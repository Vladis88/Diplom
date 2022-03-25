<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331093257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_generation DROP FOREIGN KEY FK_E1F9E22AF64382E3');
        $this->addSql('DROP INDEX IDX_E1F9E22AF64382E3 ON car_generation');
        $this->addSql('ALTER TABLE car_generation CHANGE car_model_id model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_generation ADD CONSTRAINT FK_E1F9E22A7975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('CREATE INDEX IDX_E1F9E22A7975B7E7 ON car_generation (model_id)');
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E113B0AF7');
        $this->addSql('DROP INDEX IDX_83EF70E113B0AF7 ON car_model');
        $this->addSql('ALTER TABLE car_model CHANGE car_mark_id mark_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E4290F12B FOREIGN KEY (mark_id) REFERENCES car_mark (id)');
        $this->addSql('CREATE INDEX IDX_83EF70E4290F12B ON car_model (mark_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_generation DROP FOREIGN KEY FK_E1F9E22A7975B7E7');
        $this->addSql('DROP INDEX IDX_E1F9E22A7975B7E7 ON car_generation');
        $this->addSql('ALTER TABLE car_generation CHANGE model_id car_model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_generation ADD CONSTRAINT FK_E1F9E22AF64382E3 FOREIGN KEY (car_model_id) REFERENCES car_model (id)');
        $this->addSql('CREATE INDEX IDX_E1F9E22AF64382E3 ON car_generation (car_model_id)');
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E4290F12B');
        $this->addSql('DROP INDEX IDX_83EF70E4290F12B ON car_model');
        $this->addSql('ALTER TABLE car_model CHANGE mark_id car_mark_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E113B0AF7 FOREIGN KEY (car_mark_id) REFERENCES car_mark (id)');
        $this->addSql('CREATE INDEX IDX_83EF70E113B0AF7 ON car_model (car_mark_id)');
    }
}
