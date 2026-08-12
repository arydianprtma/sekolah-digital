<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-blue-950 via-slate-900 to-indigo-950 text-white py-16 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-semibold uppercase tracking-wider">Tentang Kami</span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight">Profil {{ profile?.school_name || 'Digital School' }}</h1>
        <p class="text-slate-300 text-sm max-w-xl mx-auto">
          Mengenal sejarah, visi, misi, dan kepemimpinan sekolah digital percontohan.
        </p>
      </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
      <!-- Identitas Singkat & Sambutan -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 space-y-6">
          <h2 class="text-3xl font-extrabold text-slate-900">Sejarah Pendirian</h2>
          <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed" v-html="profile?.history">
          </div>
        </div>

        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden flex flex-col">
          <div class="w-full h-80 sm:h-96 bg-slate-900 relative overflow-hidden flex items-center justify-center">
            <img v-if="profile?.principal_photo" :src="'/storage/' + profile.principal_photo" :alt="profile?.principal_name" class="w-full h-full object-cover object-top" />
            <div v-else class="w-full h-full bg-gradient-to-tr from-blue-900 via-indigo-900 to-slate-900 flex items-center justify-center text-blue-300">
              <svg class="w-24 h-24 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
          </div>
          <div class="p-6 text-center space-y-3">
            <div>
              <h3 class="font-black text-xl text-slate-900 tracking-tight uppercase">{{ profile?.principal_name || 'Dr. H. Ahmad Dahlan, M.Pd.' }}</h3>
              <p class="text-sm font-semibold text-blue-600 tracking-wider uppercase mt-0.5">- Kepala Sekolah -</p>
            </div>
            <div class="text-sm text-slate-600 italic leading-relaxed text-left border-t border-slate-100 pt-3 prose prose-slate max-w-none" v-html="profile?.principal_greeting">
            </div>
          </div>
        </div>
      </div>

      <!-- Visi & Misi -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-gradient-to-br from-blue-900 to-indigo-900 text-white p-8 rounded-3xl shadow-xl space-y-4">
          <span class="text-xs font-bold text-blue-300 uppercase tracking-widest block">Landasan Utama</span>
          <h3 class="text-2xl font-black">Visi Sekolah</h3>
          <div class="text-lg text-blue-100 font-medium leading-relaxed" v-html="profile?.vision">
          </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-md space-y-4">
          <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest block">Langkah Strategis</span>
          <h3 class="text-2xl font-black text-slate-900">Misi Sekolah</h3>
          <ul v-if="Array.isArray(profile?.mission)" class="space-y-2 text-sm text-slate-700">
            <li v-for="(item, idx) in profile.mission" :key="idx" class="flex items-start gap-2">
              <span class="text-blue-600 font-bold">•</span>
              <span>{{ item }}</span>
            </li>
          </ul>
          <div v-else-if="profile?.mission" class="text-sm text-slate-700 leading-relaxed prose max-w-none" v-html="profile.mission">
          </div>
        </div>
      </div>

      <!-- Detail Informasi Tabel -->
      <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-xs space-y-6">
        <h3 class="text-2xl font-bold text-slate-900 border-b border-slate-100 pb-4">Data Resmi Sekolah</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
          <div>
            <span class="text-xs text-slate-400 font-bold uppercase block">Nama Sekolah</span>
            <span class="font-bold text-slate-800">{{ profile?.school_name }}</span>
          </div>
          <div>
            <span class="text-xs text-slate-400 font-bold uppercase block">NPSN</span>
            <span class="font-bold text-slate-800">{{ profile?.npsn }}</span>
          </div>
          <div>
            <span class="text-xs text-slate-400 font-bold uppercase block">Akreditasi</span>
            <span class="font-bold text-slate-800">{{ profile?.accreditation }}</span>
          </div>
          <div>
            <span class="text-xs text-slate-400 font-bold uppercase block">Tahun Berdiri</span>
            <span class="font-bold text-slate-800">{{ profile?.established_year }}</span>
          </div>
          <div>
            <span class="text-xs text-slate-400 font-bold uppercase block">Alamat</span>
            <span class="font-bold text-slate-800">{{ profile?.address }}</span>
          </div>
          <div>
            <span class="text-xs text-slate-400 font-bold uppercase block">Kontak</span>
            <span class="font-bold text-slate-800">{{ profile?.phone }} • {{ profile?.email }}</span>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
  profile: Object,
});
</script>
