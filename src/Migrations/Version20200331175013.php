<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331175013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscription ADD model_id INT DEFAULT NULL, ADD generation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3553A6EC4 FOREIGN KEY (generation_id) REFERENCES car_generation (id)');
        $this->addSql('CREATE INDEX IDX_A3C664D37975B7E7 ON subscription (model_id)');
        $this->addSql('CREATE INDEX IDX_A3C664D3553A6EC4 ON subscription (generation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37975B7E7');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3553A6EC4');
        $this->addSql('DROP INDEX IDX_A3C664D37975B7E7 ON subscription');
        $this->addSql('DROP INDEX IDX_A3C664D3553A6EC4 ON subscription');
        $this->addSql('ALTER TABLE subscription DROP model_id, DROP generation_id');
    }
}
