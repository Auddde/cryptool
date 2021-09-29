<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929123027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet ADD wallettype_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F8CDFF454 FOREIGN KEY (wallettype_id) REFERENCES wallet_type (id)');
        $this->addSql('CREATE INDEX IDX_7C68921F8CDFF454 ON wallet (wallettype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F8CDFF454');
        $this->addSql('DROP INDEX IDX_7C68921F8CDFF454 ON wallet');
        $this->addSql('ALTER TABLE wallet DROP wallettype_id');
    }
}
