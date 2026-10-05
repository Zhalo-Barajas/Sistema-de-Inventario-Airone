<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{
    use Queueable;

    //definición de variables protegidas que almacenarán los valores del constructor
    protected $message;
    protected $chatId;

    public function __construct($message, $chatId)
    {
        //Método contructor que realiza set and get para recopilar el mensaje e ID del chat
        $this->message = $message;
        $this->chatId = $chatId;
    }

    public function via($notifiable) //La función via especifica que la notificación debe ser enviada a través del canal de Telegram.

    {
        /*Aquí se devuelve un arreglo con TelegramChannel::class, indicando que la notificación
         debe ser enviada a través del canal de Telegram. */
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        /*Este método construye el mensaje de Telegram. */
        return TelegramMessage::create()
            ->to($this->chatId) // El ID del chat del grupo
            ->content($this->message); // El contenido del mensaje
    }
}