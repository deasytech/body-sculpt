<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Page')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Textarea::make('content')
                            ->rows(8)
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('SEO')
                    ->description('Overrides the default page title and description used by search engines.')
                    ->icon(Heroicon::OutlinedMagnifyingGlass)
                    ->schema([
                        TextInput::make('meta_title'),
                        TextInput::make('meta_description'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
