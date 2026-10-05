<?php

namespace App\Observers;

use App\Models\Element;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ElementObserver
{
    /**
     * Handle the Element "created" event.
     */
         //Se pueden observar los distintos eventos que se van a activar cada que realiza una acciónm con el modelo Element.
    //Se elminaron todas las funciones no utilizadas
    public function creating(Element $element): void
    {
        //

        //Fue agregada esta regla para evitar que haya conflicto al momento de usar seeders
        if(! App::runningInConsole()){ //Con este if se menciona que: si no se esta corriendo en una consola el registro de esa creación del ID grabara el id del usuario verificado
            $element->user_id = auth()->user()->id;
        }
       
        //Verificación encargada 
    }


    // /**
    //  * Handle the Element "updated" event.
    //  */
    // public function updated(Element $element): void
    // {
    //     //
    // }

    //IMPORTANTE, SI QUEREMOS QUE SE EJECUTE NUESTRO OBSERVER DESPUES DE QUE SE HAYA FINALIZADO LA EJECUCION DE NUESTRO FUNCION PRINCIPAL USAR LA FUNCION DELETED (O EQUIVALENTE "*ED")


    public function deleting(Element $element): void
    {
        //
        if($element->image){ //Si el Element contiene una imagen eliminará la imagen
            Storage::delete($element->image->url);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
        }
   }
}
