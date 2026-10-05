<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElementRequest extends FormRequest //Aqui se hace llamada a la clase ElementRequest en conjunto a FormRequest, es decir nuestra petición enviada desde el formulario.
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if($this->user_id == auth()->user()->id){ //Este if se encarga de verificar que lo que se manda en el formulario sea efectivamente del usuario que lo creo, evitando de esta manera que un usuario envie un formulario con la id de otro usuario
        //     // de esta manera se evita que un usuario loggeado realice solicitudes con las credenciales de otro usuario.
        //     return true; //Cambio a true
        // }else{
        //     return false;
        // }
        
        return true;
        //Este return se encarga de autorizar al usuario de realizar la transacción o no, un valor true lo permite, un valor false No.

        //SUGERENCIA: AGREGAR IF CON EL CUÁL PERMITA COMPROBAR SI EL USUARIO TIENE PRIVILEGIOS DE ADMIN PARA REALIZAR LA ACCIÓN

    }


    public function messages()
    {
        $messages = [
            'nameElement.required' => 'El nombre del elemento es obligatorio.',
            'nameElement.string' => 'El nombre del elemento debe ser una cadena de texto.',
            'nameElement.min' => 'El nombre del elemento debe tener al menos 3 caracteres.',
            'nameElement.max' => 'El nombre del elemento no puede tener más de 50 caracteres.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.string' => 'El slug debe ser una cadena de texto.',
            'slug.unique' => 'El slug debe ser único en la tabla de elementos.',
            'statusInv.required' => 'El estado del inventario es obligatorio.',
            'statusInv.in' => 'El estado del inventario debe ser Alta o Baja.',
            'file.image' => 'El archivo debe ser una imagen.',
            'file.required' => 'El archivo es obligatorio.',
            'category_id.required' => 'La categoría es obligatoria.',
            'fund_id.required' => 'El fondo es obligatorio.',
            'ubication_id.required' => 'La ubicación es obligatoria.',
            'building_id.required' => 'El edificio es obligatorio.',
            'tags.required' => 'Las etiquetas son obligatorias.',
            'description.required' => 'La descripción es obligatoria.',
            'description.max' => 'La descripción no puede tener más de 2500 caracteres.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'adquisitionDate.required' => 'La fecha de adquisición es obligatoria.',
            'adquisitionDate.date' => 'La fecha de adquisición debe ser una fecha válida.',
            'maintenanceDate.required' => 'La fecha de mantenimiento es obligatoria.',
            'maintenanceDate.date' => 'La fecha de mantenimiento debe ser una fecha válida.',
            'maintenanceDate.after_or_equal' => 'La fecha de mantenimiento debe ser igual o posterior a la fecha de adquisición.',
            'brand.string' => 'La marca debe ser una cadena de texto.',
            'brand.max' => 'La marca no puede tener más de 255 caracteres.',
            'model.string' => 'El modelo debe ser una cadena de texto.',
            'model.max' => 'El modelo no puede tener más de 255 caracteres.',
            'serialNumber.string' => 'El número de serie debe ser una cadena de texto.',
            'serialNumber.max' => 'El número de serie no puede tener más de 255 caracteres.',
            'invNumber.string' => 'El número de inventario debe ser una cadena de texto.',
            'invNumber.max' => 'El número de inventario no puede tener más de 255 caracteres.',
            'color.string' => 'El color debe ser una cadena de texto.',
            'color.max' => 'El color no puede tener más de 255 caracteres.',
            'material.string' => 'El material debe ser una cadena de texto.',
            'material.max' => 'El material no puede tener más de 255 caracteres.',
            'dimensions.string' => 'Las dimensiones deben ser una cadena de texto.',
            'dimensions.max' => 'Las dimensiones no pueden tener más de 255 caracteres.',
            'shelves.integer' => 'El número de estantes debe ser un número entero.',
            'shelves.numeric' => 'El número de estantes debe ser un valor numérico.',
            'shelves.max' => 'El número de estantes no puede ser mayor a 50.',
            'doors.integer' => 'El número de puertas debe ser un número entero.',
            'doors.numeric' => 'El número de puertas debe ser un valor numérico.',
            'doors.max' => 'El número de puertas no puede ser mayor a 50.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.numeric' => 'La cantidad debe ser un valor numérico.',
            'quantity.max' => 'La cantidad no puede ser mayor a 50000.',
            'typeExt.string' => 'El tipo de extintor debe ser una cadena de texto.',
            'typeExt.max' => 'El tipo de extintor no puede tener más de 255 caracteres.',
            'capacity.required_unless' => 'La capacidad es obligatoria a menos que el tipo de extintor sea N/A.',
            'capacity.integer' => 'La capacidad debe ser un número entero.',
            'capacity.numeric' => 'La capacidad debe ser un valor numérico.',
            'capacity.max' => 'La capacidad no puede ser mayor a 50000.',
        ];

        return $messages;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $element = $this->route()->parameter('element');
        $rules = [ //Este arreglo contiene las reglas a evaluar para la petición 
            'nameElement' => 'required|string|min:3|max:50', //Este campo es obligatorio
            'slug' => 'required|string|unique:elements', //Este campo es obligatorio, su valor debe se unico en la tabla elements
            'statusInv' => 'required|in:1,2', //Este campo es obligatorio, su valor unicamente puede ser 1 o 2
            'file' => 'image|required', //Regla de validación para el archivo enviado (Solicita que el archivo recibido sea una imagen), ademas de que el campo es obligatorio.
            'category_id' => 'required',
            'fund_id' => 'required',
            'ubication_id' => 'required',
            'building_id' => 'required',
            'tags' => 'required',
            'description' => 'required|max:2500|string',
            'adquisitionDate' => 'required|date',
            'maintenanceDate' => 'required|date|after_or_equal:adquisitionDate', //Lógica para evitar generar elementos con fechas de mantenimiento menores que la fecha de creación
        ];

        
        //Switch que detecta si un elemento pertenece a una categoria con atributos adicioanles, en caso de que pertenezca a este estrato se añadirán las respectivas validaciones
        switch ($this->category_id){
            case "1":
                $rules = array_merge($rules, [
                    'brand' => 'nullable|string|max:255',
                    'model'	 => 'nullable|string|max:255',
                    'serialNumber'	 => 'nullable|string|max:255',
                    'invNumber'  => 'nullable|string|max:255',
                ]);
                break;
            case "2":
                $rules = array_merge($rules, [
                    'serialNumber'	 => 'nullable|string|max:255',
                    'invNumber'  => 'nullable|string|max:255',
                    'color' => 'nullable|string|max:255',
                    'material' => 'nullable|string|max:255',
                    'dimensions' => 'nullable|string|max:255',
                    'shelves' => 'integer|numeric|max:50',
                    'doors' => 'integer|numeric|max:50',
                ]);
                break;
            case "3":
                $rules = array_merge($rules, [
                    'color' => 'nullable|string|max:255',
                    'material' => 'nullable|string|max:255',
                    'dimensions' => 'nullable|string|max:255',
                    'quantity' => 'integer|numeric|max:50000',
                ]);
                break;
            case "4":
                $rules = array_merge($rules, [
                    'brand' => 'nullable|string|max:255',
                    'model'	 => 'nullable|string|max:255',
                    'serialNumber'	 => 'nullable|string|max:255',
                    'invNumber'  => 'nullable|string|max:255',
                ]);
                break;
            case "5":
                $rules = array_merge($rules, [
                    'brand' => 'nullable|string|max:255',
                    'model'	 => 'nullable|string|max:255',
                    'serialNumber'	 => 'nullable|string|max:255',
                    'invNumber'  => 'nullable|string|max:255',
                ]);
                break;
            case "6":
                $rules = array_merge($rules, [
                    'brand' => 'nullable|string|max:255',
                    'model'	 => 'nullable|string|max:255',
                    'invNumber'  => 'nullable|string|max:255',
                    'typeExt' => 'nullable|string|max:255', //Esta es requerida si el valor de type es equivalente a add o update.
                    'capacity' => 'required_unless:typeExt,N/A|integer|numeric|max:50000',
                ]);
                break;
            
        }
        // if($this->category_id == 1){
        //     $rules = array_merge($rules, [
        //         'brand' => 'nullable|string|max:255',
        //         'model'	 => 'nullable|string|max:255',
        //         'serialNumber'	 => 'nullable|string|max:255',
        //         'invNumber'  => 'nullable|string|max:255',
        //     ]);
        // }
        // $rulesComputerAtributes = [
            
        //     // 'brand' => 'string|max:255',
        //     // 'model'	 => 'string|max:255',
        //     // 'serialNumber'	 => 'string|max:255',
        //     // 'invNumber'  => 'string|max:255',
        //     'color'  => 'string|max:255',
        //     'material'  => 'string|max:255',
        //     'dimensions'  => 'string|max:255',
        //     // 'typeExt'  => 'string|max:255',


        //     // 'capacity'  => 'integer|numeric|max:40',
        //     // 'shelves'  => 'integer|numeric|max:50',
        //     // 'doors'  => 'integer|numeric|max:50',
        //     'quantity'  => 'integer|numeric|max:50000',

        // ];

        if($element){ //Con este if reconocerá el formulario que se esta editando y evitara enviar una id null si accedieramos al formulario en crear
            $rules['slug'] = 'required|unique:elements,slug,'.$element->id; 
        }
        

        return $rules;
    }
}
