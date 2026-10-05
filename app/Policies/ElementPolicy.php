<?php

namespace App\Policies;

use App\Models\Element;
use App\Models\User;


class ElementPolicy
{
    /**
     * Create a new policy instance.
     */

     //siempre que se crea un metodo aqui se espera minimo 1 parametro

    //En este caso se espera la informacion del usuario autenticado (Recopilada del modelo User en la variable $user) y la informacion del elemento a publicar/actualzar (A partir del MOdelo Element con la variable $element)
    public function author(User $user, Element $element){

        if($user->id == $element->user_id){ //Este if se encarga de comparar el id del usuario con el del post a editar, si son iguales procedera con normalidad el programa, en caso contrario prohibira la acción
            return true; //Este tipode funcion en policy se espera que retorne un valor booleano
        }else{
            return false;
        }

    }

    //IMPORTANTE, LA POLICY EN AUTOMATICO NEGARA cualquier acción si el usuario no esta logeado. 
    //Esta funcion se encarga de verificar si el elemento esta en estado publicado, en caso de que que no lo este, no se podrá acceder

    // El signo de interrogación quiere decir que no negara la accion a pesar de que el usuario no esté loggeado
    // public function published(?User $user, Element $element){

    //     if($element->status == 2){ //Este if se encarga de comparar el id del usuario con el del elemento a editar, si son iguales procedera con normalidad el programa, en caso contrario prohibira la acción
    //         return true; //Este tipo de función en policy se espera que retorne un valor booleano
    //     }else{
    //         return false;
    //     }
    // }



    // public function __construct()
    // {
    //     //
    // }
}
