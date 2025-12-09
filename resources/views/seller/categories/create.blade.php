@extends('layouts.app')

@section('title', 'Add Category - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('seller.categories.index') }}" style="color: var(--red); text-decoration: none; font-weight: 600;">← Back to Categories</a>
    </div>

    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Add New Category</h1>

    <div class="card" style="max-width: 800px;">
        {{-- PENTING: enctype untuk upload file --}}
        <form action="{{ route('seller.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Category Name --}}
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Parent Category --}}
            <div class="form-group">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">None (Main Category)</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                <small style="color: #666;">Leave empty to create a main category</small>
                @error('parent_id')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Tagline --}}
            <div class="form-group">
                <label class="form-label">Tagline</label>
                <input type="text" name="tagline" class="form-control" value="{{ old('tagline') }}" placeholder="e.g., Premium Running Shoes">
                @error('tagline')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                @error('description')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Category Image --}}
            <div class="form-group">
                <label class="form-label">Category Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small style="color: #666;">Optional. Recommended size 600x600px. File type: JPG, JPEG, PNG, WEBP (max 2MB).</small>
                @error('image')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Create Category</button>
                <a href="{{ route('seller.categories.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
