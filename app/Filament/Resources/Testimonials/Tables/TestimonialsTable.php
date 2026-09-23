<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('quote')
                    ->limit(60)
                    ->wrap(),
                TextColumn::make('service_name')
                    ->label('Service')
                    ->placeholder('—'),
                TextColumn::make('rating')
                    ->formatStateUsing(fn (?int $state) => $state ? str_repeat('★', $state) : '—'),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
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
            ->emptyStateHeading('No testimonials yet')
            ->emptyStateDescription('Add a client testimonial to feature on the homepage.')
            ->emptyStateIcon(Heroicon::OutlinedChatBubbleLeftRight);
    }
}
