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
 * Entity class for "detil_mata_kuliah" table
 */

#[Entity]
#[Table("detil_mata_kuliah", options: ["dbId" => "DB"])]
class DetilMataKuliah extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_no", type: "integer")]
    #[GeneratedValue]
    private int $IdNo;

    #[Id]
    #[Column(name: "`Kode_MK`", options: ["name" => "Kode_MK"], type: "string")]
    private string $KodeMk;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "`Nilai_Diskusi`", options: ["name" => "Nilai_Diskusi"], type: "string", nullable: true)]
    private ?string $NilaiDiskusi;

    #[Column(name: "`Assessment_Skor_As_1`", options: ["name" => "Assessment_Skor_As_1"], type: "string", nullable: true)]
    private ?string $AssessmentSkorAs1;

    #[Column(name: "`Assessment_Skor_As_2`", options: ["name" => "Assessment_Skor_As_2"], type: "string", nullable: true)]
    private ?string $AssessmentSkorAs2;

    #[Column(name: "`Assessment_Skor_As_3`", options: ["name" => "Assessment_Skor_As_3"], type: "string", nullable: true)]
    private ?string $AssessmentSkorAs3;

    #[Column(name: "`Nilai_Tugas`", options: ["name" => "Nilai_Tugas"], type: "string", nullable: true)]
    private ?string $NilaiTugas;

    #[Column(name: "`Nilai_UTS`", options: ["name" => "Nilai_UTS"], type: "string", nullable: true)]
    private ?string $NilaiUts;

    #[Column(name: "`Nilai_Akhir`", options: ["name" => "Nilai_Akhir"], type: "string", nullable: true)]
    private ?string $NilaiAkhir;

    #[Column(name: "iduser", type: "string", nullable: true)]
    private ?string $Iduser;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "ip", type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "tanggal", type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    public function __construct(int $IdNo, string $KodeMk)
    {
        $this->IdNo = $IdNo;
        $this->KodeMk = $KodeMk;
    }

    public function getIdNo(): int
    {
        return $this->IdNo;
    }

    public function setIdNo(int $value): static
    {
        $this->IdNo = $value;
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

    public function getNim(): ?string
    {
        return HtmlDecode($this->Nim);
    }

    public function setNim(?string $value): static
    {
        $this->Nim = RemoveXss($value);
        return $this;
    }

    public function getNilaiDiskusi(): ?string
    {
        return HtmlDecode($this->NilaiDiskusi);
    }

    public function setNilaiDiskusi(?string $value): static
    {
        $this->NilaiDiskusi = RemoveXss($value);
        return $this;
    }

    public function getAssessmentSkorAs1(): ?string
    {
        return HtmlDecode($this->AssessmentSkorAs1);
    }

    public function setAssessmentSkorAs1(?string $value): static
    {
        $this->AssessmentSkorAs1 = RemoveXss($value);
        return $this;
    }

    public function getAssessmentSkorAs2(): ?string
    {
        return HtmlDecode($this->AssessmentSkorAs2);
    }

    public function setAssessmentSkorAs2(?string $value): static
    {
        $this->AssessmentSkorAs2 = RemoveXss($value);
        return $this;
    }

    public function getAssessmentSkorAs3(): ?string
    {
        return HtmlDecode($this->AssessmentSkorAs3);
    }

    public function setAssessmentSkorAs3(?string $value): static
    {
        $this->AssessmentSkorAs3 = RemoveXss($value);
        return $this;
    }

    public function getNilaiTugas(): ?string
    {
        return HtmlDecode($this->NilaiTugas);
    }

    public function setNilaiTugas(?string $value): static
    {
        $this->NilaiTugas = RemoveXss($value);
        return $this;
    }

    public function getNilaiUts(): ?string
    {
        return HtmlDecode($this->NilaiUts);
    }

    public function setNilaiUts(?string $value): static
    {
        $this->NilaiUts = RemoveXss($value);
        return $this;
    }

    public function getNilaiAkhir(): ?string
    {
        return HtmlDecode($this->NilaiAkhir);
    }

    public function setNilaiAkhir(?string $value): static
    {
        $this->NilaiAkhir = RemoveXss($value);
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
