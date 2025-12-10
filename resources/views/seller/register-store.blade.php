@extends('layouts.app')

@section('title', 'Register Store - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/store-registration.css') }}">
@endpush

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('home') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Home
    </a>
    
    <h1 style="color: var(--dark-blue); margin-bottom: 0.5rem;">Register Your Store</h1>
    <p style="color: #666; margin-bottom: 2rem;">Start selling on KICKSup by registering your store</p>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Store Logo *</label>
                <div class="upload-area" onclick="document.getElementById('logoInput').click()" id="uploadArea">
                    <div class="upload-icon">📷</div>
                    <p style="color: #666; margin-bottom: 0.5rem;"><strong>Click to upload</strong> or drag and drop</p>
                    <small style="color: #999;">PNG, JPG (MAX. 2MB)</small>
                </div>
                <input type="file" name="logo" id="logoInput" accept="image/*" style="display: none;" required onchange="previewLogo(event)">
                <div class="preview-container">
                    <img id="logoPreview" class="logo-preview" alt="Logo preview">
                </div>
                @error('logo')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Store Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number *</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                @error('phone')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Full Address *</label>
                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                @error('address')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                @error('city')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Postal Code *</label>
                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
                @error('postal_code')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">About Your Store *</label>
                <textarea name="about" class="form-control">{{ old('about') }}</textarea>
                @error('about')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 1rem; border-radius: 10px; margin: 1.5rem 0;">
                <strong>Note:</strong> Your store will be reviewed by admin before it becomes active. You'll be notified once approved.
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Submit for Verification</button>
                <a href="{{ route('home') }}" class="btn btn-outline">Cancel</a>
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
            const preview = document.getElementById('logoPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

// Drag and drop
const uploadArea = document.getElementById('uploadArea');
const logoInput = document.getElementById('logoInput');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        logoInput.files = files;
        previewLogo({ target: { files: files } });
    }
});
</script>
@endsection