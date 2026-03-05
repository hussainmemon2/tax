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

    .pay-id-badge {
        font-weight: 700; color: #475569; font-size: .8rem;
        font-family: 'DM Mono', 'Courier New', monospace;
        background: rgba(100,116,139,.07); padding: 3px 8px; border-radius: 6px;
        border: 1px solid rgba(100,116,139,.15); display: inline-block;
    }
    .client-chip { display: inline-flex; align-items: center; gap: 6px; font-size: .83rem; font-weight: 600; color: var(--text-main); }
    .chip-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .chip-dot-green { background: #059669; }
    .money-cell { font-weight: 700; font-size: .875rem; color: #059669; }
    .money-cell .cur { font-size: .72rem; font-weight: 500; color: #6EA98A; margin-right: 2px; }
    .date-cell { font-size: .83rem; color: var(--text-sub); }

    .tbl-btn-eye {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 7px; font-size: .76rem; font-weight: 600;
        border: 1.5px solid rgba(16,185,129,.2); background: rgba(16,185,129,.06);
        color: #059669; cursor: pointer; transition: .18s; font-family: 'DM Sans', sans-serif;
    }
    .tbl-btn-eye:hover { background: #059669; color: #fff; border-color: #059669; }

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
        background: rgba(16,185,129,.08); color: #059669; border: 1px solid rgba(16,185,129,.15);
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
        background: #F5F7FC; border-right: 1px solid var(--border);
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
    .drow-val.green { color: #059669; }
    .drow-val.teal  { color: #0D9488; }
    .drow-val.sub   { font-weight: 500; color: var(--text-sub); }

    /* Method badge inside drow-val */
    .method-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 50px; font-size: .75rem; font-weight: 600;
        background: rgba(11,27,53,.06); color: var(--navy);
        border: 1px solid rgba(11,27,53,.1);
    }

    /* ── Text block (service / notes) ── */
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

<div class="fin-tab-toolbar">
    <div class="fin-tab-title">
        <i class="bi bi-cash-stack"></i> Payments
    </div>
    <a href="{{ route('finance.vouchers.create') }}" class="btn-fin-create">
        <i class="bi bi-file-earmark-plus"></i> Create Voucher
    </a>
</div>

@if($data->isEmpty())
    <div class="table-empty">
        <i class="bi bi-cash-coin"></i>
        <p>No payments found.</p>
    </div>
@else
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $payment)
                <tr>
                    <td><span class="pay-id-badge">#{{ $payment->id }}</span></td>
                    <td>
                        <span class="client-chip">
                            <span class="chip-dot chip-dot-green"></span>
                            {{ $payment->client->full_name ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <span class="money-cell">
                            <span class="cur">PKR</span>{{ number_format($payment->amount, 0) }}
                        </span>
                    </td>
                    <td><span class="date-cell">{{ $payment->payment_date }}</span></td>
                    <td>
                        <button class="tbl-btn-eye" data-bs-toggle="modal" data-bs-target="#payModal{{ $payment->id }}">
                            <i class="bi bi-eye"></i> View
                        </button>
                    </td>
                </tr>

                <!-- ── Payment detail modal ── -->
                <div class="modal fade fin-modal" id="payModal{{ $payment->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
                        <div class="modal-content">

                            <div class="modal-header">
                                <div class="m-icon"><i class="bi bi-cash-stack"></i></div>
                                <div style="flex:1; min-width:0;">
                                    <h5 class="modal-title">Payment #{{ $payment->id }}</h5>
                                    <div class="modal-subtitle">{{ $payment->client->full_name ?? '' }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                {{-- Core fields — always shown --}}
                                <div class="drow-list">
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-person"></i> Client</div>
                                        <div class="drow-val">{{ $payment->client->full_name ?? '—' }}</div>
                                    </div>
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-cash"></i> Amount</div>
                                        <div class="drow-val green">PKR {{ number_format($payment->amount, 0) }}</div>
                                    </div>
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-calendar3"></i> Date</div>
                                        <div class="drow-val">{{ $payment->payment_date }}</div>
                                    </div>

                                    @if(isset($payment->payment_method) && $payment->payment_method)
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-credit-card"></i> Method</div>
                                        <div class="drow-val">
                                            <span class="method-badge">
                                                <i class="bi bi-credit-card"></i>
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(isset($payment->reference_no) && $payment->reference_no)
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-hash"></i> Reference</div>
                                        <div class="drow-val sub">{{ $payment->reference_no }}</div>
                                    </div>
                                    @endif

                                    @if(isset($payment->receiver) && optional($payment->receiver)->name)
                                    <div class="drow">
                                        <div class="drow-lbl"><i class="bi bi-person-check"></i> Receiver</div>
                                        <div class="drow-val">{{ $payment->receiver->name }}</div>
                                    </div>
                                    @endif
                                </div>

                                {{-- Service block --}}
                                @if(isset($payment->clientService) && optional($payment->clientService->service)->name)
                                <div class="dblock">
                                    <div class="dblock-hd"><i class="bi bi-briefcase"></i> Service</div>
                                    <div class="dblock-body">{{ $payment->clientService->service->name }}</div>
                                </div>
                                @endif

                                {{-- Notes block --}}
                                @if(isset($payment->notes) && $payment->notes)
                                <div class="dblock">
                                    <div class="dblock-hd"><i class="bi bi-text-left"></i> Notes</div>
                                    <div class="dblock-body">{!! $payment->notes !!}</div>
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