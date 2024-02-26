<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Admin;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
final class DashboardControllerTest extends WebTestCase
{
    /**
     * @see AppController::index()
     */
    public static function provideTestSimplePage(): Iterator
    {
        yield ['/admin'];
        yield ['/admin/en'];
        yield ['/admin/fr'];
    }

    #[DataProvider('provideTestSimplePage')]
    public function testSimplePage(string $page): void
    {
        $client = self::createClient();
        $client->request('GET', $page);
        self::assertResponseIsSuccessful("Page {$page} is not successfull.");
    }
}
