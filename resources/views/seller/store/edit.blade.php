@extends('layouts.app')

@section('title', 'Edit Store - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('seller.dashboard') }}" style="color: var(--red); text-decoration: none; font-weight: 600;">← Back to Dashboard</a>
    </div>

    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Edit Store Settings</h1>

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Store Logo</label>
                <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 1rem;">
                    @if($store->logo)
                        <img src="{{ asset($store->logo) }}" alt="Store Logo" id="currentLogo" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover; border: 3px solid var(--border);">
                    @endif
                </div>
                <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
                <small style="color: #666;">PNG, JPG (MAX. 2MB) - Leave empty to keep current logo</small>
            </div>

            <div class="form-group">
                <label class="form-label">Store Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $store->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone *</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $store->phone) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Address *</label>
                <textarea name="address" class="form-control" required>{{ old('address', $store->address) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $store->city) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Postal Code *</label>
                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $store->postal_code) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">About Store *</label>
                <textarea name="about" class="form-control">{{ old('about', $store->about) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('seller.dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('currentLogo');
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection