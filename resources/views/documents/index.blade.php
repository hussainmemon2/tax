@extends('layouts.app')

@section('page-title', 'Documents')

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

    .btn-primary-action {
        display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px;
        border-radius: 10px; border: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff; font-size: .84rem; font-weight: 600;
        font-family: 'DM Sans', sans-serif; white-space: nowrap;
        text-decoration: none; cursor: pointer;
        box-shadow: 0 4px 14px rgba(11,27,53,.2);
        transition: transform .2s, box-shadow .2s; position: relative; overflow: hidden;
    }
    .btn-primary-action::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(201,168,76,.15) 0%, transparent 60%);
    }
    .btn-primary-action:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(11,27,53,.28); color: #fff; }

    /* ── Filters bar ── */
    .filters-card {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: 18px 20px; margin-bottom: 20px;
        box-shadow: 0 4px 24px rgba(15,31,61,.05);
        display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end;
    }

    .filter-group { display: flex; flex-direction: column; gap: 5px; min-width: 160px; flex: 1; }
    .filter-group label {
        font-size: .68rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: #5C6D8A;
    }
    .filter-control {
        padding: 9px 13px; border: 1.5px solid var(--border); border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: .86rem; color: var(--text-main);
        background: #fff; outline: none; transition: border-color .2s, box-shadow .2s;
        -webkit-appearance: none;
    }
    .filter-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); }

    /* search has icon prefix */
    .filter-search-wrap { position: relative; }
    .filter-search-wrap i {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: #9AAACB; font-size: .88rem; pointer-events: none;
    }
    .filter-search-wrap .filter-control { padding-left: 35px; }
    .filter-control::placeholder { color: #B0BEDB; }

    /* select arrow */
    .filter-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239AAACB' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px; cursor: pointer;
    }

    .btn-clear-filters {
        display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px;
        border-radius: 9px; border: 1.5px solid var(--border); background: #F8F9FC;
        font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 600;
        color: var(--text-sub); cursor: pointer; transition: .18s; white-space: nowrap;
        align-self: flex-end;
    }
    .btn-clear-filters:hover { border-color: #E05252; color: #E05252; background: rgba(224,82,82,.04); }

    /* ── Main content card ── */
    .doc-shell {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }

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
        <div class="eyebrow">Documents</div>
        <h2>Document Library</h2>
        <p>Browse and download client documents</p>
    </div>
    <a href="{{ route('documents.create') }}" class="btn-primary-action">
        <i class="bi bi-cloud-upload"></i> Upload Documents
    </a>
</div>

<!-- ── Filters ── -->
<div class="filters-card">

    <div class="filter-group" style="max-width:220px;">
        <label>Service</label>
        <select id="serviceFilter" class="filter-control filter-select">
            <option value="">All Services</option>
        </select>
    </div>

    <div class="filter-group" style="max-width:280px;">
        <label>Search</label>
        <div class="filter-search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" class="filter-control" placeholder="Document or client name…">
        </div>
    </div>

    <div class="filter-group" style="max-width:180px;">
        <label>Document Date</label>
        <input type="date" id="documentDate" class="filter-control">
    </div>

    <div class="filter-group" style="max-width:180px;">
        <label>Upload Date</label>
        <input type="date" id="uploadDate" class="filter-control">
    </div>

    <button id="clearFilters" class="btn-clear-filters">
        <i class="bi bi-x-circle"></i> Clear
    </button>

</div>

<!-- ── Document list (AJAX) ── -->
<div class="doc-shell" id="docContent">
    <div class="ajax-spinner">
        <div class="spin-ring"></div>
        <span>Loading…</span>
    </div>
</div>

@endsection

@section('scripts')
<script>
const ajaxUrl    = "{{ route('documents.ajax') }}";
const serviceUrl = "{{ route('documents.services') }}";

function loadDocuments(page = 1) {
    const service = document.getElementById('serviceFilter').value;
    const search  = document.getElementById('searchInput').value;
    const docDate = document.getElementById('documentDate').value;
    const upDate  = document.getElementById('uploadDate').value;

    document.getElementById('docContent').innerHTML =
        `<div class="ajax-spinner"><div class="spin-ring"></div><span>Loading…</span></div>`;

    fetch(`${ajaxUrl}?page=${page}&service_id=${service}&search=${encodeURIComponent(search)}&document_date=${docDate}&upload_date=${upDate}`)
        .then(res => res.text())
        .then(html => document.getElementById('docContent').innerHTML = html);
}

let timer;
document.getElementById('searchInput').addEventListener('keyup', function () {
    clearTimeout(timer);
    timer = setTimeout(() => loadDocuments(), 400);
});

document.querySelectorAll('#serviceFilter,#documentDate,#uploadDate')
    .forEach(el => el.addEventListener('change', () => loadDocuments()));

document.addEventListener('click', function (e) {
    const link = e.target.closest('a[href*="page="]');
    if (!link) return;
    e.preventDefault();
    loadDocuments(new URL(link.href).searchParams.get('page'));
});

document.getElementById('clearFilters').addEventListener('click', function () {
    document.getElementById('serviceFilter').value = '';
    document.getElementById('searchInput').value   = '';
    document.getElementById('documentDate').value  = '';
    document.getElementById('uploadDate').value    = '';
    loadDocuments();
});

document.addEventListener('DOMContentLoaded', function () {
    fetch(serviceUrl)
        .then(res => res.json())
        .then(data => {
            const dd = document.getElementById('serviceFilter');
            data.forEach(s => {
                const o = document.createElement('option');
                o.value = s.id; o.text = s.service_name;
                dd.appendChild(o);
            });
        });
    loadDocuments();
});

function previewFile(url, mimeType) {
    const win = window.open('', '_blank');
    if (mimeType.includes('pdf')) {
        win.document.write(`<iframe src="${url}" style="width:100%;height:100vh;border:0;"></iframe>`);
    } else if (mimeType.includes('image')) {
        win.document.write(`<img src="${url}" style="max-width:100%;max-height:100vh;">`);
    } else {
        win.location.href = url;
    }
}
</script>
@endsection