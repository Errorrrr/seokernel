<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DoublesExport implements FromArray
{
    use Exportable;

    public function __construct($array)
    {
        $this->array = $array;
    }

    public function array(): array
    {
        return $this->array;
    }
}
