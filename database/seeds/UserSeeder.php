<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
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
            'name'              => "Usuario Admin",
            'email'             => "admin@admin.com",
            'email_verified_at' => Carbon::now(),
            'password'          => bcrypt('password'), // password
            'remember_token'    => Str::random(10),
        ]);

        UserLogin::create([
            'user_id' => $user->id
        ]);

        $role = Role::pluck('name')->all();

        $user->assignRole($role);
    }
}
