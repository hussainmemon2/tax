<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaxLaw PMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('Assets/style/style.css') }}">
</head>
<body>

<!-- Overlay -->
<div id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ── SIDEBAR ─────────────────────────────────── -->
<aside class="sidebar" id="sidebar">

    <!-- Mobile header -->
    <div class="sidebar-mobile-header">
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="brand-mark">T</div>
            <span style="color:#fff;font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;">TaxLaw PMS</span>
        </div>
        <button onclick="closeSidebar()" style="background:none;border:none;color:var(--slate-lt);font-size:1.2rem;cursor:pointer;">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Brand (desktop) -->
    <div class="sidebar-brand d-none d-lg-flex">
        <div class="brand-mark">T</div>
        <div>
            <div class="brand-label">Tax<span>Law</span> PMS</div>
            <div class="brand-sub">Practice Management</div>
        </div>
    </div>

    <!-- Nav -->
    <div class="sidebar-nav">
        <div class="nav-section">Main</div>

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>

        @can('users.manage')
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            Users
        </a>
        @endcan

        @can('roles.manage')
        <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock-fill"></i>
            Roles
        </a>
        @endcan

        @can('services.manage')
        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
            <i class="bi bi-gear-wide-connected"></i>
            Services
        </a>
        @endcan
        @can('clients.view')
        <a href="{{ route('clients.index') }}" 
        class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard-fill"></i>
            Clients
        </a>
        @endcan
        @can('services.manage')
            <a href="{{ route('client_services.create') }}" class="{{ request()->routeIs('client_services.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-plus"></i> Assign Services
            </a>
        @endcan
        @can('finance.manage')
        <a href="{{ route('finance.index') }}" 
        class="{{ request()->routeIs('finance.*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard-fill"></i>
            Finance
        </a>
        @endcan
        @can('documents.manage')
            <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'active' : '' }}">
                    <i class="bi bi-files"></i> Documents
            </a>
        @endcan

        @can('reports.view')
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-break"></i> Reports
            </a>
        @endcan
    </div>

    <div class="sidebar-foot">
        © {{ date('Y') }} TaxLaw PMS
    </div>
</aside>

<div class="main-content">

    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="topbar-hamburger" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-breadcrumb">
                TaxLaw PMS &rsaquo; <strong>@yield('page-title', 'Dashboard')</strong>
            </div>
        </div>

        <div class="topbar-right">

            <!-- Profile -->
            <div class="dropdown">
                <a href="#" class="profile-trigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="profile-name">{{ auth()->user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </header>

    <!-- Page content -->
    <div class="page-body">
        @yield('content')
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.add('active');
        document.getElementById('sidebarOverlay').style.display = 'block';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('sidebarOverlay').style.display = 'none';
    }

    // Counter animation
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.counter').forEach(counter => {
            const update = () => {
                const target = +counter.getAttribute('data-target');
                const count  = +counter.innerText;
                const increment = target / 50;
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(update, 20);
                } else {
                    counter.innerText = target;
                }
            };
            update();
        });
    });

    // Toastr
    document.addEventListener("DOMContentLoaded", function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "4000"
        };

        @if(session('success'))
            toastr.success(@json(session('success')), "Success");
        @endif

        @if(session('error'))
            toastr.error(@json(session('error')), "Error");
        @endif

        @if(session('warning'))
            toastr.warning(@json(session('warning')), "Warning");
        @endif

        @if(session('info'))
            toastr.info(@json(session('info')), "Info");
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error(@json($error), "Validation Error");
            @endforeach
        @endif
    });
</script>

@yield('scripts')
</body>
</html>