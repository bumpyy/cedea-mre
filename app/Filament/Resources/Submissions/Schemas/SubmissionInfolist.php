<?php

namespace App\Filament\Resources\Submissions\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('receipt_number'),
                SpatieMediaLibraryImageEntry::make('receipt_image')
                    ->collection('submissions'),
                TextEntry::make('user.name'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('note')
                    ->placeholder('-'),
                TextEntry::make('admin_id')
                    ->numeric()
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
