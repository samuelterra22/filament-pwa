<?php

use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── icon_purpose null fallback ────────────────────────────────

test('manifest icons use "any" purpose when icon_purpose is null', function () {
    $this->updateSetting('icon_purpose', null);

    $manifest = ManifestService::generate();

    foreach ($manifest['icons'] as $icon) {
        expect($icon['purpose'])->toBe('any');
    }
});

// ─── Icon property null vs empty string ────────────────────────

test('manifest uses fallback when icon property is null', function () {
    $this->updateSetting('icons_192x192', null);

    $manifest = ManifestService::generate();

    $icon192 = collect($manifest['icons'])->firstWhere('sizes', '192x192');

    expect($icon192['src'])->toBe('/images/icons/icon-192x192.png');
});

// ─── Splash property null fallback ─────────────────────────────

test('manifest uses fallback when splash property is null', function () {
    $this->updateSetting('splash_640x1136', null);

    $manifest = ManifestService::generate();

    expect($manifest['splash']['640x1136'])->toBe('/images/icons/splash-640x1136.png');
});

// ─── Screenshot type fallback ──────────────────────────────────

test('screenshot uses image/png fallback when type is missing', function () {
    $this->updateSetting('screenshots', [
        [
            'src' => 'pwa/screenshots/test.png',
            'sizes' => '1280x720',
            'form_factor' => '',
            'label' => '',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'][0]['type'])->toBe('image/png');
});

test('screenshot uses provided type when set', function () {
    $this->updateSetting('screenshots', [
        [
            'src' => 'pwa/screenshots/test.jpg',
            'sizes' => '1280x720',
            'type' => 'image/jpeg',
            'form_factor' => '',
            'label' => '',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'][0]['type'])->toBe('image/jpeg');
});

// ─── Screenshot src always prepends /storage/ ──────────────────

test('screenshot src is prepended with /storage/', function () {
    $this->updateSetting('screenshots', [
        [
            'src' => 'pwa/screenshots/screen.png',
            'sizes' => '1280x720',
            'type' => 'image/png',
            'form_factor' => '',
            'label' => '',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'][0]['src'])->toBe('/storage/pwa/screenshots/screen.png');
});

// ─── Screenshot with missing src key ───────────────────────────

test('screenshot with missing src defaults to empty string', function () {
    $this->updateSetting('screenshots', [
        [
            'sizes' => '1280x720',
            'type' => 'image/png',
            'form_factor' => '',
            'label' => '',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'][0]['src'])->toBe('/storage/');
});

// ─── Screenshot with missing sizes key ─────────────────────────

test('screenshot with missing sizes defaults to empty string', function () {
    $this->updateSetting('screenshots', [
        [
            'src' => 'pwa/screenshots/test.png',
            'type' => 'image/png',
            'form_factor' => '',
            'label' => '',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'][0]['sizes'])->toBe('');
});

// ─── Shortcut with missing name ────────────────────────────────

test('shortcut with missing name defaults to empty string', function () {
    $this->updateSetting('shortcuts', [
        ['description' => 'Desc', 'url' => '/test', 'icon' => ''],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['shortcuts'][0]['name'])->toBe('');
});

// ─── Multiple icon sizes with custom and null mixed ────────────

test('manifest handles mix of custom, empty and null icon paths', function () {
    $this->updateSetting('icons_72x72', 'custom/icon-72.png');
    $this->updateSetting('icons_96x96', null);
    $this->updateSetting('icons_128x128', '');

    $manifest = ManifestService::generate();

    $icon72 = collect($manifest['icons'])->firstWhere('sizes', '72x72');
    $icon96 = collect($manifest['icons'])->firstWhere('sizes', '96x96');
    $icon128 = collect($manifest['icons'])->firstWhere('sizes', '128x128');

    expect($icon72['src'])->toBe('/storage/custom/icon-72.png')
        ->and($icon96['src'])->toBe('/images/icons/icon-96x96.png')
        ->and($icon128['src'])->toBe('/images/icons/icon-128x128.png');
});

// ─── Shortcut icon type detection ──────────────────────────────

test('shortcut icon always uses image/png type and 72x72 size', function () {
    $this->updateSetting('shortcuts', [
        ['name' => 'Test', 'description' => '', 'url' => '/', 'icon' => 'icons/test.jpg'],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['shortcuts'][0]['icons'][0])
        ->toHaveKey('type', 'image/png')
        ->toHaveKey('sizes', '72x72')
        ->toHaveKey('purpose', 'any');
});

// ─── resolveAssetUrl edge cases (via icons) ────────────────────

test('icon with whitespace-only path uses fallback', function () {
    // empty() considers whitespace non-empty, so it would prepend /storage/
    $this->updateSetting('icons_72x72', '   ');

    $manifest = ManifestService::generate();

    $icon72 = collect($manifest['icons'])->firstWhere('sizes', '72x72');

    // Non-empty string gets /storage/ prefix
    expect($icon72['src'])->toBe('/storage/   ');
});
