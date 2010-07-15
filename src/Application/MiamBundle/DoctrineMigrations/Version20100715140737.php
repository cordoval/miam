<?php

namespace Application\MiamBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20100715140737 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_project ADD priority INT NOT NULL');
    }

    public function down(Schema $schema)
    {
        $this->_addSql('ALTER TABLE miam_project DROP priority');
    }
}