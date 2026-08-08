<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Album;
use App\Models\SchoolProfile;
use App\Models\TeacherStaff;
use App\Models\Facility;
use App\Models\Achievement;
use App\Models\Document;
use App\Models\ContactMessage;
use App\Models\Setting;
use App\Models\PpdbSetting;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PublicController extends Controller
{
    protected function checkMaintenance(): ?InertiaResponse
    {
        if (Setting::get('maintenance_mode', false) && !auth()->check()) {
            return Inertia::render('Maintenance', [
                'message' => Setting::get('maintenance_message', 'Website sedang dalam pemeliharaan berkala.'),
            ]);
        }
        return null;
    }

    public function beranda(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $latestNews = News::with('category')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        $latestAnnouncements = Announcement::where('status', true)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        $upcomingAgendas = Agenda::where('status', true)
            ->where('start_date', '>=', now()->startOfDay())
            ->orderBy('start_date', 'asc')
            ->take(4)
            ->get();

        $principal = TeacherStaff::where('category', 'kepala_sekolah')->first();
        $facilities = Facility::where('status', true)->take(4)->get();
        $achievements = Achievement::where('status', true)->take(4)->get();

        return Inertia::render('Beranda', [
            'latestNews' => $latestNews,
            'latestAnnouncements' => $latestAnnouncements,
            'upcomingAgendas' => $upcomingAgendas,
            'principal' => $principal,
            'facilities' => $facilities,
            'achievements' => $achievements,
        ]);
    }

    public function profil(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $profile = SchoolProfile::first();
        $visiMisiPage = Page::where('slug', 'visi-misi')->first();
        $sejarahPage = Page::where('slug', 'sejarah')->first();

        return Inertia::render('Profil/Index', [
            'profile' => $profile,
            'visiMisi' => $visiMisiPage,
            'sejarah' => $sejarahPage,
        ]);
    }

    public function beritaIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $news = News::with(['category', 'tags'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return Inertia::render('Berita/Index', [
            'news' => $news,
        ]);
    }

    public function beritaShow(string $slug): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $newsItem = News::with(['category', 'tags', 'author'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $newsItem->increment('view_count');

        $relatedNews = News::where('category_id', $newsItem->category_id)
            ->where('id', '!=', $newsItem->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return Inertia::render('Berita/Show', [
            'news' => $newsItem,
            'relatedNews' => $relatedNews,
        ]);
    }

    public function pengumumanIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $announcements = Announcement::where('status', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return Inertia::render('Pengumuman/Index', [
            'announcements' => $announcements,
        ]);
    }

    public function pengumumanShow(string $slug): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $announcement = Announcement::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return Inertia::render('Pengumuman/Show', [
            'announcement' => $announcement,
        ]);
    }

    public function agendaIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $agendas = Agenda::where('status', true)
            ->orderBy('start_date', 'asc')
            ->paginate(9);

        return Inertia::render('Agenda/Index', [
            'agendas' => $agendas,
        ]);
    }

    public function agendaShow(string $slug): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $agenda = Agenda::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return Inertia::render('Agenda/Show', [
            'agenda' => $agenda,
        ]);
    }

    public function galeriIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $albums = Album::with('items')
            ->where('status', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return Inertia::render('Galeri/Index', [
            'albums' => $albums,
        ]);
    }

    public function galeriShow(string $slug): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $album = Album::with('items')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return Inertia::render('Galeri/Show', [
            'album' => $album,
        ]);
    }

    public function guruStaf(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $staffs = TeacherStaff::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return Inertia::render('GuruStaf/Index', [
            'staffs' => $staffs,
        ]);
    }

    public function fasilitasIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $facilities = Facility::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return Inertia::render('Fasilitas/Index', [
            'facilities' => $facilities,
        ]);
    }

    public function fasilitasShow(string $slug): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $facility = Facility::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return Inertia::render('Fasilitas/Show', [
            'facility' => $facility,
        ]);
    }

    public function prestasiIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $achievements = Achievement::where('status', true)
            ->orderBy('year', 'desc')
            ->paginate(9);

        return Inertia::render('Prestasi/Index', [
            'achievements' => $achievements,
        ]);
    }

    public function prestasiShow(string $slug): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $achievement = Achievement::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return Inertia::render('Prestasi/Show', [
            'achievement' => $achievement,
        ]);
    }

    public function dokumenIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $documents = Document::where('status', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return Inertia::render('Dokumen/Index', [
            'documents' => $documents,
        ]);
    }

    public function kontakIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $profile = SchoolProfile::first();
        $socials = [
            'instagram' => Setting::get('social_instagram', ''),
            'facebook' => Setting::get('social_facebook', ''),
            'youtube' => Setting::get('social_youtube', ''),
        ];

        return Inertia::render('Kontak/Index', [
            'profile' => $profile,
            'socials' => $socials,
        ]);
    }

    public function kontakStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Pesan Publik',
            'message' => $validated['message'],
            'status' => 'baru',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim! Terima kasih.');
    }

    public function ppdbIndex(): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $ppdb = PpdbSetting::aktif();

        return Inertia::render('Ppdb/Index', [
            'ppdb' => $ppdb,
        ]);
    }

    public function pencarianIndex(Request $request): InertiaResponse
    {
        if ($m = $this->checkMaintenance()) return $m;

        $keyword = trim($request->query('q', ''));
        $filter  = $request->query('jenis', 'semua');
        $hasil   = [];

        if ($keyword !== '') {
            $search = "%{$keyword}%";

            if (in_array($filter, ['semua', 'berita'])) {
                $berita = News::with('category')
                    ->where('status', 'published')
                    ->where(fn ($q) => $q->where('title', 'like', $search)
                        ->orWhere('excerpt', 'like', $search)
                        ->orWhere('content', 'like', $search))
                    ->orderByDesc('published_at')
                    ->take(10)
                    ->get()
                    ->map(fn ($n) => [
                        'jenis'    => 'Berita',
                        'judul'    => $n->title,
                        'ringkasan'=> $n->excerpt ?? '',
                        'url'      => '/berita/' . $n->slug,
                        'tanggal'  => $n->published_at,
                    ]);
                $hasil = array_merge($hasil, $berita->toArray());
            }

            if (in_array($filter, ['semua', 'halaman'])) {
                $halaman = Page::where('status', 'published')
                    ->where(fn ($q) => $q->where('title', 'like', $search)
                        ->orWhere('content', 'like', $search))
                    ->take(5)
                    ->get()
                    ->map(fn ($p) => [
                        'jenis'    => 'Halaman',
                        'judul'    => $p->title,
                        'ringkasan'=> strip_tags(substr($p->content ?? '', 0, 200)),
                        'url'      => '/halaman/' . $p->slug,
                        'tanggal'  => $p->published_at,
                    ]);
                $hasil = array_merge($hasil, $halaman->toArray());
            }

            if (in_array($filter, ['semua', 'pengumuman'])) {
                $pengumuman = Announcement::where('status', true)
                    ->where(fn ($q) => $q->where('title', 'like', $search)
                        ->orWhere('content', 'like', $search))
                    ->orderByDesc('published_at')
                    ->take(5)
                    ->get()
                    ->map(fn ($a) => [
                        'jenis'    => 'Pengumuman',
                        'judul'    => $a->title,
                        'ringkasan'=> strip_tags(substr($a->content ?? '', 0, 200)),
                        'url'      => '/pengumuman/' . $a->slug,
                        'tanggal'  => $a->published_at,
                    ]);
                $hasil = array_merge($hasil, $pengumuman->toArray());
            }

            if (in_array($filter, ['semua', 'dokumen'])) {
                $dokumen = Document::where('status', true)
                    ->where(fn ($q) => $q->where('title', 'like', $search)
                        ->orWhere('description', 'like', $search))
                    ->orderByDesc('published_at')
                    ->take(5)
                    ->get()
                    ->map(fn ($d) => [
                        'jenis'    => 'Dokumen',
                        'judul'    => $d->title,
                        'ringkasan'=> $d->description ?? '',
                        'url'      => '/dokumen',
                        'tanggal'  => $d->published_at,
                    ]);
                $hasil = array_merge($hasil, $dokumen->toArray());
            }
        }

        // Sort by date descending
        usort($hasil, fn ($a, $b) => strcmp((string)($b['tanggal'] ?? ''), (string)($a['tanggal'] ?? '')));

        return Inertia::render('Pencarian/Index', [
            'keyword' => $keyword,
            'filter'  => $filter,
            'hasil'   => $hasil,
        ]);
    }

    public function newsletterDaftar(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'  => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $validated['email']],
            [
                'nama'   => $validated['nama'] ?? null,
                'status' => 'aktif',
                'sumber' => $request->header('referer') ? 'website' : 'langsung',
            ]
        );

        return redirect()->back()->with('success', 'Terima kasih! Anda telah berlangganan newsletter kami.');
    }
}

