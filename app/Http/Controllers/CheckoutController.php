<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty.');
        }

        $itemsTotal = collect($cartItems)->sum('subtotal');

        $shippingCosts = [
            'regular'   => 15000,
            'express'   => 25000,
            'same-day'  => 50000,
        ];

        $shippingType = 'regular';
        $shippingCost = $shippingCosts[$shippingType];

        $tax = (int) round($itemsTotal * 0.05);

        $grandTotal = $itemsTotal + $shippingCost + $tax;

        return view('checkout.index', compact(
            'cartItems',
            'itemsTotal',
            'shippingCosts',
            'shippingType',
            'shippingCost',
            'tax',
            'grandTotal'
        ));
    }

    public function buyNow(Request $request, Product $product)
    {
        $request->validate([
            'product_size_id' => 'required|exists:product_sizes,id',
            'qty'             => 'required|integer|min:1',
        ]);

        $variant = ProductSize::where('product_id', $product->id)
            ->findOrFail($request->product_size_id);

        if ($variant->stock < $request->qty) {
            return back()->with('error', 'Not enough stock for selected variant.');
        }

        $qty      = (int) $request->qty;
        $subtotal = $product->price * $qty;

        $cartItems = [
            [
                'product_id'       => $product->id,
                'product_name'     => $product->name,
                'product_price'    => $product->price,
                'product_size_id'  => $variant->id,
                'color'            => $variant->color,
                'size'             => $variant->size,
                'qty'              => $qty,
                'subtotal'         => $subtotal,
                'store_id'         => $product->store_id,
            ],
        ];

        session(['cart' => $cartItems]);

        return redirect()->route('checkout.index');
    }

    public function process(Request $request)
    {
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
            'address'           => 'required|string',
            'city'              => 'required|string',
            'postal_code'       => 'required|string',
            'shipping'          => 'required|string',
            'shipping_type'     => 'required|string|in:regular,express,same-day',
            'payment_method'    => 'required|string|in:bank_transfer,credit_card,ewallet',
            'payment_reference' => 'nullable|string|max:255',
            'bank_account'      => 'nullable|string|max:50',
            'credit_card'       => 'nullable|string|max:50',
            'ewallet'           => 'nullable|string|max:50',
        ]);

        $itemsTotal = collect($cartItems)->sum('subtotal');

        $shippingCosts = [
            'regular'   => 15000,
            'express'   => 25000,
            'same-day'  => 50000,
        ];

        $shippingType = $data['shipping_type'];
        $shippingCost = $shippingCosts[$shippingType] ?? $shippingCosts['regular'];

        $tax = (int) round($itemsTotal * 0.05);

        $grandTotal = $itemsTotal + $shippingCost + $tax;

        $firstItem = $cartItems[0];

        DB::beginTransaction();

        try {
            $trackingNumber = method_exists(Transaction::class, 'generateTrackingNumber')
                ? Transaction::generateTrackingNumber()
                : null;

            $transaction = Transaction::create([
                'code'           => 'TRX-' . Str::upper(Str::random(8)),
                'buyer_id'       => auth()->user()->buyer->id,
                'store_id'       => $firstItem['store_id'],

                'address_id'     => (string) Str::uuid(),
                'address'        => $data['address'],
                'city'           => $data['city'],
                'postal_code'    => $data['postal_code'],

                'shipping'       => $data['shipping'],
                'shipping_type'  => $shippingType,
                'shipping_cost'  => $shippingCost,
                'tracking_number'=> $trackingNumber,

                'tax'            => $tax,
                'grand_total'    => $grandTotal,
                'payment_status' => 'paid',
            ]);

            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['product_id'],
                    'qty'            => $item['qty'],
                    'size'           => $item['size'] ?? null,
                    'color'          => $item['color'] ?? null,
                    'subtotal'       => $item['subtotal'],
                ]);

                if (!empty($item['size'])) {
                    $sizeRowQuery = ProductSize::where('product_id', $item['product_id'])
                        ->where('size', $item['size']);

                    if (!empty($item['color'])) {
                        $sizeRowQuery->where('color', $item['color']);
                    }

                    $sizeRow = $sizeRowQuery->lockForUpdate()->first();

                    if ($sizeRow && $sizeRow->stock >= $item['qty']) {
                        $sizeRow->decrement('stock', $item['qty']);
                    }

                    $totalSizeStock = ProductSize::where('product_id', $item['product_id'])->sum('stock');
                    Product::where('id', $item['product_id'])->update(['stock' => $totalSizeStock]);
                }
            }

            $storeBalance = StoreBalance::firstOrCreate(
                ['store_id' => $transaction->store_id],
                ['balance'  => 0]
            );

            $storeBalance->balance += $transaction->grand_total;
            $storeBalance->save();

            if (method_exists($storeBalance, 'histories')) {
                $storeBalance->histories()->create([
                    'type'         => 'income',
                    'amount'       => $transaction->grand_total,
                    'remarks'      => 'Income from order ' . $transaction->code,
                    'reference_id' => $transaction->id,   // 👈 penting
                    'reference_type' => 'transaction',
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Payment successful! Your order has been placed.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Failed to process transaction: ' . $th->getMessage());
        }
    }
}
