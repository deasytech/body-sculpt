<?php

namespace App\Filament\Resources\MembershipPlans\Schemas;

use App\Enums\BillingInterval;
use App\Filament\Support\MoneyInput;
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
use Illuminate\Support\Str;

class MembershipPlanForm
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
                                Section::make('Plan Details')
                                    ->description('Pricing and billing for this membership plan.')
                                    ->icon(Heroicon::OutlinedIdentification)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        MoneyInput::make('price'),
                                        Select::make('billing_interval')
                                            ->options(BillingInterval::class)
                                            ->required(),
                                        TextInput::make('sessions_included')
                                            ->label('Sessions included')
                                            ->numeric()
                                            ->helperText('Leave blank for unlimited sessions.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Section::make('Description & Benefits')
                                    ->icon(Heroicon::OutlinedSparkles)
                                    ->schema([
                                        Textarea::make('description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        TagsInput::make('benefits')
                                            ->placeholder('Add a benefit and press enter')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                Section::make('Visibility')
                                    ->icon(Heroicon::OutlinedEye)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->helperText('Visible on the public membership page.')
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
