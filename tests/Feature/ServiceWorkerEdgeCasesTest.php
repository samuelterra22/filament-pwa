<?php

use Illuminate\Support\Facades\File;

// ─── Single quote escaping in icon paths ───────────────────────

test('service worker escapes single quotes in icon paths', function () {
    $this->updateSetting('icons_192x192', "pwa/icons/it's-icon.png");

    $response = $this->get('/serviceworker.js');

    expect($response->getContent())
        ->toContain("it\\'s-icon.png")
        ->not->toContain("it's-icon.png");
});

// ─── Both headers present ──────────────────────────────────────

test('service worker response has both Content-Type and Cache-Control headers', function () {
    $response = $this->get('/serviceworker.js');

    $response->assertHeader('Content-Type', 'application/javascript');

    $cacheControl = $response->headers->get('Cache-Control');
    expect($cacheControl)->toContain('public')->toContain('max-age=3600');
});

// ─── ICONS placeholder fully replaced ──────────────────────────

test('service worker does not contain raw ICONS placeholder', function () {
    $response = $this->get('/serviceworker.js');
    $content = $response->getContent();

    // The original file has ICONS as a placeholder on its own line
    // After replacement, it should be gone
    expect($content)->not->toMatch('/^\s*ICONS\s*$/m');
});

// ─── All 8 icon sizes in service worker ────────────────────────

test('service worker contains all 8 default icon paths', function () {
    $response = $this->get('/serviceworker.js');
    $content = $response->getContent();

    expect($content)
        ->toContain('/images/icons/icon-72x72.png')
        ->toContain('/images/icons/icon-96x96.png')
        ->toContain('/images/icons/icon-128x128.png')
        ->toContain('/images/icons/icon-144x144.png')
        ->toContain('/images/icons/icon-152x152.png')
        ->toContain('/images/icons/icon-192x192.png')
        ->toContain('/images/icons/icon-384x384.png')
        ->toContain('/images/icons/icon-512x512.png');
});

// ─── File::get() failure ───────────────────────────────────────

test('service worker returns 500 when File::get throws exception', function () {
    File::partialMock()
        ->shouldReceive('exists')
        ->andReturn(true)
        ->shouldReceive('get')
        ->andThrow(new RuntimeException('Permission denied'));

    $this->get('/serviceworker.js')->assertStatus(500);
});

// ─── Mixed custom and default icons in service worker ──────────

test('service worker includes both custom and default icon paths', function () {
    $this->updateSetting('icons_72x72', 'custom/icon-72.png');

    $response = $this->get('/serviceworker.js');
    $content = $response->getContent();

    expect($content)
        ->toContain('/storage/custom/icon-72.png')
        ->toContain('/images/icons/icon-96x96.png');
});
