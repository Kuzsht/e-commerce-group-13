@extends('layouts.app')

@section('title', 'My Profile - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">My Profile</h1>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <!-- Profile Card -->
        <div class="card" style="text-align: center;">
            @if($user->buyer && $user->buyer->profile_picture)
                <img src="{{ asset('images/profiles/' . $user->buyer->profile_picture) }}" alt="Profile" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem;">
            @else
                <div style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, var(--red), var(--yellow)); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; font-weight: 700;">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
            
            <h2 style="color: var(--dark-blue); margin-bottom: 0.5rem;">{{ $user->name }}</h2>
            <p style="color: #666; margin-bottom: 1.5rem;">{{ $user->email }}</p>
            
            <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'info' }}" style="margin-bottom: 1rem;">
                {{ ucfirst($user->role) }}
            </span>

            @if($user->store)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Store Owner</p>
                    <p style="color: var(--dark-blue); font-weight: 600;">{{ $user->store->name }}</p>
                    <span class="badge badge-{{ $user->store->is_verified ? 'success' : 'warning' }}" style="margin-top: 0.5rem;">
                        {{ $user->store->is_verified ? 'Verified' : 'Pending Verification' }}
                    </span>
                </div>
            @endif

            <div style="margin-top: 1.5rem;">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="width: 100%;">Edit Profile</a>
            </div>
        </div>

        <!-- Profile Details -->
        <div>
            <div class="card">
                <h2 class="card-header">Personal Information</h2>
                
                <div style="display: grid; gap: 1.5rem;">
                    <div>
                        <label style="font-weight: 600; color: var(--dark-blue); display: block; margin-bottom: 0.5rem;">Full Name</label>
                        <p style="color: #666;">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label style="font-weight: 600; color: var(--dark-blue); display: block; margin-bottom: 0.5rem;">Email Address</label>
                        <p style="color: #666;">{{ $user->email }}</p>
                    </div>

                    @if($user->buyer && $user->buyer->phone_number)
                    <div>
                        <label style="font-weight: 600; color: var(--dark-blue); display: block; margin-bottom: 0.5rem;">Phone Number</label>
                        <p style="color: #666;">{{ $user->buyer->phone_number }}</p>
                    </div>
                    @endif

                    <div>
                        <label style="font-weight: 600; color: var(--dark-blue); display: block; margin-bottom: 0.5rem;">Member Since</label>
                        <p style="color: #666;">{{ $user->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            @if($user->store)
            <div class="card">
                <h2 class="card-header">Store Information</h2>
                
                <div style="display: flex; gap: 1.5rem; align-items: start;">
                    @if($user->store->logo)
                        <img src="{{ asset($user->store->logo) }}" alt="Store Logo" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover; border: 2px solid var(--border);">
                    @endif
                    
                    <div style="flex: 1;">
                        <h3 style="color: var(--dark-blue); margin-bottom: 0.5rem;">{{ $user->store->name }}</h3>
                        <p style="color: #666; margin-bottom: 1rem;">{{ $user->store->about }}</p>
                        
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; font-size: 0.9rem;">
                            <div>
                                <strong>Phone:</strong> {{ $user->store->phone }}
                            </div>
                            <div>
                                <strong>City:</strong> {{ $user->store->city }}
                            </div>
                            <div style="grid-column: 1/-1;">
                                <strong>Address:</strong> {{ $user->store->address }}
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-primary">Go to Seller Dashboard</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection