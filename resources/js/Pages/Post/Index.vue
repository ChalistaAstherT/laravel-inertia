<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps({
    posts: Object,
    filters: Object,
});

// State untuk input pencarian
const search = ref(props.filters?.search || '');

// Fungsi saat tombol Search diklik atau form di-submit
const handleSearch = () => {
    router.get(
        '/posts',
        { search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};

// Fungsi hapus data
const destroy = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        router.delete(`/posts/${id}`);
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-300">
        <!-- NAVBAR ATAS -->
        <nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <div class="flex items-center space-x-6">
                <span class="font-bold text-lg tracking-wide">LARAVEL + VUE + INERTIA.JS</span>
                <a href="/posts" class="text-gray-300 hover:text-white text-sm">POSTS</a>
                <a href="#" class="text-gray-300 hover:text-white text-sm">EBOOK</a>
                <a href="#" class="text-gray-300 hover:text-white text-sm">TUTORIAL SET</a>
            </div>

            <!-- Form Search & Tombol User -->
            <div class="flex items-center space-x-4">
                <form @submit.prevent="handleSearch" class="flex items-center space-x-2">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search"
                        class="bg-white text-black px-3 py-1.5 rounded text-sm focus:outline-none"
                    />
                    <button
                        type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-1.5 rounded transition"
                    >
                        Search
                    </button>
                </form>

                <span class="text-sm text-gray-300">Chalista asther thedresia</span>
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-1.5 rounded transition"
                >
                    Logout
                </Link>
            </div>
        </nav>

        <!-- KONTEN UTAMA -->
        <div class="max-w-6xl mx-auto mt-10 px-4">
            <!-- Tombol Tambah Data -->
            <div class="mb-6">
                <Link
                    href="/posts/create"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded font-semibold text-sm shadow transition inline-block"
                >
                    TAMBAH DATA
                </Link>
            </div>

            <!-- Card Putih & Tabel -->
            <div class="bg-white rounded-lg shadow p-6">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">TITLE</th>
                            <th class="py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">CONTENT</th>
                            <th class="py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="post in posts.data" :key="post.id">
                            <td class="py-4 text-sm text-gray-800">{{ post.title }}</td>
                            <td class="py-4 text-sm text-gray-800">{{ post.content }}</td>
                            <td class="py-4 text-center text-sm font-medium space-x-2">
                                <Link
                                    :href="`/posts/${post.id}/edit`"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-semibold"
                                >
                                    EDIT
                                </Link>
                                <button
                                    @click="destroy(post.id)"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-semibold"
                                >
                                    DELETE
                                </button>
                            </td>
                        </tr>
                        <tr v-if="posts.data.length === 0">
                            <td colspan="3" class="py-4 text-center text-sm text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>