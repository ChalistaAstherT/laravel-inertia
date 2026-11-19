<script setup>
// Mengimpor komponen UI pendukung seperti Checkbox, Layout Tamu, InputError, InputLabel, Tombol, dan TextInput
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
// Mengimpor fungsi Head (untuk judul halaman), Link (untuk navigasi antar halaman), dan useForm (untuk manajemen state form) dari Inertia.js
import { Head, Link, useForm } from '@inertiajs/vue3';

// Menerima props dari backend: apakah fitur reset password aktif dan status pesan sukses
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Menginisialisasi state form login menggunakan useForm (email, password, dan remember me)
const form = useForm({
    email: '',
    password: '',
    remember: false,
});

// Fungsi yang dijalankan ketika form login dikirimkan (submit)
const submit = () => {
    // Mengirimkan data form menggunakan metode POST ke endpoint '/login'
    form.post('/login', {
        // Callback setelah proses selesai: mengosongkan field password demi keamanan
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <!-- Membungkus halaman dengan layout tamu (GuestLayout) -->
    <GuestLayout>
        <!-- Mengatur judul tab/meta halaman browser menjadi "Log in" -->
        <Head title="Log in"/>

        <!-- Menampilkan pesan status sukses dengan teks hijau jika ada dari backend -->
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <!-- Formulir login utama dengan pencegahan reload halaman secara bawaan (@submit.prevent) -->
        <form @submit.prevent="submit">
            <!-- Bagian Input Email -->
            <div>
                <!-- Label untuk input email -->
                <InputLabel for="email" value="Email"/>

                <!-- Kotak input teks tipe email yang terikat secara reaktif dengan v-model="form.email" -->
                <TextInput 
                    id="email" 
                    type="email" 
                    class="mt-1 block w-full" 
                    v-model="form.email" 
                    required 
                    autofocus 
                    autocomplete="username"
                />

                <!-- Komponen untuk menampilkan pesan error validasi email jika ada kesalahan -->
                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <!-- Bagian Input Password -->
            <div class="mt-4">
                <!-- Label untuk input password -->
                <InputLabel for="password" value="Password"/>

                <!-- Kotak input teks tipe password yang terikat secara reaktif dengan v-model="form.password" -->
                <TextInput 
                    id="password" 
                    type="password" 
                    class="mt-1 block w-full" 
                    v-model="form.password" 
                    required 
                    autocomplete="current-password"
                />

                <!-- Komponen untuk menampilkan pesan error validasi password jika ada kesalahan -->
                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <!-- Bagian Checkbox "Remember Me" -->
            <div class="block mt-4">
                <label class="flex items-center">
                    <!-- Checkbox yang terikat dengan v-model:checked="form.remember" -->
                    <Checkbox name="remember" v-model:checked="form.remember"/>
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <!-- Bagian Tombol Aksi, Register, dan Lupa Password -->
            <div class="flex items-center justify-between mt-4">
                <!-- Tautan menuju halaman pendaftaran akun baru -->
                <Link 
                    href="/register" 
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Register
                </Link>

                <div class="flex items-center">
                    <!-- Tautan menuju halaman lupa password (hanya muncul jika canResetPassword bernilai true) -->
                    <Link 
                        v-if="canResetPassword" 
                        href="/forgot-password" 
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 me-4"
                    >
                        Forgot your password?
                    </Link>

                    <!-- Tombol utama login (PrimaryButton) yang menyesuaikan efek transparan dan dinonaktifkan saat form sedang diproses -->
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>