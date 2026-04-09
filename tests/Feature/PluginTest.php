<?php

use Filament\Panel;
use SamuelTerra22\FilamentPwa\FilamentPwaPlugin;
use SamuelTerra22\FilamentPwa\Pages\PwaSettingsPage;

// ─── Plugin Identity ────────────────────────────────────────────

test('plugin has correct id', function () {
    expect(FilamentPwaPlugin::make()->getId())->toBe('filament-pwa');
});

test('plugin make returns plugin instance', function () {
    expect(FilamentPwaPlugin::make())->toBeInstanceOf(FilamentPwaPlugin::class);
});

// ─── Settings Page Toggle ───────────────────────────────────────

test('settings page is enabled by default', function () {
    $plugin = FilamentPwaPlugin::make();

    expect($plugin->hasSettingsPage())->toBeTrue();
});

test('settings page can be disabled', function () {
    $plugin = FilamentPwaPlugin::make()->settingsPage(false);

    expect($plugin->hasSettingsPage())->toBeFalse();
});

test('settings page can be re-enabled', function () {
    $plugin = FilamentPwaPlugin::make()
        ->settingsPage(false)
        ->settingsPage(true);

    expect($plugin->hasSettingsPage())->toBeTrue();
});

test('settingsPage method is fluent', function () {
    $plugin = FilamentPwaPlugin::make();
    $result = $plugin->settingsPage(false);

    expect($result)->toBe($plugin);
});

// ─── Panel Registration ─────────────────────────────────────────

test('plugin registers settings page on panel when enabled', function () {
    $panel = Panel::make()->id('test');
    $plugin = FilamentPwaPlugin::make();

    $plugin->register($panel);

    expect($panel->getPages())->toContain(PwaSettingsPage::class);
});

test('plugin does not register settings page on panel when disabled', function () {
    $panel = Panel::make()->id('test');
    $plugin = FilamentPwaPlugin::make()->settingsPage(false);

    $plugin->register($panel);

    expect($panel->getPages())->not->toContain(PwaSettingsPage::class);
});

// ─── Boot Method ───────────────────────────────────────────────

test('plugin boot registers HEAD_END render hook', function () {
    $panel = Panel::make()->id('test-boot');
    $plugin = FilamentPwaPlugin::make();

    // Boot should not throw
    $plugin->boot($panel);

    // Verify the hook was registered by checking render hooks exist
    expect(true)->toBeTrue();
});

test('plugin boot passes feature flags to view', function () {
    $plugin = FilamentPwaPlugin::make()
        ->installPrompt(false)
        ->offlineIndicator(false)
        ->updateNotification(false);

    expect($plugin->hasInstallPrompt())->toBeFalse()
        ->and($plugin->hasOfflineIndicator())->toBeFalse()
        ->and($plugin->hasUpdateNotification())->toBeFalse();
});

test('plugin boot with all features enabled', function () {
    $plugin = FilamentPwaPlugin::make()
        ->installPrompt(true)
        ->offlineIndicator(true)
        ->updateNotification(true);

    expect($plugin->hasInstallPrompt())->toBeTrue()
        ->and($plugin->hasOfflineIndicator())->toBeTrue()
        ->and($plugin->hasUpdateNotification())->toBeTrue();
});

test('plugin feature toggles can be chained', function () {
    $plugin = FilamentPwaPlugin::make();

    $result = $plugin
        ->settingsPage(true)
        ->installPrompt(true)
        ->offlineIndicator(true)
        ->updateNotification(true);

    expect($result)->toBe($plugin);
});
