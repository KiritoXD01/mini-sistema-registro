<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => bcrypt($row[2])
        ]);

        $user->assignRole($row[3]);

        return $user;
    }
}
