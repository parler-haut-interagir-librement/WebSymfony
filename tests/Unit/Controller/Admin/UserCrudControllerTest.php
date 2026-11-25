<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Admin;

use App\Controller\Admin\UserCrudController;
use App\Entity\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UserCrudController::class)]
final class UserCrudControllerTest extends TestCase
{
    public function testItManagesTheUsers(): void
    {
        self::assertSame(User::class, UserCrudController::getEntityFqcn());
    }
}
