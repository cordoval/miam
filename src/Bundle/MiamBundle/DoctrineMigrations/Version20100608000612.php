<?php

namespace Bundle\MiamBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20100608000612 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_timeline ADD points INT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_timeline DROP points');
    }
}