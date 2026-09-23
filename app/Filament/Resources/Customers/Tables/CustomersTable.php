<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->email),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('bookings_count')
                    ->label('Bookings')
                    ->counts('bookings')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('memberships_count')
                    ->label('Memberships')
                    ->counts('memberships')
                    ->badge()
                    ->color('success')
                    ->visibleFrom('lg'),
                TextColumn::make('created_at')
                    ->label('Customer since')
                    ->date()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No customers yet')
            ->emptyStateDescription('Customers are created automatically when a booking or order is placed.')
            ->emptyStateIcon(Heroicon::OutlinedUserCircle);
    }
}
