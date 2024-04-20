<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    private $permissions = [
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
    ];

    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //Super Admin
        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@cat.com',
            'status' => '1',
            'password' => Hash::make('admin')
        ]);
        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        //Operator
        $user = User::create([
            'name' => 'Operator',
            'username' => 'operator',
            'email' => 'operator@cat.com',
            'status' => '1',
            'password' => Hash::make('operator')
        ]);
        $role = Role::create(['name' => 'operator']);
        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::whereIn('name', $this->permissions)->delete();
        Role::whereIn('name', ['admin', 'operator'])->delete();
        User::whereIn('name', ['Admin', 'Operator'])->delete();
    }
};
