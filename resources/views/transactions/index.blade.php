@extends('layouts.app')

@section('title', 'My Orders - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); font-size: 2rem; margin-bottom: 2rem;">My Orders</h1>

    <div class="card">
        @if($transactions->isEmpty())
            <div style="text-align: center; padding: 3rem;">
                <p style="color: #666; font-size: 1.1rem; margin-bottom: 1rem;">You haven't made any orders yet</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Store</th>
                            <th>Products</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td><strong>{{ $transaction->code }}</strong></td>
                            <td>{{ $transaction->store->name }}</td>

                            {{-- 👉 Tampilkan nama product yang dipesan --}}
                            <td>
                                @php
                                    // ambil semua nama produk dari detail
                                    $productNames = $transaction->details
                                        ->map(function ($detail) {
                                            return $detail->product->name ?? 'Unknown Product';
                                        })
                                        ->toArray();

                                    $productList = implode(', ', $productNames);
                                @endphp
                                {{ \Illuminate\Support\Str::limit($productList, 60) }}
                            </td>

                            <td><strong>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($transaction->payment_status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($transaction->payment_status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($transaction->payment_status == 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst($transaction->payment_status) }}</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem;">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem;">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
