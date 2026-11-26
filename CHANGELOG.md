# Changelog

All notable changes to this template are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to
[Semantic Versioning](https://semver.org/spec/v2.0.0.html). WebSymfony is built on
[MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony), which follows
[strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony).

## Unreleased

### Changed

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
