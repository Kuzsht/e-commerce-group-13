<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Transaction::where('store_id', auth()->user()->store->id)
            ->with(['buyer.user', 'details.product'])
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Transaction::where('store_id', auth()->user()->store->id)
            ->with(['buyer.user', 'details.product.thumbnail'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    public function updateShipping(Request $request, $id)
    {
        $order = Transaction::where('store_id', auth()->user()->store->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'tracking_number' => 'required',
            'shipping_type' => 'nullable',
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Shipping info updated!');
    }
}