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
 * Entity class for "beasiswa" table
 */

#[Entity]
#[Table("beasiswa", options: ["dbId" => "DB"])]
class Beasiswa extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_beasiswa", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $IdBeasiswa;

    #[Column(name: "`Nama_Beasiswa`", options: ["name" => "Nama_Beasiswa"], type: "string", nullable: true)]
    private ?string $NamaBeasiswa;

    public function getIdBeasiswa(): int
    {
        return $this->IdBeasiswa;
    }

    public function setIdBeasiswa(int $value): static
    {
        $this->IdBeasiswa = $value;
        return $this;
    }

    public function getNamaBeasiswa(): ?string
    {
        return HtmlDecode($this->NamaBeasiswa);
    }

    public function setNamaBeasiswa(?string $value): static
    {
        $this->NamaBeasiswa = RemoveXss($value);
        return $this;
    }
}
