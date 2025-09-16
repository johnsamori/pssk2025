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
 * Entity class for "mahasiswa" table
 */

#[Entity]
#[Table("mahasiswa", options: ["dbId" => "DB"])]
class Mahasiswa extends AbstractEntity
{
    #[Id]
    #[Column(name: "NIM", type: "string", unique: true)]
    private string $Nim;

    #[Column(type: "string", nullable: true)]
    private ?string $Nama;

    #[Column(name: "`Jenis_Kelamin`", options: ["name" => "Jenis_Kelamin"], type: "string", nullable: true)]
    private ?string $JenisKelamin;

    #[Column(name: "`Provinsi_Tempat_Lahir`", options: ["name" => "Provinsi_Tempat_Lahir"], type: "string", nullable: true)]
    private ?string $ProvinsiTempatLahir;

    #[Column(name: "`Kota_Tempat_Lahir`", options: ["name" => "Kota_Tempat_Lahir"], type: "string", nullable: true)]
    private ?string $KotaTempatLahir;

    #[Column(name: "`Tanggal_Lahir`", options: ["name" => "Tanggal_Lahir"], type: "date", nullable: true)]
    private ?DateTime $TanggalLahir;

    #[Column(name: "`Golongan_Darah`", options: ["name" => "Golongan_Darah"], type: "string", nullable: true)]
    private ?string $GolonganDarah;

    #[Column(name: "`Tinggi_Badan`", options: ["name" => "Tinggi_Badan"], type: "string", nullable: true)]
    private ?string $TinggiBadan;

    #[Column(name: "`Berat_Badan`", options: ["name" => "Berat_Badan"], type: "string", nullable: true)]
    private ?string $BeratBadan;

    #[Column(name: "`Asal_sekolah`", options: ["name" => "Asal_sekolah"], type: "string", nullable: true)]
    private ?string $AsalSekolah;

    #[Column(name: "`Tahun_Ijazah`", options: ["name" => "Tahun_Ijazah"], type: "string", nullable: true)]
    private ?string $TahunIjazah;

    #[Column(name: "`Nomor_Ijazah`", options: ["name" => "Nomor_Ijazah"], type: "string", nullable: true)]
    private ?string $NomorIjazah;

    #[Column(name: "`Nilai_Raport_Kelas_10`", options: ["name" => "Nilai_Raport_Kelas_10"], type: "integer", nullable: true)]
    private ?int $NilaiRaportKelas10;

    #[Column(name: "`Nilai_Raport_Kelas_11`", options: ["name" => "Nilai_Raport_Kelas_11"], type: "integer", nullable: true)]
    private ?int $NilaiRaportKelas11;

    #[Column(name: "`Nilai_Raport_Kelas_12`", options: ["name" => "Nilai_Raport_Kelas_12"], type: "integer", nullable: true)]
    private ?int $NilaiRaportKelas12;

    #[Column(name: "`Tanggal_Daftar`", options: ["name" => "Tanggal_Daftar"], type: "date", nullable: true)]
    private ?DateTime $TanggalDaftar;

    #[Column(name: "`No_Test`", options: ["name" => "No_Test"], type: "string", nullable: true)]
    private ?string $NoTest;

    #[Column(name: "`Status_Masuk`", options: ["name" => "Status_Masuk"], type: "string", nullable: true)]
    private ?string $StatusMasuk;

    #[Column(name: "`Jalur_Masuk`", options: ["name" => "Jalur_Masuk"], type: "string", nullable: true)]
    private ?string $JalurMasuk;

    #[Column(name: "`Bukti_Lulus`", options: ["name" => "Bukti_Lulus"], type: "string", nullable: true)]
    private ?string $BuktiLulus;

    #[Column(name: "`Tes_Potensi_Akademik`", options: ["name" => "Tes_Potensi_Akademik"], type: "integer", nullable: true)]
    private ?int $TesPotensiAkademik;

    #[Column(name: "`Tes_Wawancara`", options: ["name" => "Tes_Wawancara"], type: "integer", nullable: true)]
    private ?int $TesWawancara;

