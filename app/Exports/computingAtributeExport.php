<?php

namespace App\Exports;

use App\Models\computingAtribute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class computingAtributeExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return computingAtribute::all();
    }
       ///Función utilizada con la clase WithHeadings, añade titulos a los atributos de las tablas
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
   
       public function map($computingAtribute): array
       {
           return [
               $computingAtribute->element_id,
               $computingAtribute->brand,
               $computingAtribute->model,
               $computingAtribute->serialNumber,
               $computingAtribute->invNumber,
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
           return 'Atributos_Cómputo';
       }
}
