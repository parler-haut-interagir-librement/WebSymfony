<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use App\Controller\HomeAction;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Panther\PantherTestCase;

/**
 * The home page in a real browser, Chrome driven by Panther: the Stimulus controller of the header sets the colour
 * scheme on <html data-theme> and hides the icon of the dark theme, so seeing both proves that the JavaScript of the
 * page runs under the Content Security Policy. Run by `castor test:e2e` alone; Chrome and chromedriver must be on the
 * PATH.
 *
 * @see https://github.com/symfony/panther
 */
#[CoversClass(HomeAction::class)]
final class HomePageTest extends PantherTestCase
{
    public function testTheJavaScriptOfTheHomePageRuns(): void
    {
        $client = self::createPantherClient(['hostname' => 'localhost']);
        $client->request('GET', '/');

        self::assertSelectorTextContains('body', 'MicroSymfony');

        $client->waitFor('html[data-theme="light"]', 10);
        self::assertSelectorIsNotVisible('a.theme-icon[data-header-target="darkEmoji"]');
    }
}
