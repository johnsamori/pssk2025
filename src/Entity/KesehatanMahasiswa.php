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
 * Entity class for "kesehatan_mahasiswa" table
 */

#[Entity]
#[Table("kesehatan_mahasiswa", options: ["dbId" => "DB"])]
class KesehatanMahasiswa extends AbstractEntity
{
    #[Id]
    #[Column(name: "`Id_kesehatan`", options: ["name" => "Id_kesehatan"], type: "integer", unique: true)]
    #[GeneratedValue]
    private int $IdKesehatan;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "`Dokter_Penanggung_Jawab`", options: ["name" => "Dokter_Penanggung_Jawab"], type: "string", nullable: true)]
    private ?string $DokterPenanggungJawab;

    #[Column(name: "`Nomor_SIP`", options: ["name" => "Nomor_SIP"], type: "string", nullable: true)]
    private ?string $NomorSip;

    #[Column(type: "string", nullable: true)]
    private ?string $Diagnosa;

    #[Column(name: "`Rekomendasi_Dokter`", options: ["name" => "Rekomendasi_Dokter"], type: "text", nullable: true)]
    private ?string $RekomendasiDokter;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    #[Column(type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "user_id", type: "integer", nullable: true)]
    private ?int $UserId;

    public function getIdKesehatan(): int
    {
        return $this->IdKesehatan;
    }

    public function setIdKesehatan(int $value): static
    {
        $this->IdKesehatan = $value;
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

    public function getDokterPenanggungJawab(): ?string
    {
        return HtmlDecode($this->DokterPenanggungJawab);
    }

    public function setDokterPenanggungJawab(?string $value): static
    {
        $this->DokterPenanggungJawab = RemoveXss($value);
        return $this;
    }

    public function getNomorSip(): ?string
    {
        return HtmlDecode($this->NomorSip);
    }

    public function setNomorSip(?string $value): static
    {
        $this->NomorSip = RemoveXss($value);
        return $this;
    }

    public function getDiagnosa(): ?string
    {
        return HtmlDecode($this->Diagnosa);
    }

    public function setDiagnosa(?string $value): static
    {
        $this->Diagnosa = RemoveXss($value);
        return $this;
    }

    public function getRekomendasiDokter(): ?string
    {
        return HtmlDecode($this->RekomendasiDokter);
    }

    public function setRekomendasiDokter(?string $value): static
    {
        $this->RekomendasiDokter = RemoveXss($value);
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

    public function getUserId(): ?int
    {
        return $this->UserId;
    }

    public function setUserId(?int $value): static
    {
        $this->UserId = $value;
        return $this;
    }
}
