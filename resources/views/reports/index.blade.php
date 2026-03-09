@extends('layouts.app')

@section('page-title', 'Reports')

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

    /* ── Filter card ── */
    .filter-card {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06); margin-bottom: 20px;
    }
    .filter-card-header {
        padding: 16px 24px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 11px;
        background: linear-gradient(90deg, #F8F9FC, #fff);
    }
    .fch-icon {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .88rem;
    }
    .fch-gold { background: var(--gold-pale); border: 1px solid rgba(201,168,76,.2); color: var(--gold); }
    .fch-title { font-family: 'Playfair Display', serif; font-size: .93rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .fch-sub   { font-size: .72rem; color: var(--text-sub); margin: 2px 0 0; }
    .filter-card-body { padding: 20px 24px; }

    /* ── Date range row ── */
    .filter-row {
        display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end;
    }
    .filter-group { display: flex; flex-direction: column; gap: 5px; flex: 1; min-width: 160px; }
    .filter-group label {
        font-size: .68rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: #5C6D8A;
    }
    .filter-control {
        padding: 10px 13px; border: 1.5px solid var(--border); border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: .87rem; color: var(--text-main);
        background: #fff; outline: none; transition: border-color .2s, box-shadow .2s;
        -webkit-appearance: none;
    }
    .filter-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); }

    /* Quick range chips */
    .range-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
    .range-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 50px; font-size: .75rem; font-weight: 600;
        border: 1.5px solid var(--border); background: #F8F9FC; color: var(--text-sub);
        cursor: pointer; transition: .15s; font-family: 'DM Sans', sans-serif;
    }
    .range-chip:hover  { border-color: var(--gold); color: var(--navy); background: var(--gold-pale); }
    .range-chip.active { border-color: var(--gold); color: var(--navy); background: var(--gold-pale); }

    /* ── Generate button ── */
    .btn-generate {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px;
        border-radius: 10px; border: none; cursor: pointer; white-space: nowrap;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff; font-family: 'DM Sans', sans-serif; font-size: .87rem; font-weight: 700;
        box-shadow: 0 4px 14px rgba(11,27,53,.2); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden; align-self: flex-end;
    }
    .btn-generate::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(201,168,76,.14) 0%, transparent 60%); }
    .btn-generate:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(11,27,53,.28); }

    /* ── Report shell card ── */
    .report-shell {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }

    /* ── Tab nav ── */
    .tab-nav {
        display: flex; align-items: stretch; border-bottom: 2px solid var(--border);
        background: #F8F9FC; overflow-x: auto; scrollbar-width: none;
    }
    .tab-nav::-webkit-scrollbar { display: none; }
    .tab-btn {
        display: flex; align-items: center; gap: 8px; padding: 14px 22px;
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

    /* ── Report content area ── */
    .report-body { padding: 28px 24px; min-height: 300px; }

    /* Empty / loading states */
    .report-empty {
        text-align: center; padding: 60px 20px; color: var(--text-sub);
    }
    .report-empty .re-icon {
        width: 64px; height: 64px; border-radius: 16px; margin: 0 auto 16px;
        background: var(--gold-pale); border: 1px solid rgba(201,168,76,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: var(--gold);
    }
    .report-empty h4 { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 6px; }
    .report-empty p  { font-size: .84rem; margin: 0; }

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
        <div class="eyebrow">Reports</div>
        <h2>Financial Reports</h2>
        <p>Profit &amp; Loss, income and expense analysis</p>
    </div>
</div>

<!-- ── Filter Card ── -->
<div class="filter-card">
    <div class="filter-card-header">
        <div class="fch-icon fch-gold"><i class="bi bi-funnel-fill"></i></div>
        <div>
            <div class="fch-title">Report Parameters</div>
            <div class="fch-sub">Choose a date range or use a quick preset</div>
        </div>
    </div>
    <div class="filter-card-body">

        {{-- Quick range chips --}}
        <div class="range-chips">
            <button type="button" class="range-chip" data-range="7">Last 7 days</button>
            <button type="button" class="range-chip active" data-range="30">Last 30 days</button>
            <button type="button" class="range-chip" data-range="90">Last 3 months</button>
            <button type="button" class="range-chip" data-range="this_month">This month</button>
            <button type="button" class="range-chip" data-range="last_month">Last month</button>
            <button type="button" class="range-chip" data-range="this_year">This year</button>
        </div>

        <div class="filter-row">
            <div class="filter-group" style="max-width:200px;">
                <label><i class="bi bi-calendar3 me-1"></i> From Date</label>
                <input type="date" id="fromDate" class="filter-control">
            </div>
            <div class="filter-group" style="max-width:200px;">
                <label><i class="bi bi-calendar3 me-1"></i> To Date</label>
                <input type="date" id="toDate" class="filter-control">
            </div>
            <button class="btn-generate" id="generateReportBtn">
                <i class="bi bi-file-earmark-bar-graph"></i> Generate Report
            </button>
        </div>

    </div>
</div>

<!-- ── Report Shell ── -->
<div class="report-shell">

    <div class="tab-nav" role="tablist">
        <button type="button" class="tab-btn active" data-tab="profitloss">
            <i class="bi bi-graph-up-arrow"></i> Profit &amp; Loss
        </button>
        {{-- Add more tabs here as needed --}}
    </div>

    <div class="report-body" id="reportContent">
        <div class="report-empty">
            <div class="re-icon"><i class="bi bi-bar-chart-line"></i></div>
            <h4>No report generated yet</h4>
            <p>Choose a date range above and click <strong>Generate Report</strong></p>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    let currentReportTab = 'profitloss';

    /* ── Set dates from quick range chip ── */
    function applyRange(range) {
        const today = new Date();
        let from, to = fmtDate(today);

        if (range === 'this_month') {
            from = fmtDate(new Date(today.getFullYear(), today.getMonth(), 1));
        } else if (range === 'last_month') {
            const f = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const t = new Date(today.getFullYear(), today.getMonth(), 0);
            from = fmtDate(f); to = fmtDate(t);
        } else if (range === 'this_year') {
            from = fmtDate(new Date(today.getFullYear(), 0, 1));
        } else {
            const d = new Date(today);
            d.setDate(d.getDate() - parseInt(range));
            from = fmtDate(d);
        }

        document.getElementById('fromDate').value = from;
        document.getElementById('toDate').value   = to;
    }

    function fmtDate(d) {
        return d.toISOString().split('T')[0];
    }

    /* ── Default: last 30 days ── */
    (function () {
        applyRange(30);
    })();

    /* ── Load report via AJAX ── */
    function loadReport() {
        const from = document.getElementById('fromDate').value;
        const to   = document.getElementById('toDate').value;

        if (from && to && from > to) {
            toastr.error('From date cannot be after To date', 'Invalid Range');
            return;
        }

        document.getElementById('reportContent').innerHTML =
            `<div class="ajax-spinner"><div class="spin-ring"></div><span>Generating report…</span></div>`;

        fetch(`{{ route('reports.ajax') }}?tab=${currentReportTab}&from=${from}&to=${to}`)
            .then(res => res.text())
            .then(html => {
                if (html) {
                    document.getElementById('reportContent').innerHTML = html;
                    toastr.success('Report generated successfully', 'Done');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('reportContent').innerHTML =
                    `<div class="report-empty">
                        <div class="re-icon" style="background:rgba(224,82,82,.08);border-color:rgba(224,82,82,.2);color:#E05252;">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <h4>Something went wrong</h4>
                        <p>A server error occurred. Please try again.</p>
                    </div>`;
                toastr.error('Server error occurred', 'Error');
            });
    }

    document.addEventListener('DOMContentLoaded', function () {

        /* Quick range chips */
        document.querySelectorAll('.range-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                document.querySelectorAll('.range-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                applyRange(this.dataset.range);
            });
        });

        /* Clear chip active state when dates are manually changed */
        ['fromDate','toDate'].forEach(id => {
            document.getElementById(id).addEventListener('change', function () {
                document.querySelectorAll('.range-chip').forEach(c => c.classList.remove('active'));
            });
        });

        /* Tab buttons */
        document.querySelectorAll('.tab-btn[data-tab]').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn[data-tab]').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentReportTab = this.dataset.tab;
            });
        });

        /* Generate button */
        document.getElementById('generateReportBtn').addEventListener('click', loadReport);
    });
</script>
@endsection