<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QueriesClusterExport implements WithMultipleSheets
{
    use Exportable;

    private $arrayMinuses;
    private $arrayQueries;

    public function __construct($arrayQueries, $arrayMinuses)
    {
        $this->arrayQueries = $arrayQueries;
        $this->arrayMinuses = $arrayMinuses;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[0] = new QueriesClusterSheet($this->arrayQueries, 'Запросы');
        $sheets[1] = new QueriesClusterSheet($this->arrayMinuses , 'Не подходит');

        return $sheets;
    }
}
