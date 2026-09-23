<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Support\MoneyInput;
use App\Models\ProductCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make()
                    ->columns(['default' => 1, 'lg' => 3])
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(['lg' => 2])
                            ->schema([
                                Section::make('Product Details')
                                    ->description('The name, category and pricing shown in the shop.')
                                    ->icon(Heroicon::OutlinedShoppingBag)
                                    ->schema([
                                        Select::make('product_category_id')
                                            ->label('Category')
                                            ->options(ProductCategory::query()->pluck('name', 'id'))
                                            ->searchable(),
                                        TextInput::make('name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        MoneyInput::make('price'),
                                        TextInput::make('sku')
                                            ->label('SKU'),
                                        TextInput::make('stock_quantity')
                                            ->label('Stock quantity')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(2),
                                Section::make('Description')
                                    ->icon(Heroicon::OutlinedDocumentText)
                                    ->schema([
                                        Textarea::make('description')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                Section::make('Photo')
                                    ->icon(Heroicon::OutlinedPhoto)
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('products'),
                                    ]),
                                Section::make('Visibility')
                                    ->icon(Heroicon::OutlinedEye)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->helperText('Visible in the public shop.')
                                            ->default(true),
                                        TextInput::make('sort_order')
                                            ->label('Display order')
                                            ->numeric()
                                            ->default(0),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
