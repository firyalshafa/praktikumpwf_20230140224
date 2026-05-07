<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash; // Tambahkan ini untuk jaga-jaga pengecekan manual

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        try {
            // 1. Validasi input
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // 2. Cari user berdasarkan email dulu (Pengecekan manual agar lebih jelas error-nya)
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                Log::warning('[Auth - API] Login gagal untuk email: ' . $request->email);

                return response()->json([
                    'message' => 'Email atau password salah',
                ], 401);
            }

            // 3. Hapus token lama agar database tidak penuh (Opsional tapi bagus)
            $user->tokens()->delete();

            // 4. Membuat token baru
            $token = $user->createToken('api_token')->plainTextToken;
            
            Log::info('API Login berhasil: ' . $user->email);

            return response()->json([
                'message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Throwable $e) {
            // Jika masuk ke sini, cek storage/logs/laravel.log untuk detailnya
            Log::error('Error saat login API: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Terjadi kesalahan sistem',
                'error_detail' => $e->getMessage() // Matikan ini jika sudah mau dikumpulkan (Production)
            ], 500);
        }
    }
}