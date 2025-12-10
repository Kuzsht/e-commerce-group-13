@extends('layouts.app')

@section('title', 'Add Product - KICKSup')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
    
    <h1 style="color: var(--dark-blue); margin-bottom: 2rem;">Add New Product</h1>

    <div class="card">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Product Name --}}
            <div class="form-group">
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- Category --}}
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="product_category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_category_id')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- Price --}}
            <div class="form-group">
                <label class="form-label">Price (Rp) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0" step="1000">
                @error('price')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- Weight --}}
            <div class="form-group">
                <label class="form-label">Weight (gram) *</label>
                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" required min="0">
                @error('weight')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- Condition --}}
            <div class="form-group">
                <label class="form-label">Condition *</label>
                <select name="condition" class="form-control" required>
                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="second" {{ old('condition') == 'second' ? 'selected' : '' }}>Second</option>
                </select>
                @error('condition')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- 🔥 Dynamic Color Variants (Color + Sizes + Stock) --}}
            <div class="form-group">
                <label class="form-label">Color Variants (Color + Sizes + Stock) *</label>
                <p style="color:#666; font-size:0.9rem; margin-bottom:0.5rem;">
                    Tambahkan warna dan stok per ukuran. Kamu bebas menambahkan warna sebanyak apapun.
                </p>

                @php
                    $sizeOptions = [36, 37, 38, 39, 40, 41, 42, 43, 44, 45];
                    $oldVariants = old('variants', [
                        ['color' => '', 'sizes' => []]
                    ]);
                @endphp

                <div id="variantsContainer">
                    @foreach($oldVariants as $index => $variant)
                        <div class="variant-block" data-index="{{ $index }}"
                             style="border:1px solid var(--border); border-radius:8px; padding:1rem; margin-bottom:1rem;">
                            
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                                <div class="form-group" style="flex:1; margin-right:0.75rem;">
                                    <label class="form-label">Color</label>
                                    <input
                                        type="text"
                                        name="variants[{{ $index }}][color]"
                                        class="form-control"
                                        value="{{ $variant['color'] ?? '' }}"
                                        placeholder="e.g., Black, White, Red"
                                    >
                                </div>
                                <button type="button"
                                        class="btn btn-outline"
                                        onclick="removeVariant(this)"
                                        style="margin-top: 1.6rem;">
                                    Remove
                                </button>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 0.75rem;">
                                @foreach($sizeOptions as $size)
                                    @php
                                        $val = $variant['sizes'][$size] ?? 0;
                                    @endphp
                                    <div>
                                        <label class="form-label" style="font-size:0.9rem;">Size {{ $size }}</label>
                                        <input
                                            type="number"
                                            name="variants[{{ $index }}][sizes][{{ $size }}]"
                                            class="form-control"
                                            value="{{ old('variants.'.$index.'.sizes.'.$size, $val) }}"
                                            min="0"
                                        >
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline" onclick="addVariant()" style="margin-top: 0.5rem;">
                    + Add Color Variant
                </button>

                @error('variants')
                    <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                @enderror
                @error('variants.*.color')
                    <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                @enderror
                @error('variants.*.sizes.*')
                    <small style="color: var(--red); display:block; margin-top: 0.35rem;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
                @error('description')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- Product Images --}}
            <div class="form-group">
                <label class="form-label">Product Images (min 1) *</label>
                <input
                    type="file"
                    name="images[]"
                    class="form-control"
                    accept="image/*"
                    multiple
                >
                <small>Upload sebanyak yang kamu butuhkan (misalnya 3–8 foto). Tidak ada limit dari sisi aplikasi, hanya dibatasi ukuran file server.</small>
                @error('images')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
                @error('images.*')
                    <small style="color: var(--red);">{{ $message }}</small>
                @enderror
            </div>

            {{-- Thumbnail Selection --}}
            <div class="form-group">
                <label class="form-label">Thumbnail Index (optional)</label>
                <input type="number" name="thumbnail_index" class="form-control" min="0" value="{{ old('thumbnail_index') }}">
                <small>Contoh: 0 = gambar pertama, 1 = gambar kedua, dst.</small>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Create Product</button>
                <a href="{{ route('seller.dashboard') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

{{-- TEMPLATE VARIANT (dipakai JS) --}}
<script type="text/template" id="variantTemplate">
    @php $sizeOptions = [36, 37, 38, 39, 40, 41, 42, 43, 44, 45]; @endphp
    <div class="variant-block" data-index="__INDEX__"
         style="border:1px solid var(--border); border-radius:8px; padding:1rem; margin-bottom:1rem;">
        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
            <div class="form-group" style="flex:1; margin-right:0.75rem;">
                <label class="form-label">Color</label>
                <input
                    type="text"
                    name="variants[__INDEX__][color]"
                    class="form-control"
                    placeholder="e.g., Black, White, Red"
                >
            </div>
            <button type="button"
                    class="btn btn-outline"
                    onclick="removeVariant(this)"
                    style="margin-top: 1.6rem;">
                Remove
            </button>
        </div>

        <div style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 0.75rem;">
            @foreach($sizeOptions as $size)
                <div>
                    <label class="form-label" style="font-size:0.9rem;">Size {{ $size }}</label>
                    <input
                        type="number"
                        name="variants[__INDEX__][sizes][{{ $size }}]"
                        class="form-control"
                        value="0"
                        min="0"
                    >
                </div>
            @endforeach
        </div>
    </div>
</script>

<script>
    let variantIndex = {{ count($oldVariants) }};

    function addVariant() {
        const container = document.getElementById('variantsContainer');
        const tpl = document.getElementById('variantTemplate').innerHTML;
        const html = tpl.replace(/__INDEX__/g, variantIndex);
        container.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    }

    function removeVariant(button) {
        const block = button.closest('.variant-block');
        const container = document.getElementById('variantsContainer');

        // minimal 1 block
        if (container.querySelectorAll('.variant-block').length <= 1) {
            alert('Minimal harus ada 1 varian warna.');
            return;
        }

        block.remove();
    }
</script>
@endsection
