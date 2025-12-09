@extends('layouts.app')

@section('title', 'Order Details - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">
        Order #{{ $transaction->code }}
    </h1>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- LEFT: Order items --}}
        <div>
            <div class="card">
                <h2 class="card-header">Items</h2>
                <div class="card-body">
                    @foreach($transaction->details as $detail)
                        <div class="card" style="padding:1rem; margin-bottom:1rem;">
                            <h3 style="color:var(--dark-blue); margin-bottom:0.5rem;">
                                {{ $detail->product->name }}
                            </h3>
                            <p style="color:#666; margin-bottom:0.25rem;">
                                @php
                                    // ambil warna & size dari kolom detail dulu,
                                    // kalau kosong boleh fallback ke relasi productSize (kalau kamu load)
                                    $colorLabel = $detail->color ?? optional($detail->productSize)->color;
                                    $sizeLabel  = $detail->size  ?? optional($detail->productSize)->size;
                                @endphp
                                @if($colorLabel)
                                    Color: {{ $colorLabel }} • 
                                @endif
                                Size: {{ $sizeLabel ?? '-' }} • Qty: {{ $detail->qty }}
                            </p>
                            <p style="color:#666; margin-bottom:0.25rem;">
                                Subtotal: Rp {{ number_format($detail->subtotal,0,',','.') }}
                            </p>

                            @php
                                $existingReview = \App\Models\ProductReview::where('transaction_id', $transaction->id)
                                    ->where('product_id', $detail->product_id)
                                    ->first();
                            @endphp

                            @if($transaction->payment_status === 'paid' && !$existingReview)
                                <button class="btn btn-primary" onclick="openReviewForm({{ $detail->product_id }}, {{ $transaction->id }})">
                                    Write Review
                                </button>
                            @elseif($existingReview)
                                <p style="color:green; margin-top:0.5rem;">You already reviewed this product.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT: Order summary & shipping --}}
        <div>
            <div class="card" style="margin-bottom:1.5rem;">
                <h2 class="card-header">Order Summary</h2>
                <div class="card-body">
                    <p><strong>Status:</strong> {{ ucfirst($transaction->payment_status) }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($transaction->grand_total,0,',','.') }}</p>
                    <p><strong>Tax:</strong> Rp {{ number_format($transaction->tax,0,',','.') }}</p>
                    <p><strong>Shipping Cost:</strong> Rp {{ number_format($transaction->shipping_cost,0,',','.') }}</p>
                    <p><strong>Created At:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="card">
                <h2 class="card-header">Shipping Information</h2>
                <div class="card-body">
                    <p><strong>Address:</strong> {{ $transaction->address }}</p>
                    <p><strong>City:</strong> {{ $transaction->city }}</p>
                    <p><strong>Postal Code:</strong> {{ $transaction->postal_code }}</p>
                    <p><strong>Shipping Type:</strong> {{ $transaction->shipping_type }}</p>
                    <p><strong>Tracking Number:</strong> {{ $transaction->tracking_number ?? '-' }}</p>
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
