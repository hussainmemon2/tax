@extends('layouts.app')

@section('page-title', isset($client) ? 'Edit Client' : 'Add Client')

@section('content')

<style>
    /* ── Page header ───────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
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
        font-size: 1.90rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
    }
    .page-header p { font-size: .84rem; color: var(--text-sub); margin: 3px 0 0; }

    .btn-secondary {
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
    .btn-secondary:hover { border-color: var(--navy); color: var(--navy); }

    /* ── Global error alert ────────────────────── */
    .error-alert {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-left: 4px solid #E05252;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 22px;
        font-size: .85rem;
        color: #991B1B;
    }
    .error-alert strong {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .88rem;
        margin-bottom: 8px;
        color: #E05252;
    }
    .error-alert ul { margin: 0 0 0 18px; padding: 0; }
    .error-alert li { margin-bottom: 3px; }

    /* ── Client type selector ──────────────────── */
    .type-selector {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }
    .type-option {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid var(--border);
        background: #fff;
        cursor: pointer;
        transition: border-color .2s, background .2s, box-shadow .2s;
        position: relative;
        overflow: hidden;
        user-select: none;
    }
    .type-option::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .2s;
    }
    .type-option:hover { border-color: rgba(201,168,76,.4); }
    .type-option input[type="radio"] { display: none; }

    .type-option.selected-individual {
        border-color: #2563EB;
        background: rgba(37,99,235,.03);
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }
    .type-option.selected-business {
        border-color: var(--gold);
        background: rgba(201,168,76,.03);
        box-shadow: 0 0 0 3px rgba(201,168,76,.1);
    }

    .type-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
        transition: background .2s, color .2s;
        position: relative; z-index: 1;
    }
    .type-icon-individual { background: rgba(37,99,235,.1); color: #2563EB; }
    .type-icon-business   { background: rgba(201,168,76,.12); color: var(--gold); }
    .selected-individual .type-icon-individual { background: #2563EB; color: #fff; }
    .selected-business   .type-icon-business   { background: var(--gold); color: var(--navy); }

    .type-body { flex: 1; position: relative; z-index: 1; }
    .type-label { font-size: .92rem; font-weight: 700; color: var(--text-main); line-height: 1.2; }
    .type-sub   { font-size: .75rem; color: var(--text-sub); margin-top: 2px; }

    .type-check {
        width: 22px; height: 22px;
        border-radius: 50%;
        border: 2px solid #D1D9EE;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: .72rem;
        color: transparent;
        transition: .2s;
        position: relative; z-index: 1;
    }
    .selected-individual .type-check { border-color: #2563EB; background: #2563EB; color: #fff; }
    .selected-business   .type-check { border-color: var(--gold); background: var(--gold); color: var(--navy); }

    @media (max-width: 576px) { .type-selector { flex-direction: column; } }

    /* ── Section cards ─────────────────────────── */
    .form-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
        margin-bottom: 20px;
    }
    .form-card.hidden { display: none; }

    .form-card-header {
        padding: 17px 26px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(90deg, #F8F9FC, #fff);
    }
    .fch-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem;
        flex-shrink: 0;
    }
    .fch-gold { background: var(--gold-pale);            border: 1px solid rgba(201,168,76,.2); color: var(--gold); }
    .fch-blue { background: rgba(37,99,235,.08);         border: 1px solid rgba(37,99,235,.15); color: #2563EB; }
    .fch-teal { background: rgba(13,148,136,.08);        border: 1px solid rgba(13,148,136,.15); color: #0D9488; }

    .fch-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: var(--text-main); margin: 0; }
    .fch-sub   { font-size: .74rem; color: var(--text-sub); margin: 2px 0 0; }

    .form-card-body { padding: 22px 26px; }

    /* ── Field grid ────────────────────────────── */
    .field-row { display: grid; gap: 16px; margin-bottom: 16px; }
    .field-row:last-child { margin-bottom: 0; }
    .field-row.cols-3 { grid-template-columns: repeat(3, 1fr); }
    .field-row.cols-2 { grid-template-columns: repeat(2, 1fr); }
    .field-row.cols-1 { grid-template-columns: 1fr; }

    @media (max-width: 900px) {
        .field-row.cols-3 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .field-row.cols-3,
        .field-row.cols-2 { grid-template-columns: 1fr; }
    }

    .field-group { display: flex; flex-direction: column; }

    .field-group label {
        font-size: .73rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #3D4F72;
        margin-bottom: 7px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .req { color: var(--gold); }
    .req.hidden { display: none; }

    .field-wrap { position: relative; }
    .f-icon {
        position: absolute;
        left: 13px; top: 50%;
        transform: translateY(-50%);
        color: #9AAACB;
        font-size: .88rem;
        pointer-events: none;
    }
    .f-icon.top { top: 13px; transform: none; }

    .pf-control {
        width: 100%;
        padding: 11px 14px 11px 38px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: var(--text-main);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        -webkit-appearance: none;
    }
    .pf-control.no-icon { padding-left: 14px; }
    .pf-control::placeholder { color: #B0BEDB; }
    .pf-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.11);
    }
    .pf-control.is-invalid { border-color: #E05252; }
    .pf-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(224,82,82,.1); }

    textarea.pf-control {
        padding: 11px 14px 11px 38px;
        min-height: 78px;
        resize: vertical;
        line-height: 1.5;
    }

    .invalid-msg {
        font-size: .74rem;
        color: #E05252;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Divider between sub-rows ──────────────── */
    .section-divider {
        height: 1px;
        background: var(--border);
        margin: 18px 0;
    }

    /* ── Form footer ───────────────────────────── */
    .form-footer-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 26px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }

    .btn-primary {
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
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(11,27,53,.28); }

    .btn-cancel-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 20px;
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
    .btn-cancel-link:hover { border-color: #E05252; color: #E05252; }

    .footer-note {
        font-size: .75rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
    }
</style>

<!-- ── Page Header ── -->
<div class="page-header">
    <div>
        <div class="eyebrow">Client Management</div>
        <h2>{{ isset($client) ? 'Edit Client' : 'Add New Client' }}</h2>
        <p>{{ isset($client) ? 'Update details for ' . $client->display_name : 'Fill in the details to register a new client' }}</p>
    </div>
    <a href="{{ route('clients.index') }}" class="btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Clients
    </a>
</div>

<form method="POST"
      action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}"
      id="clientForm">
    @csrf
    @if(isset($client))
        @method('PUT')
    @endif

    {{-- GLOBAL VALIDATION --}}
    @if ($errors->any())
        <div class="error-alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- ══════════════════════════════════════
         SECTION 1 — Basic Information
    ══════════════════════════════════════ -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="fch-icon fch-gold"><i class="bi bi-person-lines-fill"></i></div>
            <div>
                <div class="fch-title">Basic Information</div>
                <div class="fch-sub">Core identity details for this client</div>
            </div>
        </div>
        <div class="form-card-body">
            <div class="field-row cols-3">

                {{-- FULL NAME --}}
                <div class="field-group">
                    <label>Full Name <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="bi bi-person f-icon"></i>
                        <input type="text"
                               name="full_name"
                               class="pf-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name', $client->full_name ?? '') }}"
                               placeholder="e.g. Ahmad Raza">
                    </div>
                    @error('full_name')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- CNIC --}}
                <div class="field-group">
                    <label>CNIC <span class="req" id="cnicReq">*</span></label>
                    <div class="field-wrap">
                        <i class="bi bi-credit-card-2-front f-icon"></i>
                        <input type="text"
                               name="cnic"
                               class="pf-control @error('cnic') is-invalid @enderror"
                               value="{{ old('cnic', $client->cnic ?? '') }}"
                               placeholder="42101-1234567-1">
                    </div>
                    @error('cnic')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="field-group">
                    <label>Client Type <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="bi bi-briefcase f-icon"></i>

                        <select name="client_type"
                                class="pf-control @error('client_type') is-invalid @enderror">

                            <option value="">Select Type</option>

                            <option value="individual"
                                {{ old('client_type', $client->client_type ?? '') == 'individual' ? 'selected' : '' }}>
                                Individual
                            </option>

                            <option value="business"
                                {{ old('client_type', $client->client_type ?? '') == 'business' ? 'selected' : '' }}>
                                Business
                            </option>

                            <option value="government"
                                {{ old('client_type', $client->client_type ?? '') == 'government' ? 'selected' : '' }}>
                                Government
                            </option>

                            <option value="other"
                                {{ old('client_type', $client->client_type ?? '') == 'other' ? 'selected' : '' }}>
                                Other
                            </option>

                        </select>
                    </div>

                    @error('client_type')
                        <div class="invalid-msg">
                            <i class="bi bi-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- REFERENCE --}}
                <div class="field-group">
                    <label>Reference</label>
                    <div class="field-wrap">
                        <i class="bi bi-tag f-icon"></i>
                        <input type="text"
                               name="reference"
                               class="pf-control @error('reference') is-invalid @enderror"
                               value="{{ old('reference', $client->reference ?? '') }}"
                               placeholder="Referral or source">
                    </div>
                    @error('reference')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════
         SECTION 2 — Business Information
    ══════════════════════════════════════ -->
    <div class="form-card "
         id="business_fields">
        <div class="form-card-header">
            <div class="fch-icon fch-teal"><i class="bi bi-building"></i></div>
            <div>
                <div class="fch-title">Business Information</div>
                <div class="fch-sub">Company registration and tax details</div>
            </div>
        </div>
        <div class="form-card-body">

            <div class="field-row cols-2">

                {{-- BUSINESS NAME --}}
                <div class="field-group">
                    <label>Business Name <span class="req hidden" id="businessNameReq">*</span></label>
                    <div class="field-wrap">
                        <i class="bi bi-building f-icon"></i>
                        <input type="text"
                               name="business_name"
                               class="pf-control @error('business_name') is-invalid @enderror"
                               value="{{ old('business_name', $client->business_name ?? '') }}"
                               placeholder="Registered company name">
                    </div>
                    @error('business_name')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- REGISTRATION NUMBER --}}
                <div class="field-group">
                    <label>Registration Number <span class="req hidden" id="regNumberReq">*</span></label>
                    <div class="field-wrap">
                        <i class="bi bi-hash f-icon"></i>
                        <input type="text"
                               name="registration_number"
                               class="pf-control @error('registration_number') is-invalid @enderror"
                               value="{{ old('registration_number', $client->registration_number ?? '') }}"
                               placeholder="e.g. SECP-12345">
                    </div>
                    @error('registration_number')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="section-divider"></div>

            <div class="field-row cols-2">

                <div class="field-group">
                    <label>Business Registration Date</label>
                    <div class="field-wrap">
                        <i class="bi bi-calendar3 f-icon"></i>
                        <input type="date"
                               name="business_registration_date"
                               class="pf-control"
                               value="{{ old('business_registration_date', isset($client) ? $client->business_registration_date->format('Y-m-d')  : '') }}">
                    </div>
                </div>

                <div class="field-group">
                    <label>Portal Registration Date</label>
                    <div class="field-wrap">
                        <i class="bi bi-calendar-check f-icon"></i>
                        <input type="date"
                               name="portal_registration_date"
                               class="pf-control"
                               value="{{ old('portal_registration_date', isset($client) ? $client->portal_registration_date->format('Y-m-d')  : '') }}">
                    </div>
                </div>

            </div>

            <div class="section-divider"></div>

            <div class="field-row cols-2">

                {{-- SALES TAX --}}
                <div class="field-group">
                    <label>Sales Tax Number</label>
                    <div class="field-wrap">
                        <i class="bi bi-receipt f-icon"></i>
                        <input type="text"
                               name="sales_tax_number"
                               class="pf-control @error('sales_tax_number') is-invalid @enderror"
                               value="{{ old('sales_tax_number', $client->sales_tax_number ?? '') }}"
                               placeholder="e.g. 1234567-8">
                    </div>
                    @error('sales_tax_number')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- ADDRESS (full width) --}}
                <div class="field-group" style="grid-column:1/-1;">
                    <label>Business Address</label>
                    <div class="field-wrap">
                        <i class="bi bi-geo-alt f-icon top"></i>
                        <textarea name="business_address"
                                  class="pf-control"
                                  rows="2"
                                  placeholder="Full registered business address">{{ old('business_address', $client->business_address ?? '') }}</textarea>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════
         SECTION 3 — Contact Information
    ══════════════════════════════════════ -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="fch-icon fch-blue"><i class="bi bi-telephone-fill"></i></div>
            <div>
                <div class="fch-title">Contact Information</div>
                <div class="fch-sub">How to reach this client</div>
            </div>
        </div>
        <div class="form-card-body">
            <div class="field-row cols-2">

                <div class="field-group">
                    <label>Email Address</label>
                    <div class="field-wrap">
                        <i class="bi bi-envelope f-icon"></i>
                        <input type="email"
                               name="email"
                               class="pf-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $client->email ?? '') }}"
                               placeholder="client@email.com">
                    </div>
                    @error('email')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label>Phone Number</label>
                    <div class="field-wrap">
                        <i class="bi bi-telephone f-icon"></i>
                        <input type="text"
                               name="phone"
                               class="pf-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $client->phone ?? '') }}"
                               placeholder="+92 300 0000000">
                    </div>
                    @error('phone')
                        <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    <!-- ── Footer ── -->
    <div class="form-footer-card">
        <button type="submit" class="btn-primary">
            <i class="bi bi-{{ isset($client) ? 'check-circle-fill' : 'person-plus-fill' }}"></i>
            {{ isset($client) ? 'Save Changes' : 'Create Client' }}
        </button>
        <a href="{{ route('clients.index') }}" class="btn-cancel-link">
            <i class="bi bi-x"></i> Cancel
        </a>
        <span class="footer-note">
            <i class="bi bi-shield-check" style="color:var(--gold);"></i>
            All client data is stored securely
        </span>
    </div>

</form>

@endsection


@section('scripts')
<script>

</script>
@endsection