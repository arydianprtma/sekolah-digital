<template>
  <MainLayout>
    <div class="bg-gradient-to-b from-blue-900 via-indigo-900 to-slate-900 text-white py-16 px-4">
      <div class="max-w-7xl mx-auto text-center space-y-4">
        <h1 class="text-4xl font-extrabold tracking-tight">Hubungi Kami & Layanan Informasi</h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto">
          Silakan kirimkan pertanyaan, saran, atau konsultasi pendaftaran. Tim administrasi kami siap melayani Anda.
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Informasi Kontak Sekolah -->
        <div class="space-y-8">
          <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6">
            <h2 class="text-2xl font-extrabold text-slate-900">Informasi Sekretariat</h2>

            <div class="space-y-4 text-slate-700">
              <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                  <span class="font-bold block text-slate-900">Alamat Lengkap:</span>
                  <p class="text-sm text-slate-600 mt-0.5">{{ profile?.address || 'Jl. Pendidikan No. 100, Kota Digital' }}</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/></svg>
                </div>
                <div>
                  <span class="font-bold block text-slate-900">Telepon / Fax:</span>
                  <p class="text-sm text-slate-600 mt-0.5">{{ profile?.phone || '(021) 555-0199' }}</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                  <span class="font-bold block text-slate-900">Email Resmi:</span>
                  <p class="text-sm text-slate-600 mt-0.5">{{ profile?.email || 'info@sekolah.digital' }}</p>
                </div>
              </div>
            </div>

            <div v-if="socials" class="pt-6 border-t border-slate-100 space-y-3">
              <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kanal Media Sosial</h3>
              <div class="flex flex-wrap gap-3">
                <a v-if="socials.instagram" :href="socials.instagram" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-pink-50 text-pink-700 rounded-lg text-xs font-bold hover:bg-pink-100 transition-colors">
                  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                  Instagram
                </a>
                <a v-if="socials.facebook" :href="socials.facebook" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors">
                  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                  Facebook
                </a>
                <a v-if="socials.youtube" :href="socials.youtube" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">
                  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                  YouTube
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Kirim Pesan -->
        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6">
          <h2 class="text-2xl font-extrabold text-slate-900">Kirim Pesan Langsung</h2>

          <div v-if="$page.props.flash?.success" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $page.props.flash.success }}
          </div>

          <form @submit.prevent="submit" class="space-y-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
              <input 
                v-model="form.name" 
                type="text" 
                required 
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                placeholder="Masukkan nama Anda"
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email *</label>
              <input 
                v-model="form.email" 
                type="email" 
                required 
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                placeholder="email@domain.com"
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Subjek Pesan</label>
              <input 
                v-model="form.subject" 
                type="text" 
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                placeholder="Contoh: Pertanyaan PPDB 2026"
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Isi Pesan *</label>
              <textarea 
                v-model="form.message" 
                rows="4" 
                required 
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                placeholder="Tuliskan pertanyaan atau tanggapan Anda..."
              ></textarea>
            </div>

            <button 
              type="submit" 
              :disabled="form.processing"
              class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white rounded-xl font-bold transition-all shadow-md hover:shadow-lg"
            >
              Kirim Pesan Sekarang →
            </button>
          </form>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
  profile: Object,
  socials: Object
})

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const submit = () => {
  form.post('/kontak', {
    onSuccess: () => form.reset()
  })
}
</script>
