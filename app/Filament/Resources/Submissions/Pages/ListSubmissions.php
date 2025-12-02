<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Enum\SubmissionStatusEnum;
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
        $columns = [
            Column::make('uuid'),
            Column::make('raffle_number'),
            Column::make('receipt_number'),
            Column::make('store_name'),
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
            Column::make('image_url')
                ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('submissions')),
            Column::make('created_at')
                ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d H:i:s')),
            Column::make('updated_at')
                ->formatStateUsing(fn ($state) => (new \DateTime($state))->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d H:i:s')),
        ];

        return [
            ExportAction::make()->exports([
                ExcelExport::make('all')
                    ->withColumns($columns)
                    ->modifyQueryUsing(fn ($query) => $query->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    }))
                    ->queue(),

                ...array_map(function (SubmissionStatusEnum $status) use ($columns) {
                    return ExcelExport::make($status->value)
                        ->modifyQueryUsing(fn ($query) => $query->where('status', $status->value)
                            ->whereHas('user', function ($query) {
                                $query->where('disqualified', false);
                            }))
                        ->withColumns($columns)
                        ->queue();
                }, SubmissionStatusEnum::cases()),
            ]),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->modifyQueryUsing(fn ($query) => $query->whereHas('user', function ($query) {
                    $query->where('disqualified', false);
                })),
            'assigned' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::PENDING)->where('admin_id', auth('admin')->user()->id))
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::PENDING)->where('admin_id', auth('admin')->user()->id)->count())
                ->badgeColor(SubmissionStatusEnum::PENDING->getColor())
                ->icon(SubmissionStatusEnum::PENDING->getIcon()),
            SubmissionStatusEnum::PENDING->value => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::PENDING)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                )
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::PENDING)->whereHas('user', function ($query) {
                    $query->where('disqualified', false);
                })
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                    ->count())
                ->badgeColor(SubmissionStatusEnum::PENDING->getColor())
                ->icon(SubmissionStatusEnum::PENDING->getIcon()),
            SubmissionStatusEnum::ACCEPTED->value => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::ACCEPTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    }))
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::ACCEPTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                    ->count())
                ->badgeColor(SubmissionStatusEnum::ACCEPTED->getColor())
                ->icon(SubmissionStatusEnum::ACCEPTED->getIcon()),
            SubmissionStatusEnum::REJECTED->value => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', SubmissionStatusEnum::REJECTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                )
                ->badge(Submission::query()->where('status', SubmissionStatusEnum::REJECTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                    ->count())
                ->badgeColor(SubmissionStatusEnum::REJECTED->getColor())
                ->icon(SubmissionStatusEnum::REJECTED->getIcon()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'assigned';
    }
}
