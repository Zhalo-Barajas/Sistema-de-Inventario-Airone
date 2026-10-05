<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EventController extends Controller implements HasMiddleware
{
  public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
  {
    return [
      new Middleware(middleware: 'can:admin.event.ajax', only: ['ajax'])
    ];
  }

  public function fetch(Request $request)
  {
    $events = Event::all(); //  Recuperación de todos los eventos creados, 
    return response()->json($events); //Retorno del listado de eventos por medio de un JSON, para complementar la solicitud para los elementos.
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  public function ajax(Request $request)
  {
    $today = Carbon::today()->format('Y-m-d');
    $formatedStart = Carbon::parse($request->start)->format('Y-m-d');
    $formatedEnd = Carbon::parse($request->end)->format('Y-m-d');

    $request->validate([
      'type' => 'required|string|min:3|max:6|in:add,update,delete', //El valor es requerido, además, unicamente puede tener los valores 'add,update y delete'
      'title' => 'required_if:type,add,update|string|max:255', //Esta es requerida si el valor de type es equivalente a add o update.
      'start' => 'required_if:type,add,update|date|after_or_equal:' . $today, //Esta es requerida si el valor de type es equivalente a add o update.
      'end' => 'required_if:type,add,update|date|after_or_equal:start', //Esta es requerida si el valor de type es equivalente a add o update.
    ], [ //Mensajes de error personalizados
      'type.required' => 'El tipo de operación es obligatorio.',
      'type.string' => 'El tipo de operación debe ser una cadena de texto.',
      'type.max' => 'El tipo de operación no debe exceder los 6 caracteres.',
      'type.min' => 'El tipo de operación debe contener más de 3 caracteres.',
      'type.in' => 'Operación ilegal.',
      'title.required_if' => 'El título del evento es obligatorio.',
      'title.string' => 'El título del evento debe ser una cadena de texto.',
      'title.max' => 'El título del evento no debe exceder los 255 caracteres.',
      'start.required_if' => 'La fecha de inicio es obligatoria.',
      'start.date' => 'La fecha de inicio debe ser una fecha válida.',
      'start.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a la fecha actual.',
      'end.required_if' => 'La fecha de finalización es obligatoria.',
      'end.date' => 'La fecha de finalización debe ser una fecha válida.',
      'end.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
    ]);


    switch ($request->type) {
      case 'add': //Si la petición contiene en type el valor "add" se creará un registro nuevo de un evento.
        $event = Event::create([
          'title' => $request->title,
          'start' => $request->start,
          'end' => $request->end,
        ]);
        // Se retornará una respuesta en formato JSON con una variable que posee los datos del registro recién creado.
        return response()->json($event);
        break;
      case 'update':
        //En el caso de que la solicitud AJAX tenga el valor en type 'update se buscará el evento en la base de datos será actualizado de acuerdo a los valores del request.
        $event = Event::findOrFail($request->id)->update([
          'title' => $request->title,
          'start' => $formatedStart,
          'end' => $formatedEnd,
        ]);

        return response()->json($event);
        break;
      case 'delete':
        //Se realiza la busqueda del registro, una vez encontrado se eliminará, en caso contrario dará un error 404
        $event = Event::findOrFail($request->id)->delete();
        // $event = Event::find($request->id)->delete();
        return response()->json($event);
        break;
      default:
        //Y no pasa nada...
        break;
    }
  }
}
