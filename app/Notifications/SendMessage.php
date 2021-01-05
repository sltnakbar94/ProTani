<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;
use Illuminate\Notifications\Notification;

class SendMessage extends Notification implements ShouldQueue
{
    use Queueable;
    
    public function __construct()
    {
        $this->delay = now()->addSeconds(3);
    }

    public function via($notifiable)
    {
        return [ExpoChannel::class];
    }

    public function toExpoPush($notifiable)
    {
        return ExpoMessage::create()
            ->badge(1)
            ->enableSound()
            ->title($notifiable->title)
            ->body($notifiable->body)
            ->setJsonData(json_decode($notifiable->data, true));
    }
}
