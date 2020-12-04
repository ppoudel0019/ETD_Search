<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;



class History extends Model
{

    protected $fillable = [
        'title','sourceURL'
    ];

    public $timestamps = false;

    /*public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory; */
}
