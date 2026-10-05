<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schedule;
use App\Notifications\TelegramNotification;
use App\Models\Category;
use App\Models\Event;
use Carbon\Carbon;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();


//#NOTA: PARA PODER EJECUTAR TAREAS PORGRAMADAS SE DEBE EJECUTAR EL COMANDO "php artisan schedule:work", SE ACTUALIZARÁN LAS TAREAS DE MANERA DINÁMICA#
//En la variable notifications se recuperarán todas las notificaciones por enviar a partir de la fecha actual
$notifications = Event::where('start', ">=", Carbon::today()->toDateString())->get();

foreach ($notifications as $notification) {
    $formatedDate = Carbon::parse($notification->start);
    $notificationDay = $formatedDate->format('d');
    $notificationMonth = $formatedDate->format('m');
    Schedule::call(function () use ($notification) {
        $formatedDateStart = Carbon::parse($notification->start);
        $formatedDateEnd = Carbon::parse($notification->end);
        $daysDifference = $formatedDateStart->diffInDays($formatedDateEnd);
        $year = Carbon::now()->format('Y');
        $notificationYear = $formatedDateStart->format('Y');
        $notifiable = new \stdClass();
        if ($year == $notificationYear) {

            //Este ifi else tiene la función de en base al valor de la variable $daysDifference (Variable con los dias de diferencia entre el inicio y fin de un evento) generar una u otra notificación.
            if ($daysDifference <= 1) {
                //Envio de la notificación al canal de telegram
                Notification::send($notifiable, new TelegramNotification("El evento '" . $notification->title . "' transcurrirá el día de hoy.", "-1002217220233"));
            } else {
                //Generación de variables que almacenan los valores de dias y meses de inicio y fin del envento 
                $startDay = $formatedDateStart->format('d');
                $startMonth = $formatedDateStart->format('m');
                $endDay = $formatedDateEnd->format('d');
                $endMonth = $formatedDateEnd->format('m');
                //Envio de la notificación al canal de telegram
                Notification::send($notifiable, new TelegramNotification("El evento '" . $notification->title . "' transcurrirá del " . $startDay . "/" . $startMonth . " al " . $endDay . "/" . $endMonth . ".", "-1002217220233"));
            }

            //Una vez generada la notificación se eliminará el registro de notificación actual.
            $notification->delete();
        }
        //La notificación será programada a la hora establecida (Hora asignada (11:00 AM)) con el dia y mes asignado por el registro del evento
    })->cron('37 10 ' . $notificationDay . ' ' . $notificationMonth . ' *');
    //   })->cron('00 11 '.$notificationDay.' '.$notificationMonth.' *');

}
