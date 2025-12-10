@extends('layouts.app')

@section('title', 'KICKSup - Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="hero">
    <h1>Step Up Your <span class="highlight">Sneaker Game</span></h1>
    <p>Discover the hottest kicks from verified sellers</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary" style="font-size: 1rem; padding: 1rem 2.5rem;">Shop Now</a>
</div>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">

    {{-- 🟦 Shop by Category --}}
    <div class="categories-section" style="margin-bottom: 3rem;">
        <h2 class="section-title">Shop by Category</h2>
        <p style="text-align: center; color: #666;">Browse sneakers by category</p>

        <div class="category-grid">
            @forelse($categories as $category)
                @php
                    $catImage = $category->image ?? null;

                    if ($catImage) {
                        if (\Illuminate\Support\Str::startsWith($catImage, ['http://', 'https://'])) {
                            // sudah full URL
                            $categoryImageUrl = $catImage;
                        } elseif (\Illuminate\Support\Str::contains($catImage, 'images/categories')) {
                            // di DB sudah termasuk path folder
                            $categoryImageUrl = asset($catImage);
                        } else {
                            // cuma filename → prepend folder
                            $categoryImageUrl = asset('images/categories/' . $catImage);
                        }
                    } else {
                        $categoryImageUrl = null;
                    }
                @endphp

                <a href="{{ route('products.category', $category->slug) }}" class="category-card">
                    @if($categoryImageUrl)
                        <div class="category-icon" style="overflow:hidden; padding:0;">
                            <img 
                                src="{{ $categoryImageUrl }}" 
                                alt="{{ $category->name }}" 
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                    @else
                        <div class="category-icon">
                            {{ substr($category->name, 0, 1) }}
                        </div>
                    @endif

                    <h3 class="category-name">{{ $category->name }}</h3>
                    <p class="category-count">{{ $category->products_count }} products</p>
                </a>
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #666;">No categories available</p>
            @endforelse
        </div>
    </div>

    {{-- 🟦 Shop by Stores --}}
    <div class="categories-section" style="margin-bottom: 3rem;">
        <h2 class="section-title">Shop by Stores</h2>
        <p style="text-align: center; color: #666;">Find your favorite sneaker stores</p>

        <div class="product-grid" style="display: flex; grid-template-columns: none; overflow-x: auto; overflow-y: hidden; scroll-behavior: smooth; padding: 1rem 0; gap: 1.5rem; scrollbar-width: none; -ms-overflow-style: none;">
            @forelse($stores as $store)
                @php
                    $logo = $store->logo ?? null;

                    if ($logo) {
                        if (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://'])) {
                            $storeLogoUrl = $logo;
                        } elseif (\Illuminate\Support\Str::contains($logo, 'images/stores')) {
                            $storeLogoUrl = asset($logo);
                        } else {
                            $storeLogoUrl = asset('images/stores/' . $logo);
                        }
                    } else {
                        $storeLogoUrl = null;
                    }
                @endphp

                <a href="{{ route('stores.products', $store->id) }}" class="product-card" style="min-width: 280px; max-width: 320px; flex-shrink: 0;">
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            @if($storeLogoUrl)
                                <img 
                                    src="{{ $storeLogoUrl }}" 
                                    alt="{{ $store->name }}" 
                                    style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gray);">
                            @else
                                <div
                                    style="
                                        width: 56px;
                                        height: 56px;
                                        border-radius: 50%;
                                        background: var(--dark-blue);
                                        color: white;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-weight: 700;
                                        font-size: 1.2rem;
                                    "
                                >
                                    {{ substr($store->name, 0, 1) }}
                                </div>
                            @endif

                            <div>
                                <div style="font-size: 0.8rem; color: #888; text-transform: uppercase; letter-spacing: 0.08em;">
                                    Verified Store
                                </div>
                                <h3 class="product-name" style="margin: 0;">
                                    {{ \Illuminate\Support\Str::limit($store->name, 28) }}
                                </h3>
                                <div style="color: #666; font-size: 0.85rem;">
                                    {{ $store->city }} • {{ $store->products_count }} products
                                </div>
                            </div>
                        </div>

                        <p style="display: none; color: #666; font-size: 0.9rem; line-height: 1.6; margin-bottom: 0.5rem;">
                            {{ \Illuminate\Support\Str::limit($store->about, 90) }}
                        </p>

                        <span class="btn btn-outline" style="display: none; margin-top: 0.5rem;">
                            View Store Products
                        </span>
                    </div>
                </a>
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #666;">No stores available</p>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('stores.index') }}" class="btn btn-primary">View All Stores</a>
        </div>
    </div>

    {{-- 🟦 Latest Products --}}
    <div class="products-section">
        <h2 class="section-title">Latest Products</h2>
        <p style="text-align: center; color: #666;">Fresh drops from our sellers</p>

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
                        <div style="color: #666; font-size: 0.85rem; margin-top: 0.25rem;">
                            {{ $product->store->name }}
                        </div>
                        <div class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                </a>
            @empty
                <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 3rem;">No products available</p>
            @endforelse
        </div>

        <div style="margin-top: 2rem; text-align: center;">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
