@extends('layouts.app')

@section('title', 'Order Details - KICKSup')

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('transactions.index') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to My Orders
    </a>
    
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <h1 style="color: var(--dark-blue); margin: 0;">
            Order #{{ $transaction->code }}
        </h1>
        <span style="padding: 0.5rem 1.25rem; border-radius: var(--radius-full); font-weight: 700; font-size: 0.875rem; {{ $transaction->payment_status === 'paid' ? 'background: linear-gradient(135deg, #10b981, #059669); color: white;' : 'background: linear-gradient(135deg, #f59e0b, #d97706); color: white;' }}">
            {{ ucfirst($transaction->payment_status) }}
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- LEFT: Order items --}}
        <div>
            <div class="card" style="box-shadow: var(--shadow-xl); border: 1px solid var(--gray-100);">
                <h2 style="background: linear-gradient(135deg, var(--dark-blue), #1e3a8a); color: white; padding: 1.25rem 1.5rem; margin: 0; border-radius: var(--radius-xl) var(--radius-xl) 0 0; font-size: 1.25rem;">🛍️ Order Items</h2>
                <div style="padding: 1.5rem;">
                    @foreach($transaction->details as $detail)
                        <div style="background: white; border: 2px solid var(--gray-100); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.25rem; transition: all var(--transition-base); position: relative; display: flex; gap: 1.5rem;" class="order-item-card">
                            <!-- Product Image -->
                            <div style="flex-shrink: 0;">
                                <img src="{{ $detail->product->thumbnail ? asset('images/products/' . $detail->product->thumbnail->image) : 'https://via.placeholder.com/120x120/e5e7eb/9ca3af?text=No+Image' }}" 
                                     alt="{{ $detail->product->name }}" 
                                     style="width: 120px; height: 120px; object-fit: cover; border-radius: var(--radius-lg); border: 2px solid var(--gray-100);">
                            </div>
                            
                            <!-- Product Details -->
                            <div style="flex: 1; display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                    <h3 style="color: var(--dark-blue); margin: 0; font-size: 1.15rem; font-weight: 700; flex: 1;">
                                        {{ $detail->product->name }}
                                    </h3>
                                    <div style="background: linear-gradient(135deg, var(--red), var(--yellow)); color: white; padding: 0.35rem 1rem; border-radius: var(--radius-full); font-weight: 900; font-size: 1.1rem; white-space: nowrap; margin-left: 1rem;">
                                        Rp {{ number_format($detail->subtotal,0,',','.') }}
                                    </div>
                                </div>
                                
                                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1rem;">
                                    @php
                                        $colorLabel = $detail->color ?? optional($detail->productSize)->color;
                                        $sizeLabel  = $detail->size  ?? optional($detail->productSize)->size;
                                    @endphp
                                    @if($colorLabel)
                                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; color: var(--dark-blue);">
                                            <span style="width: 12px; height: 12px; background: linear-gradient(135deg, var(--red), var(--yellow)); border-radius: 50%; display: inline-block;"></span>
                                            {{ $colorLabel }}
                                        </span>
                                    @endif
                                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; color: var(--dark-blue);">
                                        📏 Size {{ $sizeLabel ?? '-' }}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; color: var(--dark-blue);">
                                        ✖️ Qty: {{ $detail->qty }}
                                    </span>
                                </div>

                                @php
                                    $existingReview = \App\Models\ProductReview::where('transaction_id', $transaction->id)
                                        ->where('product_id', $detail->product_id)
                                        ->first();
                                @endphp

                                <div style="margin-top: auto;">
                                    @if($transaction->payment_status === 'paid' && !$existingReview)
                                        <button class="btn btn-outline" style="margin-top: 0.5rem; font-size: 0.875rem;" onclick="openReviewForm({{ $detail->product_id }}, {{ $transaction->id }})">
                                            ⭐ Write Review
                                        </button>
                                    @elseif($existingReview)
                                        <p style="color: #10b981; margin-top: 0.75rem; font-weight: 600; font-size: 0.875rem; margin-bottom: 0;">✅ You already reviewed this product.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT: Order summary & shipping --}}
        <div>
            <div style="background: linear-gradient(135deg, var(--red) 0%, #d32f3e 100%); border-radius: var(--radius-xl); padding: 2rem; color: white; box-shadow: 0 8px 24px rgba(230, 57, 70, 0.3); margin-bottom: 1.5rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <h2 style="margin: 0 0 1.5rem 0; font-size: 1.25rem; position: relative;">💰 Order Summary</h2>
                <div style="position: relative;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.2);">
                        <span style="opacity: 0.9;">Subtotal</span>
                        <span style="font-weight: 700;">Rp {{ number_format($transaction->grand_total - $transaction->tax - $transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.2);">
                        <span style="opacity: 0.9;">Tax</span>
                        <span style="font-weight: 700;">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2);">
                        <span style="opacity: 0.9;">Shipping</span>
                        <span style="font-weight: 700;">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 900;">
                        <span>Total</span>
                        <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.85rem; opacity: 0.8;">
                        📅 {{ $transaction->created_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="card" style="box-shadow: var(--shadow-lg); border: 1px solid var(--gray-100);">
                <h2 style="background: var(--gray-50); color: var(--dark-blue); padding: 1.25rem 1.5rem; margin: 0; border-radius: var(--radius-xl) var(--radius-xl) 0 0; font-size: 1.15rem; border-bottom: 2px solid var(--border);">📦 Shipping Information</h2>
                <div style="padding: 1.5rem;">
                    <div style="margin-bottom: 1rem; padding: 1rem; background: var(--gray-50); border-radius: var(--radius-md); border-left: 4px solid var(--red);">
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Address</div>
                        <div style="font-weight: 600; color: var(--dark-blue);">{{ $transaction->address }}</div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div style="padding: 1rem; background: var(--gray-50); border-radius: var(--radius-md);">
                            <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">City</div>
                            <div style="font-weight: 600; color: var(--dark-blue);">{{ $transaction->city }}</div>
                        </div>
                        <div style="padding: 1rem; background: var(--gray-50); border-radius: var(--radius-md);">
                            <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Postal Code</div>
                            <div style="font-weight: 600; color: var(--dark-blue);">{{ $transaction->postal_code }}</div>
                        </div>
                    </div>
                    <div style="padding: 1rem; background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: 1rem;">
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Shipping Type</div>
                        <div style="font-weight: 600; color: var(--dark-blue);">{{ $transaction->shipping_type }}</div>
                    </div>
                    <div style="padding: 1rem; background: var(--gray-50); border-radius: var(--radius-md); border: 2px dashed {{ $transaction->tracking_number ? 'var(--red)' : 'var(--border)' }};">
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Tracking Number</div>
                        <div style="font-weight: 700; color: {{ $transaction->tracking_number ? 'var(--red)' : 'var(--gray-400)' }}; font-family: monospace; font-size: 1.1rem;">{{ $transaction->tracking_number ?? 'Not Available' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Review --}}
<div id="reviewModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:999;">
    <div class="card" style="width:400px; padding:1.5rem;">
        <h3 style="color:var(--dark-blue); margin-bottom:1rem;">Write a Review</h3>
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="review_product_id">
            <input type="hidden" name="transaction_id" id="review_transaction_id">

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

            <div style="display:flex; gap:0.5rem; margin-top:1rem;">
                <button type="submit" class="btn btn-primary">Submit Review</button>
                <button type="button" class="btn btn-outline" onclick="closeReviewForm()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openReviewForm(product_id, transaction_id) {
    document.getElementById('review_product_id').value = product_id;
    document.getElementById('review_transaction_id').value = transaction_id;
    document.getElementById('reviewModal').style.display = 'flex';
}
function closeReviewForm() {
    document.getElementById('reviewModal').style.display = 'none';
}
</script>
@endsection
