<?php

namespace App\Listeners;

use App\Enum\SubmissionStatusEnum;
use App\Events\SubmissionProcessed;
use App\Mail\SubmissionNotification;
use App\Services\QiscusService;
use Illuminate\Support\Facades\Mail;

class SendNotification
{
    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 3;

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

        Mail::to($event->user->email)->send(new SubmissionNotification($event->submission, $event->user, $event->type));
        app(QiscusService::class)->sendNotification($event->user, $type, bodyParams: $event->bodyParams);
    }
}
