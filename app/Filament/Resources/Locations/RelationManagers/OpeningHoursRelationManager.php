<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OpeningHoursRelationManager extends RelationManager
{
    protected static string $relationship = 'openingHours';

    protected static ?string $title = 'Opening Hours';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('day_of_week')
                ->options([
                    0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
                    4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
                ])
                ->disabled()
                ->dehydrated(true)
                ->required(),
            TimePicker::make('opens_at')->seconds(false),
            TimePicker::make('closes_at')->seconds(false),
            Toggle::make('is_closed'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('day_of_week')
            ->defaultSort('day_of_week')
            ->columns([
                TextColumn::make('day_of_week')
                    ->label('Day')
                    ->formatStateUsing(fn ($record) => $record->dayName()),
                TextColumn::make('opens_at')->time('H:i')->placeholder('Closed'),
                TextColumn::make('closes_at')->time('H:i')->placeholder('Closed'),
                IconColumn::make('is_closed')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
