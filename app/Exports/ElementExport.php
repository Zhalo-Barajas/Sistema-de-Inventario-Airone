<?php

namespace App\Exports;

use App\Models\Element;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


/*Los implements consisten de los siguiente:
FromCollection: Se recopilarán los atributos de un modelo.
WithHeadings: Cada columna con propiedades tendra un titulo especificado en la función headings().
WithTitle: Esta le otorga un nombre a la página de excel actual mediante la función title(). 
WithMapping: Esta se encarga de recopilar solo los atributos solicitado en la función map (Utilizado para excluir datos como created_at o updated_at)
ShouldAutoSize: Se encarga de desplazar automaticamente cada columna para desplegar completamente cada atributo, no tiene una función.
WithColumnWIDths: Con esta nos encargamos de darle un ancho especifico a las columnas/filas, seraliza esta acción mediante la función columnWIDths()
WithStyles: Con este podemos aplicarles estilos a las columnas y filas de la pagina del documento, a travéz de la función styles(Worksheet $sheet)
*/


class ElementExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Element::all();
    }

    ///Función utilizada con la clase WithHeadings, añade titulos a los atributos de las tablas
    public function headings(): array
    {
        return [
            'Nombre_Elemento',
            'Status_de_Inventario',
            'Fecha_de_Adquisición',
            'Fecha_de_Mantenimiento',
            'Descripción',
            'ID_Ubicación',
            'ID_Categoria',
            'ID_Usuario',
            'ID_Fondo',
            'ID_Edificio'
        ];
    }

    public function map($element): array
    {
        return [
            $element->nameElement,
            $element->statusInv,
            Carbon::parse($element->adquisitionDate)->format('d/m/Y'),
            Carbon::parse($element->maintenanceDate)->format('d/m/Y'),
            $element->description,
            $element->ubication_id,
            $element->category_id,
            $element->user_id,
            $element->fund_id,
            $element->building_id,
            // Excluyendo atributos no deseados
        ];
    }

    public function columnWIDths(): array{
        return[
            'A'=>35,
            'E'=>80,
        ];
    }
    
    public function styles(Worksheet $sheet){
            //Texto en negritas en la primera fila.
            $sheet->getStyle('1')->getFont()->setBold(true);

            //'E1:E'.$sheet->getHighestRow() Quiere decir que se aplicará el estilo en la columna E1 hasta la ultima de esa columna. Insertado Wraptext para que desplace hacia abajo el texto y no desborde.
            $sheet->getStyle('E1:E'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
            $sheet->getStyle('A1:A'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
            // $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }
    //Función utilizada por clase WithTitle, agrega un titulo a la hoja de excel con estos datos.
    public function title(): string
    {
        return 'Elementos';
    }
}
