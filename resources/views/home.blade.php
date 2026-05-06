@extends('layouts.app')
@section('title', 'Home')

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 animate__animated animate__fadeInLeft">
                @if(isset($visitCount) && $visitCount > 1)
                <div class="alert alert-light d-inline-flex align-items-center gap-2 mb-4 py-2 px-3 rounded-pill" style="font-size:.9rem">
                    <span>👋</span>
                    <span>Welcome back! This is your <strong>visit #{{ $visitCount }}</strong>
                    @if($lastVisit) — last seen {{ \Carbon\Carbon::parse($lastVisit)->diffForHumans() }}@endif</span>
                </div>
                @endif
                <h1 class="display-4 fw-bold mb-4 lh-sm">
                    Smart Waste Management<br>
                    <span style="color: var(--accent)">for a Greener Future</span>
                </h1>
                <p class="lead mb-5 opacity-90">
                    Book waste collections, schedule recycling pickups, and track your requests — all in one place. Join thousands making a difference.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('request.create') }}" class="btn btn-eco btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Book a Collection
                    </a>
                    <a href="{{ route('request.track') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="bi bi-search me-2"></i>Track Request
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0 animate__animated animate__fadeInRight">
                <div style="font-size: 10rem; line-height:1; filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3))">♻️</div>
                <p class="mt-3 opacity-75 fs-5">Reduce · Reuse · Recycle</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3 fade-in-up">
                <div class="stat-card">
                    <div class="stat-number" id="counter-requests">0</div>
                    <div class="stat-label"><i class="bi bi-truck text-success me-1"></i>Total Requests</div>
                </div>
            </div>
            <div class="col-6 col-md-3 fade-in-up">
                <div class="stat-card">
                    <div class="stat-number" id="counter-completed">0</div>
                    <div class="stat-label"><i class="bi bi-check-circle text-success me-1"></i>Completed</div>
                </div>
            </div>
            <div class="col-6 col-md-3 fade-in-up">
                <div class="stat-card">
                    <div class="stat-number" id="counter-recycling">0</div>
                    <div class="stat-label"><i class="bi bi-recycle text-success me-1"></i>Recycling Jobs</div>
                </div>
            </div>
            <div class="col-6 col-md-3 fade-in-up">
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label"><i class="bi bi-clock text-success me-1"></i>Online Booking</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#d8f3dc;color:var(--primary)">Our Services</span>
            <h2 class="fw-bold display-6">What We Collect</h2>
            <p class="text-muted">Choose the right service for your waste type</p>
        </div>
        <div class="row g-4">
            @php
            $services = [
                ['icon'=>'🗑️','title'=>'General Collection','desc'=>'Regular household and commercial waste collection on your schedule.','color'=>'#d8f3dc','type'=>'collection'],
                ['icon'=>'♻️','title'=>'Recycling','desc'=>'Paper, plastic, glass, and metal — sorted and recycled responsibly.','color'=>'#cff4fc','type'=>'recycling'],
                ['icon'=>'🛋️','title'=>'Bulky Items','desc'=>'Sofas, fridges, mattresses — we handle the heavy lifting for you.','color'=>'#fff3cd','type'=>'bulky_item'],
                ['icon'=>'⚠️','title'=>'Hazardous Waste','desc'=>'Safe disposal of chemicals, paints, batteries, and other hazardous materials.','color'=>'#f8d7da','type'=>'hazardous'],
                ['icon'=>'🌿','title'=>'Garden Waste','desc'=>'Grass cuttings, branches, leaves — composted or recycled sustainably.','color'=>'#d1e7dd','type'=>'garden_waste'],
                ['icon'=>'💻','title'=>'Electronic Waste','desc'=>'Phones, laptops, TVs — responsibly recycled to recover valuable materials.','color'=>'#e2d9f3','type'=>'electronic_waste'],
            ];
            @endphp
            @foreach($services as $service)
            <div class="col-md-6 col-lg-4 fade-in-up">
                <div class="card h-100 p-4">
                    <div class="service-icon mb-3" style="background:{{ $service['color'] }}; width:70px;height:70px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;">
                        {{ $service['icon'] }}
                    </div>
                    <h5 class="fw-bold">{{ $service['title'] }}</h5>
                    <p class="text-muted small mb-4">{{ $service['desc'] }}</p>
                    <a href="{{ route('request.create') }}?type={{ $service['type'] }}" class="btn btn-outline-eco mt-auto">
                        Book Now <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#d8f3dc;color:var(--primary)">Simple Process</span>
            <h2 class="fw-bold display-6">How It Works</h2>
            <p class="text-muted">Book your collection in under 3 minutes</p>
        </div>
        <div class="row g-4 text-center">
            @php
            $steps = [
                ['num'=>'1','icon'=>'bi-pencil-square','title'=>'Fill the Form','desc'=>'Tell us what waste you have, where you are, and when suits you best.'],
                ['num'=>'2','icon'=>'bi-calendar-check','title'=>'Get Confirmed','desc'=>'Receive your tracking number instantly. We confirm your slot within 2 hours.'],
                ['num'=>'3','icon'=>'bi-truck','title'=>'We Collect','desc'=>'Our team arrives at your chosen time. No fuss, no mess left behind.'],
                ['num'=>'4','icon'=>'bi-recycle','title'=>'We Recycle','desc'=>'Your waste is sorted, recycled, or disposed of responsibly and sustainably.'],
            ];
            @endphp
            @foreach($steps as $step)
            <div class="col-6 col-md-3 fade-in-up">
                <div class="step-number">{{ $step['num'] }}</div>
                <div class="fs-2 mb-2"><i class="bi {{ $step['icon'] }}" style="color:var(--primary)"></i></div>
                <h6 class="fw-bold">{{ $step['title'] }}</h6>
                <p class="text-muted small">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('request.create') }}" class="btn btn-eco btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Start Your Request
            </a>
        </div>
    </div>
