<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = $store->products()->with('category', 'thumbnail')->get();
        $orders = \App\Models\Transaction::where('store_id', $store->id)
            ->latest()
            ->take(10)
            ->get();

        $totalEarnings = \App\Models\Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        return view('seller.dashboard', compact('store', 'products', 'orders', 'totalEarnings'));
    }
}
