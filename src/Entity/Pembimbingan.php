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
 * Entity class for "pembimbingan" table
 */

#[Entity]
#[Table("pembimbingan", options: ["dbId" => "DB"])]
class Pembimbingan extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_pem", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $IdPem;

    #[Column(name: "`NIP_Dosen_Pembimbing`", options: ["name" => "NIP_Dosen_Pembimbing"], type: "string", nullable: true)]
    private ?string $NipDosenPembimbing;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "`Catatan_Mahasiswa`", options: ["name" => "Catatan_Mahasiswa"], type: "text", nullable: true)]
    private ?string $CatatanMahasiswa;

    #[Column(name: "`Catatan_Dosen_Wali`", options: ["name" => "Catatan_Dosen_Wali"], type: "text", nullable: true)]
    private ?string $CatatanDosenWali;

    #[Column(name: "`Rekomendasi_Unit_BK`", options: ["name" => "Rekomendasi_Unit_BK"], type: "string", nullable: true)]
    private ?string $RekomendasiUnitBk;

    #[Column(name: "`Nilai_IP_Semester`", options: ["name" => "Nilai_IP_Semester"], type: "string", nullable: true)]
    private ?string $NilaiIpSemester;

    #[Column(name: "`Nilai_IPK`", options: ["name" => "Nilai_IPK"], type: "string", nullable: true)]
    private ?string $NilaiIpk;

    #[Column(name: "`Surat_Peringatan`", options: ["name" => "Surat_Peringatan"], type: "string", nullable: true)]
    private ?string $SuratPeringatan;

    #[Column(name: "`Surat_Pemberitahuan`", options: ["name" => "Surat_Pemberitahuan"], type: "string", nullable: true)]
    private ?string $SuratPemberitahuan;

    #[Column(name: "`Rekomendasi_Akhir`", options: ["name" => "Rekomendasi_Akhir"], type: "string", nullable: true)]
    private ?string $RekomendasiAkhir;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    #[Column(type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "iduser", type: "string", nullable: true)]
    private ?string $Iduser;

    public function getIdPem(): int
    {
        return $this->IdPem;
    }

    public function setIdPem(int $value): static
    {
        $this->IdPem = $value;
        return $this;
    }

    public function getNipDosenPembimbing(): ?string
    {
        return HtmlDecode($this->NipDosenPembimbing);
    }

    public function setNipDosenPembimbing(?string $value): static
    {
        $this->NipDosenPembimbing = RemoveXss($value);
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

    public function getCatatanMahasiswa(): ?string
    {
        return HtmlDecode($this->CatatanMahasiswa);
    }

    public function setCatatanMahasiswa(?string $value): static
    {
        $this->CatatanMahasiswa = RemoveXss($value);
        return $this;
    }

    public function getCatatanDosenWali(): ?string
    {
        return HtmlDecode($this->CatatanDosenWali);
    }

    public function setCatatanDosenWali(?string $value): static
    {
        $this->CatatanDosenWali = RemoveXss($value);
        return $this;
    }

    public function getRekomendasiUnitBk(): ?string
    {
        return HtmlDecode($this->RekomendasiUnitBk);
    }

    public function setRekomendasiUnitBk(?string $value): static
    {
        $this->RekomendasiUnitBk = RemoveXss($value);
        return $this;
    }

    public function getNilaiIpSemester(): ?string
    {
        return HtmlDecode($this->NilaiIpSemester);
    }

    public function setNilaiIpSemester(?string $value): static
    {
        $this->NilaiIpSemester = RemoveXss($value);
        return $this;
    }

    public function getNilaiIpk(): ?string
    {
        return HtmlDecode($this->NilaiIpk);
    }

    public function setNilaiIpk(?string $value): static
    {
        $this->NilaiIpk = RemoveXss($value);
        return $this;
    }

    public function getSuratPeringatan(): ?string
    {
        return HtmlDecode($this->SuratPeringatan);
    }

    public function setSuratPeringatan(?string $value): static
    {
        $this->SuratPeringatan = RemoveXss($value);
        return $this;
    }

    public function getSuratPemberitahuan(): ?string
    {
        return HtmlDecode($this->SuratPemberitahuan);
    }

    public function setSuratPemberitahuan(?string $value): static
    {
        $this->SuratPemberitahuan = RemoveXss($value);
        return $this;
    }

    public function getRekomendasiAkhir(): ?string
    {
        return HtmlDecode($this->RekomendasiAkhir);
    }

    public function setRekomendasiAkhir(?string $value): static
    {
        $this->RekomendasiAkhir = RemoveXss($value);
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
