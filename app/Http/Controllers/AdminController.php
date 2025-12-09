<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Store;
use App\Models\User;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'         => User::count(),
            'total_stores'        => Store::count(),
            'pending_stores'      => Store::where('is_verified', false)->count(),
            'verified_stores'     => Store::where('is_verified', true)->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function pendingStores()
    {
        $stores = Store::where('is_verified', false)
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('admin.stores.pending', compact('stores'));
    }

    public function verifyStore($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['is_verified' => true]);

        return redirect()->back()->with('success', 'Store verified successfully!');
    }

    public function rejectStore(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->back()->with('success', 'Store rejected!');
    }

    public function users()
    {
        $users = User::with('buyer', 'store')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function stores()
    {
        $stores = Store::with('user')->latest()->paginate(20);
        return view('admin.stores.index', compact('stores'));
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted!');
    }

    public function deleteStore($id)
    {
        Store::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Store deleted!');
    }

    public function withdrawals()
    {
        $withdrawals = Withdrawal::with(['storeBalance.store'])
            ->latest()
            ->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = Withdrawal::with(['storeBalance.store'])->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending withdrawals can be approved.');
        }

        $storeBalance = $withdrawal->storeBalance;

        if (!$storeBalance) {
            return redirect()->back()->with('error', 'Store balance not found for this withdrawal.');
        }

        if ($storeBalance->balance < $withdrawal->amount) {
            return redirect()->back()->with('error', 'Insufficient store balance to approve this withdrawal.');
        }

        DB::transaction(function () use ($withdrawal, $storeBalance) {
            $storeBalance->balance -= $withdrawal->amount;
            $storeBalance->save();

            if (method_exists($storeBalance, 'histories')) {
                $storeBalance->histories()->create([
                    'type'           => 'withdraw',
                    'amount'         => $withdrawal->amount,
                    'remarks'        => 'Withdrawal approved (ID: ' . $withdrawal->id . ')',
                    'reference_id'   => $withdrawal->id,
                    'reference_type' => 'withdrawal',
                ]);
            }

            $withdrawal->status = 'approved';
            $withdrawal->save();
        });

        return redirect()->back()->with('success', 'Withdrawal has been approved.');
    }

    public function rejectWithdrawal($id)
    {
        $withdrawal = Withdrawal::with(['storeBalance.store'])->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending withdrawals can be rejected.');
        }

        $withdrawal->status = 'rejected';
        $withdrawal->save();

        return redirect()->back()->with('success', 'Withdrawal has been rejected.');
    }
}
