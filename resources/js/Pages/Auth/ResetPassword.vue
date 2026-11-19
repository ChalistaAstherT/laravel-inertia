<script setup>
// Mengimpor tata letak tamu (GuestLayout) dan berbagai komponen UI pendukung dari direktori proyek
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
// Mengimpor fungsi Head untuk manajemen judul halaman dan useForm untuk mengelola state formulir dari Inertia.js
import { Head, useForm } from '@inertiajs/vue3';

// Menerima props 'email' dan 'token' yang dikirimkan secara wajib dari backend melalui URL reset password
const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

// Menginisialisasi state form menggunakan useForm dengan nilai awal token, email dari props, serta field password kosong
const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

// Fungsi yang dijalankan saat form reset password dikirimkan (submit)
const submit = () => {
    // Mengirim request POST ke route 'password.store' untuk menyimpan password baru
    form.post(route('password.store'), {
        // Callback setelah proses selesai: mengosongkan input field password dan konfirmasi password demi keamanan
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- Membungkus halaman dengan layout tamu -->
    <GuestLayout>
        <!-- Mengatur judul tab/meta halaman browser menjadi "Reset Password" -->
        <Head title="Reset Password" />

        <!-- Formulir reset password dengan pencegahan reload halaman secara bawaan (@submit.prevent) -->
        <form @submit.prevent="submit">
            <!-- Bagian Input Email (terisi otomatis dari props token) -->
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

                <!-- Komponen untuk menampilkan pesan error validasi email jika ada kesalahan -->
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Bagian Input Password Baru -->
            <div class="mt-4">
                <!-- Label untuk input password baru -->
                <InputLabel for="password" value="Password" />

                <!-- Kotak input teks tipe password yang terikat secara reaktif dengan v-model="form.password" -->
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <!-- Komponen untuk menampilkan pesan error validasi password jika ada kesalahan -->
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Bagian Input Konfirmasi Password Baru -->
            <div class="mt-4">
                <!-- Label untuk konfirmasi password -->
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <!-- Kotak input konfirmasi password yang terikat secara reaktif dengan v-model="form.password_confirmation" -->
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <!-- Komponen untuk menampilkan pesan error konfirmasi password jika tidak cocok -->
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <!-- Bagian Tombol Aksi Submit Reset Password -->
            <div class="mt-4 flex items-center justify-end">
                <!-- Tombol utama (PrimaryButton) yang menyesuaikan tampilan transparan dan dinonaktifkan saat form sedang diproses -->
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>