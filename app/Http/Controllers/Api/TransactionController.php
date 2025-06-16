<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /* GET /api/transactions */
    public function index(): JsonResponse
    {
        try {
            $transactions = Transaction::orderBy('waktu', 'desc')->get();
            return response()->json([
                'message' => 'Transaction list retrieved successfully',
                'data' => $transactions
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* GET /api/transactions/{transaction} */
    public function show(Transaction $transaction): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Transaction detail retrieved',
                'data' => $transaction,
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
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'no_bukti' => 'required|string|max:50|unique:transactions,no_bukti',
                'user_id' => 'required|exists:users,id',
                'account_id' => 'required|exists:accounts,id',
                'tipe_transaksi' => ['required', Rule::in(['masuk', 'keluar'])],
                'deskripsi' => 'nullable|string|max:500',
                'waktu' => 'required|date',
                'nominal' => 'required|numeric|min:0',
            ]);

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
    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        try {
            $validated = $request->validate([
                'no_bukti' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('transactions', 'no_bukti')->ignore($transaction->id)
                ],
                'user_id' => 'required|exists:users,id',
                'account_id' => 'required|exists:accounts,id',
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
