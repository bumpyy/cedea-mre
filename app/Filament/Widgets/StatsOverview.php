<?php

namespace App\Filament\Widgets;

use App\Models\Submission;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon; // Wajib import ini

class StatsOverview extends StatsOverviewWidget
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
        } else {
            return "{$label} All Time";
        }
    }

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $status = $this->filters['status'] ?? null;
        $storeName = $this->filters['store_name'] ?? null;

        $filterStart = null;
        $filterEnd = null;

        if ($startDate) {
            $filterStart = Carbon::parse($startDate)->timezone('Asia/Jakarta')->startOfDay()->utc();
        }
        if ($endDate) {
            $filterEnd = Carbon::parse($endDate)->timezone('Asia/Jakarta')->endOfDay()->utc();
        }

        $todayStart = now()->timezone('Asia/Jakarta')->startOfDay()->utc();
        $todayEnd = now()->timezone('Asia/Jakarta')->endOfDay()->utc();

        return [
            Stat::make('Today new submission',
                Submission::whereBetween('created_at', [$todayStart, $todayEnd])->count()
            )->description('new submission'),

            Stat::make('Today new user',
                User::whereBetween('created_at', [$todayStart, $todayEnd])->count()
            )->description('new registered user'),

            Stat::make('Total Submission Stats', Submission::query()
                ->when($filterStart, fn ($q) => $q->where('created_at', '>=', $filterStart))
                ->when($filterEnd, fn ($q) => $q->where('created_at', '<=', $filterEnd))
                ->when($status, fn ($q) => $q->where('status', $status))
                ->when($storeName, fn ($q) => $q->where('store_name', $storeName))
                ->count()
            )->description(self::getDateFilterText("Total {$status} submission", $startDate, $endDate)),

            Stat::make('Total User Stats', User::query()
                ->when($filterStart, fn ($q) => $q->where('created_at', '>=', $filterStart))
                ->when($filterEnd, fn ($q) => $q->where('created_at', '<=', $filterEnd))
                ->count()
            )->description(self::getDateFilterText('Total registered User', $startDate, $endDate)),
        ];
    }
}
