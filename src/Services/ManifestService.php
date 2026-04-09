<?php

namespace SamuelTerra22\FilamentPwa\Services;

use SamuelTerra22\FilamentPwa\Settings\PwaSettings;

class ManifestService
{
    public const ICON_SIZES = [
        '72x72',
        '96x96',
        '128x128',
        '144x144',
        '152x152',
        '192x192',
        '384x384',
        '512x512',
    ];

    public const SPLASH_SIZES = [
        '640x1136',
        '750x1334',
        '828x1792',
        '1125x2436',
        '1242x2208',
        '1242x2688',
        '1536x2048',
        '1668x2224',
        '1668x2388',
        '2048x2732',
    ];

    public static function generate(): array
    {
        $settings = app(PwaSettings::class);

        $manifest = [
            'name' => $settings->app_name,
            'short_name' => $settings->short_name,
            'start_url' => $settings->start_url ?? '/',
            'display' => $settings->display ?? 'standalone',
            'theme_color' => $settings->theme_color ?? '#000000',
            'background_color' => $settings->background_color ?? '#ffffff',
            'orientation' => $settings->orientation ?? 'any',
            'status_bar' => $settings->status_bar ?? '#000000',
            'icons' => self::buildIcons($settings),
            'splash' => self::buildSplashScreens($settings),
        ];

        if (! empty($settings->description)) {
            $manifest['description'] = $settings->description;
        }

        if (! empty($settings->scope)) {
            $manifest['scope'] = $settings->scope;
        }

        if (! empty($settings->lang)) {
            $manifest['lang'] = $settings->lang;
        }

        if (! empty($settings->dir)) {
            $manifest['dir'] = $settings->dir;
        }

        if (! empty($settings->id)) {
            $manifest['id'] = $settings->id;
        }

        if (! empty($settings->categories)) {
            $manifest['categories'] = $settings->categories;
        }

        if (! empty($settings->display_override)) {
            $manifest['display_override'] = $settings->display_override;
        }

        if (! empty($settings->shortcuts)) {
            $manifest['shortcuts'] = self::buildShortcuts($settings->shortcuts);
        }

        if (! empty($settings->screenshots)) {
            $manifest['screenshots'] = self::buildScreenshots($settings->screenshots);
        }

        return $manifest;
    }

    protected static function buildIcons(PwaSettings $settings): array
    {
        $icons = [];
        $purpose = $settings->icon_purpose ?? 'any';

        foreach (self::ICON_SIZES as $size) {
            $property = 'icons_'.$size;
            $customPath = $settings->{$property} ?? '';

            $icons[] = [
                'src' => self::resolveAssetUrl($customPath, "images/icons/icon-{$size}.png"),
                'type' => 'image/png',
                'sizes' => $size,
                'purpose' => $purpose,
            ];
        }

        return $icons;
    }

    protected static function buildSplashScreens(PwaSettings $settings): array
    {
        $splash = [];

        foreach (self::SPLASH_SIZES as $size) {
            $property = 'splash_'.$size;
            $customPath = $settings->{$property} ?? '';

            $splash[$size] = self::resolveAssetUrl($customPath, "images/icons/splash-{$size}.png");
        }

        return $splash;
    }

    protected static function buildShortcuts(array $shortcuts): array
    {
        return collect($shortcuts)->map(function (array $shortcut) {
            $item = [
                'name' => $shortcut['name'] ?? '',
                'description' => $shortcut['description'] ?? '',
                'url' => $shortcut['url'] ?? '/',
            ];

            if (! empty($shortcut['icon'])) {
                $item['icons'] = [[
                    'src' => '/storage/'.$shortcut['icon'],
                    'type' => 'image/png',
                    'sizes' => '72x72',
                    'purpose' => 'any',
                ]];
            }

            return $item;
        })->all();
    }

    protected static function buildScreenshots(array $screenshots): array
    {
        return collect($screenshots)->map(function (array $screenshot) {
            $item = [
                'src' => '/storage/'.($screenshot['src'] ?? ''),
                'sizes' => $screenshot['sizes'] ?? '',
                'type' => $screenshot['type'] ?? 'image/png',
            ];

            if (! empty($screenshot['form_factor'])) {
                $item['form_factor'] = $screenshot['form_factor'];
            }

            if (! empty($screenshot['label'])) {
                $item['label'] = $screenshot['label'];
            }

            return $item;
        })->all();
    }

    protected static function resolveAssetUrl(string $customPath, string $fallbackPath): string
    {
        if (! empty($customPath)) {
            return '/storage/'.$customPath;
        }

        return '/'.$fallbackPath;
    }
}
