<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enum\StoreEnum;
use App\Enum\SubmissionStatusEnum;
use App\Models\Submission;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use SolutionForest\FilamentPanzoom\Components\PanZoom;

class SubmissionForm
{
    /**
     * Checks if there is already a submission with the same store name and receipt number.
     */
    private static function submissionExists(
        Submission $record,
        StoreEnum|string|null $storeName,
        ?string $receiptNumber
    ): void {
        if (Submission::where('store_name', $storeName)
            ->where('receipt_number', $receiptNumber)
            ->where('id', '<>', $record->id)
            ->exists()) {
            Notification::make()
                ->danger()
                ->color(Color::Red)
                ->title('Duplicate receipt number & store name')
                ->send();
        }
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                PanZoom::make('receipt_image_preview')
                    ->imageUrl(fn ($record) => $record->getFirstMediaUrl('submissions'))
                    ->imageId(fn ($record) => 'receipt-'.$record->id),
                \Schmeits\FilamentCharacterCounter\Forms\Components\TextInput::make('receipt_number')
                    ->unique()
                    ->characterLimit(190)
                    ->required(fn (Get $get): bool => $get('status') == SubmissionStatusEnum::ACCEPTED)
                    ->live()
                    ->afterStateUpdated(
                        function (Get $get, ?string $state, $record) {
                            SubmissionForm::submissionExists($record, $get('store_name'), $state);
                        }
                    ),
                Select::make('store_name')
                    ->options(StoreEnum::class)
                    ->default(StoreEnum::INDOMARET->value)
                    ->live()
                    ->afterStateUpdated(
                        function (Get $get, ?StoreEnum $state, $record) {
                            SubmissionForm::submissionExists($record, $state, $get('receipt_number'));
                        }
                    )
                    ->required(fn (Get $get): bool => $get('status') == SubmissionStatusEnum::ACCEPTED),
                // ->selectablePlaceholder(false),
                RadioDeck::make('status')
                    ->options(SubmissionStatusEnum::class)
                    ->icons([
                        SubmissionStatusEnum::PENDING->value => SubmissionStatusEnum::PENDING->getIcon(),
                        SubmissionStatusEnum::ACCEPTED->value => SubmissionStatusEnum::ACCEPTED->getIcon(),
                        SubmissionStatusEnum::REJECTED->value => SubmissionStatusEnum::REJECTED->getIcon(),
                    ])
                    ->descriptions([
                        SubmissionStatusEnum::PENDING->value => SubmissionStatusEnum::PENDING->getDescription(),
                        SubmissionStatusEnum::ACCEPTED->value => SubmissionStatusEnum::ACCEPTED->getDescription(),
                        SubmissionStatusEnum::REJECTED->value => SubmissionStatusEnum::REJECTED->getDescription(),
                    ])
                    ->colors([
                        SubmissionStatusEnum::PENDING->value => SubmissionStatusEnum::PENDING->getColor(),
                        SubmissionStatusEnum::ACCEPTED->value => SubmissionStatusEnum::ACCEPTED->getColor(),
                        SubmissionStatusEnum::REJECTED->value => SubmissionStatusEnum::REJECTED->getColor(),
                    ])
                    ->live()
                    ->required(),
                \Schmeits\FilamentCharacterCounter\Forms\Components\TextInput::make('note')
                    ->characterLimit(190),
            ])
            ->columns(1);

    }
}
