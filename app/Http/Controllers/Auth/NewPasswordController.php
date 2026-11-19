<?php

namespace App\Http\Controllers\Auth;

// Mengimpor controller utama, event, request, hash, password broker, string, rules validasi, dan Inertia
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Menampilkan halaman tampilan (view) form untuk memasukkan password baru.
     */
    public function create(Request $request): Response
    {
        // Merender komponen Vue 'Auth/ResetPassword' dengan membawa data email dan token dari URL
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Menangani proses permintaan penyimpanan password baru dari pengguna.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Melakukan validasi input token, email, dan password baru beserta konfirmasinya
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Berusaha mereset password pengguna menggunakan broker Password Laravel.
        // Jika berhasil, password pada model user akan diperbarui dan disimpan ke database.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password), // Enkripsi password baru
                    'remember_token' => Str::random(60),          // Membuat ulang remember token
                ])->save();

                // Memicu event bahwa password telah berhasil di-reset
                event(new PasswordReset($user));
            }
        );

        // Jika status reset password berhasil (PASSWORD_RESET), 
        // arahkan pengguna kembali ke halaman login dengan membawa pesan sukses.
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika terjadi kesalahan (gagal), lemparkan pesan error validasi ke bagian input email
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}