<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|integer',
            'product_id'     => 'required|integer',
            'rating'         => 'required|integer|min:1|max:5',
            'review'         => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        $buyer = $user->buyer;

        if (!$buyer) {
            return back()->with('error', 'You must be a buyer to leave a review.');
        }

        $transactionId = $request->transaction_id;
        $productId     = $request->product_id;

        $detail = TransactionDetail::where('product_id', $productId)
            ->where('transaction_id', $transactionId)
            ->whereHas('transaction', function ($q) use ($buyer) {
                $q->where('buyer_id', $buyer->id)
                  ->where('payment_status', 'paid');
            })
            ->first();

        if (!$detail) {
            return back()->with('error', 'You are not allowed to review this product.');
        }

        $existing = ProductReview::where('transaction_id', $transactionId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product for this order.');
        }

        ProductReview::create([
            'transaction_id' => $transactionId,
            'product_id'     => $productId,
            'rating'         => $request->rating,
            'review'         => $request->review,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
