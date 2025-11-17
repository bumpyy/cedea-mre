<?php

namespace App\Exports\Sheets;

use App\Enum\SubmissionStatusEnum;
use App\Models\Submission;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class StatusSheet implements FromQuery, WithTitle
{
    private $status;

    public function __construct(SubmissionStatusEnum $status)
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Submission::query()
            ->where('status', $this->status);
    }

    public function title(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status->value));
    }
}
