<?php

namespace App\Filament\Resources\Winners\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WinnerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('submission_id')
                    ->numeric(),
                TextEntry::make('prize'),
                TextEntry::make('status'),
                TextEntry::make('note')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
