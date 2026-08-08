<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-slate-900 to-blue-950 text-white py-12 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ page.title }}</h1>
      </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
      <div v-if="page.featured_image" class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 max-h-[400px]">
        <img :src="'/storage/' + page.featured_image" :alt="page.title" class="w-full h-full object-cover">
      </div>

      <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-xs prose prose-slate max-w-none leading-relaxed text-slate-700" v-html="page.content">
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
  page: Object,
});
</script>
