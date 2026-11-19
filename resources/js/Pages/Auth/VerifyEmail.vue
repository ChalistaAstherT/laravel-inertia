<script setup>
// Mengimpor fungsi computed dari Vue untuk membuat properti reaktif turunan
import { computed } from 'vue';
// Mengimpor tata letak tamu (GuestLayout) dan komponen tombol utama (PrimaryButton)
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
// Mengimpor fungsi Head (judul halaman), Link (navigasi), dan useForm (manajemen state form) dari Inertia.js
import { Head, Link, useForm } from '@inertiajs/vue3';

// Menerima props 'status' dari backend (untuk mengecek status pengiriman email verifikasi)
const props = defineProps({
    status: {
        type: String,
    },
});

// Menginisialisasi state form kosong menggunakan useForm untuk pengiriman ulang verifikasi
const form = useForm({});

// Fungsi yang dijalankan saat tombol "Resend Verification Email" dikirimkan (submit)
const submit = () => {
    // Mengirimkan request POST ke route 'verification.send'
    form.post(route('verification.send'));
};

// Membuat computed property untuk mengecek apakah status bernilai 'verification-link-sent'
const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <!-- Membungkus halaman dengan layout tamu -->
    <GuestLayout>
        <!-- Mengatur judul tab/meta halaman browser menjadi "Email Verification" -->
        <Head title="Email Verification" />

        <!-- Teks informasi ucapan terima kasih dan instruksi untuk memeriksa email verifikasi -->
        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        <!-- Menampilkan pesan sukses berwarna hijau jika tautan verifikasi baru berhasil dikirim -->
        <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <!-- Formulir pengiriman ulang email verifikasi dengan pencegahan reload halaman (@submit.prevent) -->
        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <!-- Tombol utama (PrimaryButton) untuk mengirim ulang email verifikasi dengan efek proses -->
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </PrimaryButton>

                <!-- Tautan untuk keluar (Log Out) yang mengirimkan request POST ke route 'logout' -->
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >Log Out</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>