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

        // Case-insensitive role check for Super Admin and admin
        $userRoleNames = $user->roles->pluck('name')->map(fn($name) => strtolower($name))->toArray();
        if (in_array('super admin', $userRoleNames) || in_array('admin', $userRoleNames)) {
            return true;
        }

        $roles = static::getAllowedRoles();

        // Super admin (role 'admin' atau tidak punya role = akses semua)
        if (empty($roles)) {
            return true;
        }

        // Case-insensitive role matching
        $userRoleNames = $user->roles->pluck('name')->map(fn($name) => strtolower($name))->toArray();
        $allowedRolesLower = array_map('strtolower', $roles);

        foreach ($allowedRolesLower as $role) {
            if (in_array($role, $userRoleNames)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Siswa dan Orang Tua tidak diizinkan membuat data secara default (kecuali di-override).
     */
    public static function canCreate(): bool
    {
        $user = auth()->user();
        if ($user) {
            $userRoleNames = $user->roles->pluck('name')->map(fn($name) => strtolower($name))->toArray();
            if (in_array('siswa', $userRoleNames) || in_array('orang_tua', $userRoleNames)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Siswa dan Orang Tua tidak diizinkan mengubah data secara default.
     */
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = auth()->user();
        if ($user) {
            $userRoleNames = $user->roles->pluck('name')->map(fn($name) => strtolower($name))->toArray();
            if (in_array('siswa', $userRoleNames) || in_array('orang_tua', $userRoleNames)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Siswa dan Orang Tua tidak diizinkan menghapus data secara default.
     */
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = auth()->user();
        if ($user) {
            $userRoleNames = $user->roles->pluck('name')->map(fn($name) => strtolower($name))->toArray();
            if (in_array('siswa', $userRoleNames) || in_array('orang_tua', $userRoleNames)) {
                return false;
            }
        }
        
        return true;
    }
}
