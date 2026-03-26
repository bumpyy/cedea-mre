<?php

namespace App\Filament\Resources\SubmissionAreas\Schemas;

use App\Enum\StoreEnum;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use SolutionForest\FilamentPanzoom\Components\PanZoom;

class SubmissionAreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                PanZoom::make('receipt_image_preview')
                    ->imageUrl(fn ($record) => $record->getFirstMediaUrl('submissions'))
                    ->imageId(fn ($record) => 'receipt-'.$record->id),
                Select::make('store_name')
                    ->options(StoreEnum::class)
                    ->default(StoreEnum::INDOMARET->value)
                    ->required(),
                \Schmeits\FilamentCharacterCounter\Forms\Components\TextInput::make('store_area')
                    ->characterLimit(190)
                    ->datalist([
                        'ACEH',
                        'SUMATERA UTARA',
                        'SUMATERA BARAT',
                        'RIAU',
                        'JAMBI',
                        'SUMATERA SELATAN',
                        'BENGKULU',
                        'LAMPUNG',
                        'KEPULAUAN BANGKA BELITUNG',
                        'KEPULAUAN RIAU',
                        'DKI JAKARTA',
                        'JAWA BARAT',
                        'JAWA TENGAH',
                        'DAERAH ISTIMEWA YOGYAKARTA',
                        'JAWA TIMUR',
                        'BANTEN',
                        'BALI',
                        'NUSA TENGGARA BARAT',
                        'NUSA TENGGARA TIMUR',
                        'KALIMANTAN BARAT',
                        'KALIMANTAN TENGAH',
                        'KALIMANTAN SELATAN',
                        'KALIMANTAN TIMUR',
                        'KALIMANTAN UTARA',
                        'SULAWESI UTARA',
                        'SULAWESI TENGAH',
                        'SULAWESI SELATAN',
                        'SULAWESI TENGGARA',
                        'GORONTALO',
                        'SULAWESI BARAT',
                        'MALUKU',
                        'MALUKU UTARA',
                        'PAPUA',
                        'PAPUA BARAT',
                        'PAPUA SELATAN',
                        'PAPUA TENGAH',
                        'PAPUA PEGUNUNGAN',
                        'PAPUA BARAT DAYA',
                    ])
                    ->required()
                    ->extraInputAttributes(['@keydown.enter.prevent' => 'return false']),
                // ->selectablePlaceholder(false),

            ])
            ->columns(1);

    }
}
