<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends User
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class);
    }
}
