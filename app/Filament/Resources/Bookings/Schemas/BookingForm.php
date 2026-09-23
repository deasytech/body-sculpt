<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\BookingStatus;
use App\Filament\Support\MoneyInput;
use App\Models\ClassSchedule;
use App\Models\Treatment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Customer & Service')
                    ->icon(Heroicon::OutlinedUserCircle)
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('bookable_type')
                            ->label('Booking type')
                            ->options([
                                'treatment' => 'Treatment / Ritual',
                                'class_schedule' => 'Pilates Class',
                            ])
                            ->live()
                            ->required(),
                        Select::make('bookable_id')
                            ->label('Service')
                            ->options(function (Get $get) {
                                return match ($get('bookable_type')) {
                                    'treatment' => Treatment::query()->active()->pluck('name', 'id'),
                                    'class_schedule' => ClassSchedule::query()->with('pilatesClass')->active()->get()
                                        ->mapWithKeys(fn (ClassSchedule $s) => [$s->id => "{$s->pilatesClass->name} — {$s->dayName()} {$s->start_time}"]),
                                    default => [],
                                };
                            })
                            ->searchable()
                            ->required(),
                        Select::make('staff_id')
                            ->label('Assigned staff')
                            ->relationship('staff', 'name', modifyQueryUsing: fn ($query) => $query->active())
                            ->searchable()
                            ->helperText('Required for treatments; leave blank for Pilates classes.'),
                    ])
                    ->columns(2),
                Section::make('Schedule')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->schema([
                        DatePicker::make('booking_date')
                            ->required(),
                        TimePicker::make('start_time')
                            ->seconds(false)
                            ->required(),
                        TimePicker::make('end_time')
                            ->seconds(false)
                            ->required(),
                    ])
                    ->columns(3),
                Section::make('Status & Payment')
                    ->icon(Heroicon::OutlinedCreditCard)
                    ->schema([
                        Select::make('status')
                            ->options(BookingStatus::class)
                            ->default('pending')
                            ->required(),
                        MoneyInput::make('price'),
                        DateTimePicker::make('cancelled_at')
                            ->seconds(false),
                    ])
                    ->columns(3),
                Section::make('Notes')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->schema([
                        Textarea::make('notes')
                            ->label('')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
