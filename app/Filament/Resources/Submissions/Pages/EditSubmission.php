<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Enum\SubmissionStatusEnum;
use App\Events\SubmissionProcessed;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Models\Submission;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Log;
use Kenepa\ResourceLock\Resources\Pages\Concerns\UsesResourceLock;

class EditSubmission extends EditRecord
{
    use UsesResourceLock;

    protected static string $resource = SubmissionResource::class;

    private function submissionExists(): bool
    {
        if ($this->data['status'] == SubmissionStatusEnum::ACCEPTED->value && (! empty($this->data['store_name']) && ! empty($this->data['receipt_number']))) {
            return Submission::where('store_name', $this->data['store_name'])
                ->where('receipt_number', $this->data['receipt_number'])
                ->where('id', '<>', $this->getRecord()->id)
                ->exists();
        }

        return false;
    }

    protected function beforeValidate(): void
    {
        if ($this->submissionExists()) {
            Notification::make()
                ->danger()
                ->color(Color::Red)
                ->title('Duplicate receipt number && store name')
                ->send();

            $this->halt();

            return;

        }
    }

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
                    do {
                        $raf_code = generateUniqueCode();
                    } while (Submission::where('raffle_number', $raf_code)->exists());

                    $record->update([
                        'raffle_number' => $raf_code,
                    ]);
                }

                event(new SubmissionProcessed(
                    $record,
                    $record->user, SubmissionStatusEnum::ACCEPTED, bodyParams: [
                        $record->uuid,
                        $record->raffle_number,
                    ]
                ));
                break;

            case SubmissionStatusEnum::REJECTED:

                event(new SubmissionProcessed(
                    $record,
                    $record->user, SubmissionStatusEnum::REJECTED, bodyParams: [
                        $record->uuid,
                        $record->note ?? '-',
                    ]
                ));

                break;
            case SubmissionStatusEnum::PENDING:

                break;
            default:
                Log::warning('Error saving submission: ', [
                    'exception' => 'Submission status not found',
                ]);
                break;
        }
    }

    protected function getSaveFormAction(): Action
    {
        $hasFormWrapper = $this->hasFormWrapper();

        return Action::make('save')
            ->label($this->submissionExists() ? 'Submission sudah ada' : __('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->disabled($this->submissionExists())
            ->submit($hasFormWrapper ? $this->getSubmitFormLivewireMethodName() : null)
            ->action($hasFormWrapper ? null : $this->getSubmitFormLivewireMethodName())
            ->keyBindings([])
            ->requiresConfirmation();
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
