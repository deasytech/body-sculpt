<?php

namespace App\Filament\Resources\PilatesClasses\Pages;

use App\Filament\Resources\PilatesClasses\PilatesClassResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPilatesClass extends EditRecord
{
    protected static string $resource = PilatesClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
