<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\FinanceExpense;
use App\Models\FinanceIncome;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
public function index()
    {
        $clients = Client::get(); // fetch your active clients
    return view('finance.index', compact('clients'));
    }

    public function ajaxData(Request $request)
    {
        $tab = $request->tab ?? 'invoices';
        $search = $request->search ?? '';

        if ($tab === 'invoices') {

            $data = Invoice::with('client')
                ->when($search, function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q2) use ($search) {
                        $q2->where('full_name', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10);

            return view('finance.partials.invoices', compact('data'))->render();
        }

        if ($tab === 'payments') {

            $data = Payment::with('client')
                ->when($search, function ($q) use ($search) {
                    $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q2) use ($search) {
                        $q2->where('full_name', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10);

            return view('finance.partials.payments', compact('data'))->render();
        }

        if ($tab === 'expenses') {

            $data = FinanceExpense::when($search, function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(10);

            return view('finance.partials.expenses', compact('data'))->render();
        }
    }
    public function getServices($clientId) {
    $services = ClientService::where('client_id', $clientId)
                 ->with('service') 
                 ->get()
                 ->map(fn($cs) => ['id' => $cs->service_id, 'name' => $cs->service->name]);
    return response()->json($services);

    }
    public function totalInvoiced(Request $request)
    {
        $clientId = $request->client_id;
        $serviceId = $request->service_id;

        $clientService = ClientService::where('client_id', $clientId)
            ->where('service_id', $serviceId)
            ->first();

        if (!$clientService) {
            return response()->json(['total_invoiced' => 0, 'total_paid' => 0]);
        }

        $clientServiceId = $clientService->id;

        $totalInvoices = Invoice::where('client_service_id', $clientServiceId)
            ->sum('total_amount');

        $totalPayments = Payment::where('client_service_id', $clientServiceId)
            ->sum('amount');

        $outstanding = $totalInvoices - $totalPayments;

        return response()->json([
            'total_invoiced' => $totalInvoices,
            'total_paid' => $totalPayments,
            'outstanding' => $outstanding
        ]);
    }
    function voucher(){
    $clients = Client::select('id', 'full_name', 'cnic')->get();
        return view('finance.voucher', compact('clients'));
    }
    function voucherStore(Request $request){
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',

            'invoices' => 'nullable|array',
            'invoices.*.total_amount' => 'required_with:invoices|numeric|min:0',
            'invoices.*.issued_date' => 'required_with:invoices|date',
            'invoices.*.narration' => 'required_with:invoices|string',

            'payments' => 'nullable|array',
            'payments.*.amount' => 'required_with:payments|numeric|min:0',
            'payments.*.payment_method' => 'required_with:payments|in:cash,bank_transfer,card,check,online',
            'payments.*.payment_date' => 'required_with:payments|date',
        ]);
        $clientService = ClientService::where('client_id', $request->client_id)
            ->where('service_id', $request->service_id)
                ->first();
            if(!$clientService){
            return back()->withInput()->withErrors(['error' => 'The selected client is not assigned to the selected service. Please assign the client to the service before creating a voucher.']);
            }
        try {
        DB::transaction(function () use ($request, $clientService) {
            $totalInvoice = 0;
            $totalPayment = 0;
            // Calculate invoice totals from request
            if (!empty($request->invoices)) {
                foreach ($request->invoices as $inv) {
                    $totalInvoice += $inv['total_amount'];
                }
            }
            // Calculate payment totals from request
            if (!empty($request->payments)) {
                foreach ($request->payments as $pay) {
                    $totalPayment += $pay['amount'];
                }
            }

            $existingInvoiceTotal = Invoice::where('client_service_id', $clientService->id)
                ->sum('total_amount');

            $existingPaymentTotal = Payment::where('client_service_id', $clientService->id)
                ->sum('amount');

            $totalInvoicesAfter = $existingInvoiceTotal + $totalInvoice;
                $totalPaymentsAfter = $existingPaymentTotal + $totalPayment;

            if ($totalPaymentsAfter > $totalInvoicesAfter) {
                throw new \Exception('Payment exceeds outstanding balance.');
            }

            if (!empty($request->invoices)) {
                foreach ($request->invoices as $inv) {
                    Invoice::create([
                        'client_id' => $request->client_id,
                        'client_service_id' => $clientService->id,
                        'invoice_number' => Invoice::generateInvoiceNumber(),
                        'narration' => $inv['narration'],
                        'total_amount' => $inv['total_amount'],
                        'issued_date' => $inv['issued_date'],
                    ]);
                }
            }

            // Create payments
            if (!empty($request->payments)) {
                foreach ($request->payments as $pay) {

                    $payment = Payment::create([
                        'client_id' => $request->client_id,
                        'client_service_id' => $clientService->id,
                        'amount' => $pay['amount'],
                        'payment_method' => $pay['payment_method'],
                        'reference_no' => $pay['reference_no'] ?? null,
                        'notes' => $pay['notes'] ?? null,
                        'recorded_by' => Auth::id(),
                        'payment_date' => $pay['payment_date'],
                    ]);

                    FinanceIncome::create([
                        'client_id' => $request->client_id,
                        'client_service_id' => $clientService->id,
                        'payment_id' => $payment->id,
                        'amount' => $pay['amount'],
                        'income_date' => $pay['payment_date'],
                        'category' => 'Service Payment',
                    ]);
                }
            }

        });
            return redirect()
            ->back()
            ->with('success', 'Voucher created successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
            }

    }
    public function storeExpense(Request $request)
    {
        $expense = FinanceExpense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'category' => $request->category,
            'recorded_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Expense created successfully'
        ]);
    }    
}
