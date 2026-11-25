<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Override;

/**
 * The accounts, listed and shown; they are created by signing up, so the administration neither creates nor edits
 * them.
 *
 * @extends AbstractCrudController<User>
 *
 * @see DashboardControllerTest
 */
final class UserCrudController extends AbstractCrudController
{
    #[Override]
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    #[Override]
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('admin.user.singular')
            ->setEntityLabelInPlural('admin.user.plural')
            ->setDefaultSort(['id' => 'ASC'])
        ;
    }

    #[Override]
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT)
        ;
    }

    /**
     * @return iterable<IdField|TextField|EmailField|ArrayField|DateTimeField>
     */
    #[Override]
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('username', 'admin.user.username');
        yield EmailField::new('email', 'admin.user.email');
        yield ArrayField::new('roles', 'admin.user.roles');
        yield DateTimeField::new('createdAt', 'admin.user.created_at');
    }
}
