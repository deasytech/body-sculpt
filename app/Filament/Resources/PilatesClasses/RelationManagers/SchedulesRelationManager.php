<?php

namespace App\Filament\Resources\PilatesClasses\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $title = 'Weekly Schedule';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('day_of_week')
                ->options([
                    0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
                    4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
                ])
                ->required(),
            TimePicker::make('start_time')->seconds(false)->required(),
            TimePicker::make('end_time')->seconds(false)->required(),
            TextInput::make('capacity_override')
                ->label('Capacity override')
                ->numeric()
                ->helperText('Leave blank to use the class default capacity.'),
            Toggle::make('is_active')->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('day_of_week')
            ->columns([
                TextColumn::make('day_of_week')
                    ->label('Day')
                    ->formatStateUsing(fn ($record) => $record->dayName()),
                TextColumn::make('start_time')->time('H:i'),
                TextColumn::make('end_time')->time('H:i'),
                TextColumn::make('capacity_override')->label('Capacity override')->placeholder('Default'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
