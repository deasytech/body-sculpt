<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\Staff;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make()
                    ->columns(['default' => 1, 'lg' => 3])
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(['lg' => 2])
                            ->schema([
                                Section::make('Post Details')
                                    ->icon(Heroicon::OutlinedNewspaper)
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                            ->columnSpanFull(),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        Select::make('staff_id')
                                            ->label('Author')
                                            ->options(Staff::query()->pluck('name', 'id'))
                                            ->searchable(),
                                        TextInput::make('excerpt')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Section::make('Content')
                                    ->icon(Heroicon::OutlinedDocumentText)
                                    ->schema([
                                        RichEditor::make('body')
                                            ->label('')
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                Section::make('Cover Photo')
                                    ->icon(Heroicon::OutlinedPhoto)
                                    ->schema([
                                        FileUpload::make('cover_image_path')
                                            ->label('')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('blog'),
                                    ]),
                                Section::make('Publishing')
                                    ->icon(Heroicon::OutlinedCalendarDays)
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->default(false),
                                        DateTimePicker::make('published_at')
                                            ->seconds(false)
                                            ->default(now()),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
