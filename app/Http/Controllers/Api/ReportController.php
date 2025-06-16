<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Exception;

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

            $transaksi = Transaction::with('account')
                ->whereMonth('waktu', $bulan)
                ->whereYear('waktu', $tahun)
                ->orderBy('waktu')
                ->get();

            return response()->json([
                'message' => "Data jurnal umum berhasil diambil. ({$bulan}-{$tahun})",
                'data' => $transaksi
            ]);
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
            ]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
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
