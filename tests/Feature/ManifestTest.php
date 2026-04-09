<?php

use SamuelTerra22\FilamentPwa\Services\ManifestService;

// ─── Happy Paths ────────────────────────────────────────────────

test('manifest endpoint returns valid JSON with correct content type', function () {
    $response = $this->get('/manifest.json');

    $response->assertStatus(200)
        ->assertHeader('Content-Type', 'application/json')
        ->assertJsonStructure([
            'name',
            'short_name',
            'start_url',
            'display',
            'theme_color',
            'background_color',
            'orientation',
            'status_bar',
            'icons',
            'splash',
        ]);
});

test('manifest service generates complete structure', function () {
    $manifest = ManifestService::generate();

    expect($manifest)
        ->toBeArray()
        ->toHaveKeys([
            'name', 'short_name', 'start_url', 'display',
            'theme_color', 'background_color', 'orientation',
            'status_bar', 'icons', 'splash',
        ]);
});

test('manifest uses seeded settings values', function () {
    $manifest = ManifestService::generate();

    expect($manifest['name'])->toBe('Test App')
        ->and($manifest['short_name'])->toBe('Test')
        ->and($manifest['start_url'])->toBe('/')
        ->and($manifest['display'])->toBe('standalone')
        ->and($manifest['theme_color'])->toBe('#000000')
        ->and($manifest['background_color'])->toBe('#ffffff')
        ->and($manifest['orientation'])->toBe('any')
        ->and($manifest['status_bar'])->toBe('#000000');
});

test('manifest includes all 8 icon sizes', function () {
    $manifest = ManifestService::generate();

    expect($manifest['icons'])->toHaveCount(8);

    $iconSizes = collect($manifest['icons'])->pluck('sizes')->toArray();

    expect($iconSizes)->toBe(ManifestService::ICON_SIZES);
});

test('manifest includes all 10 splash sizes', function () {
    $manifest = ManifestService::generate();

    expect($manifest['splash'])->toHaveCount(10)
        ->toHaveKeys(ManifestService::SPLASH_SIZES);
});

test('manifest icons have correct structure', function () {
    $manifest = ManifestService::generate();

    foreach ($manifest['icons'] as $icon) {
        expect($icon)
            ->toHaveKeys(['src', 'type', 'sizes', 'purpose'])
            ->and($icon['type'])->toBe('image/png')
            ->and($icon['purpose'])->toBe('any');
    }
});

test('manifest uses fallback icon paths when no custom icons set', function () {
    $manifest = ManifestService::generate();

    foreach ($manifest['icons'] as $icon) {
        expect($icon['src'])->toStartWith('/images/icons/icon-')
            ->and($icon['src'])->toEndWith('.png');
    }
});

test('manifest uses fallback splash paths when no custom splash set', function () {
    $manifest = ManifestService::generate();

    foreach ($manifest['splash'] as $size => $url) {
        expect($url)->toStartWith('/images/icons/splash-')
            ->and($url)->toEndWith('.png')
            ->and($url)->toContain($size);
    }
});

test('manifest does not include shortcuts when empty', function () {
    $manifest = ManifestService::generate();

    expect($manifest)->not->toHaveKey('shortcuts');
});

// ─── Custom Settings Paths ──────────────────────────────────────

test('manifest uses custom icon path with storage prefix', function () {
    $this->updateSetting('icons_192x192', 'pwa/icons/custom-192.png');

    $manifest = ManifestService::generate();

    $icon192 = collect($manifest['icons'])->firstWhere('sizes', '192x192');

    expect($icon192['src'])->toBe('/storage/pwa/icons/custom-192.png');
});

test('manifest uses custom splash path with storage prefix', function () {
    $this->updateSetting('splash_640x1136', 'pwa/splash/custom-640.png');

    $manifest = ManifestService::generate();

    expect($manifest['splash']['640x1136'])->toBe('/storage/pwa/splash/custom-640.png');
});

test('manifest mixes custom and fallback icon paths', function () {
    $this->updateSetting('icons_72x72', 'custom/icon-72.png');
    // icons_96x96 stays empty → fallback

    $manifest = ManifestService::generate();

    $icon72 = collect($manifest['icons'])->firstWhere('sizes', '72x72');
    $icon96 = collect($manifest['icons'])->firstWhere('sizes', '96x96');

    expect($icon72['src'])->toBe('/storage/custom/icon-72.png')
        ->and($icon96['src'])->toBe('/images/icons/icon-96x96.png');
});

