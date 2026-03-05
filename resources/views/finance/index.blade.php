@extends('layouts.app')

@section('page-title', 'Finance Module')

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

    /* ── Search ── */
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
    .search-field input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); }

    /* ══ Tab shell ══ */
    .fin-tab-shell {
        background: #fff; border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }
    .fin-tab-nav {
        display: flex; align-items: stretch; border-bottom: 2px solid var(--border);
        background: #F8F9FC; overflow-x: auto; scrollbar-width: none;
    }
    .fin-tab-nav::-webkit-scrollbar { display: none; }

    .fin-tab-btn {
        display: flex; align-items: center; gap: 8px; padding: 15px 24px;
        font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
        color: var(--text-sub); border: none; background: none; cursor: pointer;
        white-space: nowrap; transition: color .18s, background .18s;
        border-bottom: 2px solid transparent; margin-bottom: -2px;
    }
    .fin-tab-btn i { font-size: .88rem; opacity: .65; transition: opacity .18s; }
    .fin-tab-btn:hover { color: var(--text-main); background: rgba(201,168,76,.03); }
    .fin-tab-btn:hover i { opacity: 1; }
    .fin-tab-btn.active { color: var(--navy); border-bottom-color: var(--gold); background: #fff; }
    .fin-tab-btn.active i { opacity: 1; color: var(--gold); }

    .fin-tab-body { padding: 24px; min-height: 320px; }

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

    /* ── Expense modal ── */
    .fin-modal .modal-content {
        border: 1px solid var(--border) !important; border-radius: 16px !important;
        overflow: hidden; box-shadow: 0 20px 60px rgba(15,31,61,.18) !important;
        font-family: 'DM Sans', sans-serif;
    }
    .fin-modal .modal-header {
        padding: 18px 24px; border-bottom: 1px solid var(--border);
        background: linear-gradient(90deg, #F8F9FC, #fff);
        display: flex; align-items: center; gap: 12px;
    }
    .fin-modal .modal-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .9rem;
        background: var(--gold-pale); color: var(--gold); border: 1px solid rgba(201,168,76,.2);
    }
    .fin-modal .modal-title {
        font-family: 'Playfair Display', serif !important; font-size: 1rem !important;
        font-weight: 700 !important; color: var(--text-main) !important; margin: 0 !important;
    }
    .fin-modal .modal-body { padding: 24px; }
    .fin-modal .btn-close { opacity: .5; }
    .fin-modal .btn-close:hover { opacity: 1; }

    .mfield { margin-bottom: 16px; }
    .mfield:last-child { margin-bottom: 0; }
    .mfield label {
        display: block; font-size: .7rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase; color: #3D4F72; margin-bottom: 6px;
    }
    .mfield label .req { color: var(--gold); margin-left: 2px; }
    .mfield .mf-control {
        width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: .88rem; color: var(--text-main);
        background: #fff; outline: none; transition: border-color .2s, box-shadow .2s;
        -webkit-appearance: none;
    }
    .mfield .mf-control::placeholder { color: #B0BEDB; }
    .mfield .mf-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); }
    .mfield textarea.mf-control { min-height: 72px; resize: vertical; }
    .mfield .mf-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239AAACB' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 34px; cursor: pointer;
    }

    .fin-modal .modal-footer {
        padding: 16px 24px; border-top: 1px solid var(--border); background: #F8F9FC;
        display: flex; justify-content: flex-end; gap: 10px;
    }
    .btn-modal-cancel {
        padding: 9px 18px; border-radius: 9px; border: 1.5px solid var(--border);
        background: #fff; color: var(--text-main); font-family: 'DM Sans', sans-serif;
        font-size: .84rem; font-weight: 600; cursor: pointer; transition: .18s;
    }
    .btn-modal-cancel:hover { border-color: var(--navy); color: var(--navy); }
    .btn-modal-submit {
        padding: 9px 22px; border-radius: 9px; border: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff; font-family: 'DM Sans', sans-serif;
        font-size: .84rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 4px 14px rgba(11,27,53,.2); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .btn-modal-submit::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(201,168,76,.15) 0%, transparent 60%); }
    .btn-modal-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(11,27,53,.28); }
</style>

<!-- ── Page Header ── -->
<div class="page-header">
    <div>
        <div class="eyebrow">Finance</div>
        <h2>Finance Dashboard</h2>
        <p>Manage invoices, payments &amp; expenses</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('finance.vouchers.create') }}" class="btn-primary-action">
            <i class="bi bi-file-earmark-plus"></i> Create Voucher
        </a>
        <button type="button" class="btn-primary-action" data-bs-toggle="modal" data-bs-target="#createExpenseModal"
            style="background:linear-gradient(135deg,#0D9488,#059669);">
            <i class="bi bi-plus-circle"></i> Add Expense
        </button>
    </div>
</div>

<!-- ── Search ── -->
<div class="search-wrap">
    <div class="search-field">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Search invoices, payments, expenses…">
    </div>
