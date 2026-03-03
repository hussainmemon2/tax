@extends('layouts.app')

@section('page-title', 'Roles Management')

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

    /* Table card */
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

    .search-wrap { position: relative; }
    .search-wrap i {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #9AAACB;
        font-size: .85rem;
    }
    .search-input {
        padding: 9px 16px 9px 36px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: .84rem;
        color: var(--text-main);
        background: #fff;
        outline: none;
        width: 220px;
        transition: border-color .2s, box-shadow .2s, width .25s;
    }
    .search-input::placeholder { color: #B0BEDB; }
    .search-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.1);
        width: 260px;
    }

    /* Table */
    .roles-table { width: 100%; border-collapse: collapse; }
    .roles-table thead tr {
        background: #F5F7FB;
        border-bottom: 2px solid var(--border);
    }
    .roles-table thead th {
        padding: 13px 20px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--text-sub);
        white-space: nowrap;
    }
    .roles-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .roles-table tbody tr:last-child { border-bottom: none; }
    .roles-table tbody tr:hover { background: #FAFBFD; }
    .roles-table tbody td { padding: 15px 20px; font-size: .88rem; vertical-align: middle; }

    /* Role name cell */
    .role-name-cell { display: flex; align-items: center; gap: 11px; }
    .role-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
        border: 1.5px solid rgba(201,168,76,.25);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold-lt);
        font-size: .85rem;
        flex-shrink: 0;
    }
    .role-name { font-weight: 600; color: var(--text-main); }
    .role-meta { font-size: .72rem; color: var(--text-sub); }

    /* Permission tags */
    .perm-tags { display: flex; flex-wrap: wrap; gap: 6px; }
    .perm-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 600;
        background: rgba(37,99,235,.07);
        color: #1D4ED8;
        border: 1px solid rgba(37,99,235,.15);
        white-space: nowrap;
    }
    .perm-tag-more {
        background: var(--gold-pale);
        color: #8B6914;
        border-color: rgba(201,168,76,.2);
        cursor: default;
    }
    .perm-tag-none {
        background: #F3F4F6;
        color: #9CA3AF;
        border-color: #E5E7EB;
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
    .act-btn-edit {
        background: rgba(201,168,76,.08);
        color: var(--gold);
        border-color: rgba(201,168,76,.2);
    }
    .act-btn-edit:hover { background: rgba(201,168,76,.18); color: #8B6914; transform: translateY(-1px); }
    .act-btn-delete {
        background: rgba(224,82,82,.07);
        color: #E05252;
        border-color: rgba(224,82,82,.18);
    }
    .act-btn-delete:hover { background: rgba(224,82,82,.15); transform: translateY(-1px); }

    /* Empty state */
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
    .empty-state h6 {
        font-family: 'Playfair Display', serif;
        font-size: 1rem; font-weight: 700;
        color: var(--text-main); margin-bottom: 6px;
    }
    .empty-state p { font-size: .84rem; color: var(--text-sub); margin: 0; }

    /* Footer pagination */
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
        <div class="eyebrow">Administration</div>
        <h2>Roles Management</h2>
        <p>Define roles and control permission assignments across the system</p>
    </div>
    <a href="{{ route('roles.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Add New Role
    </a>
</div>

<!-- Table Card -->
<div class="table-card">

    <div class="table-card-header">
        <div class="table-card-header-left">
            <div class="table-title-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div class="table-title">All Roles</div>
            <span class="count-pill">{{ $roles->total() }} total</span>
        </div>
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="search-input" id="roleSearch" placeholder="Search roles or permissions…" autocomplete="off">
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="roles-table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="rolesTable">
                @forelse($roles as $role)
                <tr>
                    <td style="min-width:180px;">
                        <div class="role-name-cell">
                            <div class="role-icon"><i class="bi bi-shield-check"></i></div>
                            <div>
                                <div class="role-name">{{ $role->name }}</div>
                                <div class="role-meta">{{ $role->permissions->count() }} permission{{ $role->permissions->count() !== 1 ? 's' : '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="perm-tags">
                            @forelse($role->permissions->take(5) as $perm)
                                <span class="perm-tag">
                                    <i class="bi bi-check2"></i>{{ $perm->name }}
                                </span>
                            @empty
                                <span class="perm-tag perm-tag-none">
                                    <i class="bi bi-dash-circle"></i> No Permissions
                                </span>
                            @endforelse
                            @if($role->permissions->count() > 5)
                                <span class="perm-tag perm-tag-more">
                                    +{{ $role->permissions->count() - 5 }} more
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('roles.edit', $role) }}" class="act-btn act-btn-edit" title="Edit Role">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete role {{ addslashes($role->name) }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="act-btn act-btn-delete" title="Delete Role">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-shield"></i></div>
                            <h6>No roles found</h6>
                            <p>Create your first role to start assigning permissions.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-card-footer">
        {{ $roles->links() }}
    </div>

</div>

@endsection

@section('scripts')
<script>
    const roleSearch = document.getElementById('roleSearch');
    const rolesTable = document.getElementById('rolesTable');

    roleSearch?.addEventListener('keyup', function () {
        const query = this.value.toLowerCase().trim();
        rolesTable.querySelectorAll('tr').forEach(row => {
            const name  = row.cells[0]?.innerText.toLowerCase() || '';
            const perms = row.cells[1]?.innerText.toLowerCase() || '';
            row.style.display = name.includes(query) || perms.includes(query) ? '' : 'none';
        });
    });
</script>
@endsection