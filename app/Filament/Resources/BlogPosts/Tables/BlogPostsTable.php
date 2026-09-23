<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                ImageColumn::make('cover_image_path')
                    ->label('')
                    ->circular(),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->excerpt)
                    ->limit(60),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->placeholder('—'),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Publish date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Write your first journal post for the public blog.')
            ->emptyStateIcon(Heroicon::OutlinedNewspaper);
    }
}
