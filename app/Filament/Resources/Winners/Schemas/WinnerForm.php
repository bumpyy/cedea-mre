<?php

namespace App\Filament\Resources\Winners\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WinnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('submission_id')
                    ->required()
                    ->numeric(),
                TextInput::make('prize')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('note'),
            ]);
    }
}
