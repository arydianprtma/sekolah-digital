<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  keyword: { type: String, default: '' },
  filter: { type: String, default: 'semua' },
  hasil: { type: Array, default: () => [] },
})

const searchQuery = ref(props.keyword)
const activeFilter = ref(props.filter)

const filters = [
  { value: 'semua', label: 'Semua' },
  { value: 'berita', label: 'Berita' },
  { value: 'halaman', label: 'Halaman' },
  { value: 'pengumuman', label: 'Pengumuman' },
  { value: 'dokumen', label: 'Dokumen' },
]

function doSearch() {
  if (!searchQuery.value.trim()) return
  router.get('/pencarian', {
    q: searchQuery.value.trim(),
    jenis: activeFilter.value,
  }, { preserveState: true })
}

function setFilter(value) {
  activeFilter.value = value
  if (searchQuery.value.trim()) doSearch()
}

function highlight(text, keyword) {
  if (!keyword || !text) return text
  const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')
  return text.replace(new RegExp(`(${escaped})`, 'gi'), '<mark class="hl">$1</mark>')
}

function formatTanggal(tgl) {
  if (!tgl) return ''
  return new Date(tgl).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

const badgeColor = {
  'Berita': '#dbeafe|#1d4ed8',
  'Halaman': '#f3e8ff|#7e22ce',
  'Pengumuman': '#fef9c3|#854d0e',
  'Dokumen': '#dcfce7|#15803d',
}
</script>

<template>
  <MainLayout>
    <Head>
      <title>Pencarian{{ keyword ? ` — ${keyword}` : '' }}</title>
      <meta name="description" content="Cari berita, pengumuman, halaman, dan dokumen sekolah." />
    </Head>

    <!-- Search Hero -->
    <section class="search-hero">
      <div class="search-hero-inner">
        <h1 class="search-title">Pencarian</h1>
        <form @submit.prevent="doSearch" class="search-form">
          <div class="search-input-wrap">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
              v-model="searchQuery"
              type="search"
              placeholder="Cari berita, pengumuman, dokumen..."
              class="search-input"
              autofocus
            />
            <button type="submit" class="search-btn">Cari</button>
          </div>
        </form>
        <!-- Filter chips -->
        <div class="filter-chips">
          <button
            v-for="f in filters"
            :key="f.value"
            @click="setFilter(f.value)"
            :class="['chip', activeFilter === f.value ? 'chip-active' : '']"
          >{{ f.label }}</button>
        </div>
      </div>
    </section>

    <!-- Results -->
    <div class="results-container">
      <!-- Info -->
      <div v-if="keyword" class="results-info">
        <span v-if="hasil.length > 0">
          Ditemukan <strong>{{ hasil.length }}</strong> hasil untuk
          "<strong>{{ keyword }}</strong>"
        </span>
        <span v-else>Tidak ada hasil untuk "<strong>{{ keyword }}</strong>"</span>
      </div>

      <!-- Result list -->
      <div v-if="hasil.length > 0" class="results-list">
        <a
          v-for="(item, i) in hasil"
          :key="i"
          :href="item.url"
          class="result-card"
        >
          <div class="result-header">
            <span class="result-badge" :style="`background:${(badgeColor[item.jenis] || '|').split('|')[0]};color:${(badgeColor[item.jenis] || '|').split('|')[1]}`">
              {{ item.jenis }}
            </span>
            <span v-if="item.tanggal" class="result-date">{{ formatTanggal(item.tanggal) }}</span>
          </div>
          <h2 class="result-title" v-html="highlight(item.judul, keyword)"></h2>
          <p v-if="item.ringkasan" class="result-snippet" v-html="highlight(item.ringkasan.substring(0, 200), keyword)"></p>
          <span class="result-url">{{ item.url }}</span>
        </a>
      </div>

      <!-- Empty state -->
      <div v-else-if="keyword" class="empty-state">
        <div class="empty-icon text-slate-400">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <h2 class="empty-title">Tidak Ada Hasil</h2>
        <p class="empty-desc">Coba kata kunci lain atau ubah filter pencarian.</p>
        <ul class="empty-tips">
          <li>Periksa ejaan kata kunci Anda</li>
          <li>Gunakan kata kunci yang lebih umum</li>
          <li>Coba filter "Semua" untuk hasil lebih luas</li>
        </ul>
      </div>

      <!-- No keyword yet -->
      <div v-else class="prompt-state">
        <div class="prompt-icon text-blue-600">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <h2 class="prompt-title">Apa yang ingin Anda cari?</h2>
        <p class="prompt-desc">Ketik kata kunci di kotak pencarian untuk mulai mencari konten.</p>
        <div class="quick-filters">
          <p class="qf-label">Telusuri berdasarkan jenis konten:</p>
          <div class="qf-grid">
            <button v-for="f in filters.slice(1)" :key="f.value" @click="setFilter(f.value); searchQuery=''; doSearch()" class="qf-btn">
              {{ f.label }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<style scoped>
.search-hero {
  background: linear-gradient(135deg, #1e3a5f, #2563eb);
  padding: 3rem 1.5rem;
}
.search-hero-inner { max-width: 700px; margin: 0 auto; }
.search-title { color: white; font-size: 2rem; font-weight: 800; margin: 0 0 1.5rem; text-align: center; }

.search-form { margin-bottom: 1rem; }
.search-input-wrap { display: flex; align-items: center; background: white; border-radius: 0.875rem; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
.search-icon { width: 1.25rem; height: 1.25rem; color: #6b7280; flex-shrink: 0; margin-left: 1rem; }
.search-input { flex: 1; padding: 0.9rem 0.75rem; border: none; outline: none; font-size: 1rem; color: #111827; }
.search-btn { padding: 0.9rem 1.5rem; background: #2563eb; color: white; border: none; font-weight: 700; cursor: pointer; transition: background 0.2s; }
.search-btn:hover { background: #1d4ed8; }

.filter-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; }
.chip { padding: 0.4rem 1rem; border-radius: 999px; border: 2px solid rgba(255,255,255,0.5); background: transparent; color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.chip:hover { border-color: white; color: white; }
.chip-active { background: white; color: #2563eb; border-color: white; }

.results-container { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.results-info { color: #6b7280; margin-bottom: 1.5rem; font-size: 0.95rem; }

.results-list { display: flex; flex-direction: column; gap: 1rem; }
.result-card {
  display: block; background: white; border-radius: 0.875rem;
  padding: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.07);
  text-decoration: none; border: 1px solid #f1f5f9;
  transition: transform 0.15s, box-shadow 0.15s;
}
.result-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
.result-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; }
.result-badge { padding: 0.2rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; }
.result-date { font-size: 0.8rem; color: #9ca3af; }
.result-title { font-size: 1.1rem; font-weight: 700; color: #1e3a5f; margin: 0 0 0.5rem; line-height: 1.4; }
.result-snippet { color: #6b7280; font-size: 0.9rem; line-height: 1.6; margin: 0 0 0.5rem; }
.result-url { font-size: 0.8rem; color: #2563eb; }
:deep(.hl) { background: #fef9c3; color: #854d0e; padding: 0 0.1rem; border-radius: 2px; font-style: normal; }

.empty-state, .prompt-state { text-align: center; padding: 4rem 1rem; }
.empty-icon, .prompt-icon { font-size: 3.5rem; margin-bottom: 1rem; }
.empty-title, .prompt-title { font-size: 1.5rem; font-weight: 800; color: #1e3a5f; margin: 0 0 0.5rem; }
.empty-desc, .prompt-desc { color: #6b7280; margin: 0 0 1.5rem; }
.empty-tips { list-style: disc; text-align: left; display: inline-block; color: #6b7280; line-height: 2; }
.qf-label { color: #6b7280; margin-bottom: 0.75rem; }
.qf-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; }
.qf-btn { padding: 0.5rem 1.25rem; background: #dbeafe; color: #1d4ed8; border: none; border-radius: 0.5rem; font-weight: 700; cursor: pointer; transition: background 0.2s; }
.qf-btn:hover { background: #bfdbfe; }
</style>
