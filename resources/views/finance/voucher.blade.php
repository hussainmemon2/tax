@extends('layouts.app')

@section('page-title', 'Create Voucher')

@section('content')
    <style>
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin-bottom: 28px;
        }
        .page-header .eyebrow {
            font-size: .7rem; font-weight: 600; letter-spacing: .14em;
            text-transform: uppercase; color: var(--gold); margin-bottom: 4px;
        }
        .page-header h2 {
            font-family: 'Playfair Display', serif; font-size: 1.55rem;
            font-weight: 700; color: var(--text-main); margin: 0;
        }
        .page-header p { font-size: .84rem; color: var(--text-sub); margin: 3px 0 0; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px;
            border-radius: 10px; border: 1.5px solid var(--border); background: #fff;
            font-size: .84rem; font-weight: 600; color: var(--text-main);
            text-decoration: none; transition: .2s; font-family: 'DM Sans', sans-serif; white-space: nowrap;
        }
        .btn-back:hover { border-color: var(--navy); color: var(--navy); }

        .assign-layout {
            display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start;
        }
        @media (max-width: 1024px) { .assign-layout { grid-template-columns: 1fr; } }

        /* ── Form card ── */
        .form-card {
            background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
            overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06); margin-bottom: 20px;
        }
        .form-card-header {
            padding: 17px 24px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 11px;
            background: linear-gradient(90deg, #F8F9FC, #fff);
        }
        .fch-icon {
            width: 36px; height: 36px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; flex-shrink: 0;
        }
        .fch-gold { background: var(--gold-pale); border: 1px solid rgba(201,168,76,.2); color: var(--gold); }
        .fch-title { font-family: 'Playfair Display', serif; font-size: .93rem; font-weight: 700; color: var(--text-main); margin: 0; }
        .fch-sub   { font-size: .73rem; color: var(--text-sub); margin: 2px 0 0; }
        .form-card-body { padding: 22px 24px; }

        /* ── Fields ── */
        .field-group { margin-bottom: 18px; }
        .field-group:last-child { margin-bottom: 0; }
        .field-group label {
            display: block; font-size: .73rem; font-weight: 700;
            letter-spacing: .07em; text-transform: uppercase; color: #3D4F72; margin-bottom: 7px;
        }
        .field-group label .req { color: var(--gold); margin-left: 2px; }
        .field-wrap { position: relative; }
        .field-wrap .f-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: #9AAACB; font-size: .9rem; pointer-events: none; z-index: 5;
        }

        /* ── Service dropdown loader ── */
        .service-field-wrap { position: relative; }
        .service-loading-ring {
            display: none;
            position: absolute; right: 38px; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; border-radius: 50%;
            border: 2px solid var(--border); border-top-color: var(--gold);
            animation: svcSpin .65s linear infinite; z-index: 6; pointer-events: none;
        }
        @keyframes svcSpin { to { transform: translateY(-50%) rotate(360deg); } }
        .service-hint {
            display: flex; align-items: center; gap: 5px;
            font-size: .72rem; color: var(--text-sub); margin-top: 6px;
            min-height: 18px; transition: opacity .2s;
        }
        .service-hint i { font-size: .72rem; }
        .service-hint.loading { color: var(--gold); }
        .service-hint.loaded  { color: #059669; }
        .service-hint.error   { color: #E05252; }
        .service-hint.empty   { color: #E05252; }

        /* ── Select2 ── */
        .select2-container .select2-selection--single {
            height: 44px !important; border: 1.5px solid var(--border) !important;
            border-radius: 9px !important; padding: 0 14px 0 38px !important;
            font-family: 'DM Sans', sans-serif !important; font-size: .88rem !important;
            background: #fff !important; display: flex !important; align-items: center !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important; line-height: 44px !important; color: var(--text-main) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder { color: #B0BEDB !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 44px !important; right: 12px !important; }
        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--gold) !important; box-shadow: 0 0 0 3px rgba(201,168,76,.11) !important; outline: none !important;
        }
        .select2-dropdown {
            border: 1.5px solid var(--border) !important; border-radius: 10px !important;
            box-shadow: 0 10px 36px rgba(15,31,61,.14) !important;
            font-family: 'DM Sans', sans-serif !important; font-size: .88rem !important; z-index: 99999 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--gold-pale) !important; color: var(--text-main) !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] { background: #F0F4FF !important; }
        .select2-search--dropdown .select2-search__field {
            border: 1.5px solid var(--border) !important; border-radius: 8px !important;
            padding: 8px 12px !important; font-family: 'DM Sans', sans-serif !important;
        }
        .select2-search--dropdown .select2-search__field:focus { border-color: var(--gold) !important; outline: none !important; }
        .select2-container--disabled .select2-selection--single {
            background: #F4F6FB !important; cursor: not-allowed !important; opacity: .7;
        }

        /* ══ TAB SHELL ══ */
        .tab-shell {
            background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
            overflow: visible; box-shadow: 0 4px 24px rgba(15,31,61,.06); margin-bottom: 20px;
        }
        .tab-nav {
            display: flex; align-items: stretch; border-bottom: 2px solid var(--border);
            background: #F8F9FC; overflow-x: auto; scrollbar-width: none;
            border-radius: var(--radius) var(--radius) 0 0;
        }
        .tab-nav::-webkit-scrollbar { display: none; }
        .tab-btn {
            display: flex; align-items: center; gap: 8px; padding: 15px 22px;
            font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
            color: var(--text-sub); border: none; background: none; cursor: pointer;
            white-space: nowrap; transition: color .18s, background .18s;
            border-bottom: 2px solid transparent; margin-bottom: -2px;
        }
        .tab-btn i { font-size: .88rem; opacity: .65; transition: opacity .18s; }
        .tab-btn:hover { color: var(--text-main); background: rgba(201,168,76,.03); }
        .tab-btn:hover i { opacity: 1; }
        .tab-btn.active { color: var(--navy); border-bottom-color: var(--gold); background: #fff; }
        .tab-btn.active i { opacity: 1; color: var(--gold); }
        .tab-count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 6px; border-radius: 50px;
            font-size: .66rem; font-weight: 700; transition: background .18s, color .18s;
        }
        .tab-btn[data-tab="invoices"] .tab-count { background: rgba(13,148,136,.08); color: #0D9488; border: 1px solid rgba(13,148,136,.18); }
        .tab-btn[data-tab="payments"] .tab-count { background: rgba(16,185,129,.08); color: #059669; border: 1px solid rgba(16,185,129,.18); }
        .tab-btn.active .tab-count { background: var(--gold) !important; color: var(--navy) !important; border-color: var(--gold) !important; }

        .tab-panels { padding: 24px; }
        .tab-panel { display: none; animation: fadeTabIn .22s ease both; }
        .tab-panel.active { display: block; }
        @keyframes fadeTabIn { from { opacity: 0; transform: translateY(7px); } to { opacity: 1; transform: translateY(0); } }

        .tab-add-bar {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 10px; margin-bottom: 18px;
        }
        .tab-section-label {
            font-size: .67rem; font-weight: 700; letter-spacing: .13em;
            text-transform: uppercase; color: var(--gold); display: flex; align-items: center; gap: 7px;
        }
        .action-add-btn {
            display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px;
            border-radius: 10px; font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600;
            cursor: pointer; border: 1.5px solid transparent;
            transition: transform .18s, box-shadow .18s, background .18s;
        }
        .action-add-btn:hover { transform: translateY(-2px); }
        .add-inv-btn { background: rgba(13,148,136,.07); color: #0D9488; border-color: rgba(13,148,136,.2); }
        .add-inv-btn:hover { background: rgba(13,148,136,.14); box-shadow: 0 4px 14px rgba(13,148,136,.12); }
        .add-pay-btn { background: rgba(16,185,129,.07); color: #059669; border-color: rgba(16,185,129,.2); }
        .add-pay-btn:hover { background: rgba(16,185,129,.14); box-shadow: 0 4px 14px rgba(16,185,129,.12); }

        /* ── Item cards ── */
        .item-card {
            background: #FAFBFD; border: 1.5px solid var(--border); border-radius: 11px;
            padding: 16px 18px; margin-bottom: 12px; position: relative; animation: itemIn .22s ease both;
        }
        .item-card:hover { border-color: rgba(201,168,76,.28); }
        @keyframes itemIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        .item-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .item-card-title  { display: flex; align-items: center; gap: 9px; font-size: .86rem; font-weight: 700; color: var(--text-main); }
        .item-num {
            width: 24px; height: 24px; border-radius: 7px;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy));
            color: var(--gold-lt); font-size: .72rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .item-type-tag { font-size: .7rem; font-weight: 600; padding: 2px 8px; border-radius: 50px; }
        .inv-tag { background: rgba(13,148,136,.08); color: #0D9488; border: 1px solid rgba(13,148,136,.18); }
        .pay-tag { background: rgba(16,185,129,.08); color: #059669; border: 1px solid rgba(16,185,129,.18); }
        .btn-remove-item {
            width: 28px; height: 28px; border-radius: 7px;
            border: 1.5px solid rgba(224,82,82,.2); background: rgba(224,82,82,.06);
            color: #E05252; display: flex; align-items: center; justify-content: center;
            font-size: .78rem; cursor: pointer; transition: .15s; flex-shrink: 0;
        }
        .btn-remove-item:hover { background: rgba(224,82,82,.15); }

        .item-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        @media (max-width: 640px) { .item-fields { grid-template-columns: 1fr; } }

        .ifield label {
            display: block; font-size: .7rem; font-weight: 700;
            letter-spacing: .07em; text-transform: uppercase; color: var(--text-sub); margin-bottom: 5px;
        }
        .ifield .pf-control {
            width: 100%; padding: 9px 13px; border: 1.5px solid var(--border); border-radius: 8px;
            font-family: 'DM Sans', sans-serif; font-size: .86rem; color: var(--text-main);
            background: #fff; transition: border-color .2s, box-shadow .2s; outline: none; -webkit-appearance: none;
        }
        .ifield .pf-control::placeholder { color: #B0BEDB; }
        .ifield .pf-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); }
        .ifield .pf-control.is-invalid { border-color: #E05252; }
        .ifield .pf-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(224,82,82,.1); }
        .ifield .pf-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239AAACB' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; padding-right: 34px; cursor: pointer;
        }
        .ifield textarea.pf-control { min-height: 68px; resize: vertical; }
        .invalid-feedback { font-size: .75rem; color: #E05252; margin-top: 4px; display: flex; align-items: center; gap: 4px; }

        .tab-empty {
            text-align: center; padding: 44px 20px;
            border: 2px dashed var(--border); border-radius: 12px; color: var(--text-sub); font-size: .84rem;
        }
        .tab-empty i { font-size: 1.6rem; color: #C8D2E8; display: block; margin-bottom: 10px; }
        .tab-empty p { margin: 0; }

        /* ── Summary card ── */
        .summary-card {
            background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
            overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06);
            position: sticky; top: calc(var(--topbar-h, 70px) + 20px);
        }
        .summary-card-header {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            display: flex; align-items: center; gap: 10px;
        }
        .s-icon {
            width: 34px; height: 34px; border-radius: 9px;
            background: rgba(201,168,76,.2); border: 1px solid rgba(201,168,76,.3);
            display: flex; align-items: center; justify-content: center; color: var(--gold-lt); font-size: .88rem;
        }
        .s-title { font-family: 'Playfair Display', serif; font-size: .95rem; font-weight: 700; color: #fff; }
        .s-sub   { font-size: .72rem; color: rgba(255,255,255,.45); margin-top: 1px; }
        .summary-body { padding: 20px; }

        /* Summary rows */
        .summary-row {
            display: flex; align-items: flex-start; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px solid var(--border); font-size: .87rem;
        }
        .summary-row:last-of-type { border-bottom: none; }
        .s-label { display: flex; align-items: center; gap: 8px; color: var(--text-sub); font-weight: 500; padding-top: 1px; }
        .s-label i { font-size: .85rem; }
        .s-val-col { display: flex; flex-direction: column; align-items: flex-end; gap: 2px; }
        .s-val { font-weight: 700; color: var(--text-main); font-family: 'DM Sans', sans-serif; font-size: .9rem; }
        .s-val.negative { color: #E05252; }
        .s-sub-note { font-size: .68rem; color: #9AAACB; line-height: 1.3; }
        .summary-row.paid .s-val  { color: #059669; }

        /* Fetching spinner inline */
        .totals-spinner {
            display: none; align-items: center; gap: 7px;
            font-size: .75rem; color: var(--gold); padding: 8px 0;
        }
        .totals-spinner .mini-ring {
            width: 14px; height: 14px; border-radius: 50%;
            border: 2px solid rgba(201,168,76,.3); border-top-color: var(--gold);
            animation: svcSpin .65s linear infinite; flex-shrink: 0;
        }

        .summary-progress { margin: 14px 0 0; }
        .prog-label { display: flex; justify-content: space-between; font-size: .72rem; font-weight: 600; color: var(--text-sub); margin-bottom: 6px; }
        .prog-track { height: 8px; background: #EDF1F8; border-radius: 50px; overflow: hidden; }
        .prog-fill { height: 100%; border-radius: 50px; background: linear-gradient(90deg, #059669, #34D399); transition: width .5s cubic-bezier(.4,0,.2,1); width: 0%; }
        .prog-fill.over { background: linear-gradient(90deg, #E05252, #F87171); }

        /* Overpayment alert */
        .overpay-alert {
            display: none;
            margin-top: 14px; padding: 11px 14px;
            background: rgba(224,82,82,.07); border: 1.5px solid rgba(224,82,82,.28);
            border-radius: 10px; font-size: .78rem; color: #C0392B;
            align-items: flex-start; gap: 8px; animation: alertSlide .2s ease both;
        }
        .overpay-alert i { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
        @keyframes alertSlide { from { opacity:0; transform: translateY(-5px); } to { opacity:1; transform: translateY(0); } }

        .btn-submit {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 13px; border-radius: 10px; border: none;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy));
            color: #fff; font-family: 'DM Sans', sans-serif; font-size: .92rem; font-weight: 700;
            cursor: pointer; transition: transform .2s, box-shadow .2s, opacity .2s;
            box-shadow: 0 4px 16px rgba(11,27,53,.22); margin-top: 14px; position: relative; overflow: hidden;
        }
        .btn-submit::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(201,168,76,.12) 0%, transparent 60%); }
        .btn-submit:hover:not([disabled]) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(11,27,53,.3); }
        .btn-submit[disabled] { opacity: .45; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

        .alert-validation {
            background: rgba(224,82,82,.06); border: 1.5px solid rgba(224,82,82,.2);
            border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; font-size: .83rem; color: #C0392B;
        }
        .alert-validation ul { margin: 6px 0 0 16px; padding: 0; }
        .alert-validation li { margin-bottom: 3px; }
    </style>

    <div class="page-header">
        <div>
            <div class="eyebrow">Finance</div>
            <h2>Create Voucher</h2>
            <p>Select a client &amp; their service, then record invoices and payments</p>
        </div>
        <a href="{{ route('finance.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to Finance
        </a>
    </div>

    @if($errors->any())
        <div class="alert-validation">
            <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vouchers.store') }}" method="POST" enctype="multipart/form-data" id="assignServiceForm">
        @csrf

        {{-- Hidden: fetched totals from server when service is selected --}}
        <input type="hidden" id="fetchedInvoiced" value="0">
        <input type="hidden" id="fetchedPaid"     value="0">

        <div class="assign-layout">

            <!-- ════ LEFT ════ -->
            <div>

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="fch-icon fch-gold"><i class="bi bi-file-earmark-text-fill"></i></div>
                        <div>
                            <div class="fch-title">Voucher Details</div>
                            <div class="fch-sub">Select a client to load their active services</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label>Client <span class="req">*</span></label>
                                    <div class="field-wrap">
                                        <i class="bi bi-person f-icon"></i>
                                        <select name="client_id" id="client_id" class="select2" required style="width:100%;">
                                            <option value=""></option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    data-name="{{ $client->full_name }}"
                                                    data-cnic="{{ $client->cnic }}"
                                                    {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->full_name }} {{ $client->cnic }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="field-group">
                                    <label>Service <span class="req">*</span></label>
                                    <div class="field-wrap service-field-wrap">
                                        <i class="bi bi-briefcase f-icon"></i>
                                        <span class="service-loading-ring" id="serviceLoadingRing"></span>
                                        <select name="service_id" id="service_id" class="select2" required style="width:100%;" disabled>
                                            <option value="">Select client first…</option>
                                        </select>
                                    </div>
                                    <div class="service-hint" id="serviceHint">
                                        <i class="bi bi-info-circle"></i>
                                        <span id="serviceHintText">Choose a client to load available services</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="tab-shell">
                    <div class="tab-nav" role="tablist">
                        <button type="button" class="tab-btn active" data-tab="invoices" onclick="switchTab('invoices',this)">
                            <i class="bi bi-receipt-cutoff"></i> Invoices
                            <span class="tab-count" id="count-invoices">0</span>
                        </button>
                        <button type="button" class="tab-btn" data-tab="payments" onclick="switchTab('payments',this)">
                            <i class="bi bi-cash-stack"></i> Payments
                            <span class="tab-count" id="count-payments">0</span>
                        </button>
                    </div>

                    <div class="tab-panels">
                        <div class="tab-panel active" id="tab-invoices">
                            <div class="tab-add-bar">
                                <span class="tab-section-label"><i class="bi bi-receipt"></i> Billing Invoices</span>
                                <button type="button" class="action-add-btn add-inv-btn" id="addInvoiceBtn">
                                    <i class="bi bi-receipt-cutoff"></i> Add Invoice
                                </button>
                            </div>
                            <div id="invoicesContainer">
                                <div class="tab-empty" id="inv-empty">
                                    <i class="bi bi-receipt"></i>
                                    <p>No invoices yet — click <strong>Add Invoice</strong> to create one.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-panel" id="tab-payments">
                            <div class="tab-add-bar">
                                <span class="tab-section-label"><i class="bi bi-cash"></i> Payment Records</span>
                                <button type="button" class="action-add-btn add-pay-btn" id="addPaymentBtn">
                                    <i class="bi bi-cash-stack"></i> Add Payment
                                </button>
                            </div>
                            <div id="paymentsContainer">
                                <div class="tab-empty" id="pay-empty">
                                    <i class="bi bi-cash-coin"></i>
                                    <p>No payments yet — click <strong>Add Payment</strong> to record one.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /left -->

            <!-- ════ RIGHT — Summary ════ -->
            <div>
                <div class="summary-card">
                    <div class="summary-card-header">
                        <div class="s-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                        <div>
                            <div class="s-title">Voucher Summary</div>
                            <div class="s-sub">Live — updates as you type</div>
                        </div>
                    </div>
                    <div class="summary-body">

                        {{-- Fetching spinner --}}
                        <div class="totals-spinner" id="totalsSpinner">
                            <div class="mini-ring"></div>
                            <span>Loading existing totals…</span>
                        </div>

                        {{-- Row: Total Invoiced --}}
                        <div class="summary-row">
                            <span class="s-label"><i class="bi bi-receipt" style="color:var(--gold);"></i> Total Invoiced</span>
                            <div class="s-val-col">
                                <span class="s-val">PKR <span id="totalInvoiced">0.00</span></span>
                                <span class="s-sub-note" id="noteExistingInvoiced" style="display:none;"></span>
                            </div>
                        </div>

                        {{-- Row: Total Paid --}}
                        <div class="summary-row paid">
                            <span class="s-label"><i class="bi bi-check-circle-fill" style="color:#059669;"></i> Total Paid</span>
                            <div class="s-val-col">
                                <span class="s-val">PKR <span id="totalPaid">0.00</span></span>
                                <span class="s-sub-note" id="noteExistingPaid" style="display:none;"></span>
                            </div>
                        </div>

                        {{-- Row: Outstanding --}}
                        <div class="summary-row">
                            <span class="s-label"><i class="bi bi-exclamation-circle-fill" style="color:#E05252;"></i> Outstanding</span>
                            <div class="s-val-col">
                                <span class="s-val" id="outstandingVal">PKR <span id="outstanding">0.00</span></span>
                            </div>
                        </div>

                        <div class="summary-progress">
                            <div class="prog-label">
                                <span>Payment Progress</span>
                                <span id="progressPct">0%</span>
                            </div>
                            <div class="prog-track">
                                <div class="prog-fill" id="progressBar"></div>
                            </div>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:18px;">
                            <div style="text-align:center;padding:10px 6px;background:#F8F9FC;border:1px solid var(--border);border-radius:9px;cursor:pointer;" onclick="switchTabByName('invoices')">
                                <div style="font-size:1rem;font-weight:700;color:#0D9488;" id="sc-inv">0</div>
                                <div style="font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--text-sub);margin-top:2px;">Invoices</div>
                            </div>
                            <div style="text-align:center;padding:10px 6px;background:#F8F9FC;border:1px solid var(--border);border-radius:9px;cursor:pointer;" onclick="switchTabByName('payments')">
                                <div style="font-size:1rem;font-weight:700;color:#059669;" id="sc-pay">0</div>
                                <div style="font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--text-sub);margin-top:2px;">Payments</div>
                            </div>
                        </div>

                        {{-- Overpayment alert --}}
                        <div class="overpay-alert" id="overpayAlert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span id="overpayMsg">Payments exceed invoiced amount.</span>
                        </div>

                        <button type="submit" form="assignServiceForm" class="btn-submit" id="submitBtn">
                            <i class="bi bi-check-circle-fill"></i> Create Voucher
                        </button>

                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

  
        function updateSummary() {

            /* Existing totals fetched from DB */
            const fetchedInvoiced = parseFloat(document.getElementById('fetchedInvoiced').value) || 0;
            const fetchedPaid     = parseFloat(document.getElementById('fetchedPaid').value)     || 0;

            /* New amounts entered in this form */
            let newInvoiced = 0;
            document.querySelectorAll('input[name^="invoices"][name$="[total_amount]"]')
                .forEach(el => newInvoiced += parseFloat(el.value) || 0);

            let newPaid = 0;
            document.querySelectorAll('.payment-amount')
                .forEach(el => newPaid += parseFloat(el.value) || 0);

            /* Combined totals */
            const totalInvoiced = fetchedInvoiced + newInvoiced;
            const totalPaid     = fetchedPaid     + newPaid;
            const outstanding   = totalInvoiced   - totalPaid;
            const isOver        = totalPaid > totalInvoiced;

            /* Progress bar (cap at 100%, turn red when over) */
            const pct = totalInvoiced > 0 ? Math.min(100, (totalPaid / totalInvoiced) * 100) : 0;

            /* Update DOM */
            document.getElementById('totalInvoiced').textContent = fmt(totalInvoiced);
            document.getElementById('totalPaid').textContent     = fmt(totalPaid);
            document.getElementById('outstanding').textContent   = fmt(Math.abs(outstanding));

            /* Outstanding: show negative sign + red when overdue */
            const outstandingVal = document.getElementById('outstandingVal');
            outstandingVal.innerHTML = isOver
                ? `<span class="s-val negative">− PKR <span id="outstanding">${fmt(Math.abs(outstanding))}</span></span>`
                : `<span class="s-val">PKR <span id="outstanding">${fmt(outstanding)}</span></span>`;

            /* Progress bar */
            const bar = document.getElementById('progressBar');
            bar.style.width = pct.toFixed(1) + '%';
            bar.className   = 'prog-fill' + (isOver ? ' over' : '');
            document.getElementById('progressPct').textContent = (isOver ? '⚠ ' : '') + pct.toFixed(0) + '%';

            /* Overpayment alert banner + submit button */
            const alert     = document.getElementById('overpayAlert');
            const submitBtn = document.getElementById('submitBtn');

            if (isOver) {
                const excess = fmt(totalPaid - totalInvoiced);
                document.getElementById('overpayMsg').textContent =
                    `Payments exceed invoiced amount by PKR ${excess}. Reduce payment amounts to continue.`;
                alert.style.display  = 'flex';
                submitBtn.disabled   = true;
                submitBtn.setAttribute('disabled', true);
            } else {
                alert.style.display = 'none';
                submitBtn.disabled  = false;
                submitBtn.removeAttribute('disabled');
            }

            let running = fetchedPaid;
            document.querySelectorAll('.payment-amount').forEach(function (el) {
                el.nextElementSibling?.classList?.contains('invalid-feedback')
                    && el.nextElementSibling.remove();
                el.classList.remove('is-invalid');

                const val = parseFloat(el.value) || 0;
                running += val;

                if (running > totalInvoiced) {
                    el.classList.add('is-invalid');
                    const fb = document.createElement('div');
                    fb.className = 'invalid-feedback';
                    fb.innerHTML = '<i class="bi bi-exclamation-circle"></i> This payment pushes total paid above total invoiced.';
                    el.after(fb);
                }
            });
        }

        function fmt(n) {
            return parseFloat(n).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        /* ── Tab switching ── */
        function switchTab(name, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => { p.classList.remove('active'); p.style.display = 'none'; });
            btn.classList.add('active');
            const panel = document.getElementById('tab-' + name);
            if (panel) { panel.style.display = 'block'; panel.classList.remove('active'); void panel.offsetWidth; panel.classList.add('active'); }
        }

        function switchTabByName(name) {
            const btn = document.querySelector(`.tab-btn[data-tab="${name}"]`);
            if (btn) switchTab(name, btn);
            document.querySelector('.tab-shell')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.tab-panel').forEach(p => {
                if (!p.classList.contains('active')) p.style.display = 'none';
            });
        });

        /* ── Counter sync ── */
        function updateCounts() {
            const ic = document.querySelectorAll('#invoicesContainer .item-card').length;
            const pc = document.querySelectorAll('#paymentsContainer .item-card').length;
            ['count-invoices','sc-inv'].forEach(id => document.getElementById(id).textContent = ic);
            ['count-payments','sc-pay'].forEach(id => document.getElementById(id).textContent = pc);
            document.getElementById('inv-empty').style.display = ic === 0 ? 'block' : 'none';
            document.getElementById('pay-empty').style.display = pc === 0 ? 'block' : 'none';
        }

        /* ── Service hint helper ── */
        function setServiceHint(state, text) {
            const hint = document.getElementById('serviceHint');
            const span = document.getElementById('serviceHintText');
            const iconMap = { idle:'bi-info-circle', loading:'bi-arrow-repeat', loaded:'bi-check-circle-fill', empty:'bi-exclamation-circle-fill', error:'bi-x-circle-fill' };
            hint.className = 'service-hint ' + (state !== 'idle' ? state : '');
            hint.querySelector('i').className = 'bi ' + (iconMap[state] || 'bi-info-circle');
            span.textContent = text;
        }

        /* ── Reset fetched totals & sub-notes ── */
        function resetFetched() {
            document.getElementById('fetchedInvoiced').value = 0;
            document.getElementById('fetchedPaid').value     = 0;
            document.getElementById('noteExistingInvoiced').style.display = 'none';
            document.getElementById('noteExistingPaid').style.display     = 'none';
            updateSummary();
        }

        $(document).ready(function () {

            /* ── Select2 — client ── */
            $('#client_id').select2({
                width: '100%', dropdownParent: $('body'),
                placeholder: 'Search by name or CNIC…', allowClear: true,
                escapeMarkup: m => m,
                templateResult: function(c) {
                    if (!c.id) return c.text;
                    const name = $(c.element).data('name'), cnic = $(c.element).data('cnic');
                    return `<div><div style="font-weight:600;">${name}</div>${cnic?`<div style="font-size:.75rem;color:#9AAACB;">${cnic}</div>`:''}</div>`;
                },
                templateSelection: function(c) {
                    return c.id ? ($(c.element).data('name') || c.text) : c.text;
                },
            });

            /* ── Select2 — service ── */
            $('#service_id').select2({
                width: '100%', dropdownParent: $('body'),
                placeholder: 'Select client first…', allowClear: true,
            });
            $('#service_id').prop('disabled', true);

            /* ── Client change → load services ── */
            $('#client_id').on('change', function () {
                const clientId = $(this).val();
                const $svc = $('#service_id'), $ring = $('#serviceLoadingRing');

                $svc.prop('disabled', true).empty().append('<option value=""></option>').trigger('change');
                resetFetched();

                if (!clientId) { setServiceHint('idle', 'Choose a client to load available services'); $ring.hide(); return; }

                $ring.show();
                setServiceHint('loading', 'Loading services for this client…');

                $.ajax({
                    url: "{{ route('finance.client_services', ':id') }}".replace(':id', clientId), type: 'GET',
                    success: function (data) {
                        $ring.hide(); $svc.empty();
                        if (data.length > 0) {
                            $svc.append('<option value="">Select a service…</option>');
                            $.each(data, function (_, item) { $svc.append(`<option value="${item.id}">${item.name}</option>`); });
                            $svc.prop('disabled', false).trigger('change');
                            setServiceHint('loaded', data.length + ' service' + (data.length > 1 ? 's' : '') + ' available');
                        } else {
                            $svc.append('<option value="">No active services for this client</option>');
                            setServiceHint('empty', 'This client has no active services assigned');
                        }
                    },
                    error: function () {
                        $ring.hide(); $svc.empty().append('<option value="">Failed to load services</option>');
                        $svc.prop('disabled', false);
                        setServiceHint('error', 'Could not load services — please try again');
                    }
                });
            });

            /* ── Service change → fetch existing totals ── */
            $('#service_id').on('change', function () {
                const clientId  = $('#client_id').val();
                const serviceId = $(this).val();

                resetFetched();

                if (!clientId || !serviceId) return;

                /* Show spinner */
                const spinner = document.getElementById('totalsSpinner');
                spinner.style.display = 'flex';

                $.ajax({
                    url: '{{ route("finance.total_invoiced") }}',
                    type: 'GET',
                    data: { client_id: clientId, service_id: serviceId },
                    success: function (res) {
                        spinner.style.display = 'none';

                        const inv  = parseFloat(res.total_invoiced) || 0;
                        const paid = parseFloat(res.total_paid)     || 0;

                        document.getElementById('fetchedInvoiced').value = inv;
                        document.getElementById('fetchedPaid').value     = paid;

                        /* Show sub-notes only when there is an existing balance */
                        if (inv > 0) {
                            const n = document.getElementById('noteExistingInvoiced');
                            n.textContent = `Existing: PKR ${inv.toLocaleString('en-PK',{minimumFractionDigits:2})}`;
                            n.style.display = 'block';
                        }
                        if (paid > 0) {
                            const n = document.getElementById('noteExistingPaid');
                            n.textContent = `Existing: PKR ${paid.toLocaleString('en-PK',{minimumFractionDigits:2})}`;
                            n.style.display = 'block';
                        }

                        updateSummary();
                    },
                    error: function () {
                        spinner.style.display = 'none';
                        updateSummary();
                    }
                });
            });

            @if(old('client_id'))
                $('#client_id').trigger('change');
            @endif

            const today = new Date().toISOString().split('T')[0];
            let invoiceIndex = 0, paymentIndex = 0;

            /* ── Restore old invoices ── */
            @if(old('invoices'))
            let oldInvoices = @json(old('invoices'));
            Object.keys(oldInvoices).forEach(function (key) {
                invoiceIndex++;
                const inv = oldInvoices[key];
                $('#invoicesContainer').append(buildInvoiceCard(invoiceIndex, inv.narration ?? '', inv.total_amount ?? '', inv.issued_date ?? today));
            });
            @endif

            /* ── Restore old payments ── */
            @if(old('payments'))
            let oldPayments = @json(old('payments'));
            Object.keys(oldPayments).forEach(function (key) {
                paymentIndex++;
                const pay = oldPayments[key];
                $('#paymentsContainer').append(buildPaymentCard(paymentIndex, pay));
            });
            @endif

            updateSummary();
            updateCounts();

            @if($errors->any())
            let errorTab = null;
            @foreach($errors->keys() as $key)
                @if(str_starts_with($key, 'invoices')) errorTab = 'invoices';
                @elseif(str_starts_with($key, 'payments')) if (!errorTab) errorTab = 'payments';
                @endif
            @endforeach
            if (errorTab) switchTabByName(errorTab);
            @endif

            /* ── Add Invoice ── */
            $('#addInvoiceBtn').on('click', function () {
                invoiceIndex++;
                $('#invoicesContainer').append(buildInvoiceCard(invoiceIndex, '', '', today));
                updateCounts();
            });

            $(document).on('input', '.invoice-amount', updateSummary);
            $(document).on('click', '.remove-invoice', function () { $(this).closest('.item-card').remove(); updateSummary(); updateCounts(); });

            /* ── Add Payment ── */
            $('#addPaymentBtn').on('click', function () {
                paymentIndex++;
                $('#paymentsContainer').append(buildPaymentCard(paymentIndex, {}));
                updateCounts();
            });

            $(document).on('input', '.payment-amount', updateSummary);
            $(document).on('click', '.remove-payment', function () { $(this).closest('.item-card').remove(); updateSummary(); updateCounts(); });

            updateCounts();
        });

        /* ── Card builders (DRY) ── */
        function buildInvoiceCard(idx, narration, amount, date) {
            return `
            <div class="item-card" id="invoice-${idx}">
                <div class="item-card-header">
                    <div class="item-card-title">
                        <div class="item-num">${idx}</div>
                        <span class="item-type-tag inv-tag"><i class="bi bi-receipt me-1"></i>Invoice ${idx}</span>
                    </div>
                    <button type="button" class="btn-remove-item remove-invoice"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="item-fields">
                    <div class="ifield">
                        <label>Invoice Narration <span style="color:var(--gold)">*</span></label>
                        <input type="text" name="invoices[${idx}][narration]" class="pf-control" placeholder="e.g. Invoice for services rendered" required value="${narration}">
                    </div>
                    <div class="ifield">
                        <label>Total Amount <span style="color:var(--gold)">*</span></label>
                        <input type="number" name="invoices[${idx}][total_amount]" class="pf-control invoice-amount" placeholder="0.00" min="0" required value="${amount}">
                    </div>
                    <div class="ifield">
                        <label>Issued Date</label>
                        <input type="date" name="invoices[${idx}][issued_date]" class="pf-control" value="${date}">
                    </div>
                </div>
            </div>`;
        }

        function buildPaymentCard(idx, p) {
            const today = new Date().toISOString().split('T')[0];
            const sel = (val, opt) => val === opt ? 'selected' : '';
            return `
            <div class="item-card" id="payment-${idx}">
                <div class="item-card-header">
                    <div class="item-card-title">
                        <div class="item-num">${idx}</div>
                        <span class="item-type-tag pay-tag"><i class="bi bi-cash me-1"></i>Payment ${idx}</span>
                    </div>
                    <button type="button" class="btn-remove-item remove-payment"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="item-fields">
                    <div class="ifield">
                        <label>Amount <span style="color:var(--gold)">*</span></label>
                        <input type="number" step="0.01" name="payments[${idx}][amount]" class="pf-control payment-amount" placeholder="0.00" min="0" required value="${p.amount ?? ''}">
                    </div>
                    <div class="ifield">
                        <label>Payment Method <span style="color:var(--gold)">*</span></label>
                        <select name="payments[${idx}][payment_method]" class="pf-control pf-select" required>
                            <option value="">Select method…</option>
                            <option value="cash"          ${sel(p.payment_method,'cash')}>Cash</option>
                            <option value="bank_transfer" ${sel(p.payment_method,'bank_transfer')}>Bank Transfer</option>
                            <option value="card"          ${sel(p.payment_method,'card')}>Card</option>
                            <option value="check"         ${sel(p.payment_method,'check')}>Check</option>
                            <option value="online"        ${sel(p.payment_method,'online')}>Online</option>
                        </select>
                    </div>
                    <div class="ifield">
                        <label>Reference No.</label>
                        <input type="text" name="payments[${idx}][reference_no]" class="pf-control" placeholder="e.g. TXN-00123" value="${p.reference_no ?? ''}">
                    </div>
                    <div class="ifield">
                        <label>Payment Date</label>
                        <input type="date" name="payments[${idx}][payment_date]" class="pf-control" value="${p.payment_date ?? today}">
                    </div>
                    <div class="ifield" style="grid-column:1/-1;">
                        <label>Notes</label>
                        <textarea name="payments[${idx}][notes]" class="pf-control" placeholder="Optional notes…">${p.notes ?? ''}</textarea>
                    </div>
                </div>
            </div>`;
        }
    </script>
@endsection