<?php

namespace App\Filament\Resources\Treatments\Tables;

use App\Filament\Support\MoneyColumn;
use App\Models\ServiceCategory;
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

class TreatmentsTable
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
                    ->sortable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->short_description),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn (int $state) => "{$state} min")
                    ->sortable()
                    ->alignEnd(),
                MoneyColumn::make('price')
                    ->alignEnd(),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('service_category_id')
                    ->label('Category')
                    ->options(ServiceCategory::query()->pluck('name', 'id')),
                TernaryFilter::make('is_active'),
                TernaryFilter::make('is_featured'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No treatments yet')
            ->emptyStateDescription('Add a treatment to start building the wellness menu.')
            ->emptyStateIcon(Heroicon::OutlinedSparkles);
    }
}
