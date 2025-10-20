<?php

namespace App\Filament\Resources\Submissions\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

class SubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('receipt_number'),
                PanZoomEntry::make('image_preview')
                    ->imageUrl(fn ($record) => $record?->getFirstMediaUrl('submissions'))
                    ->doubleClickZoomLevel(2.0)  // Zoom to 2x
                    ->imageId(fn ($record) => 'image-'.$record->id),
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
