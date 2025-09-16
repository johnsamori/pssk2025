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
 * Entity class for "mata_kuliah" table
 */

#[Entity]
#[Table("mata_kuliah", options: ["dbId" => "DB"])]
class MataKuliah extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_mk", type: "integer")]
    #[GeneratedValue]
    private int $IdMk;

    #[Id]
    #[Column(name: "`Kode_MK`", options: ["name" => "Kode_MK"], type: "string")]
    private string $KodeMk;

    #[Column(type: "string", nullable: true)]
    private ?string $Semester;

    #[Column(name: "`Tahun_Akademik`", options: ["name" => "Tahun_Akademik"], type: "string", nullable: true)]
    private ?string $TahunAkademik;

    #[Column(type: "string", nullable: true)]
    private ?string $Dosen;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    #[Column(type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "iduser", type: "string", nullable: true)]
    private ?string $Iduser;

    public function __construct(int $IdMk, string $KodeMk)
    {
        $this->IdMk = $IdMk;
        $this->KodeMk = $KodeMk;
    }

    public function getIdMk(): int
    {
        return $this->IdMk;
    }

    public function setIdMk(int $value): static
    {
        $this->IdMk = $value;
        return $this;
    }

    public function getKodeMk(): string
    {
        return $this->KodeMk;
    }

    public function setKodeMk(string $value): static
    {
        $this->KodeMk = $value;
        return $this;
    }

    public function getSemester(): ?string
    {
        return HtmlDecode($this->Semester);
    }

    public function setSemester(?string $value): static
    {
        $this->Semester = RemoveXss($value);
        return $this;
    }

    public function getTahunAkademik(): ?string
    {
        return HtmlDecode($this->TahunAkademik);
    }

    public function setTahunAkademik(?string $value): static
    {
        $this->TahunAkademik = RemoveXss($value);
        return $this;
    }

    public function getDosen(): ?string
    {
        return HtmlDecode($this->Dosen);
    }

    public function setDosen(?string $value): static
    {
        $this->Dosen = RemoveXss($value);
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

    public function getIp(): ?string
    {
        return HtmlDecode($this->Ip);
    }

    public function setIp(?string $value): static
    {
        $this->Ip = RemoveXss($value);
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

    public function getIduser(): ?string
    {
        return HtmlDecode($this->Iduser);
    }

    public function setIduser(?string $value): static
    {
        $this->Iduser = RemoveXss($value);
        return $this;
    }
}
