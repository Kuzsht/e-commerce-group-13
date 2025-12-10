@extends('layouts.app')

@section('title', 'Edit Product - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('seller.dashboard') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Dashboard
    </a>
    
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Edit Product</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Product Form -->
        <div class="card">
            <h2 class="card-header">Product Information</h2>
            
            <form action="{{ route('seller.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="product_category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Price (Rp) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0" step="1000">
                    @error('price')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Weight (g)</label>
                    <input type="number" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}" step="0.01">
                    @error('weight')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Condition</label>
                    <select name="condition" class="form-control">
                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                        <option value="second" {{ old('condition', $product->condition) == 'second' ? 'selected' : '' }}>Second</option>
                    </select>
                </div>

                {{-- 🔥 Variants: Color + Size + Stock --}}
                <div class="form-group" style="margin-top: 1.5rem;">
                    <label class="form-label">Variants (Color, Size &amp; Stock) *</label>
                    <p style="color:#666; font-size:0.9rem; margin-bottom:0.75rem;">
                        Atur kombinasi warna, ukuran, dan stok untuk produk ini. Setiap baris = 1 warna dengan 1 ukuran.
                    </p>

                    @php
                        // Konversi data dari database ke format yang diharapkan controller
                        $oldVariants = old('variants');
                        
                        if ($oldVariants === null) {
                            $oldVariants = [];
                            
                            foreach($product->sizes as $index => $size) {
                                $oldVariants[] = [
                                    'color' => $size->color ?: 'Default',
                                    'sizes' => [
                                        'size' => $size->size,
                                        'stock' => $size->stock
                                    ]
                                ];
                            }
                            
                            // Jika tidak ada data, buat default
                            if (empty($oldVariants)) {
                                $oldVariants = [[
                                    'color' => '',
                                    'sizes' => [
                                        'size' => '',
                                        'stock' => 0
                                    ]
                                ]];
                            }
                        }
                    @endphp

                    <div id="variantsWrapper">
                        @foreach($oldVariants as $index => $variant)
                            <div class="variant-row" style="display:flex; gap:0.75rem; margin-bottom:0.75rem; align-items:flex-end; flex-wrap:wrap;">
                                <div style="flex:1; min-width:120px;">
                                    <label class="form-label">Color</label>
                                    <input
                                        type="text"
                                        name="variants[{{ $index }}][color]"
                                        class="form-control variant-color"
                                        value="{{ $variant['color'] ?? '' }}"
                                        placeholder="e.g. White, Black, Red"
                                    >
                                </div>
                                <div style="flex:1; min-width:120px;">
                                    <label class="form-label">Size *</label>
                                    <input
                                        type="text"
                                        name="variants[{{ $index }}][sizes][size]"
                                        class="form-control variant-size"
                                        value="{{ $variant['sizes']['size'] ?? '' }}"
                                        placeholder="e.g. 40, 41, 42"
                                        required
                                    >
                                </div>
                                <div style="flex:1; min-width:120px;">
                                    <label class="form-label">Stock *</label>
                                    <input
                                        type="number"
                                        name="variants[{{ $index }}][sizes][stock]"
                                        class="form-control variant-stock"
                                        value="{{ $variant['sizes']['stock'] ?? 0 }}"
                                        min="0"
                                        required
                                    >
                                </div>
                                
                                <div style="flex: 0 0 auto; margin-bottom: 0.5rem;">
                                    <button type="button" class="btn btn-outline btn-remove-variant" style="padding: 0.5rem 0.75rem; font-size: 0.9rem;" onclick="removeVariantRow(this)">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" class="btn btn-outline" onclick="addVariantRow()" style="margin-top: 1rem;">
                        + Add Another Variant
                    </button>

                    @error('variants')
                        <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                    @enderror
                    @error('variants.*.color')
                        <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                    @enderror
                    @error('variants.*.sizes.size')
                        <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                    @enderror
                    @error('variants.*.sizes.stock')
                        <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>

        <!-- Product Images -->
        <div class="card">
            <h2 class="card-header">Product Images</h2>
            
            <form action="{{ route('seller.products.uploadImage', $product->id) }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 2rem;">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_thumbnail" value="1">
                        <span>Set as thumbnail</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Upload Image</button>
            </form>

            <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border);">

            <h3 style="color: var(--dark-blue); margin-bottom: 1rem;">Current Images</h3>
            
            @if($product->images->isEmpty())
                <p style="text-align: center; color: #666; padding: 2rem;">No images uploaded yet</p>
            @else
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    @foreach($product->images as $image)
                    <div style="position: relative; border: 2px solid {{ $image->is_thumbnail ? 'var(--red)' : 'var(--border)' }}; border-radius: 8px; padding: 0.5rem;">
                        <img src="{{ asset('images/products/' . $image->image) }}" alt="Product" style="width: 100%; height: 150px; object-fit: cover; border-radius: 6px;">
                        
                        @if($image->is_thumbnail)
                            <span style="position: absolute; top: 0.75rem; left: 0.75rem; background: var(--red); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Thumbnail</span>
                        @endif
                        
                        <form action="{{ route('seller.products.deleteImage', $image->id) }}" method="POST" style="position: absolute; top: 0.75rem; right: 0.75rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: rgba(0,0,0,0.7); color: white; border: none; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: 1rem;" onclick="return confirm('Delete image?')">×</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
