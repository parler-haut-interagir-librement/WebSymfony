# “**Proclaim** *Honestly*, **Interact** *Liberally*” **Web***Symfony*

“**Proclaim** *Honestly*, **Interact** *Liberally*” **Web***Symfony* is a Symfony application skeleton on steroids, ready to use.

The purpose of **Web***Symfony* is to provide a sandbox with some sensible defaults and ready to use. 
It can be a solution if you want to quickly set up something, create a POC, test things, 
and even make a small "one-page" application.

It was base on [strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony) with adjustment
we're usually adding on all our projects. We also remove many examples. 

## Demo 🌈

Because a live demo is always better than all explanations. Here is it:

* Live demo will be available at [https://ph-il.ca/demos/websymfony](https://ph-il.ca/demos/websymfony)

## Requirements ⛮

All “**Proclaim** *Honestly*, **Interact** *Liberally*” project will use the latest version within 1/2 month depending on dependency availability.

* [PHP 8.2](https://www.php.net/releases/8.2/en.php)
* The [Symfony CLI](https://symfony.com/download)
* The [Xdebug](https://xdebug.org/) PHP extension if you want to run the code coverage report (optional but recommended)
* [Castor 0.9.1](https://github.com/jolicode/castor) task runner (optional)

## Stack 🔗

All “**Proclaim** Honestly, **Interact** Liberally” project will use the latest version within 1/2 month depending on dependency availability.

* [Symfony 6.3](https://symfony.com) 
* [Twig 3](https://twig.symfony.com)
* [Stimulus 3.3](https://stimulus.hotwired.dev/)
* [PHPUnit 9.6](https://phpunit.de)

## Features 🚀

**Web***Symfony* ships these features, ready to use:

* One task runner
  * Castor ([source](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/castor.php)) 
* Static analysis with PHPStan
  * [Configuration](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/phpstan.neon)
* Coding standards with php-cs-fixer
  * [Configuration](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/.php-cs-fixer.dist.php)
* Refactoring with Rector
  * [Configuration](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/restor.php)
* The debug toolbar ([doc](https://symfony.com/doc/current/profiler.html))
* Tests ([organisation](https://www.strangebuzz.com/en/blog/organizing-your-symfony-project-tests))
  * Unit test [example](https://github.com/parler-haut-interagir-librement/WebSymfony/tree/main/tests/Unit/Helper) 
  * Integration test [example](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/tests/Integration/Twig/Extension/ResponseExtensionTest.php) 
  * Functional test [example](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/tests/Functional/Controller/AppControllerTest.php) 
  * API test [example](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/tests/Api/Controller/SlugifyActionTest.php) 
  * E2E test [example](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/tests/E2E/Controller/AppControllerTest.php)
* Code coverage at 100%
  * [Output on CI](https://github.com/parler-haut-interagir-librement/WebSymfony/actions/runs/6191674576/job/16810366756)
  * [Failing output example](https://github.com/parler-haut-interagir-librement/WebSymfony/actions/runs/6176766049/job/16766431026)
* GitHub CI ([actions](https://github.com/parler-haut-interagir-librement/WebSymfony/actions))
  * [Tests job output](https://github.com/parler-haut-interagir-librement/WebSymfony/actions/runs/6191674576/job/16810366756)
  * [Lint job output](https://github.com/parler-haut-interagir-librement/WebSymfony/actions/runs/6191674576/job/16810366901)
* Asset mapper+Stimulus ([documentation](https://symfony.com/doc/current/frontend/asset_mapper.html))
  * Vanilla Js ([source](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/assets/controllers/hello_controller.js)) ([demo](https://ph-il.ca/demos/websymfony/stimulus))
  * Fetch on a JSON endpoint of the application ([source](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/assets/controllers/api_controller.js)) ([demo](https://ph-il.ca/demos/websymfony/stimulus)) 
* Symfony Maker ([documentation](https://symfony.com/bundles/SymfonyMakerBundle/current/index.html))
* A custom error template
  * [Source](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/templates/bundles/TwigBundle/Exception/error.html.twig)
  * [Demo](https://ph-il.ca/demos/microsymfony/404) 
* Database
  * Doctrine ([documentation](https://symfony.com/bundles/DoctrineBundle/current/index.html))
  * Doctrine Migrations ([documentation](https://symfony.com/bundles/DoctrineMigrationsBundle/current/index.html))
  * Doctrine Fixture ([documentation](https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html))
  * Doctrine Extensions ([configuration in sumfony](https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html)) ([documentation](https://github.com/doctrine-extensions/DoctrineExtensions/tree/main/doc))
* Object Menu ([example](https://github.com/parler-haut-interagir-librement/WebSymfony/tree/main/src/Menu/MainMenuBuilder.php))
* Security Layers
  * SymfonySecurity ([documentation](https://symfony.com/doc/current/security.html)) 
  * NelmioSecurityBundle ([documentation](https://symfony.com/bundles/NelmioSecurityBundle/current/index.html))
  * NelmioCorsBundle ([documentation]( https://symfony.com/bundles/NelmioCorsBundle/current/index.html))
* Admin
  * EasyAdmin ([documentation](https://symfony.com/bundles/EasyAdminBundle/current/index.html))

## Other good practices 👌

* Using strict types in all PHP files ([source](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/src/Controller/AppController.php))
* Using the ADR pattern in an action controller ([source](https://github.com/parler-haut-interagir-librement/WebSymfony/blob/main/src/Controller/SlugifyAction.php)) ([doc](https://symfony.com/doc/current/controller/service.html#invokable-controllers))

## Initializing an application with WebSymfony 🪄

### Initializing using composer
As the application template is [registered on Packagist](https://packagist.org/packages/phil/websymfony), 
you can use composer to install it with the following command:

```
$ composer create-project phil/websymfony
```

It creates a websymfony directory with the new project. 
In this case, you must set up Git and a repository yourself. 
But that's the fastest way to test it. 

Note that the composer install command downloads all the required dependencies and builds the assets.

### Initializing from Github site

Or use the GitHub template:

![Use this template button](https://raw.githubusercontent.com/parler-haut-interagir-librement/WebSymfony/bc7b206da4c04f48b915d9dc506a75025276b3a8/doc/use-this-template.png "Use this template")

### Initializing from Github CLI

```
$ gh repo create my-project --clone --private --template parler-haut-interagir-librement/WebSymfony
```

### Serving the application 
To serve the application with the Symfony binary, run:

```
$ symfony server:start --daemon
```

or use the castor command

```
$ castor symfony:start
```

The application is now available at https://127.0.0.1:8000 (considering your 8000 port is available). 


## References 📚

* https://jolicode.com/blog/castor-a-journey-across-the-sea-of-task-runners
* https://www.strangebuzz.com/en/blog/introducing-the-microsymfony-application-template (🇬🇧)

## Others “**Proclaim** Honestly, **Interact** Liberally” Skeletons 🩻

* [MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony)
  * Task runner
    * Castor
  * Static Analysis
    * PHPStan
  * Coding standards
    * php-cs-fixer
  * Refactoring
    * Rector
  * Debug toolbar
  * Tests
    * Unit test
    * Integration test
    * Functional test
    * API test
    * E2E test
  * GitHub CI
  * Asset mapper
  * Stimulus
  * Symfony Maker
  * Custom error template

* [ApiSymfony](https://github.com/parler-haut-interagir-librement/ApiSymfony)
  * API Platform
  * Task runner
    * Castor
  * Static Analysis
    * PHPStan
  * Coding standards
    * php-cs-fixer
  * Refactoring
    * Rector
  * Tests
    * Unit test
    * API test
    * E2E test
  * GitHub CI
  * Symfony Maker

* [WebSkeleton](https://github.com/parler-haut-interagir-librement/WebSkeleton)
  * WebSymfony +
  * “**Proclaim** Honestly, **Interact** Liberally” Bundles
    * PhilBodyBundle - Add Base Twig Components
    * more to come
  * more.
