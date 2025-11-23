<?php

namespace App\Filament\Widgets;

use App\Enum\StoreEnum; // PENTING: Import Enum
use App\Models\Submission;
use App\Models\User;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class SubmissionAndUserChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Store Performance Comparison';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $startDateFilter = $this->filters['startDate'] ?? null;
        $endDateFilter = $this->filters['endDate'] ?? null;
        $filterStore = $this->filters['store_name'] ?? null;

        $end = $endDateFilter
            ? Carbon::parse($endDateFilter)->timezone('Asia/Jakarta')->endOfDay()
            : now()->timezone('Asia/Jakarta')->endOfDay();

        if ($startDateFilter) {
            $start = Carbon::parse($startDateFilter)->timezone('Asia/Jakarta')->startOfDay();
        } else {
            $minDate = Submission::min('created_at') ?? now();
            $start = Carbon::parse($minDate)->timezone('Asia/Jakarta')->startOfDay();
        }

        $skeletonData = [];
        $period = CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $skeletonData[$date->format('Y-m-d')] = 0;
        }
        $labels = array_keys($skeletonData);

        $queryStart = $start->copy()->utc();
        $queryEnd = $end->copy()->utc();

        $datasets = [];

        if ($filterStore) {
            $enumCase = StoreEnum::tryFrom($filterStore);
            $color = $enumCase ? $enumCase->getColor() : '#36A2EB';

            $submissions = Submission::query()
                ->whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('store_name', $filterStore)
                ->get();

            $dataValues = $skeletonData;
            foreach ($submissions as $sub) {
                $dateKey = $sub->created_at->timezone('Asia/Jakarta')->format('Y-m-d');
                if (isset($dataValues[$dateKey])) {
                    $dataValues[$dateKey]++;
                }
            }

            $datasets[] = [
                'label' => 'Store: '.($enumCase?->getLabel() ?? $filterStore),
                'data' => array_values($dataValues),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'borderWidth' => 3,
                'fill' => false,
            ];

        } else {

            $allSubmissions = Submission::query()
                ->select('store_name', 'created_at')
                ->whereBetween('created_at', [$queryStart, $queryEnd])
                ->get();

            $totalValues = $skeletonData;
            foreach ($allSubmissions as $sub) {
                $dateKey = $sub->created_at->timezone('Asia/Jakarta')->format('Y-m-d');
                if (isset($totalValues[$dateKey])) {
                    $totalValues[$dateKey]++;
                }
            }

            $datasets[] = [
                'label' => 'All Submission',
                'data' => array_values($totalValues),
                'borderColor' => '#000000',
                'backgroundColor' => '#000000',
                'borderWidth' => 4,
                'pointRadius' => 0,
                'fill' => false,
            ];

            $grouped = $allSubmissions
                ->whereNotNull('store_name')
                ->where('store_name', '!=', '')
                ->groupBy('store_name');

            $palette = $this->getColorPalette();
            $paletteIndex = 0;

            foreach ($grouped as $storeName => $storeSubs) {
                $storeValues = $skeletonData;
                foreach ($storeSubs as $sub) {
                    $dateKey = $sub->created_at->timezone('Asia/Jakarta')->format('Y-m-d');
                    if (isset($storeValues[$dateKey])) {
                        $storeValues[$dateKey]++;
                    }
                }

                $enumCase = StoreEnum::tryFrom($storeName);

                if ($enumCase) {
                    $label = $enumCase->getLabel();
                    $color = $enumCase->getColor();
                } else {
                    $label = $storeName;
                    $color = $palette[$paletteIndex % count($palette)];
                    $paletteIndex++;
                }

                $datasets[] = [
                    'label' => $label,
                    'data' => array_values($storeValues),
                    'borderColor' => $color,
                    'backgroundColor' => $color,
                    'borderWidth' => 2,
                    'fill' => false,
                    'tension' => 0.3,
                ];
            }
        }

        $users = User::whereBetween('created_at', [$queryStart, $queryEnd])->get();
        $userValues = $skeletonData;
        foreach ($users as $user) {
            $dateKey = $user->created_at->timezone('Asia/Jakarta')->format('Y-m-d');
            if (isset($userValues[$dateKey])) {
                $userValues[$dateKey]++;
            }
        }

        $datasets[] = [
            'label' => 'Registered Users',
            'data' => array_values($userValues),
            'borderColor' => '#9CA3AF',
            'backgroundColor' => '#9CA3AF',
            'borderDash' => [5, 5],
            'borderWidth' => 2,
            'pointRadius' => 0,
            'fill' => false,
        ];

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    // Fallback colors untuk toko yang tidak ada di Enum
    private function getColorPalette(): array
    {
        return ['#FF6384', '#FF9F40', '#FFCD56', '#4BC0C0', '#9966FF', '#C9CBCF'];
    }
}
