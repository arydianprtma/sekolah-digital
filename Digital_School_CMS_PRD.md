# PRD --- Digital School CMS

**Nama Produk:** Digital School CMS\
**Platform:** Web\
**Framework:** Laravel 13\
**Database:** MariaDB\
**Frontend:** Inertia.js + Vue 3 + Tailwind CSS\
**Admin Panel:** Filament\
**Deployment:** VPS + Nginx + PHP-FPM

------------------------------------------------------------------------

## 1. Tujuan Produk

Digital School CMS adalah platform website sekolah yang berfungsi
sebagai pusat pengelolaan konten dan informasi sekolah. Sistem dirancang
agar administrator dan operator dapat mengelola seluruh konten website
tanpa perlu mengubah kode program.

Tujuan utama:

-   Menyediakan website resmi sekolah yang profesional dan responsif.
-   Menyediakan CMS untuk mengelola konten sekolah.
-   Memusatkan pengelolaan berita, pengumuman, agenda, galeri, dokumen,
    guru, fasilitas, dan informasi sekolah.
-   Menyediakan pengelolaan SEO.
-   Menyediakan sistem role dan permission.
-   Menyediakan audit trail untuk aktivitas administrator.
-   Menjadi fondasi untuk pengembangan modul SPMB/PPDB, akademik,
    presensi, pembayaran, dan portal siswa di masa depan.

------------------------------------------------------------------------

# 2. Ruang Lingkup Produk

Produk dibagi menjadi dua bagian utama:

1.  **Public Website**
2.  **Admin CMS**

## 2.1 Public Website

Public website adalah bagian yang dapat diakses masyarakat tanpa login.

Fitur utama:

-   Homepage
-   Profil sekolah
-   Visi dan misi
-   Sejarah sekolah
-   Struktur organisasi
-   Guru dan tenaga kependidikan
-   Program unggulan
-   Ekstrakurikuler
-   Fasilitas
-   Prestasi
-   Berita
-   Pengumuman
-   Agenda
-   Galeri
-   Dokumen
-   FAQ
-   PPDB/SPMB information
-   Kontak
-   Search
-   Social media
-   SEO metadata

## 2.2 Admin CMS

Admin CMS digunakan oleh pihak sekolah untuk mengelola website.

Fitur utama:

-   Dashboard
-   User management
-   Role & permission
-   Page management
-   News management
-   Category & tag
-   Announcement
-   Agenda
-   Gallery
-   Media library
-   School profile
-   Teacher & staff
-   Facilities
-   Achievements
-   Document center
-   Menu builder
-   Homepage builder
-   SEO management
-   Contact management
-   Notification
-   Audit log
-   System settings
-   Backup
-   Maintenance mode

------------------------------------------------------------------------

# 3. Role Pengguna

## 3.1 Super Admin

Memiliki akses penuh terhadap sistem.

Permission:

-   Mengelola seluruh konten.
-   Mengelola user.
-   Mengelola role.
-   Mengelola permission.
-   Mengubah system settings.
-   Mengelola media.
-   Mengelola SEO.
-   Melihat audit log.
-   Mengelola backup.
-   Mengaktifkan maintenance mode.

## 3.2 Admin Sekolah

Mengelola operasional website.

Permission:

-   Mengelola berita.
-   Mengelola pengumuman.
-   Mengelola agenda.
-   Mengelola galeri.
-   Mengelola halaman.
-   Mengelola dokumen.
-   Mengelola guru/staff.
-   Mengelola fasilitas.
-   Mengelola prestasi.
-   Mengelola homepage.

Tidak memiliki akses terhadap konfigurasi sistem kritis.

## 3.3 Operator

Berfokus pada data dan administrasi.

Permission:

-   Mengelola data guru.
-   Mengelola data siswa jika modul tersedia.
-   Mengelola dokumen.
-   Mengelola agenda.
-   Mengelola pengumuman.
-   Mengelola PPDB/SPMB jika modul diaktifkan.

## 3.4 Editor / Content Manager

Berfokus pada pembuatan konten.

Permission:

-   Membuat berita.
-   Mengedit berita.
-   Mengunggah media.
-   Membuat halaman.
-   Mengelola galeri.
-   Membuat pengumuman.

Tidak dapat mengelola user atau konfigurasi sistem.

