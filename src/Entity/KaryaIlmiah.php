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
 * Entity class for "karya_ilmiah" table
 */

#[Entity]
#[Table("karya_ilmiah", options: ["dbId" => "DB"])]
class KaryaIlmiah extends AbstractEntity
{
    #[Id]
    #[Column(name: "`Id_karya_ilmiah`", options: ["name" => "Id_karya_ilmiah"], type: "integer", unique: true)]
    #[GeneratedValue]
    private int $IdKaryaIlmiah;

    #[Column(name: "NIM", type: "string", nullable: true)]
    private ?string $Nim;

    #[Column(name: "`Judul_Penelitian`", options: ["name" => "Judul_Penelitian"], type: "string", nullable: true)]
    private ?string $JudulPenelitian;

    #[Column(name: "`Pembimbing_1`", options: ["name" => "Pembimbing_1"], type: "string", nullable: true)]
    private ?string $Pembimbing1;

    #[Column(name: "`Pembimbing_2`", options: ["name" => "Pembimbing_2"], type: "string", nullable: true)]
    private ?string $Pembimbing2;

    #[Column(name: "`Pembimbing_3`", options: ["name" => "Pembimbing_3"], type: "string", nullable: true)]
    private ?string $Pembimbing3;

    #[Column(name: "`Penguji_1`", options: ["name" => "Penguji_1"], type: "string", nullable: true)]
    private ?string $Penguji1;

    #[Column(name: "`Penguji_2`", options: ["name" => "Penguji_2"], type: "string", nullable: true)]
    private ?string $Penguji2;

    #[Column(name: "`Lembar_Pengesahan`", options: ["name" => "Lembar_Pengesahan"], type: "string", nullable: true)]
    private ?string $LembarPengesahan;

    #[Column(name: "`Judul_Publikasi`", options: ["name" => "Judul_Publikasi"], type: "string", nullable: true)]
    private ?string $JudulPublikasi;

    #[Column(name: "`Link_Publikasi`", options: ["name" => "Link_Publikasi"], type: "string", nullable: true)]
    private ?string $LinkPublikasi;

    #[Column(name: "user_id", type: "string", nullable: true)]
    private ?string $UserId;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "ip", type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "tanggal", type: "date", nullable: true)]
    private ?DateTime $Tanggal;

    public function getIdKaryaIlmiah(): int
    {
        return $this->IdKaryaIlmiah;
    }

    public function setIdKaryaIlmiah(int $value): static
    {
        $this->IdKaryaIlmiah = $value;
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

    public function getJudulPenelitian(): ?string
    {
        return HtmlDecode($this->JudulPenelitian);
    }

    public function setJudulPenelitian(?string $value): static
    {
        $this->JudulPenelitian = RemoveXss($value);
        return $this;
    }

    public function getPembimbing1(): ?string
    {
        return HtmlDecode($this->Pembimbing1);
    }

    public function setPembimbing1(?string $value): static
    {
        $this->Pembimbing1 = RemoveXss($value);
        return $this;
    }

    public function getPembimbing2(): ?string
    {
        return HtmlDecode($this->Pembimbing2);
    }

    public function setPembimbing2(?string $value): static
    {
        $this->Pembimbing2 = RemoveXss($value);
        return $this;
    }

    public function getPembimbing3(): ?string
    {
        return HtmlDecode($this->Pembimbing3);
    }

    public function setPembimbing3(?string $value): static
    {
        $this->Pembimbing3 = RemoveXss($value);
        return $this;
    }

    public function getPenguji1(): ?string
    {
        return HtmlDecode($this->Penguji1);
    }

    public function setPenguji1(?string $value): static
    {
        $this->Penguji1 = RemoveXss($value);
        return $this;
    }

    public function getPenguji2(): ?string
    {
        return HtmlDecode($this->Penguji2);
    }

    public function setPenguji2(?string $value): static
    {
        $this->Penguji2 = RemoveXss($value);
        return $this;
    }

    public function getLembarPengesahan(): ?string
    {
        return HtmlDecode($this->LembarPengesahan);
    }

    public function setLembarPengesahan(?string $value): static
    {
        $this->LembarPengesahan = RemoveXss($value);
        return $this;
    }

    public function getJudulPublikasi(): ?string
    {
        return HtmlDecode($this->JudulPublikasi);
    }

    public function setJudulPublikasi(?string $value): static
    {
        $this->JudulPublikasi = RemoveXss($value);
        return $this;
    }

    public function getLinkPublikasi(): ?string
    {
        return HtmlDecode($this->LinkPublikasi);
    }

    public function setLinkPublikasi(?string $value): static
    {
        $this->LinkPublikasi = RemoveXss($value);
        return $this;
    }

    public function getUserId(): ?string
    {
        return HtmlDecode($this->UserId);
    }

    public function setUserId(?string $value): static
    {
        $this->UserId = RemoveXss($value);
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
