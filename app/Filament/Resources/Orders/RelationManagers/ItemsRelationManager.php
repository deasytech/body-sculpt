<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use App\Filament\Support\MoneyColumn;
use App\Filament\Support\MoneyInput;
use App\Models\Product;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Order Items';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('product_id')
                ->label('Product')
                ->options(Product::query()->pluck('name', 'id'))
                ->searchable()
                ->live()
                ->afterStateUpdated(function (Set $set, ?string $state) {
                    $set('unit_price', $state ? Product::find($state)?->price / 100 : null);
                })
                ->required(),
            TextInput::make('quantity')
                ->numeric()
                ->default(1)
                ->live()
                ->afterStateUpdated(fn (Get $get, Set $set) => $set('line_total', round(($get('unit_price') ?? 0) * ($get('quantity') ?? 1), 2)))
                ->required(),
            MoneyInput::make('unit_price')
                ->live()
                ->afterStateUpdated(fn (Get $get, Set $set) => $set('line_total', round(((float) $get('unit_price')) * ($get('quantity') ?? 1), 2))),
            MoneyInput::make('line_total'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('product.name'),
                TextColumn::make('quantity'),
                MoneyColumn::make('unit_price'),
                MoneyColumn::make('line_total'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
