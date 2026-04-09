<?php

use Filament\Panel;
use SamuelTerra22\FilamentPwa\FilamentPwaPlugin;
use SamuelTerra22\FilamentPwa\Pages\PwaSettingsPage;

// ─── Register twice does not duplicate ─────────────────────────

test('plugin register called twice does not duplicate settings page', function () {
    $panel = Panel::make()->id('test-double');
    $plugin = FilamentPwaPlugin::make();

    $plugin->register($panel);
    $plugin->register($panel);

    $pages = collect($panel->getPages())->filter(fn ($p) => $p === PwaSettingsPage::class);

    // Filament deduplicates pages — only one instance is kept
    expect($pages)->toHaveCount(1);
});

// ─── Feature flags default states ──────────────────────────────

test('plugin all feature flags are true by default', function () {
    $plugin = FilamentPwaPlugin::make();

    expect($plugin->hasSettingsPage())->toBeTrue()
        ->and($plugin->hasInstallPrompt())->toBeTrue()
        ->and($plugin->hasOfflineIndicator())->toBeTrue()
        ->and($plugin->hasUpdateNotification())->toBeTrue();
});

test('plugin all feature flags can be disabled', function () {
    $plugin = FilamentPwaPlugin::make()
        ->settingsPage(false)
        ->installPrompt(false)
        ->offlineIndicator(false)
        ->updateNotification(false);

    expect($plugin->hasSettingsPage())->toBeFalse()
        ->and($plugin->hasInstallPrompt())->toBeFalse()
        ->and($plugin->hasOfflineIndicator())->toBeFalse()
        ->and($plugin->hasUpdateNotification())->toBeFalse();
});

// ─── Plugin getId ──────────────────────────────────────────────

test('plugin getId is consistent across instances', function () {
    $plugin1 = FilamentPwaPlugin::make();
    $plugin2 = FilamentPwaPlugin::make();

    expect($plugin1->getId())->toBe($plugin2->getId())
        ->and($plugin1->getId())->toBe('filament-pwa');
});

// ─── Boot does not throw with different feature combinations ───

test('plugin boot with all features disabled does not throw', function () {
    $panel = Panel::make()->id('test-boot-none');
    $plugin = FilamentPwaPlugin::make()
        ->installPrompt(false)
        ->offlineIndicator(false)
        ->updateNotification(false);

    $plugin->boot($panel);

    expect(true)->toBeTrue();
});

test('plugin boot with only install prompt enabled does not throw', function () {
    $panel = Panel::make()->id('test-boot-install');
    $plugin = FilamentPwaPlugin::make()
        ->installPrompt(true)
        ->offlineIndicator(false)
        ->updateNotification(false);

    $plugin->boot($panel);

    expect(true)->toBeTrue();
});

// ─── Register with disabled settings page ──────────────────────

test('plugin with disabled settings page registers no pages', function () {
    $panel = Panel::make()->id('test-no-pages');
    $plugin = FilamentPwaPlugin::make()->settingsPage(false);

    $plugin->register($panel);

    expect($panel->getPages())->not->toContain(PwaSettingsPage::class);
});
