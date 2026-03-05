<style>
    .data-table-wrap { overflow-x: auto; }
    .data-table {
        width: 100%; border-collapse: collapse;
        font-family: 'DM Sans', sans-serif; font-size: .875rem;
    }
    .data-table thead tr { border-bottom: 2px solid var(--border); background: #F8F9FC; }
    .data-table thead th {
        padding: 11px 16px; font-size: .67rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: #3D4F72; white-space: nowrap;
    }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #FAFBFD; }
    .data-table tbody td { padding: 13px 16px; color: var(--text-main); vertical-align: middle; }

    .inv-number {
        font-weight: 700; color: var(--navy); font-size: .85rem;
        font-family: 'DM Mono', 'Courier New', monospace;
        background: rgba(11,27,53,.05); padding: 3px 8px; border-radius: 6px;
        border: 1px solid rgba(11,27,53,.08); display: inline-block;
    }
    .client-chip {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: .83rem; font-weight: 600; color: var(--text-main);
    }
    .client-chip-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: var(--gold); flex-shrink: 0;
    }
    .money-cell { font-weight: 600; font-size: .875rem; }
    .money-cell .cur { font-size: .72rem; font-weight: 500; color: var(--text-sub); margin-right: 2px; }

    .date-cell { font-size: .83rem; color: var(--text-sub); }

    .tbl-btn-info {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 8px; font-size: .78rem; font-weight: 600;
        border: 1.5px solid rgba(13,148,136,.2); background: rgba(13,148,136,.06);
        color: #0D9488; cursor: pointer; transition: .18s;
        font-family: 'DM Sans', sans-serif;
    }
    .tbl-btn-info:hover { background: #0D9488; color: #fff; border-color: #0D9488; }

    .table-empty { text-align: center; padding: 50px 20px; color: var(--text-sub); font-size: .85rem; }
    .table-empty i { font-size: 2rem; color: #C8D2E8; display: block; margin-bottom: 12px; }

    .pagination-wrap { margin-top: 16px; }
    .pagination-wrap .pagination { margin: 0; gap: 4px; }
    .pagination-wrap .page-link {
        border-radius: 8px !important; border: 1.5px solid var(--border) !important;
        color: var(--text-main) !important; font-family: 'DM Sans', sans-serif !important;
        font-size: .82rem !important; font-weight: 600 !important; padding: 6px 12px !important;
        transition: .15s !important;
    }
    .pagination-wrap .page-link:hover { border-color: var(--navy) !important; color: var(--navy) !important; background: #fff !important; }
    .pagination-wrap .page-item.active .page-link { background: var(--navy) !important; border-color: var(--navy) !important; color: #fff !important; }
    .pagination-wrap .page-item.disabled .page-link { opacity: .4 !important; }

    /* ── Invoice modal ── */
    .svc-modal .modal-content {
        border: 1px solid var(--border) !important; border-radius: 16px !important;
        overflow: hidden; box-shadow: 0 20px 60px rgba(15,31,61,.18) !important;
        font-family: 'DM Sans', sans-serif;
    }
    .svc-modal .modal-header {
        padding: 18px 24px; border-bottom: 1px solid var(--border);
        background: linear-gradient(90deg, #F8F9FC, #fff);
        display: flex; align-items: center; gap: 12px;
    }
    .modal-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .9rem;
        background: rgba(13,148,136,.08); color: #0D9488; border: 1px solid rgba(13,148,136,.15);
    }
    .svc-modal .modal-title {
        font-family: 'Playfair Display', serif !important; font-size: 1rem !important;
        font-weight: 700 !important; color: var(--text-main) !important; margin: 0 !important;
    }
    .svc-modal .modal-body { padding: 24px; }
    .svc-modal .btn-close { opacity: .5; }
    .svc-modal .btn-close:hover { opacity: 1; }

    .modal-detail-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px;
    }
    @media (max-width: 480px) { .modal-detail-grid { grid-template-columns: 1fr; } }

    .modal-detail-item label {
        display: block; font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--text-sub); margin-bottom: 5px;
    }
    .modal-detail-item .detail-val {
        font-size: .88rem; font-weight: 600; color: var(--text-main);
        background: #F8F9FC; border: 1px solid var(--border);
        border-radius: 8px; padding: 8px 12px;
    }
    .detail-val.teal { color: #0D9488; }

    .narration-wrap label {
        display: block; font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--text-sub); margin-bottom: 8px;
    }
    .narration-body {
        background: #F8F9FC; border: 1px solid var(--border); border-radius: 10px;
        padding: 14px 16px; font-size: .875rem; color: var(--text-main);
        line-height: 1.65; min-height: 60px;
    }
</style>

@if($data->isEmpty())
    <div class="table-empty">
        <i class="bi bi-receipt"></i>
        <p>No invoices found for this service.</p>
    </div>
@else
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Issue Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $invoice)
                <tr>
                    <td><span class="inv-number">{{ $invoice->invoice_number }}</span></td>
                    <td>
                        <span class="client-chip">
                            <span class="client-chip-dot"></span>
                            {{ $invoice->clientService->client->display_name }}
                        </span>
                    </td>
                    <td>
                        <span class="money-cell">
                            <span class="cur">PKR</span>{{ number_format($invoice->total_amount, 0) }}
                        </span>
                    </td>
                    <td><span class="date-cell">{{ optional($invoice->issued_date)->format('Y-M-d') }}</span></td>
                    <td>
                        <button class="tbl-btn-info" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->id }}">
                            <i class="bi bi-eye"></i> View
                        </button>
                    </td>
                </tr>

                <!-- Invoice Modal -->
                <div class="modal fade svc-modal" id="invoiceModal{{ $invoice->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="modal-icon"><i class="bi bi-receipt-cutoff"></i></div>
                                <h5 class="modal-title">Invoice {{ $invoice->invoice_number }}</h5>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-detail-grid">
                                    <div class="modal-detail-item">
                                        <label><i class="bi bi-person me-1"></i>Client</label>
                                        <div class="detail-val">{{ $invoice->clientService->client->display_name }}</div>
                                    </div>
                                    <div class="modal-detail-item">
                                        <label><i class="bi bi-cash me-1"></i>Amount</label>
                                        <div class="detail-val teal">PKR {{ number_format($invoice->total_amount, 0) }}</div>
                                    </div>
                                    <div class="modal-detail-item">
                                        <label><i class="bi bi-calendar3 me-1"></i>Issue Date</label>
                                        <div class="detail-val">{{ optional($invoice->issued_date)->format('Y-M-d') }}</div>
                                    </div>
                                </div>
                                <div class="narration-wrap">
                                    <label><i class="bi bi-text-left me-1"></i>Narration</label>
                                    <div class="narration-body">{!! $invoice->narration !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $data->withQueryString()->links() }}
    </div>
@endif