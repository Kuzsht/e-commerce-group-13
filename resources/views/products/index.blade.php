@extends('layouts.app')

@section('title', 'All Products - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="color: var(--dark-blue); font-size: 2.5rem; margin-bottom: 0.5rem;">All Products</h1>
        <p style="color: #666;">Discover the latest sneakers from verified sellers</p>
    </div>

    <!-- Search & Filter -->
    <div class="card" style="margin-bottom: 2rem;">
        <form action="{{ route('products.index') }}" method="GET">
            <div style="display: flex; gap: 1rem; align-items: end;">
                <div style="flex: 1;">
                    <label class="form-label">Search Products or Stores</label>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by product or store name..." 
                        value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search'))
                    <a href="{{ route('products.index') }}" class="btn btn-outline">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Categories Filter -->
    <div style="margin-bottom: 2rem;">
        <h3 style="color: var(--dark-blue); margin-bottom: 1rem;">Filter by Category</h3>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('products.index') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline' }}">
                All Products
            </a>
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->slug) }}" class="btn btn-outline">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
    @if(request('search'))
        <p style="color: #666; margin-bottom: 1.5rem;">
            Showing results for "<strong>{{ request('search') }}</strong>"
        </p>
    @endif

    <div class="product-grid">
        @forelse($products as $product)
        <a href="{{ route('product.show', $product->id) }}" class="product-card">
            <img src="{{ $product->thumbnail ? asset('images/products/' . $product->thumbnail->image) : 'https://via.placeholder.com/300x250/0A2463/FFFFFF?text=No+Image' }}" 
                 alt="{{ $product->name }}" 
                 class="product-image">
            <div class="product-info">
                <div class="product-category">{{ $product->category->name }}</div>
                <h3 class="product-name">{{ Str::limit($product->name, 40) }}</h3>
                <div style="color: #666; font-size: 0.85rem; margin-top: 0.25rem;">{{ $product->store->name }}</div>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                @if($product->stock > 0)
                    <div style="font-size: 0.85rem; color: #28a745; margin-top: 0.5rem;">
                        ✓ In Stock ({{ $product->stock }})
                    </div>
                @else
                    <div style="font-size: 0.85rem; color: #dc3545; margin-top: 0.5rem;">
                        Out of Stock
                    </div>
                @endif
            </div>
        </a>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
            <p style="color: #666; font-size: 1.1rem;">No products found</p>
            @if(request('search'))
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 1rem;">View All Products</a>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
</div>
@endsection