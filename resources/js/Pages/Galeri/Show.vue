<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
      <div class="space-y-3 text-center">
        <span class="inline-block px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-bold uppercase">
          Album Galeri
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
          {{ album.title }}
        </h1>
        <p v-if="album.description" class="text-sm text-slate-600 max-w-2xl mx-auto">
          {{ album.description }}
        </p>
      </div>

      <div v-if="album.items && album.items.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="item in album.items" :key="item.id" class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-lg transition-all group">
          <div class="h-56 overflow-hidden bg-slate-100">
            <img :src="'/storage/' + item.media_path" :alt="item.caption || album.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
          </div>
          <div v-if="item.caption" class="p-3 text-xs font-medium text-slate-700 border-t border-slate-100">
            {{ item.caption }}
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-white rounded-2xl border border-slate-200">
        <p class="text-slate-500 font-medium">Album ini belum memiliki item foto/video.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
  album: Object,
});
</script>
