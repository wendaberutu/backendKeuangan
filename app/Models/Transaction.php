<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'waktu',
        'kode_akun',
        'nama_transaksi',
        'keterangan',
        'nominal',
        'tipe_transaksi',
        'user_id',
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    /**
     * Transaction belongs to an account.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'kode_akun', 'kode_akun');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
