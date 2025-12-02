<?php

namespace App\Filament\Pages;

use App\Enum\StoreEnum;
use App\Enum\SubmissionStatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Group::make()
                            ->schema([
                                DatePicker::make('startDate')
                                    ->timezone('Asia/Jakarta'),
                                DatePicker::make('endDate')
                                    ->timezone('Asia/Jakarta'),
                            ])
                            ->columns(2),
                        Select::make('includeDisqualified')
                            ->default(false)
                            ->selectablePlaceholder(false)
                            ->options([
                                true => 'Yes',
                                false => 'No',
                            ]),
                    ])
                    ->columnSpan('2'),
                Section::make()
                    ->schema([
                        Select::make('status')
                            ->options(
                                SubmissionStatusEnum::class
                            ),
                        Select::make('store_name')
                            ->options(
                                StoreEnum::class
                            ),
                    ])
                    ->columnSpan('2'),
            ]);
    }
}
