<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use Override;

/**
 * The roles of the users, besides ROLE_USER: a JSON list. The change is described through the schema API and written in
 * the SQL of the platform the migration runs on, so that the same migration runs on SQLite, PostgreSQL and MySQL.
 */
final class Version20261125120000 extends AbstractMigration
{
    private const string TABLE = 'user';

    private const string COLUMN = 'roles';

    #[Override]
    public function getDescription(): string
    {
        return 'The roles of the users';
    }

    public function up(Schema $schema): void
    {
        $before = $schema->getTable(self::TABLE);
        $after = $before->edit()
            ->addColumn(Column::editor()->setUnquotedName(self::COLUMN)->setTypeName(Types::JSON)->create())
            ->create();
        $this->alter($before, $after);
    }

    #[Override]
    public function down(Schema $schema): void
    {
        $before = $schema->getTable(self::TABLE);
        $this->alter($before, $before->edit()->dropColumnByUnquotedName(self::COLUMN)->create());
    }

    private function alter(Table $before, Table $after): void
    {
        $difference = $this->connection->createSchemaManager()->createComparator()->compareTables($before, $after);
        foreach ($this->platform->getAlterTableSQL($difference) as $sql) {
            $this->addSql($sql);
        }
    }
}
