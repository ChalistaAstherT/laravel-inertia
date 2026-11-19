<script setup>
// Mengimpor tata letak utama aplikasi (App.vue)
import Layout from '../../Layouts/App.vue'
// Mengimpor fungsi useForm (untuk manajemen state form), Head (untuk judul halaman), dan Link (untuk navigasi) dari Inertia.js
import { useForm, Head, Link } from '@inertiajs/vue3'

// Menginisialisasi state form pendaftaran menggunakan useForm dengan field name, email, password, dan konfirmasi password
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

// Fungsi yang dijalankan ketika form register dikirimkan (submit)
const submit = () => {
    // Mengirimkan data form menggunakan metode POST ke endpoint '/register'
    form.post('/register', {
        // Callback setelah proses selesai: mengosongkan input field password dan konfirmasi password demi keamanan
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <!-- Membungkus halaman dengan komponen layout utama -->
    <Layout>
        <!-- Mengatur judul tab/meta halaman browser menjadi "Register" -->
        <Head title="Register" />

        <!-- Baris tata letak untuk memposisikan kotak card di tengah layar -->
        <div class="row justify-content-center">
            <div class="col-md-5">
                <!-- Kartu pembungkus form dengan sudut melengkung dan efek bayangan tipis -->
                <div class="card border-0 rounded shadow-sm">
                    <div class="card-body p-4">
                        <!-- Judul formulir pendaftaran -->
                        <h4 class="fw-bold text-center mb-4">REGISTER USER</h4>
                        <hr>

                        <!-- Formulir registrasi dengan pencegahan reload halaman secara bawaan (@submit.prevent) -->
                        <form @submit.prevent="submit">
                            <!-- Bagian Input Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <!-- Kotak input teks untuk nama yang terikat reaktif dengan v-model="form.name" -->
                                <input type="text" class="form-control" v-model="form.name" placeholder="Masukkan Nama" required autofocus />
                                <!-- Menampilkan pesan error validasi nama jika ada dari backend -->
                                <div v-if="form.errors.name" class="text-danger small mt-1">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Bagian Input Email -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <!-- Kotak input teks tipe email yang terikat reaktif dengan v-model="form.email" -->
                                <input type="email" class="form-control" v-model="form.email" placeholder="Masukkan Email" required />
                                <!-- Menampilkan pesan error validasi email jika ada kesalahan -->
                                <div v-if="form.errors.email" class="text-danger small mt-1">
                                    {{ form.errors.email }}
                                </div>
                            </div>

                            <!-- Bagian Input Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <!-- Kotak input teks tipe password yang terikat reaktif dengan v-model="form.password" -->
                                <input type="password" class="form-control" v-model="form.password" placeholder="Masukkan Password" required />
                                <!-- Menampilkan pesan error validasi password jika ada kesalahan -->
                                <div v-if="form.errors.password" class="text-danger small mt-1">
                                    {{ form.errors.password }}
                                </div>
                            </div>

                            <!-- Bagian Input Konfirmasi Password -->
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <!-- Kotak input konfirmasi password yang terikat reaktif dengan v-model="form.password_confirmation" -->
                                <input type="password" class="form-control" v-model="form.password_confirmation" placeholder="Ulangi Password" required />
                            </div>

                            <!-- Bagian Tombol Aksi Submit Register -->
                            <div class="d-grid gap-2 mb-3">
                                <!-- Tombol hijau (btn-success) yang dinonaktifkan ketika form sedang diproses (:disabled="form.processing") -->
                                <button type="submit" class="btn btn-success" :disabled="form.processing">
                                    REGISTER
                                </button>
                            </div>

                            <!-- Bagian Tautan Navigasi Alternatif Menuju Halaman Login -->
                            <div class="text-center">
                                <small>Sudah punya akun? <Link href="/login" class="text-decoration-none">Login di sini</Link></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>