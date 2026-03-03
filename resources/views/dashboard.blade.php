@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')


<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="eyebrow">Overview</div>
        <h2>Dashboard</h2>
    </div>
    <div class="page-date">
        <i class="bi bi-calendar3" style="color:var(--gold);"></i>
        <span id="live-date"></span>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="#" class="qa-btn qa-btn-primary"><i class="bi bi-plus-lg"></i> New Client</a>
    <a href="#" class="qa-btn qa-btn-gold"><i class="bi bi-file-earmark-plus"></i> New Case</a>
    <a href="#" class="qa-btn qa-btn-outline"><i class="bi bi-download"></i> Export Report</a>
</div>

<!-- Stat Cards -->
<div class="row g-4 stat-row">

    <div class="col-sm-6 col-lg-4">
        <div class="stat-card stat-card-blue">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Total Users</div>
                <div class="stat-value counter" data-target="{{ \App\Models\User::count() }}">0</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-right"></i> Active accounts</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="stat-card stat-card-gold">
            <div class="stat-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Total Roles</div>
                <div class="stat-value counter" data-target="{{ \App\Models\Role::count() }}">0</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-right"></i> Defined roles</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="stat-card stat-card-teal">
            <div class="stat-icon"><i class="bi bi-key-fill"></i></div>
            <div class="stat-body">
                <div class="stat-label">Total Permissions</div>
                <div class="stat-value counter" data-target="{{ \App\Models\Permission::count() }}">0</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-right"></i> Access rules</div>
            </div>
        </div>
    </div>

</div>

<!-- Charts + Activity -->
<div class="row g-4">

    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="section-card">
            <div class="section-card-header">
                <h6><i class="bi bi-bar-chart-line me-2" style="color:var(--gold);"></i>Revenue Overview</h6>
                <div class="chart-toolbar">
                    <button class="chart-btn active">6M</button>
                    <button class="chart-btn">1Y</button>
                    <button class="chart-btn">All</button>
                </div>
            </div>
            <canvas id="revenueChart" height="110"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-4">
        <div class="section-card">
            <div class="section-card-header">
                <h6><i class="bi bi-activity me-2" style="color:var(--gold);"></i>Recent Activity</h6>
                <span class="badge-pill">Live</span>
            </div>

            <div class="activity-item">
                <div class="activity-dot dot-blue"><i class="bi bi-person-plus-fill"></i></div>
                <div class="activity-body">
                    <div class="activity-title">New user created</div>
                    <div class="activity-meta">Admin added a user &middot; 2 min ago</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-dot dot-gold"><i class="bi bi-shield-check"></i></div>
                <div class="activity-body">
                    <div class="activity-title">Role updated</div>
                    <div class="activity-meta">Manager permissions changed &middot; 18 min ago</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-dot dot-teal"><i class="bi bi-patch-check-fill"></i></div>
                <div class="activity-body">
                    <div class="activity-title">System update applied</div>
                    <div class="activity-meta">Security patch deployed &middot; 1 hr ago</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-dot dot-red"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div class="activity-body">
                    <div class="activity-title">Failed login attempt</div>
                    <div class="activity-meta">Unknown IP blocked &middot; 3 hr ago</div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Live date
    const d = new Date();
    document.getElementById('live-date').textContent = d.toLocaleDateString('en-US', {
        weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'
    });

    // Chart toolbar
    document.querySelectorAll('.chart-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.chart-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Revenue chart
    const ctx = document.getElementById('revenueChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Revenue',
                    data: [1200, 1900, 3000, 2500, 3200, 4100],
                    borderColor: '#C9A84C',
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx: c, chartArea} = chart;
                        if (!chartArea) return 'transparent';
                        const gradient = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        gradient.addColorStop(0,  'rgba(201,168,76,.18)');
                        gradient.addColorStop(1,  'rgba(201,168,76,.01)');
                        return gradient;
                    },
                    borderWidth: 2.5,
                    tension: 0.42,
                    fill: true,
                    pointBackgroundColor: '#C9A84C',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                },
                {
                    label: 'Expenses',
                    data: [800, 1100, 1600, 1400, 1800, 2200],
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59,130,246,.06)',
                    borderWidth: 2,
                    tension: 0.42,
                    fill: true,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        borderRadius: 3,
                        usePointStyle: true,
                        font: { family: 'DM Sans', size: 12 },
                        color: '#5A6A8A'
                    }
                },
                tooltip: {
                    backgroundColor: '#0B1B35',
                    titleFont: { family: 'DM Sans', size: 12, weight: '600' },
                    bodyFont:  { family: 'DM Sans', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ' $' + ctx.parsed.y.toLocaleString()
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'DM Sans', size: 12 }, color: '#8B9BBE' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(228,234,244,.7)', drawBorder: false },
                    ticks: {
                        font: { family: 'DM Sans', size: 12 },
                        color: '#8B9BBE',
                        callback: v => '$' + v.toLocaleString()
                    }
                }
            }
        }
    });
});
</script>
@endsection