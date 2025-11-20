<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Enum\SubmissionStatusEnum;
use App\Exports\Sheets\StatusSheet;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Models\Submission;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListSubmissions extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()->
                withColumns([
                    Column::make('uuid'),
                    Column::make('receipt_number'),
                    Column::make('user.name')
                        ->heading('User Name'),
                    Column::make('user.phone')
                        ->heading('User Phone'),
                    Column::make('user.email')
                        ->heading('User email'),
                    Column::make('status'),
                    Column::make('admin.name')
                        ->heading('Assigned To'),
                    Column::make('note'),
                    Column::make('created_at')
                        ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('GMT+7'))->format('Y-m-d H:i:s')),
                    Column::make('updated_at')
                        ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('GMT+7'))->format('Y-m-d H:i:s')),
                ])
                    ->withSheets(
                        append: [
                            new StatusSheet(SubmissionStatusEnum::PENDING),
                            new StatusSheet(SubmissionStatusEnum::ACCEPTED),
                            new StatusSheet(SubmissionStatusEnum::REJECTED),
                        ]
                    )
                    ->queue(),
            ]),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'assigned' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::PENDING)->where('admin_id', auth('admin')->user()->id))
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::PENDING)->where('admin_id', auth('admin')->user()->id)->count())
                ->badgeColor(SubmissionStatusEnum::PENDING->getColor())
                ->icon(SubmissionStatusEnum::PENDING->getIcon()),
            SubmissionStatusEnum::PENDING->value => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::PENDING))
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::PENDING)->count())
                ->badgeColor(SubmissionStatusEnum::PENDING->getColor())
                ->icon(SubmissionStatusEnum::PENDING->getIcon()),
            SubmissionStatusEnum::ACCEPTED->value => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::ACCEPTED))
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::ACCEPTED)->count())
                ->badgeColor(SubmissionStatusEnum::ACCEPTED->getColor())
                ->icon(SubmissionStatusEnum::ACCEPTED->getIcon()),
            SubmissionStatusEnum::REJECTED->value => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::REJECTED))
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::REJECTED)->count())
                ->badgeColor(SubmissionStatusEnum::REJECTED->getColor())
                ->icon(SubmissionStatusEnum::REJECTED->getIcon()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'assigned';
    }
}
