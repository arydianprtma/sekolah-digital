<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role-role yang dibutuhkan
        $roles = ['admin', 'guru', 'siswa', 'orang_tua'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Buat user admin default jika belum ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name'     => 'Administrator Sekolah',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles(['admin']);

        // Buat akun guru demo
        $guru = User::firstOrCreate(
            ['email' => 'guru@sekolah.sch.id'],
            [
                'name'     => 'Budi Santoso, S.Pd.',
                'password' => Hash::make('password'),
            ]
        );
        $guru->syncRoles(['guru']);

        // Buat akun siswa demo
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@sekolah.sch.id'],
            [
                'name'     => 'Ahmad Fauzi',
                'password' => Hash::make('password'),
            ]
        );
        $siswa->syncRoles(['siswa']);

        // Buat akun orang tua demo
        $ortu = User::firstOrCreate(
            ['email' => 'ortu@sekolah.sch.id'],
            [
                'name'     => 'Siti Rahayu',
                'password' => Hash::make('password'),
            ]
        );
        $ortu->syncRoles(['orang_tua']);

        $this->command->info('✓ Role dan user demo berhasil dibuat');
        $this->command->table(
            ['Email', 'Role', 'Password'],
            [
                ['admin@sekolah.sch.id', 'admin', 'password'],
                ['guru@sekolah.sch.id', 'guru', 'password'],
                ['siswa@sekolah.sch.id', 'siswa', 'password'],
                ['ortu@sekolah.sch.id', 'orang_tua', 'password'],
            ]
        );
    }
}
