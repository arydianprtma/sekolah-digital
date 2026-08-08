<template>
  <div class="min-h-screen flex flex-col bg-slate-50 text-slate-800 font-sans">
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
          <a :href="schoolProfile?.phone ? 'tel:' + schoolProfile.phone : '#'" class="hover:text-blue-200 transition-colors">
            📞 {{ schoolProfile?.phone || '(021) 555-0199' }}
          </a>
          <a :href="schoolProfile?.email ? 'mailto:' + schoolProfile.email : '#'" class="hidden sm:inline hover:text-blue-200 transition-colors">
            ✉️ {{ schoolProfile?.email || 'info@sekolah.digital' }}
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
            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-md group-hover:scale-105 transition-transform">
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
        <Link href="/pencarian" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">🔍 Pencarian</Link>
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
              <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white font-extrabold">DS</div>
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
import { ref, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const mobileMenuOpen = ref(false);
const page = usePage();
const schoolProfile = page.props.school_profile;

// Register PWA Service Worker
onMounted(() => {
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(() => {});
  }
});
</script>
