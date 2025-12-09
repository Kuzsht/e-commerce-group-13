@extends('layouts.app')

@section('title', $store->name . ' - Store Products - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">

    {{-- Breadcrumb & Back --}}
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
        <div>
            <a href="{{ route('stores.index') }}" style="color: var(--red); text-decoration: none; font-weight: 600;">
                ← Back to All Stores
            </a>
            <div style="margin-top: 0.5rem; font-size: 0.9rem; color: #888;">
                Home / Stores / {{ $store->name }}
            </div>
        </div>
    </div>

    {{-- Store header --}}
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; gap: 1.5rem; align-items: center; padding: 1.5rem;">
            @if($store->logo)
                <img
                    src="{{ asset($store->logo) }}"
                    alt="{{ $store->name }}"
                    style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gray);">
            @else
                <div
                    style="
                        width: 80px;
                        height: 80px;
                        border-radius: 50%;
                        background: var(--dark-blue);
                        color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: 700;
                        font-size: 2rem;
                    "
                >
                    {{ substr($store->name, 0, 1) }}
                </div>
            @endif

            <div style="flex: 1;">
                <div style="font-size: 0.8rem; color: #888; text-transform: uppercase; letter-spacing: 0.12em;">
                    Verified Store
                </div>
                <h1 style="margin: 0; color: var(--dark-blue); font-size: 2rem;">
                    {{ $store->name }}
                </h1>
                <div style="margin-top: 0.35rem; color: #666; font-size: 0.95rem;">
                    {{ $store->city }} • Joined {{ $store->created_at->format('F Y') }}
                </div>
                <p style="margin-top: 0.75rem; color: #666; font-size: 0.95rem; line-height: 1.7;">
                    {{ $store->about }}
                </p>
            </div>
        </div>
    </div>

    {{-- Search Products --}}
    <div class="card" style="margin-bottom: 2rem;">
        <form action="{{ route('stores.products', $store->id) }}" method="GET">
            <div style="display: flex; gap: 1rem; align-items: flex-end;">
                <div style="flex: 1;">
                    <label class="form-label">Search Products in this Store</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search product name in {{ $store->name }}..."
                        value="{{ request('search') }}">
                </div>

                {{-- Category Filter --}}
                <div style="flex: 1;">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search') || request('category'))
                    <a href="{{ route('stores.products', $store->id) }}" class="btn btn-outline">Clear</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Products List --}}
    <div>
        <h2 class="section-title" style="margin-bottom: 1.5rem;">Products from {{ $store->name }}</h2>

        <div class="product-grid">
            @forelse($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-card">
                    @php
                        $thumb = $product->thumbnail
                            ? $product->thumbnail->image
                            : ($product->images->first()->image ?? null);
                    @endphp
                    <img
                        src="{{ $thumb ? asset('images/products/' . $thumb) : 'https://via.placeholder.com/500x300?text=No+Image' }}"
                        alt="{{ $product->name }}"
                        class="product-image">

                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name }}</div>
                        <h3 class="product-name">{{ \Illuminate\Support\Str::limit($product->name, 40) }}</h3>
                        <div class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                </a>
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 3rem;">
                    This store has no products yet.
                </p>
            @endforelse
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
