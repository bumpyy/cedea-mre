<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enum\SubmissionStatusEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use SolutionForest\FilamentPanzoom\Components\PanZoom;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([

                PanZoom::make('receipt_image_preview')
                    ->imageUrl(fn ($record) => $record->getFirstMediaUrl('submissions'))
                    ->imageId(fn ($record) => 'receipt-'.$record->id),
                TextInput::make('receipt_number'),
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
                    ->required(),
            ])
            ->columns(1);

    }
}
