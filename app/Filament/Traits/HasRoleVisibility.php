<?php

namespace App\Filament\Traits;

trait HasRoleVisibility
{
    /**
     * Roles yang diizinkan mengakses resource ini.
     * Override di setiap resource dengan method getAllowedRoles yang mengembalikan array role.
     * Return array kosong = semua role bisa akses.
     *
     * @return array<string>
     */
    public static function getAllowedRoles(): array
    {
        return property_exists(static::class, 'allowedRoles') ? static::$allowedRoles : [];
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        $roles = static::getAllowedRoles();

        // Super admin (role 'admin' atau tidak punya role = akses semua)
        if (empty($roles)) {
            return true;
        }

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    public static function canCreate(): bool
    {
        // Siswa & orang tua tidak boleh create
        $user = auth()->user();
        if ($user && ($user->hasRole('siswa') || $user->hasRole('orang_tua'))) {
            return false;
        }

        return parent::canCreate();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Siswa & orang tua tidak boleh edit
        $user = auth()->user();
        if ($user && ($user->hasRole('siswa') || $user->hasRole('orang_tua'))) {
            return false;
        }

        return parent::canEdit($record);
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Siswa & orang tua tidak boleh delete
        $user = auth()->user();
        if ($user && ($user->hasRole('siswa') || $user->hasRole('orang_tua'))) {
            return false;
        }

        return parent::canDelete($record);
    }
    
    public static function canDeleteAny(): bool
    {
        $user = auth()->user();
        if ($user && ($user->hasRole('siswa') || $user->hasRole('orang_tua'))) {
            return false;
        }

        return parent::canDeleteAny();
    }
}
