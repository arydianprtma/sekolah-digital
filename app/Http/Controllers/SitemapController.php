<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Facility;
use App\Models\Achievement;
use App\Models\Document;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            url('/'),
            url('/profil'),
            url('/berita'),
            url('/pengumuman'),
            url('/agenda'),
            url('/galeri'),
            url('/guru-staf'),
            url('/fasilitas'),
            url('/prestasi'),
            url('/dokumen'),
            url('/kontak'),
        ];

        foreach (News::where('status', 'published')->get() as $item) {
            $urls[] = url("/berita/{$item->slug}");
        }

        foreach (Announcement::where('status', true)->get() as $item) {
            $urls[] = url("/pengumuman/{$item->slug}");
        }

        foreach (Agenda::where('status', true)->get() as $item) {
            $urls[] = url("/agenda/{$item->slug}");
        }

        foreach (Facility::where('status', true)->get() as $item) {
            $urls[] = url("/fasilitas/{$item->slug}");
        }

        foreach (Achievement::where('status', true)->get() as $item) {
            $urls[] = url("/prestasi/{$item->slug}");
        }

        foreach (Page::where('status', 'published')->get() as $item) {
            $urls[] = url("/halaman/{$item->slug}");
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemap.org/schemas/sitemap/0.9">';
        foreach ($urls as $u) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($u) . '</loc>';
            $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'text/xml']);
    }
}
