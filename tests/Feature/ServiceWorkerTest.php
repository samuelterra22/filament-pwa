<?php

use Illuminate\Support\Facades\File;

// ─── Happy Paths ────────────────────────────────────────────────

test('service worker endpoint returns 200', function () {
    $response = $this->get('/serviceworker.js');

    $response->assertStatus(200);
});

test('service worker has correct content type', function () {
    $response = $this->get('/serviceworker.js');

    $response->assertHeader('Content-Type', 'application/javascript');
});

test('service worker has cache control header', function () {
    $response = $this->get('/serviceworker.js');

    $cacheControl = $response->headers->get('Cache-Control');
    expect($cacheControl)->toContain('public')->toContain('max-age=3600');
});

test('service worker contains cache version identifier', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain("CACHE_NAME = 'pwa-v");
});

test('service worker contains offline URL', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain('/offline');
});

test('service worker contains icon paths replacing ICONS placeholder', function () {
    $response = $this->get('/serviceworker.js');
    $content = $response->getContent();

    expect($content)
        ->toContain('/images/icons/icon-72x72.png')
        ->toContain('/images/icons/icon-512x512.png')
        ->not->toContain("\nICONS\n");
});

test('service worker has install event listener', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain("addEventListener('install'");
});

test('service worker has activate event listener', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain("addEventListener('activate'");
});

test('service worker has fetch event listener', function () {
    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain("addEventListener('fetch'");
});

// ─── Custom Icons in Service Worker ─────────────────────────────

test('service worker reflects custom icon paths', function () {
    $this->updateSetting('icons_192x192', 'pwa/icons/custom.png');

    $response = $this->get('/serviceworker.js');

    expect($response->getContent())->toContain('/storage/pwa/icons/custom.png');
});

// ─── Edge Case: Missing JS File ────────────────────────────────

test('service worker returns 404 when js file is missing', function () {
    // Partial mock so only exists() is intercepted, other methods work normally
    File::partialMock()
        ->shouldReceive('exists')
        ->andReturn(false);

    $response = $this->get('/serviceworker.js');

    $response->assertStatus(404);
});
