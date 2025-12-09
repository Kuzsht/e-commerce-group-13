<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\TransactionDetail;
use App\Models\ProductSize;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category', 'thumbnail']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('store', function ($qs) use ($search) {
                        $qs->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categories = ProductCategory::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function byCategory($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        $products = Product::where('product_category_id', $category->id)
            ->with(['store', 'thumbnail'])
            ->latest()
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }

    public function show($id)
    {
        $product = Product::with([
                'images',
                'store',
                'category',
                'reviews.transaction.buyer.user',
                'sizes',
            ])
            ->findOrFail($id);

        $canReview           = false;
        $existingReview      = null;
        $reviewTransactionId = null;

        if (auth()->check() && auth()->user()->buyer) {
            $buyerId = auth()->user()->buyer->id;

            $purchaseDetail = TransactionDetail::where('product_id', $product->id)
                ->whereHas('transaction', function ($q) use ($buyerId) {
                    $q->where('buyer_id', $buyerId)
                        ->where('payment_status', 'paid');
                })
                ->orderBy('id')
                ->first();

            if ($purchaseDetail) {
                $canReview           = true;
                $reviewTransactionId = $purchaseDetail->transaction_id;

                $existingReview = ProductReview::where('product_id', $product->id)
                    ->where('transaction_id', $reviewTransactionId)
                    ->first();
            }
        }

        return view('products.show', compact(
            'product',
            'canReview',
            'existingReview',
            'reviewTransactionId'
        ));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description'         => 'required',
            'condition'           => 'required|in:new,second',
            'price'               => 'required|numeric|min:0',
            'weight'              => 'required|integer|min:0',

            'variants'            => 'required|array',
            'variants.*.color'    => 'nullable|string|max:50',
            'variants.*.sizes'    => 'array',
            'variants.*.sizes.*'  => 'nullable|integer|min:0',

            'images'              => 'required|array|min:1',
            'images.*'            => 'image|mimes:jpeg,png,jpg|max:2048',
            'thumbnail_index'     => 'nullable|integer|min:0',
        ]);

        $variants = $request->input('variants', []);
        $totalStock = 0;

        foreach ($variants as $variant) {
            $color = trim($variant['color'] ?? '');
            $sizes = $variant['sizes'] ?? [];

            if ($color === '') continue;

            foreach ($sizes as $size => $qty) {
                $qty = (int) $qty;
                if ($qty > 0) {
                    $totalStock += $qty;
                }
            }
        }

        if ($totalStock <= 0) {
            return back()->withInput()->withErrors(['variants' => 'Minimal harus ada 1 warna + 1 ukuran dengan stok > 0.']);
        }

        $validated['slug'] = Str::slug($request->name) . '-' . time();
        $validated['store_id'] = auth()->user()->store->id;
        $validated['stock'] = $totalStock;

        $product = Product::create($validated);

        foreach ($variants as $variant) {
            $color = trim($variant['color'] ?? '');
            $sizes = $variant['sizes'] ?? [];

            if ($color === '') continue;

            foreach ($sizes as $size => $qty) {
                $qty = (int) $qty;
                if ($qty > 0) {
                    $product->sizes()->create([
                        'color' => $color,
                        'size'  => (string) $size,
                        'stock' => $qty,
                    ]);
                }
            }
        }

        $images = $request->file('images', []);
        $thumbnailIndex = $request->thumbnail_index ?? 0;

        foreach ($images as $index => $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $filename);

            $product->images()->create([
                'image'        => $filename,
                'is_thumbnail' => ($index == $thumbnailIndex),
            ]);
        }

        return redirect()->route('seller.products.edit', $product->id)
            ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product    = Product::where('store_id', auth()->user()->store->id)
            ->with(['images', 'sizes']) // sizes = color + size + stock
            ->findOrFail($id);
        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('store_id', auth()->user()->store->id)
            ->with('sizes')
            ->findOrFail($id);

        $validated = $request->validate([
            'name'                => 'required|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description'         => 'required',
            'condition'           => 'required|in:new,second',
            'price'               => 'required|numeric|min:0',
            'weight'              => 'required|integer|min:0',

            'variants'                 => 'required|array|min:1',
            'variants.*.color'         => 'nullable|string|max:50',
            'variants.*.sizes.size'    => 'required|string|max:20',
            'variants.*.sizes.stock'   => 'required|integer|min:0',
        ]);

        $variants = $request->input('variants', []);
        $totalStock = 0;
        
        $product->sizes()->delete();

        foreach ($variants as $variant) {
            $color = trim($variant['color'] ?? '');
            $size = $variant['sizes']['size'] ?? '';
            $stock = (int) ($variant['sizes']['stock'] ?? 0);

            if (empty($size) || $stock <= 0) {
                continue;
            }

            $product->sizes()->create([
                'color' => $color ?: 'Default',
                'size'  => $size,
                'stock' => $stock,
            ]);

            $totalStock += $stock;
        }

        if ($totalStock <= 0) {
            return back()->withInput()->withErrors(['variants' => 'Minimal harus ada 1 ukuran dengan stok > 0.']);
        }

        $validated['slug'] = Str::slug($request->name) . '-' . time();
        $validated['stock'] = $totalStock;

        $product->update([
            'name'                => $validated['name'],
            'product_category_id' => $validated['product_category_id'],
            'description'         => $validated['description'],
            'condition'           => $validated['condition'],
            'price'               => $validated['price'],
            'weight'              => $validated['weight'],
            'slug'                => $validated['slug'],
            'stock'               => $validated['stock'],
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::where('store_id', auth()->user()->store->id)
            ->with('images')
            ->findOrFail($id);

        foreach ($product->images as $image) {
            if (file_exists(public_path('images/products/' . $image->image))) {
                @unlink(public_path('images/products/' . $image->image));
            }
        }

        $product->delete();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Product deleted successfully!');
    }

    public function uploadImage(Request $request, $productId)
    {
        $request->validate([
            'image'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_thumbnail' => 'boolean',
        ]);

        $product = Product::where('store_id', auth()->user()->store->id)
            ->findOrFail($productId);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/products'), $imageName);

            if ($request->is_thumbnail) {
                ProductImage::where('product_id', $product->id)
                    ->update(['is_thumbnail' => false]);
            }

            ProductImage::create([
                'product_id'   => $product->id,
                'image'        => $imageName,
                'is_thumbnail' => $request->is_thumbnail ?? false,
            ]);
        }

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    public function deleteImage($imageId)
    {
        $image = ProductImage::findOrFail($imageId);

        $product = Product::where('id', $image->product_id)
            ->where('store_id', auth()->user()->store->id)
            ->firstOrFail();

        if (file_exists(public_path('images/products/' . $image->image))) {
            @unlink(public_path('images/products/' . $image->image));
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
