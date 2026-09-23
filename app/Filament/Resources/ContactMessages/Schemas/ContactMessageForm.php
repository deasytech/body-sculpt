<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('From')
                    ->icon(Heroicon::OutlinedUserCircle)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('subject'),
                    ])
                    ->columns(2),
                Section::make('Message')
                    ->icon(Heroicon::OutlinedEnvelopeOpen)
                    ->schema([
                        Textarea::make('message')
                            ->label('')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Toggle::make('is_read')
                            ->label('Marked as read')
                            ->default(false),
                    ]),
            ]);
    }
}
