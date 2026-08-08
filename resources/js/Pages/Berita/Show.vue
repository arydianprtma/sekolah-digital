<template>
  <MainLayout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
      <div class="space-y-4 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold uppercase">
          {{ news.category?.name || 'Berita Sekolah' }}
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight">
          {{ news.title }}
        </h1>
        <div class="text-xs text-slate-500 font-medium flex items-center justify-center gap-4 border-y border-slate-200 py-3">
          <span>Dipublikasikan: {{ formatDate(news.published_at) }}</span>
          <span>•</span>
          <span>Penulis: {{ news.author?.name || 'Admin Sekolah' }}</span>
          <span>•</span>
          <span>Dilihat: {{ news.views_count }} kali</span>
        </div>
      </div>

      <div v-if="news.thumbnail" class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 max-h-[450px]">
        <img :src="'/storage/' + news.thumbnail" :alt="news.title" class="w-full h-full object-cover">
      </div>

      <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-xs prose prose-slate max-w-none prose-img:rounded-xl leading-relaxed text-slate-700" v-html="news.content">
      </div>

      <div v-if="news.tags && news.tags.length" class="flex items-center gap-2 pt-4 border-t border-slate-200">
        <span class="text-xs font-bold text-slate-400 uppercase">Tag:</span>
        <span v-for="tag in news.tags" :key="tag.id" class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold">
          #{{ tag.name }}
        </span>
      </div>

      <!-- Related News -->
      <div v-if="related_news && related_news.length" class="pt-8 border-t border-slate-200 space-y-6">
        <h3 class="text-xl font-extrabold text-slate-900">Berita Terkait</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="item in related_news" :key="item.id" class="bg-white rounded-xl border border-slate-200 p-4 hover:shadow-md transition-all">
            <h4 class="font-bold text-sm text-slate-900 line-clamp-2 mb-2 hover:text-blue-600">
              <Link :href="'/berita/' + item.slug">{{ item.title }}</Link>
            </h4>
            <span class="text-xs text-slate-400 block">{{ formatDate(item.published_at) }}</span>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  news: Object,
  related_news: Array,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};
</script>
