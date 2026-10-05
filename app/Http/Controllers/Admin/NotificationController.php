<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Support\Facades\Notification;


class NotificationController extends Controller implements HasMiddleware
{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de un metodo constructor)
    {
        //Middleware para comprobar si un usuario puede acceder o no a la vista función de este controlador.
        return [
            new Middleware(middleware: 'can:admin.notifications.index', only: ['index','send']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
        ];

    }
    public function index(){
       
        // $user = User::find($request->user_id); // Encuentra al usuario por ID
        return view('admin.notifications.index');

    }

    public function send(Request $request){

        //Recupera de la petición el ID del Chat del grupo y el mensaje que mandará el BOT.
        $chatId = $request->chat_id; // ID del chat del grupo
        //Recuperación de variable con datos del usuario.
        $user = Auth::user();

        //Generación del mensaje final que se enviará al grupo.
        $message = "El usuario ".$user->name." ha enviado la siguiente notificación: ". $request->message;
        //Se crea una instancia de stdClass, que es una clase genérica en PHP. Los objetos de tipo stdClass son simples y no tienen métodos ni propiedades predeterminadas.
        // Se crea el objeto genérico para actuar como el destinatario de la notificación
        $notifiable = new \stdClass();
        // return $message;

        // Se define el método send para devolver el chat ID del grupo (El atributo send contiene esa función)
        $notifiable->send = function() use ($chatId) {
            return $chatId;
        };
        

        // Envía la notificación usando el sistema de notificaciones de Laravel
        Notification::send($notifiable, new TelegramNotification($message, $chatId));
        //Redirección a la página de notificacones con mensaje de éxito.
        return redirect()->route('admin.notifications.index')->with('info', 'La notificación fue enviada con éxito.');    
    }
}
