@extends('layouts.app')

@section('page-title', 'Service Details')

@section('content')

<div class="page-header">
    <div>
        <div class="eyebrow">Service Details</div>
        <h2>{{ $service->name }}</h2>
        <p>{{ $service->description ?? 'No description' }}</p>
    </div>
    <a href="{{ route('services.index') }}" class="btn-add">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-4" id="serviceTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="clients-tab" data-bs-toggle="tab" data-bs-target="#clients" type="button" role="tab">Clients</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">Invoices</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">Payments</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="report-tab" data-bs-toggle="tab" data-bs-target="#report" type="button" role="tab">Reports</button>
    </li>
</ul>

<div class="tab-content" id="serviceTabContent">

    <!-- Clients Tab -->
    <div class="tab-pane fade show active" id="clients" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Total Invoiced</th>
                    <th>Total Paid</th>
                    <th>Outstanding</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($service->clientServices as $cs)
                    <tr>
                        <td>{{ $cs->client->full_name }}</td>
                        <td>PKR {{ number_format($cs->invoices->sum('amount'),0) }}</td>
                        <td>PKR {{ number_format($cs->payments->sum('amount'),0) }}</td>
                        <td>PKR {{ number_format($cs->outstanding,0) }}</td>
                        <td>
                            <a href="{{ route('clients.show', $cs->client->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Invoices Tab -->
    <div class="tab-pane fade" id="invoices" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($service->clientServices as $cs)
                    @foreach($cs->invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $cs->client->name }}</td>
                        <td>PKR {{ number_format($invoice->total_amount,0) }}</td>
                        <td>{{ $invoice->status }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->id }}">View</button>
                        </td>
                    </tr>

                    <!-- Invoice Modal -->
                    <div class="modal fade" id="invoiceModal{{ $invoice->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Invoice {{ $invoice->invoice_number }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Client:</strong> {{ $cs->client->name }}</p>
                                    <p><strong>Amount:</strong> ${{ number_format($invoice->total_amount,2) }}</p>
                                    <p><strong>Status:</strong> {{ $invoice->status }}</p>
                                    <p><strong>Details:</strong></p>
                                    {!! $invoice->details !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Payments Tab -->
    <div class="tab-pane fade" id="payments" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($service->clientServices as $cs)
                    @foreach($cs->payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $cs->client->name }}</td>
                        <td>PKR {{ number_format($payment->amount,2) }}</td>
                        <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $payment->id }}">View</button>
                        </td>
                    </tr>

                    <!-- Payment Modal -->
                    <div class="modal fade" id="paymentModal{{ $payment->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Payment #{{ $payment->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Client:</strong> {{ $cs->client->name }}</p>
                                    <p><strong>Amount:</strong> ${{ number_format($payment->amount,2) }}</p>
                                    <p><strong>Date:</strong> {{ $payment->created_at->format('Y-m-d') }}</p>
                                    <p><strong>Notes:</strong> {!! $payment->notes !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Reports Tab -->
    <div class="tab-pane fade" id="report" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Total Invoices</th>
                    <th>Total Payments</th>
                    <th>Total Outstanding</th>
                </tr>
            </thead>
            <tbody>
                @foreach($service->clientServices as $cs)
                <tr>
                    <td>{{ $cs->client->name }}</td>
                    <td>PKR {{ number_format($cs->invoices->sum('total_amount'),0) }}</td>
                    <td>PKR {{ number_format($cs->payments->sum('amount'),0) }}</td>
                    <td>PKR {{ number_format($cs->outstanding,0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection