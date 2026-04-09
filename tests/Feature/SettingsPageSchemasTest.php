<?php

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use SamuelTerra22\FilamentPwa\Pages\PwaSettingsPage;

// ─── Style Schema ──────────────────────────────────────────────

test('style schema returns array with a Grid component', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getStyleSchema();

    expect($schema)->toBeArray()->toHaveCount(1);
    expect($schema[0])->toBeInstanceOf(Grid::class);
});

// ─── Icons Schema ──────────────────────────────────────────────

test('icons schema returns select for icon_purpose and a grid', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getIconsSchema();

    expect($schema)->toBeArray()->toHaveCount(2);

    expect($schema[0])->toBeInstanceOf(Select::class);
    expect($schema[0]->getName())->toBe('icon_purpose');

    expect($schema[1])->toBeInstanceOf(Grid::class);
});

// ─── Splash Schema ─────────────────────────────────────────────

test('splash schema returns array with a Grid component', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getSplashSchema();

    expect($schema)->toBeArray()->toHaveCount(1);
    expect($schema[0])->toBeInstanceOf(Grid::class);
});

// ─── Shortcuts Schema ──────────────────────────────────────────

test('shortcuts schema returns repeater named shortcuts', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getShortcutsSchema();

    expect($schema)->toBeArray()->toHaveCount(1);

    $repeater = $schema[0];

    expect($repeater)->toBeInstanceOf(Repeater::class);
    expect($repeater->getName())->toBe('shortcuts');
});

// ─── Advanced Schema ───────────────────────────────────────────

test('advanced schema returns array with a Grid component', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getAdvancedSchema();

    expect($schema)->toBeArray()->toHaveCount(1);
    expect($schema[0])->toBeInstanceOf(Grid::class);
});

// ─── Screenshots Schema ───────────────────────────────────────

test('screenshots schema returns repeater named screenshots', function () {
    $page = new PwaSettingsPage;
    $schema = invade($page)->getScreenshotsSchema();

    expect($schema)->toBeArray()->toHaveCount(1);

    $repeater = $schema[0];

    expect($repeater)->toBeInstanceOf(Repeater::class);
    expect($repeater->getName())->toBe('screenshots');
});

// ─── Form has Tabs ─────────────────────────────────────────────

test('settings page form method exists', function () {
    $page = new PwaSettingsPage;

    expect(method_exists($page, 'form'))->toBeTrue();
});
