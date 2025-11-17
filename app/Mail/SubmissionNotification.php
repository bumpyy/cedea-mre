<?php

namespace App\Mail;

use App\Enum\SubmissionStatusEnum;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Submission $submission, public User $user, public SubmissionStatusEnum $status) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        switch ($this->status) {
            case SubmissionStatusEnum::ACCEPTED:
                $subject = "CEDEA RTE - Submission {$this->submission->id} diterima";
                break;
            case SubmissionStatusEnum::REJECTED:
                $subject = "CEDEA RTE - Submission {$this->submission->id} ditolak";
                break;
            default:
                $subject = "CEDEA RTE - Submission {$this->submission->id} diproses";
                break;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        switch ($this->status) {
            case SubmissionStatusEnum::ACCEPTED:
                return new Content(view: 'mail.submission-accepted');
                break;
            case SubmissionStatusEnum::REJECTED:
                return new Content(view: 'mail.submission-rejected');
                break;
            default:
                return new Content(view: 'mail.submission-rejected');
                break;
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
