@extends('layouts.app')

@section('title', 'Store Balance - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Store Balance</h1>

    {{-- CURRENT BALANCE --}}
    <div class="card" style="margin-bottom: 2rem;">
        <h2 class="card-header">Current Available Balance</h2>
        <div style="text-align: center; padding: 2rem;">
            <div style="font-size: 3rem; font-weight: 700; color: var(--red);">
                Rp {{ number_format($availableBalance ?? 0, 0, ',', '.') }}
            </div>
            <p style="color:#666; margin-top:0.5rem;">
                This is the amount you can still withdraw.
            </p>
            <a href="{{ route('seller.withdrawals.index') }}" class="btn btn-primary" style="margin-top: 1.5rem;">
                Request Withdrawal
            </a>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="dashboard-stats" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">Total Income (Paid Transactions)</div>
            <div class="stat-value">
                Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ffc107, #e0a800); color:#000;">
            <div class="stat-label">Total Withdrawn (Pending & Approved)</div>
            <div class="stat-value">
                Rp {{ number_format($totalWithdrawn ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- INCOME HISTORY --}}
    <div class="card">
        <h2 class="card-header">Income History (Transactions)</h2>

        @if($history->isEmpty())
            <p style="text-align: center; color: #666; padding: 2rem;">No transactions yet</p>
        @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Buyer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Shipping</th>
                            <th>Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $trx)
                        <tr>
                            <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $trx->code }}</td>
                            <td>{{ $trx->buyer->user->name ?? '-' }}</td>
                            <td style="font-weight:600; color: {{ $trx->payment_status === 'paid' ? '#28a745' : '#dc3545' }};">
                                Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $trx->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($trx->payment_status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($trx->shipping_cost, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($trx->tax, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
