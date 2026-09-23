<?php

namespace App\Filament\Resources\PromoCodes\Schemas;

use App\Enums\PromoType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PromoCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Discount')
                    ->icon(Heroicon::OutlinedTicket)
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->formatStateUsing(fn (?string $state) => $state ? strtoupper($state) : $state)
                            ->dehydrateStateUsing(fn (?string $state) => strtoupper((string) $state)),
                        Select::make('type')
                            ->options(PromoType::class)
                            ->required(),
                        TextInput::make('value')
                            ->required()
                            ->numeric()
                            ->suffix(fn (?string $state, $get) => $get('type') === 'percentage' ? '%' : '₦'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('Usage')
                    ->icon(Heroicon::OutlinedChartBar)
                    ->schema([
                        TextInput::make('max_uses')
                            ->label('Maximum uses')
                            ->numeric()
                            ->helperText('Leave blank for unlimited.'),
                        TextInput::make('used_count')
                            ->label('Times used')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Tracked automatically as the code is redeemed.'),
                    ])
                    ->columns(2),
                Section::make('Validity Window')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->schema([
                        DatePicker::make('starts_at'),
                        DatePicker::make('expires_at'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