## 3.5 Author

Opsional.

Permission:

-   Membuat draft berita.
-   Mengedit berita miliknya.
-   Mengunggah media.
-   Tidak dapat langsung mempublikasikan konten tanpa approval.

## 3.6 Guru

Role ini disiapkan untuk pengembangan School Management System.

Potensi fitur:

-   Profil guru.
-   Materi.
-   Jadwal.
-   Presensi.
-   Nilai.
-   Pengumuman internal.

Role ini tidak wajib diaktifkan pada MVP CMS.

------------------------------------------------------------------------

# 4. Public Website

## 4.1 Homepage

Homepage harus dapat dikonfigurasi melalui CMS.

Section:

-   Hero/banner
-   Sambutan kepala sekolah
-   Statistik sekolah
-   Program unggulan
-   Berita terbaru
-   Agenda terdekat
-   Prestasi
-   Galeri
-   Pengumuman
-   CTA PPDB/SPMB
-   Testimoni
-   Partner/logo
-   Social media
-   Footer

Admin harus dapat:

-   Mengaktifkan/nonaktifkan section.
-   Mengubah urutan section.
-   Mengubah judul.
-   Mengubah gambar.
-   Mengubah CTA.
-   Mengubah konten tertentu.

------------------------------------------------------------------------

# 5. Page CMS

Admin dapat membuat halaman custom tanpa coding.

Contoh halaman:

-   Tentang Sekolah
-   Sejarah
-   Visi & Misi
-   Struktur Organisasi
-   Fasilitas
-   Program Unggulan
-   Ekstrakurikuler
-   Halaman informasi lainnya

## Field

-   Title
-   Slug
-   Content
-   Featured image
-   Author
-   Status
-   Published at
-   Template
-   SEO title
-   SEO description
-   SEO image
-   Canonical URL
-   Breadcrumb
-   Robots metadata

## Status

-   Draft
-   Review
-   Published
-   Archived

------------------------------------------------------------------------

# 6. News Management

CMS berita.

Fitur:

-   Create news
-   Edit news
-   Delete news
-   Draft
-   Review
-   Publish
-   Schedule publish
-   Category
-   Tag
-   Featured image
-   Gallery
-   Author
-   Related news
-   SEO metadata
-   View counter

## Entity

``` text
News
├── Title
├── Slug
├── Excerpt
├── Content
├── Thumbnail
├── Category
├── Tags
├── Author
├── Published At
├── Status
└── SEO
```

------------------------------------------------------------------------

# 7. Category & Tag Management

Digunakan untuk mengorganisasi konten.

Contoh kategori:

-   Akademik
-   Kesiswaan
-   Prestasi
-   Kegiatan
-   Pengumuman
-   Keagamaan
-   Sekolah
-   Ekstrakurikuler

Fitur:

-   Create
-   Edit
-   Delete
-   Slug
-   Description
-   SEO metadata
-   Status

------------------------------------------------------------------------

# 8. Announcement Management

Pengumuman berbeda dari berita dan digunakan untuk informasi yang
bersifat administratif atau penting.

Contoh:

-   Jadwal ujian
-   Jadwal libur
-   Pengambilan raport
-   Informasi pembayaran
-   Perubahan jadwal

## Field

-   Title
-   Content
-   Attachment
-   Start date
-   End date
-   Priority
-   Status
-   Published at

------------------------------------------------------------------------

# 9. Agenda Sekolah

Digunakan untuk mengelola kalender kegiatan sekolah.

Jenis kegiatan:

-   Rapat
-   Ujian
-   Libur
-   Kegiatan siswa
-   Seminar
-   Workshop
-   Upacara
-   Pendaftaran
-   Wisuda

## Field

``` text
Event
├── Title
├── Description
├── Start Date
├── End Date
├── Location
├── Organizer
├── Image
└── Status
```

Fitur:

-   Calendar view
-   List view
-   Filter tanggal
-   Filter kategori
-   Publish/unpublish
-   Detail event

------------------------------------------------------------------------

# 10. Gallery Management

Gallery digunakan untuk dokumentasi kegiatan sekolah.

Jenis:

-   Foto
-   Video
-   Dokumentasi kegiatan

## Album

``` text
Album
├── Title
├── Description
├── Cover
├── Published At
└── Status
```

