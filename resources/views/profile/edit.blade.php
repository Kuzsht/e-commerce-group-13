@extends('layouts.app')

@section('title', 'Edit Profile - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('profile.show') }}" style="color: var(--red); text-decoration: none; font-weight: 600;">← Back to Profile</a>
    </div>

    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Edit Profile</h1>

    <div style="max-width: 800px;">
        <!-- Update Profile Info -->
        <div class="card">
            <h2 class="card-header">Personal Information</h2>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Profile Picture</label>
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        @if($user->buyer && $user->buyer->profile_picture)
                            <img src="{{ asset('images/profiles/' . $user->buyer->profile_picture) }}" alt="Profile" id="currentPicture" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div id="currentPicture" style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--red), var(--yellow)); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; font-weight: 700;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div style="flex: 1;">
                            <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" class="form-control" onchange="previewProfilePicture(event)">
                            <small style="color: #666;">PNG, JPG (MAX. 2MB)</small>
                        </div>
                    </div>
                    @error('profile_picture')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->buyer->phone_number ?? '') }}">
                    @error('phone_number')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>

        <!-- Update Password -->
        <div class="card">
            <h2 class="card-header">Change Password</h2>
            
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Current Password *</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">New Password *</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                    <small style="color: #666;">Minimum 6 characters</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</div>

<script>
function previewProfilePicture(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('currentPicture');
            preview.outerHTML = `<img src="${e.target.result}" alt="Profile" id="currentPicture" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">`;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection