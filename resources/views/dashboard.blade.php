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
    @can('clients.create')
    <a href="{{ route('clients.create') }}" class="qa-btn qa-btn-primary"><i class="bi bi-plus-lg"></i> New Client</a>
    @endcan
    @can('services.manage')
    <a href="{{ route('client_services.create') }}" class="qa-btn qa-btn-gold"><i class="bi bi-file-earmark-plus"></i> Assign Service</a>
    @endcan

</div>

<!-- Stat Cards -->
<div class="row g-4 stat-row">
    @can('users.manage')
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
    @endcan

    @can('roles.manage')
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
@endcan
</div>

<!-- Charts + Activity -->
@can('finance.manage')
    
<div class="row g-4">

    <!-- Revenue Chart -->
    <div class="col-lg-12">
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


</div>
@endcan

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Live date
    const d = new Date();
    document.getElementById('live-date').textContent = d.toLocaleDateString('en-US', {
        weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'
    });
@can('finance.manage')

    // Chart toolbar
$('.chart-btn').click(function(){

    $('.chart-btn').removeClass('active');

    $(this).addClass('active');

    let range = $(this).text();

    loadChart(range);

});
    // Revenue chart
   let revenueChart;

function loadChart(range='6M')
{

    $('#revenueChart').css('opacity','.3');

    $.get("{{ route('dashboard.chart.data') }}",{range:range},function(res){

        $('#revenueChart').css('opacity','1');

        if(revenueChart){
            revenueChart.destroy();
        }
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // gradients
        const revenueGradient = ctx.createLinearGradient(0,0,0,300);
        revenueGradient.addColorStop(0,'rgba(22,163,74,.35)');
        revenueGradient.addColorStop(1,'rgba(22,163,74,.02)');

        const expenseGradient = ctx.createLinearGradient(0,0,0,300);
        expenseGradient.addColorStop(0,'rgba(59,130,246,.25)');
        expenseGradient.addColorStop(1,'rgba(59,130,246,.02)');

        const outstandingGradient = ctx.createLinearGradient(0,0,0,300);
        outstandingGradient.addColorStop(0,'rgba(239,68,68,.25)');
        outstandingGradient.addColorStop(1,'rgba(239,68,68,.02)');

        revenueChart = new Chart(ctx,{
            type:'line',
            data:{
                labels:res.labels,
                datasets:[
                {
                    label:'Revenue (PKR)',
                    data:res.revenue,
                    borderColor:'#16A34A',
                    backgroundColor:revenueGradient,
                    tension:.45,
                    borderWidth:3,
                    pointRadius:3,
                    pointBackgroundColor:'#16A34A',
                    fill:true
                },
                {
                    label:'Expenses (PKR)',
                    data:res.expenses,
                    borderColor:'#60A5FA',
                    backgroundColor:expenseGradient,
                    tension:.45,
                    borderWidth:3,
                    pointRadius:3,
                    pointBackgroundColor:'#60A5FA',
                    fill:true
                },
                {
                    label:'Outstanding (PKR)',
                    data:res.outstanding,
                    borderColor:'#EF4444',
                    backgroundColor:outstandingGradient,
                    borderDash:[6,6],
                    tension:.45,
                    borderWidth:2,
                    pointRadius:3,
                    pointBackgroundColor:'#EF4444',
                    fill:false
                }
                ]
            },

            options:{
                responsive:true,
                interaction:{
                    mode:'index',
                    intersect:false
                },

                plugins:{
                    legend:{
                        position:'top',
                        labels:{
                            usePointStyle:true,
                            padding:20
                        }
                    },

                    tooltip:{
                        backgroundColor:'#111',
                        padding:12,
                        callbacks:{
                            label:function(context){
                                return context.dataset.label + ': PKR ' + context.raw.toLocaleString();
                            }
                        }
                    }
                },

                scales:{
                    x:{
                        grid:{
                            display:false
                        }
                    },

                    y:{
                        grid:{
                            color:'rgba(200,200,200,.1)'
                        },
                        ticks:{
                            callback:function(value){
                                return 'PKR ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
}
loadChart('6M');
@endcan
});
</script>
<style>
#revenueChart.loading{
opacity:.3;
filter:blur(1px);
}
</style>
@endsection