<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()->withColumns([
                    Column::make('name')
                        ->heading('Nama'),
                    Column::make('email')
                        ->heading('Email'),
                    Column::make('phone')
                        ->heading('Phone'),
                    Column::make('phone_formatted'),
                    Column::make('address'),
                    Column::make('created_at')
                        ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('GMT+7'))->format('Y-m-d H:i:s')),

                ])
                    ->modifyQueryUsing(fn ($query) => $query->where('disqualified', false))
                    ->queue(),
            ]),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'not_disqualified' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('disqualified', false)),
            'disqualified' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('disqualified', true)),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'not_disqualified';
    }
}
