<?php

use SamuelTerra22\FilamentPwa\FilamentPwaPlugin;
use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── Install Prompt HTML ───────────────────────────────────────

test('meta view contains install prompt banner by default', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('id="pwa-install-banner"')
        ->toContain('id="pwa-install-accept"')
        ->toContain('id="pwa-install-dismiss"')
        ->toContain('beforeinstallprompt');
});

test('meta view hides install prompt when disabled', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->not->toContain('id="pwa-install-banner"')
        ->not->toContain('beforeinstallprompt');
});

test('install prompt banner shows app name', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('Test App');
});

test('install prompt banner shows app description when set', function () {
    $this->updateSetting('description', 'My awesome app');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('My awesome app');
});

test('install prompt JS checks display-mode standalone', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('display-mode: standalone');
});

test('install prompt JS stores dismiss in localStorage', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('pwa-install-dismissed');
});

// ─── Plugin Toggle ─────────────────────────────────────────────

test('plugin install prompt is enabled by default', function () {
    expect(FilamentPwaPlugin::make()->hasInstallPrompt())->toBeTrue();
});

test('plugin install prompt can be disabled', function () {
    $plugin = FilamentPwaPlugin::make()->installPrompt(false);

    expect($plugin->hasInstallPrompt())->toBeFalse();
});

test('installPrompt method is fluent', function () {
    $plugin = FilamentPwaPlugin::make();
    $result = $plugin->installPrompt(false);

    expect($result)->toBe($plugin);
});
