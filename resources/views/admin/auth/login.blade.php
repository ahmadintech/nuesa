<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Executive Admin Sign In - NUESA UNIMAID</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="NUESA UNIMAID Executive Control Login" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/logos/NUESA logo.jpeg') }}" rel="icon">

    <!-- Google Web Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap & Central CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #004d2e 0%, #002617 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 460px;
            width: 100%;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="auth-card p-4 p-md-5">
        <div class="text-center mb-4">
            <img src="{{ asset('img/logos/NUESA logo.jpeg') }}" alt="NUESA UNIMAID" class="rounded-circle shadow border border-3 border-success mb-3" style="width: 80px; height: 80px; object-fit: cover;">
            <h4 class="fw-bold text-dark mb-1">Executive Admin Portal</h4>
            <p class="text-muted small">Faculty of Engineering Executive Command & Control</p>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST" id="adminLoginForm">
            @csrf

            <!-- Executive Email / Staff ID -->
            <div class="mb-4">
                <label for="inputLoginId" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">mail</span>
                    Executive Email or Staff ID
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">badge</span>
                    </span>
                    <input type="text" name="login_id" id="inputLoginId" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" value="{{ old('login_id') }}" placeholder="Email or Matric Number" autocomplete="off" required autofocus>
                </div>
                @error('login_id')
                    <span class="text-danger extra-small mt-1 d-block"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <!-- Access Password -->
            <div class="mb-4">
                <label for="inputPassword" class="form-label fw-semibold text-dark small d-flex align-items-center mb-2">
                    <span class="material-symbols-outlined text-primary me-2" style="font-size: 20px;">lock</span>
                    Access Password
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3 py-3" style="border-top-left-radius: 16px; border-bottom-left-radius: 16px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">key</span>
                    </span>
                    <input type="password" name="password" id="inputPassword" class="form-control bg-light border-start-0 py-3 fs-6" style="border-top-right-radius: 16px; border-bottom-right-radius: 16px;" placeholder="••••••••••••" autocomplete="new-password" required>
                </div>
                @error('password')
                    <span class="text-danger extra-small mt-1 d-block"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                    <label class="form-check-label text-muted small" for="rememberMe">
                        Keep session active
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center w-100 fs-6" style="border-radius: 50px; background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                <span class="material-symbols-outlined me-2" style="font-size: 22px;">lock_open</span>
                Authenticate Executive Sign In
            </button>
        </form>

        <div class="text-center mt-4 border-top pt-3">
            <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                <i class="fa fa-arrow-left me-1"></i>Back to NUESA Public Portal
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true
        });

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif
    </script>
</body>

</html>
