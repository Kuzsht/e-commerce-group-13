<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Withdrawal;

class BalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            abort(404, 'Store not found');
        }

        $storeBalance = $store->balance;

        $history = Transaction::where('store_id', $store->id)
            ->with(['buyer.user'])
            ->latest()
            ->get();

        $totalIncome = $history
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $totalWithdrawn = 0;
        if ($storeBalance) {
            $totalWithdrawn = Withdrawal::where('store_balance_id', $storeBalance->id)
                ->whereIn('status', ['pending', 'approved'])
                ->sum('amount');
        }

        $availableBalance = $totalIncome - $totalWithdrawn;

        return view('seller.balance.index', compact(
            'store',
            'history',
            'totalIncome',
            'totalWithdrawn',
            'availableBalance'
        ));
    }
}
