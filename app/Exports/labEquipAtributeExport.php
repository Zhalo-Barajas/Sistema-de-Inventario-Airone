<?php

namespace App\Exports;

use App\Models\labEquipAtribute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class labEquipAtributeExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return labEquipAtribute::all();
    }

    public function headings(): array
    {
        return [
            'ID_Elemento',
            'Marca',
            'Modelo',
            'Número_de_Serie',
            'Número_de_Inventario',
        ];
    }
 
    
    public function map($labEquipAtribute): array
    {
        return [
            $labEquipAtribute->element_id,
            $labEquipAtribute->brand,
            $labEquipAtribute->model,
            $labEquipAtribute->serialNumber,
            $labEquipAtribute->invNumber,
            
        ];
    }

    public function styles(Worksheet $sheet){
            //Texto en negritas en la primera fila.
            $sheet->getStyle('1')->getFont()->setBold(true);
    }

    //Función utilizada por clase WithTitle, agrega un titulo a la hoja de excel con estos datos.
    public function title(): string
    {
        return 'Atributos_Equipo_Laboratorio';
    }
}
