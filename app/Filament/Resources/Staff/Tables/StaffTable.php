<?php

namespace App\Filament\Resources\Staff\Tables;

use App\Enums\StaffType;
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

class StaffTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('avatar_path')
                    ->label('')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->email),
                TextColumn::make('type')
                    ->label('Role')
                    ->badge(),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('—'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(StaffType::class),
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
            ->emptyStateHeading('No team members yet')
            ->emptyStateDescription('Add instructors, therapists and staff to the team.')
            ->emptyStateIcon(Heroicon::OutlinedUsers);
    }
}
