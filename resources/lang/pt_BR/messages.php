<?php

return [
    'navigation' => [
        'group' => 'Configurações',
        'label' => 'PWA',
    ],

    'settings' => [
        'title' => 'Aplicativo Web Progressivo',
        'description' => 'Configure as opções do seu Aplicativo Web Progressivo',
    ],

    'sections' => [
        'general' => 'Geral',
        'style' => 'Aparência',
        'icons' => 'Ícones',
        'splash' => 'Telas de Abertura',
        'shortcuts' => 'Atalhos',
        'advanced' => 'Avançado',
        'screenshots' => 'Capturas de Tela',
    ],

    'form' => [
        'app_name' => 'Nome do Aplicativo',
        'short_name' => 'Nome Curto',
        'start_url' => 'URL Inicial',
        'background_color' => 'Cor de Fundo',
        'theme_color' => 'Cor do Tema',
        'status_bar' => 'Cor da Barra de Status',
        'display' => 'Modo de Exibição',
        'orientation' => 'Orientação',
        'icon' => 'Ícone :size',
        'splash' => 'Tela de Abertura :size',
        'shortcuts' => 'Atalhos',
        'shortcut_name' => 'Nome',
        'shortcut_description' => 'Descrição',
        'shortcut_url' => 'URL',
        'shortcut_icon' => 'Ícone',
        'icon_purpose' => 'Propósito do Ícone',
        'icon_purpose_help' => 'Ícones maskable possuem zona segura para formatos adaptativos no Android.',
        'description' => 'Descrição do Aplicativo',
        'description_help' => 'Uma breve descrição do seu aplicativo exibida durante a instalação.',
        'scope' => 'Escopo de Navegação',
        'scope_help' => 'Restringe quais URLs fazem parte do aplicativo.',
        'id' => 'ID do Aplicativo',
        'id_help' => 'Identificador único do aplicativo.',
        'lang' => 'Idioma',
        'lang_help' => 'Tag de idioma principal (ex: pt-BR, en-US).',
        'dir' => 'Direção do Texto',
        'categories' => 'Categorias',
        'categories_help' => 'Categorias do aplicativo (ex: business, productivity, utilities).',
        'display_override' => 'Substituição de Exibição',
        'display_override_help' => 'Cadeia de modos de exibição que o navegador tentará em ordem.',
        'screenshots' => 'Capturas de Tela',
        'screenshot_image' => 'Imagem',
        'screenshot_sizes' => 'Dimensões',
        'screenshot_type' => 'Tipo de Arquivo',
        'screenshot_form_factor' => 'Formato',
        'screenshot_label' => 'Rótulo',
    ],

    'offline' => [
        'title' => 'Você está offline',
        'message' => 'Verifique sua conexão com a internet e tente novamente.',
        'indicator' => 'Você está offline',
        'back_online' => 'Conectado novamente',
    ],

    'install' => [
        'description' => 'Instale este aplicativo no seu dispositivo para acesso rápido.',
        'button' => 'Instalar',
        'dismiss' => 'Agora não',
    ],

    'update' => [
        'message' => 'Uma nova versão está disponível.',
        'button' => 'Atualizar',
    ],
];
