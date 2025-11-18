<?php

namespace App\Listeners;

use App\Mail\WelcomeMessage;
use App\Services\QiscusService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PhoneVerifiedListener implements ShouldQueue
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
    public function handle(PhoneVerifiedListener $event): void
    {
        try {
            // Mail::to($event->user->email)->send(new WelcomeMessage($event->user));
            app(QiscusService::class)->sendNotification($event->user, 'welcome', bodyParams: [
                $event->user->name,
            ]);
        } catch (\Exception $e) {
            Log::error(sprintf('Failed to send welcome message to user %s', $event->user->phone), [
                'exception' => $e,
            ]);
        }
    }
}
