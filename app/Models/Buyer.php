<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
//use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Buyer extends User
{
    use HasFactory;
    public function transactions(){
        return $this->hasMany(Transaction::class);// a Buyer have much transaction
    }
}
