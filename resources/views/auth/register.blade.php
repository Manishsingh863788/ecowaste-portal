<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | EcoWaste Portal</title>
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
        body::before, body::after {
            content: '';
            position: fixed; border-radius: 50%; opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        body::before { width: 500px; height: 500px; background: var(--accent); top: -150px; right: -100px; }
        body::after  { width: 400px; height: 400px; background: white; bottom: -120px; left: -80px; animation-delay: -4s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        .auth-card {
            background: white; border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            width: 100%; max-width: 480px;
            padding: 44px 44px;
            position: relative; z-index: 1;
            animation: slideUp .5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand-logo  { font-size: 2.8rem; text-align: center; margin-bottom: 6px; }
        .brand-name  { text-align: center; font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 4px; }
        .brand-sub   { text-align: center; color: #6c757d; font-size: .9rem; margin-bottom: 32px; }

        .form-control {
            border-radius: 12px; padding: 12px 16px; border: 2px solid #e9ecef;
            font-size: .95rem; transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus { border-color: var(--primary-light); box-shadow: 0 0 0 .2rem rgba(82,183,136,.2); }
        .form-control.is-invalid { border-color: #dc3545; }

        .input-group-text {
            border-radius: 12px 0 0 12px; border: 2px solid #e9ecef; border-right: none;
            background: #f8f9fa; color: #6c757d;
        }
        .input-group .form-control { border-radius: 0 12px 12px 0; border-left: none; }
        .input-group:focus-within .input-group-text { border-color: var(--primary-light); }

        .btn-eco {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; border: none; border-radius: 50px;
            padding: 13px; font-weight: 700; font-size: 1rem;
            width: 100%; transition: all .3s;
            box-shadow: 0 4px 15px rgba(45,106,79,.35);
        }
        .btn-eco:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(45,106,79,.5); color: white; }

        .divider { display: flex; align-items: center; gap: 12px; color: #adb5bd; font-size: .85rem; margin: 20px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e9ecef; }

        .toggle-password {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #6c757d; cursor: pointer; padding: 4px; z-index: 5;
        }
        .toggle-password:hover { color: var(--primary); }
        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 44px; }

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

        /* Password strength */
        .strength-bar  { height: 5px; border-radius: 3px; background: #e9ecef; margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 3px; transition: width .3s, background .3s; width: 0; }
        .strength-label { font-size: .75rem; margin-top: 4px; font-weight: 600; }

        /* Requirements checklist */
        .req-list { list-style: none; padding: 0; margin: 8px 0 0; }
        .req-list li { font-size: .78rem; color: #adb5bd; display: flex; align-items: center; gap: 6px; margin-bottom: 3px; transition: color .2s; }
        .req-list li.met { color: var(--primary); }
        .req-list li i { font-size: .7rem; }

        .alert { border-radius: 12px; font-size: .9rem; }
    </style>
</head>
<body>

<a href="{{ route('home') }}" class="back-home">
    <i class="bi bi-arrow-left me-1"></i> Back to Home
</a>

<div class="auth-card">
    <div class="brand-logo">♻️</div>
    <div class="brand-name">Create Account</div>
    <div class="brand-sub">Join EcoWaste and start booking collections</div>

    @if($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-2 mb-4 py-2">
        <i class="bi bi-exclamation-circle-fill mt-1"></i>
        <ul class="mb-0 ps-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" id="registerForm" novalidate>
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small">Full Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="John Smith"
                       value="{{ old('name') }}"
                       autocomplete="name" required autofocus>
            </div>
            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="you@example.com"
                       value="{{ old('email') }}"
                       autocomplete="email" required>
            </div>
            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <div class="password-wrapper flex-grow-1">
                    <input type="password" name="password" id="regPassword"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Min. 8 characters"
                           autocomplete="new-password" required
                           oninput="checkStrength(this.value)">
                    <button type="button" class="toggle-password" onclick="togglePwd('regPassword', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            {{-- Strength bar --}}
            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
            <div class="strength-label" id="strengthLabel" style="color:#adb5bd">Enter a password</div>
            {{-- Requirements --}}
            <ul class="req-list mt-2" id="reqList">
                <li id="req-len"><i class="bi bi-circle-fill"></i> At least 8 characters</li>
                <li id="req-upper"><i class="bi bi-circle-fill"></i> One uppercase letter</li>
                <li id="req-num"><i class="bi bi-circle-fill"></i> One number</li>
                <li id="req-special"><i class="bi bi-circle-fill"></i> One special character</li>
            </ul>
            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label class="form-label fw-semibold small">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <div class="password-wrapper flex-grow-1">
                    <input type="password" name="password_confirmation" id="regPasswordConfirm"
                           class="form-control"
                           placeholder="Repeat your password"
                           autocomplete="new-password" required
                           oninput="checkMatch()">
                    <button type="button" class="toggle-password" onclick="togglePwd('regPasswordConfirm', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div id="matchMsg" class="small mt-1" style="display:none"></div>
        </div>

        <button type="submit" class="btn-eco" id="registerBtn">
            <i class="bi bi-person-plus me-2"></i>Create Account
        </button>
    </form>

    <div class="divider">or</div>

    <div class="text-center small">
        Already have an account?
        <a href="{{ route('login') }}" class="link-eco">Sign in</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Toggle password visibility ───────────────────────────────────
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

// ── Password strength checker ────────────────────────────────────
function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');

    const checks = {
        'req-len':     val.length >= 8,
        'req-upper':   /[A-Z]/.test(val),
        'req-num':     /[0-9]/.test(val),
        'req-special': /[^A-Za-z0-9]/.test(val),
    };

    let score = Object.values(checks).filter(Boolean).length;

    // Update requirement list
    Object.entries(checks).forEach(([id, met]) => {
        const li   = document.getElementById(id);
        const icon = li.querySelector('i');
        li.classList.toggle('met', met);
        icon.className = met ? 'bi bi-check-circle-fill' : 'bi bi-circle-fill';
    });

    // Update bar
    const levels = [
        { pct: '0%',   color: '#e9ecef', text: 'Enter a password',  textColor: '#adb5bd' },
        { pct: '25%',  color: '#dc3545', text: 'Weak',              textColor: '#dc3545' },
        { pct: '50%',  color: '#fd7e14', text: 'Fair',              textColor: '#fd7e14' },
        { pct: '75%',  color: '#ffc107', text: 'Good',              textColor: '#856404' },
        { pct: '100%', color: '#2d6a4f', text: 'Strong ✓',          textColor: '#2d6a4f' },
    ];
    const lvl = val.length === 0 ? levels[0] : levels[score];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.textColor;
}

// ── Password match checker ───────────────────────────────────────
function checkMatch() {
    const pwd     = document.getElementById('regPassword').value;
    const confirm = document.getElementById('regPasswordConfirm').value;
    const msg     = document.getElementById('matchMsg');

    if (!confirm) { msg.style.display = 'none'; return; }

    msg.style.display = 'block';
    if (pwd === confirm) {
        msg.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i><span class="text-success">Passwords match</span>';
    } else {
        msg.innerHTML = '<i class="bi bi-x-circle-fill text-danger me-1"></i><span class="text-danger">Passwords do not match</span>';
    }
}

// ── Submit loading state ─────────────────────────────────────────
document.getElementById('registerForm').addEventListener('submit', function (e) {
    const pwd     = document.getElementById('regPassword').value;
    const confirm = document.getElementById('regPasswordConfirm').value;
    if (pwd !== confirm) {
        e.preventDefault();
        document.getElementById('matchMsg').innerHTML =
            '<i class="bi bi-x-circle-fill text-danger me-1"></i><span class="text-danger">Passwords do not match</span>';
        document.getElementById('matchMsg').style.display = 'block';
        return;
    }
    const btn = document.getElementById('registerBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating account...';
});
</script>
</body>
</html>
