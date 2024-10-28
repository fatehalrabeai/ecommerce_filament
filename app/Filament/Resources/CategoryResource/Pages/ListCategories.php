<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Enums\CategoryStatus;
use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


}
