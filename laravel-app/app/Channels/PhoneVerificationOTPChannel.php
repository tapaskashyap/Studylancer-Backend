<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class PhoneVerificationOTPChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toSms($notifiable);
    }
}