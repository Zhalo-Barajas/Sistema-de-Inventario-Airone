<?php

namespace App\Exports;

use App\Models\Element;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class DatabaseExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[0] = new ElementExport();
        $sheets[1] = new computingAtributeExport();
        $sheets[2] = new furnitureAtributeExport();
        $sheets[3] = new infrastructureAtributeExport();
        $sheets[4] = new labEquipAtributeExport();
        $sheets[5] = new machineryAtributeExport();
        $sheets[6] = new secEquipAtributeExport();
        return $sheets;
    }
}
