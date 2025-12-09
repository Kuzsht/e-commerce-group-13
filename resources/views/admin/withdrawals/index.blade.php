@extends('layouts.app')

@section('title', 'Withdrawal Requests - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Withdrawal Requests</h1>

    <div class="card">
        <h2 class="card-header">All Withdrawals</h2>

        @if($withdrawals->isEmpty())
            <p style="text-align:center; color:#666; padding:2rem;">No withdrawal requests found.</p>
        @else
            <div style="overflow-x:auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Store</th>
                            <th>Amount</th>
                            <th>Bank</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $wd)
                            @php
                                $store = $wd->storeBalance->store ?? null;
                            @endphp
                            <tr>
                                <td>{{ $wd->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $store->name ?? '-' }}</td>
                                <td>Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                <td>{{ $wd->bank_name }}</td>
                                <td>{{ $wd->bank_account_name }}</td>
                                <td>{{ $wd->bank_account_number }}</td>
                                <td>
                                    <span class="badge badge-{{ $wd->status === 'approved' ? 'success' : ($wd->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($wd->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($wd->status === 'pending')
                                        <div style="display:flex; gap:0.5rem;">
                                            <form action="{{ route('admin.withdrawals.approve', $wd->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Approve this withdrawal?')">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.withdrawals.reject', $wd->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-outline" style="border-color: var(--red); color: var(--red);" onclick="return confirm('Reject this withdrawal?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <em style="color:#666;">No action available</em>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:1rem;">
                {{ $withdrawals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
