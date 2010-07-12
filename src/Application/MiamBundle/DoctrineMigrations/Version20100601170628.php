<?php

namespace Bundle\MiamBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version20100601170628 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->_addSql('CREATE TABLE miam_timeline (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, story_id INT NOT NULL, created_at DATETIME NOT NULL, action INT NOT NULL, INDEX miam_timeline_user_id_idx (user_id), INDEX miam_timeline_story_id_idx (story_id), PRIMARY KEY(id)) ENGINE = InnoDB');
        $this->_addSql('ALTER TABLE miam_timeline ADD FOREIGN KEY (user_id) REFERENCES sf_doctrine_user(id)');
        $this->_addSql('ALTER TABLE miam_timeline ADD FOREIGN KEY (story_id) REFERENCES miam_story(id)');
    }

    public function down(Schema $schema)
    {
        $this->_addSql('DROP TABLE miam_timeline');
    }
}