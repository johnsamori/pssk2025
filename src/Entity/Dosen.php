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
 * Entity class for "dosen" table
 */

#[Entity]
#[Table("dosen", options: ["dbId" => "DB"])]
class Dosen extends AbstractEntity
{
    #[Id]
    #[Column(type: "string", unique: true)]
    private string $No;

    #[Column(name: "NIP", type: "string", nullable: true)]
    private ?string $Nip;

    #[Column(name: "NIDN", type: "string", nullable: true)]
    private ?string $Nidn;

    #[Column(name: "`Nama_Lengkap`", options: ["name" => "Nama_Lengkap"], type: "string", nullable: true)]
    private ?string $NamaLengkap;

    #[Column(name: "`Gelar_Depan`", options: ["name" => "Gelar_Depan"], type: "string", nullable: true)]
    private ?string $GelarDepan;

    #[Column(name: "`Gelar_Belakang`", options: ["name" => "Gelar_Belakang"], type: "string", nullable: true)]
    private ?string $GelarBelakang;

    #[Column(name: "`Program_studi`", options: ["name" => "Program_studi"], type: "string", nullable: true)]
    private ?string $ProgramStudi;

    #[Column(name: "NIK", type: "string", nullable: true)]
    private ?string $Nik;

    #[Column(name: "`Tanggal_lahir`", options: ["name" => "Tanggal_lahir"], type: "date", nullable: true)]
    private ?DateTime $TanggalLahir;

    #[Column(name: "`Tempat_lahir`", options: ["name" => "Tempat_lahir"], type: "string", nullable: true)]
    private ?string $TempatLahir;

    #[Column(name: "`Nomor_Karpeg`", options: ["name" => "Nomor_Karpeg"], type: "string", nullable: true)]
    private ?string $NomorKarpeg;

    #[Column(name: "`Nomor_Stambuk`", options: ["name" => "Nomor_Stambuk"], type: "string", nullable: true)]
    private ?string $NomorStambuk;

    #[Column(name: "`Jenis_kelamin`", options: ["name" => "Jenis_kelamin"], type: "string", nullable: true)]
    private ?string $JenisKelamin;

    #[Column(name: "`Gol_Darah`", options: ["name" => "Gol_Darah"], type: "string", nullable: true)]
    private ?string $GolDarah;

    #[Column(type: "string", nullable: true)]
    private ?string $Agama;

    #[Column(name: "`Stattus_menikah`", options: ["name" => "Stattus_menikah"], type: "string", nullable: true)]
    private ?string $StattusMenikah;

    #[Column(type: "string", nullable: true)]
    private ?string $Alamat;

    #[Column(type: "string", nullable: true)]
    private ?string $Kota;

    #[Column(name: "`Telepon_seluler`", options: ["name" => "Telepon_seluler"], type: "string", nullable: true)]
    private ?string $TeleponSeluler;

    #[Column(name: "`Jenis_pegawai`", options: ["name" => "Jenis_pegawai"], type: "string", nullable: true)]
    private ?string $JenisPegawai;

    #[Column(name: "`Status_pegawai`", options: ["name" => "Status_pegawai"], type: "string", nullable: true)]
    private ?string $StatusPegawai;

    #[Column(type: "string", nullable: true)]
    private ?string $Golongan;

    #[Column(type: "string", nullable: true)]
    private ?string $Pangkat;

    #[Column(name: "`Status_dosen`", options: ["name" => "Status_dosen"], type: "string", nullable: true)]
    private ?string $StatusDosen;

    #[Column(name: "`Status_Belajar`", options: ["name" => "Status_Belajar"], type: "string", nullable: true)]
    private ?string $StatusBelajar;

    #[Column(name: "e_mail", type: "string", nullable: true)]
    private ?string $EMail;

    public function getNo(): string
    {
        return $this->No;
    }

    public function setNo(string $value): static
    {
        $this->No = $value;
        return $this;
    }

    public function getNip(): ?string
    {
        return HtmlDecode($this->Nip);
    }

    public function setNip(?string $value): static
    {
        $this->Nip = RemoveXss($value);
        return $this;
    }

    public function getNidn(): ?string
    {
        return HtmlDecode($this->Nidn);
    }

    public function setNidn(?string $value): static
    {
        $this->Nidn = RemoveXss($value);
        return $this;
    }

    public function getNamaLengkap(): ?string
    {
        return HtmlDecode($this->NamaLengkap);
    }

    public function setNamaLengkap(?string $value): static
    {
        $this->NamaLengkap = RemoveXss($value);
        return $this;
    }

    public function getGelarDepan(): ?string
    {
        return HtmlDecode($this->GelarDepan);
    }

    public function setGelarDepan(?string $value): static
    {
        $this->GelarDepan = RemoveXss($value);
        return $this;
    }

