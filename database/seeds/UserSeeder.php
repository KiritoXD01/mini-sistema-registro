<?php

use Illuminate\Database\Seeder;
use App\Models\UserLogin;
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
        $user = factory('App\Models\User')->create();

        UserLogin::create([
            'user_id' => $user->id
        ]);

        $role = Role::pluck('name')->all();

        $user->assignRole($role);
    }
}
