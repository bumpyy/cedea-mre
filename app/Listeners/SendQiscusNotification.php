<?php

namespace App\Listeners;

use App\Enum\SubmissionStatusEnum;
use App\Events\SubmissionProcessed;
use App\Services\QiscusService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendQiscusNotification implements ShouldQueue
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
        $type = match ($event->type) {
            SubmissionStatusEnum::ACCEPTED => 'submission_accepted',
            SubmissionStatusEnum::REJECTED => 'submission_rejected',
        };

        try {
            app(QiscusService::class)->sendNotification($event->user, $type, bodyParams: $event->bodyParams);
        } catch (\Exception $e) {
            Log::error(sprintf('Failed to send notification for submission %s', $event->submission->uuid), [
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}
