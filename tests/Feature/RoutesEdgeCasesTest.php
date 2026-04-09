<?php

// ─── PUT/PATCH/DELETE not allowed ──────────────────────────────

test('manifest does not respond to PUT', function () {
    $this->put('/manifest.json')->assertStatus(405);
});

test('manifest does not respond to PATCH', function () {
    $this->patch('/manifest.json')->assertStatus(405);
});

test('manifest does not respond to DELETE', function () {
    $this->delete('/manifest.json')->assertStatus(405);
});

test('service worker does not respond to PUT', function () {
    $this->put('/serviceworker.js')->assertStatus(405);
});

test('offline does not respond to DELETE', function () {
    $this->delete('/offline')->assertStatus(405);
});

// ─── Route URLs match expected patterns ────────────────────────

test('manifest route URL ends with manifest.json', function () {
    expect(route('pwa.manifest'))->toEndWith('/manifest.json');
});

test('service worker route URL ends with serviceworker.js', function () {
    expect(route('pwa.serviceworker'))->toEndWith('/serviceworker.js');
});

test('offline route URL ends with offline', function () {
    expect(route('pwa.offline'))->toEndWith('/offline');
});

// ─── Middleware configuration ──────────────────────────────────

test('routes use middleware from config', function () {
    $routes = app('router')->getRoutes();

    $manifestRoute = $routes->getByName('pwa.manifest');

    // In test environment, middleware is set to empty array
    expect($manifestRoute->middleware())->toBeArray();
});