## Gallery Item

``` text
Gallery Item
├── Album
├── Media
├── Caption
├── Sort Order
└── Status
```

Fitur:

-   Create album
-   Upload multiple images
-   Drag & drop sorting
-   Caption
-   Cover album
-   Visibility
-   Delete
-   Preview

------------------------------------------------------------------------

# 11. Media Library

Media Library menjadi pusat penyimpanan seluruh file CMS.

Kategori:

-   Images
-   Documents
-   Videos
-   Others

Fitur:

-   Upload
-   Multiple upload
-   Folder
-   Search
-   Filter
-   Rename
-   Delete
-   Preview
-   Alt text
-   Caption
-   File size
-   MIME type
-   Metadata
-   Storage information

Media harus dapat digunakan kembali oleh berbagai modul sehingga tidak
terjadi duplikasi file.

------------------------------------------------------------------------

# 12. School Profile

CMS untuk identitas sekolah.

## General Information

-   Nama sekolah
-   NPSN
-   Alamat
-   Telepon
-   Email
-   Website
-   Tahun berdiri
-   Akreditasi
-   Kepala sekolah

## Sejarah

Rich text editor untuk sejarah sekolah.

## Visi & Misi

``` text
Visi
...

Misi
1. ...
2. ...
3. ...
```

## Sambutan Kepala Sekolah

Field:

-   Foto
-   Nama
-   Jabatan
-   Sambutan
-   Status publikasi

------------------------------------------------------------------------

# 13. Teacher & Staff Management

Directory guru dan tenaga kependidikan.

## Field

-   Nama
-   NIP
-   NUPTK jika tersedia
-   Jabatan
-   Mata pelajaran
-   Foto
-   Bio
-   Email
-   Status
-   Sort order

Kategori:

-   Guru
-   Staff
-   Kepala Sekolah
-   Wakil Kepala Sekolah
-   Tenaga Kependidikan

Fitur:

-   Create
-   Edit
-   Delete
-   Activate/deactivate
-   Upload photo
-   Reorder

------------------------------------------------------------------------

# 14. Organization Structure

Struktur organisasi sekolah harus dapat dikonfigurasi.

Contoh:

``` text
                    KEPALA SEKOLAH
                          |
            +-------------+-------------+
            |             |             |
        Wakasek        Wakasek       Wakasek
        Kurikulum      Kesiswaan     Sarpras
            |
       +----+----+
       |         |
     Guru       Staff
```

Field:

-   Nama
-   Jabatan
-   Foto
-   Parent position
-   Sort order
-   Status

------------------------------------------------------------------------

# 15. Facilities Management

Digunakan untuk menampilkan fasilitas sekolah.

Contoh:

-   Laboratorium
-   Perpustakaan
-   Masjid
-   Lapangan
-   Ruang kelas
-   Laboratorium komputer
-   Asrama

## Field

-   Nama fasilitas
-   Deskripsi
-   Foto utama
-   Gallery
-   Fasilitas yang tersedia
-   Status
-   Sort order

------------------------------------------------------------------------

# 16. Program & Extracurricular Management

## Program Unggulan

Contoh:

-   Tahfidz
-   Bahasa Inggris
-   Digital Technology
-   Entrepreneurship

## Ekstrakurikuler

Contoh:

-   Basket
-   Futsal
-   Pramuka
-   PMR
-   Rohis
-   Programming

## Field

-   Nama
-   Slug
-   Deskripsi
-   Foto
-   Pembina
-   Jadwal
-   Lokasi
-   Status
-   Sort order

------------------------------------------------------------------------

# 17. Achievement Management

Digunakan untuk menampilkan prestasi sekolah dan siswa.

## Field

-   Nama prestasi
-   Nama siswa/tim
-   Tingkat
-   Tahun
-   Juara
-   Kategori
-   Foto
-   Deskripsi
-   Status

Contoh:

> Juara 1 Olimpiade Matematika Tingkat Kabupaten --- 2026

------------------------------------------------------------------------

# 18. PPDB / SPMB Integration

CMS dapat menjadi landing dan information layer untuk sistem PPDB/SPMB.

## Konten yang dapat dikelola

