<?php

namespace App\Http\Controllers\Auth;

// Mengimpor controller utama, request, response redirect, facade hash untuk enkripsi, dan aturan validasi password
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Memperbarui kata sandi pengguna yang sedang aktif.
     */
    public function update(Request $request): RedirectResponse
    {
        // Melakukan validasi input dari form ubah password
        $validated = $request->validate([
            // Password saat ini wajib diisi dan harus cocok dengan password asli pengguna di database
            'current_password' => ['required', 'current_password'],
            // Password baru wajib diisi, mengikuti standar aturan password aplikasi, dan harus sesuai dengan konfirmasi password
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Mengambil data pengguna yang sedang login, lalu memperbarui passwordnya dengan yang baru (di-hash terlebih dahulu)
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Mengembalikan pengguna kembali ke halaman sebelumnya (dengan membawa status sukses)
        return back();
    }
}