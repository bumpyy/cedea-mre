<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Enum\SubmissionStatusEnum;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Mail\SubmissionNotification;
use App\Models\Submission;
use Beta\Microsoft\Graph\Model\Alignment;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewSubmission extends ViewRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
            EditAction::make()
                // ->visible(fn (Submission $record) => $record->status !== SubmissionStatusEnum::PENDING)
                ->requiresConfirmation(fn (Submission $record) => $record->status !== SubmissionStatusEnum::PENDING)
                ->modalIcon('heroicon-o-exclamation-triangle')
                ->modalHeading('Edit Submission')
                ->modalDescription('Apakan anda yakin ingin mengedit submission ini?')
                ->modalSubmitActionLabel('Tetap edit')
                ->modalFooterActionsAlignment(Alignment::CENTER)
                ->modalAlignment(Alignment::CENTER)
                ->modalWidth('lg')
                ->after(function (EditAction $action, Submission $record) {
                    Mail::to($record->user->email)->send(new SubmissionNotification($record, $record->user));
                }),
        ];
    }
}
