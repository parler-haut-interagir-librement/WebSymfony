<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\HomeAction;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Menu\MenuItemInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Override;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * The administration, for ROLE_ADMIN only.
 *
 * @see DashboardControllerTest
 */
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
#[IsGranted(User::ROLE_ADMIN)]
final class DashboardController extends AbstractDashboardController
{
    public function __construct(
        #[Autowire(param: 'brand')]
        private readonly string $brand,
    ) {
    }

    #[Override]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    #[Override]
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->brand)
            ->setTranslationDomain('messages')
            ->setLocales(['en', 'fr'])
        ;
    }

    /**
     * @return iterable<MenuItemInterface>
     */
    #[Override]
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('admin.menu.dashboard', 'fa fa-gauge');
        yield MenuItem::linkTo(UserCrudController::class, 'admin.menu.users', 'fa fa-users');
        yield MenuItem::linkToRoute('admin.menu.site', 'fa fa-house', HomeAction::class);
        yield MenuItem::linkToLogout('admin.menu.logout', 'fa fa-right-from-bracket');
    }
}
