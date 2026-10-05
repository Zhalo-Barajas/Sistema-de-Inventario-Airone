<?php

namespace App\Exports;

use App\Models\secEquipAtribute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class secEquipAtributeExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return secEquipAtribute::all();
    }
    
    public function headings(): array
    {
        return [
            'ID_Elemento',
            'Marca',
            'Modelo',
            'Tipo_Extintor',
            'Capacidad',
            'Número_de_Inventario',
        ];
    }
 
    
    public function map($secEquipAtribute): array
    {
        return [
            $secEquipAtribute->element_id,
            $secEquipAtribute->brand,
            $secEquipAtribute->model,
            $secEquipAtribute->typeExt,
            $secEquipAtribute->capacity,
            $secEquipAtribute->invNumber,
        ];
    }

    public function styles(Worksheet $sheet){
            //Texto en negritas en la primera fila.
            $sheet->getStyle('1')->getFont()->setBold(true);
    }

    //Función utilizada por clase WithTitle, agrega un titulo a la hoja de excel con estos datos.
    public function title(): string
    {
        return 'Atributos_Equipo_Seguridad';
    }
}
