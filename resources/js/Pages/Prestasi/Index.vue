<template>
  <MainLayout>
    <div class="bg-gradient-to-b from-amber-600 via-orange-600 to-slate-900 text-white py-16 px-4">
      <div class="max-w-7xl mx-auto text-center space-y-4">
        <h1 class="text-4xl font-extrabold tracking-tight">Prestasi & Penghargaan Sekolah</h1>
        <p class="text-amber-100 text-lg max-w-2xl mx-auto">
          Catatan kebanggaan atas capaian gemilang para siswa dan civitas akademika dalam kompetisi akademik, teknologi, seni, dan olahraga.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <div v-if="achievements && achievements.data && achievements.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="item in achievements.data" 
          :key="item.id"
          class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group"
        >
          <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-start">
            <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
              <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
              {{ item.level }}
            </span>
            <span class="text-slate-400 font-semibold text-xs">{{ item.year }}</span>
          </div>

          <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
            <div>
              <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                {{ item.rank ? item.rank.replace('_', ' ').toUpperCase() : 'JUARA' }}
              </span>
              <h2 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors">
                {{ item.title }}
              </h2>
              <p class="text-slate-600 text-sm mt-2 font-medium flex items-center gap-1">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Pemenang: <span class="text-slate-950 font-bold">{{ item.winner_name }}</span>
              </p>
            </div>

            <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed">
              {{ item.description ? item.description.replace(/<[^>]*>?/gm, '') : '' }}
            </p>

            <Link 
              :href="`/prestasi/${item.slug}`" 
              class="inline-flex items-center justify-center w-full py-2.5 px-4 bg-slate-900 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition-all shadow-xs"
            >
              Rincian Prestasi →
            </Link>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-xs max-w-md mx-auto space-y-3">
        <div class="w-16 h-16 rounded-full bg-amber-50 mx-auto flex items-center justify-center text-amber-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Prestasi</h3>
        <p class="text-slate-500 text-sm">Data pencapaian prestasi sekolah akan segera diperbarui.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
  achievements: Object
})
</script>
