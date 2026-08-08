<template>
  <MainLayout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
      <div class="space-y-4 text-center">
        <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase">
          Agenda Kegiatan
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
          {{ agenda.title }}
        </h1>
        <div class="text-xs text-slate-500 font-medium border-y border-slate-200 py-3 flex flex-wrap justify-center gap-6">
          <span class="inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ formatDate(agenda.start_date) }}
          </span>
          <span class="inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            {{ agenda.location || 'Kampus Digital School' }}
          </span>
          <span v-if="agenda.organizer" class="inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            {{ agenda.organizer }}
          </span>
        </div>
      </div>

      <div v-if="agenda.image" class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 max-h-[450px]">
        <img :src="'/storage/' + agenda.image" :alt="agenda.title" class="w-full h-full object-cover">
      </div>

      <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-xs prose prose-slate max-w-none leading-relaxed text-slate-700" v-html="agenda.description">
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
  agenda: Object,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
};
</script>
