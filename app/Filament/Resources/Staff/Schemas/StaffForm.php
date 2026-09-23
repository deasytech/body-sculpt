<?php

namespace App\Filament\Resources\Staff\Schemas;

use App\Enums\StaffType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StaffForm
{
    public static function configure(Schema $schema, bool $lockType = false): Schema
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
                                Section::make('Profile')
                                    ->description('Contact details and role for this team member.')
                                    ->icon(Heroicon::OutlinedUser)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),
                                        Select::make('type')
                                            ->label('Role')
                                            ->options(StaffType::class)
                                            ->required()
                                            ->disabled($lockType)
                                            ->dehydrated(true),
                                        TextInput::make('email')
                                            ->label('Email address')
                                            ->email(),
                                        TextInput::make('phone')
                                            ->tel(),
                                        TagsInput::make('specialties')
                                            ->placeholder('Add a specialty and press enter')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Section::make('Bio')
                                    ->icon(Heroicon::OutlinedDocumentText)
                                    ->schema([
                                        Textarea::make('bio')
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
                                        FileUpload::make('avatar_path')
                                            ->label('')
                                            ->image()
                                            ->avatar()
                                            ->imageEditor()
                                            ->directory('staff'),
                                    ]),
                                Section::make('Visibility')
                                    ->icon(Heroicon::OutlinedEye)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->helperText('Visible on the public About page.')
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
