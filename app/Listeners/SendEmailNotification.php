<?php

namespace App\Listeners;

use App\Events\SubmissionProcessed;
use App\Mail\SubmissionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
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
    public function handle(SubmissionProcessed $event): void
    {
        try {
            Mail::to($event->user->email)->send(new SubmissionNotification($event->submission, $event->user, $event->type));
        } catch (\Throwable $e) {
            Log::error(sprintf('Failed to send mail notification for submission %s', $event->submission->uuid), [
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}
