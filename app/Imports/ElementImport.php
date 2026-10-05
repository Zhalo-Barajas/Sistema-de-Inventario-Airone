<?php

namespace App\Imports;

use App\Models\Element;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Str;
//Al invocar WithHeadingRows  se señala la página de excel contiene una fila con los nombres de los atributos.
class ElementImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        //NOTA: Esta función actúa como un foreach dentro de las entradas del archivo de excel importado.
        // dd($row); //Esta función actua de depurador, retorna el valor de la variable (o en este caso la file que se esta procesando en ese momento.)
        $element = new Element([
            //NOTA Los nombres de las columnas en este apartado de importaciones deben mantenerse en minúscula y sin acentos
            'nameElement' => $row['nombre_elemento'],
            'slug'    => '-', //Slug provisional, imediatamente será reemplazado.
            'statusInv' => $row['status_de_inventario'],
            'adquisitionDate' => Carbon::instance(Date::excelToDateTimeObject($row['fecha_de_adquisicion'])),
            'maintenanceDate' => Carbon::instance(Date::excelToDateTimeObject($row['fecha_de_mantenimiento'])),
            'description' => $row['descripcion'],
            'ubication_id' => $row['id_ubicacion'],
            'category_id' => $row['id_categoria'],
            'user_id' => $row['id_usuario'],
            'fund_id' => $row['id_fondo'],
            'building_id' => $row['id_edificio'],
            // otros campos necesarios
            
        ]);
        //Se aplica una metodologia similar a la del controlador de elementos, se guardan los valores del elemento para generar una ID de elemento para seguidamente modificar el Slug y añadirlo.
        $element->save();

        /*Clase invocada por medio de use Illuminate\Support\Str;, contiene utilidades para strings, en ese caso se invoca para realizar una conversión del
         nombre del elemento a un slug, una vez calculado el slug se anidará con un "-" seguido de la ID del elemento. */
        $element->slug = Str::slug($element->nameElement)."-".$element->id;
        
        // $element->slug = ($element->slug)."-".$element->id;
        $element->save();

        return $element;


        //Método antiguo para mgenerar registros.
        // return new Element([
        //    'nameElement' => $row['nombre_elemento'], 
        //    'slug'    => $row['slug'], 
        //    'statusInv' => $row['status_de_inventario'],
        //    'adquisitionDate' => Carbon::instance(Date::excelToDateTimeObject($row['fecha_de_adquisicion'])),
        //    'maintenanceDate' => Carbon::instance(Date::excelToDateTimeObject($row['fecha_de_mantenimiento'])),
        //    'description' => $row['descripcion'],
        //    'ubication_id' => $row['id_ubicacion'],
        //    'category_id' => $row['id_categoria'],
        //    'user_id' => $row['id_usuario'],
        //    'fund_id' => $row['id_fondo'],
        //    'building_id' => $row['id_edificio'],
        // ]);
    }
    
    //Apartado donde se añadirán las reglas de validación para los elementos.
    public function rules(): array
    {
        return [
            'nombre_elemento'=> ['required','string','min:3','max:500'],
            'status_de_inventario' => ['required','in:1,2','numeric'],
            'fecha_de_adquisicion'=> ['required','integer','numeric'], //añadida validación de fecha, sino generará excepciones incapturables
            'fecha_de_mantenimiento'=> ['required','integer','numeric'],
            'descripcion'=> ['required','string','max:2500'],
            'id_ubicacion'=> ['required','integer','numeric'],
            'id_categoria'=> ['required','integer','numeric'],
            'id_usuario'=> ['required','integer','numeric'],
            'id_fondo'=> ['required','integer','numeric'],
            'id_edificio'=> ['required','integer','numeric'],
        
        ];
    }

}