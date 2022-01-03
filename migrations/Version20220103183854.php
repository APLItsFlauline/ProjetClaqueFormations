<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103183854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1F1B251E737992C9 ON item');
        $this->addSql('ALTER TABLE item CHANGE ordre `order` INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251EF5299398 ON item (`order`)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1F1B251EF5299398 ON item');
        $this->addSql('ALTER TABLE item CHANGE `order` ordre INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E737992C9 ON item (ordre)');
    }
}
