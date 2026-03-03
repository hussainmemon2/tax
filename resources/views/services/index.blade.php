@extends('layouts.app')

@section('page-title', 'Services')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 28px;
    }
    .page-header .eyebrow {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 4px;
    }
    .page-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .page-header p { font-size: .84rem; color: var(--text-sub); margin: 3px 0 0; }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(11,27,53,.22);
        white-space: nowrap;
    }
    .btn-add:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(11,27,53,.28); color: #fff; }

    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }

    .table-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        background: linear-gradient(90deg, #F8F9FC, #fff);
    }

    .table-card-header-left { display: flex; align-items: center; gap: 12px; }

    .table-title-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: var(--gold-pale);
        border: 1px solid rgba(201,168,76,.2);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold);
        font-size: .95rem;
    }

    .table-title {
        font-family: 'Playfair Display', serif;
        font-size: .98rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .count-pill {
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
        background: rgba(201,168,76,.1);
        color: #8B6914;
        border: 1px solid rgba(201,168,76,.2);
    }

    /* Table */
    .svc-table { width: 100%; border-collapse: collapse; }
    .svc-table thead tr {
        background: #F5F7FB;
        border-bottom: 2px solid var(--border);
    }
    .svc-table thead th {
        padding: 13px 20px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--text-sub);
        white-space: nowrap;
    }
    .svc-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .svc-table tbody tr:last-child { border-bottom: none; }
    .svc-table tbody tr:hover { background: #FAFBFD; }
    .svc-table tbody td { padding: 15px 20px; font-size: .88rem; vertical-align: middle; }

    /* Service name cell */
    .svc-name-cell { display: flex; align-items: center; gap: 12px; }
    .svc-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
        border: 1.5px solid rgba(201,168,76,.25);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold-lt);
        font-size: .9rem;
        flex-shrink: 0;
    }
    .svc-name { font-weight: 600; color: var(--text-main); }
    .svc-desc { font-size: .73rem; color: var(--text-sub); margin-top: 1px; max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* Badges */
    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: .73rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-fixed    { background: rgba(16,185,129,.1);  color: #065F46; border: 1px solid rgba(16,185,129,.25); }
    .badge-stage    { background: rgba(37,99,235,.08);  color: #1D4ED8; border: 1px solid rgba(37,99,235,.18); }
    .badge-active   { background: rgba(201,168,76,.1);  color: #8B6914; border: 1px solid rgba(201,168,76,.25); }
    .badge-inactive { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }

    /* Stage count */
    .stage-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .83rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .stage-count .dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--gold);
        display: inline-block;
    }

    /* Actions */
    .action-cell { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .act-btn {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: .88rem;
        cursor: pointer;
        text-decoration: none;
        transition: .18s;
        border: 1.5px solid transparent;
        background: none;
    }
    .act-btn-edit { background: rgba(201,168,76,.08); color: var(--gold); border-color: rgba(201,168,76,.2); }
    .act-btn-edit:hover { background: rgba(201,168,76,.18); color: #8B6914; transform: translateY(-1px); }
    .act-btn-delete { background: rgba(224,82,82,.07); color: #E05252; border-color: rgba(224,82,82,.18); }
    .act-btn-delete:hover { background: rgba(224,82,82,.15); transform: translateY(-1px); }

    /* Empty */
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-icon {
        width: 64px; height: 64px;
        border-radius: 16px;
        background: var(--gold-pale);
        border: 1px solid rgba(201,168,76,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; color: var(--gold);
        margin: 0 auto 16px;
    }
    .empty-state h6 { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 6px; }
    .empty-state p  { font-size: .84rem; color: var(--text-sub); margin: 0; }

    /* Pagination */
    .table-card-footer {
        padding: 14px 24px;
        border-top: 1px solid var(--border);
        background: #FAFBFD;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    .table-card-footer .pagination { margin: 0; gap: 4px; }
    .table-card-footer .page-link {
        border-radius: 8px !important;
        border: 1.5px solid var(--border);
        color: var(--text-main);
        font-size: .82rem;
        font-weight: 600;
        padding: 6px 12px;
        font-family: 'DM Sans', sans-serif;
        transition: .15s;
    }
    .table-card-footer .page-link:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-pale); }
    .table-card-footer .page-item.active .page-link { background: var(--navy); border-color: var(--navy); color: #fff; }
    .table-card-footer .page-item.disabled .page-link { opacity: .4; }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <div class="eyebrow">Configuration</div>
        <h2>Services</h2>
        <p>Manage your firm's dynamic service catalogue and billing structures</p>
    </div>
    <a href="{{ route('services.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Add Service
    </a>
</div>

<!-- Table Card -->
<div class="table-card">

    <div class="table-card-header">
        <div class="table-card-header-left">
            <div class="table-title-icon"><i class="bi bi-gear-wide-connected"></i></div>
            <div class="table-title">All Services</div>
            <span class="count-pill">{{ $services->total() }} total</span>
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="svc-table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Clients</th>
                    <th>Status</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td style="min-width:200px;">
                        <div class="svc-name-cell">
                            <div class="svc-icon"><i class="bi bi-briefcase-fill"></i></div>
                            <div>
                                <div class="svc-name">{{ $service->name }}</div>
                                @if($service->description)
                                    <div class="svc-desc">{{ $service->description }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($service->is_active)
                            <span class="badge-pill badge-active"><i class="bi bi-check-circle-fill"></i> Active</span>
                        @else
                            <span class="badge-pill badge-inactive"><i class="bi bi-pause-circle"></i> Inactive</span>
                        @endif
                    </td>
                    <td >
                        <span class="badge-pill badge-stage">{{ $service->clientServices->pluck('client_id')->unique()->count() }} clients</span>
                    </td>
                    <td>
                        <div class="action-cell">
                         <a href="{{ route('services.show', $service->id) }}" class="act-btn act-btn-edit" title="View details">
                                <i class="bi bi-eye"></i>
                        </a>
                            <a href="{{ route('services.edit', $service->id) }}" class="act-btn act-btn-edit" title="Edit Service">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('services.delete', $service->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete service {{ addslashes($service->name) }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="act-btn act-btn-delete" title="Delete Service">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-gear"></i></div>
                            <h6>No services yet</h6>
                            <p>Create your first service to start managing client work.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-card-footer">
        {{ $services->links() }}
    </div>

</div>

@endsection