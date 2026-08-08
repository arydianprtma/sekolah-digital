<template>
  <MainLayout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
      <div class="space-y-4 text-center">
        <div class="inline-flex items-center gap-2">
          <span :class="getPriorityBadgeClass(announcement.priority)" class="text-xs font-bold px-3 py-1 rounded-full uppercase">
            {{ announcement.priority }}
          </span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
          {{ announcement.title }}
        </h1>
        <div class="text-xs text-slate-500 font-medium border-y border-slate-200 py-3 flex items-center justify-center gap-4">
          <span>Dipublikasikan: {{ formatDate(announcement.published_at) }}</span>
          <span v-if="announcement.start_date">•</span>
          <span v-if="announcement.start_date">Berlaku: {{ formatDate(announcement.start_date) }} - {{ formatDate(announcement.end_date) }}</span>
        </div>
      </div>

      <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-xs prose prose-slate max-w-none leading-relaxed text-slate-700" v-html="announcement.content">
      </div>

      <div v-if="announcement.attachment" class="p-6 bg-blue-50 border border-blue-200 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
          </div>
          <div>
            <span class="font-bold text-sm text-slate-900 block">Lampiran Dokumen Pengumuman</span>
            <span class="text-xs text-slate-500">Unduh dokumen resmi terkait pengumuman ini.</span>
          </div>
        </div>
        <a :href="'/storage/' + announcement.attachment" target="_blank" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-all shadow-sm">
          Unduh File
        </a>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
  announcement: Object,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};

const getPriorityBadgeClass = (priority) => {
  switch (priority) {
    case 'mendesak': return 'bg-rose-100 text-rose-700 border border-rose-300';
    case 'tinggi': return 'bg-amber-100 text-amber-700 border border-amber-300';
    case 'sedang': return 'bg-blue-100 text-blue-700 border border-blue-300';
    default: return 'bg-slate-100 text-slate-600 border border-slate-300';
  }
};
</script>
