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
use InvalidArgumentException;

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
                $subject = "CEDEA RTE - Submission {$this->submission->uuid} diterima";
                break;
            case SubmissionStatusEnum::REJECTED:
                $subject = "CEDEA RTE - Submission {$this->submission->uuid} ditolak";
                break;
            default:
                $subject = "CEDEA RTE - Submission {$this->submission->uuid} diproses";
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
        return match ($this->status) {
            SubmissionStatusEnum::ACCEPTED => new Content(view: 'mail.submission-accepted'),
            SubmissionStatusEnum::REJECTED => new Content(view: 'mail.submission-rejected'),
            default => throw new InvalidArgumentException('Invalid submission status'),
        };

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
