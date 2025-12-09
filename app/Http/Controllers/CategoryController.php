<?php
namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')
            ->with('parent')
            ->latest()
            ->paginate(15);
            
        return view('seller.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = ProductCategory::whereNull('parent_id')->get();
        return view('seller.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'tagline' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/categories'), $filename);

            $validated['image'] = 'images/categories/' . $filename;
        }

        ProductCategory::create($validated);

        return redirect()->route('seller.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = ProductCategory::withCount('products')->findOrFail($id);
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        return view('seller.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'tagline' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            $validated['image'] = 'images/categories/' . $imageName;
        }

        $category->update($validated);

        return redirect()->back()->with('success', 'Category updated!');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        
        $productCount = $category->products()->count();
        
        if ($productCount > 0) {
            return redirect()->route('seller.categories.index')
                ->with('error', 'Cannot delete category because it has ' . $productCount . ' products. Please reassign or delete those products first.');
        }
        
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        
        $category->delete();
        
        return redirect()->route('seller.categories.index')
            ->with('success', 'Category deleted!');
    }
}