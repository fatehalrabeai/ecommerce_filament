<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
//    protected static ?string $navigationGroup = 'Product Catalogue';
//    protected static ?string $navigationLabel = 'Product';

    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public static function getNavigationGroup(): string
    {
        return __('Product Management');
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('Product Details'))
                ->schema([

                    TextInput::make('name')
                        ->translateLabel()
                        ->required()
                        ->maxLength(255)
                        ->reactive()
                        ->debounce(500)
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Generate slug only after user stops typing
                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->reactive()
                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                    RichEditor::make('description')
                        ->label(__('Description'))
                        ->columnSpanFull()
                        ->translateLabel()
                        ->required(),


                ])->columns(2),

            TextInput::make('sku')
                ->translateLabel()
                ->placeholder('SKU-ANPTUV9Q')
                ->required()
                ->maxLength(250)
                ->suffixAction(
                    Action::make('generateSku')
                        ->icon('heroicon-o-arrow-path') // Heroicon icon instead of label
                        ->tooltip(__('Generate SKU'))
                        ->action(function (callable $set) {
                            // Loop to generate unique SKU
                            do {
                                $generatedSku = 'SKU-' . strtoupper(Str::random(8));
                            } while (Product::where('sku', $generatedSku)->exists());

                            // Set the SKU after uniqueness check
                            $set('sku', $generatedSku);
                        })
                ),

            SelectTree::make('category_id')
                ->translateLabel()
                ->withCount()
                ->searchable()
                ->placeholder(__('Please select category'))
                ->relationship('category', 'name', 'parent_id', modifyQueryUsing: fn(Builder $query) => $query->orderBy('name', 'asc')),
            Forms\Components\Select::make('brand_id')
                ->translateLabel()
                ->relationship('brand', 'name')
                ->searchable()
                ->preload()
                ->required(),


            Select::make('status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                ->required(),

            // Inline table for Product Attributes
            HasManyRepeater::make('attributes')
                ->relationship('attributes')
                ->schema([
                    Select::make('attribute_id')
                        ->label('Attribute')
                        ->relationship('attribute', 'name')
                        ->required(),

                    Select::make('attribute_value_id')
                        ->label('Attribute Value')
                        ->relationship('attributeValue', 'value')
                        ->required(),

                    TextInput::make('price')
                        ->required()
                        ->numeric(),
                ])
                ->createItemButtonLabel('Add Attribute')
                ->label('Product Attributes'),

            // Inline table for Product Images
            HasManyRepeater::make('images')
                ->relationship('images')
                ->schema([
                    Forms\Components\FileUpload::make('image_name')
                        ->label('Image')
                        ->image()
                        ->directory('product-images')
                        ->maxSize(2048)
                        ->required(),

                    TextInput::make('image_alt')
                        ->label('Alt Text')
                        ->maxLength(255),
                ])
                ->createItemButtonLabel('Add Image')
                ->label('Product Images')
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->translateLabel()
                    ->searchable(),

                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('avg_rating')
                    ->numeric()
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_ratings')
                    ->numeric()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->sortable()
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->translateLabel()
                    ->badge() // Display status as a badge
                    ->colors([
                        'success' => 'active',   // Green for active
                        'danger' => 'inactive',  // Red for inactive
                    ])
                    ,
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Category')
                    ->translateLabel()
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->indicator('Category')
                ,

                Tables\Filters\SelectFilter::make('Brand')
                    ->translateLabel()
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->indicator('Brand')
                ,
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->translateLabel(),
                        Forms\Components\DatePicker::make('created_until')
                            ->translateLabel(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    })->columns(2)
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];

    }

    public static function getModelLabel(): string
    {
        return __('Product');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Products');
    }


    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product created')
            ->body('The Product has been created successfully.');
    }
}
