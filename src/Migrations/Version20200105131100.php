<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105131100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_engine DROP FOREIGN KEY FK_F0C0F67FC54C8C93');
        $this->addSql('ALTER TABLE car_engine ADD CONSTRAINT FK_F0C0F67FC54C8C93 FOREIGN KEY (type_id) REFERENCES car_engine_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_engine DROP FOREIGN KEY FK_F0C0F67FC54C8C93');
        $this->addSql('ALTER TABLE car_engine ADD CONSTRAINT FK_F0C0F67FC54C8C93 FOREIGN KEY (type_id) REFERENCES car_engine (id)');
    }
}
