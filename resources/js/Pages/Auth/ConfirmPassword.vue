<script setup>
// Mengimpor tata letak tamu (GuestLayout) dan komponen UI pendukung dari direktori proyek
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
// Mengimpor fungsi Head untuk manajemen judul halaman dan useForm untuk mengelola state formulir dari Inertia.js
import { Head, useForm } from '@inertiajs/vue3';

// Menginisialisasi state form menggunakan useForm untuk menampung input password
const form = useForm({
    password: '',
});

// Fungsi yang dijalankan saat form konfirmasi password dikirimkan (submit)
const submit = () => {
    // Mengirim request POST ke route 'password.confirm'
    form.post(route('password.confirm'), {
        // Callback yang dijalankan setelah proses selesai (mengosongkan input password)
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <!-- Membungkus halaman menggunakan layout tamu -->
    <GuestLayout>
        <!-- Menentukan judul tab/meta halaman browser -->
        <Head title="Confirm Password" />

        <!-- Pesan informasi teks bahwa area ini aman dan memerlukan konfirmasi password -->
        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <!-- Formulir konfirmasi password dengan event submit yang mencegah reload halaman (prevent) -->
        <form @submit.prevent="submit">
            <!-- Bagian Input Password -->
            <div>
                <!-- Label untuk input password -->
                <InputLabel for="password" value="Password" />
                <!-- Kotak input teks tipe password yang terikat dengan v-model="form.password" -->
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <!-- Komponen untuk menampilkan pesan error validasi password jika ada -->
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Bagian Tombol Aksi Konfirmasi -->
            <div class="mt-4 flex justify-end">
                <!-- Tombol utama (PrimaryButton) yang menonaktifkan tombol atau memberi efek transparan saat form sedang diproses -->
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>