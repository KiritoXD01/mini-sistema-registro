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
            "user-show",
            "user-edit",
            "user-delete",

            //roles page
            "role-list",
            "role-create",
            "role-show",
            "role-edit",
            "role-delete",

            //teachers pages
            "teacher-list",
            "teacher-create",
            "teacher-show",
            "teacher-edit",
            "teacher-delete",

            // students pages
            "student-list",
            "student-create",
            "student-show",
            "student-edit",
            "student-delete",

            //courses pages
            "course-list",
            "course-create",
            "course-show",
            "course-edit",
            "course-delete",

            //study subject pages
            "study-subject-list",
            "study-subject-create",
            "study-subject-show",
            "study-subject-edit",
            "study-subject-delete"
        ];

        /**
         * Create each permission in Database if it doesn't exists
         */
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }
}
