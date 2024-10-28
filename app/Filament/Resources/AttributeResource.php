<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function getNavigationLabel(): string
    {
        return __('Product Attributes');
    }
    public static function getNavigationGroup(): string
    {
        return __('Product Management');
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Attribute Information')
                ->schema([
                    TextInput::make('name')

                        ->translateLabel()
                        ->label('Attribute Name')
                        ->required()
                        ->maxLength(255),

                    Select::make('field_type')
                        ->label('Field Type')
                        ->required()
                        ->options([
                            'text' => 'Text',
                            'number' => 'Number',
                            'select' => 'Select',
                            'checkbox' => 'Checkbox',
                            'radio' => 'Radio',
                            'color' => 'Color',
                        ])
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('values', [])), // Clear values when field type changes

                    // Conditionally display the Repeater for attributes with selectable values
                    Repeater::make('values')
                        ->label('Attribute Values')
                        ->relationship('values') // Link to AttributeValue model
                        ->schema([
                            TextInput::make('value')
                                ->label('Value')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->visible(fn (callable $get) => in_array($get('field_type'), ['select', 'radio', 'checkbox', 'color']))
                        ->defaultItems(1)
                        ->minItems(1)
                        ->maxItems(10)
                        ->columns(1),
                ])
                ->columnSpanFull(),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
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
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'view' => Pages\ViewAttribute::route('/{record}'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Attribute');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Attribute');
    }
}
