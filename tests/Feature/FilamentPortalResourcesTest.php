<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentPortalResourcesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);

        $user = User::factory()->create([
            'email' => 'admin@sekolah.digital',
        ]);
        $user->assignRole('Super Admin');

        $this->actingAs($user);
    }

    public function test_portal_dashboard_returns_successful_response(): void
    {
        $response = $this->get('/portal');
        $response->assertStatus(200);
    }

    public function test_portal_categories_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/categories');
        $response->assertStatus(200);
    }

    public function test_portal_tags_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/tags');
        $response->assertStatus(200);
    }

    public function test_portal_news_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/news');
        $response->assertStatus(200);
    }

    public function test_portal_pages_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/pages');
        $response->assertStatus(200);
    }

    public function test_portal_announcements_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/announcements');
        $response->assertStatus(200);
    }

    public function test_portal_agendas_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/agendas');
        $response->assertStatus(200);
    }

    public function test_portal_albums_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/albums');
        $response->assertStatus(200);
    }

    public function test_portal_school_profiles_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/school-profiles');
        $response->assertStatus(200);
    }

    public function test_portal_teacher_staffs_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/teacher-staff');
        $response->assertStatus(200);
    }

    public function test_portal_users_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/users');
        $response->assertStatus(200);
    }

    public function test_portal_facilities_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/facilities');
        $response->assertStatus(200);
    }

    public function test_portal_achievements_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/achievements');
        $response->assertStatus(200);
    }

    public function test_portal_documents_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/documents');
        $response->assertStatus(200);
    }

    public function test_portal_navigation_menus_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/navigation-menus');
        $response->assertStatus(200);
    }

    public function test_portal_contact_messages_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/contact-messages');
        $response->assertStatus(200);
    }

    public function test_portal_audit_logs_resource_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/audit-logs');
        $response->assertStatus(200);
    }

    public function test_portal_manage_settings_page_returns_successful_response(): void
    {
        $response = $this->get('/portal/manage-settings');
        $response->assertStatus(200);
    }
}
