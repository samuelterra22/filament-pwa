<?php

use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── Description ───────────────────────────────────────────────

test('manifest does not include description when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('description');
});

test('manifest includes description when set', function () {
    $this->updateSetting('description', 'A powerful admin panel');

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('description')
        ->and($manifest['description'])->toBe('A powerful admin panel');
});

// ─── Scope ─────────────────────────────────────────────────────

test('manifest includes scope when set', function () {
    $this->updateSetting('scope', '/admin');

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('scope')
        ->and($manifest['scope'])->toBe('/admin');
});

test('manifest includes default scope', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('scope')
        ->and($manifest['scope'])->toBe('/');
});

// ─── Language ──────────────────────────────────────────────────

test('manifest does not include lang when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('lang');
});

test('manifest includes lang when set', function () {
    $this->updateSetting('lang', 'pt-BR');

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('lang')
        ->and($manifest['lang'])->toBe('pt-BR');
});

// ─── Text Direction ────────────────────────────────────────────

test('manifest includes dir when set to ltr', function () {
    $this->updateSetting('dir', 'ltr');

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('dir')
        ->and($manifest['dir'])->toBe('ltr');
});

test('manifest includes dir when set to rtl', function () {
    $this->updateSetting('dir', 'rtl');

    $manifest = ManifestService::generate();

    expect($manifest['dir'])->toBe('rtl');
});

test('manifest includes dir when set to auto', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('dir')
        ->and($manifest['dir'])->toBe('auto');
});

// ─── App ID ────────────────────────────────────────────────────

test('manifest does not include id when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('id');
});

test('manifest includes id when set', function () {
    $this->updateSetting('id', 'com.example.myapp');

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('id')
        ->and($manifest['id'])->toBe('com.example.myapp');
});

// ─── Categories ────────────────────────────────────────────────

test('manifest does not include categories when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('categories');
});

test('manifest includes categories when set', function () {
    $this->updateSetting('categories', ['business', 'productivity']);

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('categories')
        ->and($manifest['categories'])->toBe(['business', 'productivity']);
});

// ─── Display Override ──────────────────────────────────────────

test('manifest does not include display_override when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('display_override');
});

test('manifest includes display_override when set', function () {
    $this->updateSetting('display_override', ['window-controls-overlay', 'standalone']);

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('display_override')
        ->and($manifest['display_override'])->toBe(['window-controls-overlay', 'standalone']);
});

// ─── Maskable Icons ────────────────────────────────────────────

test('manifest icons use default purpose any', function () {
    $manifest = ManifestService::generate();

    foreach ($manifest['icons'] as $icon) {
        expect($icon['purpose'])->toBe('any');
    }
});

test('manifest icons use maskable purpose when configured', function () {
    $this->updateSetting('icon_purpose', 'maskable');

    $manifest = ManifestService::generate();

    foreach ($manifest['icons'] as $icon) {
        expect($icon['purpose'])->toBe('maskable');
    }
});

test('manifest icons use any maskable purpose when configured', function () {
    $this->updateSetting('icon_purpose', 'any maskable');

    $manifest = ManifestService::generate();

    foreach ($manifest['icons'] as $icon) {
        expect($icon['purpose'])->toBe('any maskable');
    }
});

// ─── Screenshots ───────────────────────────────────────────────

test('manifest does not include screenshots when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('screenshots');
});

test('manifest includes screenshots when configured', function () {
    $this->updateSetting('screenshots', [
        [
            'src' => 'pwa/screenshots/desktop.png',
            'sizes' => '1280x720',
            'type' => 'image/png',
            'form_factor' => 'wide',
            'label' => 'Dashboard view',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('screenshots')
        ->and($manifest['screenshots'])->toHaveCount(1)
        ->and($manifest['screenshots'][0]['src'])->toBe('/storage/pwa/screenshots/desktop.png')
        ->and($manifest['screenshots'][0]['sizes'])->toBe('1280x720')
        ->and($manifest['screenshots'][0]['type'])->toBe('image/png')
        ->and($manifest['screenshots'][0]['form_factor'])->toBe('wide')
        ->and($manifest['screenshots'][0]['label'])->toBe('Dashboard view');
});

test('screenshot without form_factor omits the field', function () {
    $this->updateSetting('screenshots', [
        [
            'src' => 'pwa/screenshots/mobile.png',
            'sizes' => '750x1334',
            'type' => 'image/png',
            'form_factor' => '',
            'label' => '',
        ],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'][0])->not->toHaveKey('form_factor')
        ->and($manifest['screenshots'][0])->not->toHaveKey('label');
});

test('multiple screenshots are all included', function () {
    $this->updateSetting('screenshots', [
        ['src' => 'pwa/screenshots/1.png', 'sizes' => '1280x720', 'type' => 'image/png', 'form_factor' => 'wide', 'label' => 'Home'],
        ['src' => 'pwa/screenshots/2.png', 'sizes' => '750x1334', 'type' => 'image/png', 'form_factor' => 'narrow', 'label' => 'Mobile'],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['screenshots'])->toHaveCount(2);
});

// ─── Manifest Endpoint with Extended Fields ────────────────────

test('manifest endpoint includes extended fields in JSON response', function () {
    $this->updateSetting('description', 'My PWA App');
    $this->updateSetting('lang', 'en-US');
    $this->updateSetting('categories', ['business']);

    $response = $this->get('/manifest.json');

    $response->assertJson([
        'description' => 'My PWA App',
        'lang' => 'en-US',
        'categories' => ['business'],
    ]);
});
