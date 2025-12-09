<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'store_balance_id', 'amount', 'bank_account_name', 
        'bank_account_number', 'bank_name', 'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class, 'store_balance_id');
    }

    public function store()
    {
        return $this->hasOneThrough(
            Store::class,
            StoreBalance::class,
            'id',
            'id',
            'store_balance_id',
            'store_id'
        );
    }
}