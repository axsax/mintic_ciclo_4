<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable;


    const user_verified ='1';
    const user_not_verified ='0';
    const user_admin ='true';
    const user_not_admin ='false';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'verified',
        'verification_token',
        'admin',
        'role'
    ];

    public function setNameAttribute($valor){
        $this->attributes['name']= strtolower($valor);
    }
    public function getNameAttribute($valor){
        return ucfirst($valor);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified(){
        return $this->verified == User::user_verified;
    }
    public function isAdmin(){
        return $this->admin == User::user_verified;
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);// a Buyer have much transaction
    }
}
