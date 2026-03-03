<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | TaxLaw PMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('Assets/style/login.css') }}">
</head>
<body>

<!-- Background -->
<div class="bg-scene">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div class="page-wrap">
    <div class="center-stage">
        <div class="login-panel">

            <div class="brand-side">
                <div class="brand-logo">
                    <div class="logo-mark">T</div>
                    <div class="logo-text">Tax<span>Law</span> PMS</div>
                </div>

                <div class="brand-hero">
                    <h2>Practice Management<br>for <em>Modern Firms</em></h2>
                    <p>A secure, unified platform for tax &amp; legal professionals — manage clients, services, payments, documents, and financial performance with confidence.</p>

                    <div class="feature-pills">
                        <span class="pill">Client Management</span>
                        <span class="pill">Document Vault</span>
                        <span class="pill">Billing & Payments</span>
                        <span class="pill">Financial Reports</span>
                    </div>
                </div>

                <div class="brand-foot">Trusted by professional firms</div>
            </div>

            <!-- ── RIGHT: FORM ── -->
            <div class="form-side">
                <div class="form-header">
                    <div class="eyebrow">Secure Access</div>
                    <h3>Welcome back</h3>
                    <p>Sign in to your practice dashboard</p>
                </div>

                <form method="POST" action="{{ route('login.post') }}">

                    @csrf

                    <!-- Email -->
                    <div class="field-group">
                        <label for="email">Email Address</label>
                        <div class="field-wrap">
                            <svg class="f-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="field-control  @error('email') is-invalid @enderror"
                                placeholder="you@firm.com"
                                autocomplete="email"
                                value="{{ old('email') }}"
                                required>
                        </div>
                        @error('email')
                        <span class="invalid-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="field-group">
                        <label for="password">Password</label>
                        <div class="field-wrap">
                            <svg class="f-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="field-control  @error('password') is-invalid @enderror"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                required>
                            <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Toggle password">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <span class="invalid-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        Sign In to Dashboard
                    </button>

                </form>

                <hr class="gold-rule">

                <div class="secure-note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    256-bit SSL encrypted · Session-secured access
                </div>
            </div>

        </div>
    </div>

    <footer class="page-footer">
        © <script>document.write(new Date().getFullYear())</script> TaxLaw PMS. All rights reserved.
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    function togglePw() {
        const pw = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
        } else {
            pw.type = 'password';
            icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 4000,
            extendedTimeOut: 1000,
        };

        @if(session('success'))
            toastr.success("{!! addslashes(session('success')) !!}", "Success");
        @endif
        @if(session('error'))
            toastr.error("{!! addslashes(session('error')) !!}", "Error");
        @else
        setTimeout(() => toastr.info("Enter your credentials to continue", "TaxLaw PMS"), 800);
        @endif
        @if(session('warning'))
            toastr.warning("{!! addslashes(session('warning')) !!}", "Warning");
        @endif
        @if(session('info'))
            toastr.info("{!! addslashes(session('info')) !!}", "Info");
        @endif
        @if($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{!! addslashes($error) !!}", "Validation Error");
            @endforeach
        @endif

    });
</script>

</body>
</html>