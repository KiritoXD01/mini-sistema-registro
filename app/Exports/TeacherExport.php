<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeacherExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Teacher::all();
    }

    public function headings(): array
    {
        return [
            'firstname', 'lastname', 'email', 'code', 'created_at'
        ];
    }

    public  function map($row): array
    {
        return [
            $row->firstname,
            $row->lastname,
            $row->email,
            $row->code,
            $row->created_at
        ];
    }
}
