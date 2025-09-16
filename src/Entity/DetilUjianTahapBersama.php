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
 * Entity class for "detil_ujian_tahap_bersama" table
 */

#[Entity]
#[Table("detil_ujian_tahap_bersama", options: ["dbId" => "DB"])]
class DetilUjianTahapBersama extends AbstractEntity
{
    #[Id]
    #[Column(name: "no", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $No;

    #[Column(name: "id_utb", type: "string")]
    private string $IdUtb;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(type: "string", nullable: true)]
    private ?string $Nilai;

    public function getNo(): int
    {
        return $this->No;
    }

    public function setNo(int $value): static
    {
        $this->No = $value;
        return $this;
    }

    public function getIdUtb(): string
    {
        return HtmlDecode($this->IdUtb);
    }

    public function setIdUtb(string $value): static
    {
        $this->IdUtb = RemoveXss($value);
        return $this;
    }

    public function getNim(): ?string
    {
        return HtmlDecode($this->Nim);
    }

    public function setNim(?string $value): static
    {
        $this->Nim = RemoveXss($value);
        return $this;
    }

    public function getNilai(): ?string
    {
        return HtmlDecode($this->Nilai);
    }

    public function setNilai(?string $value): static
    {
        $this->Nilai = RemoveXss($value);
        return $this;
    }
}
