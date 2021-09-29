<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929124117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crypto ADD cryptoinfo_id INT NOT NULL');
        $this->addSql('ALTER TABLE crypto ADD CONSTRAINT FK_68282885637938DF FOREIGN KEY (cryptoinfo_id) REFERENCES crypto_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_68282885637938DF ON crypto (cryptoinfo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crypto DROP FOREIGN KEY FK_68282885637938DF');
        $this->addSql('DROP INDEX UNIQ_68282885637938DF ON crypto');
        $this->addSql('ALTER TABLE crypto DROP cryptoinfo_id');
    }
}
