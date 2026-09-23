<?php

namespace App\Filament\Support;

use Filament\Tables\Columns\TextColumn;

class MoneyColumn
{
    public static function make(string $name, ?string $label = null): TextColumn
    {
        return TextColumn::make($name)
            ->label($label ?? str($name)->replace('_', ' ')->title())
            ->formatStateUsing(fn (?int $state) => $state !== null ? '₦'.number_format($state / 100, 2) : '—')
            ->sortable();
    }
}
