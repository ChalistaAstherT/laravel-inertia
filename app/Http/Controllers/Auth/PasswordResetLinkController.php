<?php

namespace App\Http\Controllers\Auth;

// Mengimpor controller utama, request, response, password facade untuk mengirim link, validasi, dan Inertia
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Menampilkan halaman tampilan (view) form permintaan tautan reset password.
     */
    public function create(): Response
    {
        // Merender komponen Vue 'Auth/ForgotPassword' beserta status session jika ada
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Menangani permintaan pengiriman tautan reset password ke email pengguna.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Melakukan validasi bahwa input email wajib diisi dan formatnya harus valid
        $request->validate([
            'email' => 'required|email',
        ]);

        // Mengirimkan tautan reset password ke email pengguna yang bersangkutan.
        // Hasil dari pengiriman akan diperiksa statusnya untuk menentukan pesan yang akan ditampilkan.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Jika tautan berhasil dikirim (RESET_LINK_SENT), 
        // kembalikan pengguna ke halaman sebelumnya dengan membawa pesan status sukses.
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // Jika pengiriman gagal (misal email tidak terdaftar di database), lemparkan pesan error validasi
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}