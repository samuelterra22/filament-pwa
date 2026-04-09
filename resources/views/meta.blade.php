<!-- Web Application Manifest -->
<link rel="manifest" href="{{ route('pwa.manifest') }}">

<!-- Chrome for Android theme color -->
<meta name="theme-color" content="{{ $config['theme_color'] }}">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ $config['display'] === 'standalone' ? 'yes' : 'no' }}">
<meta name="application-name" content="{{ $config['short_name'] }}">
<link rel="icon" sizes="{{ data_get(end($config['icons']), 'sizes') }}" href="{{ data_get(end($config['icons']), 'src') }}">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="{{ $config['display'] === 'standalone' ? 'yes' : 'no' }}">
<meta name="apple-mobile-web-app-status-bar-style" content="{{ $config['status_bar'] }}">
<meta name="apple-mobile-web-app-title" content="{{ $config['short_name'] }}">
<link rel="apple-touch-icon" href="{{ data_get(end($config['icons']), 'src') }}">

<!-- Apple splash screens -->
<link href="{{ $config['splash']['640x1136'] }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['750x1334'] }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['1242x2208'] }}" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['1125x2436'] }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['828x1792'] }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['1242x2688'] }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['1536x2048'] }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['1668x2224'] }}" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['1668x2388'] }}" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link href="{{ $config['splash']['2048x2732'] }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="{{ $config['background_color'] }}">
<meta name="msapplication-TileImage" content="{{ data_get(end($config['icons']), 'src') }}">

