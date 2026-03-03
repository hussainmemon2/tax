@extends('layouts.app')

@section('page-title', 'Users Management')

@section('content')

<style>
    /* Page header */
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

    .btn-add-user {
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
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(11,27,53,.22);
        white-space: nowrap;
    }
    .btn-add-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(11,27,53,.28);
        color: #fff;
    }

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

    .table-card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

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

    .users-count {
        font-size: .75rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
        background: rgba(37,99,235,.08);
        color: #2563EB;
        border: 1px solid rgba(37,99,235,.15);
    }

    /* Search */
    .search-wrap {
        position: relative;
    }
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
        transition: border-color .2s, box-shadow .2s;
    }
    .search-input::placeholder { color: #B0BEDB; }
    .search-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.1);
        width: 260px;
    }

    /* Table */
    .users-table { width: 100%; border-collapse: collapse; }

    .users-table thead tr {
        background: #F5F7FB;
        border-bottom: 2px solid var(--border);
    }

    .users-table thead th {
        padding: 13px 20px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--text-sub);
        white-space: nowrap;
    }

    .users-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .users-table tbody tr:last-child { border-bottom: none; }
    .users-table tbody tr:hover { background: #FAFBFD; }

    .users-table tbody td {
        padding: 15px 20px;
        font-size: .88rem;
        vertical-align: middle;
    }

    /* User cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar {
        width: 36px; height: 36px;
        border-radius: 9px;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy-light));
        border: 1.5px solid rgba(201,168,76,.3);
        display: flex; align-items: center; justify-content: center;
        font-size: .82rem;
        font-weight: 700;
        color: var(--gold-lt);
        flex-shrink: 0;
    }
    .user-name {
        font-weight: 600;
        color: var(--text-main);
        line-height: 1.2;
    }
    .user-id { font-size: .72rem; color: var(--text-sub); }

    .email-cell { color: var(--text-sub); font-size: .86rem; }

    /* Role badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: .75rem;
        font-weight: 600;
        background: rgba(201,168,76,.1);
        color: #8B6914;
        border: 1px solid rgba(201,168,76,.25);
    }
    .role-badge.empty {
        background: #F3F4F6;
        color: #9CA3AF;
        border-color: #E5E7EB;
    }

    /* Action buttons */
    .action-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .act-btn {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: .88rem;
        cursor: pointer;
        text-decoration: none;
        transition: .18s;
        border: 1.5px solid transparent;
    }
    .act-btn-edit {
        background: rgba(201,168,76,.08);
        color: var(--gold);
        border-color: rgba(201,168,76,.2);
    }
    .act-btn-edit:hover {
        background: rgba(201,168,76,.18);
        color: #8B6914;
        transform: translateY(-1px);
    }
    .act-btn-delete {
        background: rgba(224,82,82,.07);
        color: #E05252;
        border-color: rgba(224,82,82,.18);
    }
    .act-btn-delete:hover {
        background: rgba(224,82,82,.15);
        transform: translateY(-1px);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-icon {
        width: 64px; height: 64px;
        border-radius: 16px;
        background: var(--gold-pale);
        border: 1px solid rgba(201,168,76,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        color: var(--gold);
        margin: 0 auto 16px;
    }
    .empty-state h6 {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 6px;
    }
    .empty-state p { font-size: .84rem; color: var(--text-sub); margin: 0; }

    /* Pagination */
    .table-card-footer {
        padding: 14px 24px;
        border-top: 1px solid var(--border);
        background: #FAFBFD;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    /* Override Laravel pagination */
    .table-card-footer .pagination {
        margin: 0;
        gap: 4px;
    }
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
    .table-card-footer .page-link:hover {
        border-color: var(--gold);
        color: var(--gold);
        background: var(--gold-pale);
    }
    .table-card-footer .page-item.active .page-link {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }
    .table-card-footer .page-item.disabled .page-link {
        opacity: .4;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <div class="eyebrow">Administration</div>
        <h2>Users Management</h2>
        <p>Manage system users, accounts, and role assignments</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn-add-user">
        <i class="bi bi-person-plus-fill"></i> Add New User
    </a>
</div>

<!-- Table Card -->
<div class="table-card">

    <div class="table-card-header">
        <div class="table-card-header-left">
            <div class="table-title-icon"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="table-title">All Users</div>
            </div>
            <span class="users-count">{{ $users->total() }} total</span>
        </div>

        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text"
                   class="search-input"
                   id="userSearch"
                   placeholder="Search name or email…"
                   autocomplete="off">
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTable">
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-id">#{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="email-cell">{{ $user->email }}</td>
                    <td>
                        @if($user->role)
                            <span class="role-badge">
                                <i class="bi bi-shield-check"></i>
                                {{ $user->role->name }}
                            </span>
                        @else
                            <span class="role-badge empty">
                                <i class="bi bi-dash-circle"></i>
                                No Role
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('users.edit', $user) }}"
                               class="act-btn act-btn-edit"
                               title="Edit User">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete user {{ addslashes($user->name) }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="act-btn act-btn-delete"
                                        title="Delete User">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-people"></i></div>
                            <h6>No users found</h6>
                            <p>Get started by adding your first user to the system.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-card-footer">
        {{ $users->links() }}
    </div>

</div>

@endsection

@section('scripts')
<script>
    const userSearch = document.getElementById('userSearch');
    const usersTable = document.getElementById('usersTable');

    userSearch?.addEventListener('keyup', function () {
        const query = this.value.toLowerCase().trim();
        usersTable.querySelectorAll('tr').forEach(row => {
            const name  = row.cells[0]?.innerText.toLowerCase() || '';
            const email = row.cells[1]?.innerText.toLowerCase() || '';
            row.style.display = name.includes(query) || email.includes(query) ? '' : 'none';
        });
    });
</script>
@endsection