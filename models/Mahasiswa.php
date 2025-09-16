<?php

namespace PHPMaker2025\pssk2025;

use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\App;
use League\Flysystem\DirectoryListing;
use League\Flysystem\FilesystemException;
use Closure;
use DateTime;
use DateTimeImmutable;
use DateInterval;
use Exception;
use InvalidArgumentException;

/**
 * Table class for mahasiswa
 */
class Mahasiswa extends DbTable implements LookupTableInterface
{
    protected string $SqlFrom = "";
    protected ?QueryBuilder $SqlSelect = null;
    protected ?string $SqlSelectList = null;
    protected string $SqlWhere = "";
    protected string $SqlGroupBy = "";
    protected string $SqlHaving = "";
    protected string $SqlOrderBy = "";
    public string $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public string $LeftColumnClass = "col-sm-4 col-form-label ew-label";
    public string $RightColumnClass = "col-sm-8";
    public string $OffsetColumnClass = "col-sm-8 offset-sm-4";
    public string $TableLeftColumnClass = "w-col-4";

    // Ajax / Modal
    public bool $UseAjaxActions = false;
    public bool $ModalSearch = false;
    public bool $ModalView = false;
    public bool $ModalAdd = false;
    public bool $ModalEdit = false;
    public bool $ModalUpdate = false;
    public bool $InlineDelete = false;
    public bool $ModalGridAdd = false;
    public bool $ModalGridEdit = false;
    public bool $ModalMultiEdit = false;

    // Fields
    public DbField $NIM;
    public DbField $Nama;
    public DbField $Jenis_Kelamin;
    public DbField $Provinsi_Tempat_Lahir;
    public DbField $Kota_Tempat_Lahir;
    public DbField $Tanggal_Lahir;
    public DbField $Golongan_Darah;
    public DbField $Tinggi_Badan;
    public DbField $Berat_Badan;
    public DbField $Asal_sekolah;
    public DbField $Tahun_Ijazah;
    public DbField $Nomor_Ijazah;
    public DbField $Nilai_Raport_Kelas_10;
    public DbField $Nilai_Raport_Kelas_11;
    public DbField $Nilai_Raport_Kelas_12;
    public DbField $Tanggal_Daftar;
    public DbField $No_Test;
    public DbField $Status_Masuk;
    public DbField $Jalur_Masuk;
    public DbField $Bukti_Lulus;
    public DbField $Tes_Potensi_Akademik;
    public DbField $Tes_Wawancara;
    public DbField $Tes_Kesehatan;
    public DbField $Hasil_Test_Kesehatan;
    public DbField $Test_MMPI;
    public DbField $Hasil_Test_MMPI;
    public DbField $Angkatan;
    public DbField $Tarif_SPP;
    public DbField $NIK_No_KTP;
    public DbField $No_KK;
    public DbField $NPWP;
    public DbField $Status_Nikah;
    public DbField $Kewarganegaraan;
    public DbField $Propinsi_Tempat_Tinggal;
    public DbField $Kota_Tempat_Tinggal;
    public DbField $Kecamatan_Tempat_Tinggal;
    public DbField $Alamat_Tempat_Tinggal;
    public DbField $RT;
    public DbField $RW;
    public DbField $Kelurahan;
    public DbField $Kode_Pos;
    public DbField $Nomor_Telpon_HP;
    public DbField $_Email;
    public DbField $Jenis_Tinggal;
    public DbField $Alat_Transportasi;
    public DbField $Sumber_Dana;
    public DbField $Sumber_Dana_Beasiswa;
    public DbField $Jumlah_Sudara;
    public DbField $Status_Bekerja;
    public DbField $Nomor_Asuransi;
    public DbField $Hobi;
    public DbField $Foto;
    public DbField $Nama_Ayah;
    public DbField $Pekerjaan_Ayah;
    public DbField $Nama_Ibu;
    public DbField $Pekerjaan_Ibu;
    public DbField $Alamat_Orang_Tua;
    public DbField $e_mail_Oranng_Tua;
    public DbField $No_Kontak_Orang_Tua;
    public DbField $userid;
    public DbField $user;
    public DbField $ip;
    public DbField $tanggal_input;

    // Page ID
    public string $PageID = ""; // To be set by subclass

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        $this->TableVar = "mahasiswa";
        $this->TableName = 'mahasiswa';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");
        $this->UpdateTable = "mahasiswa"; // Update table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = null; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = null; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDPermission = Config("DEFAULT_USER_ID_PERMISSION"); // Default User ID permission
        $this->BasicSearch = new BasicSearch($this, Session(), $this->language);

