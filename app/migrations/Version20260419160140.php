<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260419160140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_at to user safely';
    }

    public function up(Schema $schema): void
    {
        // ne rien faire ici si tu as déjà ajouté created_at à la main
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP created_at');
    }
}
