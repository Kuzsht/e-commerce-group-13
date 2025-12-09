@extends('layouts.app')

@section('title', 'Order Detail - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">
        Order #{{ $order->code }}
    </h1>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- LEFT: Order items --}}
        <div>
            <div class="card">
                <h2 class="card-header">Items</h2>
                <div class="card-body">
                    @foreach($order->details as $detail)
                        <div class="card" style="padding:1rem; margin-bottom:1rem;">
                            <h3 style="color:var(--dark-blue); margin-bottom:0.5rem;">
                                {{ $detail->product->name }}
                            </h3>
                            <p style="color:#666; margin-bottom:0.25rem;">
                                @php
                                    $colorLabel = $detail->color ?? null;
                                @endphp
                                @if($colorLabel)
                                    Color: {{ $colorLabel }} • 
                                @endif
                                Size: {{ $detail->size ?? '-' }} • Qty: {{ $detail->qty }}
                            </p>
                            <p style="color:#666; margin-bottom:0.25rem;">
                                Subtotal: Rp {{ number_format($detail->subtotal,0,',','.') }}
                            </p>
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
                    <p><strong>Customer:</strong> {{ $order->buyer->user->name }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($order->grand_total,0,',','.') }}</p>
                    <p><strong>Tax:</strong> Rp {{ number_format($order->tax,0,',','.') }}</p>
                    <p><strong>Shipping Cost:</strong> Rp {{ number_format($order->shipping_cost,0,',','.') }}</p>
                    <p><strong>Created At:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="card">
                <h2 class="card-header">Shipping Information</h2>
                <div class="card-body">
                    <p><strong>Address:</strong> {{ $order->address }}</p>
                    <p><strong>City:</strong> {{ $order->city }}</p>
                    <p><strong>Postal Code:</strong> {{ $order->postal_code }}</p>
                    <p><strong>Shipping Type:</strong> {{ $order->shipping_type }}</p>
                    <p><strong>Tracking Number:</strong> {{ $order->tracking_number ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
