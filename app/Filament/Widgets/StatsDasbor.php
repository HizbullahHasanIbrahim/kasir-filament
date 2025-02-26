<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDasbor extends BaseWidget
{
    protected function getStats(): array
    {
        $countUser = \App\Models\User::count();
        $countPelanggan = \App\Models\Pelanggan::count();
        $countyPenjualan = \App\Models\Penjualan::count();
        return [
            Stat::make('Akun', value: $countUser),
            Stat::make('Pelanggan', value: $countPelanggan),
            Stat::make('Penjualan', value: $countyPenjualan),
        ];
    }
}
