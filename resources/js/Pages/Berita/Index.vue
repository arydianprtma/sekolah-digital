<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-blue-900 to-indigo-950 text-white py-12 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kabar & Berita Sekolah</h1>
        <p class="text-slate-300 text-sm max-w-xl mx-auto">
          Dapatkan berita dan prestasi terbaru seputar kegiatan di Digital School.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div v-if="news_list && news_list.data && news_list.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="news in news_list.data" :key="news.id" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group hover:-translate-y-1">
          <div class="h-48 bg-slate-200 relative overflow-hidden">
            <img v-if="news.thumbnail" :src="'/storage/' + news.thumbnail" :alt="news.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div v-else class="w-full h-full bg-gradient-to-tr from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold opacity-80">
              <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <span v-if="news.category" class="absolute top-4 left-4 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
              {{ news.category.name }}
            </span>
          </div>

          <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
            <div class="space-y-2">
              <div class="text-xs text-slate-400 font-medium">
                {{ formatDate(news.published_at) }} • {{ news.views_count || 0 }} x dilihat
              </div>
              <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                <Link :href="'/berita/' + news.slug">{{ news.title }}</Link>
              </h3>
              <p class="text-slate-600 text-xs leading-relaxed line-clamp-3">
                {{ news.excerpt || news.title }}
              </p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
              <span class="text-xs font-semibold text-slate-500">Oleh: {{ news.author?.name || 'Admin' }}</span>
              <Link :href="'/berita/' + news.slug" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                Baca Selengkapnya →
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-white rounded-2xl border border-slate-200">
        <p class="text-slate-500 font-medium">Belum ada berita yang dipublikasikan.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  news_list: Object,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};
</script>
