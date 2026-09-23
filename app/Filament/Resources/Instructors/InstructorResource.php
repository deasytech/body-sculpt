<?php

namespace App\Filament\Resources\Instructors;

use App\Enums\StaffType;
use App\Filament\Resources\Instructors\Pages\CreateInstructor;
use App\Filament\Resources\Instructors\Pages\EditInstructor;
use App\Filament\Resources\Instructors\Pages\ListInstructors;
use App\Filament\Resources\Staff\Schemas\StaffForm;
use App\Filament\Resources\Staff\Tables\StaffTable;
use App\Models\Staff;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InstructorResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|\UnitEnum|null $navigationGroup = 'Wellness';

    protected static ?int $navigationSort = 25;

    protected static ?string $modelLabel = 'Instructor';

    protected static ?string $pluralModelLabel = 'Instructors';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', StaffType::Instructor);
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
            'index' => ListInstructors::route('/'),
            'create' => CreateInstructor::route('/create'),
            'edit' => EditInstructor::route('/{record}/edit'),
        ];
    }
}