-   Tahun ajaran
-   Periode pendaftaran
-   Gelombang
-   Persyaratan
-   Biaya
-   Jadwal
-   Kontak
-   FAQ
-   Link sistem pendaftaran

Contoh CTA:

``` text
PENERIMAAN MURID BARU
TAHUN AJARAN 2027/2028

Pendaftaran telah dibuka.

[ DAFTAR SEKARANG ]
```

Jika sistem SPMB dibuat sebagai aplikasi terpisah, CMS cukup menyediakan
informasi dan link menuju sistem SPMB.

------------------------------------------------------------------------

# 19. Document Center

Digunakan untuk menyediakan dokumen yang dapat diunduh publik.

Contoh:

-   Kalender pendidikan
-   Tata tertib
-   Brosur sekolah
-   Formulir pendaftaran
-   Kurikulum
-   Panduan PPDB
-   Surat edaran

## Field

-   Title
-   Description
-   File
-   Category
-   Year
-   File size
-   Download counter
-   Visibility
-   Published at

------------------------------------------------------------------------

# 20. FAQ Management

Admin dapat membuat pertanyaan dan jawaban.

``` text
Question
    |
    +-- Answer
```

Contoh:

-   Apakah sekolah menerima siswa pindahan?
-   Bagaimana cara mendaftar?
-   Apa saja persyaratan pendaftaran?
-   Kapan pendaftaran dibuka?

FAQ dapat digunakan untuk meningkatkan SEO dan membantu pengunjung
memperoleh informasi secara cepat.

------------------------------------------------------------------------

# 21. Contact Management

## Contact Information

-   Alamat
-   Telepon
-   WhatsApp
-   Email
-   Google Maps
-   Jam pelayanan
-   Social media

## Contact Form

Field:

-   Nama
-   Email
-   Subjek
-   Pesan

Pesan disimpan di CMS dan dapat diberi status:

-   New
-   Read
-   Replied
-   Archived

------------------------------------------------------------------------

# 22. Social Media Management

Admin dapat mengatur link:

-   Instagram
-   Facebook
-   YouTube
-   TikTok
-   WhatsApp
-   X
-   LinkedIn

URL social media tidak boleh hardcode di frontend.

------------------------------------------------------------------------

# 23. Navigation / Menu Builder

Admin dapat mengatur struktur navigasi website.

Contoh:

``` text
Beranda

Profil
├── Tentang
├── Sejarah
├── Visi & Misi
└── Struktur Organisasi

Akademik
├── Program
├── Guru
└── Ekstrakurikuler

Informasi
├── Berita
├── Pengumuman
└── Agenda

Galeri
PPDB
Kontak
```

Fitur:

-   Drag & drop
-   Parent menu
-   Internal URL
-   External URL
-   Open new tab
-   Active/inactive
-   Sort order

------------------------------------------------------------------------

# 24. Homepage Builder

Homepage menggunakan sistem section/block.

Contoh:

``` text
Homepage Sections

1. Hero
2. Sambutan
3. Statistik
4. Program Unggulan
5. Berita
6. Agenda
7. Prestasi
8. Galeri
9. PPDB
10. CTA
```

Fitur:

-   Enable/disable
-   Reorder
-   Edit content
-   Change image
-   Change title
-   Change CTA
-   Configure data source

------------------------------------------------------------------------

# 25. SEO Management

SEO harus tersedia secara global dan per konten.

## Per halaman/konten

-   SEO title
-   Meta description
-   Canonical URL
-   OG title
-   OG description
-   OG image
-   Robots
-   Keywords jika diperlukan

## Automatic SEO

-   sitemap.xml
-   robots.txt
-   canonical URL
-   Open Graph
-   Twitter/X Card
-   JSON-LD
-   Breadcrumb schema
-   Organization/School schema

------------------------------------------------------------------------

# 26. Search

Public search harus dapat mencari:

-   Berita
-   Halaman
-   Pengumuman
-   Agenda
-   Dokumen
-   FAQ
-   Prestasi
-   Program

Fitur:

-   Search keyword
-   Filter content type
-   Pagination
-   Highlight keyword
-   Empty state
-   Search suggestion

Jika jumlah data sudah besar, pencarian dapat dikembangkan menggunakan
Laravel Scout atau search engine eksternal.

------------------------------------------------------------------------

# 27. Admin Dashboard

