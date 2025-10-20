<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enum\SubmissionStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use SolutionForest\FilamentPanzoom\Components\PanZoom;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                PanZoom::make('image_preview')
                    ->imageUrl(fn ($record) => $record?->getFirstMediaUrl('submissions')),
                TextInput::make('receipt_number')
                    ->required(),
                Select::make('status')
                    ->options(SubmissionStatusEnum::class)
                    ->required()
                    ->default('pending'),
                TextInput::make('note'),

            ]);
    }
}
