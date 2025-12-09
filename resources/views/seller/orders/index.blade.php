@extends('layouts.app')

@section('title', 'Order Management - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Order Management</h1>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tracking Number</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->buyer->user->name }}</td>

                    {{-- total quantity dari semua detail --}}
                    <td>
                        {{ $order->details->sum('qty') }} pcs
                    </td>

                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>{{ $order->tracking_number ?? '-' }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="btn btn-outline" style="padding: 0.4rem 1rem;">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #666; padding: 2rem;">No orders yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
