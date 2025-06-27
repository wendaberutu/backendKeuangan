<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{ 
    /**
     * Display a listing of the users with role 'admin'.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil daftar user dengan role admin
        $admins = User::where('role', 'admin')->get();

        return response()->json($admins);
    }

    /**
     * Store a newly created admin user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Membuat user admin baru
        $user = User::create([
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display the specified admin user.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        // Mencari user berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah user yang diminta adalah admin
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'User is not an admin'], 400);
        }

        return response()->json($user);
    }

    /**
     * Update the specified admin user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_user' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'no_hp' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mencari user berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah user yang diminta adalah admin
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'User is not an admin'], 400);
        }

        // Update data user admin
        $user->update([
            'nama_user' => $request->input('nama_user', $user->nama_user),
            'email' => $request->input('email', $user->email),
            'no_hp' => $request->input('no_hp', $user->no_hp),
            'password' => $request->has('password') ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified admin user from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Mencari user berdasarkan ID
        $user = User::findOrFail($id);

        // Owner tidak boleh dihapus
        if ($user->role === 'owner') {
            return response()->json(['message' => 'Cannot delete owner'], 400);
        }

        // Hapus user admin
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
