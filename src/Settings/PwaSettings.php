<?php

namespace SamuelTerra22\FilamentPwa\Settings;

use Spatie\LaravelSettings\Settings;

class PwaSettings extends Settings
{
    public ?string $app_name;

    public ?string $short_name;

    public ?string $start_url;

    public ?string $background_color;

    public ?string $theme_color;

    public ?string $status_bar;

    public ?string $display;

    public ?string $orientation;

    public ?string $icons_72x72;

    public ?string $icons_96x96;

    public ?string $icons_128x128;

    public ?string $icons_144x144;

    public ?string $icons_152x152;

    public ?string $icons_192x192;

    public ?string $icons_384x384;

    public ?string $icons_512x512;

    public ?string $splash_640x1136;

    public ?string $splash_750x1334;

    public ?string $splash_828x1792;

    public ?string $splash_1125x2436;

    public ?string $splash_1242x2208;

    public ?string $splash_1242x2688;

    public ?string $splash_1536x2048;

    public ?string $splash_1668x2224;

    public ?string $splash_1668x2388;

    public ?string $splash_2048x2732;

    public ?array $shortcuts;

    // Extended manifest fields
    public ?string $description;

    public ?string $scope;

    public ?string $lang;

    public ?string $dir;

    public ?string $id;

    public ?array $categories;

    public ?array $display_override;

    public ?array $screenshots;

    public ?string $icon_purpose;

    public static function group(): string
    {
        return 'pwa';
    }
}
