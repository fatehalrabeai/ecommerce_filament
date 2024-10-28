<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            __('All') => ListRecords\Tab::make(),

            __('Pending Orders') => ListRecords\Tab::make()->modifyQueryUsing(function (Builder $query) {
                $query->where('status', OrderStatus::PENDING->value);
            }),

            __('Processing Orders') => ListRecords\Tab::make()->modifyQueryUsing(function (Builder $query) {
                $query->where('status', OrderStatus::PROCESSING->value);
            }),

            __('Shipped Orders') => ListRecords\Tab::make()->modifyQueryUsing(function (Builder $query) {
                $query->where('status', OrderStatus::SHIPPED->value);
            }),

            __('Delivered Orders') => ListRecords\Tab::make()->modifyQueryUsing(function (Builder $query) {
                $query->where('status', OrderStatus::DELIVERED->value);
            }),
        ];
    }
}
