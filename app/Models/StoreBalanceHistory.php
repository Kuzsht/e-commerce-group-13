<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalanceHistory extends Model
{
    protected $table = 'store_balance_histories';
    
    protected $fillable = [
        'store_balance_id', 'type', 'reference_id', 
        'reference_type', 'amount', 'remarks'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function balance()
    {
        return $this->belongsTo(StoreBalance::class, 'store_balance_id');
    }
}