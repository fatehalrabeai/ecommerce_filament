<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
use App\Models\Category;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function getNavigationLabel(): string
    {
        return __('Categories');
    }
    public static function getNavigationGroup(): string
    {
        return __('ProductManagement');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Category'))
            ->schema([
                Forms\Components\FileUpload::make('image_name')
                    ->label(__('CategoryImage'))
                    ->image()
                    ->translateLabel(),

                Forms\Components\FileUpload::make('cover_image')
                    ->translateLabel()
                    ->image()
                    ->translateLabel(),
            ])->columns(2),
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
                SelectTree::make('parent_id')
                    ->label(__('Parent category'))
                    ->withCount()
                    ->searchable()
                    ->placeholder(__('Please select category'))
                    ->relationship('parent', 'name','parent_id',modifyQueryUsing: fn (Builder $query) => $query->orderBy('name','asc')),
                Forms\Components\TextInput::make('slug')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
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
                TextColumn::make('parent.name') // Access the parent category's name
                ->label(__('Parent'))
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

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
                Section::make('CategoryInfo')
                    ->schema([
                        TextEntry::make('name')->label(__('CategoryName')),
                        TextEntry::make('slug')->label(__('Slug')),
                        TextEntry::make('status')->label(__('Status')),

                    ])->columns(2)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Category');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Categories');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product created')
            ->body('The Product has been created successfully.');
    }
}
