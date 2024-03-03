<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewRegistration;
use App\Notifications\RegistrationAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessRegistrationAttempt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $email)
    {
    }

    public function handle(): void
    {
        $user = User::where('email', $this->email)->first();

        if ($user) {
            $user->notify(new RegistrationAttempt);
        } else {
            Notification::route('mail', $this->email)
                ->notify(new NewRegistration());
        }
    }
}