Dashboard menampilkan ringkasan sistem.

## Statistik

-   Total visitors
-   Total news
-   Total pages
-   Total events
-   Total gallery
-   Total documents
-   Total contact messages
-   Total users

## Activity

Menampilkan aktivitas terbaru:

``` text
Admin published news
Operator uploaded document
Editor updated homepage
Admin changed settings
```

## Analytics

-   Traffic chart
-   Popular pages
-   Popular news
-   Recent visitors jika analytics internal digunakan

------------------------------------------------------------------------

# 28. Analytics

Minimal analytics:

-   Page views
-   Unique visitors
-   Popular pages
-   Popular news
-   Traffic source
-   Device
-   Browser
-   Country
-   Referrer

Rekomendasi:

-   Google Analytics
-   Google Search Console

Sistem internal hanya perlu digunakan untuk kebutuhan yang tidak
tersedia dari layanan eksternal.

------------------------------------------------------------------------

# 29. Audit Log

Semua aktivitas penting administrator dicatat.

## Data

``` text
Audit Log
├── User
├── Action
├── Model
├── Record
├── IP Address
├── User Agent
├── Timestamp
└── Changes
```

Contoh:

``` text
08 August 2026 21:34

Admin
Updated News #32

Changed:
status: draft -> published
```

Audit log tidak boleh mudah dihapus oleh user biasa.

------------------------------------------------------------------------

# 30. User Management

Super Admin dapat mengelola:

-   Create user
-   Edit user
-   Suspend user
-   Activate user
-   Reset password
-   Assign role
-   View last login
-   View login activity
-   2FA

------------------------------------------------------------------------

# 31. Role & Permission

Permission harus granular.

Contoh:

``` text
news.view
news.create
news.update
news.delete
news.publish

gallery.view
gallery.create
gallery.update
gallery.delete

pages.view
pages.create
pages.update
pages.delete

users.view
users.create
users.update
users.delete
```

Authorization harus menggunakan policy/permission system dan tidak
bergantung pada pemeriksaan role secara hardcoded.

------------------------------------------------------------------------

# 32. System Settings

Semua konfigurasi global dikelola dari satu tempat.

## General

-   School name
-   Logo
-   Favicon
-   Email
-   Phone
-   Address

## Appearance

-   Theme
-   Colors
-   Fonts
-   Layout

## SEO

-   Default SEO title
-   Default description
-   Default OG image

## Social

-   Instagram
-   Facebook
-   YouTube
-   TikTok
-   WhatsApp

## Email

-   SMTP
-   Sender name
-   Sender email

## Maintenance

-   Maintenance mode
-   Maintenance message

------------------------------------------------------------------------

# 33. Notification System

Admin menerima notifikasi untuk aktivitas penting.

Contoh:

-   New contact message
-   New PPDB registration
-   Scheduled article published
-   System warning
-   Failed job
-   Backup failed

Channel:

-   Database
-   Email
-   WhatsApp
-   Telegram

WhatsApp dan Telegram merupakan fitur opsional tahap lanjutan.

------------------------------------------------------------------------

# 34. Security

Security harus dirancang sejak awal.

## Authentication

-   Secure password hashing
-   Session management
-   Login throttling
-   Password reset
-   Email verification jika diperlukan
-   Two-factor authentication

## Authorization

-   Role
-   Permission
-   Policy

## Input Security

-   Validation
-   Sanitization
-   CSRF protection
-   XSS protection
-   SQL injection protection
-   Rate limiting

## File Upload Security

-   MIME validation
-   Extension validation
-   Maximum file size
-   Image validation
-   Secure filename
-   Storage isolation
-   Prevent executable uploads

## Additional Security

-   Security headers
-   Login activity
-   Audit log
-   Backup
-   HTTPS
-   Secret management

------------------------------------------------------------------------

# 35. Backup Management

Backup database dan file harus tersedia.

## Schedule

-   Daily
-   Weekly
-   Monthly

Admin dapat:

-   Melihat backup
-   Download backup
-   Delete backup
-   Melihat status backup

Backup production sebaiknya disimpan pada storage yang berbeda dari VPS
utama.

------------------------------------------------------------------------

# 36. Maintenance Mode

Admin dapat mengaktifkan maintenance mode.

