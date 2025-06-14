<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::query()->delete();

        $accounts = [
            ['kode_akun' => '101', 'jenis_akun' => 'aset', 'nama_akun' => 'Kas',               'keterangan' => 'Saldo kas tunai'],
            ['kode_akun' => '102', 'jenis_akun' => 'aset', 'nama_akun' => 'Piutang Usaha',     'keterangan' => null],
            ['kode_akun' => '201', 'jenis_akun' => 'kewajiban', 'nama_akun' => 'Utang Usaha', 'keterangan' => null],
            ['kode_akun' => '301', 'jenis_akun' => 'ekuitas', 'nama_akun' => 'Modal Pemilik', 'keterangan' => null],
            ['kode_akun' => '401', 'jenis_akun' => 'pendapatan', 'nama_akun' => 'Penjualan',  'keterangan' => null],
            ['kode_akun' => '501', 'jenis_akun' => 'beban', 'nama_akun' => 'Beban Operasional', 'keterangan' => null],
        ];

        Account::insert($accounts);
    }
}
