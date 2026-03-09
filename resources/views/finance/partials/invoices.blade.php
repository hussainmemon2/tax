<style>
    .fin-tab-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px; margin-bottom: 18px;
    }
    .fin-tab-title {
        font-family: 'Playfair Display', serif; font-size: .95rem;
        font-weight: 700; color: var(--text-main);
        display: flex; align-items: center; gap: 8px;
    }
    .fin-tab-title i { color: var(--gold); font-size: .9rem; }

    .btn-fin-create {
        display: inline-flex; align-items: center; gap: 7px; padding: 8px 18px;
        border-radius: 9px; border: none; font-size: .82rem; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff; box-shadow: 0 3px 12px rgba(11,27,53,.18);
        transition: transform .18s, box-shadow .18s; position: relative; overflow: hidden;
    }
    .btn-fin-create::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(201,168,76,.15) 0%, transparent 60%); }
    .btn-fin-create:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(11,27,53,.25); color: #fff; }

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
        font-weight: 700; color: var(--navy); font-size: .82rem;
        font-family: 'DM Mono', 'Courier New', monospace;
        background: rgba(11,27,53,.05); padding: 3px 8px; border-radius: 6px;
        border: 1px solid rgba(11,27,53,.08); display: inline-block;
    }
    .client-chip { display: inline-flex; align-items: center; gap: 6px; font-size: .83rem; font-weight: 600; color: var(--text-main); }
    .chip-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .chip-dot-gold { background: var(--gold); }
    .money-cell { font-weight: 600; font-size: .875rem; }
    .money-cell .cur { font-size: .72rem; font-weight: 500; color: var(--text-sub); margin-right: 2px; }
    .date-cell { font-size: .83rem; color: var(--text-sub); }

    .tbl-btn-eye {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 7px; font-size: .76rem; font-weight: 600;
        border: 1.5px solid rgba(13,148,136,.2); background: rgba(13,148,136,.06);
        color: #0D9488; cursor: pointer; transition: .18s; font-family: 'DM Sans', sans-serif;
    }
    .tbl-btn-eye:hover { background: #0D9488; color: #fff; border-color: #0D9488; }

    .table-empty { text-align: center; padding: 50px 20px; color: var(--text-sub); font-size: .85rem; }
    .table-empty i { font-size: 2rem; color: #C8D2E8; display: block; margin-bottom: 12px; }

    .pagination-wrap { margin-top: 16px; }
    .pagination-wrap .pagination { margin: 0; gap: 4px; }
    .pagination-wrap .page-link {
        border-radius: 8px !important; border: 1.5px solid var(--border) !important;
        color: var(--text-main) !important; font-family: 'DM Sans', sans-serif !important;
        font-size: .82rem !important; font-weight: 600 !important; padding: 6px 12px !important; transition: .15s !important;
    }
    .pagination-wrap .page-link:hover { border-color: var(--navy) !important; color: var(--navy) !important; background: #fff !important; }
    .pagination-wrap .page-item.active .page-link { background: var(--navy) !important; border-color: var(--navy) !important; color: #fff !important; }
    .pagination-wrap .page-item.disabled .page-link { opacity: .4 !important; }

    /* ══ Modal ══ */
    .fin-modal .modal-content {
        border: 1px solid var(--border) !important; border-radius: 16px !important;
        overflow: hidden; box-shadow: 0 20px 60px rgba(15,31,61,.18) !important;
        font-family: 'DM Sans', sans-serif;
    }
    .fin-modal .modal-header {
        padding: 18px 24px; border-bottom: 1px solid var(--border);
        background: linear-gradient(90deg, #F8F9FC, #fff);
        display: flex; align-items: center; gap: 12px;
    }
    .fin-modal .m-icon {
        width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .95rem;
        background: rgba(13,148,136,.08); color: #0D9488; border: 1px solid rgba(13,148,136,.15);
    }
    .fin-modal .modal-title {
        font-family: 'Playfair Display', serif !important; font-size: 1rem !important;
        font-weight: 700 !important; color: var(--text-main) !important; margin: 0 !important; line-height: 1.25 !important;
    }
    .fin-modal .modal-subtitle { font-size: .73rem; color: var(--text-sub); margin-top: 2px; }
    .fin-modal .modal-body { padding: 20px 24px 24px; }
    .fin-modal .btn-close { opacity: .45; margin-left: auto; flex-shrink: 0; }
    .fin-modal .btn-close:hover { opacity: 1; }

    /* ── Detail row list ── */
    .drow-list {
        border: 1px solid var(--border); border-radius: 11px;
        overflow: hidden; margin-bottom: 14px;
    }
    .drow-list:last-child { margin-bottom: 0; }

    .drow {
        display: flex; align-items: stretch; border-bottom: 1px solid var(--border);
    }
    .drow:last-child { border-bottom: none; }

    .drow-lbl {
        width: 38%; min-width: 110px; padding: 10px 14px;
        background: #F5F7FC;
        border-right: 1px solid var(--border);
        font-size: .68rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: #5C6D8A;
        display: flex; align-items: center; gap: 7px;
        flex-shrink: 0; line-height: 1.3;
    }
    .drow-lbl i { color: var(--gold); font-size: .78rem; flex-shrink: 0; }

    .drow-val {
        flex: 1; padding: 10px 14px;
        font-size: .875rem; font-weight: 600; color: var(--text-main);
        background: #fff; display: flex; align-items: center;
        word-break: break-word; line-height: 1.4;
    }
    .drow-val.teal  { color: #0D9488; }
    .drow-val.green { color: #059669; }
    .drow-val.red   { color: #E05252; }
    .drow-val.sub   { font-weight: 500; color: var(--text-sub); }

    /* ── Text block (narration / notes / service) ── */
    .dblock {
        border: 1px solid var(--border); border-radius: 11px;
        overflow: hidden; margin-bottom: 14px;
    }
    .dblock:last-child { margin-bottom: 0; }
    .dblock-hd {
        padding: 8px 14px; background: #F5F7FC;
        border-bottom: 1px solid var(--border);
        font-size: .68rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: #5C6D8A;
        display: flex; align-items: center; gap: 7px;
    }
    .dblock-hd i { color: var(--gold); font-size: .78rem; }
    .dblock-body {
        padding: 12px 14px; font-size: .875rem; font-weight: 500;
        color: var(--text-main); line-height: 1.7; background: #fff; min-height: 44px;
    }
</style>

<!-- Toolbar -->
<div class="fin-tab-toolbar">
    <div class="fin-tab-title">
        <i class="bi bi-receipt-cutoff"></i> Invoices
    </div>
    <a href="{{ route('finance.vouchers.create') }}" class="btn-fin-create">
        <i class="bi bi-file-earmark-plus"></i> Create Voucher
    </a>
</div>

@if($data->isEmpty())
    <div class="table-empty">
        <i class="bi bi-receipt"></i>
        <p>No invoices found.</p>
    </div>
@else
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Issued Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $invoice)
                <tr>
                    <td><span class="inv-number">{{ $invoice->invoice_number }}</span></td>
                    <td>
                        <span class="client-chip">
                            <span class="chip-dot chip-dot-gold"></span>
                            {{ $invoice->client->full_name ?? '—' }}
                        </span>
                        <br>
                        <b>CNIC:</b> {{ $invoice->client->cnic ?? '—' }}
                        </td>
                    <td>
                        <span class="money-cell">
                            <span class="cur">PKR</span>{{ number_format($invoice->total_amount, 0) }}
                        </span>
                    </td>
                    <td><span class="date-cell">{{ optional($invoice->issued_date)->format('Y-m-d') ?? '—' }}</span></td>
                    <td>
                        <button class="tbl-btn-eye" data-bs-toggle="modal" data-bs-target="#invModal{{ $invoice->id }}">
                            <i class="bi bi-eye"></i> View
                        </button>
                    </td>
                </tr>

                <!-- ── Invoice detail modal ── -->
                <div class="modal fade fin-modal" id="invModal{{ $invoice->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
                        <div class="modal-content">

                            <div class="modal-header">
                                <div class="m-icon"><i class="bi bi-receipt-cutoff"></i></div>
                                <div style="flex:1; min-width:0;">
                                    <h5 class="modal-title">Invoice {{ $invoice->invoice_number }}</h5>
                                    <div class="modal-subtitle">{{ $invoice->client->full_name ?? '' }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                {{-- Core fields --}}
                                <div class="drow-list">
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-hash"></i> Invoice #</div>
                                        <div class="drow-val">{{ $invoice->invoice_number }}</div>
                                    </div>
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-person"></i> Client</div>
                                        <div class="drow-val">{{ $invoice->client->full_name ?? '—' }} - CNIC# {{ $invoice->client->cnic }}</div>
                                    </div>
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-cash"></i> Amount</div>
                                        <div class="drow-val teal">PKR {{ number_format($invoice->total_amount, 0) }}</div>
                                    </div>
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-calendar3"></i> Issued Date</div>
                                        <div class="drow-val">{{ optional($invoice->issued_date)->format('d M Y') ?? '—' }}</div>
                                    </div>
                                    @if(isset($invoice->clientService) && optional($invoice->clientService->service)->name)
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-briefcase"></i> Service</div>
                                        <div class="drow-val">{{ $invoice->clientService->service->name }}</div>
                                    </div>
                                    @endif
                                </div>

                                {{-- Narration block --}}
                                @if($invoice->narration)
                                <div class="dblock">
                                    <div class="dblock-hd"><i class="bi bi-text-left"></i> Narration</div>
                                    <div class="dblock-body">{!! $invoice->narration !!}</div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>
@endif