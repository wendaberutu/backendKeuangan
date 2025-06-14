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
        'keterangan',
    ];

    /**
     * An account has many transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'kode_akun', 'kode_akun');
    }
}
