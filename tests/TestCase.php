<?php

namespace SamuelTerra22\FilamentPwa\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use SamuelTerra22\FilamentPwa\FilamentPwaServiceProvider;
use SamuelTerra22\FilamentPwa\Settings\PwaSettings;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;
use Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository;

class TestCase extends Orchestra
{
    protected static $latestResponse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            FilamentPwaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('settings.default_repository', 'database');
        config()->set('settings.repositories', [
            'database' => [
                'type' => DatabaseSettingsRepository::class,
                'connection' => null,
                'table' => 'settings',
            ],
        ]);

        config()->set('filament-pwa.middlewares', []);
    }

    protected function setUpDatabase(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('group');
            $table->string('name');
            $table->boolean('locked')->default(false);
            $table->json('payload');
            $table->timestamps();
        });

        $this->seedPwaSettings();
    }

    protected function updateSetting(string $name, mixed $value): void
    {
        DB::table('settings')
            ->where('group', 'pwa')
            ->where('name', $name)
            ->update(['payload' => json_encode($value)]);

        app()->forgetInstance(PwaSettings::class);
    }

    protected function seedPwaSettings(): void
    {
        $settings = [
            'app_name' => 'Test App',
            'short_name' => 'Test',
            'start_url' => '/',
            'background_color' => '#ffffff',
            'theme_color' => '#000000',
            'display' => 'standalone',
            'orientation' => 'any',
            'status_bar' => '#000000',
            'icons_72x72' => '',
            'icons_96x96' => '',
            'icons_128x128' => '',
            'icons_144x144' => '',
            'icons_152x152' => '',
            'icons_192x192' => '',
            'icons_384x384' => '',
            'icons_512x512' => '',
            'splash_640x1136' => '',
            'splash_750x1334' => '',
            'splash_828x1792' => '',
            'splash_1125x2436' => '',
            'splash_1242x2208' => '',
            'splash_1242x2688' => '',
            'splash_1536x2048' => '',
            'splash_1668x2224' => '',
            'splash_1668x2388' => '',
            'splash_2048x2732' => '',
            'shortcuts' => [],
            'description' => '',
            'scope' => '/',
            'lang' => '',
            'dir' => 'auto',
            'id' => '',
            'categories' => [],
            'display_override' => [],
            'screenshots' => [],
            'icon_purpose' => 'any',
        ];

        foreach ($settings as $name => $value) {
            DB::table('settings')->insert([
                'group' => 'pwa',
                'name' => $name,
                'locked' => false,
                'payload' => json_encode($value),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
