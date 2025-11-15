<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Filament\Resources\Submissions\SubmissionResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListSubmissionActivity extends ListActivities
{
    protected static string $resource = SubmissionResource::class;
}
