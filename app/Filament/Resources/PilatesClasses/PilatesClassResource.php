<?php

namespace App\Filament\Resources\PilatesClasses;

use App\Filament\Resources\PilatesClasses\Pages\CreatePilatesClass;
use App\Filament\Resources\PilatesClasses\Pages\EditPilatesClass;
use App\Filament\Resources\PilatesClasses\Pages\ListPilatesClasses;
use App\Filament\Resources\PilatesClasses\RelationManagers\SchedulesRelationManager;
use App\Filament\Resources\PilatesClasses\Schemas\PilatesClassForm;
use App\Filament\Resources\PilatesClasses\Tables\PilatesClassesTable;
use App\Models\PilatesClass;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PilatesClassResource extends Resource
{
    protected static ?string $model = PilatesClass::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Wellness';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return PilatesClassForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PilatesClassesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SchedulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPilatesClasses::route('/'),
            'create' => CreatePilatesClass::route('/create'),
            'edit' => EditPilatesClass::route('/{record}/edit'),
        ];
    }
}
