<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class MainMenuBuilder
{
    /**
     * Add any other dependency you need...
     */
    public function __construct(private FactoryInterface $factory, private TranslatorInterface $translator)
    {
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('main', $options);

        $menu->addChild('menu.home.text',
            [
                'route' => 'homepage',
                'linkAttributes' => ['title' => $this->translator->trans('menu.home.title')],
            ]
        );
        $menu->addChild('menu.stimulus.text',
            [
                'route' => 'app_stimulus',
                'linkAttributes' => ['title' => $this->translator->trans('menu.stimulus.title')],
            ]
        );
        $menu->addChild('menu.error.text',
            [
                'uri' => '/404',
                'linkAttributes' => ['title' => $this->translator->trans('menu.error.title')],
            ]
        );

        return $menu;
    }
}
