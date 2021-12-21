<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_file = file_get_contents(__DIR__.'/permission.json');
        $permission_json = json_decode($permission_file, true);
        if($permission_json) {
            foreach ($permission_json as $permission) {
                $permission = Permission::create([
                    'name'          => $permission,
                    'guard_name'    => 'web'
                ]);
            }
        }

        $roles = Role::where('id', 1)->get();
        $permissions = Permission::get()->pluck('id');
        if(!$roles->isEmpty()) {
            foreach ($roles as $role) {
                $role->syncPermissions($permissions);
            }
        }
    }
}