    #[Column(name: "`Tes_Kesehatan`", options: ["name" => "Tes_Kesehatan"], type: "integer", nullable: true)]
    private ?int $TesKesehatan;

    #[Column(name: "`Hasil_Test_Kesehatan`", options: ["name" => "Hasil_Test_Kesehatan"], type: "string", nullable: true)]
    private ?string $HasilTestKesehatan;

    #[Column(name: "`Test_MMPI`", options: ["name" => "Test_MMPI"], type: "integer", nullable: true)]
    private ?int $TestMmpi;

    #[Column(name: "`Hasil_Test_MMPI`", options: ["name" => "Hasil_Test_MMPI"], type: "string", nullable: true)]
    private ?string $HasilTestMmpi;

    #[Column(type: "string", nullable: true)]
    private ?string $Angkatan;

    #[Column(name: "`Tarif_SPP`", options: ["name" => "Tarif_SPP"], type: "integer", nullable: true)]
    private ?int $TarifSpp;

    #[Column(name: "`NIK_No_KTP`", options: ["name" => "NIK_No_KTP"], type: "string", nullable: true)]
    private ?string $NikNoKtp;

    #[Column(name: "`No_KK`", options: ["name" => "No_KK"], type: "string", nullable: true)]
    private ?string $NoKk;

    #[Column(name: "NPWP", type: "string", nullable: true)]
    private ?string $Npwp;

    #[Column(name: "`Status_Nikah`", options: ["name" => "Status_Nikah"], type: "string", nullable: true)]
    private ?string $StatusNikah;

    #[Column(type: "string", nullable: true)]
    private ?string $Kewarganegaraan;

    #[Column(name: "`Propinsi_Tempat_Tinggal`", options: ["name" => "Propinsi_Tempat_Tinggal"], type: "string", nullable: true)]
    private ?string $PropinsiTempatTinggal;

    #[Column(name: "`Kota_Tempat_Tinggal`", options: ["name" => "Kota_Tempat_Tinggal"], type: "string", nullable: true)]
    private ?string $KotaTempatTinggal;

    #[Column(name: "`Kecamatan_Tempat_Tinggal`", options: ["name" => "Kecamatan_Tempat_Tinggal"], type: "string", nullable: true)]
    private ?string $KecamatanTempatTinggal;

    #[Column(name: "`Alamat_Tempat_Tinggal`", options: ["name" => "Alamat_Tempat_Tinggal"], type: "string", nullable: true)]
    private ?string $AlamatTempatTinggal;

    #[Column(name: "RT", type: "string", nullable: true)]
    private ?string $Rt;

    #[Column(name: "RW", type: "string", nullable: true)]
    private ?string $Rw;

    #[Column(type: "string", nullable: true)]
    private ?string $Kelurahan;

    #[Column(name: "`Kode_Pos`", options: ["name" => "Kode_Pos"], type: "string", nullable: true)]
    private ?string $KodePos;

    #[Column(name: "`Nomor_Telpon_HP`", options: ["name" => "Nomor_Telpon_HP"], type: "string", nullable: true)]
    private ?string $NomorTelponHp;

    #[Column(type: "string", nullable: true)]
    private ?string $Email;

    #[Column(name: "`Jenis_Tinggal`", options: ["name" => "Jenis_Tinggal"], type: "string", nullable: true)]
    private ?string $JenisTinggal;

    #[Column(name: "`Alat_Transportasi`", options: ["name" => "Alat_Transportasi"], type: "string", nullable: true)]
    private ?string $AlatTransportasi;

    #[Column(name: "`Sumber_Dana`", options: ["name" => "Sumber_Dana"], type: "string", nullable: true)]
    private ?string $SumberDana;

    #[Column(name: "`Sumber_Dana_Beasiswa`", options: ["name" => "Sumber_Dana_Beasiswa"], type: "string", nullable: true)]
    private ?string $SumberDanaBeasiswa;

