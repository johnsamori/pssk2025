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
 * Entity class for "kemahasiswaan" table
 */

#[Entity]
#[Table("kemahasiswaan", options: ["dbId" => "DB"])]
class Kemahasiswaan extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_kemahasiswaan", type: "integer", unique: true)]
    private int $IdKemahasiswaan;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "`Jenis_Beasiswa`", options: ["name" => "Jenis_Beasiswa"], type: "string", nullable: true)]
    private ?string $JenisBeasiswa;

    #[Column(name: "`Sumber_beasiswa`", options: ["name" => "Sumber_beasiswa"], type: "string", nullable: true)]
    private ?string $SumberBeasiswa;

    #[Column(name: "`Nama_Kegiatan`", options: ["name" => "Nama_Kegiatan"], type: "string", nullable: true)]
    private ?string $NamaKegiatan;

    #[Column(name: "`Nama_Penghargaan_Yang Diterima`", options: ["name" => "Nama_Penghargaan_Yang Diterima"], type: "string", nullable: true)]
    private ?string $NamaPenghargaanYangDiterima;

    #[Column(type: "string", nullable: true)]
    private ?string $Sertifikat;

    #[Column(name: "userid", type: "string", nullable: true)]
    private ?string $Userid;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "ip", type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "tanggal", type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    public function getIdKemahasiswaan(): int
    {
        return $this->IdKemahasiswaan;
    }

    public function setIdKemahasiswaan(int $value): static
    {
        $this->IdKemahasiswaan = $value;
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

    public function getJenisBeasiswa(): ?string
    {
        return HtmlDecode($this->JenisBeasiswa);
    }

    public function setJenisBeasiswa(?string $value): static
    {
        $this->JenisBeasiswa = RemoveXss($value);
        return $this;
    }

    public function getSumberBeasiswa(): ?string
    {
        return HtmlDecode($this->SumberBeasiswa);
    }

    public function setSumberBeasiswa(?string $value): static
    {
        $this->SumberBeasiswa = RemoveXss($value);
        return $this;
    }

    public function getNamaKegiatan(): ?string
    {
        return HtmlDecode($this->NamaKegiatan);
    }

    public function setNamaKegiatan(?string $value): static
    {
        $this->NamaKegiatan = RemoveXss($value);
        return $this;
    }

    public function getNamaPenghargaanYangDiterima(): ?string
    {
        return HtmlDecode($this->NamaPenghargaanYangDiterima);
    }

    public function setNamaPenghargaanYangDiterima(?string $value): static
    {
        $this->NamaPenghargaanYangDiterima = RemoveXss($value);
        return $this;
    }

    public function getSertifikat(): ?string
    {
        return HtmlDecode($this->Sertifikat);
    }

    public function setSertifikat(?string $value): static
    {
        $this->Sertifikat = RemoveXss($value);
        return $this;
    }

    public function getUserid(): ?string
    {
        return HtmlDecode($this->Userid);
    }

    public function setUserid(?string $value): static
    {
        $this->Userid = RemoveXss($value);
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

    public function getTanggal(): ?DateTime
    {
        return $this->Tanggal;
    }

    public function setTanggal(?DateTime $value): static
    {
        $this->Tanggal = $value;
        return $this;
    }
}