        // NIM
        $this->NIM = new DbField(
            $this, // Table
            'x_NIM', // Variable name
            'NIM', // Name
            '`NIM`', // Expression
            '`NIM`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NIM`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NIM->InputTextType = "text";
        $this->NIM->Raw = true;
        $this->NIM->IsPrimaryKey = true; // Primary key field
        $this->NIM->Nullable = false; // NOT NULL field
        $this->NIM->Required = true; // Required field
        $this->NIM->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['NIM'] = &$this->NIM;

        // Nama
        $this->Nama = new DbField(
            $this, // Table
            'x_Nama', // Variable name
            'Nama', // Name
            '`Nama`', // Expression
            '`Nama`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nama`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nama->InputTextType = "text";
        $this->Nama->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nama'] = &$this->Nama;

        // Jenis_Kelamin
        $this->Jenis_Kelamin = new DbField(
            $this, // Table
            'x_Jenis_Kelamin', // Variable name
            'Jenis_Kelamin', // Name
            '`Jenis_Kelamin`', // Expression
            '`Jenis_Kelamin`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jenis_Kelamin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Jenis_Kelamin->InputTextType = "text";
        $this->Jenis_Kelamin->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jenis_Kelamin'] = &$this->Jenis_Kelamin;

        // Provinsi_Tempat_Lahir
        $this->Provinsi_Tempat_Lahir = new DbField(
            $this, // Table
            'x_Provinsi_Tempat_Lahir', // Variable name
            'Provinsi_Tempat_Lahir', // Name
            '`Provinsi_Tempat_Lahir`', // Expression
            '`Provinsi_Tempat_Lahir`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Provinsi_Tempat_Lahir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Provinsi_Tempat_Lahir->InputTextType = "text";
        $this->Provinsi_Tempat_Lahir->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Provinsi_Tempat_Lahir'] = &$this->Provinsi_Tempat_Lahir;

        // Kota_Tempat_Lahir
        $this->Kota_Tempat_Lahir = new DbField(
            $this, // Table
            'x_Kota_Tempat_Lahir', // Variable name
            'Kota_Tempat_Lahir', // Name
            '`Kota_Tempat_Lahir`', // Expression
            '`Kota_Tempat_Lahir`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kota_Tempat_Lahir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kota_Tempat_Lahir->InputTextType = "text";
        $this->Kota_Tempat_Lahir->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kota_Tempat_Lahir'] = &$this->Kota_Tempat_Lahir;

        // Tanggal_Lahir
        $this->Tanggal_Lahir = new DbField(
            $this, // Table
            'x_Tanggal_Lahir', // Variable name
            'Tanggal_Lahir', // Name
            '`Tanggal_Lahir`', // Expression
            CastDateFieldForLike("`Tanggal_Lahir`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`Tanggal_Lahir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tanggal_Lahir->InputTextType = "text";
        $this->Tanggal_Lahir->Raw = true;
        $this->Tanggal_Lahir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $this->language->phrase("IncorrectDate"));
        $this->Tanggal_Lahir->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tanggal_Lahir'] = &$this->Tanggal_Lahir;

        // Golongan_Darah
        $this->Golongan_Darah = new DbField(
            $this, // Table
            'x_Golongan_Darah', // Variable name
            'Golongan_Darah', // Name
            '`Golongan_Darah`', // Expression
            '`Golongan_Darah`', // Basic search expression
            200, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Golongan_Darah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Golongan_Darah->InputTextType = "text";
        $this->Golongan_Darah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Golongan_Darah'] = &$this->Golongan_Darah;

        // Tinggi_Badan
        $this->Tinggi_Badan = new DbField(
            $this, // Table
            'x_Tinggi_Badan', // Variable name
            'Tinggi_Badan', // Name
            '`Tinggi_Badan`', // Expression
            '`Tinggi_Badan`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tinggi_Badan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tinggi_Badan->InputTextType = "text";
        $this->Tinggi_Badan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tinggi_Badan'] = &$this->Tinggi_Badan;

        // Berat_Badan
        $this->Berat_Badan = new DbField(
            $this, // Table
            'x_Berat_Badan', // Variable name
            'Berat_Badan', // Name
            '`Berat_Badan`', // Expression
            '`Berat_Badan`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Berat_Badan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Berat_Badan->InputTextType = "text";
        $this->Berat_Badan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Berat_Badan'] = &$this->Berat_Badan;

        // Asal_sekolah
        $this->Asal_sekolah = new DbField(
            $this, // Table
            'x_Asal_sekolah', // Variable name
            'Asal_sekolah', // Name
            '`Asal_sekolah`', // Expression
            '`Asal_sekolah`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Asal_sekolah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Asal_sekolah->InputTextType = "text";
        $this->Asal_sekolah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Asal_sekolah'] = &$this->Asal_sekolah;

        // Tahun_Ijazah
        $this->Tahun_Ijazah = new DbField(
            $this, // Table
            'x_Tahun_Ijazah', // Variable name
            'Tahun_Ijazah', // Name
            '`Tahun_Ijazah`', // Expression
            '`Tahun_Ijazah`', // Basic search expression
            200, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tahun_Ijazah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tahun_Ijazah->InputTextType = "text";
        $this->Tahun_Ijazah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tahun_Ijazah'] = &$this->Tahun_Ijazah;

        // Nomor_Ijazah
        $this->Nomor_Ijazah = new DbField(
            $this, // Table
            'x_Nomor_Ijazah', // Variable name
            'Nomor_Ijazah', // Name
            '`Nomor_Ijazah`', // Expression
            '`Nomor_Ijazah`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nomor_Ijazah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nomor_Ijazah->InputTextType = "text";
        $this->Nomor_Ijazah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nomor_Ijazah'] = &$this->Nomor_Ijazah;

        // Nilai_Raport_Kelas_10
        $this->Nilai_Raport_Kelas_10 = new DbField(
            $this, // Table
            'x_Nilai_Raport_Kelas_10', // Variable name
            'Nilai_Raport_Kelas_10', // Name
            '`Nilai_Raport_Kelas_10`', // Expression
            '`Nilai_Raport_Kelas_10`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_Raport_Kelas_10`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_Raport_Kelas_10->InputTextType = "text";
        $this->Nilai_Raport_Kelas_10->Raw = true;
        $this->Nilai_Raport_Kelas_10->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Nilai_Raport_Kelas_10->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_Raport_Kelas_10'] = &$this->Nilai_Raport_Kelas_10;

        // Nilai_Raport_Kelas_11
        $this->Nilai_Raport_Kelas_11 = new DbField(
            $this, // Table
            'x_Nilai_Raport_Kelas_11', // Variable name
            'Nilai_Raport_Kelas_11', // Name
            '`Nilai_Raport_Kelas_11`', // Expression
            '`Nilai_Raport_Kelas_11`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_Raport_Kelas_11`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_Raport_Kelas_11->InputTextType = "text";
        $this->Nilai_Raport_Kelas_11->Raw = true;
        $this->Nilai_Raport_Kelas_11->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Nilai_Raport_Kelas_11->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_Raport_Kelas_11'] = &$this->Nilai_Raport_Kelas_11;

        // Nilai_Raport_Kelas_12
        $this->Nilai_Raport_Kelas_12 = new DbField(
            $this, // Table
            'x_Nilai_Raport_Kelas_12', // Variable name
            'Nilai_Raport_Kelas_12', // Name
            '`Nilai_Raport_Kelas_12`', // Expression
            '`Nilai_Raport_Kelas_12`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_Raport_Kelas_12`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_Raport_Kelas_12->InputTextType = "text";
        $this->Nilai_Raport_Kelas_12->Raw = true;
        $this->Nilai_Raport_Kelas_12->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Nilai_Raport_Kelas_12->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_Raport_Kelas_12'] = &$this->Nilai_Raport_Kelas_12;

        // Tanggal_Daftar
        $this->Tanggal_Daftar = new DbField(
            $this, // Table
            'x_Tanggal_Daftar', // Variable name
            'Tanggal_Daftar', // Name
            '`Tanggal_Daftar`', // Expression
            CastDateFieldForLike("`Tanggal_Daftar`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`Tanggal_Daftar`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tanggal_Daftar->InputTextType = "text";
        $this->Tanggal_Daftar->Raw = true;
        $this->Tanggal_Daftar->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $this->language->phrase("IncorrectDate"));
        $this->Tanggal_Daftar->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tanggal_Daftar'] = &$this->Tanggal_Daftar;

        // No_Test
        $this->No_Test = new DbField(
            $this, // Table
            'x_No_Test', // Variable name
            'No_Test', // Name
            '`No_Test`', // Expression
            '`No_Test`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`No_Test`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->No_Test->InputTextType = "text";
        $this->No_Test->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['No_Test'] = &$this->No_Test;

        // Status_Masuk
        $this->Status_Masuk = new DbField(
            $this, // Table
            'x_Status_Masuk', // Variable name
            'Status_Masuk', // Name
            '`Status_Masuk`', // Expression
            '`Status_Masuk`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Status_Masuk`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Status_Masuk->InputTextType = "text";
        $this->Status_Masuk->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Status_Masuk'] = &$this->Status_Masuk;

        // Jalur_Masuk
        $this->Jalur_Masuk = new DbField(
            $this, // Table
            'x_Jalur_Masuk', // Variable name
            'Jalur_Masuk', // Name
            '`Jalur_Masuk`', // Expression
            '`Jalur_Masuk`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jalur_Masuk`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Jalur_Masuk->InputTextType = "text";
        $this->Jalur_Masuk->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jalur_Masuk'] = &$this->Jalur_Masuk;

        // Bukti_Lulus
        $this->Bukti_Lulus = new DbField(
            $this, // Table
            'x_Bukti_Lulus', // Variable name
            'Bukti_Lulus', // Name
            '`Bukti_Lulus`', // Expression
            '`Bukti_Lulus`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Bukti_Lulus`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Bukti_Lulus->InputTextType = "text";
        $this->Bukti_Lulus->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Bukti_Lulus'] = &$this->Bukti_Lulus;

        // Tes_Potensi_Akademik
        $this->Tes_Potensi_Akademik = new DbField(
            $this, // Table
            'x_Tes_Potensi_Akademik', // Variable name
            'Tes_Potensi_Akademik', // Name
            '`Tes_Potensi_Akademik`', // Expression
            '`Tes_Potensi_Akademik`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tes_Potensi_Akademik`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tes_Potensi_Akademik->InputTextType = "text";
        $this->Tes_Potensi_Akademik->Raw = true;
        $this->Tes_Potensi_Akademik->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Tes_Potensi_Akademik->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tes_Potensi_Akademik'] = &$this->Tes_Potensi_Akademik;

        // Tes_Wawancara
        $this->Tes_Wawancara = new DbField(
            $this, // Table
            'x_Tes_Wawancara', // Variable name
            'Tes_Wawancara', // Name
            '`Tes_Wawancara`', // Expression
            '`Tes_Wawancara`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tes_Wawancara`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tes_Wawancara->InputTextType = "text";
        $this->Tes_Wawancara->Raw = true;
        $this->Tes_Wawancara->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Tes_Wawancara->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tes_Wawancara'] = &$this->Tes_Wawancara;

        // Tes_Kesehatan
        $this->Tes_Kesehatan = new DbField(
            $this, // Table
            'x_Tes_Kesehatan', // Variable name
            'Tes_Kesehatan', // Name
            '`Tes_Kesehatan`', // Expression
            '`Tes_Kesehatan`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tes_Kesehatan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tes_Kesehatan->InputTextType = "text";
        $this->Tes_Kesehatan->Raw = true;
        $this->Tes_Kesehatan->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Tes_Kesehatan->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tes_Kesehatan'] = &$this->Tes_Kesehatan;

        // Hasil_Test_Kesehatan
        $this->Hasil_Test_Kesehatan = new DbField(
            $this, // Table
            'x_Hasil_Test_Kesehatan', // Variable name
            'Hasil_Test_Kesehatan', // Name
            '`Hasil_Test_Kesehatan`', // Expression
            '`Hasil_Test_Kesehatan`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Hasil_Test_Kesehatan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Hasil_Test_Kesehatan->InputTextType = "text";
        $this->Hasil_Test_Kesehatan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Hasil_Test_Kesehatan'] = &$this->Hasil_Test_Kesehatan;

        // Test_MMPI
        $this->Test_MMPI = new DbField(
            $this, // Table
            'x_Test_MMPI', // Variable name
            'Test_MMPI', // Name
            '`Test_MMPI`', // Expression
            '`Test_MMPI`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Test_MMPI`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Test_MMPI->InputTextType = "text";
        $this->Test_MMPI->Raw = true;
        $this->Test_MMPI->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Test_MMPI->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Test_MMPI'] = &$this->Test_MMPI;

        // Hasil_Test_MMPI
        $this->Hasil_Test_MMPI = new DbField(
            $this, // Table
            'x_Hasil_Test_MMPI', // Variable name
            'Hasil_Test_MMPI', // Name
            '`Hasil_Test_MMPI`', // Expression
            '`Hasil_Test_MMPI`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Hasil_Test_MMPI`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Hasil_Test_MMPI->InputTextType = "text";
        $this->Hasil_Test_MMPI->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Hasil_Test_MMPI'] = &$this->Hasil_Test_MMPI;

        // Angkatan
        $this->Angkatan = new DbField(
            $this, // Table
            'x_Angkatan', // Variable name
            'Angkatan', // Name
            '`Angkatan`', // Expression
            '`Angkatan`', // Basic search expression
            200, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Angkatan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Angkatan->InputTextType = "text";
        $this->Angkatan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Angkatan'] = &$this->Angkatan;

        // Tarif_SPP
        $this->Tarif_SPP = new DbField(
            $this, // Table
            'x_Tarif_SPP', // Variable name
            'Tarif_SPP', // Name
            '`Tarif_SPP`', // Expression
            '`Tarif_SPP`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tarif_SPP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tarif_SPP->InputTextType = "text";
        $this->Tarif_SPP->Raw = true;
        $this->Tarif_SPP->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->Tarif_SPP->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tarif_SPP'] = &$this->Tarif_SPP;

        // NIK_No_KTP
        $this->NIK_No_KTP = new DbField(
            $this, // Table
            'x_NIK_No_KTP', // Variable name
            'NIK_No_KTP', // Name
            '`NIK_No_KTP`', // Expression
            '`NIK_No_KTP`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NIK_No_KTP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NIK_No_KTP->InputTextType = "text";
        $this->NIK_No_KTP->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['NIK_No_KTP'] = &$this->NIK_No_KTP;

        // No_KK
        $this->No_KK = new DbField(
            $this, // Table
            'x_No_KK', // Variable name
            'No_KK', // Name
            '`No_KK`', // Expression
            '`No_KK`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`No_KK`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->No_KK->InputTextType = "text";
        $this->No_KK->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['No_KK'] = &$this->No_KK;

        // NPWP
        $this->NPWP = new DbField(
            $this, // Table
            'x_NPWP', // Variable name
            'NPWP', // Name
            '`NPWP`', // Expression
            '`NPWP`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NPWP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NPWP->InputTextType = "text";
        $this->NPWP->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['NPWP'] = &$this->NPWP;

        // Status_Nikah
        $this->Status_Nikah = new DbField(
            $this, // Table
            'x_Status_Nikah', // Variable name
            'Status_Nikah', // Name
            '`Status_Nikah`', // Expression
            '`Status_Nikah`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Status_Nikah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Status_Nikah->InputTextType = "text";
        $this->Status_Nikah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Status_Nikah'] = &$this->Status_Nikah;

        // Kewarganegaraan
        $this->Kewarganegaraan = new DbField(
            $this, // Table
            'x_Kewarganegaraan', // Variable name
            'Kewarganegaraan', // Name
            '`Kewarganegaraan`', // Expression
            '`Kewarganegaraan`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kewarganegaraan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kewarganegaraan->InputTextType = "text";
        $this->Kewarganegaraan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kewarganegaraan'] = &$this->Kewarganegaraan;

        // Propinsi_Tempat_Tinggal
        $this->Propinsi_Tempat_Tinggal = new DbField(
            $this, // Table
            'x_Propinsi_Tempat_Tinggal', // Variable name
            'Propinsi_Tempat_Tinggal', // Name
            '`Propinsi_Tempat_Tinggal`', // Expression
            '`Propinsi_Tempat_Tinggal`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Propinsi_Tempat_Tinggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Propinsi_Tempat_Tinggal->InputTextType = "text";
        $this->Propinsi_Tempat_Tinggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Propinsi_Tempat_Tinggal'] = &$this->Propinsi_Tempat_Tinggal;

        // Kota_Tempat_Tinggal
        $this->Kota_Tempat_Tinggal = new DbField(
            $this, // Table
            'x_Kota_Tempat_Tinggal', // Variable name
            'Kota_Tempat_Tinggal', // Name
            '`Kota_Tempat_Tinggal`', // Expression
            '`Kota_Tempat_Tinggal`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kota_Tempat_Tinggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kota_Tempat_Tinggal->InputTextType = "text";
        $this->Kota_Tempat_Tinggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kota_Tempat_Tinggal'] = &$this->Kota_Tempat_Tinggal;

        // Kecamatan_Tempat_Tinggal
        $this->Kecamatan_Tempat_Tinggal = new DbField(
            $this, // Table
            'x_Kecamatan_Tempat_Tinggal', // Variable name
            'Kecamatan_Tempat_Tinggal', // Name
            '`Kecamatan_Tempat_Tinggal`', // Expression
            '`Kecamatan_Tempat_Tinggal`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kecamatan_Tempat_Tinggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kecamatan_Tempat_Tinggal->InputTextType = "text";
        $this->Kecamatan_Tempat_Tinggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kecamatan_Tempat_Tinggal'] = &$this->Kecamatan_Tempat_Tinggal;

        // Alamat_Tempat_Tinggal
        $this->Alamat_Tempat_Tinggal = new DbField(
            $this, // Table
            'x_Alamat_Tempat_Tinggal', // Variable name
            'Alamat_Tempat_Tinggal', // Name
            '`Alamat_Tempat_Tinggal`', // Expression
            '`Alamat_Tempat_Tinggal`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Alamat_Tempat_Tinggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Alamat_Tempat_Tinggal->InputTextType = "text";
        $this->Alamat_Tempat_Tinggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Alamat_Tempat_Tinggal'] = &$this->Alamat_Tempat_Tinggal;

        // RT
        $this->RT = new DbField(
            $this, // Table
            'x_RT', // Variable name
            'RT', // Name
            '`RT`', // Expression
            '`RT`', // Basic search expression
            200, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`RT`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->RT->InputTextType = "text";
        $this->RT->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['RT'] = &$this->RT;

        // RW
        $this->RW = new DbField(
            $this, // Table
            'x_RW', // Variable name
            'RW', // Name
            '`RW`', // Expression
            '`RW`', // Basic search expression
            200, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`RW`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->RW->InputTextType = "text";
        $this->RW->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['RW'] = &$this->RW;

        // Kelurahan
        $this->Kelurahan = new DbField(
            $this, // Table
            'x_Kelurahan', // Variable name
            'Kelurahan', // Name
            '`Kelurahan`', // Expression
            '`Kelurahan`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kelurahan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kelurahan->InputTextType = "text";
        $this->Kelurahan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kelurahan'] = &$this->Kelurahan;

        // Kode_Pos
        $this->Kode_Pos = new DbField(
            $this, // Table
            'x_Kode_Pos', // Variable name
            'Kode_Pos', // Name
            '`Kode_Pos`', // Expression
            '`Kode_Pos`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kode_Pos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kode_Pos->InputTextType = "text";
        $this->Kode_Pos->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kode_Pos'] = &$this->Kode_Pos;

        // Nomor_Telpon_HP
        $this->Nomor_Telpon_HP = new DbField(
            $this, // Table
            'x_Nomor_Telpon_HP', // Variable name
            'Nomor_Telpon_HP', // Name
            '`Nomor_Telpon_HP`', // Expression
            '`Nomor_Telpon_HP`', // Basic search expression
            200, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nomor_Telpon_HP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nomor_Telpon_HP->InputTextType = "text";
        $this->Nomor_Telpon_HP->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nomor_Telpon_HP'] = &$this->Nomor_Telpon_HP;

        // Email
        $this->_Email = new DbField(
            $this, // Table
            'x__Email', // Variable name
            'Email', // Name
            '`Email`', // Expression
            '`Email`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Email`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_Email->InputTextType = "text";
        $this->_Email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Email'] = &$this->_Email;

        // Jenis_Tinggal
        $this->Jenis_Tinggal = new DbField(
            $this, // Table
            'x_Jenis_Tinggal', // Variable name
            'Jenis_Tinggal', // Name
            '`Jenis_Tinggal`', // Expression
            '`Jenis_Tinggal`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jenis_Tinggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Jenis_Tinggal->InputTextType = "text";
        $this->Jenis_Tinggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jenis_Tinggal'] = &$this->Jenis_Tinggal;

        // Alat_Transportasi
        $this->Alat_Transportasi = new DbField(
            $this, // Table
            'x_Alat_Transportasi', // Variable name
            'Alat_Transportasi', // Name
            '`Alat_Transportasi`', // Expression
            '`Alat_Transportasi`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Alat_Transportasi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Alat_Transportasi->InputTextType = "text";
        $this->Alat_Transportasi->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Alat_Transportasi'] = &$this->Alat_Transportasi;

        // Sumber_Dana
        $this->Sumber_Dana = new DbField(
            $this, // Table
            'x_Sumber_Dana', // Variable name
            'Sumber_Dana', // Name
            '`Sumber_Dana`', // Expression
            '`Sumber_Dana`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Sumber_Dana`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Sumber_Dana->InputTextType = "text";
        $this->Sumber_Dana->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Sumber_Dana'] = &$this->Sumber_Dana;

        // Sumber_Dana_Beasiswa
        $this->Sumber_Dana_Beasiswa = new DbField(
            $this, // Table
            'x_Sumber_Dana_Beasiswa', // Variable name
            'Sumber_Dana_Beasiswa', // Name
            '`Sumber_Dana_Beasiswa`', // Expression
            '`Sumber_Dana_Beasiswa`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Sumber_Dana_Beasiswa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Sumber_Dana_Beasiswa->InputTextType = "text";
        $this->Sumber_Dana_Beasiswa->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Sumber_Dana_Beasiswa'] = &$this->Sumber_Dana_Beasiswa;

        // Jumlah_Sudara
        $this->Jumlah_Sudara = new DbField(
            $this, // Table
            'x_Jumlah_Sudara', // Variable name
            'Jumlah_Sudara', // Name
            '`Jumlah_Sudara`', // Expression
            '`Jumlah_Sudara`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jumlah_Sudara`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Jumlah_Sudara->InputTextType = "text";
        $this->Jumlah_Sudara->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jumlah_Sudara'] = &$this->Jumlah_Sudara;

        // Status_Bekerja
        $this->Status_Bekerja = new DbField(
            $this, // Table
            'x_Status_Bekerja', // Variable name
            'Status_Bekerja', // Name
            '`Status_Bekerja`', // Expression
            '`Status_Bekerja`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Status_Bekerja`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Status_Bekerja->InputTextType = "text";
        $this->Status_Bekerja->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Status_Bekerja'] = &$this->Status_Bekerja;

        // Nomor_Asuransi
        $this->Nomor_Asuransi = new DbField(
            $this, // Table
            'x_Nomor_Asuransi', // Variable name
            'Nomor_Asuransi', // Name
            '`Nomor_Asuransi`', // Expression
            '`Nomor_Asuransi`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nomor_Asuransi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nomor_Asuransi->InputTextType = "text";
        $this->Nomor_Asuransi->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nomor_Asuransi'] = &$this->Nomor_Asuransi;

        // Hobi
        $this->Hobi = new DbField(
            $this, // Table
            'x_Hobi', // Variable name
            'Hobi', // Name
            '`Hobi`', // Expression
            '`Hobi`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Hobi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Hobi->InputTextType = "text";
        $this->Hobi->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Hobi'] = &$this->Hobi;

        // Foto
        $this->Foto = new DbField(
            $this, // Table
            'x_Foto', // Variable name
            'Foto', // Name
            '`Foto`', // Expression
            '`Foto`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Foto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Foto->InputTextType = "text";
        $this->Foto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Foto'] = &$this->Foto;

        // Nama_Ayah
        $this->Nama_Ayah = new DbField(
            $this, // Table
            'x_Nama_Ayah', // Variable name
            'Nama_Ayah', // Name
            '`Nama_Ayah`', // Expression
            '`Nama_Ayah`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nama_Ayah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nama_Ayah->InputTextType = "text";
        $this->Nama_Ayah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nama_Ayah'] = &$this->Nama_Ayah;

        // Pekerjaan_Ayah
        $this->Pekerjaan_Ayah = new DbField(
            $this, // Table
            'x_Pekerjaan_Ayah', // Variable name
            'Pekerjaan_Ayah', // Name
            '`Pekerjaan_Ayah`', // Expression
            '`Pekerjaan_Ayah`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Pekerjaan_Ayah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Pekerjaan_Ayah->InputTextType = "text";
        $this->Pekerjaan_Ayah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Pekerjaan_Ayah'] = &$this->Pekerjaan_Ayah;

        // Nama_Ibu
        $this->Nama_Ibu = new DbField(
            $this, // Table
            'x_Nama_Ibu', // Variable name
            'Nama_Ibu', // Name
            '`Nama_Ibu`', // Expression
            '`Nama_Ibu`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nama_Ibu`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nama_Ibu->InputTextType = "text";
        $this->Nama_Ibu->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nama_Ibu'] = &$this->Nama_Ibu;

        // Pekerjaan_Ibu
        $this->Pekerjaan_Ibu = new DbField(
            $this, // Table
            'x_Pekerjaan_Ibu', // Variable name
            'Pekerjaan_Ibu', // Name
            '`Pekerjaan_Ibu`', // Expression
            '`Pekerjaan_Ibu`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Pekerjaan_Ibu`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Pekerjaan_Ibu->InputTextType = "text";
        $this->Pekerjaan_Ibu->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Pekerjaan_Ibu'] = &$this->Pekerjaan_Ibu;

        // Alamat_Orang_Tua
        $this->Alamat_Orang_Tua = new DbField(
            $this, // Table
            'x_Alamat_Orang_Tua', // Variable name
            'Alamat_Orang_Tua', // Name
            '`Alamat_Orang_Tua`', // Expression
            '`Alamat_Orang_Tua`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Alamat_Orang_Tua`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Alamat_Orang_Tua->InputTextType = "text";
        $this->Alamat_Orang_Tua->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Alamat_Orang_Tua'] = &$this->Alamat_Orang_Tua;

        // e_mail_Oranng_Tua
        $this->e_mail_Oranng_Tua = new DbField(
            $this, // Table
            'x_e_mail_Oranng_Tua', // Variable name
            'e_mail_Oranng_Tua', // Name
            '`e_mail_Oranng_Tua`', // Expression
            '`e_mail_Oranng_Tua`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`e_mail_Oranng_Tua`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->e_mail_Oranng_Tua->InputTextType = "text";
        $this->e_mail_Oranng_Tua->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['e_mail_Oranng_Tua'] = &$this->e_mail_Oranng_Tua;

        // No_Kontak_Orang_Tua
        $this->No_Kontak_Orang_Tua = new DbField(
            $this, // Table
            'x_No_Kontak_Orang_Tua', // Variable name
            'No_Kontak_Orang_Tua', // Name
            '`No_Kontak_Orang_Tua`', // Expression
            '`No_Kontak_Orang_Tua`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`No_Kontak_Orang_Tua`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->No_Kontak_Orang_Tua->InputTextType = "text";
        $this->No_Kontak_Orang_Tua->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['No_Kontak_Orang_Tua'] = &$this->No_Kontak_Orang_Tua;

        // userid
        $this->userid = new DbField(
            $this, // Table
            'x_userid', // Variable name
            'userid', // Name
            '`userid`', // Expression
            '`userid`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`userid`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->userid->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->userid->InputTextType = "text";
        $this->userid->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['userid'] = &$this->userid;

        // user
        $this->user = new DbField(
            $this, // Table
            'x_user', // Variable name
            'user', // Name
            '`user`', // Expression
            '`user`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`user`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->user->addMethod("getAutoUpdateValue", fn() => CurrentUserName());
        $this->user->InputTextType = "text";
        $this->user->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user'] = &$this->user;

        // ip
        $this->ip = new DbField(
            $this, // Table
            'x_ip', // Variable name
            'ip', // Name
            '`ip`', // Expression
            '`ip`', // Basic search expression
            200, // Type
            64, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ip`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ip->addMethod("getAutoUpdateValue", fn() => CurrentUserIP());
        $this->ip->InputTextType = "text";
        $this->ip->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ip'] = &$this->ip;

        // tanggal_input
        $this->tanggal_input = new DbField(
            $this, // Table
            'x_tanggal_input', // Variable name
            'tanggal_input', // Name
            '`tanggal_input`', // Expression
            CastDateFieldForLike("`tanggal_input`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`tanggal_input`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tanggal_input->addMethod("getAutoUpdateValue", fn() => CurrentDate());
        $this->tanggal_input->InputTextType = "text";
        $this->tanggal_input->Raw = true;
        $this->tanggal_input->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $this->language->phrase("IncorrectDate"));
        $this->tanggal_input->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tanggal_input'] = &$this->tanggal_input;

        // Cache profile
        $this->cacheProfile = new QueryCacheProfile(0, $this->TableVar, Container("result.cache"));

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility(string $fldParm): bool
    {
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass(string $class): void
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(DbField &$fld): void
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort(): void
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Render X Axis for chart
    public function renderChartXAxis(string $chartVar, array $chartRow): array
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom(): string
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "mahasiswa";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom(): string
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom(string $v): void
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect(): QueryBuilder // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields(): string
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect(): QueryBuilder
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect(QueryBuilder $v): void
    {
        $this->SqlSelect = $v;
    }

    // Get default filter
    public function getDefaultFilter(): string
    {
        return "";
    }

    // Get WHERE clause
    public function getSqlWhere(bool $delete = false): string
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        AddFilter($where, $this->getDefaultFilter());
        if (!$delete && !IsEmpty($this->SoftDeleteFieldName) && $this->UseSoftDeleteFilter) { // Add soft delete filter
            AddFilter($where, $this->Fields[$this->SoftDeleteFieldName]->Expression . " IS NULL");
            if ($this->TimeAware) { // Add time aware filter
                AddFilter($where, $this->Fields[$this->SoftDeleteFieldName]->Expression . " > " . $this->getConnection()->getDatabasePlatform()->getCurrentTimestampSQL(), "OR");
            }
        }
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere(): string
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere(string $v): void
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy(): string
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy(): string
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy(string $v): void
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving(): string // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving(): string
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving(string $v): void
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy(): string
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy(): string
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy(string $v): void
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters(string $filter, string $id = ""): string
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow(string $id = ""): bool
    {
        $allow = $this->UserIDPermission;
        return match ($id) {
            "add", "copy", "gridadd", "register", "addopt" => ($allow & Allow::ADD->value) == Allow::ADD->value,
            "edit", "gridedit", "update", "changepassword", "resetpassword" => ($allow & Allow::EDIT->value) == Allow::EDIT->value,
            "delete" => ($allow & Allow::DELETE->value) == Allow::DELETE->value,
            "view" => ($allow & Allow::VIEW->value) == Allow::VIEW->value,
            "search" => ($allow & Allow::SEARCH->value) == Allow::SEARCH->value,
            "lookup" => ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value,
            default => ($allow & Allow::LIST->value) == Allow::LIST->value
        };
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param Connection $c Connection
     * @return int
     */
    public function getRecordCount(string|QueryBuilder $sql, ?Connection $c = null): int
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetOrderBy()->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+?)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"])
            && preg_match($pattern, $sqlwrk)
            && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk)
            && !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk)
            && !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetchAssociative()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql(string $where, string $orderBy = "", bool $delete = false): QueryBuilder
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy, $delete);
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder(string $where, string $orderBy = "", bool $delete = false): QueryBuilder
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere($delete),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql(bool $delete = false): QueryBuilder
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort, $delete);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql(): QueryBuilder
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy(): string
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter
    public function loadRecordCount($filter, $delete = false): int
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        if ($delete == false) {
            $this->recordsSelecting($this->CurrentFilter);
        }
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere($delete), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount(): int
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * Get query builder for INSERT
     *
     * @param array $row Row to be inserted
     * @return QueryBuilder
     */
    public function insertSql(array $row): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder()->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($row as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(array &$row): int|bool
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($row);
            $result = $queryBuilder->executeStatement();
			if ($result) {
                $this->clearLookupCache();
            }
            $this->DbErrorMessage = "";
        } catch (Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
        }
        return $result;
    }

    /**
     * Get query builder for UPDATE
     *
     * @param array $row Row to be updated
     * @param string|array $where WHERE clause
     * @return QueryBuilder
     */
    public function updateSql(array $row, string|array $where = ""): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder()->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($row as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $where = is_array($where) ? $this->arrayToFilter($where) : $where;
        if ($where != "") {
            $queryBuilder->where($where);
        }
        return $queryBuilder;
    }

    // Update
    public function update(array $row, string|array $where = "", ?array $old = null, bool $currentFilter = true): int|bool
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $where = is_array($where) ? $this->arrayToFilter($where) : $where;
            $filter = $currentFilter ? $this->CurrentFilter : "";
            AddFilter($where, $filter);
            $success = $this->updateSql($row, $where)->executeStatement();
            $success = $success > 0 ? $success : true;
			if ($success) {
                $this->clearLookupCache();
            }
            $this->DbErrorMessage = "";
        } catch (Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        return $success;
    }

    /**
     * Get query builder for DELETE
     *
     * @param ?array $row Key values
     * @param string|array $where WHERE clause
     * @return QueryBuilder
     */
    public function deleteSql(?array $row, string|array $where = ""): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder()->delete($this->UpdateTable);
        $where = is_array($where) ? $this->arrayToFilter($where) : $where;
        if ($row) {
            if (array_key_exists('NIM', $row)) {
                AddFilter($where, QuotedName('NIM', $this->Dbid) . '=' . QuotedValue($row['NIM'], $this->NIM->DataType, $this->Dbid));
            }
        }
        return $queryBuilder->where($where != "" ? $where : "0=1");
    }

    // Delete
    public function delete(array $row, string|array $where = "", bool $currentFilter = false): int|bool
    {
        $success = true;
        if ($success) {
            try {
                // Check soft delete
                $softDelete = !IsEmpty($this->SoftDeleteFieldName)
                    && (
                        !$this->HardDelete
                        || $row[$this->SoftDeleteFieldName] === null
                        || $this->TimeAware && (new DateTimeImmutable($row[$this->SoftDeleteFieldName]))->getTimestamp() > time()
                    );
                if ($softDelete) { // Soft delete
                    $newRow = $row;
                    if ($this->TimeAware && IsEmpty($row[$this->SoftDeleteFieldName])) { // Set expiration datetime
                        $newRow[$this->SoftDeleteFieldName] = StdDateTime(strtotime($this->SoftDeleteTimeAwarePeriod));
                    } else { // Set now
                        $newRow[$this->SoftDeleteFieldName] = StdCurrentDateTime();
                    }
                    $success = $this->update($newRow, $this->getRecordFilter($row), $row);
                } else { // Delete permanently
                    $where = is_array($where) ? $this->arrayToFilter($where) : $where;
                    $filter = $currentFilter ? $this->CurrentFilter : "";
                    AddFilter($where, $filter);
                    $success = $this->deleteSql($row, $where)->executeStatement();
                    $this->DbErrorMessage = "";
                }
				if ($success) {
                    $this->clearLookupCache();
                }
            } catch (Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

	// Clear lookup cache for this table
    protected function clearLookupCache()
    {
        $cache = Container("result.cache");
        $cache->clear("lookup.cache." . $this->TableVar . ".");
        if ($cache instanceof PruneableInterface) {
            $cache->prune();
        }
    }

    // Load DbValue from result set or array
    protected function loadDbValues(?array $row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->NIM->DbValue = $row['NIM'];
        $this->Nama->DbValue = $row['Nama'];
        $this->Jenis_Kelamin->DbValue = $row['Jenis_Kelamin'];
        $this->Provinsi_Tempat_Lahir->DbValue = $row['Provinsi_Tempat_Lahir'];
        $this->Kota_Tempat_Lahir->DbValue = $row['Kota_Tempat_Lahir'];
        $this->Tanggal_Lahir->DbValue = $row['Tanggal_Lahir'];
        $this->Golongan_Darah->DbValue = $row['Golongan_Darah'];
        $this->Tinggi_Badan->DbValue = $row['Tinggi_Badan'];
        $this->Berat_Badan->DbValue = $row['Berat_Badan'];
        $this->Asal_sekolah->DbValue = $row['Asal_sekolah'];
        $this->Tahun_Ijazah->DbValue = $row['Tahun_Ijazah'];
        $this->Nomor_Ijazah->DbValue = $row['Nomor_Ijazah'];
        $this->Nilai_Raport_Kelas_10->DbValue = $row['Nilai_Raport_Kelas_10'];
        $this->Nilai_Raport_Kelas_11->DbValue = $row['Nilai_Raport_Kelas_11'];
        $this->Nilai_Raport_Kelas_12->DbValue = $row['Nilai_Raport_Kelas_12'];
        $this->Tanggal_Daftar->DbValue = $row['Tanggal_Daftar'];
        $this->No_Test->DbValue = $row['No_Test'];
        $this->Status_Masuk->DbValue = $row['Status_Masuk'];
        $this->Jalur_Masuk->DbValue = $row['Jalur_Masuk'];
        $this->Bukti_Lulus->DbValue = $row['Bukti_Lulus'];
        $this->Tes_Potensi_Akademik->DbValue = $row['Tes_Potensi_Akademik'];
        $this->Tes_Wawancara->DbValue = $row['Tes_Wawancara'];
        $this->Tes_Kesehatan->DbValue = $row['Tes_Kesehatan'];
        $this->Hasil_Test_Kesehatan->DbValue = $row['Hasil_Test_Kesehatan'];
        $this->Test_MMPI->DbValue = $row['Test_MMPI'];
        $this->Hasil_Test_MMPI->DbValue = $row['Hasil_Test_MMPI'];
        $this->Angkatan->DbValue = $row['Angkatan'];
        $this->Tarif_SPP->DbValue = $row['Tarif_SPP'];
        $this->NIK_No_KTP->DbValue = $row['NIK_No_KTP'];
        $this->No_KK->DbValue = $row['No_KK'];
        $this->NPWP->DbValue = $row['NPWP'];
        $this->Status_Nikah->DbValue = $row['Status_Nikah'];
        $this->Kewarganegaraan->DbValue = $row['Kewarganegaraan'];
        $this->Propinsi_Tempat_Tinggal->DbValue = $row['Propinsi_Tempat_Tinggal'];
        $this->Kota_Tempat_Tinggal->DbValue = $row['Kota_Tempat_Tinggal'];
        $this->Kecamatan_Tempat_Tinggal->DbValue = $row['Kecamatan_Tempat_Tinggal'];
        $this->Alamat_Tempat_Tinggal->DbValue = $row['Alamat_Tempat_Tinggal'];
        $this->RT->DbValue = $row['RT'];
        $this->RW->DbValue = $row['RW'];
        $this->Kelurahan->DbValue = $row['Kelurahan'];
        $this->Kode_Pos->DbValue = $row['Kode_Pos'];
        $this->Nomor_Telpon_HP->DbValue = $row['Nomor_Telpon_HP'];
        $this->_Email->DbValue = $row['Email'];
        $this->Jenis_Tinggal->DbValue = $row['Jenis_Tinggal'];
        $this->Alat_Transportasi->DbValue = $row['Alat_Transportasi'];
        $this->Sumber_Dana->DbValue = $row['Sumber_Dana'];
        $this->Sumber_Dana_Beasiswa->DbValue = $row['Sumber_Dana_Beasiswa'];
        $this->Jumlah_Sudara->DbValue = $row['Jumlah_Sudara'];
        $this->Status_Bekerja->DbValue = $row['Status_Bekerja'];
        $this->Nomor_Asuransi->DbValue = $row['Nomor_Asuransi'];
        $this->Hobi->DbValue = $row['Hobi'];
        $this->Foto->DbValue = $row['Foto'];
        $this->Nama_Ayah->DbValue = $row['Nama_Ayah'];
        $this->Pekerjaan_Ayah->DbValue = $row['Pekerjaan_Ayah'];
        $this->Nama_Ibu->DbValue = $row['Nama_Ibu'];
        $this->Pekerjaan_Ibu->DbValue = $row['Pekerjaan_Ibu'];
        $this->Alamat_Orang_Tua->DbValue = $row['Alamat_Orang_Tua'];
        $this->e_mail_Oranng_Tua->DbValue = $row['e_mail_Oranng_Tua'];
        $this->No_Kontak_Orang_Tua->DbValue = $row['No_Kontak_Orang_Tua'];
        $this->userid->DbValue = $row['userid'];
        $this->user->DbValue = $row['user'];
        $this->ip->DbValue = $row['ip'];
        $this->tanggal_input->DbValue = $row['tanggal_input'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles(array $row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter(): string
    {
        return "`NIM` = '@NIM@'";
    }

    // Get Key from record
    public function getKeyFromRecord(array $row, ?string $keySeparator = null): string
    {
        $keys = [];
        $val = $row['NIM'];
        if (IsEmpty($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Get Key
    public function getKey(bool $current = false, ?string $keySeparator = null): string
    {
        $keys = [];
        $val = $current ? $this->NIM->CurrentValue : $this->NIM->OldValue;
        if (IsEmpty($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey(string $key, bool $current = false, ?string $keySeparator = null): void
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = $key;
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->NIM->CurrentValue = $keys[0];
            } else {
                $this->NIM->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter(?array $row = null, bool $current = false): string
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('NIM', $row) ? $row['NIM'] : null;
        } else {
            $val = !IsEmpty($this->NIM->OldValue) && !$current ? $this->NIM->OldValue : $this->NIM->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@NIM@", AdjustSql($val), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl(): string
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = AddTabId(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL"));
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            Session($name, $referUrl); // Save to Session
        }
        return Session($name) ?? GetUrl("mahasiswalist");
    }

    // Set return page URL
    public function setReturnUrl(string $v): void
    {
        Session(AddTabId(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")), $v);
    }

    // Get modal caption
    public function getModalCaption(string $pageName): string
    {
        return match ($pageName) {
            "mahasiswaview" => $this->language->phrase("View"),
            "mahasiswaedit" => $this->language->phrase("Edit"),
            "mahasiswaadd" => $this->language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl(): string
    {
        return "mahasiswalist";
    }

    // API page name
    public function getApiPageName(string $action): string
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "MahasiswaView",
            Config("API_ADD_ACTION") => "MahasiswaAdd",
            Config("API_EDIT_ACTION") => "MahasiswaEdit",
            Config("API_DELETE_ACTION") => "MahasiswaDelete",
            Config("API_LIST_ACTION") => "MahasiswaList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl(string $parm = ""): string
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl(): string
    {
        return "mahasiswalist";
    }

    // View URL
    public function getViewUrl(string $parm = ""): string
    {
        if ($parm != "") {
            $url = $this->keyUrl("mahasiswaview", $parm);
        } else {
            $url = $this->keyUrl("mahasiswaview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl(string $parm = ""): string
    {
        if ($parm != "") {
            $url = "mahasiswaadd?" . $parm;
        } else {
            $url = "mahasiswaadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl(string $parm = ""): string
    {
        $url = $this->keyUrl("mahasiswaedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl(): string
    {
        $url = $this->keyUrl("mahasiswalist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl(string $parm = ""): string
    {
        $url = $this->keyUrl("mahasiswaadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl(): string
    {
        $url = $this->keyUrl("mahasiswalist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl(string $parm = ""): string
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("mahasiswadelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl(string $url): string
    {
        return $url;
    }

    public function keyToJson(bool $htmlEncode = false): string
    {
        $json = "";
        $json .= "\"NIM\":" . VarToJson($this->NIM->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl(string $url, string $parm = ""): string
    {
        if ($this->NIM->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->NIM->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader(DbField $fld): string
    {
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $this->security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $this->language->phrase("Filter") .
                (is_array($fld->EditValue) ? sprintf($this->language->phrase("FilterCount"), count($fld->EditValue)) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl(DbField $fld): string
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport()
        || 
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys(): array
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("NIM") ?? Route("NIM")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords(array $rows): string
    {
        return implode(" OR ", array_map(fn($row) => "(" . $this->getRecordFilter($row) . ")", $rows));
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys(bool $setCurrent = true): string
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($setCurrent) {
                $this->NIM->CurrentValue = $key;
            } else {
                $this->NIM->OldValue = $key;
            }
            AddFilter($keyFilter, $this->getRecordFilter(null, $setCurrent), "OR");
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRecords(string $filter, string $sort = ""): Result
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(array &$row)
    {
        $this->NIM->setDbValue($row['NIM']);
        $this->Nama->setDbValue($row['Nama']);
        $this->Jenis_Kelamin->setDbValue($row['Jenis_Kelamin']);
        $this->Provinsi_Tempat_Lahir->setDbValue($row['Provinsi_Tempat_Lahir']);
        $this->Kota_Tempat_Lahir->setDbValue($row['Kota_Tempat_Lahir']);
        $this->Tanggal_Lahir->setDbValue($row['Tanggal_Lahir']);
        $this->Golongan_Darah->setDbValue($row['Golongan_Darah']);
        $this->Tinggi_Badan->setDbValue($row['Tinggi_Badan']);
        $this->Berat_Badan->setDbValue($row['Berat_Badan']);
        $this->Asal_sekolah->setDbValue($row['Asal_sekolah']);
        $this->Tahun_Ijazah->setDbValue($row['Tahun_Ijazah']);
        $this->Nomor_Ijazah->setDbValue($row['Nomor_Ijazah']);
        $this->Nilai_Raport_Kelas_10->setDbValue($row['Nilai_Raport_Kelas_10']);
        $this->Nilai_Raport_Kelas_11->setDbValue($row['Nilai_Raport_Kelas_11']);
        $this->Nilai_Raport_Kelas_12->setDbValue($row['Nilai_Raport_Kelas_12']);
        $this->Tanggal_Daftar->setDbValue($row['Tanggal_Daftar']);
        $this->No_Test->setDbValue($row['No_Test']);
        $this->Status_Masuk->setDbValue($row['Status_Masuk']);
        $this->Jalur_Masuk->setDbValue($row['Jalur_Masuk']);
        $this->Bukti_Lulus->setDbValue($row['Bukti_Lulus']);
        $this->Tes_Potensi_Akademik->setDbValue($row['Tes_Potensi_Akademik']);
        $this->Tes_Wawancara->setDbValue($row['Tes_Wawancara']);
        $this->Tes_Kesehatan->setDbValue($row['Tes_Kesehatan']);
        $this->Hasil_Test_Kesehatan->setDbValue($row['Hasil_Test_Kesehatan']);
        $this->Test_MMPI->setDbValue($row['Test_MMPI']);
        $this->Hasil_Test_MMPI->setDbValue($row['Hasil_Test_MMPI']);
        $this->Angkatan->setDbValue($row['Angkatan']);
        $this->Tarif_SPP->setDbValue($row['Tarif_SPP']);
        $this->NIK_No_KTP->setDbValue($row['NIK_No_KTP']);
        $this->No_KK->setDbValue($row['No_KK']);
        $this->NPWP->setDbValue($row['NPWP']);
        $this->Status_Nikah->setDbValue($row['Status_Nikah']);
        $this->Kewarganegaraan->setDbValue($row['Kewarganegaraan']);
        $this->Propinsi_Tempat_Tinggal->setDbValue($row['Propinsi_Tempat_Tinggal']);
        $this->Kota_Tempat_Tinggal->setDbValue($row['Kota_Tempat_Tinggal']);
        $this->Kecamatan_Tempat_Tinggal->setDbValue($row['Kecamatan_Tempat_Tinggal']);
        $this->Alamat_Tempat_Tinggal->setDbValue($row['Alamat_Tempat_Tinggal']);
        $this->RT->setDbValue($row['RT']);
        $this->RW->setDbValue($row['RW']);
        $this->Kelurahan->setDbValue($row['Kelurahan']);
        $this->Kode_Pos->setDbValue($row['Kode_Pos']);
        $this->Nomor_Telpon_HP->setDbValue($row['Nomor_Telpon_HP']);
        $this->_Email->setDbValue($row['Email']);
        $this->Jenis_Tinggal->setDbValue($row['Jenis_Tinggal']);
        $this->Alat_Transportasi->setDbValue($row['Alat_Transportasi']);
        $this->Sumber_Dana->setDbValue($row['Sumber_Dana']);
        $this->Sumber_Dana_Beasiswa->setDbValue($row['Sumber_Dana_Beasiswa']);
        $this->Jumlah_Sudara->setDbValue($row['Jumlah_Sudara']);
        $this->Status_Bekerja->setDbValue($row['Status_Bekerja']);
        $this->Nomor_Asuransi->setDbValue($row['Nomor_Asuransi']);
        $this->Hobi->setDbValue($row['Hobi']);
        $this->Foto->setDbValue($row['Foto']);
        $this->Nama_Ayah->setDbValue($row['Nama_Ayah']);
        $this->Pekerjaan_Ayah->setDbValue($row['Pekerjaan_Ayah']);
        $this->Nama_Ibu->setDbValue($row['Nama_Ibu']);
        $this->Pekerjaan_Ibu->setDbValue($row['Pekerjaan_Ibu']);
        $this->Alamat_Orang_Tua->setDbValue($row['Alamat_Orang_Tua']);
        $this->e_mail_Oranng_Tua->setDbValue($row['e_mail_Oranng_Tua']);
        $this->No_Kontak_Orang_Tua->setDbValue($row['No_Kontak_Orang_Tua']);
        $this->userid->setDbValue($row['userid']);
        $this->user->setDbValue($row['user']);
        $this->ip->setDbValue($row['ip']);
        $this->tanggal_input->setDbValue($row['tanggal_input']);
    }

    // Render list content
    public function renderListContent(string $filter)
    {
        global $Response;
        $container = Container();
        $listPage = "MahasiswaList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = $container->make($listClass);
        $page->loadRecordsetFromFilter($filter);
        $view = $container->get("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $CurrentLanguage;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // NIM

        // Nama

        // Jenis_Kelamin

        // Provinsi_Tempat_Lahir

        // Kota_Tempat_Lahir

        // Tanggal_Lahir

        // Golongan_Darah

        // Tinggi_Badan

        // Berat_Badan

        // Asal_sekolah

        // Tahun_Ijazah

        // Nomor_Ijazah

        // Nilai_Raport_Kelas_10

        // Nilai_Raport_Kelas_11

        // Nilai_Raport_Kelas_12

        // Tanggal_Daftar

        // No_Test

        // Status_Masuk

        // Jalur_Masuk

        // Bukti_Lulus

        // Tes_Potensi_Akademik

        // Tes_Wawancara

        // Tes_Kesehatan

        // Hasil_Test_Kesehatan

        // Test_MMPI

        // Hasil_Test_MMPI

        // Angkatan

        // Tarif_SPP

        // NIK_No_KTP

        // No_KK

        // NPWP

        // Status_Nikah

        // Kewarganegaraan

        // Propinsi_Tempat_Tinggal

        // Kota_Tempat_Tinggal

        // Kecamatan_Tempat_Tinggal

        // Alamat_Tempat_Tinggal

        // RT

        // RW

        // Kelurahan

        // Kode_Pos

        // Nomor_Telpon_HP

        // Email

        // Jenis_Tinggal

        // Alat_Transportasi

        // Sumber_Dana

        // Sumber_Dana_Beasiswa

        // Jumlah_Sudara

        // Status_Bekerja

        // Nomor_Asuransi

        // Hobi

        // Foto

        // Nama_Ayah

        // Pekerjaan_Ayah

        // Nama_Ibu

        // Pekerjaan_Ibu

        // Alamat_Orang_Tua

        // e_mail_Oranng_Tua

        // No_Kontak_Orang_Tua

        // userid

        // user

        // ip

        // tanggal_input

        // NIM
        $this->NIM->ViewValue = $this->NIM->CurrentValue;

        // Nama
        $this->Nama->ViewValue = $this->Nama->CurrentValue;

        // Jenis_Kelamin
        $this->Jenis_Kelamin->ViewValue = $this->Jenis_Kelamin->CurrentValue;

        // Provinsi_Tempat_Lahir
        $this->Provinsi_Tempat_Lahir->ViewValue = $this->Provinsi_Tempat_Lahir->CurrentValue;

        // Kota_Tempat_Lahir
        $this->Kota_Tempat_Lahir->ViewValue = $this->Kota_Tempat_Lahir->CurrentValue;

        // Tanggal_Lahir
        $this->Tanggal_Lahir->ViewValue = $this->Tanggal_Lahir->CurrentValue;
        $this->Tanggal_Lahir->ViewValue = FormatDateTime($this->Tanggal_Lahir->ViewValue, $this->Tanggal_Lahir->formatPattern());

        // Golongan_Darah
        $this->Golongan_Darah->ViewValue = $this->Golongan_Darah->CurrentValue;

        // Tinggi_Badan
        $this->Tinggi_Badan->ViewValue = $this->Tinggi_Badan->CurrentValue;

        // Berat_Badan
        $this->Berat_Badan->ViewValue = $this->Berat_Badan->CurrentValue;

        // Asal_sekolah
        $this->Asal_sekolah->ViewValue = $this->Asal_sekolah->CurrentValue;

        // Tahun_Ijazah
        $this->Tahun_Ijazah->ViewValue = $this->Tahun_Ijazah->CurrentValue;

        // Nomor_Ijazah
        $this->Nomor_Ijazah->ViewValue = $this->Nomor_Ijazah->CurrentValue;

        // Nilai_Raport_Kelas_10
        $this->Nilai_Raport_Kelas_10->ViewValue = $this->Nilai_Raport_Kelas_10->CurrentValue;
        $this->Nilai_Raport_Kelas_10->ViewValue = FormatNumber($this->Nilai_Raport_Kelas_10->ViewValue, $this->Nilai_Raport_Kelas_10->formatPattern());

        // Nilai_Raport_Kelas_11
        $this->Nilai_Raport_Kelas_11->ViewValue = $this->Nilai_Raport_Kelas_11->CurrentValue;
        $this->Nilai_Raport_Kelas_11->ViewValue = FormatNumber($this->Nilai_Raport_Kelas_11->ViewValue, $this->Nilai_Raport_Kelas_11->formatPattern());

        // Nilai_Raport_Kelas_12
        $this->Nilai_Raport_Kelas_12->ViewValue = $this->Nilai_Raport_Kelas_12->CurrentValue;
        $this->Nilai_Raport_Kelas_12->ViewValue = FormatNumber($this->Nilai_Raport_Kelas_12->ViewValue, $this->Nilai_Raport_Kelas_12->formatPattern());

        // Tanggal_Daftar
        $this->Tanggal_Daftar->ViewValue = $this->Tanggal_Daftar->CurrentValue;
        $this->Tanggal_Daftar->ViewValue = FormatDateTime($this->Tanggal_Daftar->ViewValue, $this->Tanggal_Daftar->formatPattern());

        // No_Test
        $this->No_Test->ViewValue = $this->No_Test->CurrentValue;

        // Status_Masuk
        $this->Status_Masuk->ViewValue = $this->Status_Masuk->CurrentValue;

        // Jalur_Masuk
        $this->Jalur_Masuk->ViewValue = $this->Jalur_Masuk->CurrentValue;

        // Bukti_Lulus
        $this->Bukti_Lulus->ViewValue = $this->Bukti_Lulus->CurrentValue;

        // Tes_Potensi_Akademik
        $this->Tes_Potensi_Akademik->ViewValue = $this->Tes_Potensi_Akademik->CurrentValue;
        $this->Tes_Potensi_Akademik->ViewValue = FormatNumber($this->Tes_Potensi_Akademik->ViewValue, $this->Tes_Potensi_Akademik->formatPattern());

        // Tes_Wawancara
        $this->Tes_Wawancara->ViewValue = $this->Tes_Wawancara->CurrentValue;
        $this->Tes_Wawancara->ViewValue = FormatNumber($this->Tes_Wawancara->ViewValue, $this->Tes_Wawancara->formatPattern());

        // Tes_Kesehatan
        $this->Tes_Kesehatan->ViewValue = $this->Tes_Kesehatan->CurrentValue;
        $this->Tes_Kesehatan->ViewValue = FormatNumber($this->Tes_Kesehatan->ViewValue, $this->Tes_Kesehatan->formatPattern());

        // Hasil_Test_Kesehatan
        $this->Hasil_Test_Kesehatan->ViewValue = $this->Hasil_Test_Kesehatan->CurrentValue;

        // Test_MMPI
        $this->Test_MMPI->ViewValue = $this->Test_MMPI->CurrentValue;
        $this->Test_MMPI->ViewValue = FormatNumber($this->Test_MMPI->ViewValue, $this->Test_MMPI->formatPattern());

        // Hasil_Test_MMPI
        $this->Hasil_Test_MMPI->ViewValue = $this->Hasil_Test_MMPI->CurrentValue;

        // Angkatan
        $this->Angkatan->ViewValue = $this->Angkatan->CurrentValue;

        // Tarif_SPP
        $this->Tarif_SPP->ViewValue = $this->Tarif_SPP->CurrentValue;
        $this->Tarif_SPP->ViewValue = FormatNumber($this->Tarif_SPP->ViewValue, $this->Tarif_SPP->formatPattern());

        // NIK_No_KTP
        $this->NIK_No_KTP->ViewValue = $this->NIK_No_KTP->CurrentValue;

        // No_KK
        $this->No_KK->ViewValue = $this->No_KK->CurrentValue;

        // NPWP
        $this->NPWP->ViewValue = $this->NPWP->CurrentValue;

        // Status_Nikah
        $this->Status_Nikah->ViewValue = $this->Status_Nikah->CurrentValue;

        // Kewarganegaraan
        $this->Kewarganegaraan->ViewValue = $this->Kewarganegaraan->CurrentValue;

        // Propinsi_Tempat_Tinggal
        $this->Propinsi_Tempat_Tinggal->ViewValue = $this->Propinsi_Tempat_Tinggal->CurrentValue;

        // Kota_Tempat_Tinggal
        $this->Kota_Tempat_Tinggal->ViewValue = $this->Kota_Tempat_Tinggal->CurrentValue;

        // Kecamatan_Tempat_Tinggal
        $this->Kecamatan_Tempat_Tinggal->ViewValue = $this->Kecamatan_Tempat_Tinggal->CurrentValue;

        // Alamat_Tempat_Tinggal
        $this->Alamat_Tempat_Tinggal->ViewValue = $this->Alamat_Tempat_Tinggal->CurrentValue;

        // RT
        $this->RT->ViewValue = $this->RT->CurrentValue;

        // RW
        $this->RW->ViewValue = $this->RW->CurrentValue;

        // Kelurahan
        $this->Kelurahan->ViewValue = $this->Kelurahan->CurrentValue;

        // Kode_Pos
        $this->Kode_Pos->ViewValue = $this->Kode_Pos->CurrentValue;

        // Nomor_Telpon_HP
        $this->Nomor_Telpon_HP->ViewValue = $this->Nomor_Telpon_HP->CurrentValue;

        // Email
        $this->_Email->ViewValue = $this->_Email->CurrentValue;

        // Jenis_Tinggal
        $this->Jenis_Tinggal->ViewValue = $this->Jenis_Tinggal->CurrentValue;

        // Alat_Transportasi
        $this->Alat_Transportasi->ViewValue = $this->Alat_Transportasi->CurrentValue;

        // Sumber_Dana
        $this->Sumber_Dana->ViewValue = $this->Sumber_Dana->CurrentValue;

        // Sumber_Dana_Beasiswa
        $this->Sumber_Dana_Beasiswa->ViewValue = $this->Sumber_Dana_Beasiswa->CurrentValue;

        // Jumlah_Sudara
        $this->Jumlah_Sudara->ViewValue = $this->Jumlah_Sudara->CurrentValue;

        // Status_Bekerja
        $this->Status_Bekerja->ViewValue = $this->Status_Bekerja->CurrentValue;

        // Nomor_Asuransi
        $this->Nomor_Asuransi->ViewValue = $this->Nomor_Asuransi->CurrentValue;

        // Hobi
        $this->Hobi->ViewValue = $this->Hobi->CurrentValue;

        // Foto
        $this->Foto->ViewValue = $this->Foto->CurrentValue;

        // Nama_Ayah
        $this->Nama_Ayah->ViewValue = $this->Nama_Ayah->CurrentValue;

        // Pekerjaan_Ayah
        $this->Pekerjaan_Ayah->ViewValue = $this->Pekerjaan_Ayah->CurrentValue;

        // Nama_Ibu
        $this->Nama_Ibu->ViewValue = $this->Nama_Ibu->CurrentValue;

        // Pekerjaan_Ibu
        $this->Pekerjaan_Ibu->ViewValue = $this->Pekerjaan_Ibu->CurrentValue;

        // Alamat_Orang_Tua
        $this->Alamat_Orang_Tua->ViewValue = $this->Alamat_Orang_Tua->CurrentValue;

        // e_mail_Oranng_Tua
        $this->e_mail_Oranng_Tua->ViewValue = $this->e_mail_Oranng_Tua->CurrentValue;

        // No_Kontak_Orang_Tua
        $this->No_Kontak_Orang_Tua->ViewValue = $this->No_Kontak_Orang_Tua->CurrentValue;

        // userid
        $this->userid->ViewValue = $this->userid->CurrentValue;

        // user
        $this->user->ViewValue = $this->user->CurrentValue;

        // ip
        $this->ip->ViewValue = $this->ip->CurrentValue;

        // tanggal_input
        $this->tanggal_input->ViewValue = $this->tanggal_input->CurrentValue;
        $this->tanggal_input->ViewValue = FormatDateTime($this->tanggal_input->ViewValue, $this->tanggal_input->formatPattern());

        // NIM
        $this->NIM->HrefValue = "";
        $this->NIM->TooltipValue = "";

        // Nama
        $this->Nama->HrefValue = "";
        $this->Nama->TooltipValue = "";

        // Jenis_Kelamin
        $this->Jenis_Kelamin->HrefValue = "";
        $this->Jenis_Kelamin->TooltipValue = "";

        // Provinsi_Tempat_Lahir
        $this->Provinsi_Tempat_Lahir->HrefValue = "";
        $this->Provinsi_Tempat_Lahir->TooltipValue = "";

        // Kota_Tempat_Lahir
        $this->Kota_Tempat_Lahir->HrefValue = "";
        $this->Kota_Tempat_Lahir->TooltipValue = "";

        // Tanggal_Lahir
        $this->Tanggal_Lahir->HrefValue = "";
        $this->Tanggal_Lahir->TooltipValue = "";

        // Golongan_Darah
        $this->Golongan_Darah->HrefValue = "";
        $this->Golongan_Darah->TooltipValue = "";

        // Tinggi_Badan
        $this->Tinggi_Badan->HrefValue = "";
        $this->Tinggi_Badan->TooltipValue = "";

        // Berat_Badan
        $this->Berat_Badan->HrefValue = "";
        $this->Berat_Badan->TooltipValue = "";

        // Asal_sekolah
        $this->Asal_sekolah->HrefValue = "";
        $this->Asal_sekolah->TooltipValue = "";

        // Tahun_Ijazah
        $this->Tahun_Ijazah->HrefValue = "";
        $this->Tahun_Ijazah->TooltipValue = "";

        // Nomor_Ijazah
        $this->Nomor_Ijazah->HrefValue = "";
        $this->Nomor_Ijazah->TooltipValue = "";

        // Nilai_Raport_Kelas_10
        $this->Nilai_Raport_Kelas_10->HrefValue = "";
        $this->Nilai_Raport_Kelas_10->TooltipValue = "";

        // Nilai_Raport_Kelas_11
        $this->Nilai_Raport_Kelas_11->HrefValue = "";
        $this->Nilai_Raport_Kelas_11->TooltipValue = "";

        // Nilai_Raport_Kelas_12
        $this->Nilai_Raport_Kelas_12->HrefValue = "";
        $this->Nilai_Raport_Kelas_12->TooltipValue = "";

        // Tanggal_Daftar
        $this->Tanggal_Daftar->HrefValue = "";
        $this->Tanggal_Daftar->TooltipValue = "";

        // No_Test
        $this->No_Test->HrefValue = "";
        $this->No_Test->TooltipValue = "";

        // Status_Masuk
        $this->Status_Masuk->HrefValue = "";
        $this->Status_Masuk->TooltipValue = "";

        // Jalur_Masuk
        $this->Jalur_Masuk->HrefValue = "";
        $this->Jalur_Masuk->TooltipValue = "";

        // Bukti_Lulus
        $this->Bukti_Lulus->HrefValue = "";
        $this->Bukti_Lulus->TooltipValue = "";

        // Tes_Potensi_Akademik
        $this->Tes_Potensi_Akademik->HrefValue = "";
        $this->Tes_Potensi_Akademik->TooltipValue = "";

        // Tes_Wawancara
        $this->Tes_Wawancara->HrefValue = "";
        $this->Tes_Wawancara->TooltipValue = "";

        // Tes_Kesehatan
        $this->Tes_Kesehatan->HrefValue = "";
        $this->Tes_Kesehatan->TooltipValue = "";

        // Hasil_Test_Kesehatan
        $this->Hasil_Test_Kesehatan->HrefValue = "";
        $this->Hasil_Test_Kesehatan->TooltipValue = "";

        // Test_MMPI
        $this->Test_MMPI->HrefValue = "";
        $this->Test_MMPI->TooltipValue = "";

        // Hasil_Test_MMPI
        $this->Hasil_Test_MMPI->HrefValue = "";
        $this->Hasil_Test_MMPI->TooltipValue = "";

        // Angkatan
        $this->Angkatan->HrefValue = "";
        $this->Angkatan->TooltipValue = "";

        // Tarif_SPP
        $this->Tarif_SPP->HrefValue = "";
        $this->Tarif_SPP->TooltipValue = "";

        // NIK_No_KTP
        $this->NIK_No_KTP->HrefValue = "";
        $this->NIK_No_KTP->TooltipValue = "";

        // No_KK
        $this->No_KK->HrefValue = "";
        $this->No_KK->TooltipValue = "";

        // NPWP
        $this->NPWP->HrefValue = "";
        $this->NPWP->TooltipValue = "";

        // Status_Nikah
        $this->Status_Nikah->HrefValue = "";
        $this->Status_Nikah->TooltipValue = "";

        // Kewarganegaraan
        $this->Kewarganegaraan->HrefValue = "";
        $this->Kewarganegaraan->TooltipValue = "";

        // Propinsi_Tempat_Tinggal
        $this->Propinsi_Tempat_Tinggal->HrefValue = "";
        $this->Propinsi_Tempat_Tinggal->TooltipValue = "";

        // Kota_Tempat_Tinggal
        $this->Kota_Tempat_Tinggal->HrefValue = "";
        $this->Kota_Tempat_Tinggal->TooltipValue = "";

        // Kecamatan_Tempat_Tinggal
        $this->Kecamatan_Tempat_Tinggal->HrefValue = "";
        $this->Kecamatan_Tempat_Tinggal->TooltipValue = "";

        // Alamat_Tempat_Tinggal
        $this->Alamat_Tempat_Tinggal->HrefValue = "";
        $this->Alamat_Tempat_Tinggal->TooltipValue = "";

        // RT
        $this->RT->HrefValue = "";
        $this->RT->TooltipValue = "";

        // RW
        $this->RW->HrefValue = "";
        $this->RW->TooltipValue = "";

        // Kelurahan
        $this->Kelurahan->HrefValue = "";
        $this->Kelurahan->TooltipValue = "";

        // Kode_Pos
        $this->Kode_Pos->HrefValue = "";
        $this->Kode_Pos->TooltipValue = "";

        // Nomor_Telpon_HP
        $this->Nomor_Telpon_HP->HrefValue = "";
        $this->Nomor_Telpon_HP->TooltipValue = "";

        // Email
        $this->_Email->HrefValue = "";
        $this->_Email->TooltipValue = "";

        // Jenis_Tinggal
        $this->Jenis_Tinggal->HrefValue = "";
        $this->Jenis_Tinggal->TooltipValue = "";

        // Alat_Transportasi
        $this->Alat_Transportasi->HrefValue = "";
        $this->Alat_Transportasi->TooltipValue = "";

        // Sumber_Dana
        $this->Sumber_Dana->HrefValue = "";
        $this->Sumber_Dana->TooltipValue = "";

        // Sumber_Dana_Beasiswa
        $this->Sumber_Dana_Beasiswa->HrefValue = "";
        $this->Sumber_Dana_Beasiswa->TooltipValue = "";

        // Jumlah_Sudara
        $this->Jumlah_Sudara->HrefValue = "";
        $this->Jumlah_Sudara->TooltipValue = "";

        // Status_Bekerja
        $this->Status_Bekerja->HrefValue = "";
        $this->Status_Bekerja->TooltipValue = "";

        // Nomor_Asuransi
        $this->Nomor_Asuransi->HrefValue = "";
        $this->Nomor_Asuransi->TooltipValue = "";

        // Hobi
        $this->Hobi->HrefValue = "";
        $this->Hobi->TooltipValue = "";

        // Foto
        $this->Foto->HrefValue = "";
        $this->Foto->TooltipValue = "";

        // Nama_Ayah
        $this->Nama_Ayah->HrefValue = "";
        $this->Nama_Ayah->TooltipValue = "";

        // Pekerjaan_Ayah
        $this->Pekerjaan_Ayah->HrefValue = "";
        $this->Pekerjaan_Ayah->TooltipValue = "";

        // Nama_Ibu
        $this->Nama_Ibu->HrefValue = "";
        $this->Nama_Ibu->TooltipValue = "";

        // Pekerjaan_Ibu
        $this->Pekerjaan_Ibu->HrefValue = "";
        $this->Pekerjaan_Ibu->TooltipValue = "";

        // Alamat_Orang_Tua
        $this->Alamat_Orang_Tua->HrefValue = "";
        $this->Alamat_Orang_Tua->TooltipValue = "";

        // e_mail_Oranng_Tua
        $this->e_mail_Oranng_Tua->HrefValue = "";
        $this->e_mail_Oranng_Tua->TooltipValue = "";

        // No_Kontak_Orang_Tua
        $this->No_Kontak_Orang_Tua->HrefValue = "";
        $this->No_Kontak_Orang_Tua->TooltipValue = "";

        // userid
        $this->userid->HrefValue = "";
        $this->userid->TooltipValue = "";

        // user
        $this->user->HrefValue = "";
        $this->user->TooltipValue = "";

        // ip
        $this->ip->HrefValue = "";
        $this->ip->TooltipValue = "";

        // tanggal_input
        $this->tanggal_input->HrefValue = "";
        $this->tanggal_input->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
	// Now including Export Print (printer friendly), modification by Masino Sinaga, September 11, 2023 
    public function exportDocument(AbstractExportBase $doc, Result $result, int $startRec = 1, int $stopRec = 1, string $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->NIM);
                    $doc->exportCaption($this->Nama);
                    $doc->exportCaption($this->Jenis_Kelamin);
                    $doc->exportCaption($this->Provinsi_Tempat_Lahir);
                    $doc->exportCaption($this->Kota_Tempat_Lahir);
                    $doc->exportCaption($this->Tanggal_Lahir);
                    $doc->exportCaption($this->Golongan_Darah);
                    $doc->exportCaption($this->Tinggi_Badan);
                    $doc->exportCaption($this->Berat_Badan);
                    $doc->exportCaption($this->Asal_sekolah);
                    $doc->exportCaption($this->Tahun_Ijazah);
                    $doc->exportCaption($this->Nomor_Ijazah);
                    $doc->exportCaption($this->Nilai_Raport_Kelas_10);
                    $doc->exportCaption($this->Nilai_Raport_Kelas_11);
                    $doc->exportCaption($this->Nilai_Raport_Kelas_12);
                    $doc->exportCaption($this->Tanggal_Daftar);
                    $doc->exportCaption($this->No_Test);
                    $doc->exportCaption($this->Status_Masuk);
                    $doc->exportCaption($this->Jalur_Masuk);
                    $doc->exportCaption($this->Bukti_Lulus);
                    $doc->exportCaption($this->Tes_Potensi_Akademik);
                    $doc->exportCaption($this->Tes_Wawancara);
                    $doc->exportCaption($this->Tes_Kesehatan);
                    $doc->exportCaption($this->Hasil_Test_Kesehatan);
                    $doc->exportCaption($this->Test_MMPI);
                    $doc->exportCaption($this->Hasil_Test_MMPI);
                    $doc->exportCaption($this->Angkatan);
                    $doc->exportCaption($this->Tarif_SPP);
                    $doc->exportCaption($this->NIK_No_KTP);
                    $doc->exportCaption($this->No_KK);
                    $doc->exportCaption($this->NPWP);
                    $doc->exportCaption($this->Status_Nikah);
                    $doc->exportCaption($this->Kewarganegaraan);
                    $doc->exportCaption($this->Propinsi_Tempat_Tinggal);
                    $doc->exportCaption($this->Kota_Tempat_Tinggal);
                    $doc->exportCaption($this->Kecamatan_Tempat_Tinggal);
                    $doc->exportCaption($this->Alamat_Tempat_Tinggal);
                    $doc->exportCaption($this->RT);
                    $doc->exportCaption($this->RW);
                    $doc->exportCaption($this->Kelurahan);
                    $doc->exportCaption($this->Kode_Pos);
                    $doc->exportCaption($this->Nomor_Telpon_HP);
                    $doc->exportCaption($this->_Email);
                    $doc->exportCaption($this->Jenis_Tinggal);
                    $doc->exportCaption($this->Alat_Transportasi);
                    $doc->exportCaption($this->Sumber_Dana);
                    $doc->exportCaption($this->Sumber_Dana_Beasiswa);
                    $doc->exportCaption($this->Jumlah_Sudara);
                    $doc->exportCaption($this->Status_Bekerja);
                    $doc->exportCaption($this->Nomor_Asuransi);
                    $doc->exportCaption($this->Hobi);
                    $doc->exportCaption($this->Foto);
                    $doc->exportCaption($this->Nama_Ayah);
                    $doc->exportCaption($this->Pekerjaan_Ayah);
                    $doc->exportCaption($this->Nama_Ibu);
                    $doc->exportCaption($this->Pekerjaan_Ibu);
                    $doc->exportCaption($this->Alamat_Orang_Tua);
                    $doc->exportCaption($this->e_mail_Oranng_Tua);
                    $doc->exportCaption($this->No_Kontak_Orang_Tua);
                    $doc->exportCaption($this->userid);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->ip);
                    $doc->exportCaption($this->tanggal_input);
                } else {
                    $doc->exportCaption($this->NIM);
                    $doc->exportCaption($this->Nama);
                    $doc->exportCaption($this->Jenis_Kelamin);
                    $doc->exportCaption($this->Provinsi_Tempat_Lahir);
                    $doc->exportCaption($this->Kota_Tempat_Lahir);
                    $doc->exportCaption($this->Tanggal_Lahir);
                    $doc->exportCaption($this->Golongan_Darah);
                    $doc->exportCaption($this->Tinggi_Badan);
                    $doc->exportCaption($this->Berat_Badan);
                    $doc->exportCaption($this->Asal_sekolah);
                    $doc->exportCaption($this->Tahun_Ijazah);
                    $doc->exportCaption($this->Nomor_Ijazah);
                    $doc->exportCaption($this->Nilai_Raport_Kelas_10);
                    $doc->exportCaption($this->Nilai_Raport_Kelas_11);
                    $doc->exportCaption($this->Nilai_Raport_Kelas_12);
                    $doc->exportCaption($this->Tanggal_Daftar);
                    $doc->exportCaption($this->No_Test);
                    $doc->exportCaption($this->Status_Masuk);
                    $doc->exportCaption($this->Jalur_Masuk);
                    $doc->exportCaption($this->Bukti_Lulus);
                    $doc->exportCaption($this->Tes_Potensi_Akademik);
                    $doc->exportCaption($this->Tes_Wawancara);
                    $doc->exportCaption($this->Tes_Kesehatan);
                    $doc->exportCaption($this->Hasil_Test_Kesehatan);
                    $doc->exportCaption($this->Test_MMPI);
                    $doc->exportCaption($this->Hasil_Test_MMPI);
                    $doc->exportCaption($this->Angkatan);
                    $doc->exportCaption($this->Tarif_SPP);
                    $doc->exportCaption($this->NIK_No_KTP);
                    $doc->exportCaption($this->No_KK);
                    $doc->exportCaption($this->NPWP);
                    $doc->exportCaption($this->Status_Nikah);
                    $doc->exportCaption($this->Kewarganegaraan);
                    $doc->exportCaption($this->Propinsi_Tempat_Tinggal);
                    $doc->exportCaption($this->Kota_Tempat_Tinggal);
                    $doc->exportCaption($this->Kecamatan_Tempat_Tinggal);
                    $doc->exportCaption($this->Alamat_Tempat_Tinggal);
                    $doc->exportCaption($this->RT);
                    $doc->exportCaption($this->RW);
                    $doc->exportCaption($this->Kelurahan);
                    $doc->exportCaption($this->Kode_Pos);
                    $doc->exportCaption($this->Nomor_Telpon_HP);
                    $doc->exportCaption($this->_Email);
                    $doc->exportCaption($this->Jenis_Tinggal);
                    $doc->exportCaption($this->Alat_Transportasi);
                    $doc->exportCaption($this->Sumber_Dana);
                    $doc->exportCaption($this->Sumber_Dana_Beasiswa);
                    $doc->exportCaption($this->Jumlah_Sudara);
                    $doc->exportCaption($this->Status_Bekerja);
                    $doc->exportCaption($this->Nomor_Asuransi);
                    $doc->exportCaption($this->Hobi);
                    $doc->exportCaption($this->Foto);
                    $doc->exportCaption($this->Nama_Ayah);
                    $doc->exportCaption($this->Pekerjaan_Ayah);
                    $doc->exportCaption($this->Nama_Ibu);
                    $doc->exportCaption($this->Pekerjaan_Ibu);
                    $doc->exportCaption($this->Alamat_Orang_Tua);
                    $doc->exportCaption($this->e_mail_Oranng_Tua);
                    $doc->exportCaption($this->No_Kontak_Orang_Tua);
                    $doc->exportCaption($this->userid);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->ip);
                    $doc->exportCaption($this->tanggal_input);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
		// Begin of modification Record Number in Exported Data by Masino Sinaga, September 11, 2023
		$seqRec = 0;
		if (CurrentPageID() == "view") { // Modified by Masino Sinaga, September 11, 2023, reset seq. number in View Page
		    $_SESSION["First_Record"] = 0;
			$seqRec = (empty($_SESSION["First_Record"])) ? 0 : $_SESSION["First_Record"] - 1; 
		} else {
			$seqRec = (empty($_SESSION["First_Record"])) ? $recCnt : $_SESSION["First_Record"] - 1;
		}
		// End of modification Record Number in Exported Data by Masino Sinaga, September 11, 2023
        while (($row = $result->fetchAssociative()) && $recCnt < $stopRec) {
            $recCnt++;
			$seqRec++; // Record Number in Exported Data by Masino Sinaga, September 11, 2023
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
				// Begin of modification PageBreak for Export to PDF dan Export to Word by Masino Sinaga, September 11, 2023
                if ($this->ExportPageBreakCount > 0 && ($this->Export == "pdf" || $this->Export =="word")) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
						$doc->beginExportRow(); // Begin of modification by Masino Sinaga, September 11, 2023, table header will be repeated at the top of each page after page break, must be handled from here for Export to PDF that has the possibility to repeat the table header column in each top of page
						$doc->exportCaption($this->NIM);
						$doc->exportCaption($this->Nama);
						$doc->exportCaption($this->Jenis_Kelamin);
						$doc->exportCaption($this->Provinsi_Tempat_Lahir);
						$doc->exportCaption($this->Kota_Tempat_Lahir);
						$doc->exportCaption($this->Tanggal_Lahir);
						$doc->exportCaption($this->Golongan_Darah);
						$doc->exportCaption($this->Tinggi_Badan);
						$doc->exportCaption($this->Berat_Badan);
						$doc->exportCaption($this->Asal_sekolah);
						$doc->exportCaption($this->Tahun_Ijazah);
						$doc->exportCaption($this->Nomor_Ijazah);
						$doc->exportCaption($this->Nilai_Raport_Kelas_10);
						$doc->exportCaption($this->Nilai_Raport_Kelas_11);
						$doc->exportCaption($this->Nilai_Raport_Kelas_12);
						$doc->exportCaption($this->Tanggal_Daftar);
						$doc->exportCaption($this->No_Test);
						$doc->exportCaption($this->Status_Masuk);
						$doc->exportCaption($this->Jalur_Masuk);
						$doc->exportCaption($this->Bukti_Lulus);
						$doc->exportCaption($this->Tes_Potensi_Akademik);
						$doc->exportCaption($this->Tes_Wawancara);
						$doc->exportCaption($this->Tes_Kesehatan);
						$doc->exportCaption($this->Hasil_Test_Kesehatan);
						$doc->exportCaption($this->Test_MMPI);
						$doc->exportCaption($this->Hasil_Test_MMPI);
						$doc->exportCaption($this->Angkatan);
						$doc->exportCaption($this->Tarif_SPP);
						$doc->exportCaption($this->NIK_No_KTP);
						$doc->exportCaption($this->No_KK);
						$doc->exportCaption($this->NPWP);
						$doc->exportCaption($this->Status_Nikah);
						$doc->exportCaption($this->Kewarganegaraan);
						$doc->exportCaption($this->Propinsi_Tempat_Tinggal);
						$doc->exportCaption($this->Kota_Tempat_Tinggal);
						$doc->exportCaption($this->Kecamatan_Tempat_Tinggal);
						$doc->exportCaption($this->Alamat_Tempat_Tinggal);
						$doc->exportCaption($this->RT);
						$doc->exportCaption($this->RW);
						$doc->exportCaption($this->Kelurahan);
						$doc->exportCaption($this->Kode_Pos);
						$doc->exportCaption($this->Nomor_Telpon_HP);
						$doc->exportCaption($this->_Email);
						$doc->exportCaption($this->Jenis_Tinggal);
						$doc->exportCaption($this->Alat_Transportasi);
						$doc->exportCaption($this->Sumber_Dana);
						$doc->exportCaption($this->Sumber_Dana_Beasiswa);
						$doc->exportCaption($this->Jumlah_Sudara);
						$doc->exportCaption($this->Status_Bekerja);
						$doc->exportCaption($this->Nomor_Asuransi);
						$doc->exportCaption($this->Hobi);
						$doc->exportCaption($this->Foto);
						$doc->exportCaption($this->Nama_Ayah);
						$doc->exportCaption($this->Pekerjaan_Ayah);
						$doc->exportCaption($this->Nama_Ibu);
						$doc->exportCaption($this->Pekerjaan_Ibu);
						$doc->exportCaption($this->Alamat_Orang_Tua);
						$doc->exportCaption($this->e_mail_Oranng_Tua);
						$doc->exportCaption($this->No_Kontak_Orang_Tua);
						$doc->exportCaption($this->userid);
						$doc->exportCaption($this->user);
						$doc->exportCaption($this->ip);
						$doc->exportCaption($this->tanggal_input);
						$doc->endExportRow(); // End of modification by Masino Sinaga, table header will be repeated at the top of each page after page break, September 11, 2023
                    }
                }
				// End of modification PageBreak for Export to PDF dan Export to Word by Masino Sinaga, September 11, 2023
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->NIM);
                        $doc->exportField($this->Nama);
                        $doc->exportField($this->Jenis_Kelamin);
                        $doc->exportField($this->Provinsi_Tempat_Lahir);
                        $doc->exportField($this->Kota_Tempat_Lahir);
                        $doc->exportField($this->Tanggal_Lahir);
                        $doc->exportField($this->Golongan_Darah);
                        $doc->exportField($this->Tinggi_Badan);
                        $doc->exportField($this->Berat_Badan);
                        $doc->exportField($this->Asal_sekolah);
                        $doc->exportField($this->Tahun_Ijazah);
                        $doc->exportField($this->Nomor_Ijazah);
                        $doc->exportField($this->Nilai_Raport_Kelas_10);
                        $doc->exportField($this->Nilai_Raport_Kelas_11);
                        $doc->exportField($this->Nilai_Raport_Kelas_12);
                        $doc->exportField($this->Tanggal_Daftar);
                        $doc->exportField($this->No_Test);
                        $doc->exportField($this->Status_Masuk);
                        $doc->exportField($this->Jalur_Masuk);
                        $doc->exportField($this->Bukti_Lulus);
                        $doc->exportField($this->Tes_Potensi_Akademik);
                        $doc->exportField($this->Tes_Wawancara);
                        $doc->exportField($this->Tes_Kesehatan);
                        $doc->exportField($this->Hasil_Test_Kesehatan);
                        $doc->exportField($this->Test_MMPI);
                        $doc->exportField($this->Hasil_Test_MMPI);
                        $doc->exportField($this->Angkatan);
                        $doc->exportField($this->Tarif_SPP);
                        $doc->exportField($this->NIK_No_KTP);
                        $doc->exportField($this->No_KK);
                        $doc->exportField($this->NPWP);
                        $doc->exportField($this->Status_Nikah);
                        $doc->exportField($this->Kewarganegaraan);
                        $doc->exportField($this->Propinsi_Tempat_Tinggal);
                        $doc->exportField($this->Kota_Tempat_Tinggal);
                        $doc->exportField($this->Kecamatan_Tempat_Tinggal);
                        $doc->exportField($this->Alamat_Tempat_Tinggal);
                        $doc->exportField($this->RT);
                        $doc->exportField($this->RW);
                        $doc->exportField($this->Kelurahan);
                        $doc->exportField($this->Kode_Pos);
                        $doc->exportField($this->Nomor_Telpon_HP);
                        $doc->exportField($this->_Email);
                        $doc->exportField($this->Jenis_Tinggal);
                        $doc->exportField($this->Alat_Transportasi);
                        $doc->exportField($this->Sumber_Dana);
                        $doc->exportField($this->Sumber_Dana_Beasiswa);
                        $doc->exportField($this->Jumlah_Sudara);
                        $doc->exportField($this->Status_Bekerja);
                        $doc->exportField($this->Nomor_Asuransi);
                        $doc->exportField($this->Hobi);
                        $doc->exportField($this->Foto);
                        $doc->exportField($this->Nama_Ayah);
                        $doc->exportField($this->Pekerjaan_Ayah);
                        $doc->exportField($this->Nama_Ibu);
                        $doc->exportField($this->Pekerjaan_Ibu);
                        $doc->exportField($this->Alamat_Orang_Tua);
                        $doc->exportField($this->e_mail_Oranng_Tua);
                        $doc->exportField($this->No_Kontak_Orang_Tua);
                        $doc->exportField($this->userid);
                        $doc->exportField($this->user);
                        $doc->exportField($this->ip);
                        $doc->exportField($this->tanggal_input);
                    } else {
                        $doc->exportField($this->NIM);
                        $doc->exportField($this->Nama);
                        $doc->exportField($this->Jenis_Kelamin);
                        $doc->exportField($this->Provinsi_Tempat_Lahir);
                        $doc->exportField($this->Kota_Tempat_Lahir);
                        $doc->exportField($this->Tanggal_Lahir);
                        $doc->exportField($this->Golongan_Darah);
                        $doc->exportField($this->Tinggi_Badan);
                        $doc->exportField($this->Berat_Badan);
                        $doc->exportField($this->Asal_sekolah);
                        $doc->exportField($this->Tahun_Ijazah);
                        $doc->exportField($this->Nomor_Ijazah);
                        $doc->exportField($this->Nilai_Raport_Kelas_10);
                        $doc->exportField($this->Nilai_Raport_Kelas_11);
                        $doc->exportField($this->Nilai_Raport_Kelas_12);
                        $doc->exportField($this->Tanggal_Daftar);
                        $doc->exportField($this->No_Test);
                        $doc->exportField($this->Status_Masuk);
                        $doc->exportField($this->Jalur_Masuk);
                        $doc->exportField($this->Bukti_Lulus);
                        $doc->exportField($this->Tes_Potensi_Akademik);
                        $doc->exportField($this->Tes_Wawancara);
                        $doc->exportField($this->Tes_Kesehatan);
                        $doc->exportField($this->Hasil_Test_Kesehatan);
                        $doc->exportField($this->Test_MMPI);
                        $doc->exportField($this->Hasil_Test_MMPI);
                        $doc->exportField($this->Angkatan);
                        $doc->exportField($this->Tarif_SPP);
                        $doc->exportField($this->NIK_No_KTP);
                        $doc->exportField($this->No_KK);
                        $doc->exportField($this->NPWP);
                        $doc->exportField($this->Status_Nikah);
                        $doc->exportField($this->Kewarganegaraan);
                        $doc->exportField($this->Propinsi_Tempat_Tinggal);
                        $doc->exportField($this->Kota_Tempat_Tinggal);
                        $doc->exportField($this->Kecamatan_Tempat_Tinggal);
                        $doc->exportField($this->Alamat_Tempat_Tinggal);
                        $doc->exportField($this->RT);
                        $doc->exportField($this->RW);
                        $doc->exportField($this->Kelurahan);
                        $doc->exportField($this->Kode_Pos);
                        $doc->exportField($this->Nomor_Telpon_HP);
                        $doc->exportField($this->_Email);
                        $doc->exportField($this->Jenis_Tinggal);
                        $doc->exportField($this->Alat_Transportasi);
                        $doc->exportField($this->Sumber_Dana);
                        $doc->exportField($this->Sumber_Dana_Beasiswa);
                        $doc->exportField($this->Jumlah_Sudara);
                        $doc->exportField($this->Status_Bekerja);
                        $doc->exportField($this->Nomor_Asuransi);
                        $doc->exportField($this->Hobi);
                        $doc->exportField($this->Foto);
                        $doc->exportField($this->Nama_Ayah);
                        $doc->exportField($this->Pekerjaan_Ayah);
                        $doc->exportField($this->Nama_Ibu);
                        $doc->exportField($this->Pekerjaan_Ibu);
                        $doc->exportField($this->Alamat_Orang_Tua);
                        $doc->exportField($this->e_mail_Oranng_Tua);
                        $doc->exportField($this->No_Kontak_Orang_Tua);
                        $doc->exportField($this->userid);
                        $doc->exportField($this->user);
                        $doc->exportField($this->ip);
                        $doc->exportField($this->tanggal_input);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Render lookup field for view
    public function renderLookupForView(string $name, mixed $value): mixed
    {
        $this->RowType = RowType::VIEW;
        if ($name == "Nama") {
            $clone = $this->Nama->getClone()->setViewValue($value);
            $clone->ViewValue = $clone->CurrentValue;
            return $clone->getViewValue();
        }
        return $value;
    }

    // Render lookup field for edit
    public function renderLookupForEdit(string $name, mixed $value): mixed
    {
        $this->RowType = RowType::EDIT;
        return $value;
    }

    // Get file data
    public function getFileData(string $fldparm, string $key, bool $resize, int $width = 0, int $height = 0, array $plugins = []): Response
    {
        global $DownloadFileName;

        // No binary fields
        return $response;
    }

    // Table level events

    // Table Load event
    public function tableLoad(): void
    {
        // Enter your code here
    }

    // Records Selecting event
    public function recordsSelecting(string &$filter): void
    {
        // Enter your code here
    }

    // Records Selected event
    public function recordsSelected(Result $result): void
    {
        //Log("Records Selected");
    }

    // Records Search Validated event
    public function recordsSearchValidated(): void
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Records Searching event
    public function recordsSearching(string &$filter): void
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(string &$filter): void
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(array &$row): void
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting(?array $oldRow, array &$newRow): ?bool
    {
        // Enter your code here
        // To cancel, set return value to false
        // To skip for grid insert/update, set return value to null
        return true;
    }

    // Row Inserted event
    public function rowInserted(?array $oldRow, array $newRow): void
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating(array $oldRow, array &$newRow): ?bool
    {
        // Enter your code here
        // To cancel, set return value to false
        // To skip for grid insert/update, set return value to null
        return true;
    }

    // Row Updated event
    public function rowUpdated(array $oldRow, array $newRow): void
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict(array $oldRow, array &$newRow): bool
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting(): bool
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted(array $rows): void
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating(array $rows): bool
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated(array $oldRows, array $newRows): void
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(array $row): ?bool
    {
        // Enter your code here
        // To cancel, set return value to false
        // To skip for grid insert/update, set return value to null
        return true;
    }

    // Row Deleted event
    public function rowDeleted(array $row): void
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending(Email $email, array $args): bool
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting(DbField $field, string &$filter): void
    {
        //var_dump($field->Name, $field->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering(): void
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered(): void
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(string &$filter): void
    {
        // Enter your code here
    }
}
