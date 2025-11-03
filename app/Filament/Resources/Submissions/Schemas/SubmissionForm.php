<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enum\SubmissionStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('receipt_number'),
                Select::make('status')
                    ->options(SubmissionStatusEnum::class)
                    ->required()
                    ->default('pending'),
                TextInput::make('note'),

            ]);
    }
}