</section>

<!-- Recycling Tips -->
@if($tips->count())
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#d8f3dc;color:var(--primary)">Eco Tips</span>
            <h2 class="fw-bold display-6">Recycling Tips</h2>
            <p class="text-muted">Small changes, big impact</p>
        </div>
        <div class="row g-4">
            @foreach($tips as $tip)
            <div class="col-md-6 col-lg-4 fade-in-up">
                <div class="card tip-card h-100 p-4">
                    <div class="tip-emoji mb-3">{{ $tip->icon }}</div>
                    <span class="badge mb-2" style="background:#d8f3dc;color:var(--primary);width:fit-content">{{ $tip->category }}</span>
                    <h6 class="fw-bold">{{ $tip->title }}</h6>
                    <p class="text-muted small mb-0">{{ $tip->content }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Quick Track Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--secondary), var(--primary));">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center text-white fade-in-up">
                <h2 class="fw-bold mb-3">Track Your Request</h2>
                <p class="opacity-75 mb-4">Already submitted a request? Enter your tracking number to check the status.</p>
                <form action="{{ route('request.track') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="tracking_number" class="form-control form-control-lg rounded-pill"
                           placeholder="e.g. WM-ABC12345" required>
                    <button type="submit" class="btn btn-eco btn-lg px-4 text-nowrap">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Animated counters
function animateCounter(id, target) {
    const el = document.getElementById(id);
    if (!el) return;
    let current = 0;
    const step = Math.max(1, Math.floor(target / 60));
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current.toLocaleString();
        if (current >= target) clearInterval(timer);
    }, 30);
}

const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            animateCounter('counter-requests', {{ $totalRequests }});
            animateCounter('counter-completed', {{ $completedRequests }});
            animateCounter('counter-recycling', {{ $recyclingRequests }});
            statsObserver.disconnect();
        }
    });
}, { threshold: 0.3 });

const statsSection = document.getElementById('counter-requests');
if (statsSection) statsObserver.observe(statsSection.closest('.row'));
</script>
@endpush
