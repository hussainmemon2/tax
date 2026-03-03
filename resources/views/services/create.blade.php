@extends('layouts.app')

@section('page-title', 'Create Service')

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

    /* Cards */
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

    /* Error alert */
    .error-alert {
        background: rgba(224,82,82,.07);
        border: 1px solid rgba(224,82,82,.2);
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 24px;
        color: #C0392B;
        font-size: .86rem;
    }
    .error-alert strong { display: flex; align-items: center; gap: 7px; margin-bottom: 8px; color: #E05252; }
    .error-alert ul { margin: 0; padding-left: 18px; }
    .error-alert li { margin-bottom: 3px; }

    /* Fields */
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
    .field-group label .req { color: var(--gold); margin-left: 2px; }

    .field-wrap { position: relative; }
    .field-wrap .f-icon {
        position: absolute;
        left: 14px; top: 50%;
        transform: translateY(-50%);
        color: #9AAACB;
        font-size: .95rem;
        pointer-events: none;
        z-index: 1;
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
    .pf-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.12); }
    .pf-control.is-invalid { border-color: #E05252; }

    .pf-textarea {
        padding: 12px 16px;
        resize: vertical;
        min-height: 90px;
    }

    .pf-select {
        padding-right: 36px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239AAACB' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        cursor: pointer;
    }

    .invalid-msg {
        font-size: .78rem; color: #E05252;
        margin-top: 5px;
        display: flex; align-items: center; gap: 5px;
    }

    /* Toggle switches */
    .toggle-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 8px;
    }

    .toggle-card {
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 18px;
        border-radius: 11px;
        border: 1.5px solid var(--border);
        background: #FAFBFD;
        cursor: pointer;
        transition: border-color .18s, background .18s;
    }
    .toggle-card:hover { border-color: rgba(201,168,76,.35); }
    .toggle-card.on { border-color: var(--gold); background: rgba(201,168,76,.06); }

    .toggle-card-label { font-size: .87rem; font-weight: 600; color: var(--text-main); }
    .toggle-card-sub   { font-size: .74rem; color: var(--text-sub); margin-top: 2px; }

    /* Custom toggle switch */
    .toggle-switch {
        width: 44px; height: 24px;
        background: #D1D5DB;
        border-radius: 12px;
        position: relative;
        flex-shrink: 0;
        transition: background .2s;
    }
    .toggle-switch::after {
        content: '';
        width: 18px; height: 18px;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        top: 3px; left: 3px;
        transition: transform .2s;
        box-shadow: 0 1px 4px rgba(0,0,0,.15);
    }
    .toggle-card.on .toggle-switch { background: var(--gold); }
    .toggle-card.on .toggle-switch::after { transform: translateX(20px); }

    /* Real checkboxes hidden */
    .toggle-card input[type="checkbox"] { display: none; }

    /* Stage section */
    .stage-section-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
        margin-bottom: 20px;
    }

    .stage-section-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(90deg, #F8F9FC, #fff);
    }

    .stage-header-left { display: flex; align-items: center; gap: 12px; }

    .stage-header-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        background: rgba(37,99,235,.08);
        border: 1px solid rgba(37,99,235,.15);
        display: flex; align-items: center; justify-content: center;
        color: #2563EB;
        font-size: .88rem;
    }

    .stage-title {
        font-family: 'Playfair Display', serif;
        font-size: .95rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .btn-add-stage {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 9px;
        border: 1.5px solid rgba(37,99,235,.25);
        background: rgba(37,99,235,.06);
        color: #2563EB;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        transition: .18s;
    }
    .btn-add-stage:hover { background: rgba(37,99,235,.12); }

    .stages-body { padding: 20px 24px; }

    .stage-item {
        background: #FAFBFD;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 12px;
        position: relative;
        transition: border-color .18s;
        animation: stageIn .25s ease both;
    }
    .stage-item:hover { border-color: rgba(201,168,76,.3); }

    @keyframes stageIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .stage-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .stage-number {
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .stage-num-badge {
        width: 28px; height: 28px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: var(--gold-lt);
        font-size: .78rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
    }
    .stage-num-label {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text-main);
    }

    .btn-remove-stage {
        width: 30px; height: 30px;
        border-radius: 8px;
        border: 1.5px solid rgba(224,82,82,.2);
        background: rgba(224,82,82,.06);
        color: #E05252;
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem;
        cursor: pointer;
        transition: .15s;
    }
    .btn-remove-stage:hover { background: rgba(224,82,82,.15); }

    .stage-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media(max-width:576px) { .stage-fields { grid-template-columns: 1fr; } }

    .stage-field input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: .87rem;
        color: var(--text-main);
        background: #fff;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
    }
    .stage-field input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); }
    .stage-field input.is-invalid { border-color: #E05252; }

    .stages-empty {
        text-align: center;
        padding: 36px 20px;
        color: var(--text-sub);
        font-size: .86rem;
        border: 2px dashed var(--border);
        border-radius: 12px;
    }
    .stages-empty i { font-size: 1.8rem; color: #C8D2E8; display: block; margin-bottom: 10px; }

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
    }
    .btn-cancel:hover { border-color: #E05252; color: #E05252; }
</style>

<!-- Page Header -->
<div class="form-page-header">
    <div>
        <div class="eyebrow">Services</div>
        <h2>Create New Service</h2>
        <p>Define the service structure, billing type, and workflow stages</p>
    </div>
    <a href="{{ route('services.index') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back to Services
    </a>
</div>

<form action="{{ route('services.store') }}" method="POST" id="serviceForm">
@csrf

    <!-- Global Errors -->
    @if($errors->any())
        <div class="error-alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Service Details Card -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon"><i class="bi bi-briefcase-fill"></i></div>
            <div>
                <div class="form-card-title">Service Details</div>
                <div class="form-card-sub">Basic information and billing configuration</div>
            </div>
        </div>
        <div class="form-card-body">

            <div class="form-section-label"><i class="bi bi-info-circle"></i> Basic Information</div>

            <div class="row g-3 mb-2">
                <div class="col-md-12">
                    <div class="field-group">
                        <label>Service Name <span class="req">*</span></label>
                        <div class="field-wrap">
                            <i class="bi bi-briefcase f-icon"></i>
                            <input type="text"
                                   name="name"
                                   class="pf-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Annual Tax Return"
                                   required>
                        </div>
                        @error('name')
                            <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>


            </div>

            <div class="field-group">
                <label>Description</label>
                <textarea name="description"
                          rows="3"
                          class="pf-control pf-textarea @error('description') is-invalid @enderror"
                          placeholder="Brief description of this service…">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section-label" style="margin-top:8px;"><i class="bi bi-toggles"></i> Settings</div>

            <div class="toggle-row">
                <label class="toggle-card {{ old('is_active', true) ? 'on' : '' }}" id="activeCard">
                    <input type="checkbox"
                           name="is_active"
                           id="isActive"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <div>
                        <div class="toggle-card-label">Active Status</div>
                        <div class="toggle-card-sub">Make this service available for assignment</div>
                    </div>
                    <div class="toggle-switch"></div>
                </label>

            </div>

        </div>
    </div>
    <!-- Footer -->
    <div class="form-card" style="margin-bottom:0;">
        <div class="form-card-footer">
            <button type="submit" form="serviceForm" class="btn-save">
                <i class="bi bi-check-circle-fill"></i> Save Service
            </button>
            <a href="{{ route('services.index') }}" class="btn-cancel">
                <i class="bi bi-x"></i> Cancel
            </a>
        </div>
    </div>

</form>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.toggle-card input[type="checkbox"]').forEach(cb => {
    cb.closest('.toggle-card')
      .classList.toggle('on', cb.checked);
    cb.addEventListener('change', function () {
        this.closest('.toggle-card')
            .classList.toggle('on', this.checked);
    });

});

</script>
@endsection