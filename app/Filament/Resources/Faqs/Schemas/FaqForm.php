<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Question & Answer')
                    ->icon(Heroicon::OutlinedQuestionMarkCircle)
                    ->schema([
                        TextInput::make('category')
                            ->helperText('Optional grouping, e.g. Booking, Membership.'),
                        TextInput::make('question')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('answer')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Visibility')
                    ->icon(Heroicon::OutlinedEye)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('Display order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
