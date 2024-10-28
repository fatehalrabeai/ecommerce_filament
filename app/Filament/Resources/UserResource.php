<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\District;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use function Livewire\after;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
//    protected static ?string $navigationGroup = 'System Management';
    public static function getNavigationLabel(): string
    {
        return __('Users');
    }
    public static function getNavigationGroup(): string
    {
        return __('System Management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Section::make('Relationships')
                ->schema([
                    Forms\Components\Select::make('country_id')
                        ->relationship('country', 'name')
                        ->preload()
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('city_id', null);
                            $set('district_id', null);
                    })
                        ->required(),
                    Forms\Components\Select::make('city_id')
                        ->options(fn (Get $get): Collection => City::Query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('ar_name', 'id'))
                        ->preload()
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('district_id', null))
                        ->required(),
                    Forms\Components\Select::make('district_id')
                        ->options(fn (Get $get): Collection => District::Query()
                            ->where('city_id', $get('city_id'))
                            ->pluck('name', 'id'))
                        ->preload()
                        ->searchable()
                        ->required(),
                ])->columns(3),

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
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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



    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
