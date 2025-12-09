<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function create()
    {
        if (auth()->user()->store) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'You already have a store!');
        }

        return view('seller.register-store');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'required|max:255',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'about' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('images/stores'), $filename);

            $validated['logo'] = 'images/stores/' . $filename;
        }

        $validated['user_id'] = auth()->id();
        $validated['is_verified'] = false;

        $store = Store::create($validated);

        StoreBalance::create([
            'store_id' => $store->id,
            'balance' => 0,
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Store registered! Waiting for admin verification.');
    }

    public function dashboard()
    {
        $store = auth()->user()->store;

        if (!$store) {
            abort(404, 'Store not found');
        }

        $products = Product::where('store_id', $store->id)
            ->with(['category', 'thumbnail'])
            ->get();

        $orders = Transaction::where('store_id', $store->id)
            ->with(['buyer.user'])
            ->latest()
            ->get();

        $totalIncome = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $storeBalance = $store->balance;

        $totalWithdrawn = 0;
        if ($storeBalance) {
            $totalWithdrawn = Withdrawal::where('store_balance_id', $storeBalance->id)
                ->whereIn('status', ['pending', 'approved'])
                ->sum('amount');
        }

        $availableBalance = $totalIncome - $totalWithdrawn;

        return view('seller.dashboard', compact(
            'store',
            'products',
            'orders',
            'totalIncome',
            'totalWithdrawn',
            'availableBalance'
        ));
    }

    public function edit()
    {
        $store = auth()->user()->store;
        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = auth()->user()->store;

        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'about' => 'nullable',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($store->logo && file_exists(public_path($store->logo))) {
                unlink(public_path($store->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/stores'), $logoName);

            $validated['logo'] = 'images/stores/' . $logoName;
        }

        $store->update($validated);

        return redirect()->back()->with('success', 'Store updated successfully!');
    }

    public function destroy()
    {
        $store = auth()->user()->store;
        $store->delete();

        auth()->user()->update(['role' => 'user']);

        return redirect()->route('home')
            ->with('success', 'Store deleted successfully!');
    }

    public function browse(Request $request)
    {
        $query = Store::withCount('products')
            ->where('is_verified', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%');
            });
        }

        $stores = $query->orderBy('name')->paginate(12);

        return view('stores.index', compact('stores'));
    }

    public function showProducts(Request $request, Store $store)
    {
        $query = $store->products()->with(['category', 'thumbnail']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = ProductCategory::all();

        return view('stores.products', compact('store', 'products', 'categories'));
    }
}