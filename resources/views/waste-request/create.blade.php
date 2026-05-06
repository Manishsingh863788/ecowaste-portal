@extends('layouts.app')
@section('title', 'New Waste Collection Request')

@section('content')

<!-- Page Header -->
<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container text-white text-center">
        <h1 class="fw-bold display-5 mb-2">📋 Book a Collection</h1>
        <p class="opacity-75 fs-5">Fill in the form below — takes less than 3 minutes</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2 small fw-semibold text-muted">
                    <span id="step-label">Step 1 of 3: Your Details</span>
                    <span id="step-percent">33%</span>
                </div>
                <div class="form-progress">
                    <div class="form-progress-bar" id="progressBar" style="width: 33%"></div>
                </div>
                <div class="d-flex justify-content-between">
                    @foreach(['Your Details','Waste Info','Schedule'] as $i => $label)
                    <div class="text-center" style="flex:1">
                        <div class="step-indicator mx-auto mb-1" id="step-dot-{{ $i+1 }}"
                             style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:700;
                             background:{{ $i===0 ? 'var(--primary)' : '#dee2e6' }};
                             color:{{ $i===0 ? 'white' : '#6c757d' }};
                             transition:all .3s;">{{ $i+1 }}</div>
                        <small class="text-muted d-none d-md-block">{{ $label }}</small>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following:</h6>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('request.store') }}" method="POST" id="wasteForm" novalidate>
                @csrf

                <!-- ── STEP 1: Personal Details ── -->
                <div class="card p-4 p-md-5 mb-4" id="step1">
                    <h4 class="fw-bold mb-4"><i class="bi bi-person-circle me-2" style="color:var(--primary)"></i>Your Details</h4>

                    @if(isset($savedData) && count($savedData))
                    <div class="alert alert-info d-flex align-items-center gap-2 mb-4 py-2 px-3 rounded-3" style="font-size:.9rem">
                        <i class="bi bi-magic fs-5"></i>
                        <span>We've pre-filled your details from your last visit. <button type="button" class="btn btn-sm btn-link p-0" onclick="clearSavedData()">Clear</button></span>
                    </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control form-control-lg @error('full_name') is-invalid @enderror"
                                   placeholder="John Smith"
                                   value="{{ old('full_name', $savedData['full_name'] ?? '') }}" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   placeholder="john@example.com"
                                   value="{{ old('email', $savedData['email'] ?? '') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                   placeholder="07700 900000"
                                   value="{{ old('phone', $savedData['phone'] ?? '') }}" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Street Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control form-control-lg @error('address') is-invalid @enderror"
                                   placeholder="12 Green Lane"
                                   value="{{ old('address', $savedData['address'] ?? '') }}" required>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control form-control-lg @error('city') is-invalid @enderror"
                                   placeholder="London"
                                   value="{{ old('city', $savedData['city'] ?? '') }}" required>
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Postcode <span class="text-danger">*</span></label>
                            <input type="text" name="postcode" class="form-control form-control-lg @error('postcode') is-invalid @enderror"
                                   placeholder="SW1A 1AA"
                                   value="{{ old('postcode', $savedData['postcode'] ?? '') }}" required
                                   style="text-transform:uppercase">
                            @error('postcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-eco btn-lg px-5" onclick="goToStep(2)">
                            Next <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- ── STEP 2: Waste Information ── -->
                <div class="card p-4 p-md-5 mb-4 d-none" id="step2">
                    <h4 class="fw-bold mb-4"><i class="bi bi-recycle me-2" style="color:var(--primary)"></i>Waste Information</h4>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Request Type <span class="text-danger">*</span></label>
                        <select name="request_type" id="requestType" class="form-select form-select-lg @error('request_type') is-invalid @enderror" required>
                            <option value="">— Select a service —</option>
                            <option value="collection"       {{ old('request_type', request('type')) == 'collection'       ? 'selected' : '' }}>🗑️ General Collection</option>
                            <option value="recycling"        {{ old('request_type', request('type')) == 'recycling'        ? 'selected' : '' }}>♻️ Recycling</option>
                            <option value="bulky_item"       {{ old('request_type', request('type')) == 'bulky_item'       ? 'selected' : '' }}>🛋️ Bulky Item</option>
                            <option value="hazardous"        {{ old('request_type', request('type')) == 'hazardous'        ? 'selected' : '' }}>⚠️ Hazardous Waste</option>
                            <option value="garden_waste"     {{ old('request_type', request('type')) == 'garden_waste'     ? 'selected' : '' }}>🌿 Garden Waste</option>
                            <option value="electronic_waste" {{ old('request_type', request('type')) == 'electronic_waste' ? 'selected' : '' }}>💻 Electronic Waste</option>
                        </select>
                        @error('request_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Waste Categories -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Waste Categories <span class="text-danger">*</span> <small class="text-muted fw-normal">(select all that apply)</small></label>
                        @error('waste_categories')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                        <div class="row g-2" id="categoryGrid">
                            @php
                            $categories = [
                                ['value'=>'paper',      'label'=>'Paper',      'icon'=>'📄'],
                                ['value'=>'plastic',    'label'=>'Plastic',    'icon'=>'🧴'],
                                ['value'=>'glass',      'label'=>'Glass',      'icon'=>'🍾'],
                                ['value'=>'metal',      'label'=>'Metal',      'icon'=>'🥫'],
                                ['value'=>'food_waste', 'label'=>'Food Waste', 'icon'=>'🍎'],
                                ['value'=>'garden_waste','label'=>'Garden',    'icon'=>'🌿'],
                                ['value'=>'furniture',  'label'=>'Furniture',  'icon'=>'🛋️'],
                                ['value'=>'appliances', 'label'=>'Appliances', 'icon'=>'🧺'],
                                ['value'=>'electronics','label'=>'Electronics','icon'=>'💻'],
                                ['value'=>'batteries',  'label'=>'Batteries',  'icon'=>'🔋'],
                                ['value'=>'chemicals',  'label'=>'Chemicals',  'icon'=>'⚗️'],
                                ['value'=>'clothing',   'label'=>'Clothing',   'icon'=>'👕'],
                            ];
                            $oldCats = old('waste_categories', []);
                            @endphp
                            @foreach($categories as $cat)
                            <div class="col-6 col-md-4 col-lg-3">
                                <label class="waste-category-card w-100 {{ in_array($cat['value'], $oldCats) ? 'selected' : '' }}">
                                    <input type="checkbox" name="waste_categories[]" value="{{ $cat['value'] }}"
                                           {{ in_array($cat['value'], $oldCats) ? 'checked' : '' }}>
                                    <div class="fs-3 mb-1">{{ $cat['icon'] }}</div>
                                    <div class="small fw-semibold">{{ $cat['label'] }}</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="3" placeholder="Briefly describe the waste items (optional)..."
                                      maxlength="1000">{{ old('description') }}</textarea>
                            <div class="form-text">Max 1000 characters</div>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estimated Weight (kg)</label>
                            <input type="number" name="estimated_weight_kg" class="form-control form-control-lg @error('estimated_weight_kg') is-invalid @enderror"
                                   placeholder="e.g. 25" min="0.1" max="10000" step="0.1"
                                   value="{{ old('estimated_weight_kg') }}">
                            @error('estimated_weight_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch p-3 rounded-3 w-100" style="background:#fff3cd">
                                <input class="form-check-input" type="checkbox" name="is_urgent" id="isUrgent" value="1"
                                       {{ old('is_urgent') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isUrgent">
                                    🚨 Mark as Urgent
                                    <small class="d-block text-muted fw-normal">Priority collection within 24h</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="goToStep(1)">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </button>
                        <button type="button" class="btn btn-eco btn-lg px-5" onclick="goToStep(3)">
                            Next <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- ── STEP 3: Schedule ── -->
                <div class="card p-4 p-md-5 mb-4 d-none" id="step3">
                    <h4 class="fw-bold mb-4"><i class="bi bi-calendar3 me-2" style="color:var(--primary)"></i>Schedule Your Collection</h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preferred Date <span class="text-danger">*</span></label>
                            <input type="date" name="preferred_date" id="preferredDate"
                                   class="form-control form-control-lg @error('preferred_date') is-invalid @enderror"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('preferred_date') }}" required>
                            @error('preferred_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preferred Time <span class="text-danger">*</span></label>
                            <div class="row g-2 mt-1">
                                @foreach(['morning'=>['🌅','Morning','8am–12pm'],'afternoon'=>['☀️','Afternoon','12pm–5pm'],'evening'=>['🌆','Evening','5pm–8pm']] as $val => $info)
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="preferred_time" id="time_{{ $val }}" value="{{ $val }}"
                                           {{ old('preferred_time') == $val ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-secondary w-100 text-center py-3" for="time_{{ $val }}" style="border-radius:12px">
                                        <div class="fs-4">{{ $info[0] }}</div>
                                        <div class="fw-semibold small">{{ $info[1] }}</div>
                                        <div class="text-muted" style="font-size:.7rem">{{ $info[2] }}</div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('preferred_time')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <!-- Recurring -->
                        <div class="col-12">
                            <div class="card p-3" style="background:#f0faf5;border:2px solid #d8f3dc">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="recurring" id="recurring" value="1"
                                           {{ old('recurring') ? 'checked' : '' }} onchange="toggleRecurring(this)">
                                    <label class="form-check-label fw-semibold" for="recurring">
                                        🔄 Set as Recurring Collection
                                    </label>
                                </div>
                                <div id="recurringOptions" class="{{ old('recurring') ? '' : 'd-none' }}">
                                    <label class="form-label small fw-semibold">Frequency</label>
                                    <select name="recurring_frequency" class="form-select">
                                        <option value="weekly"      {{ old('recurring_frequency') == 'weekly'      ? 'selected' : '' }}>Weekly</option>
                                        <option value="fortnightly" {{ old('recurring_frequency') == 'fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                                        <option value="monthly"     {{ old('recurring_frequency') == 'monthly'     ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Special Instructions</label>
                            <textarea name="special_instructions" class="form-control @error('special_instructions') is-invalid @enderror"
                                      rows="3" placeholder="e.g. Gate code is 1234, please ring doorbell, waste is in back garden..."
                                      maxlength="500">{{ old('special_instructions') }}</textarea>
                            @error('special_instructions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Summary Preview -->
                    <div class="card mt-4 p-3" style="background:#f8fffe;border:2px dashed var(--primary-light)" id="summaryBox">
                        <h6 class="fw-bold mb-3"><i class="bi bi-clipboard-check me-2" style="color:var(--primary)"></i>Request Summary</h6>
                        <div class="row g-2 small" id="summaryContent">
                            <div class="col-6"><span class="text-muted">Name:</span> <span id="s-name" class="fw-semibold">—</span></div>
                            <div class="col-6"><span class="text-muted">Email:</span> <span id="s-email" class="fw-semibold">—</span></div>
                            <div class="col-6"><span class="text-muted">Type:</span> <span id="s-type" class="fw-semibold">—</span></div>
                            <div class="col-6"><span class="text-muted">Date:</span> <span id="s-date" class="fw-semibold">—</span></div>
                            <div class="col-12"><span class="text-muted">Address:</span> <span id="s-address" class="fw-semibold">—</span></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="goToStep(2)">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </button>
                        <button type="submit" class="btn btn-eco btn-lg px-5" id="submitBtn">
                            <i class="bi bi-send-fill me-2"></i>Submit Request
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentStep = 1;

// ── Step navigation ──────────────────────────────────────────────
function goToStep(step) {
    if (step > currentStep && !validateStep(currentStep)) return;

    document.getElementById('step' + currentStep).classList.add('d-none');
    document.getElementById('step' + step).classList.remove('d-none');
    document.getElementById('step' + step).scrollIntoView({ behavior: 'smooth', block: 'start' });

    currentStep = step;
    updateProgress();
}

function updateProgress() {
    const pct = Math.round((currentStep / 3) * 100);
    document.getElementById('progressBar').style.width = pct + '%';
    document.getElementById('step-percent').textContent = pct + '%';
    const labels = ['Your Details', 'Waste Info', 'Schedule'];
    document.getElementById('step-label').textContent = `Step ${currentStep} of 3: ${labels[currentStep-1]}`;

    for (let i = 1; i <= 3; i++) {
        const dot = document.getElementById('step-dot-' + i);
        if (i < currentStep) {
            dot.style.background = 'var(--primary-light)';
            dot.style.color = 'white';
            dot.innerHTML = '<i class="bi bi-check"></i>';
        } else if (i === currentStep) {
            dot.style.background = 'var(--primary)';
            dot.style.color = 'white';
            dot.textContent = i;
        } else {
            dot.style.background = '#dee2e6';
            dot.style.color = '#6c757d';
            dot.textContent = i;
        }
    }

    if (currentStep === 3) updateSummary();
}

// ── Step validation ──────────────────────────────────────────────
function validateStep(step) {
    const stepEl = document.getElementById('step' + step);
    const inputs = stepEl.querySelectorAll('[required]');
    let valid = true;

    inputs.forEach(input => {
        input.classList.remove('is-invalid');
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            valid = false;
        }
    });

    if (step === 2) {
        const checked = document.querySelectorAll('input[name="waste_categories[]"]:checked');
        if (checked.length === 0) {
            alert('Please select at least one waste category.');
            valid = false;
        }
    }

    return valid;
}

// ── Waste category card toggle ───────────────────────────────────
document.querySelectorAll('.waste-category-card').forEach(card => {
    card.addEventListener('click', () => {
        const cb = card.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        card.classList.toggle('selected', cb.checked);
    });
});

// ── Recurring toggle ─────────────────────────────────────────────
function toggleRecurring(el) {
    document.getElementById('recurringOptions').classList.toggle('d-none', !el.checked);
}

// ── Summary update ───────────────────────────────────────────────
function updateSummary() {
    document.getElementById('s-name').textContent    = document.querySelector('[name="full_name"]').value || '—';
    document.getElementById('s-email').textContent   = document.querySelector('[name="email"]').value || '—';
    const typeEl = document.getElementById('requestType');
    document.getElementById('s-type').textContent    = typeEl.options[typeEl.selectedIndex]?.text || '—';
    document.getElementById('s-date').textContent    = document.getElementById('preferredDate').value || '—';
    const addr = [
        document.querySelector('[name="address"]').value,
        document.querySelector('[name="city"]').value,
        document.querySelector('[name="postcode"]').value
    ].filter(Boolean).join(', ');
    document.getElementById('s-address').textContent = addr || '—';
}

// ── Clear saved cookie data ──────────────────────────────────────
function clearSavedData() {
    document.cookie = 'last_request_data=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/';
    location.reload();
}

// ── Postcode uppercase ───────────────────────────────────────────
document.querySelector('[name="postcode"]').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});

// ── Submit button loading state ──────────────────────────────────
document.getElementById('wasteForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
});

// ── If validation failed, show correct step ──────────────────────
@if($errors->any())
    @if($errors->has('full_name') || $errors->has('email') || $errors->has('phone') || $errors->has('address') || $errors->has('city') || $errors->has('postcode'))
        // stay on step 1
    @elseif($errors->has('request_type') || $errors->has('waste_categories') || $errors->has('description'))
        goToStep(2);
    @else
        goToStep(3);
    @endif
@endif
</script>
@endpush
