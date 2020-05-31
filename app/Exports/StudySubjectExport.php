<?php

namespace App\Exports;

use App\Models\StudySubject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudySubjectExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return StudySubject::all();
    }

    public function headings(): array
    {
        return [
            'name', 'code'
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->code
        ];
    }
}
