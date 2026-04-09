<?php

// ─── HTML title tag ────────────────────────────────────────────

test('offline page title tag contains correct translation', function () {
    $response = $this->get('/offline');
    $content = $response->getContent();

    expect($content)->toContain('<title>You are offline</title>');
});

// ─── Locale in lang attribute ──────────────────────────────────

test('offline page lang attribute matches app locale', function () {
    $response = $this->get('/offline');
    $content = $response->getContent();

    expect($content)->toContain('lang="en"');
});

test('offline page converts underscore locale to hyphen', function () {
    app()->setLocale('pt_BR');

    $response = $this->get('/offline');
    $content = $response->getContent();

    expect($content)->toContain('lang="pt-BR"');
});

// ─── HTML structure ────────────────────────────────────────────

test('offline page has h1 and p tags with correct content', function () {
    $response = $this->get('/offline');
    $content = $response->getContent();

    expect($content)
        ->toContain('<h1>You are offline</h1>')
        ->toContain('<p>Please check your internet connection and try again.</p>');
});

test('offline page has container div', function () {
    $response = $this->get('/offline');

    expect($response->getContent())->toContain('class="container"');
});

// ─── CSS is embedded ──────────────────────────────────────────

test('offline page has embedded styles', function () {
    $response = $this->get('/offline');

    expect($response->getContent())
        ->toContain('<style>')
        ->toContain('min-height: 100vh');
});
