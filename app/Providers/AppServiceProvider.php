<?php

namespace App\Providers;

use App\Observers\AuditLogObserver;
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
                    if ($user->hasRole('siswa') && ltrim($model, '\\') === 'App\\Models\\AssignmentSubmission') {
                        if ($ability === 'create') {
                            return true;
                        }

                        if (isset($arguments[0]) && is_object($arguments[0])) {
                            $studentId = \App\Models\Student::where('user_id', $user->id)->value('id');
                            return $arguments[0]->student_id === $studentId;
                        }

                        return true;
                    }

                    // Pengecualian untuk Relation Manager: Siswa boleh menambah submission ke Assignment
                    if ($user->hasRole('siswa') && ltrim($model, '\\') === 'App\\Models\\Assignment') {
                        if (in_array($ability, ['addAssignmentSubmission', 'createAssignmentSubmission'])) {
                            return true;
                        }
                    }

                    // Blokir akses CRUD lainnya untuk Siswa & Orang Tua
                    return false;
                }
            }
        });

        // Register AuditLog Observer pada semua model penting
        $modelsToObserve = [
            \App\Models\News::class,
            \App\Models\Announcement::class,
            \App\Models\Agenda::class,
            \App\Models\Album::class,
            \App\Models\Achievement::class,
            \App\Models\Document::class,
            \App\Models\Facility::class,
            \App\Models\LibraryBook::class,
            \App\Models\LearningMaterial::class,
            \App\Models\TeacherStaff::class,
            \App\Models\SchoolProfile::class,
            \App\Models\Student::class,
            \App\Models\User::class,
            \App\Models\Assignment::class,
            \App\Models\AssignmentSubmission::class,
            \App\Models\Grade::class,
            \App\Models\Schedule::class,
            \App\Models\Page::class,
        ];

        foreach ($modelsToObserve as $model) {
            $model::observe(AuditLogObserver::class);
        }
    }
}
