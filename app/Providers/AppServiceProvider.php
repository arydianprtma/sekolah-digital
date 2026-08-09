<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability, $arguments) {
            // Bypass penuh untuk Super Admin atau admin
            if ($user->hasRole('Super Admin') || $user->hasRole('admin')) {
                return true;
            }

            $writeAbilities = [
                'create', 'update', 'delete', 'deleteAny', 
                'forceDelete', 'forceDeleteAny', 'restore', 'restoreAny', 'reorder'
            ];

            if (in_array($ability, $writeAbilities)) {
                if ($user->hasRole('siswa') || $user->hasRole('orang_tua')) {
                    $model = null;
                    if (isset($arguments[0])) {
                        $model = is_string($arguments[0]) ? $arguments[0] : get_class($arguments[0]);
                    }

                    // Pengecualian: Siswa boleh melakukan aksi pada Pengumpulan Tugas (AssignmentSubmission)
                    if ($user->hasRole('siswa') && $model === \App\Models\AssignmentSubmission::class) {
                        return null; // Lanjut ke policy default
                    }

                    // Blokir akses CRUD lainnya untuk Siswa & Orang Tua
                    return false;
                }
            }
        });
    }
}