Public website menampilkan:

``` text
Website sedang dalam pemeliharaan.

Kami akan segera kembali.
```

Admin CMS tetap dapat mengakses dashboard.

------------------------------------------------------------------------

# 37. Performance

Website harus dirancang untuk performa tinggi.

Strategi:

-   Page caching
-   Query optimization
-   Database indexing
-   Redis
-   Queue
-   Image optimization
-   WebP/AVIF
-   Lazy loading
-   Responsive images
-   CDN
-   HTTP caching
-   Compression
-   Asset optimization

Target:

-   Fast first load
-   Mobile-friendly
-   Minimal unnecessary database queries
-   Optimized images
-   Efficient cache invalidation

------------------------------------------------------------------------

# 38. Responsive Design

Website harus mendukung:

-   Desktop
-   Laptop
-   Tablet
-   Mobile

Breakpoints harus diuji pada perangkat umum.

Semua fitur public website harus tetap usable pada layar mobile.

------------------------------------------------------------------------

# 39. Accessibility

Target dasar:

-   Semantic HTML
-   Keyboard navigation
-   Proper heading hierarchy
-   Alt text
-   Accessible forms
-   Sufficient contrast
-   Focus states
-   ARIA hanya ketika diperlukan

------------------------------------------------------------------------

# 40. Multilingual

Fitur opsional.

Bahasa:

-   Bahasa Indonesia
-   English

Tidak masuk MVP kecuali sekolah membutuhkan versi bilingual.

------------------------------------------------------------------------

# 41. PWA

Fitur tahap lanjutan:

-   Installable website
-   Home screen icon
-   Offline fallback
-   Web app manifest
-   Service worker
-   Push notification jika dibutuhkan

------------------------------------------------------------------------

# 42. AI Features

AI menjadi fitur tahap lanjutan.

## AI Writing Assistant

Saat membuat berita:

``` text
Judul:
Prestasi Siswa dalam Olimpiade...

[Generate Article]
```

AI menghasilkan draft artikel.

## AI SEO Assistant

``` text
[Generate SEO Title]
[Generate Meta Description]
```

## AI Summary

Artikel panjang dapat dibuat ringkas secara otomatis.

## AI Search Assistant

Pengunjung dapat bertanya:

> Kapan pendaftaran siswa baru dibuka?

AI memberikan jawaban berdasarkan informasi resmi yang tersedia di CMS.

AI tidak boleh menjadi sumber informasi utama. Jawaban harus bersumber
dari data/konten resmi sekolah.

------------------------------------------------------------------------

# 43. Future School Management System

CMS dapat dikembangkan menjadi platform sekolah digital penuh.

## SPMB / PPDB

``` text
Registration
Verification
Selection
Announcement
```

## Academic

``` text
Students
Classes
Teachers
Subjects
Schedule
Attendance
Grades
```

## Student Portal

``` text
Profile
Schedule
Attendance
Grades
Documents
```

## Teacher Portal

``` text
Profile
Schedule
Attendance
Grades
Materials
```

## Parent Portal

``` text
Student Information
Attendance
Grades
Announcements
Payments
```

------------------------------------------------------------------------

# 44. Phase Development

## Phase 1 --- Core CMS (MVP)

Prioritas P0:

``` text
Authentication
User Management
Role & Permission
Dashboard
Pages
News
Categories
Announcements
Agenda
Gallery
Media Library
School Profile
Teacher & Staff
```

Target:

Website sekolah sudah dapat berjalan dan seluruh konten dasar dapat
dikelola melalui CMS.

------------------------------------------------------------------------

## Phase 2 --- Professional CMS

Prioritas P1:

``` text
Facilities
Achievements
Document Center
Menu Builder
Homepage Builder
SEO Management
Contact Management
Notification
Audit Log
System Settings
Backup
Maintenance Mode
```

Target:

CMS siap digunakan secara production oleh sekolah.

------------------------------------------------------------------------

## Phase 3 --- Digital School

Prioritas P2:

``` text
PPDB / SPMB
Analytics
Advanced Search
Newsletter
Multilingual
PWA
```

Target:

Website berkembang menjadi platform layanan digital sekolah.

------------------------------------------------------------------------

## Phase 4 --- School Management Platform

Prioritas P3:

