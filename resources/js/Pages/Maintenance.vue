<template>
  <div class="min-h-screen bg-slate-900 text-white flex flex-col items-center justify-center p-6 text-center">
    <div class="max-w-md space-y-6 bg-slate-800/80 p-8 rounded-3xl border border-slate-700 shadow-2xl backdrop-blur-md">
      <div class="w-20 h-20 bg-blue-600/20 text-blue-400 rounded-full flex items-center justify-center text-4xl mx-auto border border-blue-500/30">
        ⚙️
      </div>

      <div class="space-y-2">
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Website Dalam Pemeliharaan</h1>
        <p class="text-slate-300 text-sm leading-relaxed">
          {{ message || 'Website kami sedang mengalami pemeliharaan sistem berkala untuk meningkatkan kualitas layanan.' }}
        </p>
      </div>

      <div class="pt-4 border-t border-slate-700/60 flex flex-col gap-3">
        <a href="/portal" class="py-2.5 px-4 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold text-xs transition-all shadow-md">
          Portal Login Administrator →
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  message: String
})
</script>
