<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationAttempt extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("Hi {$notifiable->name},")
            ->line('We noticed an attempt to register an account with your email address.')
            ->line('If this was you, [you can reset your email here]('.route('password.request').').')
            ->line('If this was not you, [please contact us immediately]().');
    }
}
