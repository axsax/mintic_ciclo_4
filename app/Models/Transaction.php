<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'id';
    use HasFactory;
    protected $fillable=[
        'iva',
        'buyer_id',
        'seller_id',
        'total_price'
    ];

    public function Buyer(){
        return $this->belongsTo(Buyer::class);// a Buyer have much transaction
    }
    public function Seller(){
        return $this->belongsTo(Seller::class);// a Buyer have much transaction
    }
    public function DetailTransactions(){
        return $this->hasMany(DetailTransaction::class);// a Buyer have much transaction
    }
}
