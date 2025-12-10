@extends('layouts.app')

@section('title', $product->name . ' - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
@endpush

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('products.index') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Products
    </a>
    
    <div class="product-detail">
        <div class="product-gallery">
            <img src="{{ $product->images->first() ? asset('images/products/' . $product->images->first()->image) : 'https://via.placeholder.com/500?text=No+Image' }}" 
                 alt="{{ $product->name }}" 
                 class="main-image"
                 id="mainImage">
            
            @if($product->images->count() > 1)
            <div class="thumbnail-images">
                @foreach($product->images as $image)
                <img src="{{ asset('images/products/' . $image->image) }}" 
                     alt="{{ $product->name }}"
                     onclick="document.getElementById('mainImage').src = this.src">
                @endforeach
            </div>
            @endif
        </div>

        <div class="product-details">
            <div class="product-category">{{ $product->category->name }}</div>
            <h1>{{ $product->name }}</h1>
            
            <div style="color: #666;">
                Sold by: <strong>{{ $product->store->name }}</strong>
            </div>

            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            <div class="product-meta">
                <div class="meta-item">
                    <span class="meta-label">Condition</span>
                    <span class="meta-value">{{ $product->condition ?? 'New' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Total Stock</span>
                    <span class="meta-value">{{ $product->stock }} pcs</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Weight</span>
                    <span class="meta-value">{{ $product->weight ?? 'N/A' }} g</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Rating</span>
                    <span class="meta-value">
                        <span class="rating">★</span> 
                        {{ number_format($product->averageRating(), 1) }}
                    </span>
                </div>
            </div>

            <div>
                <h3 style="color: var(--dark-blue); margin-bottom: 1rem;">Description</h3>
                <p style="line-height: 1.8; color: #666;">
                    {{ $product->description ?? 'No description available.' }}
                </p>
            </div>

            @auth
                @php
                    $variantsByColor = $product->sizes->groupBy('color');
                    $firstColor      = $variantsByColor->keys()->first();
                @endphp

                <form action="{{ route('checkout.buyNow', $product->id) }}" method="POST" style="margin-top: 1.5rem;">
                    @csrf

                    @if($variantsByColor->count())
                        {{-- PILIH WARNA --}}
                        <div style="margin-bottom: 1.25rem;">
                            <h3 style="color: var(--dark-blue); margin-bottom: 0.75rem;">Choose Color</h3>
                            <div style="display:flex; flex-wrap:wrap; gap:0.5rem;" id="colorButtons">
                                @foreach($variantsByColor as $color => $sizesGroup)
                                    @php $colorLabel = $color ?: 'Default'; @endphp
                                    <button
                                        type="button"
                                        class="color-button {{ $loop->first ? 'selected' : '' }}"
                                        data-color="{{ $color }}"
                                    >
                                        {{ $colorLabel }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- INFO STOCK PER VARIANT --}}
                        <div style="margin-bottom: 1.5rem;">
                            <p style="color:#666; font-size:0.9rem; margin-bottom:0.5rem;">
                                Total stock: {{ $product->stock }} pcs.
                            </p>
                        </div>

                        {{-- PILIH SIZE PER WARNA --}}
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="color: var(--dark-blue); margin-bottom: 0.75rem;">Choose Size</h3>

                            @foreach($variantsByColor as $color => $sizesGroup)
                                <div class="sizes-group" data-color="{{ $color }}" style="{{ $color === $firstColor ? '' : 'display:none;' }}">
                                    <div class="size-selector">
                                        @foreach($sizesGroup->sortBy('size') as $variant)
                                            @php
                                                $disabled = $variant->stock <= 0;
                                            @endphp
                                            <button type="button"
                                                    class="size-button {{ $disabled ? 'disabled' : '' }}"
                                                    data-variant-id="{{ $variant->id }}"
                                                    data-color="{{ $color }}"
                                                    data-size="{{ $variant->size }}"
                                                    data-stock="{{ $variant->stock }}"
                                                    @if($disabled) disabled @endif>
                                                {{ $variant->size }} ({{ $variant->stock }})
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <small id="sizeHelp" style="color: #666;">
                                Please select color and shoe size before buying.
                            </small>

                            <input type="hidden" id="selectedVariantId" name="product_size_id">
                            <input type="hidden" id="selectedColor" name="color">
                            <input type="hidden" id="selectedSize" name="size">
                        </div>

                        {{-- Quantity --}}
                        <div class="form-group" style="max-width: 220px;">
                            <label class="form-label">Quantity</label>
                            <input
                                type="number"
                                name="qty"
                                id="qtyInput"
                                class="form-control"
                                value="1"
                                min="1"
                                disabled
                            >
                            <small id="stockInfo" style="color:#666; display:none;"></small>
                        </div>
                    @endif

                    <button type="submit"
                            class="btn btn-primary"
                            style="font-size: 1.1rem; padding: 1rem 3rem; margin-top: 1rem;"
                            onclick="return validateVariantBeforeBuy();">
                        Buy Now
                    </button>
                </form>
            @else
                <div style="margin-top: 2rem;">
                    <a href="{{ route('login') }}" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 3rem;">
                        Login to Purchase
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <div class="reviews-section">
        <h2 style="color: var(--dark-blue); margin-bottom: 1.5rem;">Customer Reviews</h2>

        {{-- Form tulis ulasan jika user sudah beli --}}
        @auth
            @if($canReview && !$existingReview)
                <div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
                    <h3 style="color: var(--dark-blue); margin-bottom: 1rem;">Write a Review</h3>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="transaction_id" value="{{ $reviewTransactionId }}">

                        <div class="form-group">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-control" required>
                                <option value="">Select rating</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} ★</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Review</label>
                            <textarea name="review" class="form-control" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Submit Review
                        </button>
                    </form>
                </div>
            @elseif($canReview && $existingReview)
                <div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
                    <h3 style="color: var(--dark-blue); margin-bottom: 0.5rem;">Your Review</h3>
                    <div class="review-item" style="margin-bottom:0;">
                        <div class="review-header">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $existingReview->rating ? '★' : '☆' }}
                                @endfor
                            </span>
                        </div>
                        <p style="color: #666;">{{ $existingReview->review }}</p>
                        <small style="color: #999;">{{ $existingReview->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endif
        @endauth
        
        @forelse($product->reviews as $review)
        <div class="review-item">
            <div class="review-header">
                <strong>{{ $review->transaction->buyer->user->name }}</strong>
                <span class="rating">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                </span>
            </div>
            <p style="color: #666;">{{ $review->review }}</p>
            <small style="color: #999;">{{ $review->created_at->diffForHumans() }}</small>
        </div>
        @empty
        <p style="color: #666; text-align: center; padding: 2rem;">No reviews yet. Be the first to review this product!</p>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const colorButtons  = document.querySelectorAll('.color-button');
    const sizeGroups    = document.querySelectorAll('.sizes-group');
    const sizeButtons   = document.querySelectorAll('.size-button');

    const selectedVariantInput = document.getElementById('selectedVariantId');
    const selectedColorInput   = document.getElementById('selectedColor');
    const selectedSizeInput    = document.getElementById('selectedSize');
    const qtyInput             = document.getElementById('qtyInput');
    const sizeHelp             = document.getElementById('sizeHelp');
    const stockInfo            = document.getElementById('stockInfo');

    // pilih color
    colorButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const color = btn.dataset.color;

            colorButtons.forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');

            sizeGroups.forEach(group => {
                group.style.display = (group.dataset.color === color) ? '' : 'none';
            });

            // reset pilihan size
            selectedVariantInput.value = '';
            selectedColorInput.value   = color;
            selectedSizeInput.value    = '';
            if (qtyInput) {
                qtyInput.disabled = true;
                qtyInput.value    = 1;
            }
            if (stockInfo) {
                stockInfo.style.display = 'none';
                stockInfo.textContent   = '';
                stockInfo.style.color   = '#666';
            }
            if (sizeHelp) {
                sizeHelp.style.color   = '#666';
                sizeHelp.textContent   = 'Please select color and shoe size before buying.';
            }

            sizeButtons.forEach(b => b.classList.remove('selected'));
        });
    });

    // pilih size
    sizeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.classList.contains('disabled') || btn.disabled) {
                return;
            }

            const variantId = btn.dataset.variantId;
            const color     = btn.dataset.color;
            const size      = btn.dataset.size;
            const stock     = parseInt(btn.dataset.stock || '0', 10);

            sizeButtons.forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');

            selectedVariantInput.value = variantId;
            selectedColorInput.value   = color;
            selectedSizeInput.value    = size;

            if (qtyInput) {
                qtyInput.disabled = false;
                qtyInput.value    = 1;
                qtyInput.min      = 1;
                qtyInput.max      = stock;
            }

            if (stockInfo) {
                stockInfo.style.display = 'block';
                stockInfo.style.color   = '#666';
                stockInfo.textContent   = 'Stock for ' + (color || 'Default') + ' / size ' + size + ': ' + stock + ' pcs available.';
            }

            if (sizeHelp) {
                sizeHelp.style.color = '#666';
                sizeHelp.textContent = 'Selected: ' + (color || 'Default') + ', size ' + size + '.';
            }
        });
    });
});

function validateVariantBeforeBuy() {
    const selectedVariantInput = document.getElementById('selectedVariantId');
    const qtyInput             = document.getElementById('qtyInput');
    const sizeHelp             = document.getElementById('sizeHelp');
    const stockInfo            = document.getElementById('stockInfo');

    if (!selectedVariantInput || !selectedVariantInput.value) {
        if (sizeHelp) {
            sizeHelp.style.color   = 'var(--red)';
            sizeHelp.textContent   = 'Please choose color and shoe size first.';
        }
        return false;
    }

    if (qtyInput) {
        const qty = parseInt(qtyInput.value || '0', 10);
        const max = parseInt(qtyInput.max || '0', 10);

        if (qty < 1 || qty > max) {
            if (stockInfo) {
                stockInfo.style.display = 'block';
                stockInfo.style.color   = 'var(--red)';
                stockInfo.textContent   = 'Quantity must be between 1 and ' + max + '.';
            }
            return false;
        }
    }

    return true;
}
</script>
@endsection
