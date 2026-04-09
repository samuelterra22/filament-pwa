<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('filament-pwa::messages.offline.title') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
            color: #374151;
        }
        .container {
            text-align: center;
            padding: 2rem;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        p {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ __('filament-pwa::messages.offline.title') }}</h1>
        <p>{{ __('filament-pwa::messages.offline.message') }}</p>
    </div>
</body>
</html>
