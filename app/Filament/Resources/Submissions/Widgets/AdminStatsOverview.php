<?php

namespace App\Filament\Resources\Submissions\Widgets;

use App\Models\Submission;
use Carbon\Carbon;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
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

        if ($admin->id != 1) {
            return [];
        }

        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $processedColumn = $this->filters['processed_column'] ?? 'processed_at';

        $filterStart = $startDate ? Carbon::parse($startDate)->timezone('Asia/Jakarta')->startOfDay()->utc() : null;
        $filterEnd = $endDate ? Carbon::parse($endDate)->timezone('Asia/Jakarta')->endOfDay()->utc() : null;

        $todayStart = now()->timezone('Asia/Jakarta')->startOfDay()->utc();
        $todayEnd = now()->timezone('Asia/Jakarta')->endOfDay()->utc();

        $dateDescription = self::getDateFilterText('', $startDate, $endDate);

        $adminIds = [1, 2, 3];

        $stats = [];

        foreach ($adminIds as $id) {
            $stats[] =
            Section::make()
                ->schema([
                    Group::make()
                        ->schema([
                            Stat::make("Today submission assigned to admin $id",
                                Submission::whereAdminId($id)
                                    ->whereBetween('assigned_at', [$todayStart, $todayEnd])
                                    ->count()
                            ),

                            Stat::make("Today processed submission by admin $id",
                                Submission::whereAdminId($id)
                                    ->whereBetween('processed_at', [$todayStart, $todayEnd])
                                    ->count()
                            ),

                            Stat::make("Total submission assigned to Admin $id",
                                Submission::query()
                                    ->whereAdminId($id)
                                    ->when($filterStart, fn ($q) => $q->where($processedColumn, '>=', $filterStart))
                                    ->when($filterEnd, fn ($q) => $q->where($processedColumn, '<=', $filterEnd))
                                    ->count()
                            )->description($dateDescription),

                            Stat::make("Total submission processed by Admin $id",
                                Submission::query()
                                    ->whereAdminId($id)
                                    ->when($processedColumn == 'processed_at', fn ($q) => $q->whereNotNull($processedColumn))
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
