<!-- phil-dev source-sha256=b43b8b7062018d80d2adc2f00ab3ed0592850e3e6cfb7f8e5f175b01328f6650 -->
# WebSymfony 🕸️

[![Latest Version](https://img.shields.io/packagist/v/phil/websymfony.svg?style=flat-square)](https://packagist.org/packages/phil/websymfony)
[![PHP Version Require](https://poser.pugx.org/phil/websymfony/require/php?style=flat-square)](https://packagist.org/packages/phil/websymfony)
[![Symfony Version](https://img.shields.io/badge/Symfony-8.2-black?logo=symfony)](https://symfony.com/8)
[![PHPStan level](https://img.shields.io/badge/PHPStan-level%20max-success?style=flat-square)](phpstan.neon)
[![Software License](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status (GitHub)](https://img.shields.io/github/actions/workflow/status/parler-haut-interagir-librement/WebSymfony/symfony.yml?branch=main&style=flat-square)](https://github.com/parler-haut-interagir-librement/WebSymfony/actions?query=workflow%3ASymfony+branch%3Amain)

## À propos 🖋

« **Parler** *Haut*, **Interagir** *Librement* » **Web***Symfony* est un gabarit d'application web
[Symfony 8.2](https://symfony.com/8) survitaminé et prêt à l'emploi : tout ce que donne
[MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony), plus ce dont un site web a besoin dès
son premier jour — des comptes de membres, des en-têtes de sécurité, une administration, un menu, le français et
l'anglais —, avec les mêmes tests et les mêmes portes de qualité.

WebSymfony est bâti sur MicroSymfony, la version PHIL de [strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony),
créé et maintenu par [COil](https://github.com/COil) de [Strangebuzz](https://www.strangebuzz.com). Il en garde le nom,
la disposition, l'allure (Pico CSS) et l'esprit. Il n'utilise aucun paquet PHIL à l'exécution : les outils PHIL — le kit
PHIL UX, phil-ux et les bundles PHIL — commencent avec [WebSkeleton](#les-autres-gabarits--parler-haut-interagir-librement--).

## Table des matières 📖

* [Démo](#démo-)
* [Démarrage rapide](#démarrage-rapide-)
* [Prérequis](#prérequis-)
* [Pile technologique](#pile-technologique-)
* [Ce qu'il ajoute à MicroSymfony](#ce-quil-ajoute-à-microsymfony-)
* [Comptes et sécurité](#comptes-et-sécurité-)
* [Tâches](#tâches-)
* [Portes de qualité](#portes-de-qualité-)
* [Notes](#notes-)
* [Ce qu'il ne livre pas](#ce-quil-ne-livre-pas-)
* [Références](#références-)
* [Les autres gabarits « Parler Haut, Interagir Librement »](#les-autres-gabarits--parler-haut-interagir-librement--)
* [Contribuer](#contribuer-)
* [Sécurité](#sécurité-)
* [Crédits](#crédits-)
* [Licence](#licence-)
* [Bâti avec WebSymfony](#bâti-avec-websymfony-)

## Démo 🌈

Une démo de WebSymfony tournera dans le navigateur sur [ph-il.ca](https://ph-il.ca), avec les autres gabarits de PHIL.

## Démarrage rapide ⚡

Créez un nouveau projet à partir de la dernière version :

    composer create-project phil/websymfony my-project && cd my-project

Le dépôt est aussi un dépôt gabarit de GitHub : le bouton « Use this template » crée un nouveau dépôt à partir de la
branche principale, dont tous les commits passent l'intégration continue.

### Avec le binaire Symfony 🕸️

Il vous faut le [binaire Symfony](https://symfony.com/download#step-1-install-symfony-cli) et
[Castor](https://castor.jolicode.com/getting-started/installation/). La base de données est un fichier SQLite dans
`var/` :

    castor start

Ouvrez [https://127.0.0.1:8000](https://127.0.0.1:8000) (si le port 8000 est libre). Les données de départ créent deux
comptes : `admin` (mot de passe `admin-password`), qui accède à l'administration, et `member` (mot de passe
`member-password`) ; ne les chargez jamais là où le site est public. `castor stop` arrête le serveur
et supprime la base de données.

### Avec FrankenPHP et PostgreSQL 🧟

Il vous faut [Docker](https://www.docker.com/). `compose.yaml` sert l'application avec
[FrankenPHP](https://frankenphp.dev/) en mode *worker*, qui démarre le noyau une seule fois, sert requête après
requête et redémarre ses *workers* quand un fichier change ; la base de données est PostgreSQL 17 :

    castor up

Ouvrez [https://localhost](https://localhost). `castor down` arrête les services. L'image de `docker/Dockerfile` est
destinée au développement : une application déployée à partir de ce gabarit apporte son propre déploiement.

### Avec MySQL 🐬

MySQL est l'autre base de données que le gabarit prend en charge. Dans `compose.yaml`, remplacez le service
`database` par une image `mysql:8.4` et donnez à `DATABASE_URL` la valeur :

    mysql://app:app@database:3306/app?serverVersion=8.4&charset=utf8mb4

Avec le binaire Symfony, définissez la même variable dans `.env.local`, avec l'hôte de votre serveur. La migration
est écrite dans le SQL de la base de données sur laquelle elle s'exécute : elle n'a besoin d'aucun changement.
## Prérequis ⚙

* [PHP 8.5](https://www.php.net/releases/8.5/en.php) ou plus récent, avec les extensions de `composer.json`, et
  [Castor](https://castor.jolicode.com)
* Le [binaire Symfony](https://symfony.com/download), ou [Docker](https://www.docker.com)
* L'extension [Xdebug](https://xdebug.org/) ou [PCOV](https://github.com/krakjoe/pcov) pour le rapport de couverture
  de code
## Pile technologique 🔗

* [PHP 8.5](https://www.php.net/releases/8.5/en.php)
* [Symfony 8.2](https://symfony.com/8), dès sa version candidate, avec [Symfony Security](https://symfony.com/doc/current/security.html)
* [Doctrine ORM 3 (DBAL 4)](https://www.doctrine-project.org), sur SQLite, PostgreSQL ou MySQL, avec les
  [extensions Doctrine](https://github.com/doctrine-extensions/DoctrineExtensions)
* [Twig 3](https://twig.symfony.com) et les [formulaires Symfony](https://symfony.com/doc/current/forms.html)
* [AssetMapper](https://symfony.com/doc/current/frontend/asset_mapper.html), [Stimulus 3.2](https://stimulus.hotwired.dev/) et [Turbo 8](https://turbo.hotwired.dev/), sans Node.js
* [Pico CSS 2](https://picocss.com)
* [EasyAdmin 5](https://symfony.com/bundles/EasyAdminBundle/current/index.html)
* [PHPUnit 13](https://phpunit.de)
* [FrankenPHP](https://frankenphp.dev/) en mode worker, par Docker Compose

## Ce qu'il ajoute à MicroSymfony 🚀

| Fonctionnalité | Où |
|---|---|
| Inscription, connexion et déconnexion, une page de compte | [src/Controller/Security](src/Controller/Security), [AccountAction](src/Controller/AccountAction.php) |
| Des utilisateurs aux mots de passe hachés et aux rôles, `ROLE_ADMIN` au-dessus de `ROLE_USER` | [User](src/Entity/User.php), [security.php](config/packages/security.php) |
| Une administration pour `ROLE_ADMIN`, avec la liste des utilisateurs | [src/Controller/Admin](src/Controller/Admin) |
| Des en-têtes de sécurité et une politique de sécurité du contenu avec un nonce, par NelmioSecurityBundle | [nelmio_security.php](config/packages/nelmio_security.php) |
| Les requêtes d'autres origines sur `/api/` seulement, par NelmioCorsBundle | [nelmio_cors.php](config/packages/nelmio_cors.php) |
| Un menu principal construit par KnpMenu | [MainMenuBuilder](src/Menu/MainMenuBuilder.php) |
| L'anglais et le français, choisis d'après la langue du navigateur | [translations](translations), [translation.php](config/packages/translation.php) |
| Des dates posées par l'extension Timestampable | [stof_doctrine_extensions.php](config/packages/stof_doctrine_extensions.php) |
| Les erreurs envoyées à Sentry en production, quand `SENTRY_DSN` est défini | [sentry.php](config/packages/sentry.php) |
| L'identité PHIL : logo, droit d'auteur, thèmes clair et sombre | [base.html.twig](templates/base.html.twig) |

Tout ce que MicroSymfony contient reste : les exemples, les cinq suites de tests, Castor, les portes de qualité, Docker
Compose.

## Comptes et sécurité 🔐

* Les mots de passe sont hachés par le hacheur `auto` ; la session garde un crc32c du haché, jamais le haché, si bien
  qu'un mot de passe changé déconnecte encore les autres sessions.
* Le pare-feu vérifie l'utilisateur chaque fois qu'il est rechargé depuis la session (`user_checker_on_refresh`) : un
  compte désactivé ou changé est déconnecté à sa requête suivante.
* La connexion, l'inscription et la déconnexion portent un jeton CSRF ; la déconnexion est un POST.
* Cinq connexions échouées par minute par nom d'utilisateur et adresse IP, par `login_throttling`.
* L'usurpation d'identité est désactivée ; une fois activée, seulement par POST avec un jeton CSRF.
* `/account` demande `ROLE_USER`, `/admin` demande `ROLE_ADMIN`.

## Tâches 🧰

`castor` liste toutes les tâches. Les principales :

| Tâche | Ce qu'elle fait |
|---|---|
| `castor start`, `castor stop` | Le serveur Web du binaire Symfony avec SQLite, ses migrations et ses jeux de données d'essai. |
| `castor up`, `castor down` | FrankenPHP en mode *worker* et PostgreSQL, avec Docker Compose. |
| `castor load-fixtures` | La base de données SQLite remise à zéro, migrée et remplie. |
| `castor test` | Toutes les suites PHPUnit ; `--filter` et `--options` sont transmis à PHPUnit. |
| `castor test:unit`, `test:integration`, `test:api`, `test:functional`, `test:e2e` | Une seule suite. |
| `castor test:next` | Les tests sur la prochaine version de PHP, dans son image Docker. |
| `castor coverage` | Le rapport de couverture HTML dans `var/coverage/`, et son seuil. |
| `castor infection` | Les tests de mutation. |
| `castor lint` | Tous les *linters* et l'analyse statique. |
| `castor fix` | Rector, PHP-CS-Fixer, Twig-CS-Fixer, Biome et composer-normalize. |
| `castor ci` | L'intégration continue, en local : la couverture, puis tous les *linters*. |
| `castor hooks` | Les crochets git : les vérifications rapides sur les fichiers indexés avant chaque commit. |
## Portes de qualité 🚦

Les vérifications viennent de [`phil/dev-tools`](https://packagist.org/packages/phil/dev-tools), l'outillage commun de
PHIL, adapté à une application. Chaque outil est installé dans son propre répertoire `vendor-bin/<tool>/` par le
[plugin Composer bin](https://github.com/bamarni/composer-bin-plugin), pour que ses dépendances ne croisent jamais
celles de l'application. Les fichiers de configuration minces à la racine (`phpstan.neon`, `rector.php`,
`.php-cs-fixer.dist.php`, `arkitect.php`) appellent les fichiers communs ; `phil-dev.php` contient ce qui est propre à
l'application, chaque exception avec sa raison.

| Tâche | Vérifie |
|---|---|
| `castor lint:composer` | L'analyse des dépendances (une classe utilisée sans que son paquet soit requis), `composer audit`, composer-unused et composer-normalize. |
| `castor lint:php` | PHP-CS-Fixer : `@Symfony`, `@Symfony:risky`, types stricts et comparaisons strictes. |
| `castor lint:twig` | `lint:twig`, puis le style de code des gabarits. |
| `castor lint:js` | Biome sur les contrôleurs Stimulus. |
| `castor lint:yaml`, `lint:container`, `lint:doctrine` | Les fichiers YAML, le conteneur et le mappage Doctrine. |
| `castor stan` | PHPStan au niveau maximal, avec une couverture des types de 100 %, une limite de complexité cognitive et des appels interdits. |
| `castor lint:rector` | Rector n'a plus rien à changer. |
| `castor lint:architecture` | Arkitect sur la forme des classes ; Deptrac sur les bibliothèques que `src/` peut utiliser, listées dans `phil-dev.php`. |
## Notes 📒

### Symfony UX

Les formulaires Turbo sont désactivés dans [assets/app.js](assets/app.js). Pour les activer pour un formulaire,
ajoutez-lui l'attribut `data-turbo="true"`, ou donnez à `Turbo.setFormMode` la valeur `on` pour les activer partout.
Dans les deux cas, le contrôleur doit être
[adapté](https://symfony.com/bundles/ux-turbo/current/index.html#3-form-response-code-changes).

### Fichiers de configuration PHP

Une recette Flex peut ajouter des fichiers YAML au projet. Ils sont chargés tels quels ; pour les convertir en PHP,
suivez les autres fichiers de `config/packages`.

## Ce qu'il ne livre pas 🙅

* Aucun fichier de déploiement : chaque application apporte le sien.
* Aucun paquet PHIL à l'exécution : le kit PHIL UX, phil-ux et les bundles PHIL viennent avec WebSkeleton.
* Aucun courriel : l'inscription ne demande pas de confirmation et il n'y a pas de réinitialisation du mot de passe ;
  ajoutez [symfonycasts/verify-email-bundle](https://github.com/SymfonyCasts/verify-email-bundle) et
  [symfonycasts/reset-password-bundle](https://github.com/SymfonyCasts/reset-password-bundle) quand le site envoie du
  courriel.

## Références 📚

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
## Les autres gabarits « **Parler** Haut, **Interagir** Librement » 🩻

* [MicroSymfony](https://github.com/parler-haut-interagir-librement/MicroSymfony) (`phil/microsymfony`) : le gabarit
  micro sur lequel WebSymfony est bâti, sans base de données, avec Pico CSS, Stimulus et Turbo, Castor, les tests et les
  portes de qualité.
* [WebSkeleton](https://github.com/parler-haut-interagir-librement/WebSkeleton) (`phil/webskeleton`) : WebSymfony et les
  outils PHIL, organisé en DDD (Domain, Application, Infrastructure) :
  * le [kit PHIL UX](https://github.com/parler-haut-interagir-librement/ux-kit) pour le Toolkit de Symfony UX et
    [`phil/ux-css`](https://github.com/parler-haut-interagir-librement/ux-css), la feuille de style phil-ux ;
  * des bundles PHIL : `phil/ddd-bundle`, `phil/doctrine-behaviours-bundle` et, par une étape documentée,
    `phil/identity-client-bundle` pour les comptes de membres et `phil/ux-easyadmin-bundle` pour une administration aux
    couleurs de PHIL UX ;
  * le français et l'anglais, des routes préfixées `/fr` et `/en`, le français par défaut.
* [ApiSymfony](https://github.com/parler-haut-interagir-librement/ApiSymfony) (`phil/apisymfony`) : une API avec
  [API Platform](https://api-platform.com), Castor, les tests et les portes de qualité.

## Contribuer 🤝

Voyez [CONTRIBUTING](CONTRIBUTING.md) et le [code de conduite](CODE_OF_CONDUCT.md).

## Sécurité 🧯

Voyez [SECURITY](SECURITY.md).

## Crédits 🙏

* [Philippe Gamache](https://ph-il.ca), mainteneur, pour [Parler Haut, Interagir Librement](https://ph-il.ca)
* [COil](https://github.com/COil), auteur de [strangebuzz/MicroSymfony](https://github.com/strangebuzz/MicroSymfony),
  et [ses contributeurs](https://github.com/strangebuzz/MicroSymfony/graphs/contributors)
* [Tous les contributeurs de WebSymfony](https://github.com/parler-haut-interagir-librement/WebSymfony/graphs/contributors)

## Licence ⚖️

La licence MIT, avec l'attribution au dépôt d'origine qu'elle demande. Voyez le [fichier de licence](LICENSE).

## Bâti avec WebSymfony 🛠️

* [WebSkeleton](https://github.com/parler-haut-interagir-librement/WebSkeleton), qui énumère les sites bâtis avec lui.
