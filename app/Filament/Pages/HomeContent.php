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

class HomeContent extends Page
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.home-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Homepage Content';

    /** @var array<string, mixed> */
    public ?array $data = [];

    /**
     * Setting key => default value, used both to seed the form and as the
     * live fallback shown on the public site when a value is left blank.
     */
    public static function defaults(): array
    {
        return [
            'home_hero_heading' => "Relax your body.\nRecharge your spirit.",
            'home_hero_subheading' => 'Movement, recovery, beauty and self-care, thoughtfully brought together in one elevated wellness experience.',
            'home_hero_image' => null,
            'home_hero_cta_primary' => 'Book a Session',
            'home_hero_cta_secondary' => 'Explore Wellness',
            'home_tile_pilates_image' => null,
            'home_tile_recovery_image' => null,
            'home_tile_sculpt_image' => null,
            'home_tile_facials_image' => null,
            'home_tile_heat_recovery_image' => null,
            'home_pilates_heading' => 'Move with intention.',
            'home_wellness_heading' => 'Your body deserves a reset.',
            'home_wellness_tagline' => 'Move → Recover → Restore',
            'home_sculpt_heading' => 'Sculpt. Restore. Renew.',
            'home_facials_heading' => 'Glow from within.',
            'home_experience_heading' => 'A space to move, restore and reconnect.',
            'home_experience_copy' => 'Pilates, treatment rooms, sauna, steam, café, relaxation — every corner of the studio is designed to sell the experience, not just the service. Come for a class. Stay for the reset.',
            'home_experience_image_1' => null,
            'home_experience_image_2' => null,
            'home_membership_heading' => 'Make wellness a ritual.',
            'home_testimonials_heading' => 'What it feels like.',
            'home_cta_heading' => '"I want to be there."',
            'home_cta_copy' => 'A destination for modern wellness in Lagos — walk in, take a class, have a treatment, use the sauna, enjoy something healthy at the café, and leave feeling restored.',
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
                    ->icon(Heroicon::OutlinedPhoto)
                    ->schema([
                        Textarea::make('home_hero_heading')
                            ->label('Heading')
                            ->rows(2)
                            ->helperText('Use a new line for the line break shown on the homepage.')
                            ->columnSpanFull(),
                        Textarea::make('home_hero_subheading')
                            ->label('Subheading')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('home_hero_cta_primary')->label('Primary button label'),
                        TextInput::make('home_hero_cta_secondary')->label('Secondary button label'),
                        FileUpload::make('home_hero_image')
                            ->label('Background photo')
                            ->image()
                            ->imageEditor()
                            ->directory('site')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Services Grid')
                    ->description('The five tiles shown under "Five ways to restore." — leave a tile blank to use the default placeholder.')
                    ->icon(Heroicon::OutlinedSquares2x2)
                    ->schema([
                        FileUpload::make('home_tile_pilates_image')->label('Pilates')->image()->directory('site'),
                        FileUpload::make('home_tile_recovery_image')->label('Recovery')->image()->directory('site'),
                        FileUpload::make('home_tile_sculpt_image')->label('Sculpt')->image()->directory('site'),
                        FileUpload::make('home_tile_facials_image')->label('Facials')->image()->directory('site'),
                        FileUpload::make('home_tile_heat_recovery_image')->label('Heat & Recovery')->image()->directory('site'),
                    ])
                    ->columns(5),

                Section::make('Section Headings')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('home_pilates_heading')->label('Pilates preview heading'),
                        TextInput::make('home_wellness_heading')->label('Wellness Rituals heading'),
                        TextInput::make('home_wellness_tagline')->label('Wellness Rituals tagline'),
                        TextInput::make('home_sculpt_heading')->label('Sculpt heading'),
                        TextInput::make('home_facials_heading')->label('Facials heading'),
                        TextInput::make('home_membership_heading')->label('Membership heading'),
                        TextInput::make('home_testimonials_heading')->label('Testimonials heading'),
                    ])
                    ->columns(2),

                Section::make('The Body Sculpt Experience')
                    ->icon(Heroicon::OutlinedSparkles)
                    ->schema([
                        TextInput::make('home_experience_heading')->label('Heading')->columnSpanFull(),
                        Textarea::make('home_experience_copy')->label('Copy')->rows(3)->columnSpanFull(),
                        FileUpload::make('home_experience_image_1')->label('Photo 1')->image()->directory('site'),
                        FileUpload::make('home_experience_image_2')->label('Photo 2')->image()->directory('site'),
                    ])
                    ->columns(2),

                Section::make('Final Call to Action')
                    ->icon(Heroicon::OutlinedMegaphone)
                    ->schema([
                        TextInput::make('home_cta_heading')->label('Heading')->columnSpanFull(),
                        Textarea::make('home_cta_copy')->label('Copy')->rows(2)->columnSpanFull(),
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
            ->title('Homepage content saved')
            ->success()
            ->send();
    }
}
