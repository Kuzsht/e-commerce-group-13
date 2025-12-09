@extends('layouts.app')

@section('title', 'Pending Store Verification - KICKSup')

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Pending Store Verification</h1>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Owner</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Registered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->user->name }}</td>
                    <td>{{ $store->user->email }}</td>
                    <td>{{ $store->phone }}</td>
                    <td>{{ $store->city }}</td>
                    <td>{{ $store->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <form action="{{ route('admin.stores.verify', $store->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary" style="padding: 0.4rem 1rem;">Verify</button>
                            </form>
                            <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem; background: var(--red); color: white; border: none;" onclick="return confirm('Reject this store?')">Reject</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #666; padding: 2rem;">No pending stores</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 2rem;">
            {{ $stores->links() }}
        </div>
    </div>
</div>
@endsection