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
 * Entity class for "cuti_akademik" table
 */

#[Entity]
#[Table("cuti_akademik", options: ["dbId" => "DB"])]
class CutiAkademik extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_ca", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $IdCa;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "`Pengajuan_Surat_Cuti_Akademik`", options: ["name" => "Pengajuan_Surat_Cuti_Akademik"], type: "string", nullable: true)]
    private ?string $PengajuanSuratCutiAkademik;

    #[Column(name: "`Persetujuan_Cuti_Akademik`", options: ["name" => "Persetujuan_Cuti_Akademik"], type: "string", nullable: true)]
    private ?string $PersetujuanCutiAkademik;

    #[Column(name: "`Surat_Keterangan_Aktif_Kembali`", options: ["name" => "Surat_Keterangan_Aktif_Kembali"], type: "string", nullable: true)]
    private ?string $SuratKeteranganAktifKembali;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    #[Column(name: "id_user", type: "string", nullable: true)]
    private ?string $IdUser;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "ip", type: "string", nullable: true)]
    private ?string $Ip;

    public function getIdCa(): int
    {
        return $this->IdCa;
    }

    public function setIdCa(int $value): static
    {
        $this->IdCa = $value;
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

    public function getPengajuanSuratCutiAkademik(): ?string
    {
        return HtmlDecode($this->PengajuanSuratCutiAkademik);
    }

    public function setPengajuanSuratCutiAkademik(?string $value): static
    {
        $this->PengajuanSuratCutiAkademik = RemoveXss($value);
        return $this;
    }

    public function getPersetujuanCutiAkademik(): ?string
    {
        return HtmlDecode($this->PersetujuanCutiAkademik);
    }

    public function setPersetujuanCutiAkademik(?string $value): static
    {
        $this->PersetujuanCutiAkademik = RemoveXss($value);
        return $this;
    }

    public function getSuratKeteranganAktifKembali(): ?string
    {
        return HtmlDecode($this->SuratKeteranganAktifKembali);
    }

    public function setSuratKeteranganAktifKembali(?string $value): static
    {
        $this->SuratKeteranganAktifKembali = RemoveXss($value);
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

    public function getIdUser(): ?string
    {
        return HtmlDecode($this->IdUser);
    }

    public function setIdUser(?string $value): static
    {
        $this->IdUser = RemoveXss($value);
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
