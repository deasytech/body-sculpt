<?php

namespace App\Filament\Resources\PromoCodes\Tables;

use App\Enums\PromoType;
use App\Models\PromoCode;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PromoCodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->weight('semibold')
                    ->fontFamily('mono'),
                TextColumn::make('value')
                    ->label('Discount')
                    ->formatStateUsing(fn (PromoCode $record) => $record->type === PromoType::Percentage
                        ? "{$record->value}%"
                        : '₦'.number_format($record->value / 100, 2)),
                TextColumn::make('used_count')
                    ->label('Redeemed')
                    ->formatStateUsing(fn (PromoCode $record) => $record->max_uses
                        ? "{$record->used_count} / {$record->max_uses}"
                        : (string) $record->used_count)
                    ->badge()
                    ->color('gray'),
                TextColumn::make('expires_at')
                    ->date()
                    ->placeholder('No expiry')
                    ->sortable(),
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
            ->emptyStateHeading('No promo codes yet')
            ->emptyStateDescription('Create a code to offer a discount at checkout.')
            ->emptyStateIcon(Heroicon::OutlinedTicket);
    }
}
