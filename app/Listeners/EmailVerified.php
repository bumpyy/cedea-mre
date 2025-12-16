<?php

namespace App\Listeners;

use App\Mail\WelcomeMessage;
use App\Services\QiscusService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailVerified implements ShouldQueue
{
    public $tries = 3;

    public $backoff = 60;

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
        try {
            Mail::to($event->user->email)->send(new WelcomeMessage($event->user));
            // app(QiscusService::class)->sendNotification($event->user, 'welcome', bodyParams: [
            //     $event->user->name,
            // ]);
        } catch (\Throwable $e) {
            Log::error(sprintf('Failed to send welcome message to user %s', $event->user->email), [
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}
