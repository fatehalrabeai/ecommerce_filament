<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistrictResource\Pages;
use App\Filament\Resources\DistrictResource\RelationManagers;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
//    protected static ?string $navigationGroup = 'System Management';
//    protected static ?string $navigationLabel = 'District';

    public static function getNavigationLabel(): string
    {
        return __('Districts');
    }
    public static function getNavigationGroup(): string
    {
        return __('SystemManagement');
    }

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->debounce(500)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Generate slug only after user stops typing
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->translateLabel()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->translateLabel()
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->required(),
                Forms\Components\Select::make('city_id')
                    ->translateLabel()
                    ->relationship('city', 'ar_name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ,
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
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('city_id')
                    ->translateLabel()
                    ->searchable(),
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
            'index' => Pages\ListDistricts::route('/'),
            'create' => Pages\CreateDistrict::route('/create'),
            'edit' => Pages\EditDistrict::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('District');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Districts');
    }
}
