<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-gray-100">
        <!-- NAVBAR ATAS -->
        <nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <div class="flex items-center space-x-6">
                <span class="font-bold text-lg tracking-wide">LARAVEL + VUE + INERTIA.JS</span>
                <a href="#" class="text-gray-300 hover:text-white text-sm">POSTS</a>
                <a href="#" class="text-gray-300 hover:text-white text-sm">EBOOK</a>
            </div>

            <div class="flex items-center space-x-4">
                <Link
                    href="/login"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded transition"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    href="/register"
                    class="border border-white text-white hover:bg-white hover:text-black text-sm px-4 py-2 rounded transition"
                >
                    Register
                </Link>
            </div>
        </nav>

        <!-- KONTEN LANDING PAGE -->
        <div class="max-w-4xl mx-auto mt-20 p-8 bg-white rounded-lg shadow text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang</h1>
            <p class="text-gray-600 mb-6">Silakan klik tombol Log in di navbar atas untuk masuk ke halaman login.</p>
            <Link
                href="/login"
                class="inline-block bg-blue-600 text-white font-semibold px-6 py-2.5 rounded hover:bg-blue-700 transition"
            >
                Masuk ke Halaman Login
            </Link>
        </div>
    </div>
</template>