<template>
  <div class="org-chart-wrapper py-6 px-4 overflow-x-auto">
    <div class="min-w-[768px] flex flex-col items-center select-none">
      
      <!-- LEVEL 0: Yayasan -->
      <div class="node-box bg-slate-950 text-white border border-slate-800 shadow-xl">
        <div class="node-icon bg-slate-800 text-slate-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="node-body text-center">
          <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Lembaga</span>
          <h3 class="font-extrabold text-lg text-white">Yayasan</h3>
          <div v-if="getItem('yayasan')" class="mt-1 text-xs text-slate-300 font-medium border-t border-slate-800 pt-1">
            {{ getItem('yayasan').name }}
          </div>
        </div>
      </div>

      <!-- Connector Line Level 0 -> Level 1 -->
      <div class="line-v h-8"></div>

      <!-- LEVEL 1: Kepala Sekolah -->
      <div class="node-box bg-blue-600 text-white shadow-lg hover:bg-blue-700 transition-colors">
        <div class="node-icon bg-blue-500 text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div class="node-body text-center">
          <h3 class="font-extrabold text-base text-white">Kepala Sekolah</h3>
          <div v-if="getItem('kepala_sekolah')" class="mt-1 text-xs text-blue-100 font-medium border-t border-blue-500/50 pt-1">
            {{ getItem('kepala_sekolah').name }}
          </div>
        </div>
      </div>

      <!-- Connector Line Level 1 -> Horizontal Branch -->
      <div class="line-v h-8"></div>

      <!-- LEVEL 2 BRANCHES (Waka Kurikulum, Waka Kesiswaan, Waka Umum) -->
      <div class="relative w-full max-w-4xl flex justify-center">
        <!-- Horizontal connector line connecting all 3 Waka -->
        <div class="absolute top-0 left-[16.6%] right-[16.6%] h-0.5 bg-slate-300"></div>

        <div class="grid grid-cols-3 gap-8 w-full">
          
          <!-- BRANCH 1: Waka Kurikulum -->
          <div class="flex flex-col items-center">
            <div class="line-v h-6"></div>
            <div class="node-box bg-blue-600 text-white w-full max-w-[220px] shadow-md">
              <div class="node-body text-center">
                <h4 class="font-bold text-sm text-white">Waka Kurikulum</h4>
                <div v-if="getItem('waka_kurikulum')" class="mt-1 text-xs text-blue-100 border-t border-blue-500/50 pt-1">
                  {{ getItem('waka_kurikulum').name }}
                </div>
              </div>
            </div>

            <!-- Sub-branch connector -->
            <div class="line-v h-6"></div>
            <div class="w-full pl-4 border-l-2 border-slate-300 space-y-4">
              <!-- Sub 1: Guru Mapel -->
              <div class="relative flex items-center">
                <div class="line-h w-4"></div>
                <div class="node-sub-box bg-sky-500 text-white w-full shadow-sm">
                  <span class="font-semibold text-xs">Guru Mapel</span>
                  <span v-if="getGroupCount('guru_mapel')" class="badge-count">{{ getGroupCount('guru_mapel') }} Guru</span>
                </div>
              </div>
              <!-- Sub 2: Guru Kelas -->
              <div class="relative flex items-center">
                <div class="line-h w-4"></div>
                <div class="node-sub-box bg-sky-500 text-white w-full shadow-sm">
                  <span class="font-semibold text-xs">Guru Kelas</span>
                  <span v-if="getGroupCount('guru_kelas')" class="badge-count">{{ getGroupCount('guru_kelas') }} Guru</span>
                </div>
              </div>
            </div>
          </div>

          <!-- BRANCH 2: Waka Kesiswaan -->
          <div class="flex flex-col items-center">
            <div class="line-v h-6"></div>
            <div class="node-box bg-blue-600 text-white w-full max-w-[220px] shadow-md">
              <div class="node-body text-center">
                <h4 class="font-bold text-sm text-white">Waka Kesiswaan</h4>
                <div v-if="getItem('waka_kesiswaan')" class="mt-1 text-xs text-blue-100 border-t border-blue-500/50 pt-1">
                  {{ getItem('waka_kesiswaan').name }}
                </div>
              </div>
            </div>

            <!-- Sub-branch connector -->
            <div class="line-v h-14"></div>
            <div class="w-full flex justify-center">
              <div class="node-sub-box bg-sky-500 text-white w-full max-w-[200px] shadow-sm text-center">
                <span class="font-semibold text-xs">Pembina OSIS</span>
                <span v-if="getGroupCount('pembina_osis')" class="badge-count">{{ getGroupCount('pembina_osis') }} Personil</span>
              </div>
            </div>
          </div>

          <!-- BRANCH 3: Waka Umum -->
          <div class="flex flex-col items-center">
            <div class="line-v h-6"></div>
            <div class="node-box bg-blue-600 text-white w-full max-w-[220px] shadow-md">
              <div class="node-body text-center">
                <h4 class="font-bold text-sm text-white">Waka Umum</h4>
                <div v-if="getItem('waka_umum')" class="mt-1 text-xs text-blue-100 border-t border-blue-500/50 pt-1">
                  {{ getItem('waka_umum').name }}
                </div>
              </div>
            </div>

            <!-- Sub-branch connector -->
            <div class="line-v h-6"></div>
            <div class="w-full flex justify-center">
              <div class="node-sub-box bg-sky-500 text-white w-full max-w-[200px] shadow-sm text-center">
                <span class="font-semibold text-xs">Admin & TU</span>
                <span v-if="getGroupCount('admin_tu')" class="badge-count">{{ getGroupCount('admin_tu') }} Staf</span>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  staffs: {
    type: Array,
    default: () => [],
  },
});

const getItem = (category) => {
  return props.staffs.find(item => item.category === category);
};

const getGroupCount = (category) => {
  return props.staffs.filter(item => item.category === category).length;
};
</script>

<style scoped>
.node-box {
  border-radius: 0.85rem;
  padding: 0.85rem 1.25rem;
  min-width: 180px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.35rem;
  position: relative;
  z-index: 10;
}

.node-sub-box {
  border-radius: 0.75rem;
  padding: 0.65rem 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
}

.node-icon {
  width: 2.25rem;
  height: 2.25rem;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.25rem;
}

.line-v {
  width: 2px;
  background-color: #cbd5e1;
}

.line-h {
  height: 2px;
  background-color: #cbd5e1;
}

.badge-count {
  background-color: rgba(255, 255, 255, 0.25);
  font-size: 0.65rem;
  padding: 0.15rem 0.4rem;
  border-radius: 9999px;
  font-weight: 700;
}
</style>
