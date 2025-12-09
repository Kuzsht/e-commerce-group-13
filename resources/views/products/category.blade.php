@extends('layouts.app')

@section('title', $category->name . ' - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <nav style="margin-bottom: 1rem;">
            <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">Home</a>
            <span style="color: #666; margin: 0 0.5rem;">/</span>
            <a href="{{ route('products.index') }}" style="color: #666; text-decoration: none;">Products</a>
            <span style="color: #666; margin: 0 0.5rem;">/</span>
            <span style="color: var(--dark-blue); font-weight: 600;">{{ $category->name }}</span>
        </nav>
        
        <h1 style="color: var(--dark-blue); font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $category->name }}</h1>
        @if($category->tagline)
            <p style="color: #666;">{{ $category->tagline }}</p>
        @endif
        @if($category->description)
            <p style="color: #666; margin-top: 0.5rem;">{{ $category->description }}</p>
        @endif
    </div>

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
            </div>
        </a>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
            <p style="color: #666; font-size: 1.1rem;">No products in this category yet</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 1rem;">View All Products</a>
        </div>
        @endforelse
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
</div>
@endsection