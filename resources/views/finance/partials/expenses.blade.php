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

    .btn-fin-expense {
        display: inline-flex; align-items: center; gap: 7px; padding: 8px 18px;
        border-radius: 9px; border: none; font-size: .82rem; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none;
        background: linear-gradient(135deg, #0D9488, #059669);
        color: #fff; box-shadow: 0 3px 12px rgba(13,148,136,.2);
        transition: transform .18s, box-shadow .18s;
    }
    .btn-fin-expense:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(13,148,136,.3); color: #fff; }

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

    .exp-title { font-weight: 600; color: var(--text-main); font-size: .875rem; }
    .money-cell { font-weight: 700; font-size: .875rem; color: #E05252; }
    .money-cell .cur { font-size: .72rem; font-weight: 500; color: #C09090; margin-right: 2px; }
    .date-cell { font-size: .83rem; color: var(--text-sub); }

    /* Category badge */
    .cat-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: .72rem; font-weight: 600; padding: 3px 10px; border-radius: 50px;
        background: rgba(201,168,76,.1); color: #8B6914;
        border: 1px solid rgba(201,168,76,.22);
    }

    .tbl-btn-eye {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 7px; font-size: .76rem; font-weight: 600;
        border: 1.5px solid rgba(201,168,76,.25); background: rgba(201,168,76,.07);
        color: #8B6914; cursor: pointer; transition: .18s; font-family: 'DM Sans', sans-serif;
    }
    .tbl-btn-eye:hover { background: var(--gold); color: var(--navy); border-color: var(--gold); }

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

    /* ── Modal ── */
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
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .9rem;
        background: var(--gold-pale); color: var(--gold); border: 1px solid rgba(201,168,76,.2);
    }
    .fin-modal .modal-title {
        font-family: 'Playfair Display', serif !important; font-size: 1rem !important;
        font-weight: 700 !important; color: var(--text-main) !important; margin: 0 !important;
    }
    .fin-modal .modal-body { padding: 24px; }
    .fin-modal .btn-close { opacity: .5; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px; }
    @media (max-width: 480px) { .detail-grid { grid-template-columns: 1fr; } }
    .detail-item label {
        display: block; font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--text-sub); margin-bottom: 5px;
    }
    .detail-val {
        font-size: .875rem; font-weight: 600; color: var(--text-main);
        background: #F8F9FC; border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px;
    }
    .detail-val.red  { color: #E05252; }
    .detail-val.gold { color: #8B6914; }
    .notes-wrap label {
        display: block; font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--text-sub); margin-bottom: 8px;
    }
    .notes-body {
        background: #F8F9FC; border: 1px solid var(--border); border-radius: 10px;
        padding: 14px 16px; font-size: .875rem; color: var(--text-main); line-height: 1.65; min-height: 56px;
    }
</style>

<div class="fin-tab-toolbar">
    <div class="fin-tab-title">
        <i class="bi bi-wallet2"></i> Expenses
    </div>
    {{-- Trigger the modal that lives in the parent page --}}
    <button type="button" class="btn-fin-expense" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
        <i class="bi bi-plus-circle"></i> Add Expense
    </button>
</div>

@if($data->isEmpty())
    <div class="table-empty">
        <i class="bi bi-wallet2"></i>
        <p>No expenses recorded yet.</p>
    </div>
@else
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $expense)
                <tr>
                    <td><span class="exp-title">{{ $expense->title }}</span></td>
                    <td>
                        <span class="money-cell">
                            <span class="cur">PKR</span>{{ number_format($expense->amount, 0) }}
                        </span>
                    </td>
                    <td><span class="date-cell">{{ $expense->expense_date }}</span></td>
                    <td>
                        @if($expense->category)
                            <span class="cat-badge"><i class="bi bi-tag"></i>{{ $expense->category }}</span>
                        @else
                            <span style="color:#B0BEDB;font-size:.83rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <button class="tbl-btn-eye" data-bs-toggle="modal" data-bs-target="#expModal{{ $expense->id }}">
                            <i class="bi bi-eye"></i> View
                        </button>
                    </td>
                </tr>

                <!-- Expense detail modal -->
                <div class="modal fade fin-modal" id="expModal{{ $expense->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="m-icon"><i class="bi bi-wallet2"></i></div>
                                <h5 class="modal-title">{{ $expense->title }}</h5>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label><i class="bi bi-cash me-1"></i>Amount</label>
                                        <div class="detail-val red">PKR {{ number_format($expense->amount, 0) }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <label><i class="bi bi-calendar3 me-1"></i>Date</label>
                                        <div class="detail-val">{{ $expense->expense_date }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <label><i class="bi bi-tag me-1"></i>Category</label>
                                        <div class="detail-val gold">{{ $expense->category ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <label><i class="bi bi-person me-1"></i>Recorded By</label>
                                        <div class="detail-val">{{ $expense->recorder->name ?? '—' }}</div>
                                    </div>
                                </div>
                                @if($expense->notes)
                                <div class="notes-wrap">
                                    <label><i class="bi bi-text-left me-1"></i>Notes</label>
                                    <div class="notes-body">{{ $expense->notes }}</div>
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