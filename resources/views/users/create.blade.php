@extends('layouts.app')

@section('page-title', isset($user) ? 'Edit User' : 'Add New User')

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
    .form-page-header p {
        font-size: .85rem;
        color: var(--text-sub);
        margin: 4px 0 0;
    }

    /* Back btn */
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
    }
    .back-btn:hover { border-color: var(--navy); color: var(--navy); }

    /* Form card */
    .form-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
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
    .form-card-sub {
        font-size: .78rem;
        color: var(--text-sub);
        margin: 1px 0 0;
    }

    .form-card-body { padding: 28px; }

    /* Field styling */
    .field-group { margin-bottom: 22px; }

    .field-group label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .field-group label .req {
        color: var(--gold);
        margin-left: 2px;
    }

    .field-group label .hint {
        font-size: .72rem;
        font-weight: 400;
        letter-spacing: 0;
        text-transform: none;
        color: var(--text-sub);
        margin-left: 6px;
    }

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
        -webkit-appearance: none;
    }
    .pf-control::placeholder { color: #B0BEDB; }
    .pf-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.12);
    }
    .pf-control.is-invalid { border-color: #E05252; }
    .pf-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(224,82,82,.12); }

    .invalid-msg {
        font-size: .78rem;
        color: #E05252;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Password toggle */
    .pw-toggle {
        position: absolute;
        right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        cursor: pointer;
        color: #9AAACB;
        font-size: .95rem;
        transition: color .2s;
        padding: 4px;
    }
    .pw-toggle:hover { color: var(--navy); }

    /* Select */
    .pf-select {
        padding-right: 36px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239AAACB' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        cursor: pointer;
    }

    /* Section divider */
    .form-section-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        padding: 0 0 10px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Form footer */
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
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(11,27,53,.28);
    }

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
        <div class="eyebrow">User Management</div>
        <h2>{{ isset($user) ? 'Edit User' : 'Add New User' }}</h2>
        <p>{{ isset($user) ? 'Update account information and role assignment' : 'Create a new system user and assign a role' }}</p>
    </div>
    <a href="{{ route('users.index') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back to Users
    </a>
</div>

<!-- Form Card -->
<div class="form-card">

    <div class="form-card-header">
        <div class="form-card-icon">
            <i class="bi bi-person-{{ isset($user) ? 'gear' : 'plus-fill' }}"></i>
        </div>
        <div>
            <div class="form-card-title">{{ isset($user) ? 'Edit Account: ' . $user->name : 'New User Details' }}</div>
            <div class="form-card-sub">All fields marked with <span style="color:var(--gold);">*</span> are required</div>
        </div>
    </div>

    <div class="form-card-body">

        <form method="POST"
              action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}"
              id="userForm">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <!-- Section: Basic Info -->
            <div class="form-section-label">
                <i class="bi bi-info-circle"></i> Basic Information
            </div>

            <div class="row g-3 mb-2">

                <!-- Name -->
                <div class="col-md-6">
                    <div class="field-group">
                        <label>Full Name <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="bi bi-person f-icon"></i>
                            <input type="text"
                                   name="name"
                                   class="pf-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name ?? '') }}"
                                   placeholder="e.g. Ahmed Khan"
                                   required>
                        </div>
                        @error('name')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="field-group">
                        <label>Email Address <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="bi bi-envelope f-icon"></i>
                            <input type="email"
                                   name="email"
                                   class="pf-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email ?? '') }}"
                                   placeholder="e.g. ahmed@firm.com"
                                   required>
                        </div>
                        @error('email')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- Section: Security -->
            <div class="form-section-label" style="margin-top:8px;">
                <i class="bi bi-shield-lock"></i> Security
            </div>

            <div class="row g-3 mb-2">

                <!-- Password -->
                <div class="col-md-6">
                    <div class="field-group">
                        <label>
                            Password <span class="req">*</span>
                            @if(isset($user)) <span class="hint">(leave blank to keep current)</span> @endif
                        </label>
                        <div class="field-wrap">
                            <i class="bi bi-lock f-icon"></i>
                            <input type="password"
                                   name="password"
                                   id="passwordField"
                                   class="pf-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   {{ isset($user) ? '' : 'required' }}>
                            <button type="button" class="pw-toggle" onclick="toggleField('passwordField', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <div class="field-group">
                        <label>
                            Confirm Password
                            @if(!isset($user)) <span class="req">*</span> @endif
                        </label>
                        <div class="field-wrap">
                            <i class="bi bi-lock-fill f-icon"></i>
                            <input type="password"
                                   name="password_confirmation"
                                   id="passwordConfirmField"
                                   class="pf-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="••••••••"
                                   {{ isset($user) ? '' : 'required' }}>
                            <button type="button" class="pw-toggle" onclick="toggleField('passwordConfirmField', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- Section: Role -->
            <div class="form-section-label" style="margin-top:8px;">
                <i class="bi bi-shield-check"></i> Role & Permissions
            </div>

            <div class="row g-3">

                <!-- Role -->
                <div class="col-md-6">
                    <div class="field-group">
                        <label>Assign Role <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="bi bi-person-badge f-icon"></i>
                            <select name="role_id"
                                    class="pf-control pf-select @error('role_id') is-invalid @enderror"
                                    required>
                                <option value="">— Select a role —</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role_id')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

        </form>

    </div>

    <!-- Footer Actions -->
    <div class="form-card-footer">
        <button type="submit" form="userForm" class="btn-save">
            <i class="bi bi-{{ isset($user) ? 'check-circle-fill' : 'person-plus-fill' }}"></i>
            {{ isset($user) ? 'Save Changes' : 'Create User' }}
        </button>

        <a href="{{ route('users.index') }}" class="btn-cancel">
            <i class="bi bi-x"></i> Cancel
        </a>

        <span class="form-note">
            <i class="bi bi-shield-check" style="color:var(--gold);"></i>
            Changes are logged for audit trail
        </span>
    </div>

</div>

@endsection

@section('scripts')
<script>
    function toggleField(id, btn) {
        const f = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (f.type === 'password') {
            f.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            f.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endsection