<?php

namespace App\Imports;

use App\Models\furnitureAtribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DatabaseImportStep1 implements WithMultipleSheets
{
    //Este archivo será el encargado de invocar todas las hojas que contenga el documento de importación.
    public function sheets(): array
    {
        return [
            'Elementos' => new ElementImport(),
        ];
    }
}
