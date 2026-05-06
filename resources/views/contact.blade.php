@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container text-white text-center">
        <h1 class="fw-bold display-5 mb-2">📬 Contact Us</h1>
        <p class="opacity-75 fs-5">We're here to help — get in touch with our team</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">

        <!-- Contact Info -->
        <div class="col-lg-4">
            <h4 class="fw-bold mb-4">Get In Touch</h4>
            @php
            $info = [
                ['icon'=>'bi-geo-alt-fill',   'title'=>'Address',       'text'=>'123 Green Street<br>London, EC1A 1BB'],
                ['icon'=>'bi-telephone-fill', 'title'=>'Phone',         'text'=>'0800 123 4567<br><small class="text-muted">Mon–Fri, 8am–6pm</small>'],
                ['icon'=>'bi-envelope-fill',  'title'=>'Email',         'text'=>'info@ecowaste.gov.uk'],
                ['icon'=>'bi-clock-fill',     'title'=>'Opening Hours', 'text'=>'Mon–Fri: 8am – 6pm<br>Sat: 9am – 1pm'],
            ];
            @endphp
            @foreach($info as $item)
            <div class="d-flex gap-3 mb-4">
                <div style="width:48px;height:48px;border-radius:12px;background:#d8f3dc;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi {{ $item['icon'] }} fs-5" style="color:var(--primary)"></i>
                </div>
                <div>
                    <div class="fw-semibold">{{ $item['title'] }}</div>
                    <div class="text-muted small">{!! $item['text'] !!}</div>
                </div>
            </div>
            @endforeach

            <!-- Map placeholder -->
            <div class="rounded-3 overflow-hidden mt-4" style="height:200px;background:linear-gradient(135deg,#d8f3dc,#b7e4c7);display:flex;align-items:center;justify-content:center">
                <div class="text-center">
                    <div style="font-size:3rem">🗺️</div>
                    <p class="text-muted small mt-2">123 Green Street, London</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card p-4 p-md-5">
                <h4 class="fw-bold mb-4"><i class="bi bi-chat-dots me-2" style="color:var(--primary)"></i>Send a Message</h4>

                @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-3 rounded-3 mb-4">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" id="contactForm" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Your Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="John Smith" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   placeholder="john@example.com" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <select name="subject" class="form-select form-select-lg @error('subject') is-invalid @enderror" required>
                                <option value="">— Select a subject —</option>
                                <option value="General Enquiry"         {{ old('subject') == 'General Enquiry'         ? 'selected' : '' }}>General Enquiry</option>
                                <option value="Request Status"          {{ old('subject') == 'Request Status'          ? 'selected' : '' }}>Request Status</option>
                                <option value="Missed Collection"       {{ old('subject') == 'Missed Collection'       ? 'selected' : '' }}>Missed Collection</option>
                                <option value="Recycling Information"   {{ old('subject') == 'Recycling Information'   ? 'selected' : '' }}>Recycling Information</option>
                                <option value="Complaint"               {{ old('subject') == 'Complaint'               ? 'selected' : '' }}>Complaint</option>
                                <option value="Other"                   {{ old('subject') == 'Other'                   ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                      rows="6" placeholder="Tell us how we can help..."
                                      maxlength="2000" id="messageArea" required>{{ old('message') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                <small class="text-muted ms-auto"><span id="charCount">0</span>/2000</small>
                            </div>
                        </div>

                        <!-- Honeypot (spam protection) -->
                        <div style="display:none">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-eco btn-lg px-5" id="contactSubmit">
                                <i class="bi bi-send-fill me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Character counter
const msgArea = document.getElementById('messageArea');
const charCount = document.getElementById('charCount');
if (msgArea) {
    charCount.textContent = msgArea.value.length;
    msgArea.addEventListener('input', () => {
        charCount.textContent = msgArea.value.length;
        charCount.style.color = msgArea.value.length > 1800 ? 'var(--danger)' : '';
    });
}

// Submit loading state
document.getElementById('contactForm').addEventListener('submit', function() {
    const btn = document.getElementById('contactSubmit');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
});
</script>
@endpush
