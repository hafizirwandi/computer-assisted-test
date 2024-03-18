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
    ];
    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@programsekolah.com',
            'password' => Hash::make('admin')
        ]);
        $role = Role::create(['name' => 'admin']);

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
        Role::where('name', 'admin')->delete();
    }
};
