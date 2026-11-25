<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Controller\HomeAction;
use App\Menu\MainMenuBuilder;
use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * What every page shares: the security headers, the language of the visitor, the menu, Pico CSS and the PHIL identity.
 */
#[CoversClass(HomeAction::class)]
#[CoversClass(MainMenuBuilder::class)]
final class LayoutTest extends WebTestCase
{
    public function testEveryResponseCarriesTheSecurityHeaders(): void
    {
        $client = self::createClient();
        $client->request('GET', '/hello-world');

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('X-Frame-Options', 'DENY');
        self::assertResponseHeaderSame('X-Content-Type-Options', 'nosniff');
        self::assertResponseHeaderSame('Referrer-Policy', 'no-referrer, strict-origin-when-cross-origin');
        $policy = (string) $client->getResponse()->headers->get('Content-Security-Policy');
        self::assertStringContainsString("default-src 'self'", $policy);
        self::assertStringContainsString("object-src 'none'", $policy);
        self::assertStringContainsString("frame-ancestors 'none'", $policy);
        self::assertMatchesRegularExpression("/script-src 'self' 'nonce-[^']+'/", $policy);
    }

    public function testTheInlineScriptsCarryTheNonceOfThePolicy(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/hello-world');

        self::assertSame(1, preg_match("/'nonce-([^']+)'/", (string) $client->getResponse()->headers->get('Content-Security-Policy'), $nonce));
        foreach ($crawler->filter('script:not([src])') as $script) {
            self::assertInstanceOf(DOMElement::class, $script);
            self::assertSame($nonce[1], $script->getAttribute('nonce'));
        }
    }

    public function testThePageIsInEnglishByDefaultAndInFrenchWhenAsked(): void
    {
        $client = self::createClient();
        $client->request('GET', '/hello-world');
        self::assertSelectorExists('html[lang="en"]');
        self::assertSelectorTextContains('header', 'Sign in');
        self::assertResponseHeaderSame('Content-Language', 'en');

        $client->request('GET', '/hello-world', server: ['HTTP_ACCEPT_LANGUAGE' => 'fr-CA,fr;q=0.9,en;q=0.5']);
        self::assertSelectorExists('html[lang="fr"]');
        self::assertSelectorTextContains('header', 'Se connecter');
        self::assertSelectorTextContains('header nav', 'Bonjour le monde !');
        self::assertSelectorTextContains('footer', 'Tous droits réservés');
        self::assertResponseHeaderSame('Content-Language', 'fr');
    }

    public function testThePageLoadsPicoThroughTheImportmapAndOffersTheMenuAndTheThemeSwitch(): void
    {
        $client = self::createClient();
        $client->request('GET', '/hello-world');

        self::assertSelectorExists('link[rel="stylesheet"][href*="pico"]');
        self::assertSelectorExists('header[data-controller="header"]');
        self::assertSelectorExists('header nav a[href="/hello-world"][aria-current="page"]');
        self::assertSelectorCount(1, 'header nav a[aria-current]');
        self::assertSelectorTextContains('footer', 'Proclaim Honestly, Interact Liberally');
        self::assertSelectorExists('footer a[href="https://ph-il.ca"]');
    }
}
