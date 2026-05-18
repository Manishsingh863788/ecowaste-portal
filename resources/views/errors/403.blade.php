@extends('layouts.app')
@section('title', 'Access Denied')

@section('content')
<div style="background: linear-gradient(135deg, var(--secondary), var(--primary)); padding: 60px 0 40px;">
    <div class="container text-white text-center">
        <div style="font-size:5rem">🚫</div>
        <h1 class="fw-bold display-5 mt-3">Access Denied</h1>
        <p class="opacity-75 fs-5">This page is for administrators only.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 text-center">
            <div class="card p-5">
                <div style="font-size:4rem" class="mb-3">🔒</div>
                <h4 class="fw-bold mb-3">Admin Access Required</h4>
                <p class="text-muted mb-4">
                    You don't have permission to view this page.
                    Only administrators can access the request tracking and management features.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-eco">
                        <i class="bi bi-house me-2"></i>Go Home
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-eco">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-eco">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
