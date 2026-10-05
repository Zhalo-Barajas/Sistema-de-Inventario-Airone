<?php

namespace App\Imports;

use App\Models\computingAtribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class computingAtributeImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $string = strval($row['numero_de_serie']);
        // dd($row); Depuración de la variable $row
        $computingAtribute = new computingAtribute([
            //NOTA Los nombres de las columnas en este apartado de importaciones deben mantenerse en minúscula y sin acentos

            'element_id' => $row['id_elemento'],
            'brand' => $row['marca'],
            'model' => $row['modelo'],
            'serialNumber' => settype($row['numero_de_serie'], 'string'),
            'invNumber' => $row['numero_de_inventario'],
            // otros campos necesarios
            
        ]);
        //Se aplica una metodologia similar a la del controlador de elementos, se guardan los valores del elemento para generar una ID de elemento para seguidamente modificar el Slug y añadirlo.
        $computingAtribute->save();
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
            'numero_de_serie'=> ['required','max:255'],
            'numero_de_inventario'=> ['required','max:255'],
        ];
    }
}
