<?php

// ─── Happy Paths ────────────────────────────────────────────────

test('offline page returns 200', function () {
    $response = $this->get('/offline');

    $response->assertStatus(200);
});

test('offline page contains title text', function () {
    $response = $this->get('/offline');

    $response->assertSee('You are offline');
});

test('offline page contains message text', function () {
    $response = $this->get('/offline');

    $response->assertSee('Please check your internet connection and try again.');
});

test('offline page is valid HTML document', function () {
    $response = $this->get('/offline');
    $content = $response->getContent();

    expect($content)
        ->toContain('<!DOCTYPE html>')
        ->toContain('<html')
        ->toContain('</html>')
        ->toContain('<meta charset="utf-8">');
});

test('offline page has viewport meta tag', function () {
    $response = $this->get('/offline');

    $response->assertSee('viewport', false);
});