    #[Column(name: "`Jumlah_Sudara`", options: ["name" => "Jumlah_Sudara"], type: "string", nullable: true)]
    private ?string $JumlahSudara;

    #[Column(name: "`Status_Bekerja`", options: ["name" => "Status_Bekerja"], type: "string", nullable: true)]
    private ?string $StatusBekerja;

    #[Column(name: "`Nomor_Asuransi`", options: ["name" => "Nomor_Asuransi"], type: "string", nullable: true)]
    private ?string $NomorAsuransi;

    #[Column(type: "string", nullable: true)]
    private ?string $Hobi;

    #[Column(type: "string", nullable: true)]
    private ?string $Foto;

    #[Column(name: "`Nama_Ayah`", options: ["name" => "Nama_Ayah"], type: "string", nullable: true)]
    private ?string $NamaAyah;

    #[Column(name: "`Pekerjaan_Ayah`", options: ["name" => "Pekerjaan_Ayah"], type: "string", nullable: true)]
    private ?string $PekerjaanAyah;

    #[Column(name: "`Nama_Ibu`", options: ["name" => "Nama_Ibu"], type: "string", nullable: true)]
    private ?string $NamaIbu;

    #[Column(name: "`Pekerjaan_Ibu`", options: ["name" => "Pekerjaan_Ibu"], type: "string", nullable: true)]
    private ?string $PekerjaanIbu;

    #[Column(name: "`Alamat_Orang_Tua`", options: ["name" => "Alamat_Orang_Tua"], type: "string", nullable: true)]
    private ?string $AlamatOrangTua;

    #[Column(name: "`e_mail_Oranng_Tua`", options: ["name" => "e_mail_Oranng_Tua"], type: "string", nullable: true)]
    private ?string $EMailOranngTua;

    #[Column(name: "`No_Kontak_Orang_Tua`", options: ["name" => "No_Kontak_Orang_Tua"], type: "string", nullable: true)]
    private ?string $NoKontakOrangTua;

    #[Column(name: "userid", type: "string", nullable: true)]
    private ?string $Userid;

    #[Column(name: "user", type: "string", nullable: true)]
    private ?string $User;

    #[Column(name: "ip", type: "string", nullable: true)]
    private ?string $Ip;

    #[Column(name: "tanggal_input", type: "date", nullable: true)]
    private ?DateTime $TanggalInput;

    public function getNim(): string
    {
        return $this->Nim;
    }

    public function setNim(string $value): static
    {
        $this->Nim = $value;
        return $this;
    }

    public function getNama(): ?string
    {
        return HtmlDecode($this->Nama);
    }

