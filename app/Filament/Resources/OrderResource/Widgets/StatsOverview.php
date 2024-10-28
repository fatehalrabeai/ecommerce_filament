<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Fetch the count of delivered orders
        $deliveredOrdersCount = Order::where('status', 'delivered')->count();

        return [
            // Display the number of delivered orders
            Stat::make('Delivered Orders', $deliveredOrdersCount)
                ->description('Total delivered orders')
                ->descriptionIcon('heroicon-o-truck')
                ->color('success'),  // You can change the color based on your needs
        ];
    }
}