// ─── Shortcuts ──────────────────────────────────────────────────

test('manifest includes shortcuts when configured', function () {
    $this->updateSetting('shortcuts', [
        ['name' => 'Dashboard', 'description' => 'Go to dashboard', 'url' => '/admin', 'icon' => 'shortcuts/dash.png'],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest)->toHaveKey('shortcuts')
        ->and($manifest['shortcuts'])->toHaveCount(1)
        ->and($manifest['shortcuts'][0]['name'])->toBe('Dashboard')
        ->and($manifest['shortcuts'][0]['description'])->toBe('Go to dashboard')
        ->and($manifest['shortcuts'][0]['url'])->toBe('/admin');
});

test('shortcut with icon includes icons array', function () {
    $this->updateSetting('shortcuts', [
        ['name' => 'Home', 'description' => 'Home page', 'url' => '/', 'icon' => 'icons/home.png'],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['shortcuts'][0])->toHaveKey('icons')
        ->and($manifest['shortcuts'][0]['icons'][0]['src'])->toBe('/storage/icons/home.png')
        ->and($manifest['shortcuts'][0]['icons'][0]['type'])->toBe('image/png')
        ->and($manifest['shortcuts'][0]['icons'][0]['sizes'])->toBe('72x72');
});

test('shortcut without icon has no icons array', function () {
    $this->updateSetting('shortcuts', [
        ['name' => 'About', 'description' => 'About us', 'url' => '/about', 'icon' => ''],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['shortcuts'][0])->not->toHaveKey('icons');
});

test('multiple shortcuts are all included', function () {
    $this->updateSetting('shortcuts', [
        ['name' => 'Home', 'description' => 'Home', 'url' => '/', 'icon' => ''],
        ['name' => 'Settings', 'description' => 'Settings', 'url' => '/settings', 'icon' => ''],
        ['name' => 'Profile', 'description' => 'Profile', 'url' => '/profile', 'icon' => ''],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['shortcuts'])->toHaveCount(3);
});

// ─── Null/Edge Cases ────────────────────────────────────────────

test('manifest uses defaults when nullable settings are null', function () {
    $this->updateSetting('start_url', null);
    $this->updateSetting('display', null);
    $this->updateSetting('theme_color', null);
    $this->updateSetting('background_color', null);
    $this->updateSetting('orientation', null);
    $this->updateSetting('status_bar', null);

    $manifest = ManifestService::generate();

    expect($manifest['start_url'])->toBe('/')
        ->and($manifest['display'])->toBe('standalone')
        ->and($manifest['theme_color'])->toBe('#000000')
        ->and($manifest['background_color'])->toBe('#ffffff')
        ->and($manifest['orientation'])->toBe('any')
        ->and($manifest['status_bar'])->toBe('#000000');
});

test('manifest allows null app_name and short_name', function () {
    $this->updateSetting('app_name', null);
    $this->updateSetting('short_name', null);

    $manifest = ManifestService::generate();

    expect($manifest['name'])->toBeNull()
        ->and($manifest['short_name'])->toBeNull();
});

test('shortcut with missing optional fields uses defaults', function () {
    $this->updateSetting('shortcuts', [
        ['name' => 'Minimal'],
    ]);

    $manifest = ManifestService::generate();

    expect($manifest['shortcuts'][0]['name'])->toBe('Minimal')
        ->and($manifest['shortcuts'][0]['description'])->toBe('')
        ->and($manifest['shortcuts'][0]['url'])->toBe('/');
});

// ─── Constants Validation ───────────────────────────────────────

test('ICON_SIZES constant has 8 entries', function () {
    expect(ManifestService::ICON_SIZES)->toHaveCount(8);
});

test('SPLASH_SIZES constant has 10 entries', function () {
    expect(ManifestService::SPLASH_SIZES)->toHaveCount(10);
});

// ─── Endpoint Response Structure ────────────────────────────────

test('manifest endpoint returns settings values in JSON response', function () {
    $response = $this->get('/manifest.json');

    $response->assertJson([
        'name' => 'Test App',
        'short_name' => 'Test',
        'display' => 'standalone',
    ]);
});

test('manifest endpoint reflects updated settings', function () {
    $this->updateSetting('app_name', 'Updated App');
    $this->updateSetting('theme_color', '#ff0000');

    $response = $this->get('/manifest.json');

    $response->assertJson([
        'name' => 'Updated App',
        'theme_color' => '#ff0000',
    ]);
});