``` text
Student Portal
Teacher Portal
Parent Portal
Academic Management
Attendance
Grades
Schedule
Payment
E-Learning
AI Assistant
Mobile Application
```

Target:

CMS berkembang menjadi School Management System.

------------------------------------------------------------------------

# 45. Product Roadmap

``` text
                    DIGITAL SCHOOL PLATFORM

                           PHASE 1
                        CORE CMS / MVP
                              |
                              v
                    +-------------------+
                    | Public Website    |
                    | Admin CMS         |
                    | Content           |
                    | Media             |
                    | School Profile    |
                    +-------------------+
                              |
                              v
                           PHASE 2
                     PROFESSIONAL CMS
                              |
                    +-------------------+
                    | SEO               |
                    | Analytics         |
                    | Audit Log         |
                    | Notification      |
                    | Backup            |
                    +-------------------+
                              |
                              v
                           PHASE 3
                      DIGITAL SCHOOL
                              |
                    +-------------------+
                    | SPMB / PPDB       |
                    | Search            |
                    | PWA               |
                    | Multilingual      |
                    +-------------------+
                              |
                              v
                           PHASE 4
                   SCHOOL MANAGEMENT
                              |
                    +-------------------+
                    | Student Portal    |
                    | Teacher Portal    |
                    | Parent Portal     |
                    | Academic          |
                    | Attendance        |
                    | Grades            |
                    | Payment           |
                    | E-Learning        |
                    | AI                |
                    +-------------------+
```

------------------------------------------------------------------------

# 46. Prioritas Fitur

    No Modul                     Priority
  ---- ------------------------ ----------
     1 Authentication               P0
     2 User & Role Management       P0
     3 Dashboard                    P0
     4 Page CMS                     P0
     5 News Management              P0
     6 Category & Tag               P0
     7 Announcement                 P0
     8 Agenda                       P0
     9 Gallery                      P0
    10 Media Library                P0
    11 School Profile               P0
    12 Teacher & Staff              P0
    13 Facilities                   P1
    14 Achievement                  P1
    15 Document Center              P1
    16 Menu Builder                 P1
    17 Homepage Builder             P1
    18 SEO Management               P1
    19 Contact Management           P1
    20 Notification                 P1
    21 Audit Log                    P1
    22 System Settings              P1
    23 Backup                       P1
    24 Maintenance Mode             P1
    25 PPDB / SPMB                  P2
    26 Analytics                    P2
    27 Advanced Search              P2
    28 Newsletter                   P2
    29 Multilingual                 P2
    30 PWA                          P2
    31 Student Portal               P3
    32 Teacher Portal               P3
    33 Parent Portal                P3
    34 Academic Management          P3
    35 Attendance                   P3
    36 Grades                       P3
    37 Payment                      P3
    38 E-Learning                   P3
    39 AI Assistant                 P3
    40 Mobile Application           P3

------------------------------------------------------------------------

# 47. Recommended Architecture

``` text
                         INTERNET
                            |
                            v
                    +---------------+
                    | Nginx / HTTPS |
                    +---------------+
                            |
                            v
                    +---------------+
                    | Laravel 13    |
                    +---------------+
                            |
              +-------------+-------------+
              |                           |
              v                           v
      +---------------+           +---------------+
      | Public Web    |           | Admin CMS     |
      | Inertia/Vue   |           | Filament      |
      +---------------+           +---------------+
              |                           |
              +-------------+-------------+
                            |
                     Application Layer
                            |
             +--------------+--------------+
             |              |              |
             v              v              v
        MariaDB          Redis         Storage
             |              |              |
             +--------------+--------------+
                            |
                  +---------+---------+
                  |                   |
                  v                   v
              Queue/Jobs          Notifications
```

------------------------------------------------------------------------

# 48. Recommended Technical Stack

## Backend

-   Laravel 13
-   PHP version sesuai requirement Laravel 13
-   MariaDB
-   Redis
-   Laravel Queue
-   Laravel Scheduler
-   Laravel Notifications
-   Laravel Policies
-   Laravel Cache

## Frontend

-   Inertia.js
-   Vue 3
-   Tailwind CSS
-   Vite

## Admin

-   Filament
-   Role & permission package yang kompatibel dengan stack
-   Activity/Audit logging

## Infrastructure

