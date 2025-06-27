<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
    /* GET /api/transactions */
    public function index(): JsonResponse
    {
        try {
            $transactions = Transaction::orderBy('updated_at', 'desc')->get();

            // Tambahkan nama_akun ke setiap transaksi
            $transactions->transform(function ($transaction) {
                $transaction->nama_akun = Account::where('id', $transaction->account_id)->value('nama_akun');
                return $transaction;
            });

            return response()->json([
                'message' => 'Transaction list retrieved successfully',
                'data' => $transactions
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }





    /* GET /api/transactions/{transaction} */
    public function show(Transaction $transaction): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Transaction detail retrieved',
                'data' => [
                    'id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'account_id' => $transaction->account_id,
                    'nama_akun' => Account::where('id', $transaction->account_id)->value('nama_akun'),
                    'tipe_transaksi' => $transaction->tipe_transaksi,
                    'no_bukti' => $transaction->no_bukti,
                    'deskripsi' => $transaction->deskripsi,
                    'waktu' => \Carbon\Carbon::parse($transaction->waktu)->format('Y-m-d'),
                    'nominal' => $transaction->nominal,
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /* POST /api/transactions */
    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        try {
            $validated = $request->validate([
                'no_bukti' => 'required|string|max:50',
                'tipe_transaksi' => ['required', Rule::in(['masuk', 'keluar'])],
                'deskripsi' => 'nullable|string|max:500',
                'waktu' => 'required|date',
                'nominal' => 'required|numeric|min:0',
            ]);

            $originalNoBukti = $validated['no_bukti'];

            // Jika no_bukti tidak berubah, langsung update
            if ($originalNoBukti === $transaction->no_bukti) {
                $transaction->update($validated);
            } else {
                // Cek duplikat dan tambahkan suffix jika perlu
                $noBukti = $originalNoBukti;
                $counter = 1;

                while (
                    Transaction::where('no_bukti', $noBukti)
                    ->where('id', '!=', $transaction->id) // abaikan diri sendiri
                    ->exists()
                ) {
                    $noBukti = $originalNoBukti . '-' . $counter;
                    $counter++;
                }

                $validated['no_bukti'] = $noBukti;

                $transaction->update($validated);
            }

            return response()->json([
                'message' => 'Transaction updated successfully',
                'data' => $transaction,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'no_bukti' => 'required|string|max:50',
                'user_id' => 'required|exists:users,id',
                'account_id' => 'required|exists:accounts,id',
                'tipe_transaksi' => ['required', Rule::in(['masuk', 'keluar'])],
                'deskripsi' => 'nullable|string|max:500',
                'waktu' => 'required|date',
                'nominal' => 'required|numeric|min:0',
            ]);

            $originalNoBukti = $validated['no_bukti'];
            $noBukti = $originalNoBukti;
            $counter = 1;

            // Cek dan tambah suffix jika duplikat
            while (Transaction::where('no_bukti', $noBukti)->exists()) {
                $noBukti = $originalNoBukti . '-' . $counter;
                $counter++;
            }

            $validated['no_bukti'] = $noBukti;

            $transaction = Transaction::create($validated);

            return response()->json([
                'message' => 'Transaction created successfully',
                'data' => $transaction,
            ], 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /* PUT/PATCH /api/transactions/{transaction} */
    public function update2(Request $request, Transaction $transaction): JsonResponse
    {
        try {
            $validated = $request->validate([
                // 'no_bukti' => 'required|string|max:50|unique:transactions,no_bukti',
                // 'user_id' => 'required|exists:users,id',
                'account_id' => 'required',
                'tipe_transaksi' => ['required', Rule::in(['masuk', 'keluar'])],
                'deskripsi' => 'nullable|string|max:500',
                'waktu' => 'required|date',
                'nominal' => 'required|numeric|min:0',
            ]);

            $transaction->update($validated);

            return response()->json([
                'message' => 'Transaction updated successfully',
                'data' => $transaction,
            ], 200);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* DELETE /api/transactions/{transaction} */
    public function destroy(Transaction $transaction): JsonResponse
    {
        try {
            $transaction->delete();

            return response()->json([
                'message' => 'Transaction deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* Handle validation errors */
    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    }

    /* Handle general errors */
    private function errorResponse(Exception $e): JsonResponse
    {
        return response()->json([
            'message' => 'Something went wrong',
            'error' => $e->getMessage(), // sembunyikan kalau production
        ], 500);
    }
}
