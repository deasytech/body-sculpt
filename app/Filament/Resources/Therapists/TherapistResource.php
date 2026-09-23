<?php

namespace App\Filament\Resources\Therapists;

use App\Enums\StaffType;
use App\Filament\Resources\Staff\Schemas\StaffForm;
use App\Filament\Resources\Staff\Tables\StaffTable;
use App\Filament\Resources\Therapists\Pages\CreateTherapist;
use App\Filament\Resources\Therapists\Pages\EditTherapist;
use App\Filament\Resources\Therapists\Pages\ListTherapists;
use App\Models\Staff;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TherapistResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static string|\UnitEnum|null $navigationGroup = 'Wellness';

    protected static ?int $navigationSort = 26;

    protected static ?string $modelLabel = 'Therapist';

    protected static ?string $pluralModelLabel = 'Therapists';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', StaffType::Therapist);
    }

    public static function form(Schema $schema): Schema
    {
        return StaffForm::configure($schema, lockType: true);
    }

    public static function table(Table $table): Table
    {
        return StaffTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTherapists::route('/'),
            'create' => CreateTherapist::route('/create'),
            'edit' => EditTherapist::route('/{record}/edit'),
        ];
    }
}
