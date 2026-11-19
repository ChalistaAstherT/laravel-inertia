// Mengimpor konfigurasi bootstrap (misalnya Axios atau pustaka pendukung HTTP)
import './bootstrap';
// Mengimpor file stylesheet utama CSS
import '../css/app.css';

// Mengimpor fungsi createApp dan h (render function) dari Vue 3
import { createApp, h } from 'vue';
// Mengimpor fungsi createInertiaApp untuk menginisialisasi aplikasi Inertia.js
import { createInertiaApp } from '@inertiajs/vue3';
// Mengimpor helper untuk memuat komponen halaman Vue secara dinamis menggunakan plugin Vite Laravel
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Mengambil nama aplikasi dari environment variable (VITE_APP_NAME), jika tidak ada default ke 'Laravel'
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Menginisialisasi aplikasi Inertia.js
createInertiaApp({
    // Mengatur format judul halaman dinamis (menggabungkan judul komponen dengan nama aplikasi)
    title: (title) => `${title} - ${appName}`,
    // Menyelesaikan/memuat komponen halaman Vue secara otomatis dari direktori './Pages/' berdasarkan nama
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    // Fungsi setup untuk memasang (mount) aplikasi Vue ke elemen DOM HTML
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin) // Mendaftarkan plugin Inertia.js ke Vue
            .mount(el);   // Melakukan mounting aplikasi ke elemen root HTML
    },
    // Konfigurasi indikator progress bar saat terjadi perpindahan halaman Inertia
    progress: {
        color: '#4B5563', // Warna abu-abu untuk garis progress bar
    },
});