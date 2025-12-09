<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['store', 'category', 'thumbnail'])
            ->latest()
            ->paginate(12);
        
        $categories = ProductCategory::whereNull('parent_id')
            ->withCount('products')
            ->get();

        $stores = Store::where('is_verified', true)
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('products', 'categories', 'stores'));
    }
}
