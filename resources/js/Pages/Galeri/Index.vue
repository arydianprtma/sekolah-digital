<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-purple-900 to-slate-950 text-white py-12 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Galeri Dokumentasi</h1>
        <p class="text-purple-200 text-sm max-w-xl mx-auto">
          Kumpulan dokumentasi foto dan video kegiatan siswa serta acara sekolah.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div v-if="albums && albums.data && albums.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="album in albums.data" :key="album.id" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300 overflow-hidden group hover:-translate-y-1">
          <div class="h-52 bg-slate-200 relative overflow-hidden">
            <img v-if="album.cover" :src="'/storage/' + album.cover" :alt="album.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div v-else class="w-full h-full bg-gradient-to-tr from-purple-600 to-indigo-700 flex items-center justify-center text-white font-bold text-5xl opacity-80">
              🖼️
            </div>
            <span class="absolute bottom-3 right-3 bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full">
              {{ album.items_count || 0 }} Foto/Video
            </span>
          </div>

          <div class="p-6 space-y-3">
            <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-600 transition-colors">
              <Link :href="'/galeri/' + album.slug">{{ album.title }}</Link>
            </h3>
            <p v-if="album.description" class="text-xs text-slate-600 line-clamp-2">
              {{ album.description }}
            </p>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
              <span class="text-xs text-slate-400">{{ formatDate(album.published_at) }}</span>
              <Link :href="'/galeri/' + album.slug" class="text-xs font-bold text-purple-600 hover:text-purple-700">
                Lihat Album →
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-white rounded-2xl border border-slate-200">
        <p class="text-slate-500 font-medium">Belum ada album galeri yang dipublikasikan.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  albums: Object,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};
</script>
