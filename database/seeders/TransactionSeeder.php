<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $user_id = 1;
        $account_ids = [1, 2, 3]; // Pastikan akun-akun sudah ada

        $data = [
            // Bulan Mei
            [
                'no_bukti' => 'TRX001',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan roti tawar 50 pcs',
                'waktu' => '2025-05-01',
                'nominal' => 100000
            ],
            [
                'no_bukti' => 'TRX002',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Pembelian tepung terigu 10 kg',
                'waktu' => '2025-05-01',
                'nominal' => 50000
            ],

            [
                'no_bukti' => 'TRX003',
                'user_id' => $user_id,
                'account_id' => $account_ids[2],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Pendapatan jasa antar roti ke pelanggan',
                'waktu' => '2025-05-02',
                'nominal' => 75000
            ],
            [
                'no_bukti' => 'TRX004',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Biaya listrik untuk produksi roti bulan Mei',
                'waktu' => '2025-05-02',
                'nominal' => 30000
            ],

            [
                'no_bukti' => 'TRX005',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan roti manis 30 pcs',
                'waktu' => '2025-05-03',
                'nominal' => 85000
            ],
            [
                'no_bukti' => 'TRX006',
                'user_id' => $user_id,
                'account_id' => $account_ids[2],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Pembelian gula dan ragi untuk produksi',
                'waktu' => '2025-05-03',
                'nominal' => 45000
            ],

            [
                'no_bukti' => 'TRX007',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan paket kue ulang tahun',
                'waktu' => '2025-05-04',
                'nominal' => 95000
            ],
            [
                'no_bukti' => 'TRX008',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Biaya pengemasan dan plastik',
                'waktu' => '2025-05-04',
                'nominal' => 60000
            ],

            [
                'no_bukti' => 'TRX009',
                'user_id' => $user_id,
                'account_id' => $account_ids[2],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan roti isi coklat',
                'waktu' => '2025-05-05',
                'nominal' => 110000
            ],
            [
                'no_bukti' => 'TRX010',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Pembelian bahan bakar untuk oven',
                'waktu' => '2025-05-05',
                'nominal' => 40000
            ],

            // Bulan Juni
            [
                'no_bukti' => 'TRX011',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan roti tawar 70 pcs',
                'waktu' => '2025-06-01',
                'nominal' => 120000
            ],
            [
                'no_bukti' => 'TRX012',
                'user_id' => $user_id,
                'account_id' => $account_ids[2],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Biaya pengiriman roti ke beberapa toko',
                'waktu' => '2025-06-01',
                'nominal' => 30000
            ],

            [
                'no_bukti' => 'TRX013',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan paket kue ulang tahun',
                'waktu' => '2025-06-02',
                'nominal' => 130000
            ],
            [
                'no_bukti' => 'TRX014',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Pembelian bahan pelengkap roti',
                'waktu' => '2025-06-02',
                'nominal' => 35000
            ],

            [
                'no_bukti' => 'TRX015',
                'user_id' => $user_id,
                'account_id' => $account_ids[2],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Pendapatan dari penjualan roti manis',
                'waktu' => '2025-06-03',
                'nominal' => 70000
            ],
            [
                'no_bukti' => 'TRX016',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Biaya gaji karyawan produksi',
                'waktu' => '2025-06-03',
                'nominal' => 50000
            ],

            [
                'no_bukti' => 'TRX017',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Penjualan roti isi kacang',
                'waktu' => '2025-06-04',
                'nominal' => 140000
            ],
            [
                'no_bukti' => 'TRX018',
                'user_id' => $user_id,
                'account_id' => $account_ids[2],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Pembelian bahan baku kacang',
                'waktu' => '2025-06-04',
                'nominal' => 55000
            ],

            [
                'no_bukti' => 'TRX019',
                'user_id' => $user_id,
                'account_id' => $account_ids[0],
                'tipe_transaksi' => 'masuk',
                'deskripsi' => 'Pendapatan dari jasa antar roti',
                'waktu' => '2025-06-05',
                'nominal' => 90000
            ],
            [
                'no_bukti' => 'TRX020',
                'user_id' => $user_id,
                'account_id' => $account_ids[1],
                'tipe_transaksi' => 'keluar',
                'deskripsi' => 'Biaya kebersihan toko',
                'waktu' => '2025-06-05',
                'nominal' => 45000
            ],
        ];

        foreach ($data as $item) {
            Transaction::create($item);
        }
    }
}
