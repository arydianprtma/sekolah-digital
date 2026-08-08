<?php

namespace App\Http\Middleware;

use App\Models\SchoolProfile;
use Illuminate\Http\Request;
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
            if (\Illuminate\Support\Facades\Schema::hasTable('school_profiles')) {
                $schoolProfile = cache()->remember('school_profile', 3600, function () {
                    return SchoolProfile::first();
                });
            }
        } catch (\Throwable $e) {
            $schoolProfile = null;
        }

        return array_merge(parent::share($request), [
            'app_name' => config('app.name', 'Digital School'),
            'school_profile' => $schoolProfile,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
