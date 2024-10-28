<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
//    protected static ?string $navigationGroup = 'System Management';
//    protected static ?string $navigationLabel = 'City';

    public static function getNavigationLabel(): string
    {
        return __('Cities');
    }
    public static function getNavigationGroup(): string
    {
        return __('SystemManagement');
    }
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ar_name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->debounce(500)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Generate slug only after user stops typing
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('en_name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->debounce(500)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Generate slug only after user stops typing
                        $set('en_slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('ar_slug')
                    ->translateLabel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('en_slug')
                    ->translateLabel()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->translateLabel()
                    ->native(false)
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                Forms\Components\Select::make('country_id')
                    ->translateLabel()
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
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
                Tables\Columns\TextColumn::make('ar_name')
                    ->label(__('CityName'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('country.name')
                    ->label(__('CountryName'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                ->translateLabel()
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                ,
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('ar_name', 'desc')
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
                Section::make('City Info')
                    ->schema([
                        TextEntry::make('country.name')->label('Country Name'),
                        TextEntry::make('ar_name')->label('City Name'),
                        TextEntry::make('slug')->label('SEO Slug'),
                    ])->columns(2)
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'view' => Pages\ViewCity::route('/{record}'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('City');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Cities');
    }

}
