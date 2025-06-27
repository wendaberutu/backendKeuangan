<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * GET /api/laporan/jurnal-umum?bulan=06&tahun=2025
     */
    public function getJurnalUmumByMonth(Request $request): JsonResponse
    {
        try {
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');

            if (!$bulan || !$tahun) {
                return response()->json([
                    'message' => 'Parameter bulan dan tahun wajib diisi.'
                ], 422);
            }

            // Ambil semua transaksi + relasi akun
            $transaksi = Transaction::with('account')
                ->whereMonth('waktu', $bulan)
                ->whereYear('waktu', $tahun)
                ->orderBy('waktu')
                ->get();

            $rows = [];
            $saldo = 0;
            $total_masuk = 0;
            $total_keluar = 0;

            foreach ($transaksi as $item) {
                $debet = $item->tipe_transaksi === 'masuk' ? $item->nominal : 0;
                $kredit = $item->tipe_transaksi === 'keluar' ? $item->nominal : 0;

                // Update saldo: saldo sebelumnya + debet - kredit
                $saldo += ($debet - $kredit);

                // Tambah ke total
                $total_masuk += $debet;
                $total_keluar += $kredit;

                $rows[] = [
                    'tanggal' => $item->waktu,
                    'no_bukti' => $item->no_bukti,
                    'nama_akun' => $item->account->nama_akun,
                    'deskripsi' => $item->deskripsi,
                    'debet' => $debet,
                    'kredit' => $kredit,
                    'saldo' => $saldo
                ];
            }

            return response()->json([
                'message' => "Data jurnal umum berhasil diambil. ({$bulan}-{$tahun})",
                'data' => $rows,
                'total_masuk' => $total_masuk,
                'total_keluar' => $total_keluar,
                'total_saldo' => $saldo
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getJurnalUmumByMonth1(Request $request): JsonResponse
    {
        try {
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');

            if (!$bulan || !$tahun) {
                return response()->json([
                    'message' => 'Parameter bulan dan tahun wajib diisi.'
                ], 422);
            }

            $transaksi = Transaction::with('account')
                ->whereMonth('waktu', $bulan)
                ->whereYear('waktu', $tahun)
                ->orderBy('waktu')
                ->get();

            return response()->json([
                'message' => "Data jurnal umum berhasil diambil. ({$bulan}-{$tahun})",
                'data' => $transaksi
            ], 200 );
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * GET /api/laporan/buku-besar?nama_rekening=Kas
     */
    public function getBukuBesarByRekening(Request $request): JsonResponse
    {
        try {
            $namaRekening = $request->input('nama_rekening');

            if (!$namaRekening) {
                return response()->json([
                    'message' => 'Parameter nama_rekening wajib diisi.'
                ], 422);
            }

            $transaksi = Transaction::with('account')
                ->whereHas('account', function ($query) use ($namaRekening) {
                    $query->where('nama_akun', $namaRekening);
                })
                ->orderBy('waktu')
                ->get();

            return response()->json([
                'message' => 'Data buku besar berhasil diambil.',
                'data' => $transaksi
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }


    public function getSaldoPerAkun()
    {
        try {
            // Mengambil semua akun beserta transaksi yang terkait
            $accounts = Account::with(['transactions' => function ($query) {
                $query->orderBy('waktu', 'asc');
            }])->get();

            if ($accounts->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada akun atau transaksi'
                ], 404);
            }

            $result = [];

            foreach ($accounts as $account) {
                $transactions = $account->transactions;  // Mengambil transaksi untuk setiap akun

                // Skip akun yang tidak memiliki transaksi
                if ($transactions->isEmpty()) {
                    continue;  // Jika tidak ada transaksi, lewati akun ini
                }

                $saldo = 0;
                $accountResult = [];

                foreach ($transactions as $transaction) {
                    if ($transaction->tipe_transaksi == 'masuk') {
                        $masuk = $transaction->nominal;
                        $keluar = 0;
                        $saldo += $masuk;
                    } else {
                        $masuk = 0;
                        $keluar = $transaction->nominal;
                        $saldo -= $keluar;
                    }

                    // Mengambil waktu yang sudah diformat
                    $waktu = $transaction->waktu; // Sudah diformat dalam model

                    // Menyusun data transaksi per akun
                    $accountResult[] = [
                        'no_bukti' => $transaction->no_bukti,  // Menambahkan no_bukti
                        'kode_akun' => $account->kode_akun,    // Menambahkan kode_akun
                        'nama_akun' => $account->nama_akun,    // Menambahkan nama_akun
                        'waktu' => $waktu,  // Waktu sudah diformat
                        'deskripsi' => $transaction->deskripsi,
                        'masuk' => $masuk,
                        'keluar' => $keluar,
                        'saldo' => $saldo
                    ];
                }

                // Menyimpan hasil transaksi yang dikelompokkan berdasarkan nama akun
                $result[$account->nama_akun] = $accountResult;
            }

            return response()->json([
                'status' => 'success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function neraca(Request $request)
    {
        // Tanggal akhir default: hari ini (bisa override via query param ?tanggal=YYYY-MM-DD)
        $tanggal_akhir = $request->query('tanggal', now()->format('Y-m-d'));

        // Jenis akun yang ditampilkan di Neraca
        $jenisAkuns = ['aset', 'kewajiban', 'ekuitas'];

        $data = [];

        foreach ($jenisAkuns as $jenis) {
            $akunList = Account::where('jenis_akun', $jenis)->get();
            $detail = [];
            $total = 0;

            foreach ($akunList as $akun) {
                $masuk = Transaction::where('account_id', $akun->id)
                    ->where('tipe_transaksi', 'masuk')
                    ->whereDate('waktu', '<=', $tanggal_akhir)
                    ->sum('nominal');

                $keluar = Transaction::where('account_id', $akun->id)
                    ->where('tipe_transaksi', 'keluar')
                    ->whereDate('waktu', '<=', $tanggal_akhir)
                    ->sum('nominal');

                // Saldo akhir akun
                $saldo = $masuk - $keluar;

                $detail[] = [
                    'kode_akun' => $akun->kode_akun,
                    'nama_akun' => $akun->nama_akun,
                    'saldo'     => $saldo,
                ];

                $total += $saldo;
            }

            $data[$jenis] = [
                'total' => $total,
                'akun'  => $detail,
            ];
        }

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'tanggal' => $tanggal_akhir,
        ]);
    }

  
    public function labaRugi(Request $request)
    {
        $tanggal_awal = $request->query('awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggal_akhir = $request->query('akhir', now()->format('Y-m-d'));

        $result = [
            'pendapatan' => [],
            'beban' => [],
            'total_pendapatan' => 0,
            'total_beban' => 0,
            'laba_bersih' => 0,
            'periode' => [
                'awal' => $tanggal_awal,
                'akhir' => $tanggal_akhir,
            ],
        ];

        // Pendapatan
        $akunPendapatan = \App\Models\Account::where('jenis_akun', 'pendapatan')->get();

        foreach ($akunPendapatan as $akun) {
            $total = \App\Models\Transaction::where('account_id', $akun->id)
                ->where('tipe_transaksi', 'masuk')
                ->whereBetween('waktu', [$tanggal_awal, $tanggal_akhir])
                ->sum('nominal');

            $result['pendapatan'][] = [
                'kode_akun' => $akun->kode_akun,
                'nama_akun' => $akun->nama_akun,
                'total' => $total,
            ];

            $result['total_pendapatan'] += $total;
        }

        // Beban
        $akunBeban = \App\Models\Account::where('jenis_akun', 'beban')->get();

        foreach ($akunBeban as $akun) {
            $total = \App\Models\Transaction::where('account_id', $akun->id)
                ->where('tipe_transaksi', 'keluar')
                ->whereBetween('waktu', [$tanggal_awal, $tanggal_akhir])
                ->sum('nominal');

            $result['beban'][] = [
                'kode_akun' => $akun->kode_akun,
                'nama_akun' => $akun->nama_akun,
                'total' => $total,
            ];

            $result['total_beban'] += $total;
        }

        $result['laba_bersih'] = $result['total_pendapatan'] - $result['total_beban'];

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }






    /* Error helper */
    private function errorResponse(Exception $e): JsonResponse
    {
        return response()->json([
            'message' => 'Terjadi kesalahan.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
