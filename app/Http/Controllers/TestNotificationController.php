<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TestNotification;
use App\Customer as Customer;
use App\Models\NotificationMessage;

class TestNotificationController extends Controller
{
    public function pushMessage()
    {
        $msg = NotificationMessage::first();
        $msg->notify((new TestNotification()));
    }
}
