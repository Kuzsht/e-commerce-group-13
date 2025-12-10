@extends('layouts.app')

@section('title', 'Seller Dashboard - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
    
    <h1 style="color: var(--dark-blue); margin-bottom: 0.5rem; font-size: 2rem;">Welcome, {{ $store->name }}!</h1>
    <p style="color: #666; margin-bottom: 2rem; font-size: 0.95rem;">Manage your store and products</p>

    <div class="action-buttons">
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">+ Add New Product</a>
        <a href="{{ route('seller.categories.index') }}" class="btn btn-outline">Manage Categories</a>
        <a href="{{ route('seller.orders.index') }}" class="btn btn-outline">View All Orders</a>
        <a href="{{ route('seller.balance.index') }}" class="btn btn-outline">View Balance</a>
        <a href="{{ route('seller.store.edit') }}" class="btn btn-outline">Store Settings</a>
    </div>

    <div class="dashboard-stats">
        {{-- Total Products --}}
        <div class="stat-card">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $products->count() }}</div>
        </div>

        {{-- Pending Orders --}}
        <div class="stat-card" style="background: linear-gradient(135deg, var(--red), #d32f3e);">
            <div class="stat-label">Pending Orders</div>
            <div class="stat-value">{{ $orders->where('payment_status', 'pending')->count() }}</div>
        </div>

        {{-- Completed Orders --}}
        <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
            <div class="stat-label">Completed Orders</div>
            <div class="stat-value">{{ $orders->where('payment_status', 'paid')->count() }}</div>
        </div>

        {{-- Store Balance (dinamis dari transaksi paid) --}}
        <div class="stat-card" style="background: linear-gradient(135deg, var(--yellow), #e6c200); color: var(--black);">
            <div class="stat-label">Store Balance (Available)</div>
            <div class="stat-value">
                Rp {{ number_format($availableBalance ?? 0, 0, ',', '.') }}
            </div>
            <div style="font-size: 0.8rem; opacity: 0.8; margin-top: 0.25rem;">
                Total income: Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}<br>
                Withdrawn (pending & approved): Rp {{ number_format($totalWithdrawn ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="card-header">Your Products</h2>
        
        @if($products->isEmpty())
            <p style="text-align: center; color: #666; padding: 2rem;">
                No products yet. <a href="{{ route('seller.products.create') }}" style="color: var(--red); font-weight: 600;">Add your first product</a>
            </p>
        @else
            <div class="product-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <img src="{{ $product->thumbnail ? asset('images/products/' . $product->thumbnail->image) : 'https://via.placeholder.com/300x250/0A2463/FFFFFF?text=No+Image' }}" 
                         alt="{{ $product->name }}" 
                         class="product-image">
                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name }}</div>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-outline" style="flex: 1; text-align: center; padding: 0.5rem; font-size: 0.85rem;">Edit</a>
                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="width: 100%; background: var(--red); color: white; border: none; padding: 0.5rem; font-size: 0.85rem;" onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card">
        <h2 class="card-header">Recent Orders</h2>
        
        @if($orders->isEmpty())
            <p style="text-align: center; color: #666; padding: 2rem;">No orders yet</p>
        @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->buyer->user->name }}</td>
                            <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('seller.orders.show', $order->id) }}" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem;">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
