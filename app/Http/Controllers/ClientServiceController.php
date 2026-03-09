<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use App\Models\ClientService;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\DocumentUploadService;

class ClientServiceController extends Controller
{
    public function create()
    {
        $clients = Client::select('id', 'full_name', 'cnic', 'business_name')->get();
        $services = Service::active()->select('id', 'name')->get();
        return view('client_services.create', compact('clients', 'services'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',

            'documents' => 'nullable|array',
            'documents.*.file' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv,txt|max:10240',
            'documents.*.document_date' => 'nullable|date',

            'invoices' => 'nullable|array',
            // 'invoices.*.invoice_number' => 'required_with:invoices|string|distinct',
            'invoices.*.total_amount' => 'required_with:invoices|numeric|min:0',
            'invoices.*.issued_date' => 'required_with:invoices|date',
            'invoices.*.narration' => 'required_with:invoices|string',

            'payments' => 'nullable|array',
            'payments.*.amount' => 'required_with:payments|numeric|min:0',
            'payments.*.payment_method' => 'required_with:payments|in:cash,bank_transfer,card,check,online',
            'payments.*.payment_date' => 'required_with:payments|date',
        ]);
        $exists = ClientService::where('client_id', $request->client_id)
            ->where('service_id', $request->service_id)
            ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => 'This client is already assigned to this service.']);
            }
        try {

            DB::transaction(function () use ($request) {
   
                $clientService = ClientService::create([
                    'client_id' => $request->client_id,
                    'service_id' => $request->service_id,
                ]);

                $totalInvoice = 0;

                if ($request->has('invoices')) {
                    foreach ($request->invoices as $inv) {
                        $totalInvoice += $inv['total_amount'];

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

                $totalPayment = 0;

                if ($request->has('payments')) {

                    foreach ($request->payments as $pay) {
                        $totalPayment += $pay['amount'];
                    }

                    if ($totalPayment > $totalInvoice) {
                        throw new \Exception('Total payments cannot exceed total invoice amount.');
                    }

                    foreach ($request->payments as $pay) {
                     $payment =  Payment::create([
                            'client_id' => $request->client_id,
                            'client_service_id' => $clientService->id,
                            'amount' => $pay['amount'],
                            'payment_method' => $pay['payment_method'],
                            'reference_no' => $pay['reference_no'] ?? null,
                            'notes' => $pay['notes'] ?? null,
                            'recorded_by' => Auth::id(),
                            'payment_date' => $pay['payment_date'],
                        ]);

                    }
                }

                if ($request->has('documents')) {

                    $client = Client::find($request->client_id);

                    $cleanName = Str::slug($client->full_name);
                    $cleanCnic = preg_replace('/[^0-9]/', '', $client->cnic);
                    $service = Service::find($request->service_id);
                    $cleanService = Str::slug($service->name);

                    $folderPath = "documents/{$client->id}-{$cleanName}/{$cleanService}";
                    $uploader = new DocumentUploadService();
                    foreach ($request->documents as $doc) {

                        if (isset($doc['file'])) {

                            $originalName = $doc['file']->getClientOriginalName();
                            $fileName = time() . '_' . $originalName;

                           $path = $uploader->upload($doc['file'], $folderPath);

                            Document::create([
                                'client_id' => $request->client_id,
                                'client_service_id' => $clientService->id,
                                'file_name' => $doc['filename'] ?? $originalName,
                                'file_path' => $path,
                                'file_size' => $doc['file']->getSize(),
                                'mime_type' => $doc['file']->getClientMimeType(),
                                'uploaded_by' => Auth::id(),
                                'documentdate' => $doc['document_date'] ?? now(),
                            ]);
                        }
                    }
                }

            });

            return redirect()
                ->route('client_services.create')
                ->with('success', 'Service assigned successfully.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}