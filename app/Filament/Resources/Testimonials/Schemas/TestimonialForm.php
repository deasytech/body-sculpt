<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Testimonial')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->schema([
                        TextInput::make('customer_name')
                            ->required(),
                        TextInput::make('service_name')
                            ->helperText('Optional — the treatment or class this refers to.'),
                        Textarea::make('quote')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('rating')
                            ->options(['5' => '★★★★★', '4' => '★★★★', '3' => '★★★', '2' => '★★', '1' => '★'])
                            ->native(false),
                    ])
                    ->columns(2),
                Section::make('Visibility')
                    ->icon(Heroicon::OutlinedEye)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Shown on the homepage.'),
                        TextInput::make('sort_order')
                            ->label('Display order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }
}
