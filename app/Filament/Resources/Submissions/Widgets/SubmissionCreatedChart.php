<?php

namespace App\Filament\Resources\Submissions\Widgets;

use Filament\Widgets\ChartWidget;

class SubmissionCreatedChart extends ChartWidget
{
    protected ?string $heading = 'Submission Created Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
