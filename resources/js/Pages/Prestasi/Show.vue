<template>
  <MainLayout>
    <div class="bg-slate-900 text-white py-12 px-4">
      <div class="max-w-4xl mx-auto space-y-4">
        <Link href="/prestasi" class="text-amber-400 hover:text-amber-300 text-sm font-medium inline-flex items-center gap-1">
          ← Kembali ke Daftar Prestasi
        </Link>
        <span class="inline-flex items-center gap-1.5 bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
          Tingkat {{ achievement.level }} • Tahun {{ achievement.year }}
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ achievement.title }}</h1>
      </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12 space-y-8">
      <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6">
        <div class="flex flex-wrap gap-4 items-center justify-between pb-6 border-b border-slate-100">
          <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Penerima / Pemenang</span>
            <span class="text-xl font-bold text-slate-900">{{ achievement.winner_name }}</span>
          </div>
          <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Capaian / Juara</span>
            <span class="text-lg font-bold text-amber-600 uppercase">{{ achievement.rank ? achievement.rank.replace('_', ' ') : '-' }}</span>
          </div>
        </div>

        <div v-if="achievement.image" class="rounded-xl overflow-hidden border border-slate-200">
          <img :src="'/storage/' + achievement.image" :alt="achievement.title" class="w-full max-h-96 object-cover" />
        </div>

        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed" v-html="achievement.description"></div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
  achievement: Object
})
</script>
