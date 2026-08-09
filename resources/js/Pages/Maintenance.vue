<template>
  <div class="min-h-screen bg-slate-900 text-white flex flex-col items-center justify-center p-6 text-center">
    <div class="max-w-md space-y-6 bg-slate-800/80 p-8 rounded-3xl border border-slate-700 shadow-2xl backdrop-blur-md">
      <div class="w-20 h-20 bg-blue-600/20 text-blue-400 rounded-full flex items-center justify-center mx-auto border border-blue-500/30">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