let variantIndex = {{ count($oldVariants) }};

function addVariantRow() {
    const wrapper = document.getElementById('variantsWrapper');
    
    const newRow = document.createElement('div');
    newRow.className = 'variant-row';
    newRow.style.cssText = 'display:flex; gap:0.75rem; margin-bottom:0.75rem; align-items:flex-end; flex-wrap:wrap;';
    
    newRow.innerHTML = `
        <div style="flex:1; min-width:120px;">
            <label class="form-label">Color</label>
            <input
                type="text"
                name="variants[${variantIndex}][color]"
                class="form-control variant-color"
                placeholder="e.g. White, Black, Red"
            >
        </div>
        <div style="flex:1; min-width:120px;">
            <label class="form-label">Size *</label>
            <input
                type="text"
                name="variants[${variantIndex}][sizes][size]"
                class="form-control variant-size"
                placeholder="e.g. 40, 41, 42"
                required
            >
        </div>
        <div style="flex:1; min-width:120px;">
            <label class="form-label">Stock *</label>
            <input
                type="number"
                name="variants[${variantIndex}][sizes][stock]"
                class="form-control variant-stock"
                value="0"
                min="0"
                required
            >
        </div>
        <div style="flex: 0 0 auto; margin-bottom: 0.5rem;">
            <button type="button" class="btn btn-outline btn-remove-variant" style="padding: 0.5rem 0.75rem; font-size: 0.9rem;" onclick="removeVariantRow(this)">Remove</button>
        </div>
    `;
    
    wrapper.appendChild(newRow);
    variantIndex++;
}

// Fungsi removeVariantRow tetap sama
function removeVariantRow(button) {
    const row = button.closest('.variant-row');
    if (document.querySelectorAll('.variant-row').length > 1) {
        row.remove();
        // Reindex jika diperlukan
        reindexVariants();
    } else {
        alert('Product must have at least one variant.');
    }
}

function reindexVariants() {
    const rows = document.querySelectorAll('.variant-row');
    rows.forEach((row, index) => {
        // Update name attributes
        const colorInput = row.querySelector('.variant-color');
        const sizeInput = row.querySelector('.variant-size');
        const stockInput = row.querySelector('.variant-stock');
        
        if (colorInput) colorInput.name = `variants[${index}][color]`;
        if (sizeInput) sizeInput.name = `variants[${index}][sizes][]`;
        if (stockInput) stockInput.name = `variants[${index}][sizes][]`;
    });
    variantIndex = rows.length;
}
</script>
@endsection