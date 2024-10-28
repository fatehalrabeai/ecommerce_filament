<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
//    protected static ?string $navigationGroup = 'Product Catalogue';
//    protected static ?string $navigationLabel = $this->getNavigationLabel();

    public static function getNavigationLabel(): string
    {
        return __('Brands');
    }

    public static function getNavigationGroup(): string
    {
        return __('Product Management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->translateLabel()
                    ->reactive()
                        ->debounce(500)
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Generate slug only after user stops typing
                            $set('slug', Str::slug($state));
                        }),
                Forms\Components\TextInput::make('slug')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image_name')
                    ->image()
                    ->translateLabel(),
                Forms\Components\Select::make('status')
                    ->translateLabel()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_name')
                    ->translateLabel(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Brand Info')
                    ->schema([
                        TextEntry::make('name')->label(__('BrandName')),
                        TextEntry::make('slug')->label(__('Slug')),
                        TextEntry::make('status')->label(__('Status')),

                    ])->columns(2)
            ]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'view' => Pages\ViewBrand::route('/{record}'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Brand');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Brands');
    }
}
