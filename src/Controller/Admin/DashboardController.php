<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    // #[IsGranted('ROLE_ADMIN')]
    #[Route(
        path: '/admin/{_locale}',
        name: 'admin',
        requirements: [
            '_locale' => 'en|fr',
        ],
        locale: 'en',
    )]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('brand.html')
            ->setLocales(['en', 'fr'])
        ;
    }

    /** @noinspection MissingParentCallInspection */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToRoute('menu.home.title', 'fa fa-home', 'homepage');
        yield MenuItem::linkToUrl('menu.stimulus.title', 'fa fa-table', '/stimulus');

        // yield MenuItem::linkToLogout('Logout', 'fas fa-list');
    }
}
