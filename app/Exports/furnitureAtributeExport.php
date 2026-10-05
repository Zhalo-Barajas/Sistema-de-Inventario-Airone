<?php

namespace App\Exports;

use App\Models\furnitureAtribute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

//El Concern WithStrictNullComparison se encarga de exportar los valores equivalentes a 0 como 0 y no un espacio en blanco dentrol del excel exportado.

class furnitureAtributeExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return furnitureAtribute::all();
    }

    public function headings(): array
       {
           return [
               'ID_Elemento',
               'Color',
               'Material',
               'Dimensiones',
               'Número_Estantes',
               'Puertas',
               'Número_de_Serie',
               'Número_de_Inventario',
           ];
       }
    
       
       public function map($furnitureAtribute): array
       {
           return [
               $furnitureAtribute->element_id,
               $furnitureAtribute->color,
               $furnitureAtribute->material,
               $furnitureAtribute->dimensions,
               $furnitureAtribute->shelves,
               $furnitureAtribute->doors,
               $furnitureAtribute->serialNumber,
               $furnitureAtribute->invNumber,
               // Excluyendo atributos no deseados
           ];
       }
   
       public function styles(Worksheet $sheet){
               //Texto en negritas en la primera fila.
               $sheet->getStyle('1')->getFont()->setBold(true);
       }
       //Función utilizada por clase WithTitle, agrega un titulo a la hoja de excel con estos datos.
       public function title(): string
       {
           return 'Atributos_Inmobiliario';
       }
}
