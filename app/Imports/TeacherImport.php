<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class TeacherImport implements ToModel
{
    public function model(array $row)
    {
        return new Teacher([
            'firstname'  => $row[0],
            'lastname'   => $row[1],
            'email'      => $row[2],
            'password'   => bcrypt($row[3]),
            'code'       => $this->generateCode(6),
            'created_by' => Auth::user()->id
        ]);
    }

    private function generateCode($length = 20)
    {
        $characters = '1234567890abcdefghijklmnpqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
