<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Enum\SubmissionStatusEnum;
use App\Events\SubmissionProcessed;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Mail\SubmissionNotification;
use App\Services\QiscusService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kenepa\ResourceLock\Resources\Pages\Concerns\UsesResourceLock;

class EditSubmission extends EditRecord
{
    use UsesResourceLock;

    protected static string $resource = SubmissionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['status'] !== SubmissionStatusEnum::ACCEPTED) {
            $data['receipt_number'] = null;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();

        switch ($record->status) {
            case SubmissionStatusEnum::ACCEPTED:
                if (! $record->raffle_number) {
                    $record->update([
                        'raffle_number' => generateUniqueCode(),
                    ]);
                }

                // Mail::to($record->user->email)->send(new SubmissionNotification($record, $record->user, SubmissionStatusEnum::ACCEPTED));
                // app(QiscusService::class)->sendNotification($record->user, 'submission_accepted', bodyParams: [
                //     $record->uuid,
                //     $record->raffle_number,
                // ]);
                event(new SubmissionProcessed(
                    $record,
                    $record->user, SubmissionStatusEnum::ACCEPTED, bodyParams: [
                        $record->uuid,
                        $record->raffle_number,
                    ]
                ));
                break;

            case SubmissionStatusEnum::REJECTED:
                if ($record->raffle_number) {
                    $record->raffle_number = null;
                }

                // Mail::to($record->user->email)->send(new SubmissionNotification($record, $record->user, SubmissionStatusEnum::REJECTED));
                // app(QiscusService::class)->sendNotification($record->user, 'submission_rejected', bodyParams: [
                //     $record->uuid,
                //     $record->note ?? '-',
                // ]);

                event(new SubmissionProcessed(
                    $record,
                    $record->user, SubmissionStatusEnum::REJECTED, bodyParams: [
                        $record->uuid,
                        $record->note ?? '-',
                    ]
                ));

                break;

            default:
                Log::warning('Error saving submission: ', [
                    'exception' => 'Submission status not found',
                ]);
                break;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
