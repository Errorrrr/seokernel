<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QueriesExport implements FromArray, WithHeadings
{
    use Exportable;

    public function __construct($array)
    {
        $this->array = $array;
    }

    public function headings(): array
    {
        return [
            'Запрос',
            'Wordstat',
            'Слов',
            'Wordstat!',
        ];
    }
    public function array(): array
    {
        return $this->array;
    }
}
