<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'tipe_transaksi',
        'no_bukti',
        'deskripsi',
        'waktu',
        'nominal',
    ];

    protected $casts = [
        'waktu' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Account (belongsTo)
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
    public function getWaktuAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y'); // Format sesuai keinginan
    }
    
}
