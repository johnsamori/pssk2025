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
 * Entity class for "daftar matakuliah" table
 */

#[Entity]
#[Table("`daftar matakuliah`", options: ["dbId" => "DB"])]
class DaftarMatakuliah extends AbstractEntity
{
    #[Id]
    #[Column(type: "string", unique: true)]
    private string $Kode;

    #[Column(type: "string", nullable: true)]
    private ?string $Nama;

    #[Column(name: "SKS", type: "string", nullable: true)]
    private ?string $Sks;

    public function getKode(): string
    {
        return $this->Kode;
    }

    public function setKode(string $value): static
    {
        $this->Kode = $value;
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

    public function getSks(): ?string
    {
        return HtmlDecode($this->Sks);
    }

    public function setSks(?string $value): static
    {
        $this->Sks = RemoveXss($value);
        return $this;
    }
}
