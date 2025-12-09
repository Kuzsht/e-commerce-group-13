@extends('layouts.app')

@section('title', 'Store Management - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Store Management</h1>

    <div class="card">
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Store</th>
                        <th>Owner</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stores as $store)
                        @php
                            // Normalisasi path logo:
                            // - Kalau sudah mengandung 'http' atau 'images/stores', pakai langsung
                            // - Kalau cuma filename, prepend 'images/stores/'
                            $logo = $store->logo;

                            if ($logo) {
                                if (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://'])) {
                                    $logoUrl = $logo;
                                } elseif (\Illuminate\Support\Str::contains($logo, 'images/stores')) {
                                    $logoUrl = asset($logo);
                                } else {
                                    $logoUrl = asset('images/stores/' . $logo);
                                }
                            } else {
                                $logoUrl = null;
                            }
                        @endphp

                        <tr>
                            <td>{{ $store->id }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <div>
                                        @if($logoUrl)
                                            <img 
                                                src="{{ $logoUrl }}" 
                                                alt="Logo {{ $store->name }}" 
                                                style="width: 30px; height: 30px; border-radius: 6px; object-fit: cover;"
                                            >
                                        @else
                                            <div style="
                                                width: 30px;
                                                height: 30px;
                                                border-radius: 6px;
                                                background: #e5e7eb;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                font-size: 0.7rem;
                                                color:#6b7280;
                                            ">
                                                N/A
                                            </div>
                                        @endif
                                    </div>
                                    <strong>{{ $store->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $store->user->name ?? '-' }}</td>
                            <td>{{ $store->city ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $store->is_verified ? 'success' : 'warning' }}">
                                    {{ $store->is_verified ? 'Verified' : 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $store->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('admin.stores.delete', $store->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-outline" 
                                        style="padding: 0.4rem 1rem; font-size: 0.85rem; background: var(--red); color: white; border: none;" 
                                        onclick="return confirm('Delete store?')"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $stores->links() }}
        </div>
    </div>
</div>
@endsection
