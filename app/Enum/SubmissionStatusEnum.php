<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SubmissionStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::ACCEPTED => 'success',
            self::REJECTED => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-question-mark-circle',
            self::ACCEPTED => 'heroicon-m-check-circle',
            self::REJECTED => 'heroicon-m-x-circle',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::PENDING => 'Submission kamu sedang direview oleh tim kami',
            self::ACCEPTED => 'Submission kamu telah diverifikasi oleh tim kami',
            self::REJECTED => 'Submission kamu ditolak oleh tim kami',
        };
    }
}
