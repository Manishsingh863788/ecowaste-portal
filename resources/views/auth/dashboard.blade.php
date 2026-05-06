@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="text-white">
                <p class="mb-1 opacity-75">Welcome back 👋</p>
                <h1 class="fw-bold display-6 mb-1">{{ Auth::user()->name }}</h1>
                <p class="opacity-75 mb-0">
                    <i class="bi bi-envelope me-1"></i>{{ Auth::user()->email }}
                    &nbsp;·&nbsp;
                    <i class="bi bi-calendar me-1"></i>Member since {{ Auth::user()->created_at->format('M Y') }}
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('request.create') }}" class="btn btn-eco">
                    <i class="bi bi-plus-circle me-2"></i>New Request
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light rounded-pill px-4">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- Flash --}}
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
        <i class="bi bi-check-circle-fill fs-5"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Stats Row --}}
    <div class="row g-4 mb-5">
        @php
        $stats = [
            ['label'=>'Total Requests',   'value'=>$totalRequests,  'icon'=>'bi-truck',          'color'=>'#d8f3dc', 'icolor'=>'var(--primary)'],
            ['label'=>'Pending',          'value'=>$pendingCount,   'icon'=>'bi-hourglass-split', 'color'=>'#fff3cd', 'icolor'=>'#856404'],
            ['label'=>'Completed',        'value'=>$completedCount, 'icon'=>'bi-check-circle',   'color'=>'#d1e7dd', 'icolor'=>'#0a3622'],
            ['label'=>'Urgent Active',    'value'=>$urgentCount,    'icon'=>'bi-exclamation-triangle','color'=>'#f8d7da','icolor'=>'#842029'],
        ];
        @endphp
        @foreach($stats as $s)
        <div class="col-6 col-md-3">
            <div class="card p-4 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:52px;height:52px;border-radius:14px;background:{{ $s['color'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi {{ $s['icon'] }} fs-4" style="color:{{ $s['icolor'] }}"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3" style="color:var(--primary);line-height:1">{{ $s['value'] }}</div>
                        <div class="text-muted small">{{ $s['label'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">

        {{-- Recent Requests --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background:white;border-bottom:2px solid #f0faf5">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Recent Requests
                    </h6>
                    <a href="{{ route('requests.index') }}" class="btn btn-outline-eco btn-sm">View All</a>
                </div>
                @if($recentRequests->isEmpty())
                <div class="text-center py-5">
                    <div style="font-size:3rem">📭</div>
                    <p class="text-muted mt-2">No requests yet</p>
                    <a href="{{ route('request.create') }}" class="btn btn-eco btn-sm">Book First Collection</a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8fffe">
                            <tr>
                                <th class="px-4 py-3">Tracking #</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRequests as $req)
                            <tr>
                                <td class="px-4">
                                    <code style="color:var(--primary);font-size:.82rem">{{ $req->tracking_number }}</code>
                                </td>
                                <td class="fw-semibold small">{{ $req->full_name }}</td>
                                <td>
                                    <span class="badge rounded-pill px-2 py-1" style="background:#d8f3dc;color:var(--primary);font-size:.75rem">
                                        {{ $req->request_type_label }}
                                    </span>
                                </td>
                                <td class="small">{{ $req->preferred_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $req->status }} px-2 py-1 rounded-pill" style="font-size:.75rem">
                                        {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4">
            <div class="card p-4 mb-4">
                <h6 class="fw-bold mb-4"><i class="bi bi-lightning-charge me-2" style="color:var(--primary)"></i>Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('request.create') }}" class="btn btn-eco">
                        <i class="bi bi-plus-circle me-2"></i>Book New Collection
                    </a>
                    <a href="{{ route('request.track') }}" class="btn btn-outline-eco">
                        <i class="bi bi-search me-2"></i>Track a Request
                    </a>
                    <a href="{{ route('requests.index') }}" class="btn btn-outline-eco">
                        <i class="bi bi-list-ul me-2"></i>Manage All Requests
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-envelope me-2"></i>Contact Support
                    </a>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="card p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2" style="color:var(--primary)"></i>Account</h6>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:white;font-size:1.4rem;font-weight:700;flex-shrink:0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">
                        <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
