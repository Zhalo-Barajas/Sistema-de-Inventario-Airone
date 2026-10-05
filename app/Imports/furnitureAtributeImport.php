<?php

namespace App\Imports;

use App\Models\furnitureAtribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class furnitureAtributeImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $furnitureAtribute = new furnitureAtribute([
            //NOTA Los nombres de las columnas en este apartado de importaciones deben mantenerse en minúscula y sin acentos

            'element_id' => $row['id_elemento'],
            'color' => $row['color'],
            'material' => $row['material'],
            'dimensions' => $row['dimensiones'],
            'shelves' => $row['numero_estantes'],
            'doors' => $row['puertas'],
            'serialNumber' => (string) $row['numero_de_serie'], // (string) Actua de casting para la entrada, la convierte a una entrada de tipo string.
            'invNumber' => $row['numero_de_inventario'],
            
        ]);
        $furnitureAtribute->save();
    }

    
    public function rules(): array
    {
        return [
            //Reglas de validación
            'id_elemento'=> ['required','integer','numeric',
                             'unique:computing_atributes,element_id',
                             'unique:furniture_atributes,element_id',
                             'unique:infrastructure_atributes,element_id',
                             'unique:lab_equip_atributes,element_id',
                             'unique:machinery_atributes,element_id',
                             'unique:sec_equip_atributes,element_id',
                             'exists:elements,id'],
            'color' => ['required','string','max:255'],
            'material'=> ['required','string','max:255'],
            'dimensiones' => ['required','string','max:255'],
            'numero_estantes'=> ['required','integer','numeric'],
            'puertas'=> ['required','integer','numeric'],
            'numero_de_serie'=> ['required','max:255'],
            'numero_de_inventario'=> ['required','max:255'],
        ];
    }
}
