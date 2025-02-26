<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Pelanggan';

    protected function getData(): array
    {
        $data = Pelanggan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyData = array_fill(1, 12, 0);

        foreach ($data as $month => $count) {
            $monthlyData[$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pelanggan',
                    'data' => array_values($monthlyData),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
