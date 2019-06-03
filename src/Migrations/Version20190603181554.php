<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190603181554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE casino (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_830F4797F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE casino ADD CONSTRAINT FK_830F4797F675F31B FOREIGN KEY (author_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE bonus ADD category_id INT NOT NULL, ADD casino_id INT NOT NULL');
        $this->addSql('ALTER TABLE bonus ADD CONSTRAINT FK_9F987F7A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE bonus ADD CONSTRAINT FK_9F987F7AB19AAF95 FOREIGN KEY (casino_id) REFERENCES casino (id)');
        $this->addSql('CREATE INDEX IDX_9F987F7A12469DE2 ON bonus (category_id)');
        $this->addSql('CREATE INDEX IDX_9F987F7AB19AAF95 ON bonus (casino_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bonus DROP FOREIGN KEY FK_9F987F7AB19AAF95');
        $this->addSql('DROP TABLE casino');
        $this->addSql('ALTER TABLE bonus DROP FOREIGN KEY FK_9F987F7A12469DE2');
        $this->addSql('DROP INDEX IDX_9F987F7A12469DE2 ON bonus');
        $this->addSql('DROP INDEX IDX_9F987F7AB19AAF95 ON bonus');
        $this->addSql('ALTER TABLE bonus DROP category_id, DROP casino_id');
    }
}
