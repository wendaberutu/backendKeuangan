<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_akun',
        'jenis_akun',
        'nama_akun',
        'deskripsi',
    ];

    /**
     * An account has many transactions.
     */
 
    // Relasi satu ke banyak dengan Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
    }
    // public function getWaktuAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('d-m-Y'); // Format sesuai keinginan
    // }
}
