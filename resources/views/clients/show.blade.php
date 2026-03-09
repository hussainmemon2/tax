@extends('layouts.app')

@section('page-title', 'Client Profile')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
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
        font-family:  serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
        line-height: 1.2;
    }
    .page-header p { font-size: .84rem; color: var(--text-sub); margin: 4px 0 0; }

    .header-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px; border-radius: 10px; border: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .88rem; font-weight: 600; text-decoration: none;
        cursor: pointer; transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(11,27,53,.22);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(11,27,53,.28); color: #fff; }

    .btn-secondary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 18px; border-radius: 10px;
        border: 1.5px solid var(--border); background: #fff;
        font-size: .88rem; font-weight: 600; color: var(--text-main);
        text-decoration: none; transition: .2s; font-family: 'DM Sans', sans-serif;
    }
    .btn-secondary:hover { border-color: var(--navy); color: var(--navy); }

    /* ── Profile hero ──────────────────────────── */
    .profile-hero {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 60%, #112244 100%);
        border-radius: var(--radius);
        padding: 26px 30px;
        display: flex;
        align-items: center;
        gap: 22px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(11,27,53,.22);
    }
    .profile-hero::before {
        content: ''; position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        border: 1px solid rgba(201,168,76,.1); border-radius: 50%;
    }
    .profile-hero::after {
        content: ''; position: absolute;
        top: -100px; right: -100px;
        width: 320px; height: 320px;
        border: 1px solid rgba(201,168,76,.06); border-radius: 50%;
    }

    .hero-avatar {
        width: 68px; height: 68px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(201,168,76,.3), rgba(201,168,76,.1));
        border: 2px solid rgba(201,168,76,.4);
        display: flex; align-items: center; justify-content: center;
        font-family:  serif;
        font-size: 1.8rem; font-weight: 700; color: var(--gold-lt);
        flex-shrink: 0; position: relative; z-index: 1;
    }

    .hero-body { flex: 1; position: relative; z-index: 1; }
    .hero-name {
        font-family:  serif;
        font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 7px;
    }
    .hero-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; }

    .hero-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 50px;
        font-size: .74rem; font-weight: 600;
    }
    .badge-individual { background: rgba(37,99,235,.2); color: #93C5FD; border: 1px solid rgba(37,99,235,.3); }
    .badge-business   { background: rgba(201,168,76,.2); color: var(--gold-lt); border: 1px solid rgba(201,168,76,.3); }

    .hero-id { font-size: .75rem; color: rgba(255,255,255,.4); }

    .hero-quick {
        display: flex; flex-direction: column; gap: 6px;
        position: relative; z-index: 1; align-items: flex-end;
    }
    .hero-contact-item {
        display: flex; align-items: center; gap: 7px;
        font-size: .82rem; color: rgba(255,255,255,.65);
    }
    .hero-contact-item i { color: var(--gold); font-size: .8rem; }

    /* ── Stats row ─────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    @media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px;
        display: flex; align-items: center; gap: 13px;
        transition: transform .22s, box-shadow .22s;
        box-shadow: 0 2px 12px rgba(15,31,61,.05);
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 32px rgba(15,31,61,.1); }

    .stat-icon {
        width: 42px; height: 42px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem; flex-shrink: 0;
    }
    .si-blue  { background: rgba(37,99,235,.08);  color: #2563EB; }
    .si-green { background: rgba(16,185,129,.08); color: #059669; }
    .si-red   { background: rgba(224,82,82,.08);  color: #E05252; }
    .si-gold  { background: rgba(201,168,76,.1);  color: var(--gold); }

    .stat-body { flex: 1; min-width: 0; }
    .stat-value {
        font-family:  serif;
        font-size: 1.25rem; font-weight: 700; color: var(--text-main);
        line-height: 1.1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .stat-label {
        font-size: .7rem; font-weight: 600; letter-spacing: .05em;
        text-transform: uppercase; color: var(--text-sub); margin-top: 3px;
    }

    /* ══════════════════════════════════════════
       TAB SYSTEM
    ══════════════════════════════════════════ */
    .tab-shell {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
        overflow: hidden;
    }

    /* Tab nav bar */
    .tab-nav {
        display: flex;
        align-items: stretch;
        border-bottom: 2px solid var(--border);
        background: #F8F9FC;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .tab-nav::-webkit-scrollbar { display: none; }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 22px;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        font-weight: 600;
        color: var(--text-sub);
        border: none;
        background: none;
        cursor: pointer;
        white-space: nowrap;
        position: relative;
        transition: color .2s, background .2s;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
    }
    .tab-btn i { font-size: .9rem; opacity: .7; transition: opacity .2s; }

    .tab-btn:hover {
        color: var(--text-main);
        background: rgba(201,168,76,.04);
    }
    .tab-btn:hover i { opacity: 1; }

    .tab-btn.active {
        color: var(--navy);
        border-bottom-color: var(--gold);
        background: #fff;
    }
    .tab-btn.active i { opacity: 1; color: var(--gold); }

    .tab-dot {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 18px; height: 18px;
        padding: 0 5px;
        border-radius: 50px;
        font-size: .65rem;
        font-weight: 700;
        background: rgba(201,168,76,.12);
        color: #8B6914;
        border: 1px solid rgba(201,168,76,.2);
        margin-left: 2px;
    }
    .tab-btn.active .tab-dot {
        background: var(--gold);
        color: var(--navy);
        border-color: var(--gold);
    }

    /* Tab panels */
    .tab-panels { padding: 26px; }

    .tab-panel {
        display: none;
        animation: fadeTab .22s ease both;
    }
    .tab-panel.active { display: block; }

    @keyframes fadeTab {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Info grid inside panels ───────────────── */
    .panel-section-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 18px;
        display: flex; align-items: center; gap: 8px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    .info-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
    .info-grid.cols-4 { grid-template-columns: repeat(4, 1fr); }
    @media (max-width: 900px) {
        .info-grid        { grid-template-columns: repeat(2, 1fr); }
        .info-grid.cols-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .info-grid, .info-grid.cols-2, .info-grid.cols-4 { grid-template-columns: 1fr; }
    }

    .info-field label {
        display: block;
        font-size: .69rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase;
        color: var(--text-sub); margin-bottom: 5px;
    }
    .info-value {
        font-size: .88rem; font-weight: 500; color: var(--text-main);
        padding: 10px 13px;
        background: #F8F9FC;
        border: 1px solid var(--border);
        border-radius: 8px;
        min-height: 40px;
        display: flex; align-items: center; gap: 7px;
    }
    .info-value i { color: var(--gold); font-size: .8rem; flex-shrink: 0; }
    .info-value.empty { color: #B0BEDB; font-style: italic; font-weight: 400; }
    .info-value.danger  { color: #E05252; font-weight: 600; }
    .info-value.success { color: #059669; font-weight: 600; }
    .info-value.multiline { align-items: flex-start; min-height: 56px; }

    .type-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 50px;
        font-size: .74rem; font-weight: 600;
    }
    .chip-individual { background: rgba(37,99,235,.1); color: #1D4ED8; border: 1px solid rgba(37,99,235,.2); }
    .chip-business   { background: rgba(201,168,76,.1); color: #8B6914; border: 1px solid rgba(201,168,76,.25); }

    /* ── Services table ────────────────────────── */
    .clean-table { width: 100%; border-collapse: collapse; }
    .clean-table thead tr { background: #F5F7FB; border-bottom: 2px solid var(--border); }
    .clean-table thead th {
        padding: 11px 16px;
        font-size: .69rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: var(--text-sub); white-space: nowrap;
    }
    .clean-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .clean-table tbody tr:last-child { border-bottom: none; }
    .clean-table tbody tr:hover { background: #FAFBFD; }
    .clean-table tbody td { padding: 13px 16px; font-size: .87rem; vertical-align: middle; }
    .svc-name { font-weight: 600; color: var(--text-main); }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 50px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
    }
    .badge-success { background: rgba(16,185,129,.1); color: #065F46; border: 1px solid rgba(16,185,129,.22); }
    .badge-warning { background: rgba(245,158,11,.1); color: #92400E; border: 1px solid rgba(245,158,11,.22); }

    /* ── Financial progress bar ────────────────── */
    .finance-bar-wrap { margin: 20px 0; }
    .finance-bar-label {
        display: flex; justify-content: space-between;
        font-size: .78rem; font-weight: 600; margin-bottom: 7px; color: var(--text-sub);
    }
    .finance-bar-track {
        height: 10px; background: #EDF1F8;
        border-radius: 50px; overflow: hidden;
    }
    .finance-bar-fill {
        height: 100%; border-radius: 50px;
        background: linear-gradient(90deg, #059669, #34D399);
        transition: width .6s cubic-bezier(.4,0,.2,1);
    }
    .finance-bar-fill.danger { background: linear-gradient(90deg, #E05252, #FCA5A5); }

    /* ── Portal placeholder ────────────────────── */
    .portal-placeholder {
        text-align: center; padding: 50px 20px;
    }
    .portal-icon-wrap {
        width: 68px; height: 68px; border-radius: 18px;
        background: rgba(100,116,139,.07);
        border: 1px solid rgba(100,116,139,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem; color: #94A3B8; margin: 0 auto 16px;
    }
    .portal-placeholder h6 {
        font-family:  serif;
        font-size: 1rem; font-weight: 700;
        color: var(--text-main); margin-bottom: 6px;
    }
    .portal-placeholder p { font-size: .84rem; color: var(--text-sub); margin-bottom: 18px; }
    .coming-soon-tag {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 50px;
        font-size: .7rem; font-weight: 600;
        background: rgba(245,158,11,.1); color: #B45309;
        border: 1px solid rgba(245,158,11,.2);
        margin-bottom: 16px;
    }
    .btn-disabled {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px; border-radius: 10px;
        border: 1.5px solid var(--border); background: #F3F4F6;
        font-family: 'DM Sans', sans-serif; font-size: .88rem;
        font-weight: 600; color: #9CA3AF; cursor: not-allowed;
    }

    @media (max-width: 640px) {
        .profile-hero { flex-direction: column; align-items: flex-start; }
        .hero-quick   { align-items: flex-start; }
        .tab-panels   { padding: 18px; }
    }
</style>

<!-- ── Page Header ── -->
<div class="page-header">
    <div>
        <div class="eyebrow">Client Profile</div>
        <h2>{{ $client->display_name }}</h2>
        <p>{{ ucfirst($client->client_type) }} Client &mdash; #{{ $client->id }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('clients.edit', $client) }}" class="btn-primary">
            <i class="bi bi-pencil-square"></i> Edit Client
        </a>
        <a href="{{ route('clients.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<!-- ── Profile Hero ── -->
<div class="profile-hero">
    <div class="hero-avatar">
        {{ strtoupper(substr($client->display_name, 0, 1)) }}
    </div>
    <div class="hero-body">
        <div class="hero-name">{{ $client->display_name }}</div>
        <div class="hero-meta">
            <span class="hero-badge {{ $client->client_type === 'business' ? 'badge-business' : 'badge-individual' }}">
                <i class="bi bi-{{ $client->client_type === 'business' ? 'briefcase-fill' : 'person-fill' }}"></i>
                {{ ucfirst($client->client_type) }} Client
            </span>
            @if($client->reference)
                <span class="hero-id"><i class="bi bi-tag" style="color:var(--gold);margin-right:3px;"></i>{{ $client->reference }}</span>
            @endif
            <span class="hero-id">Client #{{ $client->id }}</span>
        </div>
    </div>
    <div class="hero-quick">
        @if($client->email)
            <div class="hero-contact-item"><i class="bi bi-envelope"></i>{{ $client->email }}</div>
        @endif
        @if($client->phone)
            <div class="hero-contact-item"><i class="bi bi-telephone"></i>{{ $client->phone }}</div>
        @endif
    </div>
</div>

<!-- ── Stat Cards ── -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon si-blue"><i class="bi bi-briefcase-fill"></i></div>
        <div class="stat-body">
            <div class="stat-value">{{ $client->services->count() }}</div>
            <div class="stat-label">Active Services</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-green"><i class="bi bi-check-circle-fill"></i></div>
        <div class="stat-body">
            <div class="stat-value">PKR {{ number_format($totalPaid , 0) }}</div>
            <div class="stat-label">Total Paid</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-red"><i class="bi bi-exclamation-circle-fill"></i></div>
        <div class="stat-body">
            <div class="stat-value">PKR {{ number_format($outstanding, 0) }}</div>
            <div class="stat-label">Outstanding</div>
        </div>
    </div>
    {{-- <div class="stat-card">
        <div class="stat-icon si-gold"><i class="bi bi-folder2-open"></i></div>
        <div class="stat-body">
            <div class="stat-value">2</div>
            <div class="stat-label">Open Cases</div>
        </div>
    </div> --}}
</div>

<div class="tab-shell">

    <!-- Tab Navigation -->
    <div class="tab-nav" role="tablist">

        <button class="tab-btn active" onclick="switchTab('overview', this)" role="tab">
            <i class="bi bi-person-lines-fill"></i> Overview
        </button>

        <button class="tab-btn" onclick="switchTab('business', this)" role="tab">
            <i class="bi bi-building"></i> Business Info
        </button>

        <button class="tab-btn" onclick="switchTab('services', this)" role="tab">
            <i class="bi bi-briefcase-fill"></i> Services
            <span class="tab-dot">{{ $client->services->count() }}</span>
        </button>

        <button class="tab-btn" onclick="switchTab('financials', this)" role="tab">
            <i class="bi bi-bar-chart-line-fill"></i> Financials
        </button>

        <button class="tab-btn" onclick="switchTab('portal', this)" role="tab">
            <i class="bi bi-shield-lock-fill"></i> Portal
        </button>

    </div>

    <!-- ─── Tab Panels ─── -->
    <div class="tab-panels">

        <!-- ══════ TAB: OVERVIEW ══════ -->
        <div class="tab-panel active" id="tab-overview">

            <div class="panel-section-label">
                <i class="bi bi-info-circle"></i> Personal Details
            </div>

            <div class="info-grid">

                <div class="info-field">
                    <label>Full Name</label>
                    <div class="info-value">
                        <i class="bi bi-person"></i>{{ $client->full_name }}
                    </div>
                </div>

                <div class="info-field">
                    <label>Client Type</label>
                    <div class="info-value">
                        <span class="type-chip {{ $client->client_type === 'business' ? 'chip-business' : 'chip-individual' }}">
                            <i class="bi bi-{{ $client->client_type === 'business' ? 'briefcase-fill' : 'person-fill' }}"></i>
                            {{ ucfirst($client->client_type) }}
                        </span>
                    </div>
                </div>

                <div class="info-field">
                    <label>CNIC</label>
                    <div class="info-value {{ !$client->cnic ? 'empty' : '' }}">
                        @if($client->cnic)
                            <i class="bi bi-credit-card-2-front"></i>{{ $client->cnic }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

            </div>

            <div class="panel-section-label" style="margin-top:6px;">
                <i class="bi bi-telephone"></i> Contact Details
            </div>

            <div class="info-grid cols-2">

                <div class="info-field">
                    <label>Email Address</label>
                    <div class="info-value {{ !$client->email ? 'empty' : '' }}">
                        @if($client->email)
                            <i class="bi bi-envelope"></i>{{ $client->email }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

                <div class="info-field">
                    <label>Phone Number</label>
                    <div class="info-value {{ !$client->phone ? 'empty' : '' }}">
                        @if($client->phone)
                            <i class="bi bi-telephone"></i>{{ $client->phone }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

                <div class="info-field">
                    <label>Reference</label>
                    <div class="info-value {{ !$client->reference ? 'empty' : '' }}">
                        @if($client->reference)
                            <i class="bi bi-tag"></i>{{ $client->reference }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

            </div>

        </div>

        <!-- ══════ TAB: BUSINESS INFO ══════ -->
        <div class="tab-panel" id="tab-business">

            <div class="panel-section-label">
                <i class="bi bi-building"></i> Company Details
            </div>

            <div class="info-grid cols-2">

                <div class="info-field">
                    <label>Business Name</label>
                    <div class="info-value">
                        <i class="bi bi-building"></i>{{ $client->business_name }}
                    </div>
                </div>

                <div class="info-field">
                    <label>Registration Number</label>
                    <div class="info-value {{ !$client->registration_number ? 'empty' : '' }}">
                        @if($client->registration_number)
                            <i class="bi bi-hash"></i>{{ $client->registration_number }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

                <div class="info-field">
                    <label>Business Registration Date</label>
                    <div class="info-value {{ !$client->business_registration_date ? 'empty' : '' }}">
                        @if($client->business_registration_date)
                            <i class="bi bi-calendar3"></i>{{ $client->business_registration_date->format('d-M-Y') }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

                <div class="info-field">
                    <label>Sales Tax Number</label>
                    <div class="info-value {{ !$client->sales_tax_number ? 'empty' : '' }}">
                        @if($client->sales_tax_number)
                            <i class="bi bi-receipt"></i>{{ $client->sales_tax_number }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

                <div class="info-field" style="grid-column:1/-1;">
                    <label>Business Address</label>
                    <div class="info-value multiline {{ !$client->business_address ? 'empty' : '' }}">
                        @if($client->business_address)
                            <i class="bi bi-geo-alt" style="margin-top:1px;flex-shrink:0;"></i>{{ $client->business_address }}
                        @else
                            Not provided
                        @endif
                    </div>
                </div>

            </div>

        </div>

        <!-- ══════ TAB: SERVICES ══════ -->
        <div class="tab-panel" id="tab-services">

            <div class="panel-section-label">
                <i class="bi bi-briefcase"></i> Assigned Services
            </div>

            <div style="overflow-x:auto; margin: 0 -26px; padding: 0 26px;">
                <table class="clean-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client->services as $service)
                        <tr>
                            <td><span class="svc-name">{{ $service->service->name }}</span></td>
                            <td>
                            <button class="btn-primary btn-sm"  >
                               <i class="bi bi-eye"></i> 
                            </button>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ══════ TAB: FINANCIALS ══════ -->
        <div class="tab-panel" id="tab-financials">

            <div class="panel-section-label">
                <i class="bi bi-bar-chart-line"></i> Financial Summary
            </div>

            <div class="info-grid cols-4">

                <div class="info-field">
                    <label>Total Invoiced</label>
                    <div class="info-value">
                        <i class="bi bi-receipt"></i>PKR {{ number_format($totalInvoiced , 0)  }}
                    </div>
                </div>

                <div class="info-field">
                    <label>Total Paid</label>
                    <div class="info-value success">
                        <i class="bi bi-check-circle-fill"></i>PKR {{ number_format($totalPaid, 0) }}
                    </div>
                </div>

                <div class="info-field">
                    <label>Outstanding</label>
                    <div class="info-value danger">
                        <i class="bi bi-exclamation-circle-fill"></i>PKR {{ number_format($outstanding, 0) }}
                    </div>
                </div>
            <div class="info-field">
                    <label>Last Payment</label>
                    <div class="info-value">
                        <i class="bi bi-calendar-check"></i>{{ $lastpaymentdate ? date('d-M-Y', strtotime($lastpaymentdate)) : 'No payments yet' }}
                    </div>
                </div>
            </div>
            <!-- Payment progress bar -->
            <div class="finance-bar-wrap">
                <div class="finance-bar-label">
                    <span>Payment Progress</span>
                    <span style="color:var(--text-main);font-weight:700;">
                        PKR {{ number_format($totalPaid) }} / {{ number_format($totalInvoiced) }} 
                        ({{ number_format($paymentPercent, 2) }}%)
                    </span>
                </div>
                <div class="finance-bar-track">
                    <div class="finance-bar-fill" style="width:{{ $paymentPercent }}%;"></div>
                </div>
            </div>

            <div class="finance-bar-wrap">
                <div class="finance-bar-label">
                    <span>Outstanding</span>
                    <span style="color:#E05252;font-weight:700;">
                        PKR {{ number_format($outstanding) }} 
                        ({{ number_format($outstandingPercent, 2) }}%)
                    </span>
                </div>
                <div class="finance-bar-track">
                    <div class="finance-bar-fill danger" style="width:{{ $outstandingPercent }}%;"></div>
                </div>
            </div>

        </div>

        <!-- ══════ TAB: PORTAL ══════ -->
        <div class="tab-panel" id="tab-portal">
            <div class="portal-placeholder">
                <span class="coming-soon-tag"><i class="bi bi-clock"></i> Module Coming Soon</span>
                <div class="portal-icon-wrap">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h6>No Credentials Added</h6>
                <p>Portal credential management will be available in an upcoming module.</p>
                <button class="btn-disabled" disabled>
                    <i class="bi bi-plus-lg"></i> Add Credentials
                </button>
            </div>
        </div>

    </div><!-- /tab-panels -->
</div><!-- /tab-shell -->

@endsection

@section('scripts')
<script>
function switchTab(name, btn) {
    // Deactivate all tabs and panels
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => {
        p.classList.remove('active');
        p.style.display = 'none';
    });

    // Activate selected
    btn.classList.add('active');
    const panel = document.getElementById('tab-' + name);
    if (panel) {
        panel.style.display = 'block';
        // Trigger animation re-play
        panel.classList.remove('active');
        void panel.offsetWidth; // reflow
        panel.classList.add('active');
    }
}

// Init — make sure only active panel is visible on load
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab-panel').forEach(p => {
        if (!p.classList.contains('active')) p.style.display = 'none';
    });
});
</script>
@endsection