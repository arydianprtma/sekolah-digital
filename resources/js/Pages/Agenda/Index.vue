<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-emerald-900 to-teal-950 text-white py-12 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Agenda & Kalender Kegiatan</h1>
        <p class="text-emerald-200 text-sm max-w-xl mx-auto">
          Jadwal kegiatan, seminar, ujian, dan acara mendatang di Digital School.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div v-if="agendas && agendas.data && agendas.data.length" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div v-for="agenda in agendas.data" :key="agenda.id" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:shadow-xl transition-all flex flex-col justify-between space-y-4">
          <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white flex flex-col items-center justify-center shrink-0 shadow-md font-bold">
              <span class="text-xl leading-none">{{ getDayNumber(agenda.start_date) }}</span>
              <span class="text-xs uppercase tracking-wider leading-none mt-1">{{ getMonthShort(agenda.start_date) }}</span>
            </div>
            <div class="space-y-2">
              <h3 class="text-xl font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                <Link :href="'/agenda/' + agenda.slug">{{ agenda.title }}</Link>
              </h3>
              <div class="text-xs text-slate-500 space-y-1.5">
                <p class="flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  Waktu: {{ formatTime(agenda.start_date) }} WIB
                </p>
                <p class="flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                  Lokasi: {{ agenda.location || 'Kampus Digital School' }}
                </p>
                <p v-if="agenda.organizer" class="flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  Penyelenggara: {{ agenda.organizer }}
                </p>
              </div>
            </div>
          </div>

          <div class="pt-4 border-t border-slate-100 flex justify-end">
            <Link :href="'/agenda/' + agenda.slug" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
              Lihat Detail Agenda →
            </Link>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-white rounded-2xl border border-slate-200">
        <p class="text-slate-500 font-medium">Belum ada agenda kegiatan mendatang.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  agendas: Object,
});

const getDayNumber = (dateStr) => {
  if (!dateStr) return '01';
  return new Date(dateStr).getDate();
};

const getMonthShort = (dateStr) => {
  if (!dateStr) return 'Jan';
  return new Date(dateStr).toLocaleDateString('id-ID', { month: 'short' });
};

const formatTime = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
};
</script>
