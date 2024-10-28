<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Order Count', Order::count()),
            Card::make('Categories Count', Category::count()),
            Card::make('Products Count', Product::count()),
            Card::make('Customers Count', User::count()),
        ];
    }
}
