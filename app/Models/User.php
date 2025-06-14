<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'nama_user',
        'email',
        'no_hp',
        'role',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
