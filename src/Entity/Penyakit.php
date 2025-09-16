<?php

namespace PHPMaker2025\pssk2025\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2025\pssk2025\AdvancedUserInterface;
use PHPMaker2025\pssk2025\AbstractEntity;
use PHPMaker2025\pssk2025\AdvancedSecurity;
use PHPMaker2025\pssk2025\UserProfile;
use PHPMaker2025\pssk2025\UserRepository;
use function PHPMaker2025\pssk2025\Config;
use function PHPMaker2025\pssk2025\EntityManager;
use function PHPMaker2025\pssk2025\RemoveXss;
use function PHPMaker2025\pssk2025\HtmlDecode;
use function PHPMaker2025\pssk2025\HashPassword;
use function PHPMaker2025\pssk2025\Security;

/**
 * Entity class for "penyakit" table
 */

#[Entity]
#[Table("penyakit", options: ["dbId" => "DB"])]
class Penyakit extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_penyakit", type: "string", unique: true)]
    private string $IdPenyakit;

    #[Column(type: "string", nullable: true)]
    private ?string $Nama;

    public function getIdPenyakit(): string
    {
        return $this->IdPenyakit;
    }

    public function setIdPenyakit(string $value): static
    {
        $this->IdPenyakit = $value;
        return $this;
    }

    public function getNama(): ?string
    {
        return HtmlDecode($this->Nama);
    }

    public function setNama(?string $value): static
    {
        $this->Nama = RemoveXss($value);
        return $this;
    }
}
