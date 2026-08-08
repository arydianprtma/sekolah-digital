<template>
  <MainLayout>
    <div class="bg-gradient-to-b from-blue-900 via-indigo-900 to-slate-900 text-white py-16 px-4">
      <div class="max-w-7xl mx-auto text-center space-y-4">
        <h1 class="text-4xl font-extrabold tracking-tight">Fasilitas & Infrastruktur Sekolah</h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto">
          Dukungan sarana dan prasarana teknologi modern untuk menciptakan lingkungan belajar yang inspiratif dan berstandar internasional.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <div v-if="facilities && facilities.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="item in facilities" 
          :key="item.id"
          class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group"
        >
          <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center text-slate-400">
            <img 
              v-if="item.primary_image" 
              :src="'/storage/' + item.primary_image" 
              :alt="item.name"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
            <div v-else class="text-center p-6 text-slate-400">
              <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9m4 4v4m0 0h4m-4 0H9m4-4H9"/></svg>
              <span class="text-xs font-semibold uppercase tracking-wider">Fasilitas Digital</span>
            </div>
          </div>

          <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
            <div>
              <h2 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                {{ item.name }}
              </h2>
              <p class="text-slate-600 text-sm mt-2 line-clamp-3 leading-relaxed">
                {{ item.description ? item.description.replace(/<[^>]*>?/gm, '') : 'Fasilitas unggulan sekolah.' }}
              </p>
            </div>

            <div v-if="item.available_features && item.available_features.length > 0" class="pt-2 border-t border-slate-100">
              <div class="flex flex-wrap gap-1.5">
                <span 
                  v-for="(feature, idx) in item.available_features" 
                  :key="idx"
                  class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-md"
                >
                  <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  {{ feature }}
                </span>
              </div>
            </div>

            <Link 
              :href="`/fasilitas/${item.slug}`" 
              class="inline-flex items-center justify-center w-full py-2.5 px-4 bg-slate-900 hover:bg-blue-600 text-white rounded-xl text-sm font-semibold transition-all shadow-xs"
            >
              Lihat Detail Fasilitas →
            </Link>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-xs max-w-md mx-auto space-y-3">
        <div class="w-16 h-16 rounded-full bg-slate-100 mx-auto flex items-center justify-center text-slate-400">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9m4 4v4m0 0h4m-4 0H9m4-4H9"/></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Fasilitas</h3>
        <p class="text-slate-500 text-sm">Data fasilitas sekolah akan segera diperbarui oleh pengelola.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
  facilities: Array
})
</script>
