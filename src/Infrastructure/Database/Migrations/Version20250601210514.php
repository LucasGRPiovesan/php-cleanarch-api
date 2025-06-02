<?php

declare(strict_types=1);

namespace Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250601210514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Criação da tabela tb_profile';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tb_profile');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('uuid', 'guid', ['notnull' => true]);
        $table->addColumn('profile', 'string', ['length' => 100]);
        $table->addColumn('description', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime_immutable');
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['uuid'], 'UNIQ_PROFILE_UUID');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tb_profile');
    }
}
