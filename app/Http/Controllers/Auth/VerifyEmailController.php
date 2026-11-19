<?php

namespace App\Http\Controllers\Auth;

// Mengimpor controller utama, event Verified, request verifikasi email, dan response redirect
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Menandai alamat email pengguna yang sedang login sebagai email yang sudah terverifikasi.
     * Menggunakan __invoke karena ini adalah controller aksi tunggal (single-action).
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Mengecek apakah email pengguna sudah pernah diverifikasi sebelumnya
        if ($request->user()->hasVerifiedEmail()) {
            // Jika sudah, langsung alihkan ke halaman tujuan (default ke route 'dashboard') dengan parameter '?verified=1'
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // Jika belum dan proses penandaan email sebagai terverifikasi berhasil...
        if ($request->user()->markEmailAsVerified()) {
            // ...memicu event bahwa pengguna telah berhasil memverifikasi emailnya
            event(new Verified($request->user()));
        }

        // Mengarahkan kembali ke halaman tujuan (default ke route 'dashboard') dengan status '?verified=1'
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}