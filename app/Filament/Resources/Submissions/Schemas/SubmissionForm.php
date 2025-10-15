<?php

namespace App\Filament\Resources\Submissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->required(),

                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('note'),

            ]);
    }
}
