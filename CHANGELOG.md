# Changelog

All notable changes to this template are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to
[Semantic Versioning](https://semver.org/spec/v2.0.0.html). WebSymfony is built on
[MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony), which follows
[strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony).

## Unreleased

The next version is 8.2.0-RC3.

### Added

- `symfony/panther` 2.4 as a development requirement, its `ServerExtension` in `phpunit.dist.xml` and its variables in
  `.env.test`: the E2E suite, `HomePageTest`, opens the home page in Chrome on `localhost` and waits for the Stimulus
  controller of the header to set `data-theme` on `<html>` and hide the icon of the dark theme, which proves that the
  JavaScript of the page runs under the Content Security Policy. `castor test:e2e` runs it alone, with Chrome and
  chromedriver on the `PATH`; the suite is left out of the `suites` of `PHIL_CASTOR`, so `castor test`,
  `castor coverage`, `castor ci` and the continuous integration need no browser.

### Fixed

- The stylesheets, Pico CSS then `styles/app.css`, are linked from `base.html.twig` instead of imported by
  `assets/app.js`: AssetMapper turned each imported stylesheet into a `data:` module of the import map, which the
  Content Security Policy of NelmioSecurityBundle refuses, so the module `app`, Stimulus, Turbo and every controller
  never ran in a browser.

## [8.2.0-RC2] - 2026-11-26

### Added

- `RouteSmokeTest` in the functional suite, from `Phil\DevTools\Testing\RouteSmokeTesting`: every GET route answers
  under 500, a new route included as soon as it exists; it replaces `StaticRoutesSmokeTest`.
- `castor test:suite <name>`, one suite of `phpunit.dist.xml` by its name, and `castor taint`, the taint analysis of
  Psalm, installed in `vendor-bin/psalm/`.

### Changed

- `castor.php` imports the common tasks of `phil/dev-tools` (`vendor/phil/dev-tools/resources/castor/tasks.php`) and
  sets the suites, the coverage threshold and the YAML paths in its `PHIL_CASTOR` constant, with `lint:doctrine` run
  by `castor lint` and `test:schema` by `castor ci`; it keeps only the template's own tasks: the servers of the
  Symfony binary and Docker Compose, `go-prod`, `go-dev`, `purge`, `load-fixtures`, `test:schema`, `lint:doctrine` and
  `check-requirements`. The task names, and the ones the README and the GitHub Actions workflow call, stay the same.
  `test:coverage` reads the percentage of covered lines itself: `bin/coverage-checker.php` is gone, and PHPUnit writes
  its output without colors.
- `phil/dev-tools` ^0.2.1@alpha.
- Every requirement of `composer.json` and of `vendor-bin/*/composer.json` at its latest minor release: the Symfony
  components at `8.2.*`, `doctrine/dbal` ^4.6, `doctrine/doctrine-bundle` ^3.4, `doctrine/migrations` ^3.10,
  `doctrine/orm` ^3.8, `doctrine/persistence` ^4.2, `symfony/ux-turbo` and `symfony/stimulus-bundle` ^3.8,
  `twig/twig`, `twig/extra-bundle` and `twig/markdown-extra` ^3.31, `league/commonmark` ^2.10, `symfony/flex` ^2.12,
  `symfony/monolog-bundle` ^4.1, `symfony/cache-contracts` ^3.8, `zenstruck/foundry` ^2.17, PHPUnit ^13.4, ParaTest
  ^7.30, `ergebnis/phpunit-slow-test-detector` ^2.29, `bamarni/composer-bin-plugin` ^1.9, `symfony/maker-bundle`
  ^1.68, Infection ^0.35, Rector ^2.9, `phpstan/phpstan-doctrine` ^2.1, composer-normalize ^2.59, Twig-CS-Fixer ^4.2,
  TwigStan ^0.2.8 and composer-unused ^0.9.9.
- The configuration back in YAML: `config/packages/*.yaml` with `when@dev`, `when@test` and `when@prod` blocks,
  `config/routes.yaml`, `config/routes/*.yaml` and `config/services.yaml`; only `config/bundles.php` and
  `config/preload.php` stay PHP. `castor lint:yaml` checks `config/` too.

## [8.2.0-RC1] - 2026-11-25

### Added

- Everything MicroSymfony gives: Doctrine ORM with a `User` entity, its Foundry factory and story, the examples, the
  five test suites, Castor tasks, the quality gates of `phil/dev-tools`, `compose.yaml` with FrankenPHP in worker mode
  and PostgreSQL, MySQL documented as the other choice.
- Accounts: sign-up with a Symfony form and its validation, form sign-in with CSRF and throttling, sign-out by POST
  with CSRF, an account page, `ROLE_ADMIN` above `ROLE_USER`, `user_checker_on_refresh` on the firewall, the session
  keeping a crc32c of the password hash.
- A migration adding the roles of the users, described through the DBAL schema API.
- Fixtures with an administrator and a member whose passwords the README gives, for development only.
- An EasyAdmin dashboard for `ROLE_ADMIN`, with the users listed and shown.
- Security headers and a Content Security Policy with a nonce by NelmioSecurityBundle; cross-origin requests on
  `/api/` only by NelmioCorsBundle.
- A KnpMenu main menu, English and French translations chosen from the browser's language, the Timestampable extension,
  Sentry in production.
- The PHIL identity in the layout: logo, copyright of Parler Haut, Interagir Librement, light and dark themes on Pico CSS.
- The security files of `phil/dev-tools` in `.github/`: Dependabot with a cooldown of seven days, the OpenSSF
  Scorecard and zizmor; the actions of every workflow pinned to a commit, the checkout without credentials.

### Changed

- Symfony 8.2 from its first release candidate, on PHP 8.5 or later, every other dependency at its latest version.
- The configuration in PHP files, the tasks in Castor only, no script in `composer.json`.
- `castor lint:doctrine` checks the Doctrine mapping only, so the lint job runs without a database;
  `castor test:schema` runs the migrations on a fresh SQLite database and compares its schema with the mapping, in
  `castor ci` and in the tests job of the workflow.

### Removed

- Tailwind, Flowbite, Scrutinizer, Biome as a bundle and the YAML configuration.

## [7.0.1] - 2024-02-24

### Changed

- Upgrade Symfony to 7.0.4

### Fixed

- Fix CI Workflow
- Fix PHPUnit 11 change in php-cs-fixer

## [7.0.0] - 2024-02-24

Now the major and minor version is sync with the symfony major and minor version

### Added

- Add symfony/requirements-checker 2.0
- Add bamarni/composer-bin-plugin
- Add many functions to Castor

### Changed

- Upgrade requirement to PHP 8.3
- Upgrade Symfony to 7.0
- Upgrade Twig to 3.8
- Upgrade PHPUnit to 11
- Upgrade Castor to 0.13
- Upgrade to Rector to 1.0
- Upgrade Symfony Maker to 1.55
- Move PHP CS Fixer to use bamarni/composer-bin-plugin
- Better .gitignore
- More pleasing configurations for PHP CS Fixer
- More pleasing configurations for Rector

### Removed

- No more Annotations, all in Attributes

## [0.2.0] - 2023-11-16

### Added

- Add symfony/panther
- Add symfony/var-dumper

### Changed

- Upgrade to Symfony 6.3.8
- Update Rector Config
- Rename phpstan.neon (for local only) to phpstan.dist.neon
- Upgrade Flex to 2.4.1
- Upgrade MonologBundle to 3.10.0
- Upgrade StimulusBundle to 2.13.2
- Upgrade PhpCsFixer to 3.38.2

### Fixed

- Fix Others Skeletons Sections in README.md
- Fix Demo URLs in README.md

## [0.1.2] - 2023-09-19

### Fixed

- Fix Others Skeletons Sections in README.md
- Fix Demo URLs in README.md

## [0.1.1] - 2023-09-14

### Fixed

- Fix texts in README.md
- Fix URLs in README.md

## [0.1.0] - 2023-09-13

First beta release
