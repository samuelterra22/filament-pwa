<?php

use SamuelTerra22\FilamentPwa\FilamentPwaPlugin;
use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── Offline Indicator HTML ────────────────────────────────────

test('meta view contains offline indicator by default', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => true,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('id="pwa-offline-banner"')
        ->toContain('id="pwa-offline-text"');
});

test('meta view hides offline indicator when disabled', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->not->toContain('id="pwa-offline-banner"')
        ->not->toContain('id="pwa-offline-text"');
});

test('offline indicator JS listens to offline event', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => true,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain("addEventListener('offline'")
        ->toContain("addEventListener('online'");
});

test('offline indicator JS checks navigator.onLine on load', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => true,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('navigator.onLine');
});

// ─── Plugin Toggle ─────────────────────────────────────────────

test('plugin offline indicator is enabled by default', function () {
    expect(FilamentPwaPlugin::make()->hasOfflineIndicator())->toBeTrue();
});

test('plugin offline indicator can be disabled', function () {
    $plugin = FilamentPwaPlugin::make()->offlineIndicator(false);

    expect($plugin->hasOfflineIndicator())->toBeFalse();
});

test('offlineIndicator method is fluent', function () {
    $plugin = FilamentPwaPlugin::make();
    $result = $plugin->offlineIndicator(false);

    expect($result)->toBe($plugin);
});