    public function setNama(?string $value): static
    {
        $this->Nama = RemoveXss($value);
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

    public function getProvinsiTempatLahir(): ?string
    {
        return HtmlDecode($this->ProvinsiTempatLahir);
    }

    public function setProvinsiTempatLahir(?string $value): static
    {
        $this->ProvinsiTempatLahir = RemoveXss($value);
        return $this;
    }

    public function getKotaTempatLahir(): ?string
    {
        return HtmlDecode($this->KotaTempatLahir);
    }

    public function setKotaTempatLahir(?string $value): static
    {
        $this->KotaTempatLahir = RemoveXss($value);
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

    public function getGolonganDarah(): ?string
    {
        return HtmlDecode($this->GolonganDarah);
    }

    public function setGolonganDarah(?string $value): static
    {
        $this->GolonganDarah = RemoveXss($value);
        return $this;
    }

    public function getTinggiBadan(): ?string
    {
        return HtmlDecode($this->TinggiBadan);
    }

    public function setTinggiBadan(?string $value): static
    {
        $this->TinggiBadan = RemoveXss($value);
        return $this;
    }

    public function getBeratBadan(): ?string
    {
        return HtmlDecode($this->BeratBadan);
    }

    public function setBeratBadan(?string $value): static
    {
        $this->BeratBadan = RemoveXss($value);
        return $this;
    }

    public function getAsalSekolah(): ?string
    {
        return HtmlDecode($this->AsalSekolah);
    }

    public function setAsalSekolah(?string $value): static
    {
        $this->AsalSekolah = RemoveXss($value);
        return $this;
    }

    public function getTahunIjazah(): ?string
    {
        return HtmlDecode($this->TahunIjazah);
    }

    public function setTahunIjazah(?string $value): static
    {
        $this->TahunIjazah = RemoveXss($value);
        return $this;
    }

    public function getNomorIjazah(): ?string
    {
        return HtmlDecode($this->NomorIjazah);
    }

    public function setNomorIjazah(?string $value): static
    {
        $this->NomorIjazah = RemoveXss($value);
        return $this;
    }

    public function getNilaiRaportKelas10(): ?int
    {
        return $this->NilaiRaportKelas10;
    }

    public function setNilaiRaportKelas10(?int $value): static
    {
        $this->NilaiRaportKelas10 = $value;
        return $this;
    }

    public function getNilaiRaportKelas11(): ?int
    {
        return $this->NilaiRaportKelas11;
    }

    public function setNilaiRaportKelas11(?int $value): static
    {
        $this->NilaiRaportKelas11 = $value;
        return $this;
    }

    public function getNilaiRaportKelas12(): ?int
    {
        return $this->NilaiRaportKelas12;
    }

    public function setNilaiRaportKelas12(?int $value): static
    {
        $this->NilaiRaportKelas12 = $value;
        return $this;
    }

    public function getTanggalDaftar(): ?DateTime
    {
        return $this->TanggalDaftar;
    }

    public function setTanggalDaftar(?DateTime $value): static
    {
        $this->TanggalDaftar = $value;
        return $this;
    }

    public function getNoTest(): ?string
    {
        return HtmlDecode($this->NoTest);
    }

    public function setNoTest(?string $value): static
    {
        $this->NoTest = RemoveXss($value);
        return $this;
    }

    public function getStatusMasuk(): ?string
    {
        return HtmlDecode($this->StatusMasuk);
    }

    public function setStatusMasuk(?string $value): static
    {
        $this->StatusMasuk = RemoveXss($value);
        return $this;
    }

    public function getJalurMasuk(): ?string
    {
        return HtmlDecode($this->JalurMasuk);
    }

    public function setJalurMasuk(?string $value): static
    {
        $this->JalurMasuk = RemoveXss($value);
        return $this;
    }

    public function getBuktiLulus(): ?string
    {
        return HtmlDecode($this->BuktiLulus);
    }

    public function setBuktiLulus(?string $value): static
    {
        $this->BuktiLulus = RemoveXss($value);
        return $this;
    }

    public function getTesPotensiAkademik(): ?int
    {
        return $this->TesPotensiAkademik;
    }

    public function setTesPotensiAkademik(?int $value): static
    {
        $this->TesPotensiAkademik = $value;
        return $this;
    }

    public function getTesWawancara(): ?int
    {
        return $this->TesWawancara;
    }

    public function setTesWawancara(?int $value): static
    {
        $this->TesWawancara = $value;
        return $this;
    }

    public function getTesKesehatan(): ?int
    {
        return $this->TesKesehatan;
    }

    public function setTesKesehatan(?int $value): static
    {
        $this->TesKesehatan = $value;
        return $this;
    }

    public function getHasilTestKesehatan(): ?string
    {
        return HtmlDecode($this->HasilTestKesehatan);
    }

    public function setHasilTestKesehatan(?string $value): static
    {
        $this->HasilTestKesehatan = RemoveXss($value);
        return $this;
    }

    public function getTestMmpi(): ?int
    {
        return $this->TestMmpi;
    }

    public function setTestMmpi(?int $value): static
    {
        $this->TestMmpi = $value;
        return $this;
    }

    public function getHasilTestMmpi(): ?string
    {
        return HtmlDecode($this->HasilTestMmpi);
    }

    public function setHasilTestMmpi(?string $value): static
    {
        $this->HasilTestMmpi = RemoveXss($value);
        return $this;
    }

    public function getAngkatan(): ?string
    {
        return HtmlDecode($this->Angkatan);
    }

    public function setAngkatan(?string $value): static
    {
        $this->Angkatan = RemoveXss($value);
        return $this;
    }

    public function getTarifSpp(): ?int
    {
        return $this->TarifSpp;
    }

    public function setTarifSpp(?int $value): static
    {
        $this->TarifSpp = $value;
        return $this;
    }

    public function getNikNoKtp(): ?string
    {
        return HtmlDecode($this->NikNoKtp);
    }

    public function setNikNoKtp(?string $value): static
    {
        $this->NikNoKtp = RemoveXss($value);
        return $this;
    }

    public function getNoKk(): ?string
    {
        return HtmlDecode($this->NoKk);
    }

    public function setNoKk(?string $value): static
    {
        $this->NoKk = RemoveXss($value);
        return $this;
    }

    public function getNpwp(): ?string
    {
        return HtmlDecode($this->Npwp);
    }

    public function setNpwp(?string $value): static
    {
        $this->Npwp = RemoveXss($value);
        return $this;
    }

    public function getStatusNikah(): ?string
    {
        return HtmlDecode($this->StatusNikah);
    }

    public function setStatusNikah(?string $value): static
    {
        $this->StatusNikah = RemoveXss($value);
        return $this;
    }

    public function getKewarganegaraan(): ?string
    {
        return HtmlDecode($this->Kewarganegaraan);
    }

    public function setKewarganegaraan(?string $value): static
    {
        $this->Kewarganegaraan = RemoveXss($value);
        return $this;
    }

    public function getPropinsiTempatTinggal(): ?string
    {
        return HtmlDecode($this->PropinsiTempatTinggal);
    }

    public function setPropinsiTempatTinggal(?string $value): static
    {
        $this->PropinsiTempatTinggal = RemoveXss($value);
        return $this;
    }

    public function getKotaTempatTinggal(): ?string
    {
        return HtmlDecode($this->KotaTempatTinggal);
    }

    public function setKotaTempatTinggal(?string $value): static
    {
        $this->KotaTempatTinggal = RemoveXss($value);
        return $this;
    }

    public function getKecamatanTempatTinggal(): ?string
    {
        return HtmlDecode($this->KecamatanTempatTinggal);
    }

    public function setKecamatanTempatTinggal(?string $value): static
    {
        $this->KecamatanTempatTinggal = RemoveXss($value);
        return $this;
    }

    public function getAlamatTempatTinggal(): ?string
    {
        return HtmlDecode($this->AlamatTempatTinggal);
    }

    public function setAlamatTempatTinggal(?string $value): static
    {
        $this->AlamatTempatTinggal = RemoveXss($value);
        return $this;
    }

    public function getRt(): ?string
    {
        return HtmlDecode($this->Rt);
    }

    public function setRt(?string $value): static
    {
        $this->Rt = RemoveXss($value);
        return $this;
    }

    public function getRw(): ?string
    {
        return HtmlDecode($this->Rw);
    }

    public function setRw(?string $value): static
    {
        $this->Rw = RemoveXss($value);
        return $this;
    }

    public function getKelurahan(): ?string
    {
        return HtmlDecode($this->Kelurahan);
    }

    public function setKelurahan(?string $value): static
    {
        $this->Kelurahan = RemoveXss($value);
        return $this;
    }

    public function getKodePos(): ?string
    {
        return HtmlDecode($this->KodePos);
    }

    public function setKodePos(?string $value): static
    {
        $this->KodePos = RemoveXss($value);
        return $this;
    }

    public function getNomorTelponHp(): ?string
    {
        return HtmlDecode($this->NomorTelponHp);
    }

    public function setNomorTelponHp(?string $value): static
    {
        $this->NomorTelponHp = RemoveXss($value);
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->Email);
    }

    public function setEmail(?string $value): static
    {
        $this->Email = RemoveXss($value);
        return $this;
    }

    public function getJenisTinggal(): ?string
    {
        return HtmlDecode($this->JenisTinggal);
    }

    public function setJenisTinggal(?string $value): static
    {
        $this->JenisTinggal = RemoveXss($value);
        return $this;
    }

    public function getAlatTransportasi(): ?string
    {
        return HtmlDecode($this->AlatTransportasi);
    }

    public function setAlatTransportasi(?string $value): static
    {
        $this->AlatTransportasi = RemoveXss($value);
        return $this;
    }

    public function getSumberDana(): ?string
    {
        return HtmlDecode($this->SumberDana);
    }

    public function setSumberDana(?string $value): static
    {
        $this->SumberDana = RemoveXss($value);
        return $this;
    }

    public function getSumberDanaBeasiswa(): ?string
    {
        return HtmlDecode($this->SumberDanaBeasiswa);
    }

    public function setSumberDanaBeasiswa(?string $value): static
    {
        $this->SumberDanaBeasiswa = RemoveXss($value);
        return $this;
    }

    public function getJumlahSudara(): ?string
    {
        return HtmlDecode($this->JumlahSudara);
    }

    public function setJumlahSudara(?string $value): static
    {
        $this->JumlahSudara = RemoveXss($value);
        return $this;
    }

    public function getStatusBekerja(): ?string
    {
        return HtmlDecode($this->StatusBekerja);
    }

    public function setStatusBekerja(?string $value): static
    {
        $this->StatusBekerja = RemoveXss($value);
        return $this;
    }

    public function getNomorAsuransi(): ?string
    {
        return HtmlDecode($this->NomorAsuransi);
    }

    public function setNomorAsuransi(?string $value): static
    {
        $this->NomorAsuransi = RemoveXss($value);
        return $this;
    }

    public function getHobi(): ?string
    {
        return HtmlDecode($this->Hobi);
    }

    public function setHobi(?string $value): static
    {
        $this->Hobi = RemoveXss($value);
        return $this;
    }

    public function getFoto(): ?string
    {
        return HtmlDecode($this->Foto);
    }

    public function setFoto(?string $value): static
    {
        $this->Foto = RemoveXss($value);
        return $this;
    }

    public function getNamaAyah(): ?string
    {
        return HtmlDecode($this->NamaAyah);
    }

    public function setNamaAyah(?string $value): static
    {
        $this->NamaAyah = RemoveXss($value);
        return $this;
    }

    public function getPekerjaanAyah(): ?string
    {
        return HtmlDecode($this->PekerjaanAyah);
    }

    public function setPekerjaanAyah(?string $value): static
    {
        $this->PekerjaanAyah = RemoveXss($value);
        return $this;
    }

    public function getNamaIbu(): ?string
    {
        return HtmlDecode($this->NamaIbu);
    }

    public function setNamaIbu(?string $value): static
    {
        $this->NamaIbu = RemoveXss($value);
        return $this;
    }

    public function getPekerjaanIbu(): ?string
    {
        return HtmlDecode($this->PekerjaanIbu);
    }

    public function setPekerjaanIbu(?string $value): static
    {
        $this->PekerjaanIbu = RemoveXss($value);
        return $this;
    }

    public function getAlamatOrangTua(): ?string
    {
        return HtmlDecode($this->AlamatOrangTua);
    }

    public function setAlamatOrangTua(?string $value): static
    {
        $this->AlamatOrangTua = RemoveXss($value);
        return $this;
    }

    public function getEMailOranngTua(): ?string
    {
        return HtmlDecode($this->EMailOranngTua);
    }

    public function setEMailOranngTua(?string $value): static
    {
        $this->EMailOranngTua = RemoveXss($value);
        return $this;
    }

    public function getNoKontakOrangTua(): ?string
    {
        return HtmlDecode($this->NoKontakOrangTua);
    }

    public function setNoKontakOrangTua(?string $value): static
    {
        $this->NoKontakOrangTua = RemoveXss($value);
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

    public function getTanggalInput(): ?DateTime
    {
        return $this->TanggalInput;
    }

    public function setTanggalInput(?DateTime $value): static
    {
        $this->TanggalInput = $value;
        return $this;
    }
}