-   Ubuntu Server
-   Nginx
-   PHP-FPM
-   MariaDB
-   Redis
-   Supervisor
-   Cloudflare
-   Let's Encrypt
-   Object storage/CDN jika diperlukan

------------------------------------------------------------------------

# 49. Non-Functional Requirements

## Performance

-   Public pages harus memiliki response time rendah.
-   Database query harus dioptimalkan.
-   Gambar harus dioptimalkan.
-   Cache digunakan pada data yang sesuai.

## Security

-   HTTPS wajib pada production.
-   Password harus di-hash.
-   Semua input harus divalidasi.
-   File upload harus divalidasi.
-   Permission harus diterapkan pada setiap resource sensitif.
-   Aktivitas admin harus dapat diaudit.

## Availability

Target awal:

-   Website tersedia 24/7.
-   Backup otomatis.
-   Monitoring server.
-   Recovery procedure tersedia.

## Scalability

Arsitektur harus memungkinkan:

-   Penambahan sekolah/modul di masa depan.
-   Penambahan API.
-   Penambahan mobile application.
-   Integrasi SPMB.
-   Integrasi sistem akademik.
-   Integrasi layanan pihak ketiga.

## Maintainability

-   Modular codebase.
-   Service layer jika diperlukan.
-   Form request validation.
-   Policies.
-   Automated testing.
-   Clear naming convention.
-   Database migration.
-   Seeders.
-   Documentation.

------------------------------------------------------------------------

# 50. MVP Definition of Done

MVP dianggap selesai apabila:

-   Public website dapat diakses.
-   Admin dapat login.
-   Role dan permission berjalan.
-   Admin dapat membuat dan mengelola halaman.
-   Admin dapat membuat dan mempublikasikan berita.
-   Admin dapat mengelola kategori.
-   Admin dapat mengelola pengumuman.
-   Admin dapat mengelola agenda.
-   Admin dapat mengelola galeri.
-   Admin dapat mengelola media.
-   Admin dapat mengelola profil sekolah.
-   Admin dapat mengelola guru/staff.
-   Homepage dapat dikonfigurasi.
-   Menu dapat dikonfigurasi.
-   Website responsive.
-   SEO dasar tersedia.
-   File upload tervalidasi.
-   Audit log tersedia.
-   Backup tersedia.
-   Production deployment berhasil.
-   Automated tests untuk fitur kritis tersedia.

------------------------------------------------------------------------

# 51. Prinsip Pengembangan

1.  **CMS-first** --- seluruh konten yang mungkin berubah harus dapat
    dikelola melalui CMS.
2.  **Permission-first** --- akses berdasarkan permission, bukan sekadar
    nama role.
3.  **Security-by-design** --- security dirancang sejak awal.
4.  **Mobile-first** --- public website harus nyaman digunakan pada
    smartphone.
5.  **SEO-ready** --- setiap konten publik harus memiliki struktur SEO
    yang baik.
6.  **Performance-aware** --- caching, indexing, image optimization, dan
    queue dipertimbangkan sejak awal.
7.  **API-ready** --- struktur backend tidak dibuat terlalu bergantung
    pada frontend.
8.  **Modular** --- CMS dapat dikembangkan menjadi School Management
    System.
9.  **Auditability** --- aktivitas administrator penting harus dapat
    dilacak.
10. **Maintainability** --- codebase harus mudah dikembangkan oleh
    developer lain.

------------------------------------------------------------------------

# 52. Kesimpulan

Digital School CMS dirancang bukan sekadar sebagai website profil
sekolah, tetapi sebagai fondasi platform digital sekolah.

Tahap pertama berfokus pada CMS dan public website. Tahap berikutnya
dapat menambahkan SPMB/PPDB, portal siswa, portal guru, portal orang
tua, akademik, presensi, nilai, pembayaran, e-learning, dan AI.

Prioritas utama adalah membangun **Core CMS yang stabil, aman, modular,
SEO-friendly, responsive, dan mudah digunakan oleh operator sekolah**.

Dengan pendekatan tersebut, satu platform Laravel 13 dapat berkembang
secara bertahap dari:

``` text
Website Sekolah
       ↓
Website + CMS
       ↓
Digital School
       ↓
School Management System
       ↓
Full Digital School Platform
```
