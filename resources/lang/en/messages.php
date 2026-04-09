<?php

return [
    'navigation' => [
        'group' => 'Settings',
        'label' => 'PWA',
    ],

    'settings' => [
        'title' => 'Progressive Web App',
        'description' => 'Configure your Progressive Web App settings',
    ],

    'sections' => [
        'general' => 'General',
        'style' => 'Appearance',
        'icons' => 'Icons',
        'splash' => 'Splash Screens',
        'shortcuts' => 'Shortcuts',
        'advanced' => 'Advanced',
        'screenshots' => 'Screenshots',
    ],

    'form' => [
        'app_name' => 'App Name',
        'short_name' => 'Short Name',
        'start_url' => 'Start URL',
        'background_color' => 'Background Color',
        'theme_color' => 'Theme Color',
        'status_bar' => 'Status Bar Color',
        'display' => 'Display Mode',
        'orientation' => 'Orientation',
        'icon' => ':size Icon',
        'splash' => ':size Splash Screen',
        'shortcuts' => 'Shortcuts',
        'shortcut_name' => 'Name',
        'shortcut_description' => 'Description',
        'shortcut_url' => 'URL',
        'shortcut_icon' => 'Icon',
        'icon_purpose' => 'Icon Purpose',
        'icon_purpose_help' => 'Maskable icons have safe zone padding for adaptive icon shapes on Android.',
        'description' => 'App Description',
        'description_help' => 'A brief description of your application shown during installation.',
        'scope' => 'Navigation Scope',
        'scope_help' => 'Restricts which URLs are considered part of the app.',
        'id' => 'App ID',
        'id_help' => 'Unique identifier for the application.',
        'lang' => 'Language',
        'lang_help' => 'Primary language tag (e.g. en-US, pt-BR).',
        'dir' => 'Text Direction',
        'categories' => 'Categories',
        'categories_help' => 'App categories (e.g. business, productivity, utilities).',
        'display_override' => 'Display Override',
        'display_override_help' => 'Fallback chain of display modes the browser will try in order.',
        'screenshots' => 'Screenshots',
        'screenshot_image' => 'Image',
        'screenshot_sizes' => 'Dimensions',
        'screenshot_type' => 'File Type',
        'screenshot_form_factor' => 'Form Factor',
        'screenshot_label' => 'Label',
    ],

    'offline' => [
        'title' => 'You are offline',
        'message' => 'Please check your internet connection and try again.',
        'indicator' => 'You are offline',
        'back_online' => 'Back online',
    ],

    'install' => [
        'description' => 'Install this app on your device for quick access.',
        'button' => 'Install',
        'dismiss' => 'Not now',
    ],

    'update' => [
        'message' => 'A new version is available.',
        'button' => 'Refresh',
    ],
];
