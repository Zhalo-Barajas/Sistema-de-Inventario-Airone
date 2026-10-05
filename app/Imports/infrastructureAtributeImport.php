<?php

namespace App\Imports;

use App\Models\infrastructureAtribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class infrastructureAtributeImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $furnitureAtribute = new infrastructureAtribute([
            //NOTA Los nombres de las columnas en este apartado de importaciones deben mantenerse en minúscula y sin acentos
            'element_id' => $row['id_elemento'],
            'color' => $row['color'],
            'material' => $row['material'],
            'dimensions' => $row['dimensiones'],
            'quantity' => $row['cantidad'],
        ]);
        $furnitureAtribute->save();
    }

    
    public function rules(): array
    {
        return [
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
            'cantidad'=> ['required','integer','numeric'],
        ];
    }
}
