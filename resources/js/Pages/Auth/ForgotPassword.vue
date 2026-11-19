<script setup>
// Mengimpor tata letak tamu (GuestLayout) dan berbagai komponen UI pendukung dari direktori proyek
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
// Mengimpor fungsi Head untuk manajemen judul halaman dan useForm untuk mengelola state formulir dari Inertia.js
import { Head, useForm } from '@inertiajs/vue3';

// Menerima props 'status' dari backend (untuk menampilkan pesan sukses pengiriman link reset password)
defineProps({
    status: {
        type: String,
    },
});

// Menginisialisasi state form menggunakan useForm dengan field 'email' yang bernilai awal kosong
const form = useForm({
    email: '',
});

// Fungsi yang dijalankan saat form dikirimkan (submit)
const submit = () => {
    // Mengirim request POST ke route 'password.email' untuk memproses pengiriman tautan reset password
    form.post(route('password.email'));
};
</script>

<template>
    <!-- Membungkus halaman dengan layout tamu -->
    <GuestLayout>
        <!-- Mengatur judul tab/meta halaman browser -->
        <Head title="Forgot Password" />

        <!-- Teks informasi penjelasan cara kerja fitur lupa password -->
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <!-- Menampilkan pesan status sukses dengan warna hijau jika status dari backend tersedia -->
        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <!-- Formulir permintaan reset password dengan event submit yang mencegah reload halaman (prevent) -->
        <form @submit.prevent="submit">
            <!-- Bagian Input Email -->
            <div>
                <!-- Label untuk input email -->
                <InputLabel for="email" value="Email" />

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

                <!-- Komponen untuk menampilkan pesan error validasi email jika terjadi kesalahan -->
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Bagian Tombol Aksi Submit -->
            <div class="mt-4 flex items-center justify-end">
                <!-- Tombol utama (PrimaryButton) yang menyesuaikan tampilan transparan dan dinonaktifkan saat form sedang diproses -->
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>