<?php

namespace Application\MiamBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20100602110623 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_story CHANGE body body LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_story CHANGE body body LONGTEXT NOT NULL');
    }
}
