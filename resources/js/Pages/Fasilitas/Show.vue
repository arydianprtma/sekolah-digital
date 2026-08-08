<template>
  <MainLayout>
    <div class="bg-slate-900 text-white py-12 px-4">
      <div class="max-w-4xl mx-auto space-y-4">
        <Link href="/fasilitas" class="text-blue-400 hover:text-blue-300 text-sm font-medium inline-flex items-center gap-1">
          ← Kembali ke Daftar Fasilitas
        </Link>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ facility.name }}</h1>
      </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12 space-y-8">
      <div v-if="facility.primary_image" class="rounded-2xl overflow-hidden shadow-lg border border-slate-200">
        <img :src="'/storage/' + facility.primary_image" :alt="facility.name" class="w-full max-h-96 object-cover" />
      </div>

      <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6">
        <div v-if="facility.available_features && facility.available_features.length > 0" class="space-y-3">
          <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Kelengkapan & Sarana</h3>
          <div class="flex flex-wrap gap-2">
            <span 
              v-for="(feature, idx) in facility.available_features" 
              :key="idx"
              class="bg-blue-50 text-blue-800 text-sm font-semibold px-3 py-1.5 rounded-lg border border-blue-100"
            >
              ✓ {{ feature }}
            </span>
          </div>
        </div>

        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed" v-html="facility.description"></div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
  facility: Object
})
</script>
