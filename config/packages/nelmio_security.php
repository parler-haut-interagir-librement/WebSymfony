<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

/**
 * The security headers of every response: no framing, no type sniffing, a strict referrer policy, no redirection to
 * another site, and a Content Security Policy where scripts run only from the site or with the nonce of the page.
 *
 * @see https://symfony.com/bundles/NelmioSecurityBundle/current/index.html
 */
return App::config([
    'nelmio_security' => [
        'clickjacking' => [
            'paths' => [
                '^/.*' => 'DENY',
            ],
        ],
        'content_type' => [
            'nosniff' => true,
        ],
        'referrer_policy' => [
            'enabled' => true,
            'policies' => ['no-referrer', 'strict-origin-when-cross-origin'],
        ],
        'external_redirects' => [
            'abort' => true,
            'log' => true,
        ],
        'csp' => [
            'enabled' => true,
            'hash' => [
                'algorithm' => 'sha384',
            ],
            'enforce' => [
                'level1_fallback' => false,
                'default-src' => ["'self'"],
                // The importmap is an inline script: base.html.twig gives it the nonce of the page.
                'script-src' => ["'self'"],
                'img-src' => ["'self'", 'data:'],
                'style-src' => ["'self'"],
                'connect-src' => ["'self'"],
                'object-src' => ["'none'"],
                'base-uri' => ["'self'"],
                'form-action' => ["'self'"],
                'frame-ancestors' => ["'none'"],
                'upgrade-insecure-requests' => false,
            ],
        ],
    ],
]);
