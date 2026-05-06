@extends('layouts.app')
@section('title', 'Track Your Request')

@section('content')
<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container text-white text-center">
        <h1 class="fw-bold display-5 mb-2">🔍 Track Your Request</h1>
        <p class="opacity-75 fs-5">Enter your tracking number to see the current status</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <!-- Search Form -->
            <div class="card p-4 mb-4">
                <form action="{{ route('request.track') }}" method="POST">
                    @csrf
                    <label class="form-label fw-semibold fs-5">Tracking Number</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text" style="background:var(--primary);color:white;border:none">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="tracking_number" class="form-control"
                               placeholder="e.g. WM-ABC12345"
                               value="{{ request('tracking_number') }}"
                               style="text-transform:uppercase;font-family:monospace;letter-spacing:2px"
                               required>
                        <button type="submit" class="btn btn-eco px-4">Track</button>
                    </div>
                    <div class="form-text mt-2">Your tracking number was provided when you submitted your request.</div>
                </form>
            </div>

            <!-- Error -->
            @if(isset($error) && $error)
            <div class="alert alert-danger d-flex align-items-center gap-3 rounded-3">
                <i class="bi bi-exclamation-circle-fill fs-4"></i>
                <div>{{ $error }}</div>
            </div>
            @endif

            <!-- Result -->
            @if(isset($wasteRequest) && $wasteRequest)
            <div class="card p-4 animate__animated animate__fadeInUp">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $wasteRequest->full_name }}</h5>
                        <code class="fs-6" style="color:var(--primary)">{{ $wasteRequest->tracking_number }}</code>
                    </div>
                    <span class="badge badge-{{ $wasteRequest->status }} px-3 py-2 rounded-pill fs-6">
                        {{ ucfirst(str_replace('_', ' ', $wasteRequest->status)) }}
                    </span>
                </div>

                <!-- Status Progress -->
                @php
                $statusOrder = ['pending','confirmed','in_progress','completed'];
                $currentIdx  = array_search($wasteRequest->status, $statusOrder);
                @endphp
                @if($wasteRequest->status !== 'cancelled')
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        @foreach(['Pending','Confirmed','In Progress','Completed'] as $i => $label)
                        <div class="text-center" style="flex:1">
                            <div class="mx-auto mb-1" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:700;
                                background:{{ $i <= $currentIdx ? 'var(--primary)' : '#dee2e6' }};
                                color:{{ $i <= $currentIdx ? 'white' : '#6c757d' }}">
                                @if($i < $currentIdx)
                                    <i class="bi bi-check"></i>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </div>
                            <small class="text-muted d-none d-md-block" style="font-size:.7rem">{{ $label }}</small>
                        </div>
                        @endforeach
                    </div>
                    <div class="progress" style="height:6px;border-radius:3px">
                        <div class="progress-bar" style="width:{{ max(5, ($currentIdx / 3) * 100) }}%;background:var(--primary)"></div>
                    </div>
                </div>
                @else
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-x-circle-fill me-2"></i>This request has been <strong>cancelled</strong>.
                </div>
                @endif

                <div class="row g-3 small">
                    <div class="col-6">
                        <span class="text-muted">Service:</span><br>
                        <strong>{{ $wasteRequest->request_type_label }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Scheduled:</span><br>
                        <strong>{{ $wasteRequest->preferred_date->format('d M Y') }} — {{ ucfirst($wasteRequest->preferred_time) }}</strong>
                    </div>
                    <div class="col-12">
                        <span class="text-muted">Address:</span><br>
                        <strong>{{ $wasteRequest->address }}, {{ $wasteRequest->city }}, {{ $wasteRequest->postcode }}</strong>
                    </div>
                    <div class="col-12">
                        <span class="text-muted">Categories:</span><br>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @foreach($wasteRequest->waste_categories as $cat)
                            <span class="badge rounded-pill px-2 py-1" style="background:#d8f3dc;color:var(--primary)">
                                {{ ucfirst(str_replace('_', ' ', $cat)) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @if($wasteRequest->is_urgent)
                    <div class="col-12">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                            🚨 Urgent Request
                        </span>
                    </div>
                    @endif
                    <div class="col-12">
                        <span class="text-muted">Submitted:</span>
                        <strong>{{ $wasteRequest->created_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('request.create') }}" class="btn btn-eco">
                        <i class="bi bi-plus-circle me-1"></i>New Request
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-house me-1"></i>Home
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
