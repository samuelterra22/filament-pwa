<?php

use SamuelTerra22\FilamentPwa\FilamentPwaServiceProvider;

// ─── Package name ──────────────────────────────────────────────

test('service provider has correct package name', function () {
    expect(FilamentPwaServiceProvider::$name)->toBe('filament-pwa');
});

test('service provider has correct view namespace', function () {
    expect(FilamentPwaServiceProvider::$viewNamespace)->toBe('filament-pwa');
});

// ─── Migrations list ───────────────────────────────────────────

test('service provider returns correct migration names', function () {
    $provider = app(FilamentPwaServiceProvider::class, ['app' => app()]);
    $migrations = invade($provider)->getMigrations();

    expect($migrations)->toBe([
        'create_pwa_settings',
        'add_pwa_extended_settings',
    ]);
});

// ─── Asset package name ────────────────────────────────────────

test('service provider returns correct asset package name', function () {
    $provider = app(FilamentPwaServiceProvider::class, ['app' => app()]);
    $name = invade($provider)->getAssetPackageName();

    expect($name)->toBe('samuelterra22/filament-pwa');
});

// ─── Empty asset/icon/script arrays ────────────────────────────

test('service provider returns empty assets array', function () {
    $provider = app(FilamentPwaServiceProvider::class, ['app' => app()]);
    $assets = invade($provider)->getAssets();

    expect($assets)->toBeArray()->toBeEmpty();
});

test('service provider returns empty icons array', function () {
    $provider = app(FilamentPwaServiceProvider::class, ['app' => app()]);
    $icons = invade($provider)->getIcons();

    expect($icons)->toBeArray()->toBeEmpty();
});

test('service provider returns empty script data array', function () {
    $provider = app(FilamentPwaServiceProvider::class, ['app' => app()]);
    $data = invade($provider)->getScriptData();

    expect($data)->toBeArray()->toBeEmpty();
});

// ─── Config defaults ───────────────────────────────────────────

test('config default middlewares is web in production config file', function () {
    // Read the raw config file value (test env overrides to [])
    $configPath = __DIR__.'/../../config/filament-pwa.php';
    $config = require $configPath;

    expect($config['middlewares'])->toBe(['web']);
});

// ─── Routes are registered ─────────────────────────────────────

test('all three PWA routes are registered with correct names', function () {
    $routes = app('router')->getRoutes();

    expect($routes->getByName('pwa.manifest'))->not->toBeNull()
        ->and($routes->getByName('pwa.offline'))->not->toBeNull()
        ->and($routes->getByName('pwa.serviceworker'))->not->toBeNull();
});

test('all three PWA routes use GET method', function () {
    $routes = app('router')->getRoutes();

    foreach (['pwa.manifest', 'pwa.offline', 'pwa.serviceworker'] as $name) {
        $route = $routes->getByName($name);

        expect($route->methods())->toContain('GET');
    }
});
