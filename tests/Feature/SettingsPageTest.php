<?php

use SamuelTerra22\FilamentPwa\Pages\PwaSettingsPage;
use SamuelTerra22\FilamentPwa\Settings\PwaSettings;

// ─── Page Metadata ─────────────────────────────────────────────

test('settings page has correct slug', function () {
    expect(PwaSettingsPage::getSlug())->toBe('pwa-settings');
});

test('settings page navigation group uses translation', function () {
    expect(PwaSettingsPage::getNavigationGroup())->toBe('Settings');
});

test('settings page navigation label uses translation', function () {
    expect(PwaSettingsPage::getNavigationLabel())->toBe('PWA');
});

test('settings page navigation sort is 99', function () {
    expect(PwaSettingsPage::getNavigationSort())->toBe(99);
});

// ─── Page Configuration ────────────────────────────────────────

test('settings page uses PwaSettings model', function () {
    $reflection = new ReflectionClass(PwaSettingsPage::class);
    $property = $reflection->getProperty('settings');

    expect($property->getDefaultValue())->toBe(PwaSettings::class);
});

test('settings page has navigation icon', function () {
    $reflection = new ReflectionClass(PwaSettingsPage::class);
    $property = $reflection->getProperty('navigationIcon');

    expect($property->getDefaultValue())->toBe('heroicon-o-device-phone-mobile');
});

// ─── Title and Subheading ──────────────────────────────────────

test('settings page title uses translation', function () {
    $page = new PwaSettingsPage;

    expect($page->getTitle())->toBe('Progressive Web App');
});

test('settings page subheading uses translation', function () {
    $page = new PwaSettingsPage;

    expect($page->getSubheading())->toBe('Configure your Progressive Web App settings');
});

// ─── Schema Method Existence ───────────────────────────────────

test('settings page has getGeneralSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getGeneralSchema'))->toBeTrue();
});

test('settings page has getStyleSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getStyleSchema'))->toBeTrue();
});

test('settings page has getIconsSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getIconsSchema'))->toBeTrue();
});

test('settings page has getSplashSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getSplashSchema'))->toBeTrue();
});

test('settings page has getShortcutsSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getShortcutsSchema'))->toBeTrue();
});

test('settings page has getAdvancedSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getAdvancedSchema'))->toBeTrue();
});

test('settings page has getScreenshotsSchema method', function () {
    expect(method_exists(PwaSettingsPage::class, 'getScreenshotsSchema'))->toBeTrue();
});

// ─── General Schema Returns Array ──────────────────────────────

test('general schema returns array with expected fields', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getGeneralSchema();

    expect($schema)->toBeArray()->toHaveCount(3);

    $names = collect($schema)->map(fn ($field) => $field->getName())->toArray();
    expect($names)->toBe(['app_name', 'short_name', 'start_url']);
});
