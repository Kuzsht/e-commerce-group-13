<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $storeBalance = $store->balance;

        $withdrawals = Withdrawal::where('store_balance_id', $storeBalance->id ?? 0)
            ->latest()
            ->paginate(15);

        return view('seller.withdrawals.index', compact('withdrawals'));
    }

    public function request(Request $request)
    {
        $validated = $request->validate([
            'amount'             => 'required|numeric|min:1',
            'bank_account_name'  => 'required|string',
            'bank_account_number'=> 'required|string',
            'bank_name'          => 'required|string',
        ]);

        $store = auth()->user()->store;
        $storeBalance = $store->balance;

        if (!$storeBalance) {
            return redirect()->back()->with('error', 'Store balance record not found.');
        }

        $totalIncome = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $totalWithdrawn = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        $availableBalance = $totalIncome - $totalWithdrawn;

        if ($availableBalance < $validated['amount']) {
            return redirect()->back()->with(
                'error',
                'Insufficient balance! Available: Rp ' . number_format($availableBalance, 0, ',', '.')
            );
        }

        $validated['store_balance_id'] = $storeBalance->id;
        $validated['status'] = 'pending';

        Withdrawal::create($validated);

        $storeBalance->balance = $availableBalance - $validated['amount'];
        $storeBalance->save();

        return redirect()->back()->with('success', 'Withdrawal request submitted!');
    }

    public function updateBankAccount(Request $request)
    {
        $validated = $request->validate([
            'bank_account_name'   => 'required',
            'bank_account_number' => 'required',
            'bank_name'           => 'required',
        ]);

        session($validated);

        return redirect()->back()->with('success', 'Bank account updated!');
    }
}
