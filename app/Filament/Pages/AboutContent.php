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

class AboutContent extends Page
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.about-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 7;

    protected static ?string $title = 'About Page Content';

    /** @var array<string, mixed> */
    public ?array $data = [];

    public static function defaults(): array
    {
        return [
            'about_hero_image' => 'treatments/recovery-massage.jpg',
            'about_hero_subheading' => 'A calming, premium space in Lekki Phase 1, Lagos, built around movement, recovery, beauty and self-care.',
            'about_story_heading' => 'Wellness, thoughtfully reimagined.',
            'about_story_image' => 'pilates-classes/reformer-beginner.jpg',
            'about_values_heading' => 'What we stand for.',
            'about_gallery_heading' => 'Life at the studio.',
            'about_gallery_image_1' => 'treatments/facials-hydrafacial.jpg',
            'about_gallery_image_2' => 'treatments/heat-recovery-sauna.jpg',
            'about_team_heading' => 'The people behind the practice.',
            'about_cta_heading' => 'Come experience it for yourself.',
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
                        Textarea::make('about_hero_subheading')->label('Subheading')->rows(2)->columnSpanFull(),
                        FileUpload::make('about_hero_image')->label('Background photo')->image()->imageEditor()->directory('site')->columnSpanFull(),
                    ]),

                Section::make('Our Story')
                    ->icon(Heroicon::OutlinedBookOpen)
                    ->schema([
                        TextInput::make('about_story_heading')->label('Heading')->columnSpanFull(),
                        FileUpload::make('about_story_image')->label('Photo')->image()->imageEditor()->directory('site')->columnSpanFull(),
                    ]),

                Section::make('Values')
                    ->icon(Heroicon::OutlinedSparkles)
                    ->schema([
                        TextInput::make('about_values_heading')->label('Heading')->columnSpanFull(),
                    ]),

                Section::make('Life at the Studio')
                    ->description('The gallery shown between the values and the team.')
                    ->icon(Heroicon::OutlinedSquares2x2)
                    ->schema([
                        TextInput::make('about_gallery_heading')->label('Heading')->columnSpanFull(),
                        FileUpload::make('about_gallery_image_1')->label('Photo 1')->image()->imageEditor()->directory('site'),
                        FileUpload::make('about_gallery_image_2')->label('Photo 2')->image()->imageEditor()->directory('site'),
                    ])
                    ->columns(2),

                Section::make('Team & Call to Action')
                    ->icon(Heroicon::OutlinedMegaphone)
                    ->schema([
                        TextInput::make('about_team_heading')->label('Team section heading')->columnSpanFull(),
                        TextInput::make('about_cta_heading')->label('Final CTA heading')->columnSpanFull(),
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
            ->title('About page content saved')
            ->success()
            ->send();
    }
}
