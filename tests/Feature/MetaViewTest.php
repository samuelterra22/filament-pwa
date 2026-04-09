<?php

use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── Manifest Link ─────────────────────────────────────────────

test('meta view contains manifest link', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('rel="manifest"')
        ->toContain('manifest.json');
});

// ─── Theme Color ───────────────────────────────────────────────

test('meta view contains theme-color meta tag', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="theme-color" content="#000000"');
});

test('meta view reflects custom theme color', function () {
    $this->updateSetting('theme_color', '#ff5500');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="theme-color" content="#ff5500"');
});

// ─── mobile-web-app-capable ────────────────────────────────────

test('meta view shows mobile-web-app-capable yes for standalone display', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('name="mobile-web-app-capable" content="yes"')
        ->toContain('name="apple-mobile-web-app-capable" content="yes"');
});

test('meta view shows mobile-web-app-capable no for fullscreen display', function () {
    $this->updateSetting('display', 'fullscreen');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('name="mobile-web-app-capable" content="no"')
        ->toContain('name="apple-mobile-web-app-capable" content="no"');
});

test('meta view shows mobile-web-app-capable no for browser display', function () {
    $this->updateSetting('display', 'browser');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('name="mobile-web-app-capable" content="no"')
        ->toContain('name="apple-mobile-web-app-capable" content="no"');
});

test('meta view shows mobile-web-app-capable no for minimal-ui display', function () {
    $this->updateSetting('display', 'minimal-ui');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="mobile-web-app-capable" content="no"');
});

// ─── application-name ──────────────────────────────────────────

test('meta view contains application-name with short_name', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="application-name" content="Test"');
});

// ─── apple-mobile-web-app-title ────────────────────────────────

test('meta view contains apple-mobile-web-app-title', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="apple-mobile-web-app-title" content="Test"');
});

// ─── apple-mobile-web-app-status-bar-style ─────────────────────

test('meta view contains status bar style', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="apple-mobile-web-app-status-bar-style" content="#000000"');
});

// ─── msapplication tags ────────────────────────────────────────

test('meta view contains msapplication-TileColor', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="msapplication-TileColor" content="#ffffff"');
});

test('meta view contains msapplication-TileImage', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="msapplication-TileImage"');
});

// ─── Icon link tags ────────────────────────────────────────────

test('meta view contains rel icon link', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('rel="icon"');
});

test('meta view contains apple-touch-icon link', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('rel="apple-touch-icon"');
});

test('meta view icon uses last icon src from config', function () {
    $this->updateSetting('icons_512x512', 'pwa/icons/custom-512.png');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('/storage/pwa/icons/custom-512.png');
});

// ─── Apple Splash Screen links ─────────────────────────────────

test('meta view contains all 10 apple splash screen links', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain('rel="apple-touch-startup-image"')
        ->toContain('splash-640x1136.png')
        ->toContain('splash-750x1334.png')
        ->toContain('splash-828x1792.png')
        ->toContain('splash-1125x2436.png')
        ->toContain('splash-1242x2208.png')
        ->toContain('splash-1242x2688.png')
        ->toContain('splash-1536x2048.png')
        ->toContain('splash-1668x2224.png')
        ->toContain('splash-1668x2388.png')
        ->toContain('splash-2048x2732.png');
});

test('meta view splash links use custom paths when set', function () {
    $this->updateSetting('splash_640x1136', 'pwa/splash/custom-640.png');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('/storage/pwa/splash/custom-640.png');
});

// ─── Service Worker Registration ───────────────────────────────

test('meta view contains service worker registration script', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->toContain("navigator.serviceWorker.register('/serviceworker.js'")
        ->toContain("scope: '.'");
});

// ─── Theme Color in CSS ────────────────────────────────────────

test('meta view uses theme color in install banner CSS', function () {
    $this->updateSetting('theme_color', '#abcdef');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('background: #abcdef');
});

// ─── Install Prompt with default description ───────────────────

test('install prompt shows default description when no description set', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('Install this app on your device for quick access.');
});

test('install prompt shows custom description when set', function () {
    $this->updateSetting('description', 'My custom description');

    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('My custom description');
});

// ─── Install Prompt button labels ──────────────────────────────

test('install prompt contains dismiss button text', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('Not now');
});

test('install prompt contains install button text', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => true,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('Install');
});

// ─── Offline Indicator text ────────────────────────────────────

test('offline indicator contains back_online translation in JS', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => true,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('Back online');
});

// ─── Update Notification text ──────────────────────────────────

test('update notification contains message text', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => true,
    ])->render();

    expect($html)->toContain('A new version is available.');
});

test('update notification contains button text', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => true,
    ])->render();

    expect($html)->toContain('Refresh');
});

// ─── Feature flags default to true when not passed ─────────────

test('meta view renders install prompt when variable not passed (defaults to true)', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
    ])->render();

    expect($html)
        ->toContain('id="pwa-install-banner"')
        ->toContain('id="pwa-offline-banner"')
        ->toContain('id="pwa-update-banner"');
});

// ─── All features disabled renders minimal HTML ────────────────

test('meta view with all features disabled has no banners', function () {
    $config = ManifestService::generate();

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)
        ->not->toContain('id="pwa-install-banner"')
        ->not->toContain('id="pwa-offline-banner"')
        ->not->toContain('id="pwa-update-banner"')
        ->toContain('rel="manifest"')
        ->toContain('name="theme-color"');
});

// ─── Empty icons array edge case ───────────────────────────────

test('meta view handles config with empty icons array gracefully', function () {
    $config = ManifestService::generate();
    $config['icons'] = [];

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    // Should render without throwing, even if icon src is empty
    expect($html)
        ->toContain('rel="icon"')
        ->toContain('rel="apple-touch-icon"');
});

// ─── Null theme_color ──────────────────────────────────────────

test('meta view handles null theme_color without error', function () {
    $config = ManifestService::generate();
    $config['theme_color'] = null;

    $html = view('filament-pwa::meta', [
        'config' => $config,
        'installPrompt' => false,
        'offlineIndicator' => false,
        'updateNotification' => false,
    ])->render();

    expect($html)->toContain('name="theme-color"');
});
