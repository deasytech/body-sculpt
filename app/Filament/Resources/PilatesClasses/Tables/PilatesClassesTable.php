<?php

namespace App\Filament\Resources\PilatesClasses\Tables;

use App\Enums\ClassLevel;
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

class PilatesClassesTable
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
                    ->description(fn ($record) => $record->instructor?->name ? "With {$record->instructor->name}" : null),
                TextColumn::make('level')
                    ->badge(),
                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn (int $state) => "{$state} min")
                    ->sortable()
                    ->alignEnd(),
                TextColumn::make('capacity')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),
                TextColumn::make('schedules_count')
                    ->label('Weekly sessions')
                    ->counts('schedules')
                    ->badge()
                    ->color('gray'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->options(ClassLevel::class),
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
            ->emptyStateHeading('No Pilates classes yet')
            ->emptyStateDescription('Add a class to start building the Pilates timetable.')
            ->emptyStateIcon(Heroicon::OutlinedUserGroup);
    }
}
