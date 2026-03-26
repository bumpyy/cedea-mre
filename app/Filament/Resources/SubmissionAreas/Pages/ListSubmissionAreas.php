<?php

namespace App\Filament\Resources\SubmissionAreas\Pages;

use App\Enum\SubmissionStatusEnum;
use App\Filament\Resources\SubmissionAreas\SubmissionAreaResource;
use App\Filament\Resources\Submissions\Widgets\AdminAreaStatsOverview;
use App\Models\Submission;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSubmissionAreas extends ListRecords
{
    protected static string $resource = SubmissionAreaResource::class;

    public function getTitle(): string
    {
        return 'Submission Area';
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        $admin = auth('admin')->user();

        // if ($admin->id != 1) {
        //     return [

        //     ];
        // }

        return [
            AdminAreaStatsOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'assigned' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', SubmissionStatusEnum::ACCEPTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                    ->where('admin_id_area', auth('admin')->user()->id)

                )
                ->badge(
                    Submission::query()
                        ->where('status', SubmissionStatusEnum::ACCEPTED)
                        ->where('admin_id_area', auth('admin')->user()->id)
                        ->whereHas('user', function ($query) {
                            $query->where('disqualified', false);
                        })
                        ->where(function (Builder $query) {
                            $query->whereNull('store_area')
                                ->orWhere('store_area', '');
                        })
                        ->count()
                )
                ->badgeColor(SubmissionStatusEnum::PENDING->getColor())
                ->icon(SubmissionStatusEnum::PENDING->getIcon()),
            'TODO' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', SubmissionStatusEnum::ACCEPTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                    ->whereNull('store_area')
                    ->orWhere('store_area', '')
                )
                ->badge(
                    Submission::query()
                        ->where('status', SubmissionStatusEnum::ACCEPTED)
                        ->whereHas('user', function ($query) {
                            $query->where('disqualified', false);
                        })
                        ->whereNull('store_area')
                        ->orWhere('store_area', '')
                        ->count()
                )
                ->badgeColor(SubmissionStatusEnum::ACCEPTED->getColor())
                ->icon(SubmissionStatusEnum::ACCEPTED->getIcon()),

        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'assigned';
    }
}
