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
 * Entity class for "annex" table
 */

#[Entity]
#[Table("annex", options: ["dbId" => "DB"])]
class Annex extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $No;

    #[Column(name: "`Peraturan_Akdemik_Universitas`", options: ["name" => "Peraturan_Akdemik_Universitas"], type: "string", nullable: true)]
    private ?string $PeraturanAkdemikUniversitas;

    #[Column(name: "`Pedoman_Pelaksanaan_Peraturan_Akademik`", options: ["name" => "Pedoman_Pelaksanaan_Peraturan_Akademik"], type: "string", nullable: true)]
    private ?string $PedomanPelaksanaanPeraturanAkademik;

    #[Column(name: "`Rubrik_Penilaian`", options: ["name" => "Rubrik_Penilaian"], type: "string", nullable: true)]
    private ?string $RubrikPenilaian;

    #[Column(name: "`Panduan_Penulisan_KTI`", options: ["name" => "Panduan_Penulisan_KTI"], type: "string", nullable: true)]
    private ?string $PanduanPenulisanKti;

    public function getNo(): int
    {
        return $this->No;
    }

    public function setNo(int $value): static
    {
        $this->No = $value;
        return $this;
    }

    public function getPeraturanAkdemikUniversitas(): ?string
    {
        return HtmlDecode($this->PeraturanAkdemikUniversitas);
    }

    public function setPeraturanAkdemikUniversitas(?string $value): static
    {
        $this->PeraturanAkdemikUniversitas = RemoveXss($value);
        return $this;
    }

    public function getPedomanPelaksanaanPeraturanAkademik(): ?string
    {
        return HtmlDecode($this->PedomanPelaksanaanPeraturanAkademik);
    }

    public function setPedomanPelaksanaanPeraturanAkademik(?string $value): static
    {
        $this->PedomanPelaksanaanPeraturanAkademik = RemoveXss($value);
        return $this;
    }

    public function getRubrikPenilaian(): ?string
    {
        return HtmlDecode($this->RubrikPenilaian);
    }

    public function setRubrikPenilaian(?string $value): static
    {
        $this->RubrikPenilaian = RemoveXss($value);
        return $this;
    }

    public function getPanduanPenulisanKti(): ?string
    {
        return HtmlDecode($this->PanduanPenulisanKti);
    }

    public function setPanduanPenulisanKti(?string $value): static
    {
        $this->PanduanPenulisanKti = RemoveXss($value);
        return $this;
    }
}