</div>

<!-- ── Tabs + AJAX content ── -->
<div class="fin-tab-shell">
    <div class="fin-tab-nav" role="tablist">
        <button class="fin-tab-btn active" data-tab="invoices">
            <i class="bi bi-receipt-cutoff"></i> Invoices
        </button>
        <button class="fin-tab-btn" data-tab="payments">
            <i class="bi bi-cash-stack"></i> Payments
        </button>
        <button class="fin-tab-btn" data-tab="expenses">
            <i class="bi bi-wallet2"></i> Expenses
        </button>
    </div>
    <div class="fin-tab-body" id="tabContent">
        <div class="ajax-spinner">
            <div class="spin-ring"></div>
            <span>Loading…</span>
        </div>
    </div>
</div>

<!-- ════ CREATE EXPENSE MODAL ════ -->
<div class="modal fade fin-modal" id="createExpenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon"><i class="bi bi-wallet2"></i></div>
                <h5 class="modal-title">Record New Expense</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="expenseForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12">
                            <div class="mfield">
                                <label>Title <span class="req">*</span></label>
                                <input type="text" name="title" class="mf-control" placeholder="e.g. Office supplies, Utility bill…" required maxlength="255">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mfield">
                                <label>Amount (PKR) <span class="req">*</span></label>
                                <input type="number" name="amount" class="mf-control" placeholder="0.00" min="0" step="0.01" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mfield">
                                <label>Expense Date <span class="req">*</span></label>
                                <input type="date" name="expense_date" class="mf-control" id="expenseDateField" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mfield">
                                <label>Category</label>
                                <select name="category" id="expenseCategory" class="mf-control mf-select">
                                <option value="">Select category…</option>
                                <option value="Office Supplies">Office Supplies</option>
                                <option value="Utilities">Utilities</option>
                                <option value="Rent">Rent</option>
                                <option value="Salaries">Salaries</option>
                                <option value="Travel">Travel</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Software">Software</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-submit" id="expenseSubmitBtn">
                        <span class="btn-text">
                            <i class="bi bi-check-circle-fill me-1"></i> Save Expense
                        </span>
                        <span class="btn-loader d-none">
                            <span class="spinner-border spinner-border-sm"></span> Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('#expenseCategory').select2({
    placeholder: "Select or type category",
    tags: true,
    width: '100%',
    dropdownParent: $('#createExpenseModal'),
    tokenSeparators: [','],
});
let currentTab = 'invoices';
let debounceTimer = null;
document.getElementById('expenseForm').addEventListener('submit', function (e) {

    e.preventDefault();

    const form = this;
    const btn = document.getElementById('expenseSubmitBtn');

    const formData = new FormData(form);

    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loader').classList.remove('d-none');

    fetch("{{ route('finance.expenses.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        btn.querySelector('.btn-text').classList.remove('d-none');
        btn.querySelector('.btn-loader').classList.add('d-none');

        if(data.success){

            form.reset();

            $('#expenseCategory').val(null).trigger('change');

            const modal = bootstrap.Modal.getInstance(document.getElementById('createExpenseModal'));
            modal.hide();

            currentTab = 'expenses';

            document.querySelector('[data-tab="expenses"]').click();

            loadData();

        }

    })
    .catch(() => {

        btn.querySelector('.btn-text').classList.remove('d-none');
        btn.querySelector('.btn-loader').classList.add('d-none');

        alert("Something went wrong.");

    });

});
function loadData(page = 1) {
    const search = document.getElementById('searchInput').value;
    document.getElementById('tabContent').innerHTML =
        `<div class="ajax-spinner"><div class="spin-ring"></div><span>Loading…</span></div>`;
    fetch(`{{ route('finance.ajax') }}?tab=${currentTab}&page=${page}&search=${encodeURIComponent(search)}`)
        .then(res => res.text())
        .then(html => { document.getElementById('tabContent').innerHTML = html; });
}

document.addEventListener("DOMContentLoaded", function () {
    // Pre-fill today's date in expense modal
    document.getElementById('expenseDateField').value = new Date().toISOString().split('T')[0];

    loadData();

    document.querySelectorAll('[data-tab]').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('[data-tab]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentTab = this.dataset.tab;
            loadData();
        });
    });

    document.getElementById('searchInput').addEventListener('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { loadData(); }, 400);
    });
});

// Pagination (no reload)
document.getElementById('tabContent').addEventListener('click', function (e) {
    const link = e.target.closest('a[href*="page="]');
    if (!link) return;
    e.preventDefault();
    const url = new URL(link.href);
    const page = url.searchParams.get('page') ?? 1;
    loadData(page);
});

// After expense saved — close modal and reload expenses tab
document.getElementById('expenseForm')?.addEventListener('submit', function (e) {
    // Let the form submit normally (full POST)
    // If you want AJAX submit, replace with fetch() and call loadData() after
});
</script>
@endsection