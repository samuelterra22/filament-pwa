<?php

use SamuelTerra22\FilamentPwa\FilamentPwaPlugin;
use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── Update Notification HTML ──────────────────────────────────

test('meta view contains update notification by default', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => true,
    ])->render();

    expect($html)
        ->toContain('id="pwa-update-banner"')
        ->toContain('id="pwa-update-accept"');
});

test('meta view hides update notification when disabled', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->not->toContain('id="pwa-update-banner"')
        ->not->toContain('id="pwa-update-accept"');
});

test('update notification JS detects updatefound event', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => true,
    ])->render();

    expect($html)->toContain('updatefound');
});

test('update notification JS handles controllerchange', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => true,
    ])->render();

    expect($html)->toContain('controllerchange');
});

test('update notification JS sends SKIP_WAITING message', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => true,
    ])->render();

    expect($html)->toContain('SKIP_WAITING');
});

// ─── Service Worker SKIP_WAITING Handler ───────────────────────

test('service worker contains message event listener', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain("addEventListener('message'");
});

test('service worker handles SKIP_WAITING message', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain('SKIP_WAITING');
});

// ─── Plugin Toggle ─────────────────────────────────────────────

test('plugin update notification is enabled by default', function () {
    expect(FilamentPwaPlugin::make()->hasUpdateNotification())->toBeTrue();
});

test('plugin update notification can be disabled', function () {
    $plugin = FilamentPwaPlugin::make()->updateNotification(false);

    expect($plugin->hasUpdateNotification())->toBeFalse();
});

test('updateNotification method is fluent', function () {
    $plugin = FilamentPwaPlugin::make();
    $result = $plugin->updateNotification(false);

    expect($result)->toBe($plugin);
});
