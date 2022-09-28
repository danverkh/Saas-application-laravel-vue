<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\WelcomeEmailWithCredentials;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailWithCredentials
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        Mail::send(
            new WelcomeEmailWithCredentials($event->user, $event->password)
        );
    }
}
