<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EcoWaste Portal') | Waste Management & Recycling</title>
    <meta name="description" content="Book waste collection and recycling services online. Fast, easy, eco-friendly.">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        :root {
            --primary:   #2d6a4f;
            --primary-light: #52b788;
            --secondary: #1b4332;
            --accent:    #95d5b2;
            --warning:   #f4a261;
            --danger:    #e63946;
            --light-bg:  #f8fffe;
            --card-shadow: 0 4px 24px rgba(45,106,79,0.10);
        }

        * { font-family: 'Inter', sans-serif; }

        body { background: var(--light-bg); color: #1a1a2e; }

        /* ── Navbar ── */
        .navbar-brand span { color: var(--primary-light); }
        .navbar { background: var(--secondary) !important; box-shadow: 0 2px 12px rgba(0,0,0,0.15); }
        .navbar .nav-link { color: #d8f3dc !important; font-weight: 500; transition: color .2s; }
        .navbar .nav-link:hover, .navbar .nav-link.active { color: var(--accent) !important; }
        .navbar-toggler { border-color: var(--accent); }

        /* ── Hero ── */
        .hero-section {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 60%, var(--primary-light) 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2395d5b2' fill-opacity='0.07'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ── Cards ── */
        .card { border: none; border-radius: 16px; box-shadow: var(--card-shadow); transition: transform .25s, box-shadow .25s; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(45,106,79,0.18); }

        /* ── Buttons ── */
        .btn-eco {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; border: none; border-radius: 50px;
            padding: 12px 32px; font-weight: 600; letter-spacing: .5px;
            transition: all .3s; box-shadow: 0 4px 15px rgba(45,106,79,0.3);
        }
        .btn-eco:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(45,106,79,0.45); color: white; }
        .btn-outline-eco {
            border: 2px solid var(--primary); color: var(--primary);
            border-radius: 50px; padding: 10px 28px; font-weight: 600; transition: all .3s;
        }
        .btn-outline-eco:hover { background: var(--primary); color: white; }

        /* ── Stats ── */
        .stat-card { background: white; border-radius: 16px; padding: 28px; text-align: center; box-shadow: var(--card-shadow); }
        .stat-number { font-size: 2.8rem; font-weight: 800; color: var(--primary); line-height: 1; }
        .stat-label  { color: #6c757d; font-size: .9rem; margin-top: 6px; }

        /* ── Service Cards ── */
        .service-icon { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 16px; }

        /* ── Steps ── */
        .step-number { width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 700; margin: 0 auto 12px; }

        /* ── Forms ── */
        .form-control:focus, .form-select:focus { border-color: var(--primary-light); box-shadow: 0 0 0 .2rem rgba(82,183,136,.25); }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }

        /* ── Status badges ── */
        .badge-pending     { background: #fff3cd; color: #856404; }
        .badge-confirmed   { background: #cff4fc; color: #055160; }
        .badge-in_progress { background: #cfe2ff; color: #084298; }
        .badge-completed   { background: #d1e7dd; color: #0a3622; }
        .badge-cancelled   { background: #f8d7da; color: #842029; }

        /* ── Timeline ── */
        .timeline { position: relative; padding-left: 30px; }
        .timeline::before { content: ''; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background: #dee2e6; }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-dot { position: absolute; left: -26px; top: 4px; width: 14px; height: 14px; border-radius: 50%; background: var(--primary); border: 2px solid white; box-shadow: 0 0 0 2px var(--primary); }
        .timeline-dot.active { background: var(--primary-light); box-shadow: 0 0 0 2px var(--primary-light); }

        /* ── Cookie Banner ── */
        #cookieBanner {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 9999;
            background: var(--secondary); color: white;
            padding: 16px 24px; display: none;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
        }

        /* ── Footer ── */
        footer { background: var(--secondary); color: #d8f3dc; }
        footer a { color: var(--accent); text-decoration: none; }
        footer a:hover { color: white; }

        /* ── Tip Cards ── */
        .tip-card { border-left: 4px solid var(--primary-light); }
        .tip-emoji { font-size: 2.5rem; }

        /* ── Scroll to top ── */
        #scrollTop {
            position: fixed; bottom: 80px; right: 24px; z-index: 999;
            width: 44px; height: 44px; border-radius: 50%;
            background: var(--primary); color: white; border: none;
            display: none; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); cursor: pointer;
            transition: all .3s;
        }
        #scrollTop:hover { background: var(--primary-light); transform: translateY(-2px); }

        /* ── Animations ── */
        .fade-in-up { opacity: 0; transform: translateY(30px); transition: opacity .6s ease, transform .6s ease; }
        .fade-in-up.visible { opacity: 1; transform: translateY(0); }

        /* ── Progress bar ── */
        .form-progress { height: 6px; border-radius: 3px; background: #e9ecef; margin-bottom: 32px; }
        .form-progress-bar { height: 100%; border-radius: 3px; background: linear-gradient(90deg, var(--primary), var(--primary-light)); transition: width .4s ease; }

        /* ── Waste category checkboxes ── */
        .waste-category-card {
            border: 2px solid #dee2e6; border-radius: 12px; padding: 14px;
            cursor: pointer; transition: all .2s; text-align: center;
        }
        .waste-category-card:hover { border-color: var(--primary-light); background: #f0faf5; }
        .waste-category-card.selected { border-color: var(--primary); background: #d8f3dc; }
        .waste-category-card input { display: none; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            ♻️ Eco<span>Waste</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('request.create') ? 'active' : '' }}" href="{{ route('request.create') }}">
                        <i class="bi bi-plus-circle me-1"></i>New Request
                    </a>
                </li>
                {{-- Admin only links --}}
                @auth
                @if(Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('request.track') ? 'active' : '' }}" href="{{ route('request.track') }}">
                        <i class="bi bi-search me-1"></i>Track Request
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('requests.index') ? 'active' : '' }}" href="{{ route('requests.index') }}">
                        <i class="bi bi-list-ul me-1"></i>All Requests
                    </a>
                </li>
                @endif
                @endauth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="bi bi-envelope me-1"></i>Contact
                    </a>
                </li>

                {{-- Mobile: auth links inside the collapsible menu --}}
                @auth
                <li class="nav-item d-lg-none border-top border-secondary mt-2 pt-2">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100 border-0 p-0" style="color:#f8d7da!important;padding-left:0!important">
                            <i class="bi bi-box-arrow-right me-1"></i>Sign Out
                        </button>
                    </form>
                </li>
                @else
                <li class="nav-item d-lg-none border-top border-secondary mt-2 pt-2">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="bi bi-person-plus me-1"></i>Register
                    </a>
                </li>
                @endauth
            </ul>

            {{-- Desktop: auth buttons outside the ul --}}
            @auth
            <div class="dropdown ms-3 d-none d-lg-block">
                <button class="btn btn-eco dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" style="min-width:200px">
                    <li>
                        <div class="px-3 py-2 border-bottom">
                            <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ Auth::user()->email }}</div>
                        </div>
                    </li>
                    <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2 text-success"></i>Dashboard</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('request.create') }}"><i class="bi bi-plus-circle me-2 text-success"></i>New Request</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('requests.index') }}"><i class="bi bi-list-ul me-2 text-success"></i>All Requests</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @else
            <div class="d-none d-lg-flex gap-2 ms-3">
                <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-eco">
                    <i class="bi bi-person-plus me-1"></i>Register
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show m-0 rounded-0 text-center" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show m-0 rounded-0 text-center" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@yield('content')

<!-- Footer -->
<footer class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="fw-bold text-white mb-3">♻️ EcoWaste Portal</h5>
                <p class="small opacity-75">Making waste management simple, sustainable, and accessible for everyone. Book collections, track requests, and learn recycling tips.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="fs-5"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="fs-5"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-semibold mb-3">Services</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('request.create') }}">General Collection</a></li>
                    <li class="mb-2"><a href="{{ route('request.create') }}">Recycling</a></li>
                    <li class="mb-2"><a href="{{ route('request.create') }}">Bulky Items</a></li>
                    <li class="mb-2"><a href="{{ route('request.create') }}">Hazardous Waste</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                    <li class="mb-2"><a href="{{ route('request.track') }}">Track Request</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li class="mb-2"><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="text-white fw-semibold mb-3">Contact Info</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>123 Green Street, London, EC1A 1BB</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>0800 123 4567</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@ecowaste.gov.uk</li>
                    <li class="mb-2"><i class="bi bi-clock me-2"></i>Mon–Fri: 8am – 6pm</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="row align-items-center">
            <div class="col-md-6 small opacity-75">
                &copy; {{ date('Y') }} EcoWaste Portal. All rights reserved.
            </div>
            <div class="col-md-6 text-md-end small opacity-75">
                Built with ♻️ for a greener planet
            </div>
        </div>
    </div>
</footer>

<!-- Cookie Consent Banner -->
<div id="cookieBanner">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:1.8rem">🍪</span>
            <div>
                <strong>We use cookies</strong>
                <p class="mb-0 small opacity-75">We use cookies to remember your details and improve your experience. Your data is never sold.</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-light" onclick="declineCookies()">Decline</button>
            <button class="btn btn-sm btn-eco" onclick="acceptCookies()">Accept All</button>
        </div>
    </div>
</div>

<!-- Scroll to Top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ── Cookie helpers ──────────────────────────────────────────────
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/;SameSite=Lax`;
}
function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
}

// ── Cookie Banner ───────────────────────────────────────────────
function acceptCookies() {
    setCookie('cookie_consent', 'accepted', 365);
    document.getElementById('cookieBanner').style.display = 'none';
}
function declineCookies() {
    setCookie('cookie_consent', 'declined', 365);
    document.getElementById('cookieBanner').style.display = 'none';
}
window.addEventListener('DOMContentLoaded', () => {
    if (!getCookie('cookie_consent')) {
        setTimeout(() => {
            document.getElementById('cookieBanner').style.display = 'block';
        }, 1500);
    }
});

// ── Scroll to top button ────────────────────────────────────────
const scrollBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
    scrollBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
});

// ── Intersection Observer for fade-in animations ────────────────
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
</script>

@stack('scripts')
</body>
</html>
