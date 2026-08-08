<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-amber-900 to-orange-950 text-white py-12 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pengumuman Resmi</h1>
        <p class="text-amber-200 text-sm max-w-xl mx-auto">
          Informasi penting, akademik, dan edaran resmi dari pihak Digital School.
        </p>
      </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div v-if="announcements && announcements.data && announcements.data.length" class="space-y-4">
        <div v-for="item in announcements.data" :key="item.id" class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <span :class="getPriorityBadgeClass(item.priority)" class="text-xs font-bold px-2.5 py-0.5 rounded uppercase">
                {{ item.priority }}
              </span>
              <span class="text-xs text-slate-400 font-medium">Dipublikasikan: {{ formatDate(item.published_at) }}</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900 hover:text-blue-600 transition-colors">
              <Link :href="'/pengumuman/' + item.slug">{{ item.title }}</Link>
            </h3>
          </div>

          <Link :href="'/pengumuman/' + item.slug" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 text-xs font-bold transition-all shrink-0 text-center">
            Lihat rincian →
          </Link>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-white rounded-2xl border border-slate-200">
        <p class="text-slate-500 font-medium">Belum ada pengumuman terbaru.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  announcements: Object,
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
