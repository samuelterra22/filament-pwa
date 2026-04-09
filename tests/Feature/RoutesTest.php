<?php

// ─── Route Registration ─────────────────────────────────────────

test('manifest route is registered', function () {
    $this->get('/manifest.json')->assertStatus(200);
});

test('offline route is registered', function () {
    $this->get('/offline')->assertStatus(200);
});

test('service worker route is registered', function () {
    $this->get('/serviceworker.js')->assertStatus(200);
});

// ─── Route Names ────────────────────────────────────────────────

test('manifest route has correct name', function () {
    expect(route('pwa.manifest'))->toEndWith('/manifest.json');
});

test('offline route has correct name', function () {
    expect(route('pwa.offline'))->toEndWith('/offline');
});

test('service worker route has correct name', function () {
    expect(route('pwa.serviceworker'))->toEndWith('/serviceworker.js');
});

// ─── HTTP Methods ───────────────────────────────────────────────

test('manifest only responds to GET', function () {
    $this->post('/manifest.json')->assertStatus(405);
});

test('offline only responds to GET', function () {
    $this->post('/offline')->assertStatus(405);
});

test('service worker only responds to GET', function () {
    $this->post('/serviceworker.js')->assertStatus(405);
});

// ─── Non-existent Routes ────────────────────────────────────────

test('non-existent pwa route returns 404', function () {
    $this->get('/pwa/nonexistent')->assertStatus(404);
});
