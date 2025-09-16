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
 * Entity class for "detil_semester_antara" table
 */

#[Entity]
#[Table("detil_semester_antara", options: ["dbId" => "DB"])]
class DetilSemesterAntara extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_smtsr", type: "string")]
    private string $IdSmtsr;

    #[Id]
    #[Column(name: "no", type: "integer")]
    #[GeneratedValue]
    private int $No;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "KRS", type: "string", nullable: true)]
    private ?string $Krs;

    #[Column(name: "`Bukti_SPP`", options: ["name" => "Bukti_SPP"], type: "string", nullable: true)]
    private ?string $BuktiSpp;

    public function __construct(string $IdSmtsr, int $No)
    {
        $this->IdSmtsr = $IdSmtsr;
        $this->No = $No;
    }

    public function getIdSmtsr(): string
    {
        return $this->IdSmtsr;
    }

    public function setIdSmtsr(string $value): static
    {
        $this->IdSmtsr = $value;
        return $this;
    }

    public function getNo(): int
    {
        return $this->No;
    }

    public function setNo(int $value): static
    {
        $this->No = $value;
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

    public function getKrs(): ?string
    {
        return HtmlDecode($this->Krs);
    }

    public function setKrs(?string $value): static
    {
        $this->Krs = RemoveXss($value);
        return $this;
    }

    public function getBuktiSpp(): ?string
    {
        return HtmlDecode($this->BuktiSpp);
    }

    public function setBuktiSpp(?string $value): static
    {
        $this->BuktiSpp = RemoveXss($value);
        return $this;
    }
}
