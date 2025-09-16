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
 * Entity class for "tahun_akademik" table
 */

#[Entity]
#[Table("tahun_akademik", options: ["dbId" => "DB"])]
class TahunAkademik extends AbstractEntity
{
    #[Id]
    #[Column(name: "id_tahun", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $IdTahun;

    #[Column(name: "`Tahun_Akademik`", options: ["name" => "Tahun_Akademik"], type: "string", nullable: true)]
    private ?string $_TahunAkademik;

    public function getIdTahun(): int
    {
        return $this->IdTahun;
    }

    public function setIdTahun(int $value): static
    {
        $this->IdTahun = $value;
        return $this;
    }

    public function get_TahunAkademik(): ?string
    {
        return HtmlDecode($this->_TahunAkademik);
    }

    public function set_TahunAkademik(?string $value): static
    {
        $this->_TahunAkademik = RemoveXss($value);
        return $this;
    }
}
