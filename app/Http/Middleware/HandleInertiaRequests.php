<?php

namespace App\Http\Middleware;

use App\Models\SchoolProfile;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $schoolProfile = null;
        try {
            if (Schema::hasTable('school_profiles')) {
                $schoolProfile = cache()->remember('school_profile', 3600, function () {
                    return SchoolProfile::first();
                });
            }
        } catch (\Throwable $e) {
            $schoolProfile = null;
        }

        $settings = cache()->remember('site_settings', 3600, function () {
            if (!Schema::hasTable('settings')) return [];
            return [
                'maintenance_mode'    => Setting::get('maintenance_mode', false),
                'maintenance_message' => Setting::get('maintenance_message', 'Website sedang dalam pemeliharaan.'),
                'social_instagram'    => Setting::get('social_instagram', ''),
                'social_facebook'     => Setting::get('social_facebook', ''),
                'social_youtube'      => Setting::get('social_youtube', ''),
                'seo_title'           => Setting::get('seo_title', config('app.name')),
                'seo_description'     => Setting::get('seo_description', ''),
            ];
        });

        return array_merge(parent::share($request), [
            'app_name'       => config('app.name', 'Digital School'),
            'school_profile' => $schoolProfile,
            'settings'       => $settings,
            'flash'          => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
