<?php

namespace App\Http\Controllers\Auth;

// Mengimpor controller utama, response untuk redirect/Inertia, dan request HTTP
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Menampilkan halaman pemberitahuan verifikasi email (__invoke digunakan untuk controller single-action).
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        // Mengecek apakah email pengguna sudah diverifikasi
        return $request->user()->hasVerifiedEmail()
                    // Jika sudah, langsung dialihkan ke halaman tujuan (default ke route 'dashboard')
                    ? redirect()->intended(route('dashboard', absolute: false))
                    // Jika belum, tampilkan halaman komponen Vue 'Auth/VerifyEmail' beserta status session-nya
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}