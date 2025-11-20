<?php

namespace App\Filament\Resources\Submissions\Schemas;

use Deldius\UserField\UserEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

class SubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('uuid'),
                TextEntry::make('receipt_number'),
                PanZoomEntry::make('receipt_image_preview')
                    ->imageUrl(fn ($record) => $record->getFirstMediaUrl('submissions'))
                    ->imageId(fn ($record) => 'receipt-'.$record->id),
                SpatieMediaLibraryImageEntry::make('receipt_image')
                    ->collection('submissions'),
                UserEntry::make('user_id')
                    ->size(Size::Small) // Set avatar size
                    ->label('User'), // Entry label
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('note')
                    ->placeholder('-'),
                TextEntry::make('admin_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime('Y-m-d H:i:s', 'GMT+7')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime('Y-m-d H:i:s', 'GMT+7')
                    ->placeholder('-'),
            ])
            ->columns(1);
    }
}