    public function getGelarBelakang(): ?string
    {
        return HtmlDecode($this->GelarBelakang);
    }

    public function setGelarBelakang(?string $value): static
    {
        $this->GelarBelakang = RemoveXss($value);
        return $this;
    }

    public function getProgramStudi(): ?string
    {
        return HtmlDecode($this->ProgramStudi);
    }

    public function setProgramStudi(?string $value): static
    {
        $this->ProgramStudi = RemoveXss($value);
        return $this;
    }

    public function getNik(): ?string
    {
        return HtmlDecode($this->Nik);
    }

    public function setNik(?string $value): static
    {
        $this->Nik = RemoveXss($value);
        return $this;
    }

    public function getTanggalLahir(): ?DateTime
    {
        return $this->TanggalLahir;
    }

    public function setTanggalLahir(?DateTime $value): static
    {
        $this->TanggalLahir = $value;
        return $this;
    }

    public function getTempatLahir(): ?string
    {
        return HtmlDecode($this->TempatLahir);
    }

    public function setTempatLahir(?string $value): static
    {
        $this->TempatLahir = RemoveXss($value);
        return $this;
    }

    public function getNomorKarpeg(): ?string
    {
        return HtmlDecode($this->NomorKarpeg);
    }

    public function setNomorKarpeg(?string $value): static
    {
        $this->NomorKarpeg = RemoveXss($value);
        return $this;
    }

    public function getNomorStambuk(): ?string
    {
        return HtmlDecode($this->NomorStambuk);
    }

    public function setNomorStambuk(?string $value): static
    {
        $this->NomorStambuk = RemoveXss($value);
        return $this;
    }

    public function getJenisKelamin(): ?string
    {
        return HtmlDecode($this->JenisKelamin);
    }

    public function setJenisKelamin(?string $value): static
    {
        $this->JenisKelamin = RemoveXss($value);
        return $this;
    }

    public function getGolDarah(): ?string
    {
        return HtmlDecode($this->GolDarah);
    }

    public function setGolDarah(?string $value): static
    {
        $this->GolDarah = RemoveXss($value);
        return $this;
    }

    public function getAgama(): ?string
    {
        return HtmlDecode($this->Agama);
    }

    public function setAgama(?string $value): static
    {
        $this->Agama = RemoveXss($value);
        return $this;
    }

    public function getStattusMenikah(): ?string
    {
        return HtmlDecode($this->StattusMenikah);
    }

    public function setStattusMenikah(?string $value): static
    {
        $this->StattusMenikah = RemoveXss($value);
        return $this;
    }

    public function getAlamat(): ?string
    {
        return HtmlDecode($this->Alamat);
    }

    public function setAlamat(?string $value): static
    {
        $this->Alamat = RemoveXss($value);
        return $this;
    }

    public function getKota(): ?string
    {
        return HtmlDecode($this->Kota);
    }

    public function setKota(?string $value): static
    {
        $this->Kota = RemoveXss($value);
        return $this;
    }

    public function getTeleponSeluler(): ?string
    {
        return HtmlDecode($this->TeleponSeluler);
    }

    public function setTeleponSeluler(?string $value): static
    {
        $this->TeleponSeluler = RemoveXss($value);
        return $this;
    }

    public function getJenisPegawai(): ?string
    {
        return HtmlDecode($this->JenisPegawai);
    }

    public function setJenisPegawai(?string $value): static
    {
        $this->JenisPegawai = RemoveXss($value);
        return $this;
    }

    public function getStatusPegawai(): ?string
    {
        return HtmlDecode($this->StatusPegawai);
    }

    public function setStatusPegawai(?string $value): static
    {
        $this->StatusPegawai = RemoveXss($value);
        return $this;
    }

    public function getGolongan(): ?string
    {
        return HtmlDecode($this->Golongan);
    }

    public function setGolongan(?string $value): static
    {
        $this->Golongan = RemoveXss($value);
        return $this;
    }

    public function getPangkat(): ?string
    {
        return HtmlDecode($this->Pangkat);
    }

    public function setPangkat(?string $value): static
    {
        $this->Pangkat = RemoveXss($value);
        return $this;
    }

    public function getStatusDosen(): ?string
    {
        return HtmlDecode($this->StatusDosen);
    }

    public function setStatusDosen(?string $value): static
    {
        $this->StatusDosen = RemoveXss($value);
        return $this;
    }

    public function getStatusBelajar(): ?string
    {
        return HtmlDecode($this->StatusBelajar);
    }

    public function setStatusBelajar(?string $value): static
    {
        $this->StatusBelajar = RemoveXss($value);
        return $this;
    }

    public function getEMail(): ?string
    {
        return HtmlDecode($this->EMail);
    }

    public function setEMail(?string $value): static
    {
        $this->EMail = RemoveXss($value);
        return $this;
    }
}
