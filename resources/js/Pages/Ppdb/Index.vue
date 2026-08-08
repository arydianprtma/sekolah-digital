<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  ppdb: Object,
})

const newsletterEmail = ref('')
const newsletterNama = ref('')
const nlLoading = ref(false)
const nlSuccess = ref(false)

function submitNewsletter() {
  nlLoading.value = true
  router.post('/newsletter/daftar', {
    email: newsletterEmail.value,
    nama: newsletterNama.value,
  }, {
    onSuccess: () => {
      nlSuccess.value = true
      newsletterEmail.value = ''
      newsletterNama.value = ''
    },
    onFinish: () => { nlLoading.value = false },
  })
}
</script>

<template>
  <MainLayout>
    <Head>
      <title>PPDB / Penerimaan Peserta Didik Baru</title>
      <meta name="description" content="Informasi pendaftaran peserta didik baru, persyaratan, jadwal, dan biaya." />
    </Head>

    <!-- Hero Section -->
    <section class="ppdb-hero">
      <div class="hero-overlay">
        <div class="hero-content">
          <div class="badge-ppdb">PPDB Online</div>
          <h1 class="hero-title">Penerimaan Peserta Didik Baru</h1>
          <p v-if="ppdb" class="hero-subtitle">Tahun Ajaran {{ ppdb.tahun_ajaran }}</p>
          <p v-else class="hero-subtitle">Informasi pendaftaran peserta didik baru</p>
        </div>
      </div>
    </section>

    <div class="ppdb-container">

      <!-- Status PPDB -->
      <section v-if="ppdb" class="ppdb-status-section">
        <div class="status-grid">
          <div class="status-card status-ta">
            <div class="status-icon">
              <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
            </div>
            <div class="status-info">
              <p class="status-label">Tahun Ajaran</p>
              <p class="status-value">{{ ppdb.tahun_ajaran }}</p>
            </div>
          </div>
          <div v-if="ppdb.gelombang" class="status-card status-gel">
            <div class="status-icon">
              <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="status-info">
              <p class="status-label">Gelombang</p>
              <p class="status-value">{{ ppdb.gelombang }}</p>
            </div>
          </div>
          <div v-if="ppdb.tanggal_mulai" class="status-card status-mulai">
            <div class="status-icon">
              <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="status-info">
              <p class="status-label">Mulai Pendaftaran</p>
              <p class="status-value">{{ new Date(ppdb.tanggal_mulai).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' }) }}</p>
            </div>
          </div>
          <div v-if="ppdb.tanggal_selesai" class="status-card status-selesai">
            <div class="status-icon">
              <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="status-info">
              <p class="status-label">Batas Pendaftaran</p>
              <p class="status-value">{{ new Date(ppdb.tanggal_selesai).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' }) }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Daftar -->
      <section v-if="ppdb && ppdb.link_pendaftaran" class="cta-section">
        <div class="cta-card">
          <div class="cta-content">
            <h2 class="cta-title">Daftarkan Putra/Putri Anda Sekarang!</h2>
            <p class="cta-desc">Pendaftaran dilakukan secara online melalui sistem PPDB kami</p>
          </div>
          <a :href="ppdb.link_pendaftaran" target="_blank" rel="noopener" class="cta-btn">
            Daftar Sekarang →
          </a>
        </div>
      </section>

      <!-- Konten PPDB -->
      <div v-if="ppdb" class="content-grid">

        <!-- Persyaratan -->
        <div v-if="ppdb.persyaratan" class="content-card">
          <h2 class="card-title">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Persyaratan Pendaftaran
          </h2>
          <div class="prose-content" v-html="ppdb.persyaratan"></div>
        </div>

        <!-- Jadwal -->
        <div v-if="ppdb.jadwal" class="content-card">
          <h2 class="card-title">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Jadwal PPDB
          </h2>
          <div class="prose-content" v-html="ppdb.jadwal"></div>
        </div>

        <!-- Biaya -->
        <div v-if="ppdb.biaya" class="content-card">
          <h2 class="card-title">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Informasi Biaya
          </h2>
          <div class="prose-content" v-html="ppdb.biaya"></div>
        </div>

        <!-- Keterangan -->
        <div v-if="ppdb.keterangan" class="content-card">
          <h2 class="card-title">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Informasi Tambahan
          </h2>
          <div class="prose-content" v-html="ppdb.keterangan"></div>
        </div>
      </div>

      <!-- Kontak PPDB -->
      <section v-if="ppdb && (ppdb.whatsapp_pendaftaran || ppdb.email_pendaftaran)" class="kontak-ppdb">
        <h2 class="kontak-title">Hubungi Kami</h2>
        <div class="kontak-grid">
          <a v-if="ppdb.whatsapp_pendaftaran"
             :href="'https://wa.me/' + ppdb.whatsapp_pendaftaran"
             target="_blank"
             class="kontak-card kontak-wa">
            <svg class="kontak-icon" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            <div>
              <p class="kontak-label">WhatsApp</p>
              <p class="kontak-val">{{ ppdb.whatsapp_pendaftaran }}</p>
            </div>
          </a>
          <a v-if="ppdb.email_pendaftaran"
             :href="'mailto:' + ppdb.email_pendaftaran"
             class="kontak-card kontak-email">
            <svg class="kontak-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <div>
              <p class="kontak-label">Email</p>
              <p class="kontak-val">{{ ppdb.email_pendaftaran }}</p>
            </div>
          </a>
        </div>
      </section>

      <!-- Belum ada PPDB aktif -->
      <div v-if="!ppdb" class="no-ppdb text-slate-400">
        <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <h2 class="no-ppdb-title">Informasi PPDB Belum Tersedia</h2>
        <p class="no-ppdb-desc">Informasi pendaftaran untuk tahun ajaran berikutnya akan segera diumumkan. Pantau terus website kami.</p>
      </div>

      <!-- Newsletter -->
      <section class="newsletter-section">
        <div class="newsletter-card">
          <h2 class="newsletter-title">Dapatkan Informasi PPDB Terbaru</h2>
          <p class="newsletter-desc">Daftarkan email Anda untuk mendapatkan notifikasi pembukaan PPDB dan informasi penting lainnya.</p>
          <div v-if="nlSuccess" class="nl-success flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Berhasil! Anda akan mendapatkan update terbaru dari kami.
          </div>
          <form v-else @submit.prevent="submitNewsletter" class="newsletter-form">
            <input v-model="newsletterNama" type="text" placeholder="Nama Anda (opsional)" class="nl-input" />
            <input v-model="newsletterEmail" type="email" placeholder="Email Anda" required class="nl-input" />
            <button type="submit" class="nl-btn" :disabled="nlLoading">
              {{ nlLoading ? 'Mendaftar...' : 'Berlangganan' }}
            </button>
          </form>
        </div>
      </section>

    </div>
  </MainLayout>
</template>

<style scoped>
.ppdb-hero {
  background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #7c3aed 100%);
  min-height: 320px;
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
}
.ppdb-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.hero-overlay { position: relative; z-index: 1; width: 100%; padding: 4rem 2rem; text-align: center; }
.badge-ppdb {
  display: inline-block;
  background: rgba(255,255,255,0.2);
  border: 1px solid rgba(255,255,255,0.3);
  color: white;
  padding: 0.3rem 1rem;
  border-radius: 999px;
  font-size: 0.85rem;
  font-weight: 600;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 1rem;
}
.hero-title { color: white; font-size: 2.5rem; font-weight: 800; margin: 0 0 0.5rem; }
.hero-subtitle { color: rgba(255,255,255,0.85); font-size: 1.2rem; margin: 0; }

.ppdb-container { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

.ppdb-status-section { margin: 2rem 0; }
.status-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
.status-card {
  display: flex; align-items: center; gap: 1rem;
  background: white; border-radius: 1rem; padding: 1.25rem 1.5rem;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  border-left: 4px solid;
}
.status-ta { border-color: #2563eb; }
.status-gel { border-color: #7c3aed; }
.status-mulai { border-color: #059669; }
.status-selesai { border-color: #d97706; }
.status-icon { font-size: 1.8rem; }
.status-label { font-size: 0.8rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; }
.status-value { font-size: 1.05rem; font-weight: 700; color: #111827; margin: 0.2rem 0 0; }

.cta-section { margin: 2rem 0; }
.cta-card {
  background: linear-gradient(135deg, #1e40af, #7c3aed);
  border-radius: 1.25rem; padding: 2rem 2.5rem;
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 1.5rem;
  box-shadow: 0 8px 32px rgba(37,99,235,0.3);
}
.cta-title { color: white; font-size: 1.4rem; font-weight: 800; margin: 0 0 0.3rem; }
.cta-desc { color: rgba(255,255,255,0.8); margin: 0; }
.cta-btn {
  display: inline-block;
  background: white; color: #2563eb;
  padding: 0.9rem 2rem; border-radius: 0.75rem;
  font-weight: 700; text-decoration: none; font-size: 1rem;
  white-space: nowrap;
  transition: transform 0.2s, box-shadow 0.2s;
}
.cta-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); }

.content-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(460px, 1fr)); gap: 1.5rem; margin: 2rem 0; }
.content-card { background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
.card-title { font-size: 1.2rem; font-weight: 700; color: #1e3a5f; margin: 0 0 1.25rem; display: flex; align-items: center; gap: 0.5rem; }
.card-icon { font-size: 1.3rem; }
.prose-content { color: #374151; line-height: 1.8; }
.prose-content :deep(ul) { padding-left: 1.5rem; }
.prose-content :deep(li) { margin-bottom: 0.4rem; }

.kontak-ppdb { margin: 2.5rem 0; }
.kontak-title { font-size: 1.4rem; font-weight: 700; color: #1e3a5f; margin: 0 0 1rem; }
.kontak-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem; }
.kontak-card {
  display: flex; align-items: center; gap: 1rem;
  padding: 1.25rem 1.5rem; border-radius: 1rem;
  text-decoration: none; transition: transform 0.2s;
}
.kontak-card:hover { transform: translateY(-2px); }
.kontak-wa { background: #dcfce7; color: #15803d; }
.kontak-email { background: #dbeafe; color: #1d4ed8; }
.kontak-icon { width: 2.5rem; height: 2.5rem; flex-shrink: 0; }
.kontak-label { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; }
.kontak-val { font-size: 1rem; font-weight: 700; margin: 0.2rem 0 0; }

.no-ppdb { text-align: center; padding: 5rem 2rem; }
.no-ppdb-icon { font-size: 4rem; margin-bottom: 1rem; }
.no-ppdb-title { font-size: 1.5rem; font-weight: 700; color: #1e3a5f; margin-bottom: 0.75rem; }
.no-ppdb-desc { color: #6b7280; max-width: 500px; margin: 0 auto; line-height: 1.7; }

.newsletter-section { margin-top: 3rem; }
.newsletter-card {
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  border: 1px solid #bae6fd;
  border-radius: 1.25rem; padding: 2.5rem;
  text-align: center;
}
.newsletter-title { font-size: 1.5rem; font-weight: 800; color: #1e3a5f; margin: 0 0 0.5rem; }
.newsletter-desc { color: #475569; margin: 0 0 1.5rem; }
.nl-success { background: #dcfce7; color: #15803d; padding: 1rem 1.5rem; border-radius: 0.75rem; font-weight: 600; }
.newsletter-form { display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
.nl-input { flex: 1; min-width: 200px; max-width: 280px; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.625rem; font-size: 0.95rem; outline: none; }
.nl-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.nl-btn { padding: 0.75rem 1.75rem; background: #2563eb; color: white; border: none; border-radius: 0.625rem; font-weight: 700; cursor: pointer; transition: background 0.2s; }
.nl-btn:hover:not(:disabled) { background: #1d4ed8; }
.nl-btn:disabled { opacity: 0.6; cursor: not-allowed; }

@media (max-width: 640px) {
  .hero-title { font-size: 1.75rem; }
  .content-grid { grid-template-columns: 1fr; }
  .cta-card { flex-direction: column; text-align: center; }
}
</style>
