<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class BalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            abort(404, 'Store not found');
        }

        $history = Transaction::where('store_id', $store->id)
            ->with(['buyer.user'])
            ->latest()
            ->get();

        $totalEarnings = $history
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        return view('seller.balance.index', compact(
            'store',
            'totalEarnings',
            'history'
        ));
    }
}
