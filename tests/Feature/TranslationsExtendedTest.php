<?php

// ─── Offline translations ──────────────────────────────────────

test('offline indicator translation exists', function () {
    expect(__('filament-pwa::messages.offline.indicator'))
        ->toBe('You are offline');
});

test('back_online translation exists', function () {
    expect(__('filament-pwa::messages.offline.back_online'))
        ->toBe('Back online');
});

// ─── Install translations ──────────────────────────────────────

test('install description translation exists', function () {
    expect(__('filament-pwa::messages.install.description'))
        ->toBe('Install this app on your device for quick access.');
});

test('install button translation exists', function () {
    expect(__('filament-pwa::messages.install.button'))
        ->toBe('Install');
});

test('install dismiss translation exists', function () {
    expect(__('filament-pwa::messages.install.dismiss'))
        ->toBe('Not now');
});

// ─── Update translations ──────────────────────────────────────

test('update message translation exists', function () {
    expect(__('filament-pwa::messages.update.message'))
        ->toBe('A new version is available.');
});

test('update button translation exists', function () {
    expect(__('filament-pwa::messages.update.button'))
        ->toBe('Refresh');
});

// ─── Section translations ──────────────────────────────────────

test('all section translations exist', function () {
    $sections = ['general', 'style', 'icons', 'splash', 'shortcuts', 'advanced', 'screenshots'];

    foreach ($sections as $section) {
        expect(__("filament-pwa::messages.sections.{$section}"))
            ->not->toBe("filament-pwa::messages.sections.{$section}");
    }
});

// ─── Form label translations ──────────────────────────────────

test('all form label translations exist', function () {
    $keys = [
        'app_name', 'short_name', 'start_url', 'background_color', 'theme_color',
        'status_bar', 'display', 'orientation', 'shortcuts', 'icon_purpose',
        'description', 'scope', 'id', 'lang', 'dir', 'categories',
        'display_override', 'screenshots', 'screenshot_image', 'screenshot_sizes',
        'screenshot_type', 'screenshot_form_factor', 'screenshot_label',
        'shortcut_name', 'shortcut_description', 'shortcut_url', 'shortcut_icon',
    ];

    foreach ($keys as $key) {
        expect(__("filament-pwa::messages.form.{$key}"))
            ->not->toBe("filament-pwa::messages.form.{$key}");
    }
});

// ─── Icon size translations with all sizes ─────────────────────

test('icon translations work with all 8 sizes', function () {
    $sizes = ['72x72', '96x96', '128x128', '144x144', '152x152', '192x192', '384x384', '512x512'];

    foreach ($sizes as $size) {
        $translation = __('filament-pwa::messages.form.icon', ['size' => $size]);

        expect($translation)
            ->toContain($size)
            ->not->toBe('filament-pwa::messages.form.icon');
    }
});

// ─── Splash translations with all sizes ────────────────────────

test('splash translations work with all 10 sizes', function () {
    $sizes = [
        '640x1136', '750x1334', '828x1792', '1125x2436', '1242x2208',
        '1242x2688', '1536x2048', '1668x2224', '1668x2388', '2048x2732',
    ];

    foreach ($sizes as $size) {
        $translation = __('filament-pwa::messages.form.splash', ['size' => $size]);

        expect($translation)
            ->toContain($size)
            ->not->toBe('filament-pwa::messages.form.splash');
    }
});

// ─── Missing translation key fallback ──────────────────────────

test('non-existent translation key returns raw key', function () {
    expect(__('filament-pwa::messages.nonexistent.key'))
        ->toBe('filament-pwa::messages.nonexistent.key');
});
