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
 * Entity class for "semester_antara" table
 */

#[Entity]
#[Table("semester_antara", options: ["dbId" => "DB"])]
class SemesterAntara extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_smtr", type: "string", unique: true)]
    private string $IdSmtr;

    #[Column(type: "string", nullable: true)]
    private ?string $Semester;

    #[Column(type: "string", nullable: true)]
    private ?string $Jadwal;

    #[Column(name: "`Tahun_Akademik`", options: ["name" => "Tahun_Akademik"], type: "string", nullable: true)]
    private ?string $TahunAkademik;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    #[Column(name: "`User_id`", options: ["name" => "User_id"], type: "integer", nullable: true)]
    private ?int $UserId;

    #[Column(type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "IP", type: "string", nullable: true)]
    private ?string $Ip;

    public function getIdSmtr(): string
    {
        return $this->IdSmtr;
    }

    public function setIdSmtr(string $value): static
    {
        $this->IdSmtr = $value;
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

    public function getJadwal(): ?string
    {
        return HtmlDecode($this->Jadwal);
    }

    public function setJadwal(?string $value): static
    {
        $this->Jadwal = RemoveXss($value);
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

    public function getTanggal(): ?DateTime
    {
        return $this->Tanggal;
    }

    public function setTanggal(?DateTime $value): static
    {
        $this->Tanggal = $value;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->UserId;
    }

    public function setUserId(?int $value): static
    {
        $this->UserId = $value;
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
