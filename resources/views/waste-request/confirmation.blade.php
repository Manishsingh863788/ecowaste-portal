@extends('layouts.app')
@section('title', 'Request Confirmed')

@section('content')
<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container text-white text-center">
        <div class="animate__animated animate__bounceIn" style="font-size:5rem">✅</div>
        <h1 class="fw-bold display-5 mt-3">Request Submitted!</h1>
        <p class="opacity-75 fs-5">Your waste collection has been booked successfully.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <!-- Tracking Number Card -->
            <div class="card p-4 mb-4 text-center" style="border: 3px solid var(--primary-light); background: #f0faf5;">
                <p class="text-muted mb-1">Your Tracking Number</p>
                <div class="display-5 fw-bold" style="color: var(--primary); letter-spacing: 3px; font-family: monospace;">
                    {{ $wasteRequest->tracking_number }}
                </div>
                <p class="text-muted small mt-2 mb-3">Save this number to track your request status</p>
                <button class="btn btn-outline-eco mx-auto" onclick="copyTracking('{{ $wasteRequest->tracking_number }}')" id="copyBtn">
                    <i class="bi bi-clipboard me-2"></i>Copy Tracking Number
                </button>
            </div>

            <!-- Request Details -->
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-clipboard-data me-2" style="color:var(--primary)"></i>Request Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Full Name</small>
                            <strong>{{ $wasteRequest->full_name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $wasteRequest->email }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Service Type</small>
                            <strong>{{ $wasteRequest->request_type_label }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge badge-{{ $wasteRequest->status }} px-3 py-2 rounded-pill">
                                {{ ucfirst(str_replace('_', ' ', $wasteRequest->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Preferred Date</small>
                            <strong>{{ $wasteRequest->preferred_date->format('D, d M Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Preferred Time</small>
                            <strong>{{ ucfirst($wasteRequest->preferred_time) }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Collection Address</small>
                            <strong>{{ $wasteRequest->address }}, {{ $wasteRequest->city }}, {{ $wasteRequest->postcode }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#f8f9fa">
                            <small class="text-muted d-block">Waste Categories</small>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                @foreach($wasteRequest->waste_categories as $cat)
                                <span class="badge rounded-pill px-3 py-2" style="background:#d8f3dc;color:var(--primary)">
                                    {{ ucfirst(str_replace('_', ' ', $cat)) }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if($wasteRequest->is_urgent)
                    <div class="col-12">
                        <div class="alert alert-warning d-flex align-items-center gap-2 mb-0">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>Urgent Request</strong> — Priority collection within 24 hours
                        </div>
                    </div>
                    @endif
                    @if($wasteRequest->recurring)
                    <div class="col-12">
                        <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                            <i class="bi bi-arrow-repeat"></i>
                            <strong>Recurring:</strong> {{ ucfirst($wasteRequest->recurring_frequency) }} collection scheduled
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>What Happens Next</h5>
                <div class="timeline">
                    @php
                    $steps = [
                        ['label'=>'Request Submitted',   'desc'=>'Your request has been received.',                    'done'=>true],
                        ['label'=>'Confirmation',        'desc'=>'We\'ll confirm your slot within 2 hours.',           'done'=>false],
                        ['label'=>'Collection Day',      'desc'=>'Our team arrives at your chosen time.',              'done'=>false],
                        ['label'=>'Waste Processed',     'desc'=>'Your waste is sorted and recycled responsibly.',     'done'=>false],
                        ['label'=>'Completed',           'desc'=>'Request marked complete. Thank you!',                'done'=>false],
                    ];
                    @endphp
                    @foreach($steps as $s)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $s['done'] ? 'active' : '' }}"></div>
                        <div class="ps-2">
                            <strong class="{{ $s['done'] ? '' : 'text-muted' }}">{{ $s['label'] }}</strong>
                            <p class="text-muted small mb-0">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('request.track') }}" class="btn btn-eco btn-lg">
                    <i class="bi bi-search me-2"></i>Track This Request
                </a>
                <a href="{{ route('request.create') }}" class="btn btn-outline-eco btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>New Request
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                    <i class="bi bi-house me-2"></i>Home
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyTracking(number) {
    navigator.clipboard.writeText(number).then(() => {
        const btn = document.getElementById('copyBtn');
        btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Copied!';
        btn.classList.add('btn-eco');
        btn.classList.remove('btn-outline-eco');
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-clipboard me-2"></i>Copy Tracking Number';
            btn.classList.remove('btn-eco');
            btn.classList.add('btn-outline-eco');
        }, 2500);
    });
}
</script>
@endpush
