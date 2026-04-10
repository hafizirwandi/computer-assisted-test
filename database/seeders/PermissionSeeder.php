<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        // =============================================
        // SEMUA PERMISSION (dari migration)
        // =============================================
        $permissions = [
            'user-list',
            'user-edit',
            'user-delete',
            'user-create',
            'role-list',
            'role-edit',
            'role-delete',
            'role-create',
            'role-add-permission',
            'permission-list',
            'permission-edit',
            'permission-delete',
            'permission-create',
            'sekolah-list',
            'sekolah-edit',
            'sekolah-delete',
            'sekolah-create',
            'matapelajaran-list',
            'matapelajaran-edit',
            'matapelajaran-delete',
            'matapelajaran-create',
            'soal-list',
            'soal-edit',
            'soal-delete',
            'soal-create',
            'butirsoal-list',
            'butirsoal-edit',
            'butirsoal-delete',
            'butirsoal-create',
            'siswa-list',
            'siswa-edit',
            'siswa-delete',
            'siswa-create',
            'siswa-import',
            'p-ujian-list',
            'p-ujian-active',
            'p-ujian-edit',
            'p-ujian-delete',
            'p-ujian-create',
            'reset-ujian-list',
            'reset-ujian-edit',
            'reset-ujian-delete',
            'reset-ujian-create',
            'rekap-nilai',
            'rekap-nilai-kumulatif',
            'rekap-nilai-global',
            'rekap-nilai-global-kumulatif',
            'edit-nilai-siswa',
            'edit-nilai-siswa-global',
            'sinkronisasi-nilai',
            'cek-hasil-sinkronisasi-nilai',
            'eksport-nilai',
            'import-nilai',
            'dokumentasi',
            'ganti-password',
            'pengaturan-sistem',
            'edit-rekap-global',
            'delete-rekap-global',
            'create-rekap-global',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // =============================================
        // ADMIN ONLINE
        // =============================================
        $user = User::firstOrCreate(
            ['username' => 'admin-online'],
            [
                'name' => 'Admin',
                'email' => 'admin-online@cat.com',
                'status' => '1',
                'password' => Hash::make('admin'),
            ],
        );

        $role = Role::firstOrCreate(['name' => 'admin-online']);

        $rpermission = ['user-list', 'user-edit', 'user-delete', 'user-create', 'role-list', 'role-edit', 'role-delete', 'role-create', 'role-add-permission', 'permission-list', 'permission-edit', 'permission-delete', 'permission-create', 'rekap-nilai-global', 'rekap-nilai-global-kumulatif', 'edit-nilai-siswa', 'edit-nilai-siswa-global', 'import-nilai', 'dokumentasi', 'ganti-password', 'pengaturan-sistem'];

        foreach ($rpermission as $r) {
            $role->givePermissionTo($r);
        }

        $user->assignRole([$role->id]);

        // =============================================
        // ADMIN (Lokal / Offline)
        // =============================================
        $user = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@cat.com',
                'status' => '1',
                'password' => Hash::make('admin'),
            ],
        );

        $role = Role::firstOrCreate(['name' => 'admin']);

        $rpermission = ['user-list', 'user-edit', 'user-delete', 'user-create', 'role-list', 'role-edit', 'role-delete', 'role-create', 'role-add-permission', 'permission-list', 'permission-edit', 'permission-delete', 'permission-create', 'matapelajaran-list', 'matapelajaran-edit', 'matapelajaran-delete', 'matapelajaran-create', 'soal-list', 'soal-edit', 'soal-delete', 'soal-create', 'butirsoal-list', 'butirsoal-edit', 'butirsoal-delete', 'butirsoal-create', 'dokumentasi', 'ganti-password', 'pengaturan-sistem'];

        foreach ($rpermission as $r) {
            $role->givePermissionTo($r);
        }

        $user->assignRole([$role->id]);

        // =============================================
        // OPERATOR
        // =============================================
        $user = User::firstOrCreate(
            ['username' => 'operator'],
            [
                'name' => 'Operator',
                'email' => 'operator@cat.com',
                'status' => '1',
                'password' => Hash::make('operator'),
            ],
        );

        $role = Role::firstOrCreate(['name' => 'operator']);

        $rpermission = ['sekolah-list', 'sekolah-edit', 'sekolah-delete', 'sekolah-create', 'siswa-list', 'siswa-edit', 'siswa-delete', 'siswa-create', 'siswa-import', 'p-ujian-list', 'p-ujian-edit', 'p-ujian-delete', 'p-ujian-create', 'p-ujian-active', 'reset-ujian-list', 'reset-ujian-edit', 'reset-ujian-delete', 'reset-ujian-create', 'rekap-nilai', 'rekap-nilai-kumulatif', 'sinkronisasi-nilai', 'cek-hasil-sinkronisasi-nilai', 'eksport-nilai', 'dokumentasi', 'ganti-password'];

        foreach ($rpermission as $r) {
            $role->givePermissionTo($r);
        }

        $user->assignRole([$role->id]);

        // =============================================
        // OPERATOR ONLINE
        // =============================================
        $user = User::firstOrCreate(
            ['username' => 'operator-online'],
            [
                'name' => 'Operator Online',
                'email' => 'operator-online@cat.com',
                'status' => '1',
                'password' => Hash::make('operator'),
            ],
        );

        $role = Role::firstOrCreate(['name' => 'operator-online']);

        $rpermission = ['rekap-nilai-global', 'rekap-nilai-global-kumulatif', 'edit-nilai-siswa', 'edit-nilai-siswa-global', 'import-nilai', 'dokumentasi', 'ganti-password', 'pengaturan-sistem', 'edit-rekap-global', 'delete-rekap-global', 'create-rekap-global'];

        foreach ($rpermission as $r) {
            $role->givePermissionTo($r);
        }

        $user->assignRole([$role->id]);
    }
}
