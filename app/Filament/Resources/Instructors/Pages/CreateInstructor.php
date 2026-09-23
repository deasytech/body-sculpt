<?php

namespace App\Filament\Resources\Instructors\Pages;

use App\Enums\StaffType;
use App\Filament\Resources\Instructors\InstructorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInstructor extends CreateRecord
{
    protected static string $resource = InstructorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = StaffType::Instructor;

        return $data;
    }
}
