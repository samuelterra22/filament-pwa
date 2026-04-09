<?php

use SamuelTerra22\FilamentPwa\Settings\PwaSettings;

// ─── Settings Group ─────────────────────────────────────────────

test('settings group is pwa', function () {
    expect(PwaSettings::group())->toBe('pwa');
});

// ─── Settings Load from Database ────────────────────────────────

test('settings loads seeded values', function () {
    $settings = app(PwaSettings::class);

    expect($settings->app_name)->toBe('Test App')
        ->and($settings->short_name)->toBe('Test')
        ->and($settings->start_url)->toBe('/')
        ->and($settings->display)->toBe('standalone')
        ->and($settings->orientation)->toBe('any')
        ->and($settings->theme_color)->toBe('#000000')
        ->and($settings->background_color)->toBe('#ffffff')
        ->and($settings->status_bar)->toBe('#000000');
});

test('icon settings are empty strings by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->icons_72x72)->toBe('')
        ->and($settings->icons_512x512)->toBe('');
});

test('splash settings are empty strings by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->splash_640x1136)->toBe('')
        ->and($settings->splash_2048x2732)->toBe('');
});

test('shortcuts is empty array by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->shortcuts)->toBe([]);
});

// ─── Settings Update ────────────────────────────────────────────

test('settings reflect database updates', function () {
    $this->updateSetting('app_name', 'New Name');

    $settings = app(PwaSettings::class);

    expect($settings->app_name)->toBe('New Name');
});
