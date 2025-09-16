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
 * Table class for detil_mata_kuliah
 */
class DetilMataKuliah extends DbTable implements LookupTableInterface
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
    public DbField $id_no;
    public DbField $Kode_MK;
    public DbField $NIM;
    public DbField $Nilai_Diskusi;
    public DbField $Assessment_Skor_As_1;
    public DbField $Assessment_Skor_As_2;
    public DbField $Assessment_Skor_As_3;
    public DbField $Nilai_Tugas;
    public DbField $Nilai_UTS;
    public DbField $Nilai_Akhir;
    public DbField $iduser;
    public DbField $user;
    public DbField $ip;
    public DbField $tanggal;

    // Page ID
    public string $PageID = ""; // To be set by subclass

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        $this->TableVar = "detil_mata_kuliah";
        $this->TableName = 'detil_mata_kuliah';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");
        $this->UpdateTable = "detil_mata_kuliah"; // Update table
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
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDPermission = Config("DEFAULT_USER_ID_PERMISSION"); // Default User ID permission
        $this->BasicSearch = new BasicSearch($this, Session(), $this->language);

        // id_no
        $this->id_no = new DbField(
            $this, // Table
            'x_id_no', // Variable name
            'id_no', // Name
            '`id_no`', // Expression
            '`id_no`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`id_no`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->id_no->InputTextType = "text";
        $this->id_no->Raw = true;
        $this->id_no->IsAutoIncrement = true; // Autoincrement field
        $this->id_no->IsPrimaryKey = true; // Primary key field
        $this->id_no->Nullable = false; // NOT NULL field
        $this->id_no->DefaultErrorMessage = $this->language->phrase("IncorrectInteger");
        $this->id_no->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['id_no'] = &$this->id_no;

        // Kode_MK
        $this->Kode_MK = new DbField(
            $this, // Table
            'x_Kode_MK', // Variable name
            'Kode_MK', // Name
            '`Kode_MK`', // Expression
            '`Kode_MK`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kode_MK`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Kode_MK->InputTextType = "text";
        $this->Kode_MK->Raw = true;
        $this->Kode_MK->IsPrimaryKey = true; // Primary key field
        $this->Kode_MK->IsForeignKey = true; // Foreign key field
        $this->Kode_MK->Nullable = false; // NOT NULL field
        $this->Kode_MK->Required = true; // Required field
        $this->Kode_MK->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Kode_MK'] = &$this->Kode_MK;

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
        $this->NIM->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['NIM'] = &$this->NIM;

        // Nilai_Diskusi
        $this->Nilai_Diskusi = new DbField(
            $this, // Table
            'x_Nilai_Diskusi', // Variable name
            'Nilai_Diskusi', // Name
            '`Nilai_Diskusi`', // Expression
            '`Nilai_Diskusi`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_Diskusi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_Diskusi->InputTextType = "text";
        $this->Nilai_Diskusi->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_Diskusi'] = &$this->Nilai_Diskusi;

        // Assessment_Skor_As_1
        $this->Assessment_Skor_As_1 = new DbField(
            $this, // Table
            'x_Assessment_Skor_As_1', // Variable name
            'Assessment_Skor_As_1', // Name
            '`Assessment_Skor_As_1`', // Expression
            '`Assessment_Skor_As_1`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Assessment_Skor_As_1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Assessment_Skor_As_1->InputTextType = "text";
        $this->Assessment_Skor_As_1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Assessment_Skor_As_1'] = &$this->Assessment_Skor_As_1;

        // Assessment_Skor_As_2
        $this->Assessment_Skor_As_2 = new DbField(
            $this, // Table
            'x_Assessment_Skor_As_2', // Variable name
            'Assessment_Skor_As_2', // Name
            '`Assessment_Skor_As_2`', // Expression
            '`Assessment_Skor_As_2`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Assessment_Skor_As_2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Assessment_Skor_As_2->InputTextType = "text";
        $this->Assessment_Skor_As_2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Assessment_Skor_As_2'] = &$this->Assessment_Skor_As_2;

        // Assessment_Skor_As_3
        $this->Assessment_Skor_As_3 = new DbField(
            $this, // Table
            'x_Assessment_Skor_As_3', // Variable name
            'Assessment_Skor_As_3', // Name
            '`Assessment_Skor_As_3`', // Expression
            '`Assessment_Skor_As_3`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Assessment_Skor_As_3`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Assessment_Skor_As_3->InputTextType = "text";
        $this->Assessment_Skor_As_3->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Assessment_Skor_As_3'] = &$this->Assessment_Skor_As_3;

        // Nilai_Tugas
        $this->Nilai_Tugas = new DbField(
            $this, // Table
            'x_Nilai_Tugas', // Variable name
            'Nilai_Tugas', // Name
            '`Nilai_Tugas`', // Expression
            '`Nilai_Tugas`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_Tugas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_Tugas->InputTextType = "text";
        $this->Nilai_Tugas->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_Tugas'] = &$this->Nilai_Tugas;

        // Nilai_UTS
        $this->Nilai_UTS = new DbField(
            $this, // Table
            'x_Nilai_UTS', // Variable name
            'Nilai_UTS', // Name
            '`Nilai_UTS`', // Expression
            '`Nilai_UTS`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_UTS`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_UTS->InputTextType = "text";
        $this->Nilai_UTS->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_UTS'] = &$this->Nilai_UTS;

        // Nilai_Akhir
        $this->Nilai_Akhir = new DbField(
            $this, // Table
            'x_Nilai_Akhir', // Variable name
            'Nilai_Akhir', // Name
            '`Nilai_Akhir`', // Expression
            '`Nilai_Akhir`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nilai_Akhir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nilai_Akhir->InputTextType = "text";
        $this->Nilai_Akhir->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nilai_Akhir'] = &$this->Nilai_Akhir;

        // iduser
        $this->iduser = new DbField(
            $this, // Table
            'x_iduser', // Variable name
            'iduser', // Name
            '`iduser`', // Expression
            '`iduser`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`iduser`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->iduser->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->iduser->InputTextType = "text";
        $this->iduser->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['iduser'] = &$this->iduser;

        // user
        $this->user = new DbField(
            $this, // Table
            'x_user', // Variable name
            'user', // Name
            '`user`', // Expression
            '`user`', // Basic search expression
            200, // Type
            15, // Size
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

        // tanggal
        $this->tanggal = new DbField(
            $this, // Table
            'x_tanggal', // Variable name
            'tanggal', // Name
            '`tanggal`', // Expression
            CastDateFieldForLike("`tanggal`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`tanggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tanggal->addMethod("getAutoUpdateValue", fn() => CurrentDate());
        $this->tanggal->InputTextType = "text";
        $this->tanggal->Raw = true;
        $this->tanggal->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $this->language->phrase("IncorrectDate"));
        $this->tanggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tanggal'] = &$this->tanggal;

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

    // Current master table name
    public function getCurrentMasterTable(): ?string
    {
        return Session(AddTabId(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")));
    }

    public function setCurrentMasterTable(?string $v): void
    {
        Session(AddTabId(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")), $v);
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession(): string
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "mata_kuliah") {
            $masterTable = Container("mata_kuliah");
            if ($this->Kode_MK->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->Kode_MK, $this->Kode_MK->getSessionValue(), $masterTable->Kode_MK->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession(): string
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "mata_kuliah") {
            $masterTable = Container("mata_kuliah");
            if ($this->Kode_MK->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->Kode_MK, $this->Kode_MK->getSessionValue(), $masterTable->Kode_MK->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter(DbTableBase $masterTable, array $keys): ?string
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "mata_kuliah":
                $key = $keys["Kode_MK"] ?? "";
                if (IsEmpty($key)) {
                    if ($masterTable->Kode_MK->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->Kode_MK, $keys["Kode_MK"], $this->Kode_MK->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter(DbTableBase $masterTable): string
    {
        switch ($masterTable->TableVar) {
            case "mata_kuliah":
                return GetKeyFilter($this->Kode_MK, $masterTable->Kode_MK->DbValue, $masterTable->Kode_MK->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis(string $chartVar, array $chartRow): array
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom(): string
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "detil_mata_kuliah";
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
            $this->id_no->setDbValue($conn->lastInsertId());
            $row['id_no'] = $this->id_no->DbValue;
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

        // Return auto increment field
        if ($success) {
            if (!isset($row['id_no']) && !IsEmpty($this->id_no->CurrentValue)) {
                $row['id_no'] = $this->id_no->CurrentValue;
            }
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
            if (array_key_exists('id_no', $row)) {
                AddFilter($where, QuotedName('id_no', $this->Dbid) . '=' . QuotedValue($row['id_no'], $this->id_no->DataType, $this->Dbid));
            }
            if (array_key_exists('Kode_MK', $row)) {
                AddFilter($where, QuotedName('Kode_MK', $this->Dbid) . '=' . QuotedValue($row['Kode_MK'], $this->Kode_MK->DataType, $this->Dbid));
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
        $this->id_no->DbValue = $row['id_no'];
        $this->Kode_MK->DbValue = $row['Kode_MK'];
        $this->NIM->DbValue = $row['NIM'];
        $this->Nilai_Diskusi->DbValue = $row['Nilai_Diskusi'];
        $this->Assessment_Skor_As_1->DbValue = $row['Assessment_Skor_As_1'];
        $this->Assessment_Skor_As_2->DbValue = $row['Assessment_Skor_As_2'];
        $this->Assessment_Skor_As_3->DbValue = $row['Assessment_Skor_As_3'];
        $this->Nilai_Tugas->DbValue = $row['Nilai_Tugas'];
        $this->Nilai_UTS->DbValue = $row['Nilai_UTS'];
        $this->Nilai_Akhir->DbValue = $row['Nilai_Akhir'];
        $this->iduser->DbValue = $row['iduser'];
        $this->user->DbValue = $row['user'];
        $this->ip->DbValue = $row['ip'];
        $this->tanggal->DbValue = $row['tanggal'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles(array $row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter(): string
    {
        return "`id_no` = @id_no@ AND `Kode_MK` = '@Kode_MK@'";
    }

    // Get Key from record
    public function getKeyFromRecord(array $row, ?string $keySeparator = null): string
    {
        $keys = [];
        $val = $row['id_no'];
        if (IsEmpty($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $row['Kode_MK'];
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
        $val = $current ? $this->id_no->CurrentValue : $this->id_no->OldValue;
        if (IsEmpty($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->Kode_MK->CurrentValue : $this->Kode_MK->OldValue;
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
        if (count($keys) == 2) {
            if ($current) {
                $this->id_no->CurrentValue = $keys[0];
            } else {
                $this->id_no->OldValue = $keys[0];
            }
            if ($current) {
                $this->Kode_MK->CurrentValue = $keys[1];
            } else {
                $this->Kode_MK->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter(?array $row = null, bool $current = false): string
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_no', $row) ? $row['id_no'] : null;
        } else {
            $val = !IsEmpty($this->id_no->OldValue) && !$current ? $this->id_no->OldValue : $this->id_no->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_no@", AdjustSql($val), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('Kode_MK', $row) ? $row['Kode_MK'] : null;
        } else {
            $val = !IsEmpty($this->Kode_MK->OldValue) && !$current ? $this->Kode_MK->OldValue : $this->Kode_MK->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Kode_MK@", AdjustSql($val), $keyFilter); // Replace key value
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
        return Session($name) ?? GetUrl("detilmatakuliahlist");
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
            "detilmatakuliahview" => $this->language->phrase("View"),
            "detilmatakuliahedit" => $this->language->phrase("Edit"),
            "detilmatakuliahadd" => $this->language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl(): string
    {
        return "detilmatakuliahlist";
    }

    // API page name
    public function getApiPageName(string $action): string
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "DetilMataKuliahView",
            Config("API_ADD_ACTION") => "DetilMataKuliahAdd",
            Config("API_EDIT_ACTION") => "DetilMataKuliahEdit",
            Config("API_DELETE_ACTION") => "DetilMataKuliahDelete",
            Config("API_LIST_ACTION") => "DetilMataKuliahList",
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
        return "detilmatakuliahlist";
    }

    // View URL
    public function getViewUrl(string $parm = ""): string
    {
        if ($parm != "") {
            $url = $this->keyUrl("detilmatakuliahview", $parm);
        } else {
            $url = $this->keyUrl("detilmatakuliahview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl(string $parm = ""): string
    {
        if ($parm != "") {
            $url = "detilmatakuliahadd?" . $parm;
        } else {
            $url = "detilmatakuliahadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl(string $parm = ""): string
    {
        $url = $this->keyUrl("detilmatakuliahedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl(): string
    {
        $url = $this->keyUrl("detilmatakuliahlist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl(string $parm = ""): string
    {
        $url = $this->keyUrl("detilmatakuliahadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl(): string
    {
        $url = $this->keyUrl("detilmatakuliahlist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl(string $parm = ""): string
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("detilmatakuliahdelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl(string $url): string
    {
        if ($this->getCurrentMasterTable() == "mata_kuliah" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_Kode_MK", $this->Kode_MK->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson(bool $htmlEncode = false): string
    {
        $json = "";
        $json .= "\"id_no\":" . VarToJson($this->id_no->CurrentValue, "number");
        $json .= ",\"Kode_MK\":" . VarToJson($this->Kode_MK->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl(string $url, string $parm = ""): string
    {
        if ($this->id_no->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id_no->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->Kode_MK->CurrentValue !== null) {
            $url .= $this->RouteCompositeKeySeparator . $this->encodeKeyValue($this->Kode_MK->CurrentValue);
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 1))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 1))) // Other API
                : []; // Non-API
            if (($keyValue = Param("id_no") ?? Route("id_no")) !== null) {
                $arKey[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("Kode_MK") ?? Route("Kode_MK")) !== null) {
                $arKey[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(1) ?? $keyValues[1] ?? null) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            $arKeys[] = $arKey;
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
                }
                if (!is_numeric($key[0])) { // id_no
                    continue;
                }
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
                $this->id_no->CurrentValue = $key[0];
            } else {
                $this->id_no->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->Kode_MK->CurrentValue = $key[1];
            } else {
                $this->Kode_MK->OldValue = $key[1];
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
        $this->id_no->setDbValue($row['id_no']);
        $this->Kode_MK->setDbValue($row['Kode_MK']);
        $this->NIM->setDbValue($row['NIM']);
        $this->Nilai_Diskusi->setDbValue($row['Nilai_Diskusi']);
        $this->Assessment_Skor_As_1->setDbValue($row['Assessment_Skor_As_1']);
        $this->Assessment_Skor_As_2->setDbValue($row['Assessment_Skor_As_2']);
        $this->Assessment_Skor_As_3->setDbValue($row['Assessment_Skor_As_3']);
        $this->Nilai_Tugas->setDbValue($row['Nilai_Tugas']);
        $this->Nilai_UTS->setDbValue($row['Nilai_UTS']);
        $this->Nilai_Akhir->setDbValue($row['Nilai_Akhir']);
        $this->iduser->setDbValue($row['iduser']);
        $this->user->setDbValue($row['user']);
        $this->ip->setDbValue($row['ip']);
        $this->tanggal->setDbValue($row['tanggal']);
    }

    // Render list content
    public function renderListContent(string $filter)
    {
        global $Response;
        $container = Container();
        $listPage = "DetilMataKuliahList";
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

        // id_no

        // Kode_MK

        // NIM

        // Nilai_Diskusi

        // Assessment_Skor_As_1

        // Assessment_Skor_As_2

        // Assessment_Skor_As_3

        // Nilai_Tugas

        // Nilai_UTS

        // Nilai_Akhir

        // iduser

        // user

        // ip

        // tanggal

        // id_no
        $this->id_no->ViewValue = $this->id_no->CurrentValue;

        // Kode_MK
        $this->Kode_MK->ViewValue = $this->Kode_MK->CurrentValue;

        // NIM
        $this->NIM->ViewValue = $this->NIM->CurrentValue;

        // Nilai_Diskusi
        $this->Nilai_Diskusi->ViewValue = $this->Nilai_Diskusi->CurrentValue;

        // Assessment_Skor_As_1
        $this->Assessment_Skor_As_1->ViewValue = $this->Assessment_Skor_As_1->CurrentValue;

        // Assessment_Skor_As_2
        $this->Assessment_Skor_As_2->ViewValue = $this->Assessment_Skor_As_2->CurrentValue;

        // Assessment_Skor_As_3
        $this->Assessment_Skor_As_3->ViewValue = $this->Assessment_Skor_As_3->CurrentValue;

        // Nilai_Tugas
        $this->Nilai_Tugas->ViewValue = $this->Nilai_Tugas->CurrentValue;

        // Nilai_UTS
        $this->Nilai_UTS->ViewValue = $this->Nilai_UTS->CurrentValue;

        // Nilai_Akhir
        $this->Nilai_Akhir->ViewValue = $this->Nilai_Akhir->CurrentValue;

        // iduser
        $this->iduser->ViewValue = $this->iduser->CurrentValue;

        // user
        $this->user->ViewValue = $this->user->CurrentValue;

        // ip
        $this->ip->ViewValue = $this->ip->CurrentValue;

        // tanggal
        $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
        $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, $this->tanggal->formatPattern());

        // id_no
        $this->id_no->HrefValue = "";
        $this->id_no->TooltipValue = "";

        // Kode_MK
        $this->Kode_MK->HrefValue = "";
        $this->Kode_MK->TooltipValue = "";

        // NIM
        $this->NIM->HrefValue = "";
        $this->NIM->TooltipValue = "";

        // Nilai_Diskusi
        $this->Nilai_Diskusi->HrefValue = "";
        $this->Nilai_Diskusi->TooltipValue = "";

        // Assessment_Skor_As_1
        $this->Assessment_Skor_As_1->HrefValue = "";
        $this->Assessment_Skor_As_1->TooltipValue = "";

        // Assessment_Skor_As_2
        $this->Assessment_Skor_As_2->HrefValue = "";
        $this->Assessment_Skor_As_2->TooltipValue = "";

        // Assessment_Skor_As_3
        $this->Assessment_Skor_As_3->HrefValue = "";
        $this->Assessment_Skor_As_3->TooltipValue = "";

        // Nilai_Tugas
        $this->Nilai_Tugas->HrefValue = "";
        $this->Nilai_Tugas->TooltipValue = "";

        // Nilai_UTS
        $this->Nilai_UTS->HrefValue = "";
        $this->Nilai_UTS->TooltipValue = "";

        // Nilai_Akhir
        $this->Nilai_Akhir->HrefValue = "";
        $this->Nilai_Akhir->TooltipValue = "";

        // iduser
        $this->iduser->HrefValue = "";
        $this->iduser->TooltipValue = "";

        // user
        $this->user->HrefValue = "";
        $this->user->TooltipValue = "";

        // ip
        $this->ip->HrefValue = "";
        $this->ip->TooltipValue = "";

        // tanggal
        $this->tanggal->HrefValue = "";
        $this->tanggal->TooltipValue = "";

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
                    $doc->exportCaption($this->id_no);
                    $doc->exportCaption($this->Kode_MK);
                    $doc->exportCaption($this->NIM);
                    $doc->exportCaption($this->Nilai_Diskusi);
                    $doc->exportCaption($this->Assessment_Skor_As_1);
                    $doc->exportCaption($this->Assessment_Skor_As_2);
                    $doc->exportCaption($this->Assessment_Skor_As_3);
                    $doc->exportCaption($this->Nilai_Tugas);
                    $doc->exportCaption($this->Nilai_UTS);
                    $doc->exportCaption($this->Nilai_Akhir);
                    $doc->exportCaption($this->iduser);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->ip);
                    $doc->exportCaption($this->tanggal);
                } else {
                    $doc->exportCaption($this->id_no);
                    $doc->exportCaption($this->Kode_MK);
                    $doc->exportCaption($this->NIM);
                    $doc->exportCaption($this->Nilai_Diskusi);
                    $doc->exportCaption($this->Assessment_Skor_As_1);
                    $doc->exportCaption($this->Assessment_Skor_As_2);
                    $doc->exportCaption($this->Assessment_Skor_As_3);
                    $doc->exportCaption($this->Nilai_Tugas);
                    $doc->exportCaption($this->Nilai_UTS);
                    $doc->exportCaption($this->Nilai_Akhir);
                    $doc->exportCaption($this->iduser);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->ip);
                    $doc->exportCaption($this->tanggal);
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
						$doc->exportCaption($this->id_no);
						$doc->exportCaption($this->Kode_MK);
						$doc->exportCaption($this->NIM);
						$doc->exportCaption($this->Nilai_Diskusi);
						$doc->exportCaption($this->Assessment_Skor_As_1);
						$doc->exportCaption($this->Assessment_Skor_As_2);
						$doc->exportCaption($this->Assessment_Skor_As_3);
						$doc->exportCaption($this->Nilai_Tugas);
						$doc->exportCaption($this->Nilai_UTS);
						$doc->exportCaption($this->Nilai_Akhir);
						$doc->exportCaption($this->iduser);
						$doc->exportCaption($this->user);
						$doc->exportCaption($this->ip);
						$doc->exportCaption($this->tanggal);
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
                        $doc->exportField($this->id_no);
                        $doc->exportField($this->Kode_MK);
                        $doc->exportField($this->NIM);
                        $doc->exportField($this->Nilai_Diskusi);
                        $doc->exportField($this->Assessment_Skor_As_1);
                        $doc->exportField($this->Assessment_Skor_As_2);
                        $doc->exportField($this->Assessment_Skor_As_3);
                        $doc->exportField($this->Nilai_Tugas);
                        $doc->exportField($this->Nilai_UTS);
                        $doc->exportField($this->Nilai_Akhir);
                        $doc->exportField($this->iduser);
                        $doc->exportField($this->user);
                        $doc->exportField($this->ip);
                        $doc->exportField($this->tanggal);
                    } else {
                        $doc->exportField($this->id_no);
                        $doc->exportField($this->Kode_MK);
                        $doc->exportField($this->NIM);
                        $doc->exportField($this->Nilai_Diskusi);
                        $doc->exportField($this->Assessment_Skor_As_1);
                        $doc->exportField($this->Assessment_Skor_As_2);
                        $doc->exportField($this->Assessment_Skor_As_3);
                        $doc->exportField($this->Nilai_Tugas);
                        $doc->exportField($this->Nilai_UTS);
                        $doc->exportField($this->Nilai_Akhir);
                        $doc->exportField($this->iduser);
                        $doc->exportField($this->user);
                        $doc->exportField($this->ip);
                        $doc->exportField($this->tanggal);
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
