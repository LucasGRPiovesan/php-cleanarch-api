<?php

declare(strict_types=1);

namespace Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250601210515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Criação da tabela tb_user com relacionamento 1:N com tb_profile';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tb_user');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('uuid', 'guid', ['notnull' => true]);
        $table->addColumn('id_profile', 'integer', ['notnull' => true]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('password', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime_immutable');
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('deleted_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['uuid'], 'UNIQ_USER_UUID');
        $table->addUniqueIndex(['email'], 'UNIQ_USER_EMAIL');
        $table->addIndex(['id_profile'], 'IDX_USER_ID_PROFILE');
        
        $table->addForeignKeyConstraint(
            'tb_profile',        // Tabela referenciada
            ['id_profile'],      // Coluna local
            ['id'],              // Coluna da tabela referenciada
            ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'], // Opções (ajustáveis)
            'FK_USER_PROFILE'    // Nome da constraint
        );
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tb_user');
    }
}
