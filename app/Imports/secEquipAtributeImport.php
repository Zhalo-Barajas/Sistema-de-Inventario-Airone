<?php

namespace App\Imports;

use App\Models\secEquipAtribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class secEquipAtributeImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $element = new secEquipAtribute([
            //NOTA Los nombres de las columnas en este apartado de importaciones deben mantenerse en minúscula y sin acentos

            'element_id' => $row['id_elemento'],
            'brand' => $row['marca'],
            'model' => $row['modelo'],
            'typeExt' => $row['tipo_extintor'],
            'capacity' => $row['capacidad'],
            // otros campos necesarios
            
        ]);
        //Se aplica una metodologia similar a la del controlador de elementos, se guardan los valores del elemento para generar una ID de elemento para seguidamente modificar el Slug y añadirlo.
        $element->save();
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
            'marca' => ['required','string','max:255'],
            'modelo'=> ['required','string','max:255'],
            'tipo_extintor'=> ['required','string','max:255'],
            'capacidad'=>  ['required','integer','numeric'],
        ];
    }
}
