<?php

namespace Application\MiamBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20100719170732 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_story ADD domain INT NOT NULL');
    }

    public function down(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_story DROP domain');
    }
}