<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'                  => 'Kamran Najafzade',
            'email'                 => 'nadjafzadeh@gmail.com',
            'email_verified_at'     => date('Y-m-d H:i:s'),
            'password'              => Hash::make('12345678'),
        ]);

        if($user) {
            $roles =  Role::get()->pluck('id');
            if($roles) {
                $user->assignRole($roles);
            }
        }
    }
}
