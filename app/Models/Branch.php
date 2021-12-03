<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Branch extends Eloquent
{
    use HasFactory;
    protected $fillable=[
        'name',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }
}
