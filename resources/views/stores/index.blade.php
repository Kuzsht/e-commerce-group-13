@extends('layouts.app')

@section('title', 'All Stores - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
    <div style="margin-bottom: 2rem;">
        <h1 style="color: var(--dark-blue); font-size: 2.5rem; margin-bottom: 0.5rem;">All Stores</h1>
        <p style="color: #666;">Browse all verified sneaker stores on KICKSup</p>
    </div>

    {{-- Search store --}}
    <div class="card" style="margin-bottom: 2rem;">
        <form action="{{ route('stores.index') }}" method="GET">
            <div style="display: flex; gap: 1rem; align-items: flex-end;">
                <div style="flex: 1;">
                    <label class="form-label">Search Stores</label>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by store name or city..." 
                        value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search'))
                    <a href="{{ route('stores.products', $store->id) }}" class="btn btn-primary" style="display: none;">
                @endif
            </div>
        </form>
    </div>

    {{-- Grid stores --}}
    <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
        @forelse($stores as $store)
            <a href="{{ route('stores.products', $store->id) }}" class="product-card">
                <div style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        @if($store->logo)
                            {{-- Kalau kolom logo menyimpan path lengkap "images/stores/xxx.jpg" --}}
                            <img 
                                src="{{ asset($store->logo) }}" 
                                alt="{{ $store->name }}" 
                                style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gray);">
                        @else
                            <div
                                style="
                                    width: 64px;
                                    height: 64px;
                                    border-radius: 50%;
                                    background: var(--dark-blue);
                                    color: white;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 700;
                                    font-size: 1.5rem;
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
                                {{ \Illuminate\Support\Str::limit($store->name, 30) }}
                            </h3>
                            <div style="color: #666; font-size: 0.9rem;">
                                {{ $store->city }} • {{ $store->products_count }} products
                            </div>
                        </div>
                    </div>

                    <p style="display: none; color: #666; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem;">
                        {{ \Illuminate\Support\Str::limit($store->about, 120) }}
                    </p>

                    <span class="btn btn-outline" style="display: none; margin-top: 0.5rem;">
                        View Products
                    </span>
                </div>
            </a>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                <p style="color: #666; font-size: 1.1rem;">No stores found</p>
                @if(request('search'))
                    <a href="{{ route('stores.index') }}" class="btn btn-primary" style="margin-top: 1rem;">View All Stores</a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $stores->links() }}
    </div>
</div>
@endsection
