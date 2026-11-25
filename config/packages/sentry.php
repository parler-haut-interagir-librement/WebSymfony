<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\ErrorHandler\Error\FatalError;

/**
 * Sentry, in production only: the errors are sent to the project of SENTRY_DSN; an empty DSN sends nothing. No
 * personal data is sent unless send_default_pii is turned on.
 *
 * @see https://docs.sentry.io/platforms/php/guides/symfony/
 */
return App::config([
    'when@prod' => [
        'sentry' => [
            'dsn' => '%env(SENTRY_DSN)%',
            'options' => [
                'ignore_exceptions' => [FatalError::class],
            ],
        ],
    ],
]);
