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
 * Entity class for "ujian_tahap_bersama" table
 */

#[Entity]
#[Table("ujian_tahap_bersama", options: ["dbId" => "DB"])]
class UjianTahapBersama extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_utb", type: "string", unique: true)]
    private string $IdUtb;

    #[Column(type: "string", nullable: true)]
    private ?string $Ujian;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    #[Column(name: "userid", type: "integer", nullable: true)]
    private ?int $Userid;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "ip", type: "string", nullable: true)]
    private ?string $Ip;

    public function getIdUtb(): string
    {
        return $this->IdUtb;
    }

    public function setIdUtb(string $value): static
    {
        $this->IdUtb = $value;
        return $this;
    }

    public function getUjian(): ?string
    {
        return HtmlDecode($this->Ujian);
    }

    public function setUjian(?string $value): static
    {
        $this->Ujian = RemoveXss($value);
        return $this;
    }

    public function getTanggal(): ?DateTime
    {
        return $this->Tanggal;
    }

    public function setTanggal(?DateTime $value): static
    {
        $this->Tanggal = $value;
        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->Userid;
    }

    public function setUserid(?int $value): static
    {
        $this->Userid = $value;
        return $this;
    }

    public function getUser(): ?string
    {
        return HtmlDecode($this->User);
    }

    public function setUser(?string $value): static
    {
        $this->User = RemoveXss($value);
        return $this;
    }

    public function getIp(): ?string
    {
        return HtmlDecode($this->Ip);
    }

    public function setIp(?string $value): static
    {
        $this->Ip = RemoveXss($value);
        return $this;
    }
}
