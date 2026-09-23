<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GeneralSettings extends Page
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.general-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 20;

    protected static ?string $title = 'General Settings';

    /** @var array<string, mixed> */
    public ?array $data = [];

    private const KEYS = ['site_name', 'tagline', 'phone', 'email', 'careers_email', 'instagram_handle', 'instagram_url', 'pilates_drop_in_price'];

    public function mount(): void
    {
        $values = collect(self::KEYS)->mapWithKeys(fn (string $key) => [$key => Setting::get($key)]);

        $this->form->fill($values->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')->label('Site name')->required(),
                TextInput::make('tagline')->label('Tagline'),
                TextInput::make('phone')->label('Phone'),
                TextInput::make('email')->label('Email address')->email(),
                TextInput::make('careers_email')->label('Careers email address')->email(),
                TextInput::make('instagram_handle')->label('Instagram handle'),
                TextInput::make('instagram_url')->label('Instagram URL')->url(),
                TextInput::make('pilates_drop_in_price')
                    ->label('Pilates drop-in price (kobo)')
                    ->numeric()
                    ->helperText('Stored in kobo — e.g. 1500000 = ₦15,000.'),
            ])
            ->statePath('data')
            ->columns(2);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, (string) $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
