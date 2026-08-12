<template>
  <div class="min-h-screen flex flex-col bg-slate-50 text-slate-800 font-sans">

    <!-- ⚠️ Maintenance Mode Banner -->
    <div v-if="settings.maintenance_mode"
      class="w-full bg-amber-400 text-amber-950 text-sm font-medium px-4 py-2.5 flex items-center justify-center gap-3 shadow-sm z-50">
      <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
      <span>
        <strong>Mode Pemeliharaan Aktif:</strong>
        {{ settings.maintenance_message || 'Website sedang dalam pemeliharaan berkala.' }}
      </span>
    </div>

    <!-- Top Header Announcement Bar -->
    <header class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white text-xs py-2 px-4 shadow-sm border-b border-blue-800/40">
      <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
        <div class="flex items-center gap-4">
          <span class="flex items-center gap-1.5 font-medium">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Portal Resmi Sekolah Digital
          </span>
          <span class="hidden md:inline text-slate-400">|</span>
          <span class="hidden md:inline text-slate-300">NPSN: {{ schoolProfile?.npsn || '10203040' }}</span>
        </div>
        <div class="flex items-center gap-4">
          <a :href="schoolProfile?.phone ? 'tel:' + schoolProfile.phone : '#'" class="flex items-center gap-1.5 hover:text-blue-200 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/></svg>
            {{ schoolProfile?.phone || '(021) 555-0199' }}
          </a>
          <a :href="schoolProfile?.email ? 'mailto:' + schoolProfile.email : '#'" class="hidden sm:flex items-center gap-1.5 hover:text-blue-200 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            {{ schoolProfile?.email || 'info@sekolah.digital' }}
          </a>
          <a href="/portal" class="bg-blue-600 hover:bg-blue-500 text-white px-2.5 py-0.5 rounded font-semibold transition-all hover:shadow">
            Portal Admin →
          </a>
        </div>
      </div>
    </header>

    <!-- Main Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs transition-all">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
          <!-- Logo & Brand -->
          <Link href="/" class="flex items-center gap-3 group">
            <div v-if="schoolProfile?.logo" class="h-12 flex items-center justify-center shrink-0">
              <img :src="'/storage/' + schoolProfile.logo" :alt="schoolProfile?.school_name" class="h-12 w-auto max-w-[180px] object-contain group-hover:scale-105 transition-transform" />
            </div>
            <div v-else class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-md group-hover:scale-105 transition-transform shrink-0">
              DS
            </div>
            <div>
              <span class="text-xl font-extrabold bg-gradient-to-r from-blue-900 via-indigo-900 to-blue-700 bg-clip-text text-transparent tracking-tight">
                {{ schoolProfile?.school_name || 'Digital School' }}
              </span>
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-widest">
                Cerdas • Berkarakter • Digital
              </span>
            </div>
          </Link>

          <!-- Desktop Menu Links -->
          <div class="hidden lg:flex items-center gap-1 font-medium text-sm text-slate-700">
            <Link href="/" class="px-3 py-2 rounded-lg hover:text-blue-600 hover:bg-blue-50/80 transition-all" :class="{ 'text-blue-600 font-bold bg-blue-50': $page.url === '/' }">
              Beranda
            </Link>

            <!-- Profil Dropdown -->
            <div class="relative group">
              <button class="px-3 py-2 flex items-center gap-1 rounded-lg hover:text-blue-600 hover:bg-blue-50/80 transition-all" :class="{ 'text-blue-600 font-bold bg-blue-50': ['/profil', '/guru-staf', '/fasilitas', '/prestasi'].some(path => $page.url.startsWith(path)) }">
                Profil
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
              </button>
              <div class="absolute left-0 mt-0 pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="bg-white border border-slate-100 rounded-xl shadow-xl py-2">
                  <Link href="/profil" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Profil Sekolah</Link>
                  <Link href="/guru-staf" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Guru & Staf</Link>
                  <Link href="/fasilitas" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Fasilitas</Link>
                  <Link href="/prestasi" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Prestasi</Link>
                </div>
              </div>
            </div>

            <!-- Informasi Dropdown -->
            <div class="relative group">
              <button class="px-3 py-2 flex items-center gap-1 rounded-lg hover:text-blue-600 hover:bg-blue-50/80 transition-all" :class="{ 'text-blue-600 font-bold bg-blue-50': ['/berita', '/pengumuman', '/agenda', '/galeri', '/dokumen'].some(path => $page.url.startsWith(path)) }">
                Informasi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
              </button>
              <div class="absolute left-0 mt-0 pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="bg-white border border-slate-100 rounded-xl shadow-xl py-2">
                  <Link href="/berita" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Berita Terkini</Link>
                  <Link href="/pengumuman" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Pengumuman</Link>
                  <Link href="/agenda" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Agenda Kegiatan</Link>
                  <Link href="/galeri" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Galeri Foto</Link>
                  <Link href="/dokumen" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">Dokumen Publik</Link>
                </div>
              </div>
            </div>

            <Link href="/kontak" class="px-3 py-2 rounded-lg hover:text-blue-600 hover:bg-blue-50/80 transition-all" :class="{ 'text-blue-600 font-bold bg-blue-50': $page.url.startsWith('/kontak') }">
              Kontak
            </Link>

            <Link href="/ppdb" class="ml-1 px-3 py-2 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-all" :class="{ 'bg-blue-800': $page.url.startsWith('/ppdb') }">
              PPDB
            </Link>

            <!-- Search Icon -->
            <Link href="/pencarian" class="ml-1 p-2 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Pencarian">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </Link>
          </div>

          <!-- Mobile Toggle Button -->
          <div class="lg:hidden flex items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
              <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
              <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Dropdown Navigation -->
      <div v-show="mobileMenuOpen" class="lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-4 space-y-1">
        <Link href="/" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Beranda</Link>
        <Link href="/profil" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Profil Sekolah</Link>
        <Link href="/berita" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Berita</Link>
        <Link href="/pengumuman" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Pengumuman</Link>
        <Link href="/agenda" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Agenda</Link>
        <Link href="/galeri" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Galeri</Link>
        <Link href="/guru-staf" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Guru & Staf</Link>
        <Link href="/fasilitas" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Fasilitas</Link>
        <Link href="/prestasi" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Prestasi</Link>
        <Link href="/dokumen" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Dokumen</Link>
        <Link href="/kontak" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Kontak</Link>
        <Link href="/ppdb" class="block px-3 py-2 rounded-lg font-bold text-white bg-blue-600 hover:bg-blue-700">PPDB</Link>
        <Link href="/pencarian" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Pencarian</Link>
      </div>
    </nav>

    <!-- Main Dynamic Content Slot -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
          <div class="md:col-span-1 space-y-4">
            <div class="flex items-center gap-3">
              <div v-if="schoolProfile?.logo" class="h-10 flex items-center justify-center shrink-0">
                <img :src="'/storage/' + schoolProfile.logo" :alt="schoolProfile?.school_name" class="h-10 w-auto max-w-[150px] object-contain" />
              </div>
              <div v-else class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white font-extrabold shrink-0">
                DS
              </div>
              <span class="text-xl font-bold text-white tracking-tight">{{ schoolProfile?.school_name || 'Digital School' }}</span>
            </div>
            <p class="text-sm text-slate-400 leading-relaxed">
              {{ schoolProfile?.address || 'Jl. Pendidikan No. 100, Kota Digital' }}
            </p>
            <div class="text-xs text-slate-400 space-y-1">
              <p>Telepon: {{ schoolProfile?.phone || '(021) 555-0199' }}</p>
              <p>Email: {{ schoolProfile?.email || 'info@sekolah.digital' }}</p>
              <p>Akreditasi: {{ schoolProfile?.accreditation || 'A' }}</p>
            </div>
            <!-- Social Media Icons -->
            <div class="flex items-center gap-3 pt-2">
              <a v-if="settings.social_instagram" :href="settings.social_instagram" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-pink-600 flex items-center justify-center transition-colors" title="Instagram">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              </a>
              <a v-if="settings.social_facebook" :href="settings.social_facebook" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-colors" title="Facebook">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <a v-if="settings.social_youtube" :href="settings.social_youtube" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-red-600 flex items-center justify-center transition-colors" title="YouTube">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              </a>
            </div>
          </div>

          <div>
            <h4 class="text-white font-bold text-base mb-4 border-b border-slate-800 pb-2">Jelajah Halaman</h4>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="hover:text-blue-400 transition-colors">Beranda Utama</Link></li>
              <li><Link href="/profil" class="hover:text-blue-400 transition-colors">Profil & Visi Misi</Link></li>
              <li><Link href="/berita" class="hover:text-blue-400 transition-colors">Kabar & Berita Terbaru</Link></li>
              <li><Link href="/pengumuman" class="hover:text-blue-400 transition-colors">Informasi Pengumuman</Link></li>
            </ul>
          </div>

          <div>
            <h4 class="text-white font-bold text-base mb-4 border-b border-slate-800 pb-2">Informasi Publik</h4>
            <ul class="space-y-2 text-sm">
              <li><Link href="/agenda" class="hover:text-blue-400 transition-colors">Agenda & Kalender Kegiatan</Link></li>
              <li><Link href="/galeri" class="hover:text-blue-400 transition-colors">Galeri Foto & Video</Link></li>
              <li><Link href="/guru-staf" class="hover:text-blue-400 transition-colors">Direktori Guru & Staf</Link></li>
              <li><Link href="/ppdb" class="hover:text-blue-400 transition-colors">Pendaftaran (PPDB)</Link></li>
              <li><Link href="/pencarian" class="hover:text-blue-400 transition-colors">Pencarian Konten</Link></li>
              <li><a href="/portal" class="hover:text-blue-400 transition-colors">Login Portal CMS</a></li>
            </ul>
          </div>

          <div>
            <h4 class="text-white font-bold text-base mb-4 border-b border-slate-800 pb-2">Jam Layanan & Info</h4>
            <p class="text-sm text-slate-400 mb-3">
              Senin - Jumat: 07:00 - 15:30 WIB<br>
              Sabtu - Minggu: Libur
            </p>
            <div class="p-3 rounded-lg bg-blue-950/60 border border-blue-800/50 text-xs text-blue-300">
              Platform Digital School CMS Laravel 13 Powered by Inertia + Vue 3
            </div>
          </div>
        </div>

        <div class="mt-12 pt-6 border-t border-slate-800/80 text-center text-xs text-slate-500 flex flex-wrap justify-between items-center gap-4">
          <p>© {{ new Date().getFullYear() }} {{ schoolProfile?.school_name || 'Digital School' }}. All rights reserved.</p>
          <p>Hak Cipta Dilindungi Undang-Undang</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const mobileMenuOpen = ref(false);
const page = usePage();
const schoolProfile = computed(() => page.props.school_profile);
const settings = computed(() => page.props.settings || {});

// Register PWA Service Worker
onMounted(() => {
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(() => {});
  }
});
</script>
