<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FailedRowsExport implements FromCollection, WithHeadings
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array
    {
        return ['name', 'email', 'age', 'errors'];
    }
}
