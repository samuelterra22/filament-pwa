<?php

namespace SamuelTerra22\FilamentPwa\Pages;

use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use SamuelTerra22\FilamentPwa\Services\ManifestService;
use SamuelTerra22\FilamentPwa\Settings\PwaSettings;

class PwaSettingsPage extends SettingsPage
{
    protected static string $settings = PwaSettings::class;

    protected static ?string $slug = 'pwa-settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?int $navigationSort = 99;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-pwa::messages.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-pwa::messages.navigation.label');
    }

    public function getTitle(): string
    {
        return __('filament-pwa::messages.settings.title');
    }

    public function getSubheading(): ?string
    {
        return __('filament-pwa::messages.settings.description');
    }

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('pwa-settings')
                ->tabs([
                    Tab::make(__('filament-pwa::messages.sections.general'))
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema($this->getGeneralSchema()),

                    Tab::make(__('filament-pwa::messages.sections.style'))
                        ->icon('heroicon-o-paint-brush')
                        ->schema($this->getStyleSchema()),

                    Tab::make(__('filament-pwa::messages.sections.icons'))
                        ->icon('heroicon-o-photo')
                        ->schema($this->getIconsSchema()),

                    Tab::make(__('filament-pwa::messages.sections.splash'))
                        ->icon('heroicon-o-device-phone-mobile')
                        ->schema($this->getSplashSchema()),

                    Tab::make(__('filament-pwa::messages.sections.shortcuts'))
                        ->icon('heroicon-o-link')
                        ->schema($this->getShortcutsSchema()),

                    Tab::make(__('filament-pwa::messages.sections.advanced'))
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->schema($this->getAdvancedSchema()),

                    Tab::make(__('filament-pwa::messages.sections.screenshots'))
                        ->icon('heroicon-o-camera')
                        ->schema($this->getScreenshotsSchema()),
                ])
                ->columnSpanFull()
                ->persistTabInQueryString(),
        ]);
    }

    protected function getGeneralSchema(): array
    {
        return [
            TextInput::make('app_name')
                ->label(__('filament-pwa::messages.form.app_name'))
                ->required()
                ->maxLength(255),

            TextInput::make('short_name')
                ->label(__('filament-pwa::messages.form.short_name'))
                ->required()
                ->maxLength(50),

            TextInput::make('start_url')
                ->label(__('filament-pwa::messages.form.start_url'))
                ->default('/'),
        ];
    }

    protected function getStyleSchema(): array
    {
        return [
            Grid::make(2)->schema([
                ColorPicker::make('background_color')
                    ->label(__('filament-pwa::messages.form.background_color'))
                    ->default('#ffffff'),

                ColorPicker::make('theme_color')
                    ->label(__('filament-pwa::messages.form.theme_color'))
                    ->default('#000000'),

                ColorPicker::make('status_bar')
                    ->label(__('filament-pwa::messages.form.status_bar'))
                    ->default('#000000'),

                Select::make('display')
                    ->label(__('filament-pwa::messages.form.display'))
                    ->options([
                        'standalone' => 'Standalone',
                        'fullscreen' => 'Fullscreen',
                        'minimal-ui' => 'Minimal UI',
                        'browser' => 'Browser',
                    ])
                    ->default('standalone'),

                Select::make('orientation')
                    ->label(__('filament-pwa::messages.form.orientation'))
                    ->options([
                        'any' => 'Any',
                        'portrait' => 'Portrait',
                        'landscape' => 'Landscape',
                        'portrait-primary' => 'Portrait Primary',
                        'portrait-secondary' => 'Portrait Secondary',
                        'landscape-primary' => 'Landscape Primary',
                        'landscape-secondary' => 'Landscape Secondary',
                    ])
                    ->default('any'),
            ]),
        ];
    }

    protected function getIconsSchema(): array
    {
        $fields = [];

        foreach (ManifestService::ICON_SIZES as $size) {
            $fields[] = FileUpload::make("icons_{$size}")
                ->label(__('filament-pwa::messages.form.icon', ['size' => $size]))
                ->acceptedFileTypes(['image/png'])
                ->visibility('public')
                ->directory('pwa/icons')
                ->columnSpan(1);
        }

        return [
            Select::make('icon_purpose')
                ->label(__('filament-pwa::messages.form.icon_purpose'))
                ->helperText(__('filament-pwa::messages.form.icon_purpose_help'))
                ->options([
                    'any' => 'Any',
                    'maskable' => 'Maskable',
                    'any maskable' => 'Any + Maskable',
                ])
                ->default('any'),

            Grid::make(2)->schema($fields),
        ];
    }

    protected function getSplashSchema(): array
    {
        $fields = [];

        foreach (ManifestService::SPLASH_SIZES as $size) {
            $fields[] = FileUpload::make("splash_{$size}")
                ->label(__('filament-pwa::messages.form.splash', ['size' => $size]))
                ->acceptedFileTypes(['image/png'])
                ->visibility('public')
                ->directory('pwa/splash')
                ->columnSpan(1);
        }

        return [
            Grid::make(2)->schema($fields),
        ];
    }

    protected function getAdvancedSchema(): array
    {
        return [
            Grid::make(2)->schema([
                Textarea::make('description')
                    ->label(__('filament-pwa::messages.form.description'))
                    ->helperText(__('filament-pwa::messages.form.description_help'))
                    ->rows(3)
                    ->columnSpan(2),

                TextInput::make('scope')
                    ->label(__('filament-pwa::messages.form.scope'))
                    ->helperText(__('filament-pwa::messages.form.scope_help'))
                    ->default('/'),

                TextInput::make('id')
                    ->label(__('filament-pwa::messages.form.id'))
                    ->helperText(__('filament-pwa::messages.form.id_help')),

                TextInput::make('lang')
                    ->label(__('filament-pwa::messages.form.lang'))
                    ->helperText(__('filament-pwa::messages.form.lang_help'))
                    ->placeholder('en-US'),

                Select::make('dir')
                    ->label(__('filament-pwa::messages.form.dir'))
                    ->options([
                        'auto' => 'Auto',
                        'ltr' => 'LTR (Left to Right)',
                        'rtl' => 'RTL (Right to Left)',
                    ])
                    ->default('auto'),

                TagsInput::make('categories')
                    ->label(__('filament-pwa::messages.form.categories'))
                    ->helperText(__('filament-pwa::messages.form.categories_help'))
                    ->placeholder('business, productivity')
                    ->columnSpan(2),

                TagsInput::make('display_override')
                    ->label(__('filament-pwa::messages.form.display_override'))
                    ->helperText(__('filament-pwa::messages.form.display_override_help'))
                    ->placeholder('window-controls-overlay, standalone')
                    ->columnSpan(2),
            ]),
        ];
    }

    protected function getScreenshotsSchema(): array
    {
        return [
            Repeater::make('screenshots')
                ->label(__('filament-pwa::messages.form.screenshots'))
                ->schema([
                    FileUpload::make('src')
                        ->label(__('filament-pwa::messages.form.screenshot_image'))
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                        ->visibility('public')
                        ->directory('pwa/screenshots')
                        ->required(),

                    TextInput::make('sizes')
                        ->label(__('filament-pwa::messages.form.screenshot_sizes'))
                        ->placeholder('1280x720')
                        ->required(),

                    Select::make('type')
                        ->label(__('filament-pwa::messages.form.screenshot_type'))
                        ->options([
                            'image/png' => 'PNG',
                            'image/jpeg' => 'JPEG',
                            'image/webp' => 'WebP',
                        ])
                        ->default('image/png'),

                    Select::make('form_factor')
                        ->label(__('filament-pwa::messages.form.screenshot_form_factor'))
                        ->options([
                            'narrow' => 'Narrow (mobile)',
                            'wide' => 'Wide (desktop)',
                        ]),

                    TextInput::make('label')
                        ->label(__('filament-pwa::messages.form.screenshot_label')),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->defaultItems(0)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['sizes'] ?? null),
        ];
    }

    protected function getShortcutsSchema(): array
    {
        return [
            Repeater::make('shortcuts')
                ->label(__('filament-pwa::messages.form.shortcuts'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('filament-pwa::messages.form.shortcut_name'))
                        ->required(),

                    Textarea::make('description')
                        ->label(__('filament-pwa::messages.form.shortcut_description')),

                    TextInput::make('url')
                        ->label(__('filament-pwa::messages.form.shortcut_url'))
                        ->url()
                        ->required(),

                    FileUpload::make('icon')
                        ->label(__('filament-pwa::messages.form.shortcut_icon'))
                        ->image()
                        ->visibility('public')
                        ->directory('pwa/shortcuts'),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->defaultItems(0)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
        ];
    }
}
