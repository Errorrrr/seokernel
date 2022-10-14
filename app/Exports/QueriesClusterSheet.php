<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class QueriesClusterSheet implements FromArray, WithHeadings, WithTitle
{
    use Exportable;

    public function __construct($array, $title)
    {
        $this->array = $array;
        $this->title = $title;
    }

    public function headings(): array
    {
        return [
            'Запрос',
        ];
    }
    public function array(): array
    {
        return $this->array;
    }

    public function title(): string
    {
        return $this->title;
    }

}
