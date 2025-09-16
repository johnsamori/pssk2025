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
 * Table class for dosen
 */
class Dosen extends DbTable implements LookupTableInterface
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
    public DbField $No;
    public DbField $NIP;
    public DbField $NIDN;
    public DbField $Nama_Lengkap;
    public DbField $Gelar_Depan;
    public DbField $Gelar_Belakang;
    public DbField $Program_studi;
    public DbField $NIK;
    public DbField $Tanggal_lahir;
    public DbField $Tempat_lahir;
    public DbField $Nomor_Karpeg;
    public DbField $Nomor_Stambuk;
    public DbField $Jenis_kelamin;
    public DbField $Gol_Darah;
    public DbField $Agama;
    public DbField $Stattus_menikah;
    public DbField $Alamat;
    public DbField $Kota;
    public DbField $Telepon_seluler;
    public DbField $Jenis_pegawai;
    public DbField $Status_pegawai;
    public DbField $Golongan;
    public DbField $Pangkat;
    public DbField $Status_dosen;
    public DbField $Status_Belajar;
    public DbField $e_mail;

    // Page ID
    public string $PageID = ""; // To be set by subclass

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        $this->TableVar = "dosen";
        $this->TableName = 'dosen';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");
        $this->UpdateTable = "dosen"; // Update table
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

        // No
        $this->No = new DbField(
            $this, // Table
            'x_No', // Variable name
            'No', // Name
            '`No`', // Expression
            '`No`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`No`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->No->InputTextType = "text";
        $this->No->Raw = true;
        $this->No->IsPrimaryKey = true; // Primary key field
        $this->No->Nullable = false; // NOT NULL field
        $this->No->Required = true; // Required field
        $this->No->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['No'] = &$this->No;

        // NIP
        $this->NIP = new DbField(
            $this, // Table
            'x_NIP', // Variable name
            'NIP', // Name
            '`NIP`', // Expression
            '`NIP`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NIP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NIP->InputTextType = "text";
        $this->NIP->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['NIP'] = &$this->NIP;

        // NIDN
        $this->NIDN = new DbField(
            $this, // Table
            'x_NIDN', // Variable name
            'NIDN', // Name
            '`NIDN`', // Expression
            '`NIDN`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NIDN`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NIDN->InputTextType = "text";
        $this->NIDN->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['NIDN'] = &$this->NIDN;

        // Nama_Lengkap
        $this->Nama_Lengkap = new DbField(
            $this, // Table
            'x_Nama_Lengkap', // Variable name
            'Nama_Lengkap', // Name
            '`Nama_Lengkap`', // Expression
            '`Nama_Lengkap`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nama_Lengkap`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nama_Lengkap->InputTextType = "text";
        $this->Nama_Lengkap->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nama_Lengkap'] = &$this->Nama_Lengkap;

        // Gelar_Depan
        $this->Gelar_Depan = new DbField(
            $this, // Table
            'x_Gelar_Depan', // Variable name
            'Gelar_Depan', // Name
            '`Gelar_Depan`', // Expression
            '`Gelar_Depan`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Gelar_Depan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Gelar_Depan->InputTextType = "text";
        $this->Gelar_Depan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Gelar_Depan'] = &$this->Gelar_Depan;

        // Gelar_Belakang
        $this->Gelar_Belakang = new DbField(
            $this, // Table
            'x_Gelar_Belakang', // Variable name
            'Gelar_Belakang', // Name
            '`Gelar_Belakang`', // Expression
            '`Gelar_Belakang`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Gelar_Belakang`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Gelar_Belakang->InputTextType = "text";
        $this->Gelar_Belakang->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Gelar_Belakang'] = &$this->Gelar_Belakang;

        // Program_studi
        $this->Program_studi = new DbField(
            $this, // Table
            'x_Program_studi', // Variable name
            'Program_studi', // Name
            '`Program_studi`', // Expression
            '`Program_studi`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Program_studi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Program_studi->InputTextType = "text";
        $this->Program_studi->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Program_studi'] = &$this->Program_studi;

        // NIK
        $this->NIK = new DbField(
            $this, // Table
            'x_NIK', // Variable name
            'NIK', // Name
            '`NIK`', // Expression
            '`NIK`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NIK`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NIK->InputTextType = "text";
        $this->NIK->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['NIK'] = &$this->NIK;

        // Tanggal_lahir
        $this->Tanggal_lahir = new DbField(
            $this, // Table
            'x_Tanggal_lahir', // Variable name
            'Tanggal_lahir', // Name
            '`Tanggal_lahir`', // Expression
            CastDateFieldForLike("`Tanggal_lahir`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`Tanggal_lahir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tanggal_lahir->InputTextType = "text";
        $this->Tanggal_lahir->Raw = true;
        $this->Tanggal_lahir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $this->language->phrase("IncorrectDate"));
        $this->Tanggal_lahir->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tanggal_lahir'] = &$this->Tanggal_lahir;

        // Tempat_lahir
        $this->Tempat_lahir = new DbField(
            $this, // Table
            'x_Tempat_lahir', // Variable name
            'Tempat_lahir', // Name
            '`Tempat_lahir`', // Expression
            '`Tempat_lahir`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Tempat_lahir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tempat_lahir->InputTextType = "text";
        $this->Tempat_lahir->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tempat_lahir'] = &$this->Tempat_lahir;

        // Nomor_Karpeg
        $this->Nomor_Karpeg = new DbField(
            $this, // Table
            'x_Nomor_Karpeg', // Variable name
            'Nomor_Karpeg', // Name
            '`Nomor_Karpeg`', // Expression
            '`Nomor_Karpeg`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nomor_Karpeg`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nomor_Karpeg->InputTextType = "text";
        $this->Nomor_Karpeg->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nomor_Karpeg'] = &$this->Nomor_Karpeg;

        // Nomor_Stambuk
        $this->Nomor_Stambuk = new DbField(
            $this, // Table
            'x_Nomor_Stambuk', // Variable name
            'Nomor_Stambuk', // Name
            '`Nomor_Stambuk`', // Expression
            '`Nomor_Stambuk`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nomor_Stambuk`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nomor_Stambuk->InputTextType = "text";
        $this->Nomor_Stambuk->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nomor_Stambuk'] = &$this->Nomor_Stambuk;

        // Jenis_kelamin
        $this->Jenis_kelamin = new DbField(
            $this, // Table
            'x_Jenis_kelamin', // Variable name
            'Jenis_kelamin', // Name
            '`Jenis_kelamin`', // Expression
            '`Jenis_kelamin`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jenis_kelamin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Jenis_kelamin->InputTextType = "text";
        $this->Jenis_kelamin->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jenis_kelamin'] = &$this->Jenis_kelamin;

        // Gol_Darah
        $this->Gol_Darah = new DbField(
            $this, // Table
            'x_Gol_Darah', // Variable name
            'Gol_Darah', // Name
            '`Gol_Darah`', // Expression
            '`Gol_Darah`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Gol_Darah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Gol_Darah->InputTextType = "text";
        $this->Gol_Darah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Gol_Darah'] = &$this->Gol_Darah;

        // Agama
        $this->Agama = new DbField(
            $this, // Table
            'x_Agama', // Variable name
            'Agama', // Name
            '`Agama`', // Expression
            '`Agama`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Agama`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Agama->InputTextType = "text";
        $this->Agama->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Agama'] = &$this->Agama;

        // Stattus_menikah
        $this->Stattus_menikah = new DbField(
            $this, // Table
            'x_Stattus_menikah', // Variable name
            'Stattus_menikah', // Name
            '`Stattus_menikah`', // Expression
            '`Stattus_menikah`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Stattus_menikah`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Stattus_menikah->InputTextType = "text";
        $this->Stattus_menikah->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Stattus_menikah'] = &$this->Stattus_menikah;

        // Alamat
        $this->Alamat = new DbField(
            $this, // Table
            'x_Alamat', // Variable name
            'Alamat', // Name
            '`Alamat`', // Expression
            '`Alamat`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Alamat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Alamat->InputTextType = "text";
        $this->Alamat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Alamat'] = &$this->Alamat;

        // Kota
        $this->Kota = new DbField(
            $this, // Table
            'x_Kota', // Variable name
            'Kota', // Name
            '`Kota`', // Expression
            '`Kota`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kota`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kota->InputTextType = "text";
        $this->Kota->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kota'] = &$this->Kota;

        // Telepon_seluler
        $this->Telepon_seluler = new DbField(
            $this, // Table
            'x_Telepon_seluler', // Variable name
            'Telepon_seluler', // Name
            '`Telepon_seluler`', // Expression
            '`Telepon_seluler`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Telepon_seluler`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Telepon_seluler->InputTextType = "text";
        $this->Telepon_seluler->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Telepon_seluler'] = &$this->Telepon_seluler;

        // Jenis_pegawai
        $this->Jenis_pegawai = new DbField(
            $this, // Table
            'x_Jenis_pegawai', // Variable name
            'Jenis_pegawai', // Name
            '`Jenis_pegawai`', // Expression
            '`Jenis_pegawai`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jenis_pegawai`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Jenis_pegawai->InputTextType = "text";
        $this->Jenis_pegawai->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jenis_pegawai'] = &$this->Jenis_pegawai;

        // Status_pegawai
        $this->Status_pegawai = new DbField(
            $this, // Table
            'x_Status_pegawai', // Variable name
            'Status_pegawai', // Name
            '`Status_pegawai`', // Expression
            '`Status_pegawai`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Status_pegawai`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Status_pegawai->InputTextType = "text";
        $this->Status_pegawai->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Status_pegawai'] = &$this->Status_pegawai;

        // Golongan
        $this->Golongan = new DbField(
            $this, // Table
            'x_Golongan', // Variable name
            'Golongan', // Name
            '`Golongan`', // Expression
            '`Golongan`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Golongan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Golongan->InputTextType = "text";
        $this->Golongan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Golongan'] = &$this->Golongan;

        // Pangkat
        $this->Pangkat = new DbField(
            $this, // Table
            'x_Pangkat', // Variable name
            'Pangkat', // Name
            '`Pangkat`', // Expression
            '`Pangkat`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Pangkat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Pangkat->InputTextType = "text";
        $this->Pangkat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Pangkat'] = &$this->Pangkat;

        // Status_dosen
        $this->Status_dosen = new DbField(
            $this, // Table
            'x_Status_dosen', // Variable name
            'Status_dosen', // Name
            '`Status_dosen`', // Expression
            '`Status_dosen`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Status_dosen`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Status_dosen->InputTextType = "text";
        $this->Status_dosen->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Status_dosen'] = &$this->Status_dosen;

        // Status_Belajar
        $this->Status_Belajar = new DbField(
            $this, // Table
            'x_Status_Belajar', // Variable name
            'Status_Belajar', // Name
            '`Status_Belajar`', // Expression
            '`Status_Belajar`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Status_Belajar`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Status_Belajar->InputTextType = "text";
        $this->Status_Belajar->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Status_Belajar'] = &$this->Status_Belajar;

        // e_mail
        $this->e_mail = new DbField(
            $this, // Table
            'x_e_mail', // Variable name
            'e_mail', // Name
            '`e_mail`', // Expression
            '`e_mail`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`e_mail`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->e_mail->InputTextType = "text";
        $this->e_mail->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['e_mail'] = &$this->e_mail;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "dosen";
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
            if (array_key_exists('No', $row)) {
                AddFilter($where, QuotedName('No', $this->Dbid) . '=' . QuotedValue($row['No'], $this->No->DataType, $this->Dbid));
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
        $this->No->DbValue = $row['No'];
        $this->NIP->DbValue = $row['NIP'];
        $this->NIDN->DbValue = $row['NIDN'];
        $this->Nama_Lengkap->DbValue = $row['Nama_Lengkap'];
        $this->Gelar_Depan->DbValue = $row['Gelar_Depan'];
        $this->Gelar_Belakang->DbValue = $row['Gelar_Belakang'];
        $this->Program_studi->DbValue = $row['Program_studi'];
        $this->NIK->DbValue = $row['NIK'];
        $this->Tanggal_lahir->DbValue = $row['Tanggal_lahir'];
        $this->Tempat_lahir->DbValue = $row['Tempat_lahir'];
        $this->Nomor_Karpeg->DbValue = $row['Nomor_Karpeg'];
        $this->Nomor_Stambuk->DbValue = $row['Nomor_Stambuk'];
        $this->Jenis_kelamin->DbValue = $row['Jenis_kelamin'];
        $this->Gol_Darah->DbValue = $row['Gol_Darah'];
        $this->Agama->DbValue = $row['Agama'];
        $this->Stattus_menikah->DbValue = $row['Stattus_menikah'];
        $this->Alamat->DbValue = $row['Alamat'];
        $this->Kota->DbValue = $row['Kota'];
        $this->Telepon_seluler->DbValue = $row['Telepon_seluler'];
        $this->Jenis_pegawai->DbValue = $row['Jenis_pegawai'];
        $this->Status_pegawai->DbValue = $row['Status_pegawai'];
        $this->Golongan->DbValue = $row['Golongan'];
        $this->Pangkat->DbValue = $row['Pangkat'];
        $this->Status_dosen->DbValue = $row['Status_dosen'];
        $this->Status_Belajar->DbValue = $row['Status_Belajar'];
        $this->e_mail->DbValue = $row['e_mail'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles(array $row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter(): string
    {
        return "`No` = '@No@'";
    }

    // Get Key from record
    public function getKeyFromRecord(array $row, ?string $keySeparator = null): string
    {
        $keys = [];
        $val = $row['No'];
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
        $val = $current ? $this->No->CurrentValue : $this->No->OldValue;
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
                $this->No->CurrentValue = $keys[0];
            } else {
                $this->No->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter(?array $row = null, bool $current = false): string
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('No', $row) ? $row['No'] : null;
        } else {
            $val = !IsEmpty($this->No->OldValue) && !$current ? $this->No->OldValue : $this->No->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@No@", AdjustSql($val), $keyFilter); // Replace key value
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
        return Session($name) ?? GetUrl("dosenlist");
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
            "dosenview" => $this->language->phrase("View"),
            "dosenedit" => $this->language->phrase("Edit"),
            "dosenadd" => $this->language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl(): string
    {
        return "dosenlist";
    }

    // API page name
    public function getApiPageName(string $action): string
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "DosenView",
            Config("API_ADD_ACTION") => "DosenAdd",
            Config("API_EDIT_ACTION") => "DosenEdit",
            Config("API_DELETE_ACTION") => "DosenDelete",
            Config("API_LIST_ACTION") => "DosenList",
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
        return "dosenlist";
    }

    // View URL
    public function getViewUrl(string $parm = ""): string
    {
        if ($parm != "") {
            $url = $this->keyUrl("dosenview", $parm);
        } else {
            $url = $this->keyUrl("dosenview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl(string $parm = ""): string
    {
        if ($parm != "") {
            $url = "dosenadd?" . $parm;
        } else {
            $url = "dosenadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl(string $parm = ""): string
    {
        $url = $this->keyUrl("dosenedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl(): string
    {
        $url = $this->keyUrl("dosenlist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl(string $parm = ""): string
    {
        $url = $this->keyUrl("dosenadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl(): string
    {
        $url = $this->keyUrl("dosenlist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl(string $parm = ""): string
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("dosendelete", $parm);
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
        $json .= "\"No\":" . VarToJson($this->No->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl(string $url, string $parm = ""): string
    {
        if ($this->No->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->No->CurrentValue);
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
            if (($keyValue = Param("No") ?? Route("No")) !== null) {
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
                $this->No->CurrentValue = $key;
            } else {
                $this->No->OldValue = $key;
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
        $this->No->setDbValue($row['No']);
        $this->NIP->setDbValue($row['NIP']);
        $this->NIDN->setDbValue($row['NIDN']);
        $this->Nama_Lengkap->setDbValue($row['Nama_Lengkap']);
        $this->Gelar_Depan->setDbValue($row['Gelar_Depan']);
        $this->Gelar_Belakang->setDbValue($row['Gelar_Belakang']);
        $this->Program_studi->setDbValue($row['Program_studi']);
        $this->NIK->setDbValue($row['NIK']);
        $this->Tanggal_lahir->setDbValue($row['Tanggal_lahir']);
        $this->Tempat_lahir->setDbValue($row['Tempat_lahir']);
        $this->Nomor_Karpeg->setDbValue($row['Nomor_Karpeg']);
        $this->Nomor_Stambuk->setDbValue($row['Nomor_Stambuk']);
        $this->Jenis_kelamin->setDbValue($row['Jenis_kelamin']);
        $this->Gol_Darah->setDbValue($row['Gol_Darah']);
        $this->Agama->setDbValue($row['Agama']);
        $this->Stattus_menikah->setDbValue($row['Stattus_menikah']);
        $this->Alamat->setDbValue($row['Alamat']);
        $this->Kota->setDbValue($row['Kota']);
        $this->Telepon_seluler->setDbValue($row['Telepon_seluler']);
        $this->Jenis_pegawai->setDbValue($row['Jenis_pegawai']);
        $this->Status_pegawai->setDbValue($row['Status_pegawai']);
        $this->Golongan->setDbValue($row['Golongan']);
        $this->Pangkat->setDbValue($row['Pangkat']);
        $this->Status_dosen->setDbValue($row['Status_dosen']);
        $this->Status_Belajar->setDbValue($row['Status_Belajar']);
        $this->e_mail->setDbValue($row['e_mail']);
    }

    // Render list content
    public function renderListContent(string $filter)
    {
        global $Response;
        $container = Container();
        $listPage = "DosenList";
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

        // No

        // NIP

        // NIDN

        // Nama_Lengkap

        // Gelar_Depan

        // Gelar_Belakang

        // Program_studi

        // NIK

        // Tanggal_lahir

        // Tempat_lahir

        // Nomor_Karpeg

        // Nomor_Stambuk

        // Jenis_kelamin

        // Gol_Darah

        // Agama

        // Stattus_menikah

        // Alamat

        // Kota

        // Telepon_seluler

        // Jenis_pegawai

        // Status_pegawai

        // Golongan

        // Pangkat

        // Status_dosen

        // Status_Belajar

        // e_mail

        // No
        $this->No->ViewValue = $this->No->CurrentValue;

        // NIP
        $this->NIP->ViewValue = $this->NIP->CurrentValue;

        // NIDN
        $this->NIDN->ViewValue = $this->NIDN->CurrentValue;

        // Nama_Lengkap
        $this->Nama_Lengkap->ViewValue = $this->Nama_Lengkap->CurrentValue;

        // Gelar_Depan
        $this->Gelar_Depan->ViewValue = $this->Gelar_Depan->CurrentValue;

        // Gelar_Belakang
        $this->Gelar_Belakang->ViewValue = $this->Gelar_Belakang->CurrentValue;

        // Program_studi
        $this->Program_studi->ViewValue = $this->Program_studi->CurrentValue;

        // NIK
        $this->NIK->ViewValue = $this->NIK->CurrentValue;

        // Tanggal_lahir
        $this->Tanggal_lahir->ViewValue = $this->Tanggal_lahir->CurrentValue;
        $this->Tanggal_lahir->ViewValue = FormatDateTime($this->Tanggal_lahir->ViewValue, $this->Tanggal_lahir->formatPattern());

        // Tempat_lahir
        $this->Tempat_lahir->ViewValue = $this->Tempat_lahir->CurrentValue;

        // Nomor_Karpeg
        $this->Nomor_Karpeg->ViewValue = $this->Nomor_Karpeg->CurrentValue;

        // Nomor_Stambuk
        $this->Nomor_Stambuk->ViewValue = $this->Nomor_Stambuk->CurrentValue;

        // Jenis_kelamin
        $this->Jenis_kelamin->ViewValue = $this->Jenis_kelamin->CurrentValue;

        // Gol_Darah
        $this->Gol_Darah->ViewValue = $this->Gol_Darah->CurrentValue;

        // Agama
        $this->Agama->ViewValue = $this->Agama->CurrentValue;

        // Stattus_menikah
        $this->Stattus_menikah->ViewValue = $this->Stattus_menikah->CurrentValue;

        // Alamat
        $this->Alamat->ViewValue = $this->Alamat->CurrentValue;

        // Kota
        $this->Kota->ViewValue = $this->Kota->CurrentValue;

        // Telepon_seluler
        $this->Telepon_seluler->ViewValue = $this->Telepon_seluler->CurrentValue;

        // Jenis_pegawai
        $this->Jenis_pegawai->ViewValue = $this->Jenis_pegawai->CurrentValue;

        // Status_pegawai
        $this->Status_pegawai->ViewValue = $this->Status_pegawai->CurrentValue;

        // Golongan
        $this->Golongan->ViewValue = $this->Golongan->CurrentValue;

        // Pangkat
        $this->Pangkat->ViewValue = $this->Pangkat->CurrentValue;

        // Status_dosen
        $this->Status_dosen->ViewValue = $this->Status_dosen->CurrentValue;

        // Status_Belajar
        $this->Status_Belajar->ViewValue = $this->Status_Belajar->CurrentValue;

        // e_mail
        $this->e_mail->ViewValue = $this->e_mail->CurrentValue;

        // No
        $this->No->HrefValue = "";
        $this->No->TooltipValue = "";

        // NIP
        $this->NIP->HrefValue = "";
        $this->NIP->TooltipValue = "";

        // NIDN
        $this->NIDN->HrefValue = "";
        $this->NIDN->TooltipValue = "";

        // Nama_Lengkap
        $this->Nama_Lengkap->HrefValue = "";
        $this->Nama_Lengkap->TooltipValue = "";

        // Gelar_Depan
        $this->Gelar_Depan->HrefValue = "";
        $this->Gelar_Depan->TooltipValue = "";

        // Gelar_Belakang
        $this->Gelar_Belakang->HrefValue = "";
        $this->Gelar_Belakang->TooltipValue = "";

        // Program_studi
        $this->Program_studi->HrefValue = "";
        $this->Program_studi->TooltipValue = "";

        // NIK
        $this->NIK->HrefValue = "";
        $this->NIK->TooltipValue = "";

        // Tanggal_lahir
        $this->Tanggal_lahir->HrefValue = "";
        $this->Tanggal_lahir->TooltipValue = "";

        // Tempat_lahir
        $this->Tempat_lahir->HrefValue = "";
        $this->Tempat_lahir->TooltipValue = "";

        // Nomor_Karpeg
        $this->Nomor_Karpeg->HrefValue = "";
        $this->Nomor_Karpeg->TooltipValue = "";

        // Nomor_Stambuk
        $this->Nomor_Stambuk->HrefValue = "";
        $this->Nomor_Stambuk->TooltipValue = "";

        // Jenis_kelamin
        $this->Jenis_kelamin->HrefValue = "";
        $this->Jenis_kelamin->TooltipValue = "";

        // Gol_Darah
        $this->Gol_Darah->HrefValue = "";
        $this->Gol_Darah->TooltipValue = "";

        // Agama
        $this->Agama->HrefValue = "";
        $this->Agama->TooltipValue = "";

        // Stattus_menikah
        $this->Stattus_menikah->HrefValue = "";
        $this->Stattus_menikah->TooltipValue = "";

        // Alamat
        $this->Alamat->HrefValue = "";
        $this->Alamat->TooltipValue = "";

        // Kota
        $this->Kota->HrefValue = "";
        $this->Kota->TooltipValue = "";

        // Telepon_seluler
        $this->Telepon_seluler->HrefValue = "";
        $this->Telepon_seluler->TooltipValue = "";

        // Jenis_pegawai
        $this->Jenis_pegawai->HrefValue = "";
        $this->Jenis_pegawai->TooltipValue = "";

        // Status_pegawai
        $this->Status_pegawai->HrefValue = "";
        $this->Status_pegawai->TooltipValue = "";

        // Golongan
        $this->Golongan->HrefValue = "";
        $this->Golongan->TooltipValue = "";

        // Pangkat
        $this->Pangkat->HrefValue = "";
        $this->Pangkat->TooltipValue = "";

        // Status_dosen
        $this->Status_dosen->HrefValue = "";
        $this->Status_dosen->TooltipValue = "";

        // Status_Belajar
        $this->Status_Belajar->HrefValue = "";
        $this->Status_Belajar->TooltipValue = "";

        // e_mail
        $this->e_mail->HrefValue = "";
        $this->e_mail->TooltipValue = "";

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
                    $doc->exportCaption($this->No);
                    $doc->exportCaption($this->NIP);
                    $doc->exportCaption($this->NIDN);
                    $doc->exportCaption($this->Nama_Lengkap);
                    $doc->exportCaption($this->Gelar_Depan);
                    $doc->exportCaption($this->Gelar_Belakang);
                    $doc->exportCaption($this->Program_studi);
                    $doc->exportCaption($this->NIK);
                    $doc->exportCaption($this->Tanggal_lahir);
                    $doc->exportCaption($this->Tempat_lahir);
                    $doc->exportCaption($this->Nomor_Karpeg);
                    $doc->exportCaption($this->Nomor_Stambuk);
                    $doc->exportCaption($this->Jenis_kelamin);
                    $doc->exportCaption($this->Gol_Darah);
                    $doc->exportCaption($this->Agama);
                    $doc->exportCaption($this->Stattus_menikah);
                    $doc->exportCaption($this->Alamat);
                    $doc->exportCaption($this->Kota);
                    $doc->exportCaption($this->Telepon_seluler);
                    $doc->exportCaption($this->Jenis_pegawai);
                    $doc->exportCaption($this->Status_pegawai);
                    $doc->exportCaption($this->Golongan);
                    $doc->exportCaption($this->Pangkat);
                    $doc->exportCaption($this->Status_dosen);
                    $doc->exportCaption($this->Status_Belajar);
                    $doc->exportCaption($this->e_mail);
                } else {
                    $doc->exportCaption($this->No);
                    $doc->exportCaption($this->NIP);
                    $doc->exportCaption($this->NIDN);
                    $doc->exportCaption($this->Nama_Lengkap);
                    $doc->exportCaption($this->Gelar_Depan);
                    $doc->exportCaption($this->Gelar_Belakang);
                    $doc->exportCaption($this->Program_studi);
                    $doc->exportCaption($this->NIK);
                    $doc->exportCaption($this->Tanggal_lahir);
                    $doc->exportCaption($this->Tempat_lahir);
                    $doc->exportCaption($this->Nomor_Karpeg);
                    $doc->exportCaption($this->Nomor_Stambuk);
                    $doc->exportCaption($this->Jenis_kelamin);
                    $doc->exportCaption($this->Gol_Darah);
                    $doc->exportCaption($this->Agama);
                    $doc->exportCaption($this->Stattus_menikah);
                    $doc->exportCaption($this->Alamat);
                    $doc->exportCaption($this->Kota);
                    $doc->exportCaption($this->Telepon_seluler);
                    $doc->exportCaption($this->Jenis_pegawai);
                    $doc->exportCaption($this->Status_pegawai);
                    $doc->exportCaption($this->Golongan);
                    $doc->exportCaption($this->Pangkat);
                    $doc->exportCaption($this->Status_dosen);
                    $doc->exportCaption($this->Status_Belajar);
                    $doc->exportCaption($this->e_mail);
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
						$doc->exportCaption($this->No);
						$doc->exportCaption($this->NIP);
						$doc->exportCaption($this->NIDN);
						$doc->exportCaption($this->Nama_Lengkap);
						$doc->exportCaption($this->Gelar_Depan);
						$doc->exportCaption($this->Gelar_Belakang);
						$doc->exportCaption($this->Program_studi);
						$doc->exportCaption($this->NIK);
						$doc->exportCaption($this->Tanggal_lahir);
						$doc->exportCaption($this->Tempat_lahir);
						$doc->exportCaption($this->Nomor_Karpeg);
						$doc->exportCaption($this->Nomor_Stambuk);
						$doc->exportCaption($this->Jenis_kelamin);
						$doc->exportCaption($this->Gol_Darah);
						$doc->exportCaption($this->Agama);
						$doc->exportCaption($this->Stattus_menikah);
						$doc->exportCaption($this->Alamat);
						$doc->exportCaption($this->Kota);
						$doc->exportCaption($this->Telepon_seluler);
						$doc->exportCaption($this->Jenis_pegawai);
						$doc->exportCaption($this->Status_pegawai);
						$doc->exportCaption($this->Golongan);
						$doc->exportCaption($this->Pangkat);
						$doc->exportCaption($this->Status_dosen);
						$doc->exportCaption($this->Status_Belajar);
						$doc->exportCaption($this->e_mail);
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
                        $doc->exportField($this->No);
                        $doc->exportField($this->NIP);
                        $doc->exportField($this->NIDN);
                        $doc->exportField($this->Nama_Lengkap);
                        $doc->exportField($this->Gelar_Depan);
                        $doc->exportField($this->Gelar_Belakang);
                        $doc->exportField($this->Program_studi);
                        $doc->exportField($this->NIK);
                        $doc->exportField($this->Tanggal_lahir);
                        $doc->exportField($this->Tempat_lahir);
                        $doc->exportField($this->Nomor_Karpeg);
                        $doc->exportField($this->Nomor_Stambuk);
                        $doc->exportField($this->Jenis_kelamin);
                        $doc->exportField($this->Gol_Darah);
                        $doc->exportField($this->Agama);
                        $doc->exportField($this->Stattus_menikah);
                        $doc->exportField($this->Alamat);
                        $doc->exportField($this->Kota);
                        $doc->exportField($this->Telepon_seluler);
                        $doc->exportField($this->Jenis_pegawai);
                        $doc->exportField($this->Status_pegawai);
                        $doc->exportField($this->Golongan);
                        $doc->exportField($this->Pangkat);
                        $doc->exportField($this->Status_dosen);
                        $doc->exportField($this->Status_Belajar);
                        $doc->exportField($this->e_mail);
                    } else {
                        $doc->exportField($this->No);
                        $doc->exportField($this->NIP);
                        $doc->exportField($this->NIDN);
                        $doc->exportField($this->Nama_Lengkap);
                        $doc->exportField($this->Gelar_Depan);
                        $doc->exportField($this->Gelar_Belakang);
                        $doc->exportField($this->Program_studi);
                        $doc->exportField($this->NIK);
                        $doc->exportField($this->Tanggal_lahir);
                        $doc->exportField($this->Tempat_lahir);
                        $doc->exportField($this->Nomor_Karpeg);
                        $doc->exportField($this->Nomor_Stambuk);
                        $doc->exportField($this->Jenis_kelamin);
                        $doc->exportField($this->Gol_Darah);
                        $doc->exportField($this->Agama);
                        $doc->exportField($this->Stattus_menikah);
                        $doc->exportField($this->Alamat);
                        $doc->exportField($this->Kota);
                        $doc->exportField($this->Telepon_seluler);
                        $doc->exportField($this->Jenis_pegawai);
                        $doc->exportField($this->Status_pegawai);
                        $doc->exportField($this->Golongan);
                        $doc->exportField($this->Pangkat);
                        $doc->exportField($this->Status_dosen);
                        $doc->exportField($this->Status_Belajar);
                        $doc->exportField($this->e_mail);
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
