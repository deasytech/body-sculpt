<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Location')
                    ->icon(Heroicon::OutlinedBuildingStorefront)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_primary')
                            ->label('Primary location')
                            ->helperText('Used for opening hours, contact details and the location page.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Address')
                    ->icon(Heroicon::OutlinedMapPin)
                    ->schema([
                        TextInput::make('address_line1')
                            ->label('Address line 1')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('address_line2')
                            ->label('Address line 2')
                            ->columnSpanFull(),
                        TextInput::make('city')
                            ->required(),
                        TextInput::make('state')
                            ->required(),
                        TextInput::make('country')
                            ->required()
                            ->default('Nigeria'),
                    ])
                    ->columns(3),
                Section::make('Contact')
                    ->icon(Heroicon::OutlinedPhone)
                    ->schema([
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email(),
                    ])
                    ->columns(2),
                Section::make('Map Coordinates')
                    ->icon(Heroicon::OutlinedGlobeAlt)
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric(),
                        TextInput::make('longitude')
                            ->numeric(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
