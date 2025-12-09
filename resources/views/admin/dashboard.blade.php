@extends('layouts.app')

@section('title', 'Admin Dashboard - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
.admin-hero {
    background: linear-gradient(135deg, var(--dark-blue) 0%, #1e3a8a 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.admin-hero::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.admin-hero h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.admin-hero p {
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.quick-action-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    border: 2px solid transparent;
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    border-color: var(--red);
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.quick-action-title {
    font-weight: 600;
    color: var(--dark-blue);
    margin-bottom: 0.25rem;
}

.quick-action-desc {
    font-size: 0.85rem;
    color: #666;
}

.stat-card {
    position: relative;
    overflow: hidden;
}

.stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(30%, -30%);
}

.recent-activity {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid var(--border);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: var(--dark-blue);
    margin-bottom: 0.25rem;
}

.activity-time {
    font-size: 0.85rem;
    color: #999;
}
</style>
@endpush

@section('content')
<div class="container">
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
