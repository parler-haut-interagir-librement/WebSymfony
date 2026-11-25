<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

/**
 * Twig components, which EasyAdmin renders its pages with; the application's own go in templates/components/.
 *
 * @see https://symfony.com/bundles/ux-twig-component/current/index.html
 */
return App::config([
    'twig_component' => [
        'anonymous_template_directory' => 'components/',
        'defaults' => [
            'App\Twig\Components\\' => 'components/',
        ],
    ],
]);
