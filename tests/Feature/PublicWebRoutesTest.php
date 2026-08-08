<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_beranda_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_profil_page_returns_successful_response(): void
    {
        $response = $this->get('/profil');
        $response->assertStatus(200);
    }

    public function test_berita_index_page_returns_successful_response(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
    }

    public function test_pengumuman_index_page_returns_successful_response(): void
    {
        $response = $this->get('/pengumuman');
        $response->assertStatus(200);
    }

    public function test_agenda_index_page_returns_successful_response(): void
    {
        $response = $this->get('/agenda');
        $response->assertStatus(200);
    }

    public function test_galeri_index_page_returns_successful_response(): void
    {
        $response = $this->get('/galeri');
        $response->assertStatus(200);
    }

    public function test_guru_staf_page_returns_successful_response(): void
    {
        $response = $this->get('/guru-staf');
        $response->assertStatus(200);
    }

    public function test_fasilitas_index_page_returns_successful_response(): void
    {
        $response = $this->get('/fasilitas');
        $response->assertStatus(200);
    }

    public function test_prestasi_index_page_returns_successful_response(): void
    {
        $response = $this->get('/prestasi');
        $response->assertStatus(200);
    }

    public function test_dokumen_index_page_returns_successful_response(): void
    {
        $response = $this->get('/dokumen');
        $response->assertStatus(200);
    }

    public function test_kontak_index_page_returns_successful_response(): void
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }

    public function test_sitemap_returns_xml_response(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }
}
