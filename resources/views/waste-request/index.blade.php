@extends('layouts.app')
@section('title', 'All Requests')

@section('content')
<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container text-white">
        <h1 class="fw-bold display-5 mb-2">📋 All Requests</h1>
        <p class="opacity-75">Manage and update waste collection requests</p>
    </div>
</div>

<div class="container py-5">

    <!-- Filters -->
    <div class="card p-4 mb-4">
        <form method="GET" action="{{ route('requests.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, email or tracking number..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    @foreach(['collection','recycling','bulky_item','hazardous','garden_waste','electronic_waste'] as $t)
                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $t)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-eco w-100">Filter</button>
                <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary">✕</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background:white;border-bottom:2px solid #f0faf5">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-list-ul me-2" style="color:var(--primary)"></i>
                {{ $requests->total() }} Request(s) Found
            </h6>
            <a href="{{ route('request.create') }}" class="btn btn-eco btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Request
            </a>
        </div>

        @if($requests->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:4rem">📭</div>
            <h5 class="text-muted mt-3">No requests found</h5>
            <a href="{{ route('request.create') }}" class="btn btn-eco mt-3">Book First Collection</a>
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
                        <th>Urgent</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td class="px-4">
                            <code style="color:var(--primary);font-size:.85rem">{{ $req->tracking_number }}</code>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $req->full_name }}</div>
                            <small class="text-muted">{{ $req->email }}</small>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2" style="background:#d8f3dc;color:var(--primary)">
                                {{ $req->request_type_label }}
                            </span>
                        </td>
                        <td>
                            <div>{{ $req->preferred_date->format('d M Y') }}</div>
                            <small class="text-muted">{{ ucfirst($req->preferred_time) }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $req->status }} px-3 py-2 rounded-pill">
                                {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                            </span>
                        </td>
                        <td>
                            @if($req->is_urgent)
                            <span class="badge bg-warning text-dark rounded-pill px-2">🚨 Urgent</span>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <!-- Update Status -->
                                <form action="{{ route('requests.updateStatus', $req) }}" method="POST" class="d-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" style="width:130px">
                                        @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $req->status == $s ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-eco px-3">✓</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($requests->hasPages())
        <div class="d-flex justify-content-center py-4">
            {{ $requests->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
