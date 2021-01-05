<?php

namespace App\Channels;

use NotificationChannels\ExpoPushNotifications\ExpoChannel;

class CustomExpoChannel extends ExpoChannel {
    
     /**
     * Get the interest name for the notifiable.
     *
     * @param $notifiable
     *
     * @return string
     */
    public function interestName($notifiable)
    {
        return $notifiable->getKey();
    }
}