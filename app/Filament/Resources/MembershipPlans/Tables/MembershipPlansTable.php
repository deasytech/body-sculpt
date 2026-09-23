<?php

namespace App\Filament\Resources\MembershipPlans\Tables;

use App\Filament\Support\MoneyColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MembershipPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold'),
                MoneyColumn::make('price'),
                TextColumn::make('billing_interval')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('sessions_included')
                    ->label('Sessions')
                    ->placeholder('Unlimited')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('memberships_count')
                    ->label('Members')
                    ->counts('memberships')
                    ->badge()
                    ->color('success'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
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
            ->emptyStateHeading('No membership plans yet')
            ->emptyStateDescription('Create a plan to start selling memberships.')
            ->emptyStateIcon(Heroicon::OutlinedIdentification);
    }
}
