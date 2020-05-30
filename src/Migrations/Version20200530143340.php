<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530143340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_2D0B6BCEA76ED395 ON travel');
        $this->addSql('ALTER TABLE travel DROP user_id');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3A76ED395');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3ECAB15B3');
        $this->addSql('ALTER TABLE user_travel ADD id INT AUTO_INCREMENT NOT NULL, ADD rating INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE travel ADD user_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_2D0B6BCEA76ED395 ON travel (user_id)');
        $this->addSql('ALTER TABLE user_travel MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3A76ED395');
        $this->addSql('ALTER TABLE user_travel DROP FOREIGN KEY FK_485970F3ECAB15B3');
        $this->addSql('ALTER TABLE user_travel DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_travel DROP id, DROP rating');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel ADD CONSTRAINT FK_485970F3ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_travel ADD PRIMARY KEY (user_id, travel_id)');
    }
}
