<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use App\Filament\Support\MoneyColumn;
use App\Models\ClassSchedule;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('booking_date', 'desc')
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('bookable.name')
                    ->label('Service')
                    ->getStateUsing(function ($record) {
                        if ($record->bookable_type === 'treatment') {
                            return $record->bookable?->name;
                        }

                        /** @var ClassSchedule|null $schedule */
                        $schedule = $record->bookable;

                        return $schedule ? $schedule->pilatesClass?->name.' — '.$schedule->dayName() : null;
                    }),
                TextColumn::make('staff.name')
                    ->label('Staff')
                    ->placeholder('—'),
                TextColumn::make('booking_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Time')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (BookingStatus $state) => $state->color()),
                MoneyColumn::make('price')
                    ->alignEnd(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(BookingStatus::class),
                Filter::make('booking_date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('booking_date', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('booking_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No bookings yet')
            ->emptyStateDescription('Bookings appear here once a client books online or one is added manually.')
            ->emptyStateIcon(Heroicon::OutlinedCalendarDays);
    }
}
