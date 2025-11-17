<?php

namespace App\Listeners;

use App\Mail\WelcomeMessage;
use App\Services\QiscusService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class EmailVerified
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeMessage($event->user));
        app(QiscusService::class)->sendNotification($event->user, 'welcome', bodyParams: [
            $event->user->name,
        ]);
    }
}
