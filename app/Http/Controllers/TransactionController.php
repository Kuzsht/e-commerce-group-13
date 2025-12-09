<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('buyer_id', auth()->user()->buyer->id)
            ->with(['store', 'details.product'])
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::where('buyer_id', auth()->user()->buyer->id)
            ->with(['store', 'details.product.thumbnail'])
            ->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
}