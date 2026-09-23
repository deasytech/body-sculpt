<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Support\MoneyColumn;
use App\Models\ProductCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->sku),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge(),
                MoneyColumn::make('price')
                    ->alignEnd(),
                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->alignEnd()
                    ->color(fn (int $state) => $state === 0 ? 'danger' : ($state < 10 ? 'warning' : null))
                    ->weight(fn (int $state) => $state === 0 ? 'bold' : null),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('product_category_id')
                    ->label('Category')
                    ->options(ProductCategory::query()->pluck('name', 'id')),
                TernaryFilter::make('is_active'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No products yet')
            ->emptyStateDescription('Add a product to start selling in the shop.')
            ->emptyStateIcon(Heroicon::OutlinedShoppingBag);
    }
}
