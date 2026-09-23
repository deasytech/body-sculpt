<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Filament\Support\MoneyInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Order')
                    ->icon(Heroicon::OutlinedShoppingCart)
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required(),
                        TextInput::make('order_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabledOn('edit'),
                        Select::make('status')
                            ->options(OrderStatus::class)
                            ->default('pending')
                            ->required(),
                        Select::make('promo_code_id')
                            ->label('Promo code')
                            ->relationship('promoCode', 'code')
                            ->searchable(),
                    ])
                    ->columns(2),
                Section::make('Totals')
                    ->icon(Heroicon::OutlinedCalculator)
                    ->schema([
                        MoneyInput::make('subtotal'),
                        MoneyInput::make('discount')->required(false)->minValue(0),
                        MoneyInput::make('total'),
                    ])
                    ->columns(3),
                Section::make('Payment')
                    ->icon(Heroicon::OutlinedCreditCard)
                    ->schema([
                        TextInput::make('payment_gateway'),
                        TextInput::make('payment_reference'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
