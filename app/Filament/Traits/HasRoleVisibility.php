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

        // Bypass untuk Super Admin
        if ($user->hasRole('Super Admin') || $user->hasRole('admin')) {
            return true;
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
}
