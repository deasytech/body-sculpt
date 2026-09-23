<?php

namespace App\Filament\Resources\PilatesClasses\Schemas;

use App\Enums\ClassLevel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class PilatesClassForm
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
                                Section::make('Class Details')
                                    ->description('The instructor, level and capacity for this class.')
                                    ->icon(Heroicon::OutlinedUserGroup)
                                    ->schema([
                                        Select::make('instructor_id')
                                            ->label('Instructor')
                                            ->relationship('instructor', 'name', modifyQueryUsing: fn ($query) => $query->instructors()->active())
                                            ->searchable()
                                            ->required(),
                                        TextInput::make('name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        Select::make('level')
                                            ->options(ClassLevel::class)
                                            ->default('all_levels')
                                            ->required(),
                                        TextInput::make('duration_minutes')
                                            ->label('Duration')
                                            ->required()
                                            ->numeric()
                                            ->default(50)
                                            ->suffix('min'),
                                        TextInput::make('capacity')
                                            ->label('Capacity')
                                            ->required()
                                            ->numeric()
                                            ->default(12)
                                            ->suffix('people'),
                                    ])
                                    ->columns(2),
                                Section::make('Description')
                                    ->icon(Heroicon::OutlinedDocumentText)
                                    ->schema([
                                        Textarea::make('description')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                Section::make('Photo')
                                    ->icon(Heroicon::OutlinedPhoto)
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('')
                                            ->image()
                                            ->imageEditor(),
                                    ]),
                                Section::make('Visibility')
                                    ->icon(Heroicon::OutlinedEye)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->helperText('Visible on the public Pilates page.')
                                            ->default(true),
                                        TextInput::make('sort_order')
                                            ->label('Display order')
                                            ->numeric()
                                            ->default(0),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
