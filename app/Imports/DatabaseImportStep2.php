<?php

namespace App\Imports;

use App\Models\furnitureAtribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DatabaseImportStep2 implements WithMultipleSheets
{
    //Este archivo será el encargado de invocar todas las hojas que contenga el documento de importación.
    public function sheets(): array
    {
        return [
            'Atributos_Cómputo' => new computingAtributeImport(),
            'Atributos_Inmobiliario' => new furnitureAtributeImport(),
            'Atributos_Infraestructura' => new infrastructureAtributeImport(),
            'Atributos_Equipo_Laboratorio' => new labEquipAtributeImport(),
            'Atributos_Maquinaria' => new machineryAtributeImport(),
            'Atributos_Equipo_Seguridad' => new secEquipAtributeImport(),
        ];
    }
}
