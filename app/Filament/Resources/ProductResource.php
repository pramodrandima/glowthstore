<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('status')
                ->options(collect(ProductStatus::cases())->mapWithKeys(fn ($status) => [$status->value => ucfirst($status->value)]))
                ->required(),
            Forms\Components\TextInput::make('owner_type')
                ->default('glowth')
                ->required(),
            Forms\Components\TextInput::make('owner_id')
                ->numeric(),
            Forms\Components\Select::make('category_id')
                ->label('Category')
                ->options(Category::query()->pluck('name', 'id'))
                ->searchable(),
            Forms\Components\Select::make('tags')
                ->relationship('tags', 'name')
                ->multiple()
                ->preload(),
            Forms\Components\TextInput::make('price_usd')
                ->numeric()
                ->required()
                ->prefix('$'),
            Forms\Components\Toggle::make('featured'),
            Forms\Components\Textarea::make('short_description')
                ->rows(2),
            Forms\Components\RichEditor::make('description')
                ->columnSpanFull(),
            Forms\Components\TagsInput::make('inclusions')
                ->placeholder('Add inclusion and press enter')
                ->columnSpanFull(),
            Forms\Components\Repeater::make('previews')
                ->relationship()
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->disk('public')
                        ->directory('product-previews')
                        ->required()
                        ->image(),
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ])
                ->collapsible()
                ->columnSpanFull(),
            Forms\Components\Repeater::make('files')
                ->relationship()
                ->schema([
                    Forms\Components\TextInput::make('display_name')->required(),
                    Forms\Components\Select::make('format')
                        ->options([
                            'AI' => 'AI',
                            'PSD' => 'PSD',
                            'PDF' => 'PDF',
                            'PNG' => 'PNG',
                            'SVG' => 'SVG',
                            'ZIP' => 'ZIP',
                        ]),
                    Forms\Components\FileUpload::make('storage_path')
                        ->disk(config('store.product_files_disk'))
                        ->directory('product-files')
                        ->required(),
                    Forms\Components\TextInput::make('storage_disk')
                        ->default(config('store.product_files_disk'))
                        ->required(),
                    Forms\Components\TextInput::make('file_size')
                        ->numeric(),
                ])
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\TextColumn::make('price_usd')->money('USD'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        ProductStatus::DRAFT->value => 'Draft',
                        ProductStatus::PUBLISHED->value => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(Category::query()->pluck('name', 'id')->toArray()),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['category', 'tags']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
