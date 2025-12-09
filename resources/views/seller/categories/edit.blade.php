@extends('layouts.app')

@section('title', 'Edit Category - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('seller.categories.index') }}" style="color: var(--red); text-decoration: none; font-weight: 600;">← Back to Categories</a>
    </div>

    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Edit Category</h1>

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('seller.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required autofocus>
                @error('name')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">None (Main Category)</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                <small style="color: #666;">Leave empty to make this a main category</small>
                @error('parent_id')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tagline</label>
                <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $category->tagline) }}" placeholder="e.g., Premium Running Shoes">
                @error('tagline')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Category Image --}}
            <div class="form-group">
                <label class="form-label">Category Image</label>

                @php
                    $catImage = $category->image ?? null;

                    if ($catImage) {
                        if (\Illuminate\Support\Str::startsWith($catImage, ['http://', 'https://'])) {
                            $categoryImageUrl = $catImage;
                        } elseif (\Illuminate\Support\Str::contains($catImage, 'images/categories')) {
                            $categoryImageUrl = asset($catImage);
                        } else {
                            $categoryImageUrl = asset('images/categories/' . $catImage);
                        }
                    } else {
                        $categoryImageUrl = null;
                    }
                @endphp

                @if($categoryImageUrl)
                    <div style="margin-bottom: 0.75rem;">
                        <small style="display:block; color:#666; margin-bottom:0.25rem;">Current Image:</small>
                        <img 
                            src="{{ $categoryImageUrl }}" 
                            alt="{{ $category->name }}" 
                            style="width: 120px; height: 120px; border-radius: 12px; object-fit: cover; border: 1px solid #ddd;">
                    </div>
                @endif

                <input type="file" name="image" class="form-control">
                <small style="color:#666;">Leave empty if you don't want to change the image.</small>
                @error('image')
                    <small style="color: var(--red); font-size: 0.85rem; display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="{{ route('seller.categories.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
