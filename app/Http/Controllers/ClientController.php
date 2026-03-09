<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Invoice;
use App\Models\Payment;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('full_name', 'like', "%{$request->search}%")
                  ->orWhere('business_name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.form');
    }

    public function store(StoreClientRequest $request)
    {
        Client::create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.form', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }
    public function show(Client $client)
    {
        $totalInvoiced = Invoice::where('client_id', $client->id)->sum('total_amount');
        $totalPaid = Payment::where('client_id', $client->id)->sum('amount');
        $outstanding = $totalInvoiced - $totalPaid;
        $lastpaymentdate = Payment::where('client_id', $client->id)->latest('payment_date')->value('payment_date');
        $paymentPercent     = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0; 
        $outstandingPercent = $totalInvoiced > 0 ? ($outstanding / $totalInvoiced) * 100 : 0;

        return view('clients.show', compact('client', 'totalInvoiced', 'totalPaid', 'outstanding', 'lastpaymentdate', 'paymentPercent', 'outstandingPercent'));
    }
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}