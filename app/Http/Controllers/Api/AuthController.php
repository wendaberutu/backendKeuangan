<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\JWTSubject;  // Import JWTSubject

use App\Models\User;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Cek kredensial dan buat token
        try {
            $credentials = $request->only('email', 'password');
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized: Invalid credentials'], 401);
            }

            // Jika login berhasil, kirimkan token
            // Dapatkan informasi pengguna
            $user = JWTAuth::user();  // Mengambil pengguna yang sedang login
            return response()->json(['token' => $token, 'role' => $user->role, 'nama_user'=>$user->nama_user], 200);
        } catch (Exception $e) {
            // Tangani kesalahan jika terjadi (misalnya, kesalahan server atau token tidak dapat dibuat)
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }


    // Function to handle logout
    public function logout(Request $request)
    {
        try {
            // Menghapus token dari sesi
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }
}
