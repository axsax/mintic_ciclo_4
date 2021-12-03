<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Product extends Eloquent
{
    use HasFactory;

    const product_avaliable='1';
    const product_not_avaliable='0';
    protected $fillable=[
        'name',
        'branch',
        'description',
        'iva',
        'quantity',
        'status',
        'price',
        'provider_id'
    ];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function DetailTransactions(){
        return $this->hasMany(DetailTransaction::class);
    }

}
