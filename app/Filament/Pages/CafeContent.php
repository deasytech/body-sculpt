<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CafeContent extends Page
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.cafe-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCake;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static ?string $title = 'Café Page Content';

    /** @var array<string, mixed> */
    public ?array $data = [];

    public static function defaults(): array
    {
        return [
            'cafe_hero_heading' => 'Nourish your body.',
            'cafe_hero_copy' => 'Healthy drinks and food, served in the same calm space where you move and recover — part of the Body Sculpt lifestyle, not an afterthought.',
            'cafe_tile_1_label' => 'Drinks',
            'cafe_tile_1_image' => null,
            'cafe_tile_2_label' => 'Healthy Food',
            'cafe_tile_2_image' => null,
            'cafe_tile_3_label' => 'The Space',
            'cafe_tile_3_image' => null,
            'cafe_cta_heading' => 'Come for a class. Stay for a smoothie.',
        ];
    }

    public function mount(): void
    {
        $values = collect(self::defaults())
            ->mapWithKeys(fn (mixed $default, string $key) => [$key => Setting::get($key, $default)]);

        $this->form->fill($values->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('cafe_hero_heading')->label('Heading')->columnSpanFull(),
                        Textarea::make('cafe_hero_copy')->label('Copy')->rows(2)->columnSpanFull(),
                    ]),

                Section::make('Gallery Tiles')
                    ->description('Each tile falls back to an original illustration when left blank.')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->schema([
                        TextInput::make('cafe_tile_1_label')->label('Tile 1 label'),
                        FileUpload::make('cafe_tile_1_image')->label('Tile 1 photo')->image()->imageEditor()->directory('site'),
                        TextInput::make('cafe_tile_2_label')->label('Tile 2 label'),
                        FileUpload::make('cafe_tile_2_image')->label('Tile 2 photo')->image()->imageEditor()->directory('site'),
                        TextInput::make('cafe_tile_3_label')->label('Tile 3 label'),
                        FileUpload::make('cafe_tile_3_image')->label('Tile 3 photo')->image()->imageEditor()->directory('site'),
                    ])
                    ->columns(2),

                Section::make('Call to Action')
                    ->icon(Heroicon::OutlinedMegaphone)
                    ->schema([
                        TextInput::make('cafe_cta_heading')->label('Heading')->columnSpanFull(),
                    ]),
            ])
            ->statePath('data')
            ->columns(1);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, is_array($value) ? ($value[0] ?? '') : (string) ($value ?? ''));
        }

        Notification::make()
            ->title('Café page content saved')
            ->success()
            ->send();
    }
}
