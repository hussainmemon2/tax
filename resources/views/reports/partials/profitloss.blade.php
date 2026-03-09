<style>
    /* ── Report header ── */
    .rpt-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
        padding-bottom: 18px; border-bottom: 1px solid var(--border);
    }
    .rpt-header-left .rpt-eyebrow {
        font-size: .68rem; font-weight: 700; letter-spacing: .12em;
        text-transform: uppercase; color: var(--gold); margin-bottom: 3px;
        display: flex; align-items: center; gap: 6px;
    }
    .rpt-header-left h3 {
        font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700;
        color: var(--text-main); margin: 0 0 4px;
    }
    .rpt-meta { font-size: .75rem; color: var(--text-sub); display: flex; align-items: center; gap: 6px; }
    .rpt-meta i { font-size: .75rem; color: #9AAACB; }

    .rpt-header-right { text-align: right; }
    .rpt-period-label { font-size: .67rem; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; color: #9AAACB; margin-bottom: 4px; }
    .rpt-period-val   { font-size: .85rem; font-weight: 700; color: var(--text-main); font-family: 'DM Mono', monospace; }

    /* ── Stat cards ── */
    .stat-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 28px;
    }
    @media (max-width: 640px) { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        border-radius: 13px; padding: 18px 20px;
        border: 1px solid var(--border); position: relative; overflow: hidden;
    }
    .stat-card-income  { background: linear-gradient(135deg, #F0FDF8, #fff); border-color: rgba(16,185,129,.2); }
    .stat-card-expense { background: linear-gradient(135deg, #FFF5F5, #fff); border-color: rgba(224,82,82,.2); }
    .stat-card-profit  { background: linear-gradient(135deg, #F0F6FF, #fff); border-color: rgba(37,99,235,.2); }
    .stat-card-loss    { background: linear-gradient(135deg, #FFF5F5, #fff); border-color: rgba(224,82,82,.2); }

    /* Corner watermark icon */
    .stat-card::after {
        content: attr(data-icon); font-family: 'bootstrap-icons';
        position: absolute; right: 14px; bottom: 8px; font-size: 2.6rem;
        opacity: .07; pointer-events: none;
    }

    .stat-label {
        font-size: .68rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;
    }
    .stat-card-income  .stat-label { color: #059669; }
    .stat-card-expense .stat-label { color: #E05252; }
    .stat-card-profit  .stat-label { color: #2563EB; }
    .stat-card-loss    .stat-label { color: #E05252; }

    .stat-label i { font-size: .8rem; }

    .stat-amount {
        font-family: 'DM Sans', sans-serif; font-size: 1.45rem; font-weight: 800;
        line-height: 1.1; letter-spacing: -.01em;
    }
    .stat-card-income  .stat-amount { color: #059669; }
    .stat-card-expense .stat-amount { color: #E05252; }
    .stat-card-profit  .stat-amount { color: #2563EB; }
    .stat-card-loss    .stat-amount { color: #E05252; }

    .stat-amount .cur { font-size: .75rem; font-weight: 600; opacity: .65; margin-right: 2px; vertical-align: middle; }

    /* ── Breakdown table ── */
    .breakdown-section { margin-top: 8px; }
    .breakdown-title {
        font-size: .72rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: var(--text-sub);
        display: flex; align-items: center; gap: 7px; margin-bottom: 12px;
    }
    .breakdown-title i { color: var(--gold); }

    .breakdown-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 9px 14px; border-radius: 9px; font-size: .86rem; margin-bottom: 4px;
        background: #F8F9FC; border: 1px solid var(--border);
    }
    .breakdown-row:hover { background: #F2F5FA; }
    .breakdown-row .br-label { display: flex; align-items: center; gap: 8px; color: var(--text-main); font-weight: 500; }
    .breakdown-row .br-label i { color: #9AAACB; font-size: .8rem; }
    .breakdown-row .br-val { font-weight: 700; font-family: 'DM Sans', sans-serif; }
    .br-income  .br-val { color: #059669; }
    .br-expense .br-val { color: #E05252; }

    /* ── Net result banner ── */
    .net-banner {
        margin-top: 20px; border-radius: 13px; padding: 18px 22px;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
    }
    .net-banner.profit { background: linear-gradient(135deg, rgba(16,185,129,.08), rgba(16,185,129,.03)); border: 1.5px solid rgba(16,185,129,.25); }
    .net-banner.loss   { background: linear-gradient(135deg, rgba(224,82,82,.08), rgba(224,82,82,.03));  border: 1.5px solid rgba(224,82,82,.25); }

    .net-banner-left { display: flex; align-items: center; gap: 12px; }
    .net-icon {
        width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
    }
    .net-banner.profit .net-icon { background: rgba(16,185,129,.12); color: #059669; border: 1px solid rgba(16,185,129,.2); }
    .net-banner.loss   .net-icon { background: rgba(224,82,82,.12);  color: #E05252; border: 1px solid rgba(224,82,82,.2); }

    .net-label { font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; margin-bottom: 2px; }
    .net-banner.profit .net-label { color: #059669; }
    .net-banner.loss   .net-label { color: #E05252; }
    .net-desc { font-size: .78rem; color: var(--text-sub); }

    .net-amount {
        font-family: 'DM Sans', sans-serif; font-size: 1.6rem; font-weight: 800; letter-spacing: -.015em;
    }
    .net-banner.profit .net-amount { color: #059669; }
    .net-banner.loss   .net-amount { color: #E05252; }
    .net-amount .cur { font-size: .8rem; font-weight: 600; opacity: .7; margin-right: 2px; }

    /* ── Margin bar ── */
    .margin-bar-wrap { margin-top: 20px; }
    .margin-bar-label { display: flex; justify-content: space-between; align-items: center; margin-bottom: 7px; }
    .margin-bar-label span { font-size: .72rem; font-weight: 700; color: var(--text-sub); }
    .margin-bar-label strong { font-size: .82rem; font-weight: 800; }
    .margin-track { height: 10px; background: #EDF1F8; border-radius: 50px; overflow: hidden; }
    .margin-fill  { height: 100%; border-radius: 50px; transition: width .6s cubic-bezier(.4,0,.2,1); }
    .margin-fill.positive { background: linear-gradient(90deg, #059669, #34D399); }
    .margin-fill.negative { background: linear-gradient(90deg, #E05252, #F87171); }
</style>

{{-- ── Report Header ── --}}
<div class="rpt-header">
    <div class="rpt-header-left">
        <div class="rpt-eyebrow"><i class="bi bi-graph-up-arrow"></i> Profit &amp; Loss</div>
        <h3>P&amp;L Statement</h3>
        <div class="rpt-meta">
            <i class="bi bi-clock"></i>
            Generated {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>
    <div class="rpt-header-right">
        <div class="rpt-period-label">Report Period</div>
        <div class="rpt-period-val">
            {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
            &nbsp;→&nbsp;
            {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
        </div>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="stat-grid">

    {{-- Income --}}
    <div class="stat-card stat-card-income" data-icon="">
        <div class="stat-label"><i class="bi bi-arrow-down-circle-fill"></i> Total Income</div>
        <div class="stat-amount"><span class="cur">PKR</span>{{ number_format($income) }}</div>
    </div>

    {{-- Expenses --}}
    <div class="stat-card stat-card-expense" data-icon="">
        <div class="stat-label"><i class="bi bi-arrow-up-circle-fill"></i> Total Expenses</div>
        <div class="stat-amount"><span class="cur">PKR</span>{{ number_format($expense) }}</div>
    </div>

    {{-- Net --}}
    @if($profit >= 0)
    <div class="stat-card stat-card-profit" data-icon="">
        <div class="stat-label"><i class="bi bi-graph-up-arrow"></i> Net Profit</div>
        <div class="stat-amount"><span class="cur">PKR</span>{{ number_format($profit) }}</div>
    </div>
    @else
    <div class="stat-card stat-card-loss" data-icon="">
        <div class="stat-label"><i class="bi bi-graph-down-arrow"></i> Net Loss</div>
        <div class="stat-amount"><span class="cur">PKR</span>{{ number_format(abs($profit)) }}</div>
    </div>
    @endif

</div>

{{-- ── Breakdown rows ── --}}
<div class="breakdown-section">
    <div class="breakdown-title"><i class="bi bi-list-ul"></i> Breakdown</div>

    <div class="breakdown-row br-income">
        <div class="br-label"><i class="bi bi-cash-stack"></i> Payments Received</div>
        <div class="br-val">PKR {{ number_format($income) }}</div>
    </div>
    <div class="breakdown-row br-expense">
        <div class="br-label"><i class="bi bi-receipt"></i> Operational Expenses</div>
        <div class="br-val">PKR {{ number_format($expense) }}</div>
    </div>
</div>

{{-- ── Net result banner ── --}}
@php
    $isProfit    = $profit >= 0;
    $marginPct   = $income > 0 ? abs($profit / $income * 100) : 0;
@endphp

<div class="net-banner {{ $isProfit ? 'profit' : 'loss' }}">
    <div class="net-banner-left">
        <div class="net-icon">
            <i class="bi {{ $isProfit ? 'bi-emoji-smile-fill' : 'bi-emoji-frown-fill' }}"></i>
        </div>
        <div>
            <div class="net-label">{{ $isProfit ? 'Net Profit' : 'Net Loss' }}</div>
            <div class="net-desc">
                {{ $isProfit ? 'Revenue exceeded expenses' : 'Expenses exceeded revenue' }}
                for this period
            </div>
        </div>
    </div>
    <div class="net-amount">
        <span class="cur">PKR</span>{{ number_format(abs($profit)) }}
    </div>
</div>

{{-- ── Profit margin bar ── --}}
<div class="margin-bar-wrap">
    <div class="margin-bar-label">
        <span>{{ $isProfit ? 'Profit' : 'Loss' }} Margin</span>
        <strong style="color: {{ $isProfit ? '#059669' : '#E05252' }};">
            {{ number_format($marginPct, 1) }}%
        </strong>
    </div>
    <div class="margin-track">
        <div class="margin-fill {{ $isProfit ? 'positive' : 'negative' }}"
             style="width: {{ min(100, $marginPct) }}%"></div>
    </div>
</div>