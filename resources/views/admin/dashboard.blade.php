@extends('layouts.app')

@section('title', 'Admin Dashboard - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('home') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Home
    </a>
    
    <div class="admin-hero">
        <h1>Welcome back, Admin! 👋</h1>
        <p>Here's what's happening with your e-commerce platform today</p>
    </div>

    <!-- Statistics -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, var(--red), #d32f3e);">
            <div class="stat-label">Total Stores</div>
            <div class="stat-value">{{ number_format($stats['total_stores']) }}</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, var(--yellow), #e6c200); color: var(--black);">
            <div class="stat-label">Pending Verification</div>
            <div class="stat-value">{{ number_format($stats['pending_stores']) }}</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
            <div class="stat-label">Verified Stores</div>
            <div class="stat-value">{{ number_format($stats['verified_stores']) }}</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <h2 style="color: var(--dark-blue); margin: 2rem 0 1rem;">Quick Actions</h2>
    <div class="quick-actions">

        <a href="{{ route('admin.stores.pending') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #fff3cd;">⏳</div>
            <div class="quick-action-title">Verify Stores</div>
            <div class="quick-action-desc">Review pending applications</div>
        </a>

        <a href="{{ route('admin.users.index') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #d1ecf1;">👥</div>
            <div class="quick-action-title">Manage Users</div>
            <div class="quick-action-desc">View and manage all users</div>
        </a>

        <a href="{{ route('admin.stores.index') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #d4edda;">🏪</div>
            <div class="quick-action-title">Manage Stores</div>
            <div class="quick-action-desc">View all stores</div>
        </a>

        <a href="{{ route('products.index') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #f8d7da;">📦</div>
            <div class="quick-action-title">View Products</div>
            <div class="quick-action-desc">Browse all products</div>
        </a>

        <!-- NEW: Manage Withdrawals -->
        <a href="{{ route('admin.withdrawals.index') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #e2e3ff;">💸</div>
            <div class="quick-action-title">Manage Withdrawals</div>
            <div class="quick-action-desc">Approve or reject seller withdrawal requests</div>
        </a>

    </div>

    <!-- Recent Activity -->
    <h2 style="color: var(--dark-blue); margin: 2rem 0 1rem;">Recent Activity</h2>
    <div class="recent-activity">

        @if($stats['pending_stores'] > 0)
        <div class="activity-item">
            <div class="activity-icon" style="background: #fff3cd;">⏳</div>
            <div class="activity-content">
                <div class="activity-title">{{ $stats['pending_stores'] }} Store(s) Waiting for Verification</div>
                <div class="activity-time">Review pending store applications</div>
            </div>
            <a href="{{ route('admin.stores.pending') }}" class="btn btn-outline">Review</a>
        </div>
        @endif

        @if($stats['pending_withdrawals'] > 0)
        <div class="activity-item">
            <div class="activity-icon" style="background: #e2e3ff;">💸</div>
            <div class="activity-content">
                <div class="activity-title">{{ $stats['pending_withdrawals'] }} Withdrawal Request(s) Pending</div>
                <div class="activity-time">Sellers are waiting for payout approval</div>
            </div>
            <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline">Review</a>
        </div>
        @endif

        <div class="activity-item">
            <div class="activity-icon" style="background: #d1ecf1;">👥</div>
            <div class="activity-content">
                <div class="activity-title">{{ $stats['total_users'] }} Total Users</div>
                <div class="activity-time">Registered users on the platform</div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">View All</a>
        </div>

    </div>
</div>
@endsection
