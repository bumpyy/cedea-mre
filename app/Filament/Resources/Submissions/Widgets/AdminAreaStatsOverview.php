<?php

namespace App\Filament\Resources\Submissions\Widgets;

use App\Models\Admin;
use App\Models\Submission;
use Carbon\Carbon;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminAreaStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    private static function getDateFilterText(string $label, ?string $startDate = null, ?string $endDate = null): string
    {
        $startDateText = $startDate ? "from {$startDate}" : '';
        $endDateText = $endDate ? "until {$endDate}" : '';

        if ($startDate && $endDate) {
            return "{$label} {$startDateText} {$endDateText}";
        } elseif ($startDate) {
            return "{$label} {$startDateText}";
        } elseif ($endDate) {
            return "{$label} {$endDateText}";
        }

        return "{$label} All Time";
    }

    protected function getStats(): array
    {
        $admin = auth('admin')->user();

        if (! $admin->id) {
            return [];
        }

        $startDate = $this->filters['adminFilterStartDate'] ?? null;
        $endDate = $this->filters['adminFilterEndDate'] ?? null;
        $processedColumn = $this->filters['processed_column'] ?? 'admin_area_processed_at';
        $todayStart = now()->timezone('Asia/Jakarta')->startOfDay()->utc();
        $todayEnd = now()->timezone('Asia/Jakarta')->endOfDay()->utc();
        if ($admin->id != 1) {
            return [
                Section::make()
                    ->schema([
                        Group::make()
                            ->schema([
                                Stat::make("Today submission assigned to admin $admin->id",
                                    Submission::whereAdminIdArea($admin->id)
                                        ->whereBetween('admin_area_assigned_at', [$todayStart, $todayEnd])
                                        ->count()
                                ),

                                Stat::make("Today processed submission by admin $admin->id",
                                    Submission::whereAdminIdArea($admin->id)
                                        ->whereBetween('admin_area_processed_at', [$todayStart, $todayEnd])
                                        ->count()
                                ),
                            ]),
                    ]),
            ];
        }

        $filterStart = $startDate ? Carbon::parse($startDate)->timezone('Asia/Jakarta')->startOfDay()->utc() : null;
        $filterEnd = $endDate ? Carbon::parse($endDate)->timezone('Asia/Jakarta')->endOfDay()->utc() : null;

        $dateDescription = self::getDateFilterText('', $startDate, $endDate);

        $admins = Admin::all();
        $adminIds = $admins->pluck('id')->toArray();

        $stats = [];

        foreach ($adminIds as $id) {
            $stats[] =
            Section::make()
                ->schema([
                    Group::make()
                        ->schema([
                            Stat::make("Today submission assigned to admin $id",
                                Submission::whereAdminIdArea($id)
                                    ->whereBetween('admin_area_assigned_at', [$todayStart, $todayEnd])
                                    ->count()
                            ),

                            Stat::make("Today processed submission by admin $id",
                                Submission::whereAdminIdArea($id)
                                    ->whereBetween('admin_area_processed_at', [$todayStart, $todayEnd])
                                    ->count()
                            ),

                            Stat::make("Total submission assigned to Admin $id",
                                Submission::query()
                                    ->whereAdminIdArea($id)
                                    ->when($filterStart, fn ($q) => $q->where($processedColumn, '>=', $filterStart))
                                    ->when($filterEnd, fn ($q) => $q->where($processedColumn, '<=', $filterEnd))
                                    ->count()
                            )->description($dateDescription),

                            Stat::make("Total submission processed by Admin $id",
                                Submission::query()
                                    ->whereAdminIdArea($id)
                                    ->when($processedColumn == 'admin_area_processed_at', fn ($q) => $q->whereNotNull($processedColumn))
                                    ->when($filterStart, fn ($q) => $q->where($processedColumn, '>=', $filterStart))
                                    ->when($filterEnd, fn ($q) => $q->where($processedColumn, '<=', $filterEnd))
                                    ->count()
                            )->description($dateDescription),
                        ]),
                ]);
        }

        return $stats;
    }
}
