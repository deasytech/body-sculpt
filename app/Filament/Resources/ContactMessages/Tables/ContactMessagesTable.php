<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? null : 'bold')
                    ->description(fn ($record) => $record->email),
                TextColumn::make('subject')
                    ->searchable()
                    ->placeholder('—')
                    ->limit(40),
                TextColumn::make('message')
                    ->limit(60)
                    ->toggleable()
                    ->wrap(),
                TextColumn::make('is_read')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state) => $state ? 'Read' : 'Unread')
                    ->color(fn (bool $state) => $state ? 'gray' : 'warning'),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No messages yet')
            ->emptyStateDescription('Messages sent through the public contact form will appear here.')
            ->emptyStateIcon(Heroicon::OutlinedEnvelopeOpen);
    }
}
