<?php

namespace App\Filament\Support;

use Filament\Forms\Components\TextInput;

/**
 * Prices are stored in kobo (minor units) but edited in Naira in the admin —
 * this keeps that conversion in one place instead of repeating it per resource.
 */
class MoneyInput
{
    public static function make(string $name, ?string $label = null): TextInput
    {
        return TextInput::make($name)
            ->label($label ?? str($name)->replace('_', ' ')->title())
            ->numeric()
            ->prefix('₦')
            ->required()
            ->minValue(0)
            ->formatStateUsing(fn (?int $state) => $state !== null ? $state / 100 : null)
            ->dehydrateStateUsing(fn ($state) => (int) round(((float) $state) * 100));
    }
}
