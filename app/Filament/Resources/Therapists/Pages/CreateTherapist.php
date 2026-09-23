<?php

namespace App\Filament\Resources\Therapists\Pages;

use App\Enums\StaffType;
use App\Filament\Resources\Therapists\TherapistResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTherapist extends CreateRecord
{
    protected static string $resource = TherapistResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = StaffType::Therapist;

        return $data;
    }
}
