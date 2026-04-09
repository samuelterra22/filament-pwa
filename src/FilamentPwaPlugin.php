<?php

namespace SamuelTerra22\FilamentPwa;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use SamuelTerra22\FilamentPwa\Pages\PwaSettingsPage;
use SamuelTerra22\FilamentPwa\Services\ManifestService;

class FilamentPwaPlugin implements Plugin
{
    protected bool $hasSettingsPage = true;

    protected bool $hasInstallPrompt = true;

    protected bool $hasOfflineIndicator = true;

    protected bool $hasUpdateNotification = true;

    public function getId(): string
    {
        return 'filament-pwa';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function settingsPage(bool $condition = true): static
    {
        $this->hasSettingsPage = $condition;

        return $this;
    }

    public function hasSettingsPage(): bool
    {
        return $this->hasSettingsPage;
    }

    public function installPrompt(bool $condition = true): static
    {
        $this->hasInstallPrompt = $condition;

        return $this;
    }

    public function hasInstallPrompt(): bool
    {
        return $this->hasInstallPrompt;
    }

    public function offlineIndicator(bool $condition = true): static
    {
        $this->hasOfflineIndicator = $condition;

        return $this;
    }

    public function hasOfflineIndicator(): bool
    {
        return $this->hasOfflineIndicator;
    }

    public function updateNotification(bool $condition = true): static
    {
        $this->hasUpdateNotification = $condition;

        return $this;
    }

    public function hasUpdateNotification(): bool
    {
        return $this->hasUpdateNotification;
    }

    public function register(Panel $panel): void
    {
        if ($this->hasSettingsPage()) {
            $panel->pages([
                PwaSettingsPage::class,
            ]);
        }
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn () => view('filament-pwa::meta', [
                'config' => ManifestService::generate(),
                'installPrompt' => $this->hasInstallPrompt,
                'offlineIndicator' => $this->hasOfflineIndicator,
                'updateNotification' => $this->hasUpdateNotification,
            ])
        );
    }
}
