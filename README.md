# WebSymfony 🕸️

[![Latest Version](https://img.shields.io/packagist/v/phil/websymfony.svg?style=flat-square)](https://packagist.org/packages/phil/websymfony)
[![PHP Version Require](https://poser.pugx.org/phil/websymfony/require/php?style=flat-square)](https://packagist.org/packages/phil/websymfony)
[![Symfony Version](https://img.shields.io/badge/Symfony-8.2-black?logo=symfony)](https://symfony.com/8)
[![PHPStan level](https://img.shields.io/badge/PHPStan-level%20max-success?style=flat-square)](phpstan.neon)
[![Software License](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status (GitHub)](https://img.shields.io/github/actions/workflow/status/parler-haut-interagir-librement/WebSymfony/symfony.yml?branch=main&style=flat-square)](https://github.com/parler-haut-interagir-librement/WebSymfony/actions?query=workflow%3ASymfony+branch%3Amain)

## About 🖋

“**Proclaim** *Honestly*, **Interact** *Liberally*” **Web***Symfony* is a [Symfony 8.2](https://symfony.com/8) web
application template on steroids, ready to use: everything [MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony)
gives, plus what a web site needs from its first day — member accounts, security headers, an administration, a menu,
English and French —, with the same tests and quality gates.

WebSymfony is built on MicroSymfony, the PHIL version of [strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony),
created and maintained by [COil](https://github.com/COil) of [Strangebuzz](https://www.strangebuzz.com). It keeps its
name, its layout, its look (Pico CSS) and its spirit. It uses no PHIL package at run time: the PHIL tools — the PHIL UX
kit, phil-ux and the PHIL bundles — start with [WebSkeleton](#others-proclaim-honestly-interact-liberally-skeletons-).

## Table of Contents 📖

* [Demo](#demo-)
* [Quick-start](#quick-start-)
* [Requirements](#requirements-)
* [Stack](#stack-)
* [What it adds to MicroSymfony](#what-it-adds-to-microsymfony-)
* [Accounts and security](#accounts-and-security-)
* [Tasks](#tasks-)
* [Quality gates](#quality-gates-)
* [Notes](#notes-)
* [What it doesn't ship](#what-it-doesnt-ship-)
* [References](#references-)
* [Others “Proclaim Honestly, Interact Liberally” Skeletons](#others-proclaim-honestly-interact-liberally-skeletons-)
* [Contributing](#contributing-)
* [Security](#security-)
* [Credits](#credits-)
* [License](#license-)
* [Built with WebSymfony](#built-with-websymfony-)

## Demo 🌈

A demo of WebSymfony will run in the browser on [ph-il.ca](https://ph-il.ca), with the other templates of PHIL.

## Quick-start ⚡

Create a new project from the latest release:

    composer create-project phil/websymfony my-project && cd my-project

The repository is also a GitHub template repository: the "Use this template" button creates a new repository from the
main branch, whose commits all pass the continuous integration.

### With the Symfony binary 🕸️

You need the [Symfony binary](https://symfony.com/download#step-1-install-symfony-cli) and
[Castor](https://castor.jolicode.com/getting-started/installation/). The database is a SQLite file in `var/`:

    castor start

Open [https://127.0.0.1:8000](https://127.0.0.1:8000) (if port 8000 is free). The fixtures create two accounts:
`admin` (password `admin-password`), which reaches the administration, and `member` (password `member-password`);
never load them where the site is public. `castor stop` stops the server and
deletes the database.

### With FrankenPHP and PostgreSQL 🧟

You need [Docker](https://www.docker.com/). `compose.yaml` serves the application with
[FrankenPHP](https://frankenphp.dev/) in worker mode, which boots the kernel once and serves request after request,
and restarts its workers when a file changes; the database is PostgreSQL 17:

    castor up

Open [https://localhost](https://localhost). `castor down` stops the services. The image of `docker/Dockerfile` is
for development: an application deployed from this template brings its own deployment.

### With MySQL 🐬

MySQL is the other database the template supports. In `compose.yaml`, replace the `database` service with a
`mysql:8.4` image and set `DATABASE_URL` to:

    mysql://app:app@database:3306/app?serverVersion=8.4&charset=utf8mb4

With the Symfony binary, set the same variable in `.env.local`, with the host of your server. The migration is written
in the SQL of the database it runs on, so it needs no change.
## Requirements ⚙

* [PHP 8.5](https://www.php.net/releases/8.5/en.php) or later, with the extensions of `composer.json`, and
  [Castor](https://castor.jolicode.com)
* The [Symfony binary](https://symfony.com/download), or [Docker](https://www.docker.com)
* The [Xdebug](https://xdebug.org/) or [PCOV](https://github.com/krakjoe/pcov) extension for the code coverage report
## Stack 🔗

* [PHP 8.5](https://www.php.net/releases/8.5/en.php)
* [Symfony 8.2](https://symfony.com/8), from its release candidate, with [Symfony Security](https://symfony.com/doc/current/security.html)
* [Doctrine ORM 3 (DBAL 4)](https://www.doctrine-project.org), on SQLite, PostgreSQL or MySQL, with the
  [Doctrine extensions](https://github.com/doctrine-extensions/DoctrineExtensions)
* [Twig 3](https://twig.symfony.com) and [Symfony forms](https://symfony.com/doc/current/forms.html)
* [AssetMapper](https://symfony.com/doc/current/frontend/asset_mapper.html), [Stimulus 3.2](https://stimulus.hotwired.dev/) and [Turbo 8](https://turbo.hotwired.dev/), without Node.js
* [Pico CSS 2](https://picocss.com)
* [EasyAdmin 5](https://symfony.com/bundles/EasyAdminBundle/current/index.html)
* [PHPUnit 13](https://phpunit.de)
* [FrankenPHP](https://frankenphp.dev/) in worker mode, through Docker Compose

## What it adds to MicroSymfony 🚀

| Feature | Where |
|---|---|
| Sign-up, sign-in and sign-out, an account page | [src/Controller/Security](src/Controller/Security), [AccountAction](src/Controller/AccountAction.php) |
| Users with hashed passwords and roles, `ROLE_ADMIN` above `ROLE_USER` | [User](src/Entity/User.php), [security.php](config/packages/security.php) |
| An administration for `ROLE_ADMIN`, with the list of users | [src/Controller/Admin](src/Controller/Admin) |
| Security headers and a Content Security Policy with a nonce, by NelmioSecurityBundle | [nelmio_security.php](config/packages/nelmio_security.php) |
| Cross-origin requests on `/api/` only, by NelmioCorsBundle | [nelmio_cors.php](config/packages/nelmio_cors.php) |
| A main menu built by KnpMenu | [MainMenuBuilder](src/Menu/MainMenuBuilder.php) |
| English and French, chosen from the browser's language | [translations](translations), [translation.php](config/packages/translation.php) |
| Dates set by the Timestampable extension | [stof_doctrine_extensions.php](config/packages/stof_doctrine_extensions.php) |
| Errors sent to Sentry in production, when `SENTRY_DSN` is set | [sentry.php](config/packages/sentry.php) |
| The PHIL identity: logo, copyright, light and dark themes | [base.html.twig](templates/base.html.twig) |

Everything MicroSymfony has stays: the examples, the five test suites, Castor, the quality gates, Docker Compose.

## Accounts and security 🔐

* Passwords are hashed by the `auto` hasher; the session keeps a crc32c of the hash, never the hash, so a changed
  password still signs the other sessions out.
* The firewall checks the user again each time it is refreshed from the session (`user_checker_on_refresh`): a disabled
  or changed account is signed out on its next request.
* The sign-in, the sign-up and the sign-out carry a CSRF token; the sign-out is a POST.
* Five failed sign-ins a minute per user name and IP address, through `login_throttling`.
* Impersonation is off; when it is turned on, only by POST with a CSRF token.
* `/account` asks for `ROLE_USER`, `/admin` for `ROLE_ADMIN`.

## Tasks 🧰

`castor` lists every task. The main ones:

| Task | What it does |
|---|---|
| `castor start`, `castor stop` | The Symfony binary's web server with SQLite, its migrations and its fixtures. |
| `castor up`, `castor down` | FrankenPHP in worker mode and PostgreSQL, with Docker Compose. |
| `castor load-fixtures` | The SQLite database reset, migrated and filled. |
| `castor test` | Every PHPUnit suite; `--filter` and `--options` pass on to PHPUnit. |
| `castor test:unit`, `test:integration`, `test:api`, `test:functional`, `test:e2e` | One suite. |
| `castor test:next` | The tests on the next PHP version, in its Docker image. |
| `castor test:schema` | The migrations on a fresh SQLite database, then its schema compared with the Doctrine mapping. |
| `castor coverage` | The HTML coverage report in `var/coverage/`, and its threshold. |
| `castor infection` | Mutation testing. |
| `castor lint` | Every lint and the static analysis. |
| `castor fix` | Rector, PHP-CS-Fixer, Twig-CS-Fixer, Biome and composer-normalize. |
| `castor ci` | The continuous integration, locally: coverage, `test:schema`, then every lint. |
| `castor hooks` | The git hooks: the fast checks on the staged files before each commit. |
## Quality gates 🚦

The checks come from [`phil/dev-tools`](https://packagist.org/packages/phil/dev-tools), the shared tooling of PHIL,
adapted to an application. Each tool is installed in its own `vendor-bin/<tool>/` directory by the
[Composer bin plugin](https://github.com/bamarni/composer-bin-plugin), so that its dependencies never meet the
application's. The thin configuration files at the root (`phpstan.neon`, `rector.php`, `.php-cs-fixer.dist.php`,
`arkitect.php`) call the shared ones; `phil-dev.php` holds what is particular to the application, each exception with
its reason.

| Task | Checks |
|---|---|
| `castor lint:composer` | The dependency analysis (a class used without its package required), `composer audit`, composer-unused and composer-normalize. |
| `castor lint:php` | PHP-CS-Fixer: `@Symfony`, `@Symfony:risky`, strict types and strict comparisons. |
| `castor lint:twig` | `lint:twig`, then the code style of the templates. |
| `castor lint:js` | Biome on the Stimulus controllers. |
| `castor lint:yaml`, `lint:container`, `lint:doctrine` | The YAML files, the container and the Doctrine mapping. |
| `castor stan` | PHPStan at the maximum level, with type coverage at 100 %, a cognitive complexity limit and forbidden calls. |
| `castor lint:rector` | Rector has nothing left to change. |
| `castor lint:architecture` | Arkitect on the shape of the classes; Deptrac on the libraries `src/` may use, listed in `phil-dev.php`. |
## Notes 📒

### Symfony UX

Turbo forms are disabled in [assets/app.js](assets/app.js). To enable them for a form, add the `data-turbo="true"`
attribute to it, or set `Turbo.setFormMode` to `on` to enable them everywhere. In both cases, the controller has to be
[adapted](https://symfony.com/bundles/ux-turbo/current/index.html#3-form-response-code-changes).

### PHP configuration files

A Flex recipe can add YAML files to the project. They are loaded as they are; to convert them to PHP, follow the
other files of `config/packages`.

## What it doesn't ship 🙅

* No deployment file: each application brings its own.
* No PHIL package at run time: the PHIL UX kit, phil-ux and the PHIL bundles come with WebSkeleton.
* No e-mail: the sign-up asks for no confirmation and there is no password reset; add
  [symfonycasts/verify-email-bundle](https://github.com/SymfonyCasts/verify-email-bundle) and
  [symfonycasts/reset-password-bundle](https://github.com/SymfonyCasts/reset-password-bundle) when the site sends mail.

## References 📚

* [Introducing the MicroSymfony application template](https://www.strangebuzz.com/en/blog/introducing-the-microsymfony-application-template) (strangebuzz.com)
* [MicroSymfony 8: ready for the LTS promise](https://www.strangebuzz.com/en/blog/microsymfony-8-ready-for-the-lts-promise) (strangebuzz.com)
* [Initializing your Symfony project with solid foundations](https://www.strangebuzz.com/en/blog/initializing-your-symfony-project-with-solid-foundations) (strangebuzz.com)
* [Organizing your Symfony project tests](https://www.strangebuzz.com/en/blog/organizing-your-symfony-project-tests) (strangebuzz.com)
* [A better ADR pattern for your Symfony controllers](https://www.strangebuzz.com/en/blog/a-better-adr-pattern-for-your-symfony-controllers) (strangebuzz.com)
* [Castor, a journey across the sea of task runners](https://jolicode.com/blog/castor-a-journey-across-the-sea-of-task-runners) (jolicode.com)
* [PHPStan 2.0 Released With Level 10 and Elephpants!](https://phpstan.org/blog/phpstan-2-0-released-level-10-elephpants) (phpstan.org)
* [You should be using PHPStan's bleeding edge](https://backendtea.com/post/use-phpstan-bleeding-edge/) (backendtea.com)
* [A Good Naming Convention for Routes, Controllers and Templates?](https://jolicode.com/blog/a-good-naming-convention-for-routes-controllers-and-templates) (jolicode.com)
* [Front-end application development, Symfony-style(s)](https://dunglas.dev/2024/04/front-end-application-development-symfony-styles/) (dunglas.dev)
* [The Symfony Framework Best Practices](https://symfony.com/doc/current/best_practices.html) (symfony.com)
## Others “**Proclaim** Honestly, **Interact** Liberally” Skeletons 🩻

* [MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony) (`phil/microsymfony`): the micro
  template WebSymfony is built on, with no database, Pico CSS, Stimulus and Turbo, Castor, the tests and quality gates.
* [WebSkeleton](https://github.com/parler-haut-interagir-librement/WebSkeleton) (`phil/webskeleton`): WebSymfony and the
  PHIL tools, organised in DDD (Domain, Application, Infrastructure):
  * the [PHIL UX kit](https://github.com/parler-haut-interagir-librement/ux-kit) for the Symfony UX Toolkit and
    [`phil/ux-css`](https://github.com/parler-haut-interagir-librement/ux-css), the phil-ux stylesheet;
  * PHIL bundles: `phil/ddd-bundle`, `phil/doctrine-behaviours-bundle`, and, by a documented step,
    `phil/identity-client-bundle` for member accounts and `phil/ux-easyadmin-bundle` for an administration in the
    colours of PHIL UX;
  * French and English, routes prefixed `/fr` and `/en`, French by default.
* [ApiSymfony](https://github.com/parler-haut-interagir-librement/ApiSymfony) (`phil/apisymfony`): an API with
  [API Platform](https://api-platform.com), Castor, the tests and quality gates.

## Contributing 🤝

See [CONTRIBUTING](CONTRIBUTING.md) and the [Code of Conduct](CODE_OF_CONDUCT.md).

## Security 🧯

See [SECURITY](SECURITY.md).

## Credits 🙏

* [Philippe Gamache](https://ph-il.ca), maintainer, for [Parler Haut, Interagir Librement](https://ph-il.ca)
* [COil](https://github.com/COil), author of [strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony),
  and [its contributors](https://github.com/strangebuzz/MicroSymfony/graphs/contributors)
* [All the contributors of WebSymfony](https://github.com/parler-haut-interagir-librement/WebSymfony/graphs/contributors)

## License ⚖️

The MIT License, with the attribution to the original repository it asks for. See the [license file](LICENSE).

## Built with WebSymfony 🛠️

* [WebSkeleton](https://github.com/parler-haut-interagir-librement/WebSkeleton), which lists the sites built with it.
