<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EcoWaste Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #2d6a4f;
            --primary-light: #52b788;
            --secondary:     #1b4332;
            --accent:        #95d5b2;
        }
        * { font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 50%, var(--primary-light) 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            position: relative; overflow: hidden;
        }

        /* Animated background blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 500px; height: 500px;
            background: var(--accent);
            top: -150px; right: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: white;
            bottom: -120px; left: -80px;
            animation-delay: -4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        .auth-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            width: 100%; max-width: 460px;
            padding: 48px 44px;
            position: relative; z-index: 1;
            animation: slideUp .5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            font-size: 2.8rem; text-align: center; margin-bottom: 6px;
        }
        .brand-name {
            text-align: center; font-size: 1.5rem; font-weight: 800;
            color: var(--secondary); margin-bottom: 4px;
        }
        .brand-sub {
            text-align: center; color: #6c757d; font-size: .9rem; margin-bottom: 36px;
        }

        .form-control {
            border-radius: 12px; padding: 12px 16px; border: 2px solid #e9ecef;
            font-size: .95rem; transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 .2rem rgba(82,183,136,.2);
        }
        .form-control.is-invalid { border-color: #dc3545; }

        .input-group-text {
            border-radius: 12px 0 0 12px; border: 2px solid #e9ecef; border-right: none;
            background: #f8f9fa; color: #6c757d;
        }
        .input-group .form-control { border-radius: 0 12px 12px 0; border-left: none; }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-light);
        }

        .btn-eco {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; border: none; border-radius: 50px;
            padding: 13px; font-weight: 700; font-size: 1rem;
            width: 100%; transition: all .3s;
            box-shadow: 0 4px 15px rgba(45,106,79,.35);
        }
        .btn-eco:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45,106,79,.5);
            color: white;
        }
        .btn-eco:active { transform: translateY(0); }

        .divider {
            display: flex; align-items: center; gap: 12px;
            color: #adb5bd; font-size: .85rem; margin: 24px 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e9ecef;
        }

        .toggle-password {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #6c757d; cursor: pointer;
            padding: 4px; z-index: 5;
        }
        .toggle-password:hover { color: var(--primary); }

        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 44px; }

        .remember-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px;
        }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }

        .link-eco { color: var(--primary); font-weight: 600; text-decoration: none; }
        .link-eco:hover { color: var(--primary-light); text-decoration: underline; }

        .back-home {
            position: fixed; top: 20px; left: 20px; z-index: 10;
            background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
            color: white; border: 1px solid rgba(255,255,255,.3);
            border-radius: 50px; padding: 8px 18px; font-size: .85rem;
            text-decoration: none; font-weight: 500; transition: all .2s;
        }
        .back-home:hover { background: rgba(255,255,255,.25); color: white; }

        .btn-google {
            background: white; color: #3c4043;
            border: 2px solid #e9ecef; border-radius: 50px;
            padding: 11px; font-weight: 600; font-size: .95rem;
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;
            text-decoration: none; transition: all .2s; margin-bottom: 20px;
        }
        .btn-google:hover {
            background: #f8f9fa; border-color: #d1d5db; color: #202124;
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .alert { border-radius: 12px; font-size: .9rem; }

        /* Strength meter */
        .strength-bar { height: 4px; border-radius: 2px; background: #e9ecef; margin-top: 6px; }
        .strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0; }
    </style>
</head>
<body>

<a href="{{ route('home') }}" class="back-home">
    <i class="bi bi-arrow-left me-1"></i> Back to Home
</a>

<div class="auth-card">
    <div class="brand-logo">♻️</div>
    <div class="brand-name">EcoWaste Portal</div>
    <div class="brand-sub">Sign in to manage waste collections</div>

    {{-- Flash success (e.g. after logout) --}}
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4 py-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Auth error --}}
    @if($errors->any())
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 py-2">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" id="loginForm" novalidate>
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="you@example.com"
                       value="{{ old('email') }}"
                       autocomplete="email" required autofocus>
            </div>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <div class="password-wrapper flex-grow-1">
                    <input type="password" name="password" id="loginPassword"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password"
                           autocomplete="current-password" required>
                    <button type="button" class="toggle-password" onclick="togglePwd('loginPassword', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Remember + Forgot --}}
        <div class="remember-row">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>
            <a href="#" class="link-eco small">Forgot password?</a>
        </div>

        <button type="submit" class="btn-eco" id="loginBtn">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <div class="divider">or</div>

    <a href="{{ route('auth.google') }}" class="btn-google">
        <svg width="18" height="18" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
        </svg>
        Sign in with Google
    </a>

    <div class="text-center small">
        Don't have an account?
        <a href="{{ route('register') }}" class="link-eco">Create one free</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

document.getElementById('loginForm').addEventListener('submit', function () {
    const btn = document.getElementById('loginBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Signing in...';
});
</script>
</body>
</html>
