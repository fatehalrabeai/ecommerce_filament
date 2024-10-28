<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }

//    public static function getNavigationGroup(): string
//    {
//        return __('Order Management');
//    }

    public static function getModelLabel(): string
    {
        return __('Order');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Orders');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Customer name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()  // Apply badge style to the text
                    ->formatStateUsing(function (OrderStatus $state) {
                        return match ($state) {
                            OrderStatus::PENDING => __('Pending'),
                            OrderStatus::PROCESSING => __('Processing'),
                            OrderStatus::SHIPPED => __('Shipped'),
                            OrderStatus::DELIVERED => __('Delivered'),
                            OrderStatus::CANCELLED => __('Cancelled'),
                            OrderStatus::RETURNED => __('Returned'),
                        };
                    })
                    ->colors([
                        'primary' => OrderStatus::PENDING->value,
                        'warning' => OrderStatus::PROCESSING->value,
                        'info' => OrderStatus::SHIPPED->value,
                        'success' => OrderStatus::DELIVERED->value,
                        'danger' => OrderStatus::CANCELLED->value,
                        'secondary' => OrderStatus::RETURNED->value,
                    ])
                    ->label(__('Order Status')),
                Tables\Columns\TextColumn::make('total_price')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
