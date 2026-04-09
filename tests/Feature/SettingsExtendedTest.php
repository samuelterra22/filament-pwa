<?php

use SamuelTerra22\FilamentPwa\Settings\PwaSettings;

// ─── New Settings Defaults ─────────────────────────────────────

test('description is empty string by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->description)->toBe('');
});

test('scope defaults to slash', function () {
    $settings = app(PwaSettings::class);

    expect($settings->scope)->toBe('/');
});

test('lang is empty string by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->lang)->toBe('');
});

test('dir defaults to auto', function () {
    $settings = app(PwaSettings::class);

    expect($settings->dir)->toBe('auto');
});

test('id is empty string by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->id)->toBe('');
});

test('categories is empty array by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->categories)->toBe([]);
});

test('display_override is empty array by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->display_override)->toBe([]);
});

test('screenshots is empty array by default', function () {
    $settings = app(PwaSettings::class);

    expect($settings->screenshots)->toBe([]);
});

test('icon_purpose defaults to any', function () {
    $settings = app(PwaSettings::class);

    expect($settings->icon_purpose)->toBe('any');
});

// ─── Settings Update ───────────────────────────────────────────

test('description reflects database updates', function () {
    $this->updateSetting('description', 'Updated description');

    expect(app(PwaSettings::class)->description)->toBe('Updated description');
});

test('icon_purpose reflects database updates', function () {
    $this->updateSetting('icon_purpose', 'maskable');

    expect(app(PwaSettings::class)->icon_purpose)->toBe('maskable');
});

test('categories reflects database updates', function () {
    $this->updateSetting('categories', ['business', 'productivity']);

    expect(app(PwaSettings::class)->categories)->toBe(['business', 'productivity']);
});

test('screenshots reflects database updates', function () {
    $screenshots = [
        ['src' => 'test.png', 'sizes' => '1280x720', 'type' => 'image/png', 'form_factor' => 'wide', 'label' => 'Test'],
    ];
    $this->updateSetting('screenshots', $screenshots);

    expect(app(PwaSettings::class)->screenshots)->toBe($screenshots);
});
