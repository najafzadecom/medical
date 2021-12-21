<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            ExperimentSeeder::class,
            PackageSeeder::class,
            CountrySeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
