<template>
  <MainLayout>
    <div class="bg-gradient-to-b from-slate-900 via-slate-800 to-indigo-950 text-white py-16 px-4">
      <div class="max-w-7xl mx-auto text-center space-y-4">
        <h1 class="text-4xl font-extrabold tracking-tight">Pusat Dokumen & Unduhan Publik</h1>
        <p class="text-slate-300 text-lg max-w-2xl mx-auto">
          Akses dan unduh berkas resmi sekolah seperti Kalender Pendidikan, Brosur PPDB, Formulir, dan Panduan Akademik.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <div v-if="documents && documents.data && documents.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="doc in documents.data" 
          :key="doc.id"
          class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:shadow-lg transition-all flex flex-col justify-between space-y-4"
        >
          <div class="space-y-3">
            <div class="flex justify-between items-center">
              <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-md uppercase">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                {{ doc.category }}
              </span>
              <span class="text-slate-400 text-xs font-medium">{{ doc.year }}</span>
            </div>

            <h2 class="text-lg font-bold text-slate-900 leading-snug">
              {{ doc.title }}
            </h2>

            <p class="text-slate-600 text-xs line-clamp-2">
              {{ doc.description || 'Dokumen resmi terverifikasi.' }}
            </p>
          </div>

          <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <span class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              {{ doc.file_size || 'PDF / Doc' }}
            </span>
            <a 
              :href="'/dokumen/' + doc.id + '/download'" 
              class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
              Unduh Berkas
            </a>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-xs max-w-md mx-auto space-y-3">
        <div class="w-16 h-16 rounded-full bg-slate-100 mx-auto flex items-center justify-center text-slate-400">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Belum Ada Dokumen</h3>
        <p class="text-slate-500 text-sm">Berkas resmi publik akan segera diunggah oleh pihak sekolah.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
  documents: Object
})

const getStorageUrl = (filePath) => {
  if (!filePath) return '#';
  if (filePath.startsWith('http://') || filePath.startsWith('https://')) return filePath;
  const cleanPath = filePath.replace(/^\/?storage\//, '');
  return '/storage/' + cleanPath;
}
</script>
