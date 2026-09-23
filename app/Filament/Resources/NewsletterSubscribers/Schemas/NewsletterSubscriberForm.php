<?php

namespace App\Filament\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Subscriber')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        DateTimePicker::make('subscribed_at')
                            ->seconds(false)
                            ->default(now()),
                    ])
                    ->columns(3),
            ]);
    }
}
