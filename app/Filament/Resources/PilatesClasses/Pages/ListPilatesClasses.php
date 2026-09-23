<?php

namespace App\Filament\Resources\PilatesClasses\Pages;

use App\Filament\Resources\PilatesClasses\PilatesClassResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPilatesClasses extends ListRecords
{
    protected static string $resource = PilatesClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
