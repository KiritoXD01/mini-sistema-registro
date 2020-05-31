<?php

namespace App\Imports;

use App\Models\StudySubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class StudySubjectImport implements ToModel
{
    public function model(array $row)
    {
        return new StudySubject([
            'name' => $row[0],
            'code' => strtoupper(Str::slug($row[1])),
            'created_by' => Auth::user()->id
        ]);
    }
}
