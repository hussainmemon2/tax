@extends('layouts.app')

@section('page-title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')

<style>
    .form-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 28px;
    }
    .form-page-header .eyebrow {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 4px;
    }
    .form-page-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .form-page-header p { font-size: .85rem; color: var(--text-sub); margin: 4px 0 0; }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        background: #fff;
        font-size: .84rem;
        font-weight: 600;
        color: var(--text-main);
        text-decoration: none;
        transition: .2s;
        font-family: 'DM Sans', sans-serif;
        white-space: nowrap;
    }
    .back-btn:hover { border-color: var(--navy); color: var(--navy); }

    /* Form card */
    .form-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
        margin-bottom: 20px;
    }

    .form-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(90deg, #F8F9FC, #fff);
    }

    .form-card-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: var(--gold-pale);
        border: 1px solid rgba(201,168,76,.2);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold);
        font-size: 1rem;
    }

    .form-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .form-card-sub { font-size: .78rem; color: var(--text-sub); margin: 2px 0 0; }

    .form-card-body { padding: 28px; }

    /* Section label */
    .form-section-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Field */
    .field-group { margin-bottom: 24px; }
    .field-group label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--text-main);
        margin-bottom: 8px;
    }
    .field-group label .req { color: var(--gold); margin-left: 2px; }

    .field-wrap { position: relative; }
    .field-wrap .f-icon {
        position: absolute;
        left: 14px; top: 50%;
        transform: translateY(-50%);
        color: #9AAACB;
        font-size: .95rem;
        pointer-events: none;
    }
    .pf-control {
        width: 100%;
        padding: 12px 16px 12px 42px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        color: var(--text-main);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .pf-control::placeholder { color: #B0BEDB; }
    .pf-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.12);
    }
    .pf-control.is-invalid { border-color: #E05252; }
    .invalid-msg {
        font-size: .78rem; color: #E05252;
        margin-top: 5px;
        display: flex; align-items: center; gap: 5px;
    }

    /* Permissions grid */
    .permissions-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }
    .permissions-count {
        font-size: .8rem;
        color: var(--text-sub);
    }
    .permissions-count span {
        font-weight: 700;
        color: var(--gold);
    }
    .select-btns { display: flex; gap: 8px; }
    .sel-btn {
        padding: 5px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .76rem;
        font-weight: 600;
        color: var(--text-sub);
        cursor: pointer;
        transition: .18s;
    }
    .sel-btn:hover { border-color: var(--navy); color: var(--navy); }
    .sel-btn.active { background: var(--navy); color: #fff; border-color: var(--navy); }

    /* Permission checkbox card */
    .perm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }

    .perm-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        background: #FAFBFD;
        cursor: pointer;
        transition: border-color .18s, background .18s;
        user-select: none;
    }
    .perm-item:hover { border-color: rgba(201,168,76,.4); background: var(--gold-pale); }
    .perm-item.checked { border-color: var(--gold); background: rgba(201,168,76,.07); }

    .perm-checkbox {
        width: 18px; height: 18px;
        border: 2px solid #C8D2E8;
        border-radius: 5px;
        background: #fff;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: .18s;
        position: relative;
    }
    .perm-item.checked .perm-checkbox {
        background: var(--gold);
        border-color: var(--gold);
    }
    .perm-checkbox::after {
        content: '';
        width: 5px; height: 9px;
        border: 2px solid #fff;
        border-top: none; border-left: none;
        transform: rotate(45deg) scale(0);
        transition: transform .15s;
        position: absolute;
        top: 1px;
    }
    .perm-item.checked .perm-checkbox::after { transform: rotate(45deg) scale(1); }

    /* Hide real checkbox */
    .perm-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0; height: 0;
    }

    .perm-label {
        font-size: .83rem;
        font-weight: 500;
        color: var(--text-main);
        line-height: 1.3;
    }
    .perm-item.checked .perm-label { font-weight: 600; color: #7A5A10; }

    /* No permissions */
    .no-perms {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-sub);
        font-size: .88rem;
    }

    /* Footer */
    .form-card-footer {
        padding: 20px 28px;
        border-top: 1px solid var(--border);
        background: #FAFBFD;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 26px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(11,27,53,.22);
    }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(11,27,53,.28); }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        background: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 600;
        color: var(--text-sub);
        text-decoration: none;
        transition: .2s;
        cursor: pointer;
    }
    .btn-cancel:hover { border-color: #E05252; color: #E05252; }

    .form-note {
        font-size: .76rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
    }
</style>

<!-- Page Header -->
<div class="form-page-header">
    <div>
        <div class="eyebrow">Roles Management</div>
        <h2>{{ isset($role) ? 'Edit Role' : 'Create New Role' }}</h2>
        <p>{{ isset($role) ? 'Update role name and permission assignments' : 'Define a new role and assign the relevant permissions' }}</p>
    </div>
    <a href="{{ route('roles.index') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back to Roles
    </a>
</div>

<form method="POST"
      action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}"
      id="roleForm">
    @csrf
    @if(isset($role)) @method('PUT') @endif

    <!-- Role Name Card -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon"><i class="bi bi-shield-{{ isset($role) ? 'gear' : 'plus' }}"></i></div>
            <div>
                <div class="form-card-title">Role Information</div>
                <div class="form-card-sub">Fields marked <span style="color:var(--gold);">*</span> are required</div>
            </div>
        </div>
        <div class="form-card-body">
            <div class="form-section-label"><i class="bi bi-info-circle"></i> Basic Details</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="field-group">
                        <label>Role Name <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="bi bi-tag f-icon"></i>
                            <input type="text"
                                   name="name"
                                   class="pf-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $role->name ?? '') }}"
                                   placeholder="e.g. Senior Accountant"
                                   required>
                        </div>
                        @error('name')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Card -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon"><i class="bi bi-key-fill"></i></div>
            <div>
                <div class="form-card-title">Permission Assignment</div>
                <div class="form-card-sub">Select which permissions this role should have access to</div>
            </div>
        </div>
        <div class="form-card-body">
            <div class="form-section-label"><i class="bi bi-check2-square"></i> Available Permissions</div>

            <div class="permissions-toolbar">
                <div class="permissions-count">
                    <span id="checkedCount">{{ isset($rolePermissions) ? count($rolePermissions) : 0 }}</span> of {{ $permissions->count() }} selected
                </div>
                <div class="select-btns">
                    <button type="button" class="sel-btn" id="selectAll">Select All</button>
                    <button type="button" class="sel-btn" id="clearAll">Clear All</button>
                </div>
            </div>

            @if($permissions->count() > 0)
                <div class="perm-grid" id="permGrid">
                    @foreach($permissions as $permission)
                        @php
                            $isChecked = isset($rolePermissions) && in_array($permission->id, $rolePermissions);
                        @endphp
                        <label class="perm-item {{ $isChecked ? 'checked' : '' }}">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->id }}"
                                   {{ $isChecked ? 'checked' : '' }}>
                            <div class="perm-checkbox"></div>
                            <span class="perm-label">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            @else
                <div class="no-perms">
                    <i class="bi bi-key" style="font-size:2rem;color:var(--gold);display:block;margin-bottom:10px;"></i>
                    No permissions have been defined yet.
                </div>
            @endif
        </div>

        <div class="form-card-footer">
            <button type="submit" form="roleForm" class="btn-save">
                <i class="bi bi-{{ isset($role) ? 'check-circle-fill' : 'shield-plus' }}"></i>
                {{ isset($role) ? 'Save Changes' : 'Create Role' }}
            </button>

            <a href="{{ route('roles.index') }}" class="btn-cancel">
                <i class="bi bi-x"></i> Cancel
            </a>

            <span class="form-note">
                <i class="bi bi-shield-check" style="color:var(--gold);"></i>
                Permission changes apply immediately
            </span>
        </div>
    </div>

</form>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const permItems = document.querySelectorAll('.perm-item');
    const countEl   = document.getElementById('checkedCount');

    function updateCount() {
        const n = document.querySelectorAll('.perm-item input[type="checkbox"]:checked').length;
        if (countEl) countEl.textContent = n;
    }

    permItems.forEach(item => {
        const cb = item.querySelector('input[type="checkbox"]');

        // When checkbox changes, update UI
        cb.addEventListener('change', function () {
            item.classList.toggle('checked', cb.checked);
            updateCount();
        });
    });

    document.getElementById('selectAll')?.addEventListener('click', function () {
        permItems.forEach(item => {
            const cb = item.querySelector('input');
            cb.checked = true;
            item.classList.add('checked');
        });
        updateCount();
    });

    document.getElementById('clearAll')?.addEventListener('click', function () {
        permItems.forEach(item => {
            const cb = item.querySelector('input');
            cb.checked = false;
            item.classList.remove('checked');
        });
        updateCount();
    });

});
</script>
@endsection