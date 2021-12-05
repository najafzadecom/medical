<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name'          => 'Administrator',
            'guard_name'    => 'web'
        ]);

        $role = Role::create([
            'name'          => 'Manager',
            'guard_name'    => 'web'
        ]);

        $role = Role::create([
            'name'          => 'Laboperator',
            'guard_name'    => 'web'
        ]);

        $role = Role::create([
            'name'          => 'Registrator',
            'guard_name'    => 'web'
        ]);
    }
}
