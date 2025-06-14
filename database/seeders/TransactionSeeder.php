<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::query()->delete();

        $owner = User::where('role', 'owner')->first();

        Transaction::create([
            'waktu'           => Carbon::now(),
            'kode_akun'       => '401', // Penjualan
            'nama_transaksi'  => 'Penjualan Kontan',
            'keterangan'      => 'Penjualan barang eceran',
            'nominal'         => 1500000,
            'tipe_transaksi'  => 'masuk',
            'user_id'         => $owner->id,
        ]);

        Transaction::create([
            'waktu'           => Carbon::now(),
            'kode_akun'       => '501', // Beban Operasional
            'nama_transaksi'  => 'Bayar Listrik',
            'keterangan'      => 'Pembayaran bulan Juni',
            'nominal'         => 250000,
            'tipe_transaksi'  => 'keluar',
            'user_id'         => $owner->id,
        ]);
    }
}
