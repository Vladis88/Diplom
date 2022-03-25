<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200102003214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car_body_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_drive_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_engine (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, gas_equipment_type_id INT DEFAULT NULL, engine_capacity INT DEFAULT NULL, hybrid TINYINT(1) NOT NULL, gas_equipment TINYINT(1) NOT NULL, power_reserve INT DEFAULT NULL, INDEX IDX_F0C0F67FC54C8C93 (type_id), INDEX IDX_F0C0F67FC2B8FDEF (gas_equipment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_engine_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_exchange (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_gas_equipment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_generation (id INT AUTO_INCREMENT NOT NULL, car_model_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E1F9E22AF64382E3 (car_model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_info (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, model_id INT DEFAULT NULL, generation_id INT DEFAULT NULL, body_type_id INT DEFAULT NULL, shape_id INT DEFAULT NULL, price_id INT DEFAULT NULL, mileage_measure_id INT DEFAULT NULL, engine_id INT DEFAULT NULL, transmission_id INT DEFAULT NULL, drive_type_id INT DEFAULT NULL, color_id INT DEFAULT NULL, interior_material_id INT DEFAULT NULL, interior_color_id INT DEFAULT NULL, exchange_id INT DEFAULT NULL, region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, year VARCHAR(255) NOT NULL, modification VARCHAR(255) DEFAULT NULL, mileage INT NOT NULL, exchange_note LONGTEXT DEFAULT NULL, vin_number VARCHAR(255) DEFAULT NULL, video_link VARCHAR(255) DEFAULT NULL, INDEX IDX_E325FB4290F12B (mark_id), INDEX IDX_E325FB7975B7E7 (model_id), INDEX IDX_E325FB553A6EC4 (generation_id), INDEX IDX_E325FB2CBA3505 (body_type_id), INDEX IDX_E325FB50266CBB (shape_id), UNIQUE INDEX UNIQ_E325FBD614C7E7 (price_id), INDEX IDX_E325FB93E2BD7 (mileage_measure_id), UNIQUE INDEX UNIQ_E325FBE78C9C0A (engine_id), INDEX IDX_E325FB78D28519 (transmission_id), INDEX IDX_E325FB1B53C22F (drive_type_id), INDEX IDX_E325FB7ADA1FB5 (color_id), INDEX IDX_E325FBC81C1C1A (interior_material_id), INDEX IDX_E325FBAAF1E1BF (interior_color_id), INDEX IDX_E325FB68AFD1A0 (exchange_id), INDEX IDX_E325FB98260155 (region_id), INDEX IDX_E325FB8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_interior_color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_mark (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, av_by_link_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_mileage_measure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_model (id INT AUTO_INCREMENT NOT NULL, car_mark_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, av_by_link_name VARCHAR(255) NOT NULL, INDEX IDX_83EF70E113B0AF7 (car_mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_price (id INT AUTO_INCREMENT NOT NULL, byn INT NOT NULL, usd INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_shape (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_transmission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_trim_material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B023498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_climate_and_heating_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_climate_and_heating_option_car_info (car_climate_and_heating_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_76140F0583BCB730 (car_climate_and_heating_option_id), INDEX IDX_76140F05E203A24 (car_info_id), PRIMARY KEY(car_climate_and_heating_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_comfort_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_comfort_option_car_info (car_comfort_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_AFDF459D865B3BFF (car_comfort_option_id), INDEX IDX_AFDF459DE203A24 (car_info_id), PRIMARY KEY(car_comfort_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_exterior_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_exterior_option_car_info (car_exterior_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_93952EDEBBEC6DF6 (car_exterior_option_id), INDEX IDX_93952EDEE203A24 (car_info_id), PRIMARY KEY(car_exterior_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_help_systems_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_help_systems_option_car_info (car_help_systems_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_7E1F4BFA5D09EE44 (car_help_systems_option_id), INDEX IDX_7E1F4BFAE203A24 (car_info_id), PRIMARY KEY(car_help_systems_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_interior_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_interior_option_car_info (car_interior_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_C426780917703A89 (car_interior_option_id), INDEX IDX_C4267809E203A24 (car_info_id), PRIMARY KEY(car_interior_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_multimedia_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_multimedia_option_car_info (car_multimedia_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_914451EAB3DD6C8 (car_multimedia_option_id), INDEX IDX_914451EAE203A24 (car_info_id), PRIMARY KEY(car_multimedia_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_optics_and_light_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_optics_and_light_option_car_info (car_optics_and_light_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_3305753BAC573413 (car_optics_and_light_option_id), INDEX IDX_3305753BE203A24 (car_info_id), PRIMARY KEY(car_optics_and_light_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_security_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_security_option_car_info (car_security_option_id INT NOT NULL, car_info_id INT NOT NULL, INDEX IDX_2713D01F9FCB2016 (car_security_option_id), INDEX IDX_2713D01FE203A24 (car_info_id), PRIMARY KEY(car_security_option_id, car_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_engine ADD CONSTRAINT FK_F0C0F67FC54C8C93 FOREIGN KEY (type_id) REFERENCES car_engine (id)');
        $this->addSql('ALTER TABLE car_engine ADD CONSTRAINT FK_F0C0F67FC2B8FDEF FOREIGN KEY (gas_equipment_type_id) REFERENCES car_gas_equipment_type (id)');
        $this->addSql('ALTER TABLE car_generation ADD CONSTRAINT FK_E1F9E22AF64382E3 FOREIGN KEY (car_model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB4290F12B FOREIGN KEY (mark_id) REFERENCES car_mark (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB7975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB553A6EC4 FOREIGN KEY (generation_id) REFERENCES car_generation (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB2CBA3505 FOREIGN KEY (body_type_id) REFERENCES car_body_type (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB50266CBB FOREIGN KEY (shape_id) REFERENCES car_shape (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FBD614C7E7 FOREIGN KEY (price_id) REFERENCES car_price (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB93E2BD7 FOREIGN KEY (mileage_measure_id) REFERENCES car_mileage_measure (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FBE78C9C0A FOREIGN KEY (engine_id) REFERENCES car_engine (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB78D28519 FOREIGN KEY (transmission_id) REFERENCES car_transmission (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB1B53C22F FOREIGN KEY (drive_type_id) REFERENCES car_drive_type (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB7ADA1FB5 FOREIGN KEY (color_id) REFERENCES car_color (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FBC81C1C1A FOREIGN KEY (interior_material_id) REFERENCES car_trim_material (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FBAAF1E1BF FOREIGN KEY (interior_color_id) REFERENCES car_interior_color (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB68AFD1A0 FOREIGN KEY (exchange_id) REFERENCES car_exchange (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE car_info ADD CONSTRAINT FK_E325FB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E113B0AF7 FOREIGN KEY (car_mark_id) REFERENCES car_mark (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE car_climate_and_heating_option_car_info ADD CONSTRAINT FK_76140F0583BCB730 FOREIGN KEY (car_climate_and_heating_option_id) REFERENCES car_climate_and_heating_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_climate_and_heating_option_car_info ADD CONSTRAINT FK_76140F05E203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_comfort_option_car_info ADD CONSTRAINT FK_AFDF459D865B3BFF FOREIGN KEY (car_comfort_option_id) REFERENCES car_comfort_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_comfort_option_car_info ADD CONSTRAINT FK_AFDF459DE203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_exterior_option_car_info ADD CONSTRAINT FK_93952EDEBBEC6DF6 FOREIGN KEY (car_exterior_option_id) REFERENCES car_exterior_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_exterior_option_car_info ADD CONSTRAINT FK_93952EDEE203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_help_systems_option_car_info ADD CONSTRAINT FK_7E1F4BFA5D09EE44 FOREIGN KEY (car_help_systems_option_id) REFERENCES car_help_systems_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_help_systems_option_car_info ADD CONSTRAINT FK_7E1F4BFAE203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_interior_option_car_info ADD CONSTRAINT FK_C426780917703A89 FOREIGN KEY (car_interior_option_id) REFERENCES car_interior_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_interior_option_car_info ADD CONSTRAINT FK_C4267809E203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_multimedia_option_car_info ADD CONSTRAINT FK_914451EAB3DD6C8 FOREIGN KEY (car_multimedia_option_id) REFERENCES car_multimedia_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_multimedia_option_car_info ADD CONSTRAINT FK_914451EAE203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_optics_and_light_option_car_info ADD CONSTRAINT FK_3305753BAC573413 FOREIGN KEY (car_optics_and_light_option_id) REFERENCES car_optics_and_light_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_optics_and_light_option_car_info ADD CONSTRAINT FK_3305753BE203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_security_option_car_info ADD CONSTRAINT FK_2713D01F9FCB2016 FOREIGN KEY (car_security_option_id) REFERENCES car_security_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_security_option_car_info ADD CONSTRAINT FK_2713D01FE203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_post ADD car_info_id INT DEFAULT NULL, ADD seller_name VARCHAR(255) DEFAULT NULL, DROP price, CHANGE about_car description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE car_post ADD CONSTRAINT FK_91E07821E203A24 FOREIGN KEY (car_info_id) REFERENCES car_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_91E07821E203A24 ON car_post (car_info_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB2CBA3505');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB7ADA1FB5');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB1B53C22F');
        $this->addSql('ALTER TABLE car_engine DROP FOREIGN KEY FK_F0C0F67FC54C8C93');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FBE78C9C0A');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB68AFD1A0');
        $this->addSql('ALTER TABLE car_engine DROP FOREIGN KEY FK_F0C0F67FC2B8FDEF');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB553A6EC4');
        $this->addSql('ALTER TABLE car_post DROP FOREIGN KEY FK_91E07821E203A24');
        $this->addSql('ALTER TABLE car_climate_and_heating_option_car_info DROP FOREIGN KEY FK_76140F05E203A24');
        $this->addSql('ALTER TABLE car_comfort_option_car_info DROP FOREIGN KEY FK_AFDF459DE203A24');
        $this->addSql('ALTER TABLE car_exterior_option_car_info DROP FOREIGN KEY FK_93952EDEE203A24');
        $this->addSql('ALTER TABLE car_help_systems_option_car_info DROP FOREIGN KEY FK_7E1F4BFAE203A24');
        $this->addSql('ALTER TABLE car_interior_option_car_info DROP FOREIGN KEY FK_C4267809E203A24');
        $this->addSql('ALTER TABLE car_multimedia_option_car_info DROP FOREIGN KEY FK_914451EAE203A24');
        $this->addSql('ALTER TABLE car_optics_and_light_option_car_info DROP FOREIGN KEY FK_3305753BE203A24');
        $this->addSql('ALTER TABLE car_security_option_car_info DROP FOREIGN KEY FK_2713D01FE203A24');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FBAAF1E1BF');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB4290F12B');
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E113B0AF7');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB93E2BD7');
        $this->addSql('ALTER TABLE car_generation DROP FOREIGN KEY FK_E1F9E22AF64382E3');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB7975B7E7');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FBD614C7E7');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB50266CBB');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB78D28519');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FBC81C1C1A');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB8BAC62AF');
        $this->addSql('ALTER TABLE car_climate_and_heating_option_car_info DROP FOREIGN KEY FK_76140F0583BCB730');
        $this->addSql('ALTER TABLE car_comfort_option_car_info DROP FOREIGN KEY FK_AFDF459D865B3BFF');
        $this->addSql('ALTER TABLE car_exterior_option_car_info DROP FOREIGN KEY FK_93952EDEBBEC6DF6');
        $this->addSql('ALTER TABLE car_help_systems_option_car_info DROP FOREIGN KEY FK_7E1F4BFA5D09EE44');
        $this->addSql('ALTER TABLE car_interior_option_car_info DROP FOREIGN KEY FK_C426780917703A89');
        $this->addSql('ALTER TABLE car_multimedia_option_car_info DROP FOREIGN KEY FK_914451EAB3DD6C8');
        $this->addSql('ALTER TABLE car_optics_and_light_option_car_info DROP FOREIGN KEY FK_3305753BAC573413');
        $this->addSql('ALTER TABLE car_security_option_car_info DROP FOREIGN KEY FK_2713D01F9FCB2016');
        $this->addSql('ALTER TABLE car_info DROP FOREIGN KEY FK_E325FB98260155');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155');
        $this->addSql('DROP TABLE car_body_type');
        $this->addSql('DROP TABLE car_color');
        $this->addSql('DROP TABLE car_drive_type');
        $this->addSql('DROP TABLE car_engine');
        $this->addSql('DROP TABLE car_engine_type');
        $this->addSql('DROP TABLE car_exchange');
        $this->addSql('DROP TABLE car_gas_equipment_type');
        $this->addSql('DROP TABLE car_generation');
        $this->addSql('DROP TABLE car_info');
        $this->addSql('DROP TABLE car_interior_color');
        $this->addSql('DROP TABLE car_mark');
        $this->addSql('DROP TABLE car_mileage_measure');
        $this->addSql('DROP TABLE car_model');
        $this->addSql('DROP TABLE car_price');
        $this->addSql('DROP TABLE car_shape');
        $this->addSql('DROP TABLE car_transmission');
        $this->addSql('DROP TABLE car_trim_material');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE car_climate_and_heating_option');
        $this->addSql('DROP TABLE car_climate_and_heating_option_car_info');
        $this->addSql('DROP TABLE car_comfort_option');
        $this->addSql('DROP TABLE car_comfort_option_car_info');
        $this->addSql('DROP TABLE car_exterior_option');
        $this->addSql('DROP TABLE car_exterior_option_car_info');
        $this->addSql('DROP TABLE car_help_systems_option');
        $this->addSql('DROP TABLE car_help_systems_option_car_info');
        $this->addSql('DROP TABLE car_interior_option');
        $this->addSql('DROP TABLE car_interior_option_car_info');
        $this->addSql('DROP TABLE car_multimedia_option');
        $this->addSql('DROP TABLE car_multimedia_option_car_info');
        $this->addSql('DROP TABLE car_optics_and_light_option');
        $this->addSql('DROP TABLE car_optics_and_light_option_car_info');
        $this->addSql('DROP TABLE car_security_option');
        $this->addSql('DROP TABLE car_security_option_car_info');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP INDEX UNIQ_91E07821E203A24 ON car_post');
        $this->addSql('ALTER TABLE car_post ADD price INT NOT NULL, DROP car_info_id, DROP seller_name, CHANGE description about_car LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
