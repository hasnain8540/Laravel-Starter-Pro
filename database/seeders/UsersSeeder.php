<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::first();

        $user = User::create([
            'first_name'        => 'Super',
            'last_name'         => 'Admin',
            'email'             => 'superadmin@laravel.com',
            'password'          => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);

        $user->roles()->attach($role);

    }
}
