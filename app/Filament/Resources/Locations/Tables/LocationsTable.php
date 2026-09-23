<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->fullAddress()),
                TextColumn::make('phone')
                    ->placeholder('—'),
                TextColumn::make('email')
                    ->label('Email address')
                    ->placeholder('—'),
                IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No locations yet')
            ->emptyStateDescription('Add the studio location, opening hours and contact details.')
            ->emptyStateIcon(Heroicon::OutlinedMapPin);
    }
}
