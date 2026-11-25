<?php

declare(strict_types=1);

namespace App\Tests\Integration\Menu;

use App\Menu\MainMenuBuilder;
use Knp\Menu\Provider\MenuProviderInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[CoversClass(MainMenuBuilder::class)]
final class MainMenuBuilderTest extends KernelTestCase
{
    public function testTheMainMenuLinksToTheExamplePagesInOrder(): void
    {
        $menu = self::getContainer()->get('knp_menu.menu_provider');
        self::assertInstanceOf(MenuProviderInterface::class, $menu);
        self::assertTrue($menu->has('main'));

        $items = [];
        foreach ($menu->get('main')->getChildren() as $name => $item) {
            $items[$name] = $item->getUri();
        }

        self::assertSame([
            'menu.readme' => '/',
            'menu.hello' => '/hello-world',
            'menu.stimulus' => '/stimulus',
            'menu.composer' => '/composer',
            'menu.form' => '/form',
            'menu.users' => '/users',
        ], $items);
    }
}
