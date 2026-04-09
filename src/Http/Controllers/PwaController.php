<?php

namespace SamuelTerra22\FilamentPwa\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use SamuelTerra22\FilamentPwa\Services\ManifestService;

class PwaController extends Controller
{
    public function manifest(): JsonResponse
    {
        return response()->json(ManifestService::generate());
    }

    public function offline(): View
    {
        return view('filament-pwa::offline');
    }

    public function serviceWorker(): Response
    {
        $jsPath = __DIR__.'/../../../resources/js/serviceworker.js';

        if (! File::exists($jsPath)) {
            abort(404, 'Service worker file not found');
        }

        $content = File::get($jsPath);

        $manifest = ManifestService::generate();
        $iconsList = collect($manifest['icons'])
            ->map(fn (array $icon): string => "'".str_replace("'", "\\'", $icon['src'])."'")
            ->implode(",\n    ");

        $content = str_replace('ICONS', $iconsList, $content);

        return response($content)
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
