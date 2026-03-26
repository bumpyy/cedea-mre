<?php

namespace App\Filament\Resources\SubmissionAreas\Pages;

use App\Filament\Resources\SubmissionAreas\SubmissionAreaResource;
use Filament\Resources\Pages\EditRecord;

class EditSubmissionArea extends EditRecord
{
    protected static string $resource = SubmissionAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();

        if (! $record->processed_at) {
            $record->update([
                'admin_area_processed_at' => now(),
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
