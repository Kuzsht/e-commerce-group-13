@extends('layouts.app')

@section('title', 'Checkout - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 1rem;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- LEFT: Shipping & Payment Form --}}
        <div>
            <div class="card">
                <h2 class="card-header">Shipping & Payment</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST" style="padding-top: 1rem;">
                    @csrf

                    {{-- hidden shipping provider (dummy) --}}
                    <input type="hidden" name="shipping" value="standard">

                    {{-- Address --}}
                    <div class="form-group">
                        <label class="form-label">Full Address</label>
                        <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                        @error('address')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                        @error('city')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
                        @error('postal_code')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Shipping Type --}}
                    <div class="form-group">
                        <label class="form-label">Shipping Type</label>
                        <select name="shipping_type" class="form-control" id="shippingTypeSelect" required>
                            <option value="">Select Shipping</option>
                            @foreach($shippingCosts as $type => $cost)
                                <option
                                    value="{{ $type }}"
                                    data-cost="{{ $cost }}"
                                    {{ old('shipping_type', $shippingType) == $type ? 'selected' : '' }}
                                >
                                    @if($type === 'regular')
                                        Regular (3-5 days) - Rp {{ number_format($cost, 0, ',', '.') }}
                                    @elseif($type === 'express')
                                        Express (1-2 days) - Rp {{ number_format($cost, 0, ',', '.') }}
                                    @else
                                        Same Day - Rp {{ number_format($cost, 0, ',', '.') }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('shipping_type')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">Select Payment Method</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="credit_card"   {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="ewallet"       {{ old('payment_method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('payment_method')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Payment Reference --}}
                    <div class="form-group">
                        <label class="form-label">Payment Reference (optional)</label>
                        <input type="text" name="payment_reference" class="form-control" value="{{ old('payment_reference') }}" placeholder="E.g., Virtual Account / E-Wallet ref">
                        @error('payment_reference')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Bank / Card / Ewallet numbers --}}
                    <div class="form-group">
                        <label class="form-label">Bank Account Number (if bank transfer)</label>
                        <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') }}">
                        @error('bank_account')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Credit Card Number (if credit card)</label>
                        <input type="text" name="credit_card" class="form-control" value="{{ old('credit_card') }}">
                        @error('credit_card')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">E-Wallet Number (if e-wallet)</label>
                        <input type="text" name="ewallet" class="form-control" value="{{ old('ewallet') }}">
                        @error('ewallet')
                            <small style="color: var(--red);">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit"
                            class="btn btn-primary"
                            style="width: 100%; padding: 1rem; font-size: 1.1rem;"
                            onclick="return confirm('Apakah kamu yakin ingin melakukan transaksi dan membayar sekarang?')">
                        Pay Now & Complete Purchase
                    </button>
                </form>
            </div>
        </div>

        {{-- RIGHT: Order Summary --}}
        <div>
            <div class="card">
                <h2 class="card-header">Order Summary</h2>

                {{-- Cart items --}}
                <div style="padding: 1rem 0; border-bottom: 1px solid var(--gray);">
                    @forelse($cartItems as $item)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark-blue);">
                                    {{ $item['product_name'] }}
                                </div>
                                <div style="font-size: 0.85rem; color: #666;">
                                    @php
                                        $colorLabel = $item['color'] ?? null;
                                    @endphp
                                    @if($colorLabel)
                                        Color: {{ $colorLabel }} • 
                                    @endif
                                    Size: {{ $item['size'] ?? '-' }} • Qty: {{ $item['qty'] }}
                                </div>
                            </div>
                            <div style="font-weight: 600; color: var(--dark-blue); text-align: right;">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <p style="color: #666; text-align: center; padding: 1rem 0;">
                            No items in cart.
                        </p>
                    @endforelse
                </div>
                
                {{-- Totals --}}
                <div style="padding: 1rem 0; border-bottom: 1px solid var(--gray);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>Subtotal</span>
                        <span id="subtotalDisplay">Rp {{ number_format($itemsTotal, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>Shipping</span>
                        <span id="shippingCostDisplay">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>Tax (5%)</span>
                        <span id="taxDisplay">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-top: 1rem; font-size: 1.3rem; font-weight: 700; color: var(--red);">
                    <span>Total</span>
                    <span id="grandTotalDisplay">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const shippingSelect = document.getElementById('shippingTypeSelect');
        const shippingCostDisplay = document.getElementById('shippingCostDisplay');
        const taxDisplay = document.getElementById('taxDisplay');
        const grandTotalDisplay = document.getElementById('grandTotalDisplay');

        const subtotal = {{ (int) $itemsTotal }};

        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function recalc() {
            if (!shippingSelect) return;

            const option = shippingSelect.options[shippingSelect.selectedIndex];
            const cost = parseInt(option.getAttribute('data-cost') || '0');

            const tax = Math.round(subtotal * 0.05);
            const total = subtotal + cost + tax;

            shippingCostDisplay.textContent = formatRupiah(cost);
            taxDisplay.textContent = formatRupiah(tax);
            grandTotalDisplay.textContent = formatRupiah(total);
        }

        if (shippingSelect) {
            shippingSelect.addEventListener('change', recalc);
            recalc();
        }
    })();
</script>
@endsection
