<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

/**
 * The Doctrine extensions in use: Timestampable sets the dates of the users.
 *
 * @see https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html
 */
return App::config([
    'stof_doctrine_extensions' => [
        'default_locale' => 'en',
        'orm' => [
            'default' => [
                'timestampable' => true,
            ],
        ],
    ],
]);
