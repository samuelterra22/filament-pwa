<?php

// ─── Config ─────────────────────────────────────────────────────

test('config file is loaded', function () {
    expect(config('filament-pwa'))->toBeArray();
});

test('config has middlewares key', function () {
    expect(config('filament-pwa.middlewares'))->toBeArray();
});

// ─── Views ──────────────────────────────────────────────────────

test('meta view exists', function () {
    expect(view()->exists('filament-pwa::meta'))->toBeTrue();
});

test('offline view exists', function () {
    expect(view()->exists('filament-pwa::offline'))->toBeTrue();
});

// ─── Translations ───────────────────────────────────────────────

test('english translations are loaded', function () {
    expect(__('filament-pwa::messages.settings.title'))
        ->toBe('Progressive Web App');
});

test('translation keys are not returned raw', function () {
    expect(__('filament-pwa::messages.settings.title'))
        ->not->toBe('filament-pwa::messages.settings.title');
});

test('form translations use size placeholder', function () {
    expect(__('filament-pwa::messages.form.icon', ['size' => '72x72']))
        ->toContain('72x72');
});

test('splash translations use size placeholder', function () {
    expect(__('filament-pwa::messages.form.splash', ['size' => '640x1136']))
        ->toContain('640x1136');
});
