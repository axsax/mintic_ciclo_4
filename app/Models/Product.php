<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';
    use HasFactory;

    const product_avaliable='1';
    const product_not_avaliable='0';
    protected $fillable=[
        'name',
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
