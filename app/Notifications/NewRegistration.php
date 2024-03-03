<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class NewRegistration extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $email = $notifiable->routes['mail'];
        $link = URL::temporarySignedRoute(
            'registration.complete',
            now()->addMinutes(30),
            ['email' => $email]
        );

        return (new MailMessage)
            ->line('Hi! To proceed with your registration, please click the link below.')
            ->action('Complete Registration', $link)
            ->line('If you did not attempt to register, you can safely ignore this email ([or contact us](#)).');
    }
}