<!-- PWA Styles -->
<style>
    .pwa-banner {
        position: fixed;
        left: 0;
        right: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        font-size: 0.875rem;
        line-height: 1.25rem;
        transition: transform 0.3s ease, opacity 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .pwa-banner--hidden { transform: translateY(-100%); opacity: 0; pointer-events: none; }
    .pwa-banner--bottom { bottom: 0; top: auto; border-radius: 0.75rem 0.75rem 0 0; }
    .pwa-banner--bottom.pwa-banner--hidden { transform: translateY(100%); }
    .pwa-banner--top { top: 0; border-radius: 0 0 0.75rem 0.75rem; }

    /* Install Prompt */
    .pwa-install-banner {
        background: {{ $config['theme_color'] }};
        color: #fff;
        gap: 0.75rem;
        justify-content: space-between;
    }
    .pwa-install-banner__content { display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0; }
    .pwa-install-banner__icon { width: 40px; height: 40px; border-radius: 8px; flex-shrink: 0; }
    .pwa-install-banner__text { flex: 1; min-width: 0; }
    .pwa-install-banner__title { font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .pwa-install-banner__desc { opacity: 0.85; font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .pwa-install-banner__actions { display: flex; gap: 0.5rem; flex-shrink: 0; }
    .pwa-install-banner__btn {
        padding: 0.4rem 1rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: opacity 0.15s;
    }
    .pwa-install-banner__btn:hover { opacity: 0.85; }
    .pwa-install-banner__btn--install { background: #fff; color: {{ $config['theme_color'] }}; }
    .pwa-install-banner__btn--dismiss { background: rgba(255,255,255,0.2); color: #fff; }

    /* Offline Indicator */
    .pwa-offline-banner {
        background: #ef4444;
        color: #fff;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
    .pwa-offline-banner--online { background: #22c55e; }
    .pwa-offline-banner svg { width: 1rem; height: 1rem; flex-shrink: 0; }

    /* Update Notification */
    .pwa-update-banner {
        background: #3b82f6;
        color: #fff;
        justify-content: center;
        gap: 0.75rem;
    }
    .pwa-update-banner__btn {
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: none;
        padding: 0.3rem 0.75rem;
        border-radius: 0.375rem;
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: opacity 0.15s;
    }
    .pwa-update-banner__btn:hover { opacity: 0.85; }
</style>

@if($installPrompt ?? true)
<!-- Install Prompt Banner -->
<div id="pwa-install-banner" class="pwa-banner pwa-banner--bottom pwa-install-banner pwa-banner--hidden" role="alert">
    <div class="pwa-install-banner__content">
        <img class="pwa-install-banner__icon" src="{{ data_get(end($config['icons']), 'src') }}" alt="{{ $config['name'] }}">
        <div class="pwa-install-banner__text">
            <div class="pwa-install-banner__title">{{ $config['name'] }}</div>
            @if(!empty($config['description']))
                <div class="pwa-install-banner__desc">{{ $config['description'] }}</div>
            @else
                <div class="pwa-install-banner__desc">{{ __('filament-pwa::messages.install.description') }}</div>
            @endif
        </div>
    </div>
    <div class="pwa-install-banner__actions">
        <button class="pwa-install-banner__btn pwa-install-banner__btn--dismiss" id="pwa-install-dismiss" type="button">
            {{ __('filament-pwa::messages.install.dismiss') }}
        </button>
        <button class="pwa-install-banner__btn pwa-install-banner__btn--install" id="pwa-install-accept" type="button">
            {{ __('filament-pwa::messages.install.button') }}
        </button>
    </div>
</div>
@endif

@if($offlineIndicator ?? true)
<!-- Offline Indicator -->
<div id="pwa-offline-banner" class="pwa-banner pwa-banner--top pwa-offline-banner pwa-banner--hidden" role="status" aria-live="polite">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
    </svg>
    <span id="pwa-offline-text">{{ __('filament-pwa::messages.offline.indicator') }}</span>
</div>
@endif

@if($updateNotification ?? true)
<!-- Update Notification -->
<div id="pwa-update-banner" class="pwa-banner pwa-banner--top pwa-update-banner pwa-banner--hidden" role="alert">
    <span>{{ __('filament-pwa::messages.update.message') }}</span>
    <button class="pwa-update-banner__btn" id="pwa-update-accept" type="button">
        {{ __('filament-pwa::messages.update.button') }}
    </button>
</div>
@endif

<!-- Service Worker Registration & Features -->
<script type="text/javascript">
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            console.log('PWA: ServiceWorker registration successful with scope:', registration.scope);

            @if($updateNotification ?? true)
            // SW Update Detection
            registration.addEventListener('updatefound', function () {
                var newWorker = registration.installing;
                if (!newWorker) return;

                newWorker.addEventListener('statechange', function () {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        var banner = document.getElementById('pwa-update-banner');
                        if (banner) {
                            banner.classList.remove('pwa-banner--hidden');
                        }
                    }
                });
            });
            @endif
        }, function (err) {
            console.log('PWA: ServiceWorker registration failed:', err);
        });

        @if($updateNotification ?? true)
        // Handle controller change (after skipWaiting)
        var refreshing = false;
        navigator.serviceWorker.addEventListener('controllerchange', function () {
            if (!refreshing) {
                refreshing = true;
                window.location.reload();
            }
        });

        // Update button click
        document.addEventListener('DOMContentLoaded', function () {
            var updateBtn = document.getElementById('pwa-update-accept');
            if (updateBtn) {
                updateBtn.addEventListener('click', function () {
                    navigator.serviceWorker.ready.then(function (registration) {
                        if (registration.waiting) {
                            registration.waiting.postMessage({ type: 'SKIP_WAITING' });
                        }
                    });
                });
            }
        });
        @endif
    }

    @if($installPrompt ?? true)
    // Install Prompt
    (function () {
        var deferredPrompt = null;
        var banner = document.getElementById('pwa-install-banner');
        var dismissKey = 'pwa-install-dismissed';

        if (!banner) return;

        // Check if already installed (display-mode: standalone)
        if (window.matchMedia('(display-mode: standalone)').matches || navigator.standalone === true) {
            return;
        }

        window.addEventListener('beforeinstallprompt', function (e) {
            e.preventDefault();
            deferredPrompt = e;

            // Check if user previously dismissed
            if (localStorage.getItem(dismissKey)) {
                var dismissed = parseInt(localStorage.getItem(dismissKey), 10);
                // Show again after 7 days
                if (Date.now() - dismissed < 7 * 24 * 60 * 60 * 1000) {
                    return;
                }
            }

            banner.classList.remove('pwa-banner--hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            var installBtn = document.getElementById('pwa-install-accept');
            var dismissBtn = document.getElementById('pwa-install-dismiss');

            if (installBtn) {
                installBtn.addEventListener('click', function () {
                    if (!deferredPrompt) return;
                    banner.classList.add('pwa-banner--hidden');
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(function (choiceResult) {
                        deferredPrompt = null;
                        if (choiceResult.outcome === 'accepted') {
                            console.log('PWA: User accepted install prompt');
                        }
                    });
                });
            }

            if (dismissBtn) {
                dismissBtn.addEventListener('click', function () {
                    banner.classList.add('pwa-banner--hidden');
                    localStorage.setItem(dismissKey, Date.now().toString());
                });
            }
        });
    })();
    @endif

    @if($offlineIndicator ?? true)
    // Offline Indicator
    (function () {
        var banner = document.getElementById('pwa-offline-banner');
        var textEl = document.getElementById('pwa-offline-text');
        var onlineTimeout = null;

        if (!banner || !textEl) return;

        function showOffline() {
            if (onlineTimeout) { clearTimeout(onlineTimeout); onlineTimeout = null; }
            banner.classList.remove('pwa-offline-banner--online', 'pwa-banner--hidden');
            textEl.textContent = @json(__('filament-pwa::messages.offline.indicator'));
        }

        function showOnline() {
            banner.classList.add('pwa-offline-banner--online');
            banner.classList.remove('pwa-banner--hidden');
            textEl.textContent = @json(__('filament-pwa::messages.offline.back_online'));
            onlineTimeout = setTimeout(function () {
                banner.classList.add('pwa-banner--hidden');
            }, 3000);
        }

        window.addEventListener('offline', showOffline);
        window.addEventListener('online', showOnline);

        // Show immediately if already offline
        if (!navigator.onLine) {
            showOffline();
        }
    })();
    @endif
</script>
