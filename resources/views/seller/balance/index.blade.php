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

    <!-- Financial Summary Cards with Modern Design -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
        <!-- Total Income Card -->
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem; position: relative;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    💰
                </div>
                <div>
                    <div style="font-size: 0.875rem; opacity: 0.95; font-weight: 600;">Total Income</div>
                    <div style="font-size: 0.75rem; opacity: 0.8;">(Paid Transactions)</div>
                </div>
            </div>
            <div style="font-size: 2rem; font-weight: 900; position: relative;">
                Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
            </div>
        </div>

        <!-- Total Withdrawn Card -->
        <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem; position: relative;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    📤
                </div>
                <div>
                    <div style="font-size: 0.875rem; opacity: 0.95; font-weight: 600;">Total Withdrawn</div>
                    <div style="font-size: 0.75rem; opacity: 0.8;">(Pending & Approved)</div>
                </div>
            </div>
            <div style="font-size: 2rem; font-weight: 900; position: relative;">
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
