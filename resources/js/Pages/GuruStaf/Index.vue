<template>
  <MainLayout>
    <div class="bg-gradient-to-r from-blue-900 to-slate-900 text-white py-12 px-4 shadow-inner">
      <div class="max-w-7xl mx-auto text-center space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Guru & Tenaga Kependidikan</h1>
        <p class="text-slate-300 text-sm max-w-xl mx-auto">
          Direktori Tenaga Pengajar dan Staf Profesional di Digital School.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div v-if="teacherList && teacherList.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div 
          v-for="person in teacherList" 
          :key="person.id" 
          class="bg-white rounded-2xl border border-slate-200/80 p-6 text-center space-y-4 shadow-xs hover:shadow-xl transition-all duration-300 group hover:-translate-y-1 relative overflow-hidden"
        >
          <!-- Category Badge Ribbon for Leadership Roles -->
          <div v-if="['kepala_sekolah', 'waka_kurikulum', 'waka_kesiswaan', 'waka_umum', 'wakil_kepala_sekolah', 'yayasan'].includes(person.category)" class="absolute top-3 right-3">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-blue-100 text-blue-800 tracking-wider">
              {{ person.category === 'kepala_sekolah' ? 'Kepsek' : (person.category.includes('waka') || person.category.includes('wakil') ? 'Waka' : 'Pimpinan') }}
            </span>
          </div>

          <!-- Avatar Image -->
          <div class="w-24 h-24 mx-auto rounded-full overflow-hidden bg-slate-100 border-4 border-blue-100 group-hover:border-blue-500 transition-colors shadow-inner flex items-center justify-center text-slate-400">
            <img 
              v-if="person.photo" 
              :src="'/storage/' + person.photo" 
              @error="person.photo = null" 
              class="w-full h-full object-cover"
            />
            <svg v-else class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>

          <div class="space-y-1">
            <h3 class="font-bold text-slate-900 text-base group-hover:text-blue-600 transition-colors">
              {{ person.name }}
            </h3>
            <p v-if="person.position" class="text-xs font-semibold text-blue-600">
              {{ person.position }}
            </p>
            <p v-if="person.subject" class="text-xs text-slate-500">
              Pengampu: {{ person.subject }}
            </p>
            <p v-if="person.nip" class="text-[11px] text-slate-400">
              NIP: {{ person.nip }}
            </p>
          </div>

          <div v-if="person.bio" class="pt-3 border-t border-slate-100 text-xs text-slate-600 line-clamp-3 italic">
            "{{ person.bio }}"
          </div>
        </div>
      </div>

      <div v-else class="text-center py-16 bg-white rounded-2xl border border-slate-200">
        <p class="text-slate-500 font-medium">Belum ada data guru/staf.</p>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
  teachers: Array,
  staffs: Array,
});

const teacherList = computed(() => props.teachers || props.staffs || []);
</script>
