<?php

namespace App\Filament\Resources\MembershipPlans\RelationManagers;

use App\Enums\MembershipStatus;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembershipsRelationManager extends RelationManager
{
    protected static string $relationship = 'memberships';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('customer_id')
                ->relationship('customer', 'name')
                ->searchable()
                ->required(),
            Select::make('status')
                ->options(MembershipStatus::class)
                ->default('active')
                ->required(),
            DatePicker::make('starts_at')->required(),
            DatePicker::make('ends_at'),
            DatePicker::make('renews_at'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('customer.name')->searchable(),
                TextColumn::make('status')->badge()->color(fn (MembershipStatus $state) => $state->color()),
                TextColumn::make('starts_at')->date(),
                TextColumn::make('ends_at')->date(),
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
