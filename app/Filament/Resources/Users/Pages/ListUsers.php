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
        $columns = [
            Column::make('name')
                ->heading('Nama'),
            Column::make('email')
                ->heading('Email'),
            Column::make('phone')
                ->heading('Phone'),
            Column::make('phone_formatted')
                ->heading('Phone formatted'),
            Column::make('submissions_count')
                ->getStateUsing(fn ($record) => $record->submissions->count()),
            Column::make('phone_formatted'),
            Column::make('address'),
            Column::make('social'),
            Column::make('disqualified'),
            Column::make('email_verified_at')
                ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d')),
            Column::make('phone_verified_at')
                ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d')),
            Column::make('created_at')
                ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d H:i:s')),
        ];

        return [
            ExportAction::make()->exports([
                ExcelExport::make('all')
                    ->withColumns($columns)
                    ->queue(),
                ExcelExport::make('not_disqualified')
                    ->withColumns($columns)
                    ->modifyQueryUsing(fn ($query) => $query->where('disqualified', false))
                    ->queue(),
                ExcelExport::make('only_disqualified')
                    ->withColumns($columns)
                    ->modifyQueryUsing(fn ($query) => $query->where('disqualified', true))
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
