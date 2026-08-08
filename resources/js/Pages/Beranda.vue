<template>
  <MainLayout>
    <!-- Hero Banner Section -->
    <section class="relative bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-950 text-white overflow-hidden py-20 lg:py-28">
      <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
              ✨ Selamat Datang di Website Resmi
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
              Mewujudkan Generasi <span class="bg-gradient-to-r from-blue-400 via-sky-300 to-indigo-300 bg-clip-text text-transparent">Digital Berprestasi</span>
            </h1>
            <p class="text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
              {{ school_profile?.vision || 'Pusat keunggulan pendidikan yang mengintegrasikan kecerdasan intelektual, pembentukan karakter mulia, dan penguasaan teknologi informasi masa depan.' }}
            </p>
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-4">
              <Link href="/profil" class="px-7 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-base shadow-lg shadow-blue-600/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all">
                Jelajahi Profil Sekolah →
              </Link>
              <Link href="/berita" class="px-7 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-base border border-white/20 backdrop-blur-sm hover:-translate-y-0.5 transition-all">
                Kabar Terbaru
              </Link>
            </div>
          </div>

          <div class="lg:col-span-5 relative">
            <div class="relative mx-auto max-w-md lg:max-w-none">
              <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur-xl opacity-40"></div>
              <div class="relative bg-slate-900/90 border border-slate-700/80 rounded-2xl p-6 shadow-2xl backdrop-blur-md">
                <div class="flex items-center gap-4 mb-4">
                  <div class="w-16 h-16 rounded-full bg-blue-600/30 border-2 border-blue-400 flex items-center justify-center text-blue-300 overflow-hidden">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  </div>
                  <div>
                    <h3 class="text-lg font-bold text-white">{{ school_profile?.principal_name || 'Dr. H. Ahmad Dahlan, M.Pd.' }}</h3>
                    <p class="text-xs text-blue-300 font-medium">Kepala Sekolah {{ school_profile?.school_name }}</p>
                  </div>
                </div>
                <div class="text-sm text-slate-300 italic leading-relaxed border-t border-slate-800 pt-4">
                  "{{ school_profile?.principal_greeting || 'Selamat datang di portal Digital School. Kami berkomitmen mencetak lulusan yang inovatif, berkarakter, dan berdaya saing global.' }}"
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Banner -->
    <section class="bg-white border-y border-slate-200 py-10 shadow-xs">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div class="space-y-1">
            <span class="text-3xl sm:text-4xl font-extrabold text-blue-600">1,250+</span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa Aktif</p>
          </div>
          <div class="space-y-1">
            <span class="text-3xl sm:text-4xl font-extrabold text-indigo-600">85+</span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Guru & Staf</p>
          </div>
          <div class="space-y-1">
            <span class="text-3xl sm:text-4xl font-extrabold text-emerald-600">120+</span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Prestasi Diraih</p>
          </div>
          <div class="space-y-1">
            <span class="text-3xl sm:text-4xl font-extrabold text-amber-600">24+</span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ekstrakurikuler</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Berita Terbaru Section -->
    <section class="py-16 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
          <div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1">Informasi Terkini</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Berita Sekolah Terbaru</h2>
          </div>
          <Link href="/berita" class="inline-flex items-center gap-1.5 font-bold text-sm text-blue-600 hover:text-blue-700 transition-colors">
            Lihat Semua Berita →
          </Link>
        </div>

        <div v-if="latest_news && latest_news.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="news in latest_news" :key="news.id" class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group hover:-translate-y-1">
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
                <span class="text-xs font-semibold text-slate-500">Penulis: Admin</span>
                <Link :href="'/berita/' + news.slug" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                  Baca Selengkapnya →
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pengumuman & Agenda Grid Section -->
    <section class="py-16 bg-white border-t border-slate-200/80">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
          <!-- Left: Pengumuman Sekolah -->
          <div class="lg:col-span-6 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
              <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest block">Pengumuman Penting</span>
                <h2 class="text-2xl font-extrabold text-slate-900">Pengumuman Terbaru</h2>
              </div>
              <Link href="/pengumuman" class="text-xs font-bold text-blue-600 hover:text-blue-700">Lihat Semua →</Link>
            </div>

            <div v-if="latest_announcements && latest_announcements.length" class="space-y-4">
              <div v-for="item in latest_announcements" :key="item.id" class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-amber-300 hover:shadow-md transition-all">
                <div class="flex items-center gap-2 mb-2">
                  <span :class="getPriorityBadgeClass(item.priority)" class="text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                    {{ item.priority }}
                  </span>
                  <span class="text-xs text-slate-400 font-medium">{{ formatDate(item.published_at) }}</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 hover:text-blue-600 transition-colors">
                  <Link :href="'/pengumuman/' + item.slug">{{ item.title }}</Link>
                </h3>
              </div>
            </div>
          </div>

          <!-- Right: Agenda Kegiatan -->
          <div class="lg:col-span-6 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
              <div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block">Kalender Kegiatan</span>
                <h2 class="text-2xl font-extrabold text-slate-900">Agenda Terdekat</h2>
              </div>
              <Link href="/agenda" class="text-xs font-bold text-blue-600 hover:text-blue-700">Lihat Semua →</Link>
            </div>

            <div v-if="upcoming_agendas && upcoming_agendas.length" class="space-y-4">
              <div v-for="agenda in upcoming_agendas" :key="agenda.id" class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-emerald-300 hover:shadow-md transition-all flex items-start gap-4">
                <div class="w-14 h-14 rounded-xl bg-emerald-600 text-white flex flex-col items-center justify-center shrink-0 shadow-sm font-bold">
                  <span class="text-lg leading-none">{{ getDayNumber(agenda.start_date) }}</span>
                  <span class="text-[10px] uppercase tracking-wider leading-none mt-1">{{ getMonthShort(agenda.start_date) }}</span>
                </div>
                <div class="space-y-1">
                  <h3 class="text-base font-bold text-slate-900 hover:text-emerald-700 transition-colors">
                    <Link :href="'/agenda/' + agenda.slug">{{ agenda.title }}</Link>
                  </h3>
                  <p class="text-xs text-slate-500 flex items-center gap-2">
                    <span>📍 {{ agenda.location || 'Kampus Digital School' }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  school_profile: Object,
  latest_news: Array,
  latest_announcements: Array,
  upcoming_agendas: Array,
  latest_albums: Array,
  teachers: Array,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
};

const getDayNumber = (dateStr) => {
  if (!dateStr) return '01';
  return new Date(dateStr).getDate();
};

const getMonthShort = (dateStr) => {
  if (!dateStr) return 'Jan';
  return new Date(dateStr).toLocaleDateString('id-ID', { month: 'short' });
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
