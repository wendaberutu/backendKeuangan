<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /* GET /api/accounts */
    public function index(): JsonResponse
    {
        try {
            $accounts = Account::orderBy('kode_akun')->get();
            return response()->json([
                'message' => 'Account list retrieved successfully',
                'data' => $accounts
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* GET /api/accounts/{id} */
    public function show(Account $account): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Account detail retrieved',
                'data' => $account,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Account not found',
            ], 404);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* POST /api/accounts */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'kode_akun'   => 'required|string|max:10|unique:accounts,kode_akun',
                'jenis_akun'  => ['required', Rule::in(['aset', 'kewajiban', 'ekuitas', 'pendapatan', 'beban'])],
                'nama_akun'   => 'required|string|max:191',
                'keterangan'  => 'nullable|string',
            ]);

            $account = Account::create($validated);

            return response()->json([
                'message' => 'Account created successfully',
                'data'    => $account,
            ], 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* PUT/PATCH /api/accounts/{id} */
    public function update(Request $request, Account $account): JsonResponse
    {
        try {
            $validated = $request->validate([
                'kode_akun'   => [
                    'required',
                    'string',
                    'max:10',
                    Rule::unique('accounts', 'kode_akun')->ignore($account->id)
                ],
                'jenis_akun'  => ['required', Rule::in(['aset', 'kewajiban', 'ekuitas', 'pendapatan', 'beban'])],
                'nama_akun'   => 'required|string|max:191',
                'keterangan'  => 'nullable|string',
            ]);

            $account->update($validated);

            return response()->json([
                'message' => 'Account updated successfully',
                'data'    => $account,
            ], 200);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /* DELETE /api/accounts/{id} */
    public function destroy(Account $account): JsonResponse
    {
        try {
            $account->delete();

            return response()->json([
                'message' => 'Account deleted successfully',
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
            'errors'  => $e->errors()
        ], 422);
    }

    /* Handle general errors */
    private function errorResponse(Exception $e): JsonResponse
    {
        return response()->json([
            'message' => 'Something went wrong',
            'error'   => $e->getMessage(), // untuk dev, sembunyikan di production
        ], 500);
    }
}
