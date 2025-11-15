<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Enum\SubmissionStatusEnum;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Services\QiscusService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Kenepa\ResourceLock\Resources\Pages\Concerns\UsesResourceLock;

class EditSubmission extends EditRecord
{
    use UsesResourceLock;

    protected static string $resource = SubmissionResource::class;

    protected function afterSave(): void
    {
        $record = $this->getRecord();

        switch ($record->status) {
            case SubmissionStatusEnum::ACCEPTED:
                if (! $record->raffle_number) {
                    $record->update([
                        'raffle_number' => generateUniqueRaffleCode(),
                    ]);
                }
                app(QiscusService::class)->sendNotification($record->user, 'submission_accepted');
                break;

            case SubmissionStatusEnum::REJECTED:
                if ($record->raffle_number) {
                    $record->raffle_number = null;
                }
                app(QiscusService::class)->sendNotification($record->user, 'submission_rejected', bodyParams: [
                    'text' => $record->note ?? '-',
                ]);
                break;

            default:
                Log::warning('Error saving submission: ', [
                    'exception' => 'Submission status not found',
                ]);
                break;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
