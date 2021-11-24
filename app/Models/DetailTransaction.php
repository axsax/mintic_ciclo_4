<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class DetailTransaction extends Eloquent
{
    protected $primaryKey = 'id';
    use HasFactory;
    protected $fillable=[
        'quantity',
        'product_id',
        'transaction_id'
    ];

    public function transactions(){
        return $this->belongsTo(Transaction::class);// a Buyer have much transaction
    }

    public function products(){
        return $this->belongsTo(Products::class);// a Buyer have much transaction
    }
}
