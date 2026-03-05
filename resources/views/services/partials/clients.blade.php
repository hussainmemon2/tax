<style>
    /* ══ Shared table styles (loaded per partial) ══ */
    .data-table-wrap {
        overflow-x: auto;
    }
    .data-table {
        width: 100%; border-collapse: collapse;
        font-family: 'DM Sans', sans-serif; font-size: .875rem;
    }
    .data-table thead tr {
        border-bottom: 2px solid var(--border);
        background: #F8F9FC;
    }
    .data-table thead th {
        padding: 11px 16px;
        font-size: .67rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: #3D4F72;
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #FAFBFD; }
    .data-table tbody td {
        padding: 13px 16px; color: var(--text-main); vertical-align: middle;
    }

    /* name cell */
    .client-name-cell { display: flex; align-items: center; gap: 10px; }
    .client-avatar {
        width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: var(--gold-lt); font-size: .78rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(201,168,76,.2);
    }
    .client-name-text { font-weight: 600; color: var(--text-main); font-size: .875rem; }

    /* money cells */
    .money-cell { font-weight: 600; font-size: .875rem; }
    .money-cell.green { color: #059669; }
    .money-cell.red   { color: #E05252; }
    .money-cell .cur  { font-size: .72rem; font-weight: 500; color: var(--text-sub); margin-right: 2px; }

    /* action btn */
    .tbl-btn-view {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 8px; font-size: .78rem; font-weight: 600;
        border: 1.5px solid rgba(11,27,53,.15); background: #fff;
        color: var(--navy); text-decoration: none; transition: .18s; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
    }
    .tbl-btn-view:hover {
        background: var(--navy); color: #fff; border-color: var(--navy);
    }

    /* empty state */
    .table-empty {
        text-align: center; padding: 50px 20px;
        color: var(--text-sub); font-size: .85rem;
    }
    .table-empty i { font-size: 2rem; color: #C8D2E8; display: block; margin-bottom: 12px; }

    /* pagination override */
    .pagination-wrap { margin-top: 16px; }
    .pagination-wrap .pagination { margin: 0; gap: 4px; }
    .pagination-wrap .page-link {
        border-radius: 8px !important; border: 1.5px solid var(--border) !important;
        color: var(--text-main) !important; font-family: 'DM Sans', sans-serif !important;
        font-size: .82rem !important; font-weight: 600 !important; padding: 6px 12px !important;
        transition: .15s !important;
    }
    .pagination-wrap .page-link:hover { border-color: var(--navy) !important; color: var(--navy) !important; background: #fff !important; }
    .pagination-wrap .page-item.active .page-link {
        background: var(--navy) !important; border-color: var(--navy) !important; color: #fff !important;
    }
    .pagination-wrap .page-item.disabled .page-link { opacity: .4 !important; }
</style>

@if($data->isEmpty())
    <div class="table-empty">
        <i class="bi bi-people"></i>
        <p>No clients found for this service.</p>
    </div>
@else
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Total Invoiced</th>
                    <th>Total Paid</th>
                    <th>Outstanding</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $cs)
                <tr>
                    <td>
                        <div class="client-name-cell">
                            <div class="client-avatar">
                                {{ strtoupper(substr($cs->client->full_name, 0, 1)) }}
                            </div>
                            <span class="client-name-text">{{ $cs->client->full_name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="money-cell">
                            <span class="cur">PKR</span>{{ number_format($cs->invoices()->sum('total_amount'), 0) }}
                        </span>
                    </td>
                    <td>
                        <span class="money-cell green">
                            <span class="cur">PKR</span>{{ number_format($cs->payments()->sum('amount'), 0) }}
                        </span>
                    </td>
                    <td>
                        <span class="money-cell {{ $cs->outstanding > 0 ? 'red' : 'green' }}">
                            <span class="cur">PKR</span>{{ number_format($cs->outstanding, 0) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('clients.show', $cs->client->id) }}" class="tbl-btn-view">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $data->withQueryString()->links() }}
    </div>
@endif