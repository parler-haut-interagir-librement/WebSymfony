<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Controller\ComposerAction;
use App\Controller\FormAction;
use App\Controller\HelloWorldAction;
use App\Controller\HomeAction;
use App\Controller\ListUsersAction;
use App\Controller\SlugifyAction;
use Phil\DevTools\Testing\RouteSmokeTesting;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Every GET route of the application answers without a server error: a new page is tested as soon as its route exists.
 * The routes whose parameters have no default, such as the detail page of a user in the administration, are left out,
 * and so are the profiler and the error pages, named `_…`; the pages that require a signed-in member answer with the
 * redirection to the login page.
 */
#[CoversClass(ComposerAction::class)]
#[CoversClass(FormAction::class)]
#[CoversClass(HelloWorldAction::class)]
#[CoversClass(HomeAction::class)]
#[CoversClass(ListUsersAction::class)]
#[CoversClass(SlugifyAction::class)]
final class RouteSmokeTest extends WebTestCase
{
    use RouteSmokeTesting;
}
