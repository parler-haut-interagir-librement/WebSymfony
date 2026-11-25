<?php

declare(strict_types=1);

/*
 * What phil/dev-tools reads of this application: its paths and its exceptions to the shared configurations.
 * See vendor/phil/dev-tools/doc/configuration.md for every section.
 */
return [
    // Released on Packagist since 2023: its CHANGELOG has the usual sections.
    'docs' => ['public' => true],
    'paths' => ['src', 'tests', 'migrations', 'bin', 'public', 'importmap.php'],
    // The functional tests share one SQLite file: they run one after the other, with PHPUnit.
    'phpunit' => ['parallel' => false],
    // Besides the Symfony components, the classes of src/ may use these libraries and bundles, and no other: a new one
    // is added here on purpose, after it is required by composer.json.
    'deptrac' => ['allow' => [
        '^Doctrine\\\\(Bundle\\\\DoctrineBundle|DBAL|ORM|Persistence)\\\\.*',
        '^EasyCorp\\\\Bundle\\\\EasyAdminBundle\\\\.*',
        '^Gedmo\\\\Mapping\\\\.*',
        '^Knp\\\\Menu\\\\.*',
        '^Symfony\\\\Bridge\\\\Doctrine\\\\.*',
        '^Symfony\\\\Bundle\\\\(FrameworkBundle|SecurityBundle)\\\\.*',
        '^Twig\\\\.*',
        '^Zenstruck\\\\Foundry\\\\.*',
    ]],
    // The Stimulus controllers and the scripts of the application; assets/vendor holds the packages of the importmap.
    'js' => ['paths' => ['assets/controllers', 'assets/app.js', 'assets/bootstrap.js']],
    // Used through the configuration, the templates, the front controller or the console, never by a class of src/.
    'unused' => ['ignore' => [
        'ext-iconv', 'ext-simplexml', 'doctrine/migrations', 'doctrine/doctrine-migrations-bundle', 'league/commonmark',
        'symfony/asset-mapper', 'symfony/dotenv', 'symfony/flex', 'symfony/monolog-bundle',
        'symfony/runtime', 'symfony/stimulus-bundle', 'symfony/ux-turbo',
        'symfony/web-link', 'symfony/yaml', 'twig/markdown-extra',
        'knplabs/knp-menu-bundle', 'nelmio/cors-bundle', 'nelmio/security-bundle',
        'stof/doctrine-extensions-bundle', 'symfony/rate-limiter', 'sentry/sentry-symfony',
    ]],
];
