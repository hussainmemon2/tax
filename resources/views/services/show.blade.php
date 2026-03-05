@extends('layouts.app')

@section('page-title', 'Service Details')

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

    /* ── Search bar ── */
    .search-wrap { margin-bottom: 20px; }
    .search-field { position: relative; max-width: 340px; }
    .search-field i {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: #9AAACB; font-size: .9rem; pointer-events: none;
    }
    .search-field input {
        width: 100%; padding: 10px 14px 10px 38px;
        border: 1.5px solid var(--border); border-radius: 10px;
        font-family: 'DM Sans', sans-serif; font-size: .88rem;
        color: var(--text-main); background: #fff; outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-field input::placeholder { color: #B0BEDB; }
    .search-field input:focus {
        border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1);
    }

    /* ══ Tab shell ══ */
    .svc-tab-shell {
        background: #fff; border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }
    .svc-tab-nav {
        display: flex; align-items: stretch; border-bottom: 2px solid var(--border);
        background: #F8F9FC; overflow-x: auto; scrollbar-width: none;
    }
    .svc-tab-nav::-webkit-scrollbar { display: none; }

    .svc-tab-btn {
        display: flex; align-items: center; gap: 8px; padding: 15px 24px;
        font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
        color: var(--text-sub); border: none; background: none; cursor: pointer;
        white-space: nowrap; transition: color .18s, background .18s;
        border-bottom: 2px solid transparent; margin-bottom: -2px;
    }
    .svc-tab-btn i { font-size: .88rem; opacity: .65; transition: opacity .18s; }
    .svc-tab-btn:hover { color: var(--text-main); background: rgba(201,168,76,.03); }
    .svc-tab-btn:hover i { opacity: 1; }
    .svc-tab-btn.active { color: var(--navy); border-bottom-color: var(--gold); background: #fff; }
    .svc-tab-btn.active i { opacity: 1; color: var(--gold); }

    .svc-tab-body { padding: 24px; min-height: 300px; }

    /* ── Spinner ── */
    .ajax-spinner {
        display: flex; align-items: center; justify-content: center;
        padding: 60px 20px; gap: 12px; color: var(--text-sub); font-size: .88rem;
    }
    .ajax-spinner .spin-ring {
        width: 26px; height: 26px; border-radius: 50%;
        border: 2.5px solid var(--border); border-top-color: var(--gold);
        animation: spinRing .7s linear infinite; flex-shrink: 0;
    }
    @keyframes spinRing { to { transform: rotate(360deg); } }
</style>

<!-- ── Page Header ── -->
<div class="page-header">
    <div>
        <div class="eyebrow">Service Details</div>
        <h2>{{ $service->name }}</h2>
        <p>{{ $service->description ?? 'No description' }}</p>
    </div>
    <a href="{{ route('services.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<!-- ── Search ── -->
<div class="search-wrap">
    <div class="search-field">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Search clients, invoices, payments…">
    </div>
</div>

<!-- ── Tabs + AJAX content ── -->
<div class="svc-tab-shell">

    <div class="svc-tab-nav" role="tablist">
        <button class="svc-tab-btn active" data-tab="clients">
            <i class="bi bi-people-fill"></i> Clients
        </button>
        <button class="svc-tab-btn" data-tab="invoices">
            <i class="bi bi-receipt-cutoff"></i> Invoices
        </button>
        <button class="svc-tab-btn" data-tab="payments">
            <i class="bi bi-cash-stack"></i> Payments
        </button>
    </div>

    <div class="svc-tab-body" id="tabContent">
        <div class="ajax-spinner">
            <div class="spin-ring"></div>
            <span>Loading…</span>
        </div>
    </div>

</div>

@endsection


@section('scripts')
<script>
let currentTab = 'clients';
let debounceTimer = null;

function loadData(page = 1) {
    const search = document.getElementById('searchInput').value;

    document.getElementById('tabContent').innerHTML =
        `<div class="ajax-spinner"><div class="spin-ring"></div><span>Loading…</span></div>`;

    fetch(`{{ route('services.ajax', $service->id) }}?tab=${currentTab}&page=${page}&search=${encodeURIComponent(search)}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('tabContent').innerHTML = html;
        });
}

document.addEventListener("DOMContentLoaded", function () {

    // Initial load
    loadData();

    // Tab click
    document.querySelectorAll('[data-tab]').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('[data-tab]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentTab = this.dataset.tab;
            loadData();
        });
    });

    // Search with debounce
    document.getElementById('searchInput').addEventListener('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { loadData(); }, 400);
    });

});

// Pagination click handler (important)
document.getElementById('tabContent').addEventListener('click', function (e) {
    const link = e.target.closest('a[href*="page="]');
    if (!link) return;
    e.preventDefault();
    e.stopPropagation();
    const url = new URL(link.href);
    const page = url.searchParams.get('page') ?? 1;
    loadData(page);
});
</script>
@endsection