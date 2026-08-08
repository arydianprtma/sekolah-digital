<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Album;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Page;
use App\Models\PpdbSetting;
use App\Models\NewsletterSubscriber;
use App\Models\SchoolProfile;
use App\Models\Tag;
use App\Models\TeacherStaff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin Sekolah']);
        Role::firstOrCreate(['name' => 'Operator']);
        Role::firstOrCreate(['name' => 'Editor']);
        Role::firstOrCreate(['name' => 'Author']);

        // 2. Super Admin User
        $user = User::firstOrCreate(
            ['email' => 'admin@sekolah.digital'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole($superAdminRole);

        // 3. School Profile
        SchoolProfile::firstOrCreate(
            ['id' => 1],
            [
                'school_name' => 'SMA Negeri 1 Digital',
                'npsn' => '10203040',
                'address' => 'Jl. Pendidikan No. 100, Kota Digital',
                'phone' => '(021) 555-0199',
                'email' => 'info@sekolah.digital',
                'website' => 'https://sekolah.digital',
                'established_year' => '1995',
                'accreditation' => 'A (Sangat Baik)',
                'history' => 'SMA Negeri 1 Digital didirikan pada tahun 1995 sebagai sekolah percontohan berorientasi teknologi digital dan karakter mulia. Sejak pendiriannya, sekolah ini secara konsisten menghasilkan lulusan berprestasi tinggi.',
                'vision' => 'Terwujudnya Generasi Cerdas, Berkarakter, Inovatif, dan Unggul dalam Teknologi Informasi.',
                'mission' => [
                    'Menyelenggarakan pendidikan berkualitas tinggi berbasis teknologi informasi.',
                    'Membina karakter peserta didik berbasis nilai moral dan keagamaan.',
                    'Pengembangan bakat dan minat dalam bidang sains, seni, dan olahraga.',
                    'Membangun jejaring kolaborasi dengan perguruan tinggi dan industri teknologi.',
                ],
                'principal_name' => 'Dr. H. Ahmad Dahlan, M.Pd.',
                'principal_photo' => null,
                'principal_greeting' => 'Selamat datang di website resmi Digital School. Kami berkomitmen memberikan layanan pendidikan terbaik yang adaptif terhadap perkembangan zaman dan kebutuhan era digital.',
            ]
        );

        // 4. Categories & Tags
        $catAkademik = Category::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'description' => 'Berita seputar kegiatan pembelajaran dan akademik.',
            'status' => true,
        ]);
        $catPrestasi = Category::create([
            'name' => 'Prestasi',
            'slug' => 'prestasi',
            'description' => 'Capaian dan kebanggaan siswa serta sekolah.',
            'status' => true,
        ]);
        $catKegiatan = Category::create([
            'name' => 'Kegiatan Sekolah',
            'slug' => 'kegiatan-sekolah',
            'description' => 'Dokumentasi kegiatan dan acara sekolah.',
            'status' => true,
        ]);

        $tagSains = Tag::create(['name' => 'Sains', 'slug' => 'sains']);
        $tagDigital = Tag::create(['name' => 'Digital', 'slug' => 'digital']);
        $tagLomba = Tag::create(['name' => 'Lomba', 'slug' => 'lomba']);

        // 5. News
        $news1 = News::create([
            'title' => 'Siswa Digital School Meraih Medali Emas Olimpiade Sains Nasional 2026',
            'slug' => 'siswa-digital-school-meraih-medali-emas-olimpiade-sains-nasional-2026',
            'excerpt' => 'Prestasi gemilang diraih oleh tim Olimpiade Komputer Digital School dalam gelaran OSN 2026.',
            'content' => '<p>Tim olimpiade komputer SMA Digital School berhasil membawa pulang Medali Emas pada gelaran Olimpiade Sains Nasional (OSN) 2026. Keberhasilan ini menambah deretan prestasi gemilang sekolah di tingkat nasional.</p><p>Kepala Sekolah menyampaikan apresiasi setinggi-tingginya kepada para siswa dan guru pembimbing yang telah bekerja keras selama 6 bulan terakhir.</p>',
            'thumbnail' => null,
            'category_id' => $catPrestasi->id,
            'author_id' => $user->id,
            'status' => 'published',
            'published_at' => now(),
            'views_count' => 128,
            'seo_title' => 'Siswa Digital School Juara OSN 2026',
            'seo_description' => 'Berita keberhasilan siswa Digital School meraih medali emas OSN 2026.',
        ]);
        $news1->tags()->sync([$tagSains->id, $tagLomba->id]);

        $news2 = News::create([
            'title' => 'Penerapan Kurikulum Pembelajaran Berbasis AI dan IoT di Tahun Ajaran Baru',
            'slug' => 'penerapan-kurikulum-pembelajaran-berbasis-ai-dan-iot',
            'excerpt' => 'Digital School resmi mengintegrasikan laboratorium AI dan IoT ke dalam kurikulum pembelajaran informatika.',
            'content' => '<p>Menghadapi tantangan teknologi masa depan, Digital School meluncurkan program kurikulum berbasis Artificial Intelligence (AI) dan Internet of Things (IoT) untuk seluruh siswa kelas X dan XI.</p>',
            'thumbnail' => null,
            'category_id' => $catAkademik->id,
            'author_id' => $user->id,
            'status' => 'published',
            'published_at' => now()->subDays(2),
            'views_count' => 95,
        ]);
        $news2->tags()->sync([$tagDigital->id]);

        // 6. Announcements
        Announcement::create([
            'title' => 'Informasi Pelaksanaan Ujian Tengah Semester (UTS) Genap TA 2025/2026',
            'slug' => 'informasi-pelaksanaan-uts-genap-ta-2025-2026',
            'content' => 'Diberitahukan kepada seluruh siswa bahwa Ujian Tengah Semester Genap akan dilaksanakan mulai tanggal 16 Maret 2026. Diharapkan seluruh siswa mempersiapkan kartu ujian dan kelengkapan belajar.',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(12),
            'priority' => 'tinggi',
            'status' => true,
            'published_at' => now(),
        ]);

        Announcement::create([
            'title' => 'Pengumuman Libur Menyambut Hari Raya dan Kegiatan Pesantren Ramadan',
            'slug' => 'pengumuman-libur-menyambut-hari-raya',
            'content' => 'Kegiatan belajar mengajar akan diliburkan mulai tanggal 20 Maret 2026. Kegiatan dilanjutkan dengan Pesantren Ramadan secara hybrid.',
            'start_date' => now()->addDays(15),
            'end_date' => now()->addDays(20),
            'priority' => 'sedang',
            'status' => true,
            'published_at' => now(),
        ]);

        // 7. Agendas
        Agenda::create([
            'title' => 'Seminar Nasional Digital Leadership & Cyber Security for Youth',
            'slug' => 'seminar-nasional-digital-leadership-cyber-security',
            'description' => 'Seminar interaktif menghadirkan pakar keamanan siber nasional untuk memberikan pemahaman mengenai etika dan keamanan di dunia digital.',
            'start_date' => now()->addDays(7)->setHour(8)->setMinute(0),
            'end_date' => now()->addDays(7)->setHour(12)->setMinute(0),
            'location' => 'Aula Utama Digital School',
            'organizer' => 'OSIS & Tim TI Sekolah',
            'status' => true,
        ]);

        Agenda::create([
            'title' => 'Pameran Karya Inovasi Teknologi & Seni Siswa (Digital Expo 2026)',
            'slug' => 'pameran-karya-inovasi-teknologi-seni-siswa-2026',
            'description' => 'Ajang tahunan unjuk karya proyek akhir siswa dalam bidang aplikasi web, robotika, karya seni digital, dan entrepreneurship.',
            'start_date' => now()->addDays(14)->setHour(9)->setMinute(0),
            'end_date' => now()->addDays(15)->setHour(16)->setMinute(0),
            'location' => 'Gedung Olahraga & Exhibition Hall',
            'organizer' => 'Panitia Digital Expo',
            'status' => true,
        ]);

        // 8. Albums & Gallery
        $album1 = Album::create([
            'title' => 'Dokumentasi Upacara HUT Kemerdekaan & Pentas Seni',
            'slug' => 'dokumentasi-upacara-hut-kemerdekaan-pentas-seni',
            'description' => 'Kumpulan foto kemeriahan peringatan hari besar nasional di sekolah.',
            'published_at' => now()->subMonth(),
            'status' => true,
        ]);

        GalleryItem::create([
            'album_id' => $album1->id,
            'media_path' => 'gallery/sample-1.jpg',
            'caption' => 'Pengibaran Bendera Sang Merah Putih oleh Tim Paskibra Sekolah',
            'type' => 'image',
            'sort_order' => 1,
            'status' => true,
        ]);

        // 9. Teacher & Staff
        TeacherStaff::create([
            'name' => 'Dr. H. Ahmad Dahlan, M.Pd.',
            'nip' => '19750812 200003 1 001',
            'position' => 'Kepala Sekolah',
            'subject' => 'Manajemen Pendidikan',
            'bio' => 'Berpengalaman lebih dari 20 tahun memimpin pengembangan sekolah digital berprestasi.',
            'email' => 'kepala@sekolah.digital',
            'category' => 'kepala_sekolah',
            'status' => true,
            'sort_order' => 1,
        ]);

        TeacherStaff::create([
            'name' => 'Siti Nurhaliza, S.T., M.Kom.',
            'nip' => '19880415 201201 2 004',
            'position' => 'Wakil Kepsek Bidang Kurikulum',
            'subject' => 'Informatika & Pemrograman Web',
            'bio' => 'Pengampu mata pelajaran Informatika dan Pembina Tim Olimpiade Komputer.',
            'email' => 'siti.kurikulum@sekolah.digital',
            'category' => 'wakil_kepala_sekolah',
            'status' => true,
            'sort_order' => 2,
        ]);

        TeacherStaff::create([
            'name' => 'Budi Santoso, S.Pd.',
            'nip' => '19920110 201802 1 003',
            'position' => 'Guru Seni & Pembina Ekstrakurikuler',
            'subject' => 'Seni Budaya & Desain Grafis',
            'bio' => 'Pembimbing karya kreativitas dan desain siswa.',
            'email' => 'budi.guru@sekolah.digital',
            'category' => 'guru',
            'status' => true,
            'sort_order' => 3,
        ]);

        // 10. Custom Pages
        Page::create([
            'title' => 'Visi dan Misi',
            'slug' => 'visi-misi',
            'content' => '<h2>Visi Sekolah</h2><p>Terwujudnya Generasi Cerdas, Berkarakter, Inovatif, dan Unggul dalam Teknologi Informasi.</p><h2>Misi Sekolah</h2><ol><li>Menyelenggarakan pendidikan berkualitas tinggi berbasis teknologi informasi.</li><li>Membina karakter peserta didik berbasis nilai moral dan keagamaan.</li><li>Pengembangan bakat dan minat dalam bidang sains, seni, dan olahraga.</li></ol>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Sejarah Sekolah',
            'slug' => 'sejarah',
            'content' => '<h2>Sejarah Pendirian</h2><p>SMA Digital School berdiri sejak tahun 1995 sebagai sekolah pionir dalam memanfaatkan teknologi komunikasi dan informatika dalam proses belajar mengajar.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // 11. Facilities
        \App\Models\Facility::create([
            'name' => 'Laboratorium Komputer & AI Center',
            'slug' => 'laboratorium-komputer-ai-center',
            'description' => 'Laboratorium canggih dengan 40 unit PC spesifikasi tinggi, jaringan internet 1Gbps, dan perangkat pengembangan AI & IoT.',
            'primary_image' => null,
            'available_features' => ['AC 2 PK', 'Internet High Speed 1Gbps', 'Smart Display 75-inch', 'PC Spec Core i7 32GB RAM'],
            'status' => true,
            'sort_order' => 1,
        ]);

        \App\Models\Facility::create([
            'name' => 'Perpustakaan Digital & Ruang Baca Multi-Media',
            'slug' => 'perpustakaan-digital-ruang-baca',
            'description' => 'Perpustakaan modern yang menyediakan ribuan buku fisik dan e-book yang dapat diakses secara daring oleh seluruh siswa.',
            'primary_image' => null,
            'available_features' => ['Katalog Digital', 'Area Quiet Study', 'Akses E-Book Gratis', 'Free WiFi'],
            'status' => true,
            'sort_order' => 2,
        ]);

        // 12. Achievements
        \App\Models\Achievement::create([
            'title' => 'Juara 1 Olimpiade Matematika & Komputer Nasional 2026',
            'slug' => 'juara-1-olimpiade-matematika-komputer-nasional-2026',
            'winner_name' => 'Tim Sains Digital School',
            'level' => 'nasional',
            'year' => '2026',
            'rank' => 'juara_1',
            'category' => 'Akademik & Sains',
            'description' => 'Keberhasilan tim dalam memecahkan algoritma dan pemodelan matematika kompleks pada tingkat nasional.',
            'status' => true,
        ]);

        \App\Models\Achievement::create([
            'title' => 'Juara 2 Lomba Robotika Cerdas Tingkat Provinsi',
            'slug' => 'juara-2-lomba-robotika-cerdas-tingkat-provinsi',
            'winner_name' => 'Muhammad Fikri (Kelas XI MIPA 1)',
            'level' => 'provinsi',
            'year' => '2025',
            'rank' => 'juara_2',
            'category' => 'Teknologi & Robotika',
            'description' => 'Prestasi dalam merancang robot pemadam api otomatis berbasis sensor ultrasonik.',
            'status' => true,
        ]);

        // 13. Documents
        \App\Models\Document::create([
            'title' => 'Kalender Pendidikan TA 2025/2026 Resmi',
            'slug' => 'kalender-pendidikan-ta-2025-2026-resmi',
            'description' => 'Jadwal lengkap kegiatan belajar mengajar, libur sekolah, dan ujian semester.',
            'file_path' => 'dokumen/kalender-pendidikan.pdf',
            'category' => 'Akademik',
            'year' => '2026',
            'file_size' => '1.2 MB',
            'download_count' => 45,
            'status' => true,
            'published_at' => now(),
        ]);

        \App\Models\Document::create([
            'title' => 'Brosur Informasi Penerimaan Murid Baru (PPDB 2026/2027)',
            'slug' => 'brosur-informasi-ppdb-2026-2027',
            'description' => 'Panduan alur pendaftaran, rincian biaya, dan persyaratan berkas pendaftaran.',
            'file_path' => 'dokumen/brosur-ppdb-2026.pdf',
            'category' => 'PPDB / SPMB',
            'year' => '2026',
            'file_size' => '2.5 MB',
            'download_count' => 120,
            'status' => true,
            'published_at' => now(),
        ]);

        // 14. Navigation Menus
        \App\Models\NavigationMenu::create([
            'title' => 'Beranda',
            'url' => '/',
            'sort_order' => 1,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Profil',
            'url' => '/profil',
            'sort_order' => 2,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Berita',
            'url' => '/berita',
            'sort_order' => 3,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Pengumuman',
            'url' => '/pengumuman',
            'sort_order' => 4,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Agenda',
            'url' => '/agenda',
            'sort_order' => 5,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Galeri',
            'url' => '/galeri',
            'sort_order' => 6,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Guru & Staf',
            'url' => '/guru-staf',
            'sort_order' => 7,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Fasilitas',
            'url' => '/fasilitas',
            'sort_order' => 8,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Prestasi',
            'url' => '/prestasi',
            'sort_order' => 9,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Dokumen',
            'url' => '/dokumen',
            'sort_order' => 10,
            'status' => true,
        ]);

        \App\Models\NavigationMenu::create([
            'title' => 'Kontak',
            'url' => '/kontak',
            'sort_order' => 11,
            'status' => true,
        ]);

        // 15. Contact Messages
        \App\Models\ContactMessage::create([
            'name' => 'Budi Gunawan',
            'email' => 'budi.g@gmail.com',
            'subject' => 'Pertanyaan Seputar Pendaftaran Siswa Baru',
            'message' => 'Selamat siang, saya orang tua calon siswa ingin menanyakan perihal syarat khusus pendaftaran kelas unggulan digital.',
            'status' => 'baru',
            'ip_address' => '127.0.0.1',
        ]);

        // 16. Audit Log
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'Inisialisasi Sistem Phase 2',
            'model_type' => 'System',
            'record_id' => '1',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Digital School Installer',
            'changes' => ['status' => 'Phase 2 Initialized'],
        ]);

        // 17. Settings
        \App\Models\Setting::set('maintenance_mode', false, 'system');
        \App\Models\Setting::set('maintenance_message', 'Website Digital School sedang dalam pemeliharaan berkala. Kami akan segera kembali.', 'system');
        \App\Models\Setting::set('social_instagram', 'https://instagram.com/sekolahdigital', 'social');
        \App\Models\Setting::set('social_facebook', 'https://facebook.com/sekolahdigital', 'social');
        \App\Models\Setting::set('social_youtube', 'https://youtube.com/sekolahdigital', 'social');

        // ---- Phase 3 Seeds ----

        // 18. PPDB Setting
        PpdbSetting::create([
            'tahun_ajaran'          => '2027/2028',
            'gelombang'             => 'Gelombang 1',
            'tanggal_mulai'         => '2027-01-02',
            'tanggal_selesai'       => '2027-03-31',
            'persyaratan'           => '<ul><li>Fotokopi Kartu Keluarga</li><li>Fotokopi Akta Kelahiran</li><li>Pas foto 3x4 sebanyak 4 lembar</li><li>Raport kelas 5 dan 6</li><li>Surat keterangan sehat dari dokter</li></ul>',
            'jadwal'                => '<table><tr><th>Kegiatan</th><th>Tanggal</th></tr><tr><td>Pendaftaran Online</td><td>2 Jan – 31 Mar 2027</td></tr><tr><td>Seleksi Berkas</td><td>1 – 5 Apr 2027</td></tr><tr><td>Pengumuman Hasil</td><td>10 Apr 2027</td></tr><tr><td>Daftar Ulang</td><td>11 – 20 Apr 2027</td></tr></table>',
            'biaya'                 => '<p>Uang pangkal: Rp 5.000.000 (dapat diangsur)</p><p>SPP per bulan: Rp 500.000</p><p>Biaya seragam: Rp 800.000</p>',
            'link_pendaftaran'      => 'https://ppdb.sekolah.digital',
            'whatsapp_pendaftaran'  => '6281234567890',
            'email_pendaftaran'     => 'ppdb@sekolah.digital',
            'keterangan'            => '<p>Untuk informasi lebih lanjut, silakan hubungi panitia PPDB melalui WhatsApp atau email yang tersedia.</p>',
            'is_active'             => true,
        ]);

        // 19. Newsletter Subscribers (sample)
        $sampleSubscribers = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@email.com', 'status' => 'aktif', 'sumber' => 'homepage'],
            ['nama' => 'Siti Rahayu',  'email' => 'siti@email.com', 'status' => 'aktif', 'sumber' => 'footer'],
            ['nama' => 'Ahmad Fauzi',  'email' => 'ahmad@email.com', 'status' => 'aktif', 'sumber' => 'ppdb'],
        ];
        foreach ($sampleSubscribers as $s) {
            NewsletterSubscriber::create($s);
        }

        // 20. Audit log Phase 3
        \App\Models\AuditLog::create([
            'user_id'    => $user->id,
            'action'     => 'Inisialisasi Sistem Phase 3',
            'model_type' => 'System',
            'record_id'  => '1',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Digital School Installer',
            'changes'    => ['status' => 'Phase 3 Initialized'],
        ]);
    }
}
