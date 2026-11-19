<?php

namespace App\Http\Controllers\Auth;

// Mengimpor controller utama, model User, event pendaftaran, request, auth, hash, validasi, dan Inertia
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman tampilan (view) form pendaftaran akun baru.
     */
    public function create(): Response
    {
        // Merender komponen Vue 'Auth/Register' melalui Inertia
        return Inertia::render('Auth/Register');
    }

    /**
     * Menangani permintaan proses pendaftaran pengguna baru yang masuk.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Melakukan validasi input dari form registrasi (nama, email, dan password)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Membuat data user baru ke dalam database (password dienkripsi menggunakan Hash::make)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Memicu event 'Registered' (biasanya digunakan untuk mengirim email verifikasi jika diaktifkan)
        event(new Registered($user));

        // Langsung melakukan login otomatis pada pengguna yang baru saja mendaftar
        Auth::login($user);

        // Mengarahkan pengguna ke halaman tujuan setelah berhasil daftar (default ke route 'dashboard')
        return redirect(route('dashboard', absolute: false));
    }
}