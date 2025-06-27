<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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

    // Implementasi dari metode JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Tambahkan relasi accounts
    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
            'nama_user' => $this->nama_user,
            'user_id' => $this->id,
        ];
    }
}
