<?php

// Until the 1.x Castor version the API may be unstable
// it script was tested with Castor 0.13.0

declare(strict_types=1);

use Castor\Attribute\AsTask;
use Symfony\Component\Console\Command\Command;

use function Castor\io;
use function Castor\parallel;
use function Castor\run;
use function Castor\task;

/**
 * Don't display the description when using a parent command context.
 */
function title(string $title, ?Command $command = null): void
{
    io()->title($title . (null !== $command ? ': ' . $command->getDescription() : ''));
}

function success(): void
{
    io()->success('Done!');
}

function aborted(): void
{
    io()->warning('Aborted.');
}

#[AsTask(namespace: 'symfony', description: 'Serve the application with the Symfony binary', )]
function start(): void
{
    title(__FUNCTION__, task());
    run('symfony serve --daemon', quiet: false);
    success();
}

#[AsTask(namespace: 'symfony', description: 'Stop the web server')]
function stop(): void
{
    title(__FUNCTION__, task());
    run('symfony server:stop', quiet: false);
    success();
}

#[AsTask(namespace: 'symfony', description: 'Switch to the production environment')]
function go_prod(): void
{
    title(__FUNCTION__, task());
    if (io()->confirm('Are you sure you want to switch to the production environment? This will modify your .env.local file', false)) {
        run('sed -e \'s/APP_ENV=dev/APP_ENV=prod\' -e \'s/APP_DEBUG=1/APP_DEBUG=0\' .env.local', quiet: false);
        run('bin/console asset-map:compile', quiet: false);
        success();

        return;
    }

    aborted();
}

#[AsTask(namespace: 'symfony', description: 'Switch to the development environment')]
function go_dev(): void
{
    title(__FUNCTION__, task());
    if (io()->confirm('Are you sure you want to switch to the development environment? This will modify your .env.local file', false)) {
        run('sed -e \'s/APP_ENV=prod/APP_ENV=dev\' -e \'s/APP_DEBUG=0/APP_DEBUG=1\' .env.local', quiet: false);
        run('rm -rf ./public/assets/*', quiet: false);
        success();

        return;
    }

    aborted();
}

#[AsTask(namespace: 'symfony', description: 'Purge all Symfony cache and logs')]
function purge(): void
{
    title(__FUNCTION__, task());
    run('rm -rf ./var/cache/* ./var/logs/* ./var/coverage/*', quiet: false);
    success();
}

#[AsTask(name: 'all', namespace: 'test', description: 'Run all PHPUnit tests')]
function test(): void
{
    title(__FUNCTION__, task());
    run('vendor/bin/phpunit', quiet: false);
    io()->writeln('');
    success();
}

#[AsTask(namespace: 'test', description: 'Generate the HTML PHPUnit code coverage report (stored in var/coverage)')]
function coverage(): void
{
    title(__FUNCTION__, task());
    run(
        'php -d xdebug.enable=1 -d memory_limit=-1 vendor/bin/phpunit --coverage-html=var/coverage --coverage-clover=var/coverage/clover.xml',
        environment: [
            'XDEBUG_MODE' => 'coverage',
        ],
        quiet: false
    );
    run('php bin/coverage-checker.php var/coverage/clover.xml 100', quiet: false);
    success();
}

#[AsTask(namespace: 'test', description: 'Open the PHPUnit code coverage report (var/coverage/index.html)')]
function cov_report(): void
{
    title(__FUNCTION__, task());
    run('open var/coverage/index.html', quiet: true);
    success();
}

#[AsTask(namespace: 'cs', description: 'Run PHPStan')]
function stan(): void
{
    title(__FUNCTION__, task());
    run('vendor/bin/phpstan analyse --memory-limit 1G', quiet: false);
    success();
}

#[AsTask(namespace: 'cs', description: 'Fix PHP files with php-cs-fixer')]
function fix_php(): void
{
    title(__FUNCTION__, task());
    run(
        'vendor/bin/php-cs-fixer fix --allow-risky=yes',
        environment: [
            'PHP_CS_FIXER_IGNORE_ENV' => 1,
        ],
        quiet: false
    );
    success();
}

#[AsTask(namespace: 'cs', description: 'Lint PHP files with php-cs-fixer (report only)')]
function lint_php(): void
{
    title(__FUNCTION__, task());
    run('vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run',
        environment: [
            'PHP_CS_FIXER_IGNORE_ENV' => 1,
        ],
        quiet: false
    );
    success();
}

#[AsTask(name: 'run', namespace: 'rector', description: 'Run Rector')]
function rector(): void
{
    title(__FUNCTION__, task());
    run('vendor/bin/rector', quiet: false);
    success();
}

#[AsTask(name: 'dry-run', namespace: 'rector', description: 'Run Rector')]
function rector_dry_run(): void
{
    title(__FUNCTION__, task());
    run('vendor/bin/rector --dry-run', quiet: false);
    success();
}

#[AsTask(name: 'all', namespace: 'cs', description: 'Run all CS checks')]
function cs_all(): void
{
    title(__FUNCTION__, task());
    fix_php();
    stan();
}

#[AsTask(name: 'container', namespace: 'lint', description: 'Lint the Symfony DI container')]
function lint_container(): void
{
    title(__FUNCTION__, task());
    run('bin/console lint:container', quiet: false);
    success();
}

#[AsTask(name: 'twig', namespace: 'lint', description: 'Lint Twig files')]
function lint_twig(): void
{
    title(__FUNCTION__, task());
    run('bin/console lint:twig templates/', quiet: false);
    success();
}

#[AsTask(name: 'yaml', namespace: 'lint', description: 'Lint Yaml files')]
function lint_yaml(): void
{
    title(__FUNCTION__, task());
    run('bin/console lint:yaml --parse-tags config/', quiet: false);
    run('bin/console lint:yaml --parse-tags translations/', quiet: false);
    success();
}

#[AsTask(name: 'all', namespace: 'lint', description: 'Run all lints')]
function lint_all(): void
{
    title(__FUNCTION__, task());
    parallel(
        fn () => lint_php(),
        fn () => lint_container(),
        fn () => lint_twig(),
        fn () => lint_yaml(),
    );
}

#[AsTask(name: 'all', namespace: 'ci', description: 'Run CI locally')]
function ci(): void
{
    title(__FUNCTION__, task());
    test();
    cs_all();
    lint_all();
}

#[AsTask(name: 'versions', namespace: 'helpers', description: 'Output current stack versions')]
function versions(): void
{
    title(__FUNCTION__, task());
    io()->note('PHP');
    run('php -v', quiet: false);
    io()->newLine();

    io()->note('Composer');
    run('composer --version', quiet: false);
    io()->newLine();

    io()->note('Symfony');
    run('bin/console --version', quiet: false);
    io()->newLine();

    io()->note('PHPUnit');
    run('vendor/bin/phpunit --version', quiet: false);

    io()->note('PHPStan');
    run('vendor/bin/phpstan --version', quiet: false);
    io()->newLine();

    io()->note('php-cs-fixer');
    run('vendor/bin/php-cs-fixer --version', quiet: false);
    io()->newLine();

    success();
}

#[AsTask(name: 'check-requirements', namespace: 'helpers', description: 'Checks requirements for running Symfony')]
function check_requirements(): void
{
    title(__FUNCTION__, task());
    run('vendor/bin/requirements-checker', quiet: false);
    success();
}
