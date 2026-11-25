<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * The accounts of the application: sign-in by form, sign-out by POST with a CSRF token, attempts throttled, the user
 * checked again each time it is refreshed from the session.
 *
 * @see https://symfony.com/doc/current/security.html
 */
return App::config([
    'security' => [
        'password_hashers' => [
            PasswordAuthenticatedUserInterface::class => 'auto',
        ],
        'providers' => [
            'app_user_provider' => [
                'entity' => [
                    'class' => User::class,
                    'property' => 'username',
                ],
            ],
        ],
        'role_hierarchy' => [
            User::ROLE_ADMIN => [User::ROLE_USER],
        ],
        'firewalls' => [
            'dev' => [
                // The profiler, the debug toolbar and the assets are never behind the firewall.
                'pattern' => '^/(_profiler(/|$)|(_wdt|assets)/)',
                'security' => false,
            ],
            'main' => [
                'lazy' => true,
                'provider' => 'app_user_provider',
                // A disabled or changed account is signed out on its next request, not at the end of its session.
                'user_checker_on_refresh' => true,
                'form_login' => [
                    'login_path' => 'App\Controller\Security\LoginAction',
                    'check_path' => 'App\Controller\Security\LoginAction',
                    'enable_csrf' => true,
                    'csrf_token_id' => 'authenticate',
                    'default_target_path' => 'App\Controller\AccountAction',
                ],
                'logout' => [
                    // The security route loader turns this path into the route _logout_main.
                    'path' => '/logout',
                    'enable_csrf' => true,
                    'csrf_token_id' => 'logout',
                ],
                // Five failed attempts a minute per user name and IP address, through symfony/rate-limiter.
                'login_throttling' => [
                    'max_attempts' => 5,
                ],
                // https://symfony.com/doc/current/security/impersonating_user.html: when switch_user is enabled, only
                // with a POST request and a CSRF token.
            ],
        ],
        // Only the first rule that matches is applied.
        'access_control' => [
            ['path' => '^/admin', 'roles' => User::ROLE_ADMIN],
            ['path' => '^/account', 'roles' => User::ROLE_USER],
        ],
    ],
    'when@test' => [
        'security' => [
            'password_hashers' => [
                // The lowest work factors: secure hashes are not needed by the tests and slow them down.
                PasswordAuthenticatedUserInterface::class => [
                    'algorithm' => 'auto',
                    'cost' => 4,
                    'time_cost' => 3,
                    'memory_cost' => 10,
                ],
            ],
        ],
    ],
]);
