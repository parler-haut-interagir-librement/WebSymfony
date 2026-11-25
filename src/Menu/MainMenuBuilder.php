<?php

declare(strict_types=1);

namespace App\Menu;

use App\Controller\ComposerAction;
use App\Controller\FormAction;
use App\Controller\HelloWorldAction;
use App\Controller\HomeAction;
use App\Controller\ListUsersAction;
use Knp\Menu\Attribute\AsMenuBuilder;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

/**
 * The main menu of the site, rendered by knp_menu_render('main') in base.html.twig. Its labels are translation keys.
 *
 * @see MainMenuBuilderTest
 */
final readonly class MainMenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
    ) {
    }

    #[AsMenuBuilder(name: 'main')]
    public function createMainMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('main');
        $menu->addChild('menu.readme', ['route' => HomeAction::class]);
        $menu->addChild('menu.hello', ['route' => HelloWorldAction::class]);
        $menu->addChild('menu.stimulus', ['route' => 'App\Controller\StimulusAction']);
        $menu->addChild('menu.composer', ['route' => ComposerAction::class]);
        $menu->addChild('menu.form', ['route' => FormAction::class]);
        $menu->addChild('menu.users', ['route' => ListUsersAction::class]);

        return $menu;
    }
}
