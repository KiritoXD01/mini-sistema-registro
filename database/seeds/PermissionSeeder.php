<?php

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
        // Permission list
        $permissions = [
            //users page
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",

            //roles page
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",

            //teachers pages
            "teacher-list",
            "teacher-create",
            "teacher-edit",
            "teacher-delete",

            // students pages
            "student-list",
            "student-create",
            "student-edit",
            "student-delete"
        ];

        /**
         * Create each permission in Database if it doesn't exists
         */
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        //Assign all the permissions to the ADMIN user role
        Role::first()->syncPermissions($permissions);
    }
}
