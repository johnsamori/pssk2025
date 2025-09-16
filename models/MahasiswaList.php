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
 * Page class
 */
class MahasiswaList extends Mahasiswa
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "list";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "MahasiswaList";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // Grid form hidden field names
    public string $FormName = "fmahasiswalist";

    // CSS class/style
    public string $CurrentPageName = "mahasiswalist";

    // Page URLs
    public string $AddUrl = "";
    public string $EditUrl = "";
    public string $DeleteUrl = "";
    public string $ViewUrl = "";
    public string $CopyUrl = "";
    public string $ListUrl = "";

    // Update URLs
    public string $InlineAddUrl = "";
    public string $InlineCopyUrl = "";
    public string $InlineEditUrl = "";
    public string $GridAddUrl = "";
    public string $GridEditUrl = "";
    public string $MultiEditUrl = "";
    public string $MultiDeleteUrl = "";
    public string $MultiUpdateUrl = "";

    // Page headings
    public string $Heading = "";
    public string $Subheading = "";
    public string $PageHeader = "";
    public string $PageFooter = "";

    // Page layout
    public bool $UseLayout = true;

    // Page terminated
    private bool $terminated = false;

    // Page heading
    public function pageHeading(): string
    {
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading(): string
    {
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return Language()->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName(): string
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl(bool $withArgs = true): string
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader(): void
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter(): void
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility(): void
    {
        $this->NIM->setVisibility();
        $this->Nama->setVisibility();
        $this->Jenis_Kelamin->setVisibility();
        $this->Provinsi_Tempat_Lahir->setVisibility();
        $this->Kota_Tempat_Lahir->setVisibility();
        $this->Tanggal_Lahir->setVisibility();
        $this->Golongan_Darah->setVisibility();
        $this->Tinggi_Badan->setVisibility();
        $this->Berat_Badan->setVisibility();
        $this->Asal_sekolah->setVisibility();
        $this->Tahun_Ijazah->setVisibility();
        $this->Nomor_Ijazah->setVisibility();
        $this->Nilai_Raport_Kelas_10->setVisibility();
        $this->Nilai_Raport_Kelas_11->setVisibility();
        $this->Nilai_Raport_Kelas_12->setVisibility();
        $this->Tanggal_Daftar->setVisibility();
        $this->No_Test->setVisibility();
        $this->Status_Masuk->setVisibility();
        $this->Jalur_Masuk->setVisibility();
        $this->Bukti_Lulus->setVisibility();
        $this->Tes_Potensi_Akademik->setVisibility();
        $this->Tes_Wawancara->setVisibility();
        $this->Tes_Kesehatan->setVisibility();
        $this->Hasil_Test_Kesehatan->setVisibility();
        $this->Test_MMPI->setVisibility();
        $this->Hasil_Test_MMPI->setVisibility();
        $this->Angkatan->setVisibility();
        $this->Tarif_SPP->setVisibility();
        $this->NIK_No_KTP->setVisibility();
        $this->No_KK->setVisibility();
        $this->NPWP->setVisibility();
        $this->Status_Nikah->setVisibility();
        $this->Kewarganegaraan->setVisibility();
        $this->Propinsi_Tempat_Tinggal->setVisibility();
        $this->Kota_Tempat_Tinggal->setVisibility();
        $this->Kecamatan_Tempat_Tinggal->setVisibility();
        $this->Alamat_Tempat_Tinggal->setVisibility();
        $this->RT->setVisibility();
        $this->RW->setVisibility();
        $this->Kelurahan->setVisibility();
        $this->Kode_Pos->setVisibility();
        $this->Nomor_Telpon_HP->setVisibility();
        $this->_Email->setVisibility();
        $this->Jenis_Tinggal->setVisibility();
        $this->Alat_Transportasi->setVisibility();
        $this->Sumber_Dana->setVisibility();
        $this->Sumber_Dana_Beasiswa->setVisibility();
        $this->Jumlah_Sudara->setVisibility();
        $this->Status_Bekerja->setVisibility();
        $this->Nomor_Asuransi->setVisibility();
        $this->Hobi->setVisibility();
        $this->Foto->setVisibility();
        $this->Nama_Ayah->setVisibility();
        $this->Pekerjaan_Ayah->setVisibility();
        $this->Nama_Ibu->setVisibility();
        $this->Pekerjaan_Ibu->setVisibility();
        $this->Alamat_Orang_Tua->setVisibility();
        $this->e_mail_Oranng_Tua->setVisibility();
        $this->No_Kontak_Orang_Tua->setVisibility();
        $this->userid->Visible = false;
        $this->user->Visible = false;
        $this->ip->Visible = false;
        $this->tanggal_input->Visible = false;
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'mahasiswa';
        $this->TableName = 'mahasiswa';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->TableGridClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Save if user language changed
        if (Param("language") !== null) {
            Profile()->setLanguageId(Param("language"))->saveToStorage();
        }

        // Table object (mahasiswa)
        if (!isset($GLOBALS["mahasiswa"]) || $GLOBALS["mahasiswa"]::class == PROJECT_NAMESPACE . "mahasiswa") {
            $GLOBALS["mahasiswa"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "mahasiswaadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "mahasiswadelete";
        $this->MultiUpdateUrl = "mahasiswaupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mahasiswa');
        }

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Import options
        $this->ImportOptions = new ListOptions(TagClassName: "ew-import-option");

        // Other options
        $this->OtherOptions = new ListOptionsCollection();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $this->language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions(
            TableVar: $this->TableVar,
            TagClassName: "ew-column-option",
            ButtonGroupClass: "ew-column-dropdown",
            UseDropDownButton: true,
            DropDownButtonPhrase: $this->language->phrase("Columns"),
            DropDownAutoClose: "outside",
            UseButtonGroup: false
        );

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");

        // List actions
        $this->ListActions = new ListActions();
    }

    // Is lookup
    public function isLookup(): bool
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill(): bool
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest(): bool
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup(): bool
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated(): bool
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string|bool $url URL for direction, true => show response for API
     * @return void
     */
    public function terminate(string|bool $url = ""): void
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (HasJsonResponse()) { // Has JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!IsDebug() && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "mahasiswaview"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                }
                WriteJson($result);
            } else {
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromResult(Result|array $result, bool $current = false): array
    {
        $rows = [];
        if ($result instanceof Result) { // Result
            while ($row = $result->fetchAssociative()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($result)) {
            foreach ($result as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray(array $ar): array
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (isset($this->Fields[$fldname]) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (IsEmpty($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->uploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->uploadPath() . $file)));
                                    if (!IsEmpty($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        if ($fld->DataType == DataType::MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue(array $ar): string
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['NIM'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit(): void
    {
        if ($this->isAddOrEdit()) {
            $this->userid->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->user->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->ip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->tanggal_input->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true): array|bool
    {
        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }

    // Class variables
    public ?ListOptions $ListOptions = null; // List options
    public ?ListOptions $ExportOptions = null; // Export options
    public ?ListOptions $SearchOptions = null; // Search options
    public ?ListOptionsCollection $OtherOptions = null; // Other options
    public ?ListOptions $HeaderOptions = null; // Header options
    public ?ListOptions $FooterOptions = null; // Footer options
    public ?ListOptions $FilterOptions = null; // Filter options
    public ?ListOptions $ImportOptions = null; // Import options
    public ?ListActions $ListActions = null; // List actions
    public int $SelectedCount = 0;
    public int $SelectedIndex = 0;
    public int $DisplayRecords = 20;
    public int $StartRecord = 0;
    public int $StopRecord = 0;
    public int $TotalRecords = 0;

    // Begin modification by Masino Sinaga, September 11, 2023
    // public $RecordRange = 10;
	public int $RecordRange = 10;

	// End modification by Masino Sinaga, September 11, 2023
    public string $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public string $DefaultSearchWhere = ""; // Default search WHERE clause
    public string $SearchWhere = ""; // Search WHERE clause
    public string $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public int $SearchColumnCount = 0; // For extended search
    public int $SearchFieldsPerRow = 1; // For extended search
    public int $RecordCount = 0; // Record count
    public int $InlineRowCount = 0;
    public int $StartRowCount = 1;
    public array $Attrs = []; // Row attributes and cell attributes
    public int|string $RowIndex = 0; // Row index
    public int $KeyCount = 0; // Key count
    public string $MultiColumnGridClass = "row-cols-md";
    public string $MultiColumnEditClass = "col-12 w-100";
    public string $MultiColumnCardClass = "card h-100 ew-card";
    public string $MultiColumnListOptionsPosition = "bottom-start";
    public ?string $DbMasterFilter = ""; // Master filter
    public string $DbDetailFilter = ""; // Detail filter
    public bool $MasterRecordExists = false;
    public string $MultiSelectKey = "";
    public string $Command = "";
    public string $UserAction = ""; // User action
    public bool $RestoreSearch = false;
    public ?string $HashValue = null; // Hash value
    public ?SubPages $DetailPages = null;
    public string $TopContentClass = "ew-top";
    public string $MiddleContentClass = "ew-middle";
    public string $BottomContentClass = "ew-bottom";
    public string $PageAction = "";
    public array $RecKeys = [];
    public bool $IsModal = false;
    protected string $FilterForModalActions = "";
    private bool $UseInfiniteScroll = false;

    /**
     * Load result set from filter
     *
     * @return void
     */
    public function loadRecordsetFromFilter(string $filter): void
    {
        // Set up list options
        $this->setupListOptions();

        // Search options
        $this->setupSearchOptions();

        // Other options
        $this->setupOtherOptions();

        // Set visibility
        $this->setVisibility();

        // Load result set
        $this->TotalRecords = $this->loadRecordCount($filter);
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords;
        $this->CurrentFilter = $filter;
        $this->Result = $this->loadResult();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
    }

    /**
     * Page run
     *
     * @return void
     */
    public function run(): void
    {
        global $ExportType, $DashboardReport;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));

// Is modal
        $this->IsModal = IsModal();

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

		// Call this new function from userfn*.php file
		My_Global_Check(); // Modified by Masino Sinaga, September 10, 2023

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

		// Begin of Compare Root URL by Masino Sinaga, September 10, 2023
		if (MS_ALWAYS_COMPARE_ROOT_URL == TRUE) {
			if (isset($_SESSION['pssk2025_Root_URL'])) {
				if ($_SESSION['pssk2025_Root_URL'] == MS_OTHER_COMPARED_ROOT_URL && $_SESSION['pssk2025_Root_URL'] <> "") {
					$this->setFailureMessage(str_replace("%s", MS_OTHER_COMPARED_ROOT_URL, Container("language")->phrase("NoPermission")));
					header("Location: " . $_SESSION['pssk2025_Root_URL']);
				}
			}
		}
		// End of Compare Root URL by Masino Sinaga, September 10, 2023

        // Setup other options
        $this->setupOtherOptions();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fmahasiswagrid";
        }

        // Set up page action
        $this->PageAction = CurrentPageUrl(false);

        // Set up infinite scroll
        $this->UseInfiniteScroll = ConvertToBool(Param("infinitescroll"));

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $query = ""; // Query builder

        // Set up Dashboard Filter
        if ($DashboardReport) {
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar));
        }

        // Get command
        $this->Command = strtolower(Get("cmd", ""));

        // Process list action first
        if ($this->processListAction()) { // Ajax request
            $this->terminate();
            return;
        }

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Hide list options
        if ($this->isExport()) {
            $this->ListOptions->hideAllOptions(["sequence"]);
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        } elseif ($this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit() || $this->isConfirm()) {
            $this->ListOptions->hideAllOptions();
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        }

        // Hide options
        if ($this->isExport() || !(IsEmpty($this->CurrentAction) || $this->isSearch())) {
            $this->ExportOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
            $this->ImportOptions->hideAllOptions();
        }

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Get default search criteria
        AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

        // Get basic search values
        if ($this->loadBasicSearchValues()) {
            $this->setSessionRules(""); // Clear rules for QueryBuilder
        }

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }

        // Restore search parms from Session if not searching / reset / export
        if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
            $this->restoreSearchParms();
        }

        // Call Records SearchValidated event
        $this->recordsSearchValidated();

        // Set up sorting order
        $this->setupSortOrder();

        // Get basic search criteria
        if (!$this->hasInvalidFields()) {
            $srchBasic = $this->basicSearchWhere();
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != 0) {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms() && !$query) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere(); // Save to session
            }
        }

        // Build search criteria
        if ($query) {
            AddFilter($this->SearchWhere, $query);
        } else {
            AddFilter($this->SearchWhere, $srchAdvanced);
            AddFilter($this->SearchWhere, $srchBasic);
        }

        // Call Records_Searching event
        $this->recordsSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json" && !$query) {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        if (!$this->security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $this->Filter;
        } else {
            $this->setSessionWhere($this->Filter);
            $this->CurrentFilter = "";
        }
        $this->Filter = $this->applyUserIDFilters($this->Filter);
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } elseif (($this->isEdit() || $this->isCopy() || $this->isInlineInserted() || $this->isInlineUpdated()) && $this->UseInfiniteScroll) { // Get current record only
            $this->CurrentFilter = $this->isInlineUpdated() ? $this->getRecordFilter() : $this->getFilterFromRecordKeys();
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Result = $this->loadResult();
        } elseif (
            $this->UseInfiniteScroll && $this->isGridInserted()
            || $this->UseInfiniteScroll && ($this->isGridEdit() || $this->isGridUpdated())
            || $this->isMultiEdit()
            || $this->UseInfiniteScroll && $this->isMultiUpdated()
        ) { // Get current records only
            $this->CurrentFilter = $this->FilterForModalActions; // Restore filter
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Result = $this->loadResult();
        } elseif (!(IsApi() && IsExport())) { // Skip loading records if export from API (to be done in exportData)
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) {
                $this->setupStartRecord(); // Set up start record position
            }
            $this->Result = $this->loadResult($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if ((IsEmpty($this->CurrentAction) || $this->isSearch()) && $this->TotalRecords == 0) {
                if (!$this->security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($this->language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($this->language->phrase("NoRecord"));
                }
            }
        }

        // Set up list action columns
        foreach ($this->ListActions as $listAction) {
            if ($listAction->getVisible()) {
                if ($listAction->Select == ActionType::MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listAction->Select == ActionType::SINGLE) { // Show list action column
                    $this->ListOptions["listactions"]->Visible = true;
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            if ($query) { // Hide search panel if using QueryBuilder
                RemoveClass($this->SearchPanelClass, "show");
            } else {
                AppendClass($this->SearchPanelClass, "show");
            }
        }

		// Begin of add Search Panel Status by Masino Sinaga, October 13, 2024
		if (ReadCookie('mahasiswa_searchpanel') == 'notactive' || ReadCookie('mahasiswa_searchpanel') == "") {
			RemoveClass($this->SearchPanelClass, "show");
			AppendClass($this->SearchPanelClass, "collapse");
		} elseif (ReadCookie('mahasiswa_searchpanel') == 'active') {
			RemoveClass($this->SearchPanelClass, "collapse");
			AppendClass($this->SearchPanelClass, "show");
		} else {
			RemoveClass($this->SearchPanelClass, "show");
			AppendClass($this->SearchPanelClass, "collapse");
		}

		// End of add Search Panel Status by Masino Sinaga, October 13, 2024

        // API list action
        if (IsApi()) {
            if (Route(0) == Config("API_LIST_ACTION")) {
                if (!$this->isExport()) {
                    $rows = $this->getRecordsFromResult($this->Result);
                    $this->Result?->free();
                    WriteJson([
                        "success" => true,
                        "action" => Config("API_LIST_ACTION"),
                        $this->TableVar => $rows,
                        "totalRecordCount" => $this->TotalRecords
                    ]);
                    $this->terminate(true);
                }
                return;
            } elseif ($this->peekFailureMessage()) {
                WriteJson(["error" => $this->getFailureMessage()]);
                $this->terminate(true);
                return;
            }
        }

        // Render other options
        $this->renderOtherOptions();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

		// Set up first record for Export Data purpose, by Masino Sinaga, September 11, 2023
		$first_rec = Session(AddTabId(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_START_REC")));
		$_SESSION["First_Record"] = $first_rec;

        // Set ReturnUrl in header if necessary
        if ($returnUrl = (FlashBag()->get("Return-Url")[0] ?? "")) {
            AddHeader("Return-Url", GetUrl($returnUrl));
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get page number
    public function getPageNumber(): int
    {
        return ($this->DisplayRecords > 0 && $this->StartRecord > 0) ? ceil($this->StartRecord / $this->DisplayRecords) : 1;
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords(): void
    {
        // Begin of modification Customize Navigation/Pager Panel, by Masino Sinaga, September 11, 2023
		global $Language;
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk > MS_TABLE_MAXIMUM_SELECTED_RECORDS || strtolower($wrk) == "all") {
            $wrk = MS_TABLE_MAXIMUM_SELECTED_RECORDS;
			if ($wrk > 0)
				$this->setFailureMessage(str_replace("%t", MS_TABLE_MAXIMUM_SELECTED_RECORDS, $Language->Phrase("MaximumRecordsPerPage")));
        }

		// End of modification Customize Navigation/Pager Panel, by Masino Sinaga, September 11, 2023
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter(): string
    {
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $this->FormIndex = $rowindex;
        $thisKey = $this->getOldKey();
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $this->FormIndex = $rowindex;
            $thisKey = $this->getOldKey();
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList(): string
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server") {
            $savedFilterList = Profile()->getSearchFilters("fmahasiswasrch");
        }
        $filterList = Concat($filterList, $this->NIM->AdvancedSearch->toJson(), ","); // Field NIM
        $filterList = Concat($filterList, $this->Nama->AdvancedSearch->toJson(), ","); // Field Nama
        $filterList = Concat($filterList, $this->Jenis_Kelamin->AdvancedSearch->toJson(), ","); // Field Jenis_Kelamin
        $filterList = Concat($filterList, $this->Provinsi_Tempat_Lahir->AdvancedSearch->toJson(), ","); // Field Provinsi_Tempat_Lahir
        $filterList = Concat($filterList, $this->Kota_Tempat_Lahir->AdvancedSearch->toJson(), ","); // Field Kota_Tempat_Lahir
        $filterList = Concat($filterList, $this->Tanggal_Lahir->AdvancedSearch->toJson(), ","); // Field Tanggal_Lahir
        $filterList = Concat($filterList, $this->Golongan_Darah->AdvancedSearch->toJson(), ","); // Field Golongan_Darah
        $filterList = Concat($filterList, $this->Tinggi_Badan->AdvancedSearch->toJson(), ","); // Field Tinggi_Badan
        $filterList = Concat($filterList, $this->Berat_Badan->AdvancedSearch->toJson(), ","); // Field Berat_Badan
        $filterList = Concat($filterList, $this->Asal_sekolah->AdvancedSearch->toJson(), ","); // Field Asal_sekolah
        $filterList = Concat($filterList, $this->Tahun_Ijazah->AdvancedSearch->toJson(), ","); // Field Tahun_Ijazah
        $filterList = Concat($filterList, $this->Nomor_Ijazah->AdvancedSearch->toJson(), ","); // Field Nomor_Ijazah
        $filterList = Concat($filterList, $this->Nilai_Raport_Kelas_10->AdvancedSearch->toJson(), ","); // Field Nilai_Raport_Kelas_10
        $filterList = Concat($filterList, $this->Nilai_Raport_Kelas_11->AdvancedSearch->toJson(), ","); // Field Nilai_Raport_Kelas_11
        $filterList = Concat($filterList, $this->Nilai_Raport_Kelas_12->AdvancedSearch->toJson(), ","); // Field Nilai_Raport_Kelas_12
        $filterList = Concat($filterList, $this->Tanggal_Daftar->AdvancedSearch->toJson(), ","); // Field Tanggal_Daftar
        $filterList = Concat($filterList, $this->No_Test->AdvancedSearch->toJson(), ","); // Field No_Test
        $filterList = Concat($filterList, $this->Status_Masuk->AdvancedSearch->toJson(), ","); // Field Status_Masuk
        $filterList = Concat($filterList, $this->Jalur_Masuk->AdvancedSearch->toJson(), ","); // Field Jalur_Masuk
        $filterList = Concat($filterList, $this->Bukti_Lulus->AdvancedSearch->toJson(), ","); // Field Bukti_Lulus
        $filterList = Concat($filterList, $this->Tes_Potensi_Akademik->AdvancedSearch->toJson(), ","); // Field Tes_Potensi_Akademik
        $filterList = Concat($filterList, $this->Tes_Wawancara->AdvancedSearch->toJson(), ","); // Field Tes_Wawancara
        $filterList = Concat($filterList, $this->Tes_Kesehatan->AdvancedSearch->toJson(), ","); // Field Tes_Kesehatan
        $filterList = Concat($filterList, $this->Hasil_Test_Kesehatan->AdvancedSearch->toJson(), ","); // Field Hasil_Test_Kesehatan
        $filterList = Concat($filterList, $this->Test_MMPI->AdvancedSearch->toJson(), ","); // Field Test_MMPI
        $filterList = Concat($filterList, $this->Hasil_Test_MMPI->AdvancedSearch->toJson(), ","); // Field Hasil_Test_MMPI
        $filterList = Concat($filterList, $this->Angkatan->AdvancedSearch->toJson(), ","); // Field Angkatan
        $filterList = Concat($filterList, $this->Tarif_SPP->AdvancedSearch->toJson(), ","); // Field Tarif_SPP
        $filterList = Concat($filterList, $this->NIK_No_KTP->AdvancedSearch->toJson(), ","); // Field NIK_No_KTP
        $filterList = Concat($filterList, $this->No_KK->AdvancedSearch->toJson(), ","); // Field No_KK
        $filterList = Concat($filterList, $this->NPWP->AdvancedSearch->toJson(), ","); // Field NPWP
        $filterList = Concat($filterList, $this->Status_Nikah->AdvancedSearch->toJson(), ","); // Field Status_Nikah
        $filterList = Concat($filterList, $this->Kewarganegaraan->AdvancedSearch->toJson(), ","); // Field Kewarganegaraan
        $filterList = Concat($filterList, $this->Propinsi_Tempat_Tinggal->AdvancedSearch->toJson(), ","); // Field Propinsi_Tempat_Tinggal
        $filterList = Concat($filterList, $this->Kota_Tempat_Tinggal->AdvancedSearch->toJson(), ","); // Field Kota_Tempat_Tinggal
        $filterList = Concat($filterList, $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->toJson(), ","); // Field Kecamatan_Tempat_Tinggal
        $filterList = Concat($filterList, $this->Alamat_Tempat_Tinggal->AdvancedSearch->toJson(), ","); // Field Alamat_Tempat_Tinggal
        $filterList = Concat($filterList, $this->RT->AdvancedSearch->toJson(), ","); // Field RT
        $filterList = Concat($filterList, $this->RW->AdvancedSearch->toJson(), ","); // Field RW
        $filterList = Concat($filterList, $this->Kelurahan->AdvancedSearch->toJson(), ","); // Field Kelurahan
        $filterList = Concat($filterList, $this->Kode_Pos->AdvancedSearch->toJson(), ","); // Field Kode_Pos
        $filterList = Concat($filterList, $this->Nomor_Telpon_HP->AdvancedSearch->toJson(), ","); // Field Nomor_Telpon_HP
        $filterList = Concat($filterList, $this->_Email->AdvancedSearch->toJson(), ","); // Field Email
        $filterList = Concat($filterList, $this->Jenis_Tinggal->AdvancedSearch->toJson(), ","); // Field Jenis_Tinggal
        $filterList = Concat($filterList, $this->Alat_Transportasi->AdvancedSearch->toJson(), ","); // Field Alat_Transportasi
        $filterList = Concat($filterList, $this->Sumber_Dana->AdvancedSearch->toJson(), ","); // Field Sumber_Dana
        $filterList = Concat($filterList, $this->Sumber_Dana_Beasiswa->AdvancedSearch->toJson(), ","); // Field Sumber_Dana_Beasiswa
        $filterList = Concat($filterList, $this->Jumlah_Sudara->AdvancedSearch->toJson(), ","); // Field Jumlah_Sudara
        $filterList = Concat($filterList, $this->Status_Bekerja->AdvancedSearch->toJson(), ","); // Field Status_Bekerja
        $filterList = Concat($filterList, $this->Nomor_Asuransi->AdvancedSearch->toJson(), ","); // Field Nomor_Asuransi
        $filterList = Concat($filterList, $this->Hobi->AdvancedSearch->toJson(), ","); // Field Hobi
        $filterList = Concat($filterList, $this->Foto->AdvancedSearch->toJson(), ","); // Field Foto
        $filterList = Concat($filterList, $this->Nama_Ayah->AdvancedSearch->toJson(), ","); // Field Nama_Ayah
        $filterList = Concat($filterList, $this->Pekerjaan_Ayah->AdvancedSearch->toJson(), ","); // Field Pekerjaan_Ayah
        $filterList = Concat($filterList, $this->Nama_Ibu->AdvancedSearch->toJson(), ","); // Field Nama_Ibu
        $filterList = Concat($filterList, $this->Pekerjaan_Ibu->AdvancedSearch->toJson(), ","); // Field Pekerjaan_Ibu
        $filterList = Concat($filterList, $this->Alamat_Orang_Tua->AdvancedSearch->toJson(), ","); // Field Alamat_Orang_Tua
        $filterList = Concat($filterList, $this->e_mail_Oranng_Tua->AdvancedSearch->toJson(), ","); // Field e_mail_Oranng_Tua
        $filterList = Concat($filterList, $this->No_Kontak_Orang_Tua->AdvancedSearch->toJson(), ","); // Field No_Kontak_Orang_Tua
        $filterList = Concat($filterList, $this->userid->AdvancedSearch->toJson(), ","); // Field userid
        $filterList = Concat($filterList, $this->user->AdvancedSearch->toJson(), ","); // Field user
        $filterList = Concat($filterList, $this->ip->AdvancedSearch->toJson(), ","); // Field ip
        $filterList = Concat($filterList, $this->tanggal_input->AdvancedSearch->toJson(), ","); // Field tanggal_input
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList(): bool
    {
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            Profile()->setSearchFilters("fmahasiswasrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList(): void
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field NIM
        $this->NIM->AdvancedSearch->SearchValue = $filter["x_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchOperator = $filter["z_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchCondition = $filter["v_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchValue2 = $filter["y_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchOperator2 = $filter["w_NIM"] ?? "";
        $this->NIM->AdvancedSearch->save();

        // Field Nama
        $this->Nama->AdvancedSearch->SearchValue = $filter["x_Nama"] ?? "";
        $this->Nama->AdvancedSearch->SearchOperator = $filter["z_Nama"] ?? "";
        $this->Nama->AdvancedSearch->SearchCondition = $filter["v_Nama"] ?? "";
        $this->Nama->AdvancedSearch->SearchValue2 = $filter["y_Nama"] ?? "";
        $this->Nama->AdvancedSearch->SearchOperator2 = $filter["w_Nama"] ?? "";
        $this->Nama->AdvancedSearch->save();

        // Field Jenis_Kelamin
        $this->Jenis_Kelamin->AdvancedSearch->SearchValue = $filter["x_Jenis_Kelamin"] ?? "";
        $this->Jenis_Kelamin->AdvancedSearch->SearchOperator = $filter["z_Jenis_Kelamin"] ?? "";
        $this->Jenis_Kelamin->AdvancedSearch->SearchCondition = $filter["v_Jenis_Kelamin"] ?? "";
        $this->Jenis_Kelamin->AdvancedSearch->SearchValue2 = $filter["y_Jenis_Kelamin"] ?? "";
        $this->Jenis_Kelamin->AdvancedSearch->SearchOperator2 = $filter["w_Jenis_Kelamin"] ?? "";
        $this->Jenis_Kelamin->AdvancedSearch->save();

        // Field Provinsi_Tempat_Lahir
        $this->Provinsi_Tempat_Lahir->AdvancedSearch->SearchValue = $filter["x_Provinsi_Tempat_Lahir"] ?? "";
        $this->Provinsi_Tempat_Lahir->AdvancedSearch->SearchOperator = $filter["z_Provinsi_Tempat_Lahir"] ?? "";
        $this->Provinsi_Tempat_Lahir->AdvancedSearch->SearchCondition = $filter["v_Provinsi_Tempat_Lahir"] ?? "";
        $this->Provinsi_Tempat_Lahir->AdvancedSearch->SearchValue2 = $filter["y_Provinsi_Tempat_Lahir"] ?? "";
        $this->Provinsi_Tempat_Lahir->AdvancedSearch->SearchOperator2 = $filter["w_Provinsi_Tempat_Lahir"] ?? "";
        $this->Provinsi_Tempat_Lahir->AdvancedSearch->save();

        // Field Kota_Tempat_Lahir
        $this->Kota_Tempat_Lahir->AdvancedSearch->SearchValue = $filter["x_Kota_Tempat_Lahir"] ?? "";
        $this->Kota_Tempat_Lahir->AdvancedSearch->SearchOperator = $filter["z_Kota_Tempat_Lahir"] ?? "";
        $this->Kota_Tempat_Lahir->AdvancedSearch->SearchCondition = $filter["v_Kota_Tempat_Lahir"] ?? "";
        $this->Kota_Tempat_Lahir->AdvancedSearch->SearchValue2 = $filter["y_Kota_Tempat_Lahir"] ?? "";
        $this->Kota_Tempat_Lahir->AdvancedSearch->SearchOperator2 = $filter["w_Kota_Tempat_Lahir"] ?? "";
        $this->Kota_Tempat_Lahir->AdvancedSearch->save();

        // Field Tanggal_Lahir
        $this->Tanggal_Lahir->AdvancedSearch->SearchValue = $filter["x_Tanggal_Lahir"] ?? "";
        $this->Tanggal_Lahir->AdvancedSearch->SearchOperator = $filter["z_Tanggal_Lahir"] ?? "";
        $this->Tanggal_Lahir->AdvancedSearch->SearchCondition = $filter["v_Tanggal_Lahir"] ?? "";
        $this->Tanggal_Lahir->AdvancedSearch->SearchValue2 = $filter["y_Tanggal_Lahir"] ?? "";
        $this->Tanggal_Lahir->AdvancedSearch->SearchOperator2 = $filter["w_Tanggal_Lahir"] ?? "";
        $this->Tanggal_Lahir->AdvancedSearch->save();

        // Field Golongan_Darah
        $this->Golongan_Darah->AdvancedSearch->SearchValue = $filter["x_Golongan_Darah"] ?? "";
        $this->Golongan_Darah->AdvancedSearch->SearchOperator = $filter["z_Golongan_Darah"] ?? "";
        $this->Golongan_Darah->AdvancedSearch->SearchCondition = $filter["v_Golongan_Darah"] ?? "";
        $this->Golongan_Darah->AdvancedSearch->SearchValue2 = $filter["y_Golongan_Darah"] ?? "";
        $this->Golongan_Darah->AdvancedSearch->SearchOperator2 = $filter["w_Golongan_Darah"] ?? "";
        $this->Golongan_Darah->AdvancedSearch->save();

        // Field Tinggi_Badan
        $this->Tinggi_Badan->AdvancedSearch->SearchValue = $filter["x_Tinggi_Badan"] ?? "";
        $this->Tinggi_Badan->AdvancedSearch->SearchOperator = $filter["z_Tinggi_Badan"] ?? "";
        $this->Tinggi_Badan->AdvancedSearch->SearchCondition = $filter["v_Tinggi_Badan"] ?? "";
        $this->Tinggi_Badan->AdvancedSearch->SearchValue2 = $filter["y_Tinggi_Badan"] ?? "";
        $this->Tinggi_Badan->AdvancedSearch->SearchOperator2 = $filter["w_Tinggi_Badan"] ?? "";
        $this->Tinggi_Badan->AdvancedSearch->save();

        // Field Berat_Badan
        $this->Berat_Badan->AdvancedSearch->SearchValue = $filter["x_Berat_Badan"] ?? "";
        $this->Berat_Badan->AdvancedSearch->SearchOperator = $filter["z_Berat_Badan"] ?? "";
        $this->Berat_Badan->AdvancedSearch->SearchCondition = $filter["v_Berat_Badan"] ?? "";
        $this->Berat_Badan->AdvancedSearch->SearchValue2 = $filter["y_Berat_Badan"] ?? "";
        $this->Berat_Badan->AdvancedSearch->SearchOperator2 = $filter["w_Berat_Badan"] ?? "";
        $this->Berat_Badan->AdvancedSearch->save();

        // Field Asal_sekolah
        $this->Asal_sekolah->AdvancedSearch->SearchValue = $filter["x_Asal_sekolah"] ?? "";
        $this->Asal_sekolah->AdvancedSearch->SearchOperator = $filter["z_Asal_sekolah"] ?? "";
        $this->Asal_sekolah->AdvancedSearch->SearchCondition = $filter["v_Asal_sekolah"] ?? "";
        $this->Asal_sekolah->AdvancedSearch->SearchValue2 = $filter["y_Asal_sekolah"] ?? "";
        $this->Asal_sekolah->AdvancedSearch->SearchOperator2 = $filter["w_Asal_sekolah"] ?? "";
        $this->Asal_sekolah->AdvancedSearch->save();

        // Field Tahun_Ijazah
        $this->Tahun_Ijazah->AdvancedSearch->SearchValue = $filter["x_Tahun_Ijazah"] ?? "";
        $this->Tahun_Ijazah->AdvancedSearch->SearchOperator = $filter["z_Tahun_Ijazah"] ?? "";
        $this->Tahun_Ijazah->AdvancedSearch->SearchCondition = $filter["v_Tahun_Ijazah"] ?? "";
        $this->Tahun_Ijazah->AdvancedSearch->SearchValue2 = $filter["y_Tahun_Ijazah"] ?? "";
        $this->Tahun_Ijazah->AdvancedSearch->SearchOperator2 = $filter["w_Tahun_Ijazah"] ?? "";
        $this->Tahun_Ijazah->AdvancedSearch->save();

        // Field Nomor_Ijazah
        $this->Nomor_Ijazah->AdvancedSearch->SearchValue = $filter["x_Nomor_Ijazah"] ?? "";
        $this->Nomor_Ijazah->AdvancedSearch->SearchOperator = $filter["z_Nomor_Ijazah"] ?? "";
        $this->Nomor_Ijazah->AdvancedSearch->SearchCondition = $filter["v_Nomor_Ijazah"] ?? "";
        $this->Nomor_Ijazah->AdvancedSearch->SearchValue2 = $filter["y_Nomor_Ijazah"] ?? "";
        $this->Nomor_Ijazah->AdvancedSearch->SearchOperator2 = $filter["w_Nomor_Ijazah"] ?? "";
        $this->Nomor_Ijazah->AdvancedSearch->save();

        // Field Nilai_Raport_Kelas_10
        $this->Nilai_Raport_Kelas_10->AdvancedSearch->SearchValue = $filter["x_Nilai_Raport_Kelas_10"] ?? "";
        $this->Nilai_Raport_Kelas_10->AdvancedSearch->SearchOperator = $filter["z_Nilai_Raport_Kelas_10"] ?? "";
        $this->Nilai_Raport_Kelas_10->AdvancedSearch->SearchCondition = $filter["v_Nilai_Raport_Kelas_10"] ?? "";
        $this->Nilai_Raport_Kelas_10->AdvancedSearch->SearchValue2 = $filter["y_Nilai_Raport_Kelas_10"] ?? "";
        $this->Nilai_Raport_Kelas_10->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_Raport_Kelas_10"] ?? "";
        $this->Nilai_Raport_Kelas_10->AdvancedSearch->save();

        // Field Nilai_Raport_Kelas_11
        $this->Nilai_Raport_Kelas_11->AdvancedSearch->SearchValue = $filter["x_Nilai_Raport_Kelas_11"] ?? "";
        $this->Nilai_Raport_Kelas_11->AdvancedSearch->SearchOperator = $filter["z_Nilai_Raport_Kelas_11"] ?? "";
        $this->Nilai_Raport_Kelas_11->AdvancedSearch->SearchCondition = $filter["v_Nilai_Raport_Kelas_11"] ?? "";
        $this->Nilai_Raport_Kelas_11->AdvancedSearch->SearchValue2 = $filter["y_Nilai_Raport_Kelas_11"] ?? "";
        $this->Nilai_Raport_Kelas_11->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_Raport_Kelas_11"] ?? "";
        $this->Nilai_Raport_Kelas_11->AdvancedSearch->save();

        // Field Nilai_Raport_Kelas_12
        $this->Nilai_Raport_Kelas_12->AdvancedSearch->SearchValue = $filter["x_Nilai_Raport_Kelas_12"] ?? "";
        $this->Nilai_Raport_Kelas_12->AdvancedSearch->SearchOperator = $filter["z_Nilai_Raport_Kelas_12"] ?? "";
        $this->Nilai_Raport_Kelas_12->AdvancedSearch->SearchCondition = $filter["v_Nilai_Raport_Kelas_12"] ?? "";
        $this->Nilai_Raport_Kelas_12->AdvancedSearch->SearchValue2 = $filter["y_Nilai_Raport_Kelas_12"] ?? "";
        $this->Nilai_Raport_Kelas_12->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_Raport_Kelas_12"] ?? "";
        $this->Nilai_Raport_Kelas_12->AdvancedSearch->save();

        // Field Tanggal_Daftar
        $this->Tanggal_Daftar->AdvancedSearch->SearchValue = $filter["x_Tanggal_Daftar"] ?? "";
        $this->Tanggal_Daftar->AdvancedSearch->SearchOperator = $filter["z_Tanggal_Daftar"] ?? "";
        $this->Tanggal_Daftar->AdvancedSearch->SearchCondition = $filter["v_Tanggal_Daftar"] ?? "";
        $this->Tanggal_Daftar->AdvancedSearch->SearchValue2 = $filter["y_Tanggal_Daftar"] ?? "";
        $this->Tanggal_Daftar->AdvancedSearch->SearchOperator2 = $filter["w_Tanggal_Daftar"] ?? "";
        $this->Tanggal_Daftar->AdvancedSearch->save();

        // Field No_Test
        $this->No_Test->AdvancedSearch->SearchValue = $filter["x_No_Test"] ?? "";
        $this->No_Test->AdvancedSearch->SearchOperator = $filter["z_No_Test"] ?? "";
        $this->No_Test->AdvancedSearch->SearchCondition = $filter["v_No_Test"] ?? "";
        $this->No_Test->AdvancedSearch->SearchValue2 = $filter["y_No_Test"] ?? "";
        $this->No_Test->AdvancedSearch->SearchOperator2 = $filter["w_No_Test"] ?? "";
        $this->No_Test->AdvancedSearch->save();

        // Field Status_Masuk
        $this->Status_Masuk->AdvancedSearch->SearchValue = $filter["x_Status_Masuk"] ?? "";
        $this->Status_Masuk->AdvancedSearch->SearchOperator = $filter["z_Status_Masuk"] ?? "";
        $this->Status_Masuk->AdvancedSearch->SearchCondition = $filter["v_Status_Masuk"] ?? "";
        $this->Status_Masuk->AdvancedSearch->SearchValue2 = $filter["y_Status_Masuk"] ?? "";
        $this->Status_Masuk->AdvancedSearch->SearchOperator2 = $filter["w_Status_Masuk"] ?? "";
        $this->Status_Masuk->AdvancedSearch->save();

        // Field Jalur_Masuk
        $this->Jalur_Masuk->AdvancedSearch->SearchValue = $filter["x_Jalur_Masuk"] ?? "";
        $this->Jalur_Masuk->AdvancedSearch->SearchOperator = $filter["z_Jalur_Masuk"] ?? "";
        $this->Jalur_Masuk->AdvancedSearch->SearchCondition = $filter["v_Jalur_Masuk"] ?? "";
        $this->Jalur_Masuk->AdvancedSearch->SearchValue2 = $filter["y_Jalur_Masuk"] ?? "";
        $this->Jalur_Masuk->AdvancedSearch->SearchOperator2 = $filter["w_Jalur_Masuk"] ?? "";
        $this->Jalur_Masuk->AdvancedSearch->save();

        // Field Bukti_Lulus
        $this->Bukti_Lulus->AdvancedSearch->SearchValue = $filter["x_Bukti_Lulus"] ?? "";
        $this->Bukti_Lulus->AdvancedSearch->SearchOperator = $filter["z_Bukti_Lulus"] ?? "";
        $this->Bukti_Lulus->AdvancedSearch->SearchCondition = $filter["v_Bukti_Lulus"] ?? "";
        $this->Bukti_Lulus->AdvancedSearch->SearchValue2 = $filter["y_Bukti_Lulus"] ?? "";
        $this->Bukti_Lulus->AdvancedSearch->SearchOperator2 = $filter["w_Bukti_Lulus"] ?? "";
        $this->Bukti_Lulus->AdvancedSearch->save();

        // Field Tes_Potensi_Akademik
        $this->Tes_Potensi_Akademik->AdvancedSearch->SearchValue = $filter["x_Tes_Potensi_Akademik"] ?? "";
        $this->Tes_Potensi_Akademik->AdvancedSearch->SearchOperator = $filter["z_Tes_Potensi_Akademik"] ?? "";
        $this->Tes_Potensi_Akademik->AdvancedSearch->SearchCondition = $filter["v_Tes_Potensi_Akademik"] ?? "";
        $this->Tes_Potensi_Akademik->AdvancedSearch->SearchValue2 = $filter["y_Tes_Potensi_Akademik"] ?? "";
        $this->Tes_Potensi_Akademik->AdvancedSearch->SearchOperator2 = $filter["w_Tes_Potensi_Akademik"] ?? "";
        $this->Tes_Potensi_Akademik->AdvancedSearch->save();

        // Field Tes_Wawancara
        $this->Tes_Wawancara->AdvancedSearch->SearchValue = $filter["x_Tes_Wawancara"] ?? "";
        $this->Tes_Wawancara->AdvancedSearch->SearchOperator = $filter["z_Tes_Wawancara"] ?? "";
        $this->Tes_Wawancara->AdvancedSearch->SearchCondition = $filter["v_Tes_Wawancara"] ?? "";
        $this->Tes_Wawancara->AdvancedSearch->SearchValue2 = $filter["y_Tes_Wawancara"] ?? "";
        $this->Tes_Wawancara->AdvancedSearch->SearchOperator2 = $filter["w_Tes_Wawancara"] ?? "";
        $this->Tes_Wawancara->AdvancedSearch->save();

        // Field Tes_Kesehatan
        $this->Tes_Kesehatan->AdvancedSearch->SearchValue = $filter["x_Tes_Kesehatan"] ?? "";
        $this->Tes_Kesehatan->AdvancedSearch->SearchOperator = $filter["z_Tes_Kesehatan"] ?? "";
        $this->Tes_Kesehatan->AdvancedSearch->SearchCondition = $filter["v_Tes_Kesehatan"] ?? "";
        $this->Tes_Kesehatan->AdvancedSearch->SearchValue2 = $filter["y_Tes_Kesehatan"] ?? "";
        $this->Tes_Kesehatan->AdvancedSearch->SearchOperator2 = $filter["w_Tes_Kesehatan"] ?? "";
        $this->Tes_Kesehatan->AdvancedSearch->save();

        // Field Hasil_Test_Kesehatan
        $this->Hasil_Test_Kesehatan->AdvancedSearch->SearchValue = $filter["x_Hasil_Test_Kesehatan"] ?? "";
        $this->Hasil_Test_Kesehatan->AdvancedSearch->SearchOperator = $filter["z_Hasil_Test_Kesehatan"] ?? "";
        $this->Hasil_Test_Kesehatan->AdvancedSearch->SearchCondition = $filter["v_Hasil_Test_Kesehatan"] ?? "";
        $this->Hasil_Test_Kesehatan->AdvancedSearch->SearchValue2 = $filter["y_Hasil_Test_Kesehatan"] ?? "";
        $this->Hasil_Test_Kesehatan->AdvancedSearch->SearchOperator2 = $filter["w_Hasil_Test_Kesehatan"] ?? "";
        $this->Hasil_Test_Kesehatan->AdvancedSearch->save();

        // Field Test_MMPI
        $this->Test_MMPI->AdvancedSearch->SearchValue = $filter["x_Test_MMPI"] ?? "";
        $this->Test_MMPI->AdvancedSearch->SearchOperator = $filter["z_Test_MMPI"] ?? "";
        $this->Test_MMPI->AdvancedSearch->SearchCondition = $filter["v_Test_MMPI"] ?? "";
        $this->Test_MMPI->AdvancedSearch->SearchValue2 = $filter["y_Test_MMPI"] ?? "";
        $this->Test_MMPI->AdvancedSearch->SearchOperator2 = $filter["w_Test_MMPI"] ?? "";
        $this->Test_MMPI->AdvancedSearch->save();

        // Field Hasil_Test_MMPI
        $this->Hasil_Test_MMPI->AdvancedSearch->SearchValue = $filter["x_Hasil_Test_MMPI"] ?? "";
        $this->Hasil_Test_MMPI->AdvancedSearch->SearchOperator = $filter["z_Hasil_Test_MMPI"] ?? "";
        $this->Hasil_Test_MMPI->AdvancedSearch->SearchCondition = $filter["v_Hasil_Test_MMPI"] ?? "";
        $this->Hasil_Test_MMPI->AdvancedSearch->SearchValue2 = $filter["y_Hasil_Test_MMPI"] ?? "";
        $this->Hasil_Test_MMPI->AdvancedSearch->SearchOperator2 = $filter["w_Hasil_Test_MMPI"] ?? "";
        $this->Hasil_Test_MMPI->AdvancedSearch->save();

        // Field Angkatan
        $this->Angkatan->AdvancedSearch->SearchValue = $filter["x_Angkatan"] ?? "";
        $this->Angkatan->AdvancedSearch->SearchOperator = $filter["z_Angkatan"] ?? "";
        $this->Angkatan->AdvancedSearch->SearchCondition = $filter["v_Angkatan"] ?? "";
        $this->Angkatan->AdvancedSearch->SearchValue2 = $filter["y_Angkatan"] ?? "";
        $this->Angkatan->AdvancedSearch->SearchOperator2 = $filter["w_Angkatan"] ?? "";
        $this->Angkatan->AdvancedSearch->save();

        // Field Tarif_SPP
        $this->Tarif_SPP->AdvancedSearch->SearchValue = $filter["x_Tarif_SPP"] ?? "";
        $this->Tarif_SPP->AdvancedSearch->SearchOperator = $filter["z_Tarif_SPP"] ?? "";
        $this->Tarif_SPP->AdvancedSearch->SearchCondition = $filter["v_Tarif_SPP"] ?? "";
        $this->Tarif_SPP->AdvancedSearch->SearchValue2 = $filter["y_Tarif_SPP"] ?? "";
        $this->Tarif_SPP->AdvancedSearch->SearchOperator2 = $filter["w_Tarif_SPP"] ?? "";
        $this->Tarif_SPP->AdvancedSearch->save();

        // Field NIK_No_KTP
        $this->NIK_No_KTP->AdvancedSearch->SearchValue = $filter["x_NIK_No_KTP"] ?? "";
        $this->NIK_No_KTP->AdvancedSearch->SearchOperator = $filter["z_NIK_No_KTP"] ?? "";
        $this->NIK_No_KTP->AdvancedSearch->SearchCondition = $filter["v_NIK_No_KTP"] ?? "";
        $this->NIK_No_KTP->AdvancedSearch->SearchValue2 = $filter["y_NIK_No_KTP"] ?? "";
        $this->NIK_No_KTP->AdvancedSearch->SearchOperator2 = $filter["w_NIK_No_KTP"] ?? "";
        $this->NIK_No_KTP->AdvancedSearch->save();

        // Field No_KK
        $this->No_KK->AdvancedSearch->SearchValue = $filter["x_No_KK"] ?? "";
        $this->No_KK->AdvancedSearch->SearchOperator = $filter["z_No_KK"] ?? "";
        $this->No_KK->AdvancedSearch->SearchCondition = $filter["v_No_KK"] ?? "";
        $this->No_KK->AdvancedSearch->SearchValue2 = $filter["y_No_KK"] ?? "";
        $this->No_KK->AdvancedSearch->SearchOperator2 = $filter["w_No_KK"] ?? "";
        $this->No_KK->AdvancedSearch->save();

        // Field NPWP
        $this->NPWP->AdvancedSearch->SearchValue = $filter["x_NPWP"] ?? "";
        $this->NPWP->AdvancedSearch->SearchOperator = $filter["z_NPWP"] ?? "";
        $this->NPWP->AdvancedSearch->SearchCondition = $filter["v_NPWP"] ?? "";
        $this->NPWP->AdvancedSearch->SearchValue2 = $filter["y_NPWP"] ?? "";
        $this->NPWP->AdvancedSearch->SearchOperator2 = $filter["w_NPWP"] ?? "";
        $this->NPWP->AdvancedSearch->save();

        // Field Status_Nikah
        $this->Status_Nikah->AdvancedSearch->SearchValue = $filter["x_Status_Nikah"] ?? "";
        $this->Status_Nikah->AdvancedSearch->SearchOperator = $filter["z_Status_Nikah"] ?? "";
        $this->Status_Nikah->AdvancedSearch->SearchCondition = $filter["v_Status_Nikah"] ?? "";
        $this->Status_Nikah->AdvancedSearch->SearchValue2 = $filter["y_Status_Nikah"] ?? "";
        $this->Status_Nikah->AdvancedSearch->SearchOperator2 = $filter["w_Status_Nikah"] ?? "";
        $this->Status_Nikah->AdvancedSearch->save();

        // Field Kewarganegaraan
        $this->Kewarganegaraan->AdvancedSearch->SearchValue = $filter["x_Kewarganegaraan"] ?? "";
        $this->Kewarganegaraan->AdvancedSearch->SearchOperator = $filter["z_Kewarganegaraan"] ?? "";
        $this->Kewarganegaraan->AdvancedSearch->SearchCondition = $filter["v_Kewarganegaraan"] ?? "";
        $this->Kewarganegaraan->AdvancedSearch->SearchValue2 = $filter["y_Kewarganegaraan"] ?? "";
        $this->Kewarganegaraan->AdvancedSearch->SearchOperator2 = $filter["w_Kewarganegaraan"] ?? "";
        $this->Kewarganegaraan->AdvancedSearch->save();

        // Field Propinsi_Tempat_Tinggal
        $this->Propinsi_Tempat_Tinggal->AdvancedSearch->SearchValue = $filter["x_Propinsi_Tempat_Tinggal"] ?? "";
        $this->Propinsi_Tempat_Tinggal->AdvancedSearch->SearchOperator = $filter["z_Propinsi_Tempat_Tinggal"] ?? "";
        $this->Propinsi_Tempat_Tinggal->AdvancedSearch->SearchCondition = $filter["v_Propinsi_Tempat_Tinggal"] ?? "";
        $this->Propinsi_Tempat_Tinggal->AdvancedSearch->SearchValue2 = $filter["y_Propinsi_Tempat_Tinggal"] ?? "";
        $this->Propinsi_Tempat_Tinggal->AdvancedSearch->SearchOperator2 = $filter["w_Propinsi_Tempat_Tinggal"] ?? "";
        $this->Propinsi_Tempat_Tinggal->AdvancedSearch->save();

        // Field Kota_Tempat_Tinggal
        $this->Kota_Tempat_Tinggal->AdvancedSearch->SearchValue = $filter["x_Kota_Tempat_Tinggal"] ?? "";
        $this->Kota_Tempat_Tinggal->AdvancedSearch->SearchOperator = $filter["z_Kota_Tempat_Tinggal"] ?? "";
        $this->Kota_Tempat_Tinggal->AdvancedSearch->SearchCondition = $filter["v_Kota_Tempat_Tinggal"] ?? "";
        $this->Kota_Tempat_Tinggal->AdvancedSearch->SearchValue2 = $filter["y_Kota_Tempat_Tinggal"] ?? "";
        $this->Kota_Tempat_Tinggal->AdvancedSearch->SearchOperator2 = $filter["w_Kota_Tempat_Tinggal"] ?? "";
        $this->Kota_Tempat_Tinggal->AdvancedSearch->save();

        // Field Kecamatan_Tempat_Tinggal
        $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->SearchValue = $filter["x_Kecamatan_Tempat_Tinggal"] ?? "";
        $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->SearchOperator = $filter["z_Kecamatan_Tempat_Tinggal"] ?? "";
        $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->SearchCondition = $filter["v_Kecamatan_Tempat_Tinggal"] ?? "";
        $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->SearchValue2 = $filter["y_Kecamatan_Tempat_Tinggal"] ?? "";
        $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->SearchOperator2 = $filter["w_Kecamatan_Tempat_Tinggal"] ?? "";
        $this->Kecamatan_Tempat_Tinggal->AdvancedSearch->save();

        // Field Alamat_Tempat_Tinggal
        $this->Alamat_Tempat_Tinggal->AdvancedSearch->SearchValue = $filter["x_Alamat_Tempat_Tinggal"] ?? "";
        $this->Alamat_Tempat_Tinggal->AdvancedSearch->SearchOperator = $filter["z_Alamat_Tempat_Tinggal"] ?? "";
        $this->Alamat_Tempat_Tinggal->AdvancedSearch->SearchCondition = $filter["v_Alamat_Tempat_Tinggal"] ?? "";
        $this->Alamat_Tempat_Tinggal->AdvancedSearch->SearchValue2 = $filter["y_Alamat_Tempat_Tinggal"] ?? "";
        $this->Alamat_Tempat_Tinggal->AdvancedSearch->SearchOperator2 = $filter["w_Alamat_Tempat_Tinggal"] ?? "";
        $this->Alamat_Tempat_Tinggal->AdvancedSearch->save();

        // Field RT
        $this->RT->AdvancedSearch->SearchValue = $filter["x_RT"] ?? "";
        $this->RT->AdvancedSearch->SearchOperator = $filter["z_RT"] ?? "";
        $this->RT->AdvancedSearch->SearchCondition = $filter["v_RT"] ?? "";
        $this->RT->AdvancedSearch->SearchValue2 = $filter["y_RT"] ?? "";
        $this->RT->AdvancedSearch->SearchOperator2 = $filter["w_RT"] ?? "";
        $this->RT->AdvancedSearch->save();

        // Field RW
        $this->RW->AdvancedSearch->SearchValue = $filter["x_RW"] ?? "";
        $this->RW->AdvancedSearch->SearchOperator = $filter["z_RW"] ?? "";
        $this->RW->AdvancedSearch->SearchCondition = $filter["v_RW"] ?? "";
        $this->RW->AdvancedSearch->SearchValue2 = $filter["y_RW"] ?? "";
        $this->RW->AdvancedSearch->SearchOperator2 = $filter["w_RW"] ?? "";
        $this->RW->AdvancedSearch->save();

        // Field Kelurahan
        $this->Kelurahan->AdvancedSearch->SearchValue = $filter["x_Kelurahan"] ?? "";
        $this->Kelurahan->AdvancedSearch->SearchOperator = $filter["z_Kelurahan"] ?? "";
        $this->Kelurahan->AdvancedSearch->SearchCondition = $filter["v_Kelurahan"] ?? "";
        $this->Kelurahan->AdvancedSearch->SearchValue2 = $filter["y_Kelurahan"] ?? "";
        $this->Kelurahan->AdvancedSearch->SearchOperator2 = $filter["w_Kelurahan"] ?? "";
        $this->Kelurahan->AdvancedSearch->save();

        // Field Kode_Pos
        $this->Kode_Pos->AdvancedSearch->SearchValue = $filter["x_Kode_Pos"] ?? "";
        $this->Kode_Pos->AdvancedSearch->SearchOperator = $filter["z_Kode_Pos"] ?? "";
        $this->Kode_Pos->AdvancedSearch->SearchCondition = $filter["v_Kode_Pos"] ?? "";
        $this->Kode_Pos->AdvancedSearch->SearchValue2 = $filter["y_Kode_Pos"] ?? "";
        $this->Kode_Pos->AdvancedSearch->SearchOperator2 = $filter["w_Kode_Pos"] ?? "";
        $this->Kode_Pos->AdvancedSearch->save();

        // Field Nomor_Telpon_HP
        $this->Nomor_Telpon_HP->AdvancedSearch->SearchValue = $filter["x_Nomor_Telpon_HP"] ?? "";
        $this->Nomor_Telpon_HP->AdvancedSearch->SearchOperator = $filter["z_Nomor_Telpon_HP"] ?? "";
        $this->Nomor_Telpon_HP->AdvancedSearch->SearchCondition = $filter["v_Nomor_Telpon_HP"] ?? "";
        $this->Nomor_Telpon_HP->AdvancedSearch->SearchValue2 = $filter["y_Nomor_Telpon_HP"] ?? "";
        $this->Nomor_Telpon_HP->AdvancedSearch->SearchOperator2 = $filter["w_Nomor_Telpon_HP"] ?? "";
        $this->Nomor_Telpon_HP->AdvancedSearch->save();

        // Field Email
        $this->_Email->AdvancedSearch->SearchValue = $filter["x__Email"] ?? "";
        $this->_Email->AdvancedSearch->SearchOperator = $filter["z__Email"] ?? "";
        $this->_Email->AdvancedSearch->SearchCondition = $filter["v__Email"] ?? "";
        $this->_Email->AdvancedSearch->SearchValue2 = $filter["y__Email"] ?? "";
        $this->_Email->AdvancedSearch->SearchOperator2 = $filter["w__Email"] ?? "";
        $this->_Email->AdvancedSearch->save();

        // Field Jenis_Tinggal
        $this->Jenis_Tinggal->AdvancedSearch->SearchValue = $filter["x_Jenis_Tinggal"] ?? "";
        $this->Jenis_Tinggal->AdvancedSearch->SearchOperator = $filter["z_Jenis_Tinggal"] ?? "";
        $this->Jenis_Tinggal->AdvancedSearch->SearchCondition = $filter["v_Jenis_Tinggal"] ?? "";
        $this->Jenis_Tinggal->AdvancedSearch->SearchValue2 = $filter["y_Jenis_Tinggal"] ?? "";
        $this->Jenis_Tinggal->AdvancedSearch->SearchOperator2 = $filter["w_Jenis_Tinggal"] ?? "";
        $this->Jenis_Tinggal->AdvancedSearch->save();

        // Field Alat_Transportasi
        $this->Alat_Transportasi->AdvancedSearch->SearchValue = $filter["x_Alat_Transportasi"] ?? "";
        $this->Alat_Transportasi->AdvancedSearch->SearchOperator = $filter["z_Alat_Transportasi"] ?? "";
        $this->Alat_Transportasi->AdvancedSearch->SearchCondition = $filter["v_Alat_Transportasi"] ?? "";
        $this->Alat_Transportasi->AdvancedSearch->SearchValue2 = $filter["y_Alat_Transportasi"] ?? "";
        $this->Alat_Transportasi->AdvancedSearch->SearchOperator2 = $filter["w_Alat_Transportasi"] ?? "";
        $this->Alat_Transportasi->AdvancedSearch->save();

        // Field Sumber_Dana
        $this->Sumber_Dana->AdvancedSearch->SearchValue = $filter["x_Sumber_Dana"] ?? "";
        $this->Sumber_Dana->AdvancedSearch->SearchOperator = $filter["z_Sumber_Dana"] ?? "";
        $this->Sumber_Dana->AdvancedSearch->SearchCondition = $filter["v_Sumber_Dana"] ?? "";
        $this->Sumber_Dana->AdvancedSearch->SearchValue2 = $filter["y_Sumber_Dana"] ?? "";
        $this->Sumber_Dana->AdvancedSearch->SearchOperator2 = $filter["w_Sumber_Dana"] ?? "";
        $this->Sumber_Dana->AdvancedSearch->save();

        // Field Sumber_Dana_Beasiswa
        $this->Sumber_Dana_Beasiswa->AdvancedSearch->SearchValue = $filter["x_Sumber_Dana_Beasiswa"] ?? "";
        $this->Sumber_Dana_Beasiswa->AdvancedSearch->SearchOperator = $filter["z_Sumber_Dana_Beasiswa"] ?? "";
        $this->Sumber_Dana_Beasiswa->AdvancedSearch->SearchCondition = $filter["v_Sumber_Dana_Beasiswa"] ?? "";
        $this->Sumber_Dana_Beasiswa->AdvancedSearch->SearchValue2 = $filter["y_Sumber_Dana_Beasiswa"] ?? "";
        $this->Sumber_Dana_Beasiswa->AdvancedSearch->SearchOperator2 = $filter["w_Sumber_Dana_Beasiswa"] ?? "";
        $this->Sumber_Dana_Beasiswa->AdvancedSearch->save();

        // Field Jumlah_Sudara
        $this->Jumlah_Sudara->AdvancedSearch->SearchValue = $filter["x_Jumlah_Sudara"] ?? "";
        $this->Jumlah_Sudara->AdvancedSearch->SearchOperator = $filter["z_Jumlah_Sudara"] ?? "";
        $this->Jumlah_Sudara->AdvancedSearch->SearchCondition = $filter["v_Jumlah_Sudara"] ?? "";
        $this->Jumlah_Sudara->AdvancedSearch->SearchValue2 = $filter["y_Jumlah_Sudara"] ?? "";
        $this->Jumlah_Sudara->AdvancedSearch->SearchOperator2 = $filter["w_Jumlah_Sudara"] ?? "";
        $this->Jumlah_Sudara->AdvancedSearch->save();

        // Field Status_Bekerja
        $this->Status_Bekerja->AdvancedSearch->SearchValue = $filter["x_Status_Bekerja"] ?? "";
        $this->Status_Bekerja->AdvancedSearch->SearchOperator = $filter["z_Status_Bekerja"] ?? "";
        $this->Status_Bekerja->AdvancedSearch->SearchCondition = $filter["v_Status_Bekerja"] ?? "";
        $this->Status_Bekerja->AdvancedSearch->SearchValue2 = $filter["y_Status_Bekerja"] ?? "";
        $this->Status_Bekerja->AdvancedSearch->SearchOperator2 = $filter["w_Status_Bekerja"] ?? "";
        $this->Status_Bekerja->AdvancedSearch->save();

        // Field Nomor_Asuransi
        $this->Nomor_Asuransi->AdvancedSearch->SearchValue = $filter["x_Nomor_Asuransi"] ?? "";
        $this->Nomor_Asuransi->AdvancedSearch->SearchOperator = $filter["z_Nomor_Asuransi"] ?? "";
        $this->Nomor_Asuransi->AdvancedSearch->SearchCondition = $filter["v_Nomor_Asuransi"] ?? "";
        $this->Nomor_Asuransi->AdvancedSearch->SearchValue2 = $filter["y_Nomor_Asuransi"] ?? "";
        $this->Nomor_Asuransi->AdvancedSearch->SearchOperator2 = $filter["w_Nomor_Asuransi"] ?? "";
        $this->Nomor_Asuransi->AdvancedSearch->save();

        // Field Hobi
        $this->Hobi->AdvancedSearch->SearchValue = $filter["x_Hobi"] ?? "";
        $this->Hobi->AdvancedSearch->SearchOperator = $filter["z_Hobi"] ?? "";
        $this->Hobi->AdvancedSearch->SearchCondition = $filter["v_Hobi"] ?? "";
        $this->Hobi->AdvancedSearch->SearchValue2 = $filter["y_Hobi"] ?? "";
        $this->Hobi->AdvancedSearch->SearchOperator2 = $filter["w_Hobi"] ?? "";
        $this->Hobi->AdvancedSearch->save();

        // Field Foto
        $this->Foto->AdvancedSearch->SearchValue = $filter["x_Foto"] ?? "";
        $this->Foto->AdvancedSearch->SearchOperator = $filter["z_Foto"] ?? "";
        $this->Foto->AdvancedSearch->SearchCondition = $filter["v_Foto"] ?? "";
        $this->Foto->AdvancedSearch->SearchValue2 = $filter["y_Foto"] ?? "";
        $this->Foto->AdvancedSearch->SearchOperator2 = $filter["w_Foto"] ?? "";
        $this->Foto->AdvancedSearch->save();

        // Field Nama_Ayah
        $this->Nama_Ayah->AdvancedSearch->SearchValue = $filter["x_Nama_Ayah"] ?? "";
        $this->Nama_Ayah->AdvancedSearch->SearchOperator = $filter["z_Nama_Ayah"] ?? "";
        $this->Nama_Ayah->AdvancedSearch->SearchCondition = $filter["v_Nama_Ayah"] ?? "";
        $this->Nama_Ayah->AdvancedSearch->SearchValue2 = $filter["y_Nama_Ayah"] ?? "";
        $this->Nama_Ayah->AdvancedSearch->SearchOperator2 = $filter["w_Nama_Ayah"] ?? "";
        $this->Nama_Ayah->AdvancedSearch->save();

        // Field Pekerjaan_Ayah
        $this->Pekerjaan_Ayah->AdvancedSearch->SearchValue = $filter["x_Pekerjaan_Ayah"] ?? "";
        $this->Pekerjaan_Ayah->AdvancedSearch->SearchOperator = $filter["z_Pekerjaan_Ayah"] ?? "";
        $this->Pekerjaan_Ayah->AdvancedSearch->SearchCondition = $filter["v_Pekerjaan_Ayah"] ?? "";
        $this->Pekerjaan_Ayah->AdvancedSearch->SearchValue2 = $filter["y_Pekerjaan_Ayah"] ?? "";
        $this->Pekerjaan_Ayah->AdvancedSearch->SearchOperator2 = $filter["w_Pekerjaan_Ayah"] ?? "";
        $this->Pekerjaan_Ayah->AdvancedSearch->save();

        // Field Nama_Ibu
        $this->Nama_Ibu->AdvancedSearch->SearchValue = $filter["x_Nama_Ibu"] ?? "";
        $this->Nama_Ibu->AdvancedSearch->SearchOperator = $filter["z_Nama_Ibu"] ?? "";
        $this->Nama_Ibu->AdvancedSearch->SearchCondition = $filter["v_Nama_Ibu"] ?? "";
        $this->Nama_Ibu->AdvancedSearch->SearchValue2 = $filter["y_Nama_Ibu"] ?? "";
        $this->Nama_Ibu->AdvancedSearch->SearchOperator2 = $filter["w_Nama_Ibu"] ?? "";
        $this->Nama_Ibu->AdvancedSearch->save();

        // Field Pekerjaan_Ibu
        $this->Pekerjaan_Ibu->AdvancedSearch->SearchValue = $filter["x_Pekerjaan_Ibu"] ?? "";
        $this->Pekerjaan_Ibu->AdvancedSearch->SearchOperator = $filter["z_Pekerjaan_Ibu"] ?? "";
        $this->Pekerjaan_Ibu->AdvancedSearch->SearchCondition = $filter["v_Pekerjaan_Ibu"] ?? "";
        $this->Pekerjaan_Ibu->AdvancedSearch->SearchValue2 = $filter["y_Pekerjaan_Ibu"] ?? "";
        $this->Pekerjaan_Ibu->AdvancedSearch->SearchOperator2 = $filter["w_Pekerjaan_Ibu"] ?? "";
        $this->Pekerjaan_Ibu->AdvancedSearch->save();

        // Field Alamat_Orang_Tua
        $this->Alamat_Orang_Tua->AdvancedSearch->SearchValue = $filter["x_Alamat_Orang_Tua"] ?? "";
        $this->Alamat_Orang_Tua->AdvancedSearch->SearchOperator = $filter["z_Alamat_Orang_Tua"] ?? "";
        $this->Alamat_Orang_Tua->AdvancedSearch->SearchCondition = $filter["v_Alamat_Orang_Tua"] ?? "";
        $this->Alamat_Orang_Tua->AdvancedSearch->SearchValue2 = $filter["y_Alamat_Orang_Tua"] ?? "";
        $this->Alamat_Orang_Tua->AdvancedSearch->SearchOperator2 = $filter["w_Alamat_Orang_Tua"] ?? "";
        $this->Alamat_Orang_Tua->AdvancedSearch->save();

        // Field e_mail_Oranng_Tua
        $this->e_mail_Oranng_Tua->AdvancedSearch->SearchValue = $filter["x_e_mail_Oranng_Tua"] ?? "";
        $this->e_mail_Oranng_Tua->AdvancedSearch->SearchOperator = $filter["z_e_mail_Oranng_Tua"] ?? "";
        $this->e_mail_Oranng_Tua->AdvancedSearch->SearchCondition = $filter["v_e_mail_Oranng_Tua"] ?? "";
        $this->e_mail_Oranng_Tua->AdvancedSearch->SearchValue2 = $filter["y_e_mail_Oranng_Tua"] ?? "";
        $this->e_mail_Oranng_Tua->AdvancedSearch->SearchOperator2 = $filter["w_e_mail_Oranng_Tua"] ?? "";
        $this->e_mail_Oranng_Tua->AdvancedSearch->save();

        // Field No_Kontak_Orang_Tua
        $this->No_Kontak_Orang_Tua->AdvancedSearch->SearchValue = $filter["x_No_Kontak_Orang_Tua"] ?? "";
        $this->No_Kontak_Orang_Tua->AdvancedSearch->SearchOperator = $filter["z_No_Kontak_Orang_Tua"] ?? "";
        $this->No_Kontak_Orang_Tua->AdvancedSearch->SearchCondition = $filter["v_No_Kontak_Orang_Tua"] ?? "";
        $this->No_Kontak_Orang_Tua->AdvancedSearch->SearchValue2 = $filter["y_No_Kontak_Orang_Tua"] ?? "";
        $this->No_Kontak_Orang_Tua->AdvancedSearch->SearchOperator2 = $filter["w_No_Kontak_Orang_Tua"] ?? "";
        $this->No_Kontak_Orang_Tua->AdvancedSearch->save();

        // Field userid
        $this->userid->AdvancedSearch->SearchValue = $filter["x_userid"] ?? "";
        $this->userid->AdvancedSearch->SearchOperator = $filter["z_userid"] ?? "";
        $this->userid->AdvancedSearch->SearchCondition = $filter["v_userid"] ?? "";
        $this->userid->AdvancedSearch->SearchValue2 = $filter["y_userid"] ?? "";
        $this->userid->AdvancedSearch->SearchOperator2 = $filter["w_userid"] ?? "";
        $this->userid->AdvancedSearch->save();

        // Field user
        $this->user->AdvancedSearch->SearchValue = $filter["x_user"] ?? "";
        $this->user->AdvancedSearch->SearchOperator = $filter["z_user"] ?? "";
        $this->user->AdvancedSearch->SearchCondition = $filter["v_user"] ?? "";
        $this->user->AdvancedSearch->SearchValue2 = $filter["y_user"] ?? "";
        $this->user->AdvancedSearch->SearchOperator2 = $filter["w_user"] ?? "";
        $this->user->AdvancedSearch->save();

        // Field ip
        $this->ip->AdvancedSearch->SearchValue = $filter["x_ip"] ?? "";
        $this->ip->AdvancedSearch->SearchOperator = $filter["z_ip"] ?? "";
        $this->ip->AdvancedSearch->SearchCondition = $filter["v_ip"] ?? "";
        $this->ip->AdvancedSearch->SearchValue2 = $filter["y_ip"] ?? "";
        $this->ip->AdvancedSearch->SearchOperator2 = $filter["w_ip"] ?? "";
        $this->ip->AdvancedSearch->save();

        // Field tanggal_input
        $this->tanggal_input->AdvancedSearch->SearchValue = $filter["x_tanggal_input"] ?? "";
        $this->tanggal_input->AdvancedSearch->SearchOperator = $filter["z_tanggal_input"] ?? "";
        $this->tanggal_input->AdvancedSearch->SearchCondition = $filter["v_tanggal_input"] ?? "";
        $this->tanggal_input->AdvancedSearch->SearchValue2 = $filter["y_tanggal_input"] ?? "";
        $this->tanggal_input->AdvancedSearch->SearchOperator2 = $filter["w_tanggal_input"] ?? "";
        $this->tanggal_input->AdvancedSearch->save();
        $this->BasicSearch->setKeyword($filter[Config("TABLE_BASIC_SEARCH")] ?? "");
        $this->BasicSearch->setType($filter[Config("TABLE_BASIC_SEARCH_TYPE")] ?? "");
    }

    // Show list of filters
    public function showFilterList(): void
    {
        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";
        if ($this->BasicSearch->Keyword != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->language->phrase("BasicSearchKeyword") . "</span>" . $captionSuffix . $this->BasicSearch->Keyword . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $this->language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    public function basicSearchWhere(bool $default = false): string
    {
        $searchStr = "";
        if (!$this->security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->NIM;
        $searchFlds[] = &$this->Nama;
        $searchFlds[] = &$this->Jenis_Kelamin;
        $searchFlds[] = &$this->Provinsi_Tempat_Lahir;
        $searchFlds[] = &$this->Kota_Tempat_Lahir;
        $searchFlds[] = &$this->Golongan_Darah;
        $searchFlds[] = &$this->Tinggi_Badan;
        $searchFlds[] = &$this->Berat_Badan;
        $searchFlds[] = &$this->Asal_sekolah;
        $searchFlds[] = &$this->Tahun_Ijazah;
        $searchFlds[] = &$this->Nomor_Ijazah;
        $searchFlds[] = &$this->No_Test;
        $searchFlds[] = &$this->Status_Masuk;
        $searchFlds[] = &$this->Jalur_Masuk;
        $searchFlds[] = &$this->Bukti_Lulus;
        $searchFlds[] = &$this->Hasil_Test_Kesehatan;
        $searchFlds[] = &$this->Hasil_Test_MMPI;
        $searchFlds[] = &$this->Angkatan;
        $searchFlds[] = &$this->NIK_No_KTP;
        $searchFlds[] = &$this->No_KK;
        $searchFlds[] = &$this->NPWP;
        $searchFlds[] = &$this->Status_Nikah;
        $searchFlds[] = &$this->Kewarganegaraan;
        $searchFlds[] = &$this->Propinsi_Tempat_Tinggal;
        $searchFlds[] = &$this->Kota_Tempat_Tinggal;
        $searchFlds[] = &$this->Kecamatan_Tempat_Tinggal;
        $searchFlds[] = &$this->Alamat_Tempat_Tinggal;
        $searchFlds[] = &$this->RT;
        $searchFlds[] = &$this->RW;
        $searchFlds[] = &$this->Kelurahan;
        $searchFlds[] = &$this->Kode_Pos;
        $searchFlds[] = &$this->Nomor_Telpon_HP;
        $searchFlds[] = &$this->_Email;
        $searchFlds[] = &$this->Jenis_Tinggal;
        $searchFlds[] = &$this->Alat_Transportasi;
        $searchFlds[] = &$this->Sumber_Dana;
        $searchFlds[] = &$this->Sumber_Dana_Beasiswa;
        $searchFlds[] = &$this->Jumlah_Sudara;
        $searchFlds[] = &$this->Status_Bekerja;
        $searchFlds[] = &$this->Nomor_Asuransi;
        $searchFlds[] = &$this->Hobi;
        $searchFlds[] = &$this->Foto;
        $searchFlds[] = &$this->Nama_Ayah;
        $searchFlds[] = &$this->Pekerjaan_Ayah;
        $searchFlds[] = &$this->Nama_Ibu;
        $searchFlds[] = &$this->Pekerjaan_Ibu;
        $searchFlds[] = &$this->Alamat_Orang_Tua;
        $searchFlds[] = &$this->e_mail_Oranng_Tua;
        $searchFlds[] = &$this->No_Kontak_Orang_Tua;
        $searchFlds[] = &$this->userid;
        $searchFlds[] = &$this->user;
        $searchFlds[] = &$this->ip;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms(): bool
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms(): void
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault(): bool
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms(): void
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms(): void
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder(): void
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = ""; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->NIM); // NIM
            $this->updateSort($this->Nama); // Nama
            $this->updateSort($this->Jenis_Kelamin); // Jenis_Kelamin
            $this->updateSort($this->Provinsi_Tempat_Lahir); // Provinsi_Tempat_Lahir
            $this->updateSort($this->Kota_Tempat_Lahir); // Kota_Tempat_Lahir
            $this->updateSort($this->Tanggal_Lahir); // Tanggal_Lahir
            $this->updateSort($this->Golongan_Darah); // Golongan_Darah
            $this->updateSort($this->Tinggi_Badan); // Tinggi_Badan
            $this->updateSort($this->Berat_Badan); // Berat_Badan
            $this->updateSort($this->Asal_sekolah); // Asal_sekolah
            $this->updateSort($this->Tahun_Ijazah); // Tahun_Ijazah
            $this->updateSort($this->Nomor_Ijazah); // Nomor_Ijazah
            $this->updateSort($this->Nilai_Raport_Kelas_10); // Nilai_Raport_Kelas_10
            $this->updateSort($this->Nilai_Raport_Kelas_11); // Nilai_Raport_Kelas_11
            $this->updateSort($this->Nilai_Raport_Kelas_12); // Nilai_Raport_Kelas_12
            $this->updateSort($this->Tanggal_Daftar); // Tanggal_Daftar
            $this->updateSort($this->No_Test); // No_Test
            $this->updateSort($this->Status_Masuk); // Status_Masuk
            $this->updateSort($this->Jalur_Masuk); // Jalur_Masuk
            $this->updateSort($this->Bukti_Lulus); // Bukti_Lulus
            $this->updateSort($this->Tes_Potensi_Akademik); // Tes_Potensi_Akademik
            $this->updateSort($this->Tes_Wawancara); // Tes_Wawancara
            $this->updateSort($this->Tes_Kesehatan); // Tes_Kesehatan
            $this->updateSort($this->Hasil_Test_Kesehatan); // Hasil_Test_Kesehatan
            $this->updateSort($this->Test_MMPI); // Test_MMPI
            $this->updateSort($this->Hasil_Test_MMPI); // Hasil_Test_MMPI
            $this->updateSort($this->Angkatan); // Angkatan
            $this->updateSort($this->Tarif_SPP); // Tarif_SPP
            $this->updateSort($this->NIK_No_KTP); // NIK_No_KTP
            $this->updateSort($this->No_KK); // No_KK
            $this->updateSort($this->NPWP); // NPWP
            $this->updateSort($this->Status_Nikah); // Status_Nikah
            $this->updateSort($this->Kewarganegaraan); // Kewarganegaraan
            $this->updateSort($this->Propinsi_Tempat_Tinggal); // Propinsi_Tempat_Tinggal
            $this->updateSort($this->Kota_Tempat_Tinggal); // Kota_Tempat_Tinggal
            $this->updateSort($this->Kecamatan_Tempat_Tinggal); // Kecamatan_Tempat_Tinggal
            $this->updateSort($this->Alamat_Tempat_Tinggal); // Alamat_Tempat_Tinggal
            $this->updateSort($this->RT); // RT
            $this->updateSort($this->RW); // RW
            $this->updateSort($this->Kelurahan); // Kelurahan
            $this->updateSort($this->Kode_Pos); // Kode_Pos
            $this->updateSort($this->Nomor_Telpon_HP); // Nomor_Telpon_HP
            $this->updateSort($this->_Email); // Email
            $this->updateSort($this->Jenis_Tinggal); // Jenis_Tinggal
            $this->updateSort($this->Alat_Transportasi); // Alat_Transportasi
            $this->updateSort($this->Sumber_Dana); // Sumber_Dana
            $this->updateSort($this->Sumber_Dana_Beasiswa); // Sumber_Dana_Beasiswa
            $this->updateSort($this->Jumlah_Sudara); // Jumlah_Sudara
            $this->updateSort($this->Status_Bekerja); // Status_Bekerja
            $this->updateSort($this->Nomor_Asuransi); // Nomor_Asuransi
            $this->updateSort($this->Hobi); // Hobi
            $this->updateSort($this->Foto); // Foto
            $this->updateSort($this->Nama_Ayah); // Nama_Ayah
            $this->updateSort($this->Pekerjaan_Ayah); // Pekerjaan_Ayah
            $this->updateSort($this->Nama_Ibu); // Nama_Ibu
            $this->updateSort($this->Pekerjaan_Ibu); // Pekerjaan_Ibu
            $this->updateSort($this->Alamat_Orang_Tua); // Alamat_Orang_Tua
            $this->updateSort($this->e_mail_Oranng_Tua); // e_mail_Oranng_Tua
            $this->updateSort($this->No_Kontak_Orang_Tua); // No_Kontak_Orang_Tua
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd(): void
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->NIM->setSort("");
                $this->Nama->setSort("");
                $this->Jenis_Kelamin->setSort("");
                $this->Provinsi_Tempat_Lahir->setSort("");
                $this->Kota_Tempat_Lahir->setSort("");
                $this->Tanggal_Lahir->setSort("");
                $this->Golongan_Darah->setSort("");
                $this->Tinggi_Badan->setSort("");
                $this->Berat_Badan->setSort("");
                $this->Asal_sekolah->setSort("");
                $this->Tahun_Ijazah->setSort("");
                $this->Nomor_Ijazah->setSort("");
                $this->Nilai_Raport_Kelas_10->setSort("");
                $this->Nilai_Raport_Kelas_11->setSort("");
                $this->Nilai_Raport_Kelas_12->setSort("");
                $this->Tanggal_Daftar->setSort("");
                $this->No_Test->setSort("");
                $this->Status_Masuk->setSort("");
                $this->Jalur_Masuk->setSort("");
                $this->Bukti_Lulus->setSort("");
                $this->Tes_Potensi_Akademik->setSort("");
                $this->Tes_Wawancara->setSort("");
                $this->Tes_Kesehatan->setSort("");
                $this->Hasil_Test_Kesehatan->setSort("");
                $this->Test_MMPI->setSort("");
                $this->Hasil_Test_MMPI->setSort("");
                $this->Angkatan->setSort("");
                $this->Tarif_SPP->setSort("");
                $this->NIK_No_KTP->setSort("");
                $this->No_KK->setSort("");
                $this->NPWP->setSort("");
                $this->Status_Nikah->setSort("");
                $this->Kewarganegaraan->setSort("");
                $this->Propinsi_Tempat_Tinggal->setSort("");
                $this->Kota_Tempat_Tinggal->setSort("");
                $this->Kecamatan_Tempat_Tinggal->setSort("");
                $this->Alamat_Tempat_Tinggal->setSort("");
                $this->RT->setSort("");
                $this->RW->setSort("");
                $this->Kelurahan->setSort("");
                $this->Kode_Pos->setSort("");
                $this->Nomor_Telpon_HP->setSort("");
                $this->_Email->setSort("");
                $this->Jenis_Tinggal->setSort("");
                $this->Alat_Transportasi->setSort("");
                $this->Sumber_Dana->setSort("");
                $this->Sumber_Dana_Beasiswa->setSort("");
                $this->Jumlah_Sudara->setSort("");
                $this->Status_Bekerja->setSort("");
                $this->Nomor_Asuransi->setSort("");
                $this->Hobi->setSort("");
                $this->Foto->setSort("");
                $this->Nama_Ayah->setSort("");
                $this->Pekerjaan_Ayah->setSort("");
                $this->Nama_Ibu->setSort("");
                $this->Pekerjaan_Ibu->setSort("");
                $this->Alamat_Orang_Tua->setSort("");
                $this->e_mail_Oranng_Tua->setSort("");
                $this->No_Kontak_Orang_Tua->setSort("");
                $this->userid->setSort("");
                $this->user->setSort("");
                $this->ip->setSort("");
                $this->tanggal_input->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions(): void
    {
        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $this->security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $this->security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $this->security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $this->security->canDelete();
        $item->OnLeft = true;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $this->language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = true;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        // $this->ListOptions->ButtonClass = ""; // Class for button group

            // Set up list options (to be implemented by extensions)

        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Add "hash" parameter to URL
    public function urlAddHash(string $url, string $hash): string
    {
        return $this->UseAjaxActions ? $url : UrlAddQuery($url, "hash=" . $hash);
    }

    // Render list options
    public function renderListOptions(): void
    {
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($this->language->phrase("ViewLink"));
            if ($this->security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"mahasiswa\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $this->language->phrase("ViewLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $this->language->phrase("ViewLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($this->language->phrase("EditLink"));
            if ($this->security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
					$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"mahasiswa\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-ask=\"1\" data-btn=\"SaveBtn\">" . $this->language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $this->language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($this->language->phrase("CopyLink"));
            if ($this->security->canAdd()) {
                if ($this->ModalAdd && !IsMobile()) {
					$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"mahasiswa\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-ask=\"1\" data-btn=\"AddBtn\">" . $this->language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $this->language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($this->security->canDelete()) {
                $deleteCaption = $this->language->phrase("DeleteLink");
                $deleteTitle = HtmlTitle($deleteCaption);
                if ($this->UseAjaxActions) {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"inline\" data-action=\"delete\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" data-key= \"" . HtmlEncode($this->getKey(true)) . "\" data-url=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\"" .
                        ($this->InlineDelete ? " data-ew-action=\"inline-delete\"" : "") .
                        " title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Render list action buttons (single selection)
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions as $listAction) { // ActionType::SINGLE
                if (in_array($this->RowType, [RowType::VIEW, RowType::PREVIEW])) {
                    $listAction->setFields($this->Fields);
                }
                if ($listAction->Select == ActionType::SINGLE && $listAction->getVisible()) {
                    $caption = $listAction->getCaption();
                    $title = HtmlTitle($caption);
                    $icon = $listAction->Icon ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listAction->Icon)) . "\" data-caption=\"" . $title . "\"></i> " : "";
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action" . ($listAction->getEnabled() ? "" : " disabled") .
                        "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fmahasiswalist\" data-key=\"" . $this->keyToJson(true) .
                        "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                    $links[] = $link;
                    if ($body == "") { // Setup first button
                        $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action" . ($listAction->getEnabled() ? "" : " disabled") .
                            "\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fmahasiswalist\" data-key=\"" . $this->keyToJson(true) .
                            "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($this->language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $this->language->phrase("ListActionButton") . "</button>";
                $content = implode(array_map(fn($link) => "<li>" . $link . "</li>", $links));
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->NIM->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";

        // Render list options (to be implemented by extensions)

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions(): void
    {
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($this->language->phrase("AddLink"));
        if ($this->ModalAdd && !IsMobile()) {
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"mahasiswa\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-ask=\"1\" data-btn=\"AddBtn\">" . $this->language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $this->language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $this->security->canAdd();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "NIM");
            $this->createColumnOption($option, "Nama");
            $this->createColumnOption($option, "Jenis_Kelamin");
            $this->createColumnOption($option, "Provinsi_Tempat_Lahir");
            $this->createColumnOption($option, "Kota_Tempat_Lahir");
            $this->createColumnOption($option, "Tanggal_Lahir");
            $this->createColumnOption($option, "Golongan_Darah");
            $this->createColumnOption($option, "Tinggi_Badan");
            $this->createColumnOption($option, "Berat_Badan");
            $this->createColumnOption($option, "Asal_sekolah");
            $this->createColumnOption($option, "Tahun_Ijazah");
            $this->createColumnOption($option, "Nomor_Ijazah");
            $this->createColumnOption($option, "Nilai_Raport_Kelas_10");
            $this->createColumnOption($option, "Nilai_Raport_Kelas_11");
            $this->createColumnOption($option, "Nilai_Raport_Kelas_12");
            $this->createColumnOption($option, "Tanggal_Daftar");
            $this->createColumnOption($option, "No_Test");
            $this->createColumnOption($option, "Status_Masuk");
            $this->createColumnOption($option, "Jalur_Masuk");
            $this->createColumnOption($option, "Bukti_Lulus");
            $this->createColumnOption($option, "Tes_Potensi_Akademik");
            $this->createColumnOption($option, "Tes_Wawancara");
            $this->createColumnOption($option, "Tes_Kesehatan");
            $this->createColumnOption($option, "Hasil_Test_Kesehatan");
            $this->createColumnOption($option, "Test_MMPI");
            $this->createColumnOption($option, "Hasil_Test_MMPI");
            $this->createColumnOption($option, "Angkatan");
            $this->createColumnOption($option, "Tarif_SPP");
            $this->createColumnOption($option, "NIK_No_KTP");
            $this->createColumnOption($option, "No_KK");
            $this->createColumnOption($option, "NPWP");
            $this->createColumnOption($option, "Status_Nikah");
            $this->createColumnOption($option, "Kewarganegaraan");
            $this->createColumnOption($option, "Propinsi_Tempat_Tinggal");
            $this->createColumnOption($option, "Kota_Tempat_Tinggal");
            $this->createColumnOption($option, "Kecamatan_Tempat_Tinggal");
            $this->createColumnOption($option, "Alamat_Tempat_Tinggal");
            $this->createColumnOption($option, "RT");
            $this->createColumnOption($option, "RW");
            $this->createColumnOption($option, "Kelurahan");
            $this->createColumnOption($option, "Kode_Pos");
            $this->createColumnOption($option, "Nomor_Telpon_HP");
            $this->createColumnOption($option, "Email");
            $this->createColumnOption($option, "Jenis_Tinggal");
            $this->createColumnOption($option, "Alat_Transportasi");
            $this->createColumnOption($option, "Sumber_Dana");
            $this->createColumnOption($option, "Sumber_Dana_Beasiswa");
            $this->createColumnOption($option, "Jumlah_Sudara");
            $this->createColumnOption($option, "Status_Bekerja");
            $this->createColumnOption($option, "Nomor_Asuransi");
            $this->createColumnOption($option, "Hobi");
            $this->createColumnOption($option, "Foto");
            $this->createColumnOption($option, "Nama_Ayah");
            $this->createColumnOption($option, "Pekerjaan_Ayah");
            $this->createColumnOption($option, "Nama_Ibu");
            $this->createColumnOption($option, "Pekerjaan_Ibu");
            $this->createColumnOption($option, "Alamat_Orang_Tua");
            $this->createColumnOption($option, "e_mail_Oranng_Tua");
            $this->createColumnOption($option, "No_Kontak_Orang_Tua");
        }

        // Set up custom actions
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions[$name] = $action;
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $this->language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $this->language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $this->language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fmahasiswasrch\" data-ew-action=\"none\">" . $this->language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fmahasiswasrch\" data-ew-action=\"none\">" . $this->language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $this->language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Page header/footer options
        $this->HeaderOptions = new ListOptions(TagClassName: "ew-header-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->HeaderOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        $this->FooterOptions = new ListOptions(TagClassName: "ew-footer-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->FooterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Show active user count from SQL
    }

    // Active user filter
    // - Get active users by SQL (SELECT COUNT(*) FROM UserTable WHERE ProfileField LIKE '%"SessionID":%')
    protected function activeUserFilter(): string
    {
        if (UserProfile::$FORCE_LOGOUT_USER_ENABLED) {
            $userProfileField = $this->Fields[Config("USER_PROFILE_FIELD_NAME")];
            return $userProfileField->Expression . " LIKE '%\"" . UserProfile::$SESSION_ID . "\":%'";
        }
        return "0=1"; // No active users
    }

    // Create new column option
    protected function createColumnOption(ListOptions $options, string $name): void
    {
        $field = $this->Fields[$name] ?? null;
        if ($field?->Visible) {
            $item = $options->add($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
        }
    }

    // Render other options
    public function renderOtherOptions(): void
    {
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Render list action buttons
        foreach ($this->ListActions as $listAction) { // ActionType::MULTIPLE
            if ($listAction->Select == ActionType::MULTIPLE && $listAction->getVisible()) {
                $item = &$option->add("custom_" . $listAction->Action);
                $caption = $listAction->getCaption();
                $icon = $listAction->Icon ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fmahasiswalist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
                $item->Visible = true;
            }
        }

        // Hide multi edit, grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction(): bool
    {
        $users = [];
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("action", "");
        if ($filter != "" && $userAction != "") {
            $conn = $this->getConnection();
            // Clear current action
            $this->CurrentAction = "";
            // Check permission first
            $caption = $userAction;
            $listAction = $this->ListActions[$userAction] ?? null;
            if ($listAction) {
                $this->UserAction = $userAction;
                $caption = $listAction->getCaption();
                if (!$listAction->Allowed) {
                    $errmsg = sprintf($this->language->phrase("CustomActionNotAllowed"), $caption);
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            } else {
                // Skip checking, handle by Row_CustomAction
            }
            $rows = $this->loadRecords($filter)->fetchAllAssociative();
            $this->SelectedCount = count($rows);
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($this->SelectedCount > 0) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedIndex = 0;
                foreach ($rows as $row) {
                    $this->SelectedIndex++;
                    if ($listAction) {
                        $processed = $listAction->handle($row, $this);
                        if (!$processed) {
                            break;
                        }
                    }
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                    if (!$this->peekSuccessMessage() && !IsEmpty($listAction?->SuccessMessage)) {
                        $this->setSuccessMessage($listAction->SuccessMessage);
                    }
                    if (!$this->peekSuccessMessage()) {
                        $this->setSuccessMessage(sprintf($this->language->phrase("CustomActionCompleted"), $caption)); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                    if (!$this->peekFailureMessage()) {
                        $this->setFailureMessage($listAction->FailureMessage);
                    }

                    // Set up error message
                    if ($this->peekSuccessMessage() || $this->peekFailureMessage()) {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(sprintf($this->language->phrase("CustomActionFailed"), $caption));
                    }
                }
            }
            if (Post("ajax") == $userAction) { // Ajax
                if (HasJsonResponse()) { // List action returns JSON
                    $this->clearMessages(); // Clear messages
                } else {
                    if ($this->peekSuccessMessage()) {
                        echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    }
                    if ($this->peekFailureMessage()) {
                        echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    }
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up Grid
    public function setupGrid(): void
    {
        if ($this->ExportAll && $this->isExport()) {
            $this->StopRecord = $this->TotalRecords;
        } else {
            // Set the last record to display
            if ($this->TotalRecords > $this->StartRecord + $this->DisplayRecords - 1) {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            } else {
                $this->StopRecord = $this->TotalRecords;
            }
        }
        $this->RecordCount = $this->StartRecord - 1;
        if ($this->CurrentRow !== false) {
            // Nothing to do
        } elseif ($this->isGridAdd() && !$this->AllowAddDeleteRow && $this->StopRecord == 0) { // Grid-Add with no records
            $this->StopRecord = $this->GridAddRowCount;
        } elseif ($this->isAdd() && $this->TotalRecords == 0) { // Inline-Add with no records
            $this->StopRecord = 1;
        }

        // Initialize aggregate
        $this->RowType = RowType::AGGREGATEINIT;
        $this->resetAttributes();
        $this->renderRow();
        if (($this->isGridAdd() || $this->isGridEdit())) { // Render template row first
            $this->RowIndex = '$rowindex$';
        }
    }

    // Set up Row
    public function setupRow(): void
    {
        if ($this->isGridAdd() || $this->isGridEdit()) {
            if ($this->RowIndex === '$rowindex$') { // Render template row first
                $this->loadRowValues();

                // Set row properties
                $this->resetAttributes();
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_mahasiswa", "data-rowtype" => RowType::ADD]);
                $this->RowAttrs->appendClass("ew-template");
                // Render row
                $this->RowType = RowType::ADD;
                $this->renderRow();

                // Render list options
                $this->renderListOptions();

                // Reset record count for template row
                $this->RecordCount--;
                return;
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isCopy() && $this->InlineRowCount == 0 && !$this->loadRow()) { // Inline copy
            $this->CurrentAction = "add";
        }
        if ($this->isAdd() && $this->InlineRowCount == 0 || $this->isGridAdd()) {
            $this->loadRowValues(); // Load default values
            $this->OldKey = "";
            $this->setKey($this->OldKey);
        } elseif ($this->isInlineInserted() && $this->UseInfiniteScroll) {
            // Nothing to do, just use current values
        } elseif (!($this->isCopy() && $this->InlineRowCount == 0)) {
            $this->loadRowValues($this->CurrentRow); // Load row values
            if ($this->isGridEdit() || $this->isMultiEdit()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey);
            }
        }
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }

        // Inline Add/Copy row (row 0)
        if ($this->RowType == RowType::ADD && ($this->isAdd() || $this->isCopy())) {
            $this->InlineRowCount++;
            $this->RecordCount--; // Reset record count for inline add/copy row
            if ($this->TotalRecords == 0) { // Reset stop record if no records
                $this->StopRecord = 0;
            }
        } else {
            // Inline Edit row
            if ($this->RowType == RowType::EDIT && $this->isEdit()) {
                $this->InlineRowCount++;
            }
            $this->RowCount++; // Increment row count
        }

        // Set up row attributes
        $this->RowAttrs->merge([
            "data-rowindex" => $this->RowCount,
            "data-key" => $this->getKey(true),
            "id" => "r" . $this->RowCount . "_mahasiswa",
            "data-rowtype" => $this->RowType,
            "data-inline" => ($this->isAdd() || $this->isCopy() || $this->isEdit()) ? "true" : "false", // Inline-Add/Copy/Edit
            "class" => ($this->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($this->isAdd() && $this->RowType == RowType::ADD || $this->isEdit() && $this->RowType == RowType::EDIT) { // Inline-Add/Edit row
            $this->RowAttrs->appendClass("table-active");
        }

        // Render row
        $this->renderRow();

        // Render list options
        $this->renderListOptions();
    }

// Load basic search values
    protected function loadBasicSearchValues(): bool
    {
        $keyword = Get(Config("TABLE_BASIC_SEARCH"));
        if ($keyword === null) {
            return false;
        } else {
            $this->BasicSearch->setKeyword($keyword, false);
            if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
                $this->Command = "search";
            }
            $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
            return true;
        }
    }

    /**
     * Load result
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Result
     */
    public function loadResult(int $offset = -1, int $rowcnt = -1): Result
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Records Selected event
        $this->recordsSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return array|bool
     */
    public function loadRows(int $offset = -1, int $rowcnt = -1): array|bool
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return bool
     */
    public function loadRow(): bool
    {
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array|bool|null $row Record
     * @return void
     */
    public function loadRowValues(array|bool|null $row = null): void
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
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

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['NIM'] = $this->NIM->DefaultValue;
        $row['Nama'] = $this->Nama->DefaultValue;
        $row['Jenis_Kelamin'] = $this->Jenis_Kelamin->DefaultValue;
        $row['Provinsi_Tempat_Lahir'] = $this->Provinsi_Tempat_Lahir->DefaultValue;
        $row['Kota_Tempat_Lahir'] = $this->Kota_Tempat_Lahir->DefaultValue;
        $row['Tanggal_Lahir'] = $this->Tanggal_Lahir->DefaultValue;
        $row['Golongan_Darah'] = $this->Golongan_Darah->DefaultValue;
        $row['Tinggi_Badan'] = $this->Tinggi_Badan->DefaultValue;
        $row['Berat_Badan'] = $this->Berat_Badan->DefaultValue;
        $row['Asal_sekolah'] = $this->Asal_sekolah->DefaultValue;
        $row['Tahun_Ijazah'] = $this->Tahun_Ijazah->DefaultValue;
        $row['Nomor_Ijazah'] = $this->Nomor_Ijazah->DefaultValue;
        $row['Nilai_Raport_Kelas_10'] = $this->Nilai_Raport_Kelas_10->DefaultValue;
        $row['Nilai_Raport_Kelas_11'] = $this->Nilai_Raport_Kelas_11->DefaultValue;
        $row['Nilai_Raport_Kelas_12'] = $this->Nilai_Raport_Kelas_12->DefaultValue;
        $row['Tanggal_Daftar'] = $this->Tanggal_Daftar->DefaultValue;
        $row['No_Test'] = $this->No_Test->DefaultValue;
        $row['Status_Masuk'] = $this->Status_Masuk->DefaultValue;
        $row['Jalur_Masuk'] = $this->Jalur_Masuk->DefaultValue;
        $row['Bukti_Lulus'] = $this->Bukti_Lulus->DefaultValue;
        $row['Tes_Potensi_Akademik'] = $this->Tes_Potensi_Akademik->DefaultValue;
        $row['Tes_Wawancara'] = $this->Tes_Wawancara->DefaultValue;
        $row['Tes_Kesehatan'] = $this->Tes_Kesehatan->DefaultValue;
        $row['Hasil_Test_Kesehatan'] = $this->Hasil_Test_Kesehatan->DefaultValue;
        $row['Test_MMPI'] = $this->Test_MMPI->DefaultValue;
        $row['Hasil_Test_MMPI'] = $this->Hasil_Test_MMPI->DefaultValue;
        $row['Angkatan'] = $this->Angkatan->DefaultValue;
        $row['Tarif_SPP'] = $this->Tarif_SPP->DefaultValue;
        $row['NIK_No_KTP'] = $this->NIK_No_KTP->DefaultValue;
        $row['No_KK'] = $this->No_KK->DefaultValue;
        $row['NPWP'] = $this->NPWP->DefaultValue;
        $row['Status_Nikah'] = $this->Status_Nikah->DefaultValue;
        $row['Kewarganegaraan'] = $this->Kewarganegaraan->DefaultValue;
        $row['Propinsi_Tempat_Tinggal'] = $this->Propinsi_Tempat_Tinggal->DefaultValue;
        $row['Kota_Tempat_Tinggal'] = $this->Kota_Tempat_Tinggal->DefaultValue;
        $row['Kecamatan_Tempat_Tinggal'] = $this->Kecamatan_Tempat_Tinggal->DefaultValue;
        $row['Alamat_Tempat_Tinggal'] = $this->Alamat_Tempat_Tinggal->DefaultValue;
        $row['RT'] = $this->RT->DefaultValue;
        $row['RW'] = $this->RW->DefaultValue;
        $row['Kelurahan'] = $this->Kelurahan->DefaultValue;
        $row['Kode_Pos'] = $this->Kode_Pos->DefaultValue;
        $row['Nomor_Telpon_HP'] = $this->Nomor_Telpon_HP->DefaultValue;
        $row['Email'] = $this->_Email->DefaultValue;
        $row['Jenis_Tinggal'] = $this->Jenis_Tinggal->DefaultValue;
        $row['Alat_Transportasi'] = $this->Alat_Transportasi->DefaultValue;
        $row['Sumber_Dana'] = $this->Sumber_Dana->DefaultValue;
        $row['Sumber_Dana_Beasiswa'] = $this->Sumber_Dana_Beasiswa->DefaultValue;
        $row['Jumlah_Sudara'] = $this->Jumlah_Sudara->DefaultValue;
        $row['Status_Bekerja'] = $this->Status_Bekerja->DefaultValue;
        $row['Nomor_Asuransi'] = $this->Nomor_Asuransi->DefaultValue;
        $row['Hobi'] = $this->Hobi->DefaultValue;
        $row['Foto'] = $this->Foto->DefaultValue;
        $row['Nama_Ayah'] = $this->Nama_Ayah->DefaultValue;
        $row['Pekerjaan_Ayah'] = $this->Pekerjaan_Ayah->DefaultValue;
        $row['Nama_Ibu'] = $this->Nama_Ibu->DefaultValue;
        $row['Pekerjaan_Ibu'] = $this->Pekerjaan_Ibu->DefaultValue;
        $row['Alamat_Orang_Tua'] = $this->Alamat_Orang_Tua->DefaultValue;
        $row['e_mail_Oranng_Tua'] = $this->e_mail_Oranng_Tua->DefaultValue;
        $row['No_Kontak_Orang_Tua'] = $this->No_Kontak_Orang_Tua->DefaultValue;
        $row['userid'] = $this->userid->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['ip'] = $this->ip->DefaultValue;
        $row['tanggal_input'] = $this->tanggal_input->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord(): ?array
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $result = ExecuteQuery($sql, $conn);
            if ($row = $result->fetchAssociative()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow(): void
    {
        global $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up search options
    protected function setupSearchOptions(): void
    {	
		$pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

	// Begin of add Search Panel Status by Masino Sinaga, October 13, 2024

	    // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
		if (ReadCookie('mahasiswa_searchpanel') == 'notactive' || ReadCookie('mahasiswa_searchpanel') == "") {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fmahasiswasrch\" aria-pressed=\"false\">" . $this->language->phrase("SearchLink") . "</a>";
		} elseif (ReadCookie('mahasiswa_searchpanel') == 'active') {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle active\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fmahasiswasrch\" aria-pressed=\"true\">" . $this->language->phrase("SearchLink") . "</a>";
		} else {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fmahasiswasrch\" aria-pressed=\"false\">" . $this->language->phrase("SearchLink") . "</a>";
		}
        $item->Visible = true;

	// End of add Search Panel Status by Masino Sinaga, October 13, 2024

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $this->language->phrase("ShowAll") . "\" data-caption=\"" . $this->language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $this->language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $this->language->phrase("ShowAll") . "\" data-caption=\"" . $this->language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $this->language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $this->language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$this->security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields(): bool
    {
        return true;
    }

    // Render search options
    protected function renderSearchOptions(): void
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions(DbField $fld): void
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $qb = $fld->Lookup->getSqlAsQueryBuilder(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $qb != null && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($qb, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }

                // Get lookup cache Id
                $sql = $qb->getSQL();
                $lookupCacheKey = "lookup.cache." . Container($fld->Lookup->LinkTable)->TableVar . ".";
                $cacheId = $lookupCacheKey . hash("xxh128", $sql); // Hash value of SQL as cache id

                // Use result cache
                $cacheProfile = new QueryCacheProfile(0, $cacheId, Container("result.cache"));
                $rows = $conn->executeCacheQuery($sql, [], [], $cacheProfile)->fetchAllAssociative();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord(): void
    {
        $pagerTable = Get(Config("TABLE_PAGER_TABLE_NAME"));
        if ($this->DisplayRecords == 0 || $pagerTable && $pagerTable != $this->TableVar) { // Display all records / Check if paging for this table
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = ConvertToBool(Param("infinitescroll"));
        if ($pageNo !== null) { // Check for "pageno" parameter first
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                if ($this->StartRecord <= 0) {
                    $this->StartRecord = 1;
                } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                    $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                }
            }
        } elseif ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
            $this->StartRecord = $startRec;
        } elseif (!$infiniteScroll) {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount(): int
    {
        return ceil($this->TotalRecords / $this->DisplayRecords);
    }

    // Parse query builder rule
    protected function parseRules(array $group, string $fieldName = "", string $itemName = ""): string
    {
        $group["condition"] ??= "AND";
        if (!in_array($group["condition"], ["AND", "OR"])) {
            throw new Exception("Unable to build SQL query with condition '" . $group["condition"] . "'");
        }
        if (!is_array($group["rules"] ?? null)) {
            return "";
        }
        $parts = [];
        foreach ($group["rules"] as $rule) {
            if (is_array($rule["rules"] ?? null) && count($rule["rules"]) > 0) {
                $part = $this->parseRules($rule, $fieldName, $itemName);
                if ($part) {
                    $parts[] = "(" . " " . $part . " " . ")" . " ";
                }
            } else {
                $field = $rule["field"];
                $fld = $this->fieldByParam($field);
                $dbid = $this->Dbid;
                if ($fld instanceof ReportField && is_array($fld->DashboardSearchSourceFields)) {
                    $item = $fld->DashboardSearchSourceFields[$itemName] ?? null;
                    if ($item) {
                        $tbl = Container($item["table"]);
                        $dbid = $tbl->Dbid;
                        $fld = $tbl->Fields[$item["field"]];
                    } else {
                        $fld = null;
                    }
                }
                if ($fld && ($fieldName == "" || $fld->Name == $fieldName)) { // Field name not specified or matched field name
                    $fldOpr = array_search($rule["operator"], Config("CLIENT_SEARCH_OPERATORS"));
                    $ope = Config("QUERY_BUILDER_OPERATORS")[$rule["operator"]] ?? null;
                    if (!$ope || !$fldOpr) {
                        throw new Exception("Unknown SQL operation for operator '" . $rule["operator"] . "'");
                    }
                    if ($ope["nb_inputs"] > 0 && isset($rule["value"]) && !EmptyValue($rule["value"]) || IsNullOrEmptyOperator($fldOpr)) {
                        $fldVal = $rule["value"] ?? "";
                        if (is_array($fldVal)) {
                            $fldVal = $fld->isMultiSelect() ? implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal) : $fldVal[0];
                        }
                        $useFilter = $fld->UseFilter; // Query builder does not use filter
                        try {
                            if ($fld instanceof ReportField) { // Search report fields
                                if ($fld->SearchType == "dropdown") {
                                    if (is_array($fldVal)) {
                                        $sql = "";
                                        foreach ($fldVal as $val) {
                                            AddFilter($sql, DropDownFilter($fld, $val, $fldOpr, $dbid), "OR");
                                        }
                                        $parts[] = $sql;
                                    } else {
                                        $parts[] = DropDownFilter($fld, $fldVal, $fldOpr, $dbid);
                                    }
                                } else {
                                    $fld->AdvancedSearch->SearchOperator = $fldOpr;
                                    $fld->AdvancedSearch->SearchValue = $fldVal;
                                    $parts[] = GetReportFilter($fld, false, $dbid);
                                }
                            } else { // Search normal fields
                                if ($fld->isMultiSelect()) {
                                    $fld->AdvancedSearch->SearchValue = ConvertSearchValue($fldVal, $fldOpr, $fld);
                                    $parts[] = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fld->AdvancedSearch->SearchValue, $this->Dbid) : "";
                                } else {
                                    $fldVal2 = ContainsString($fldOpr, "BETWEEN") ? $rule["value"][1] : ""; // BETWEEN
                                    if (is_array($fldVal2)) {
                                        $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
                                    }
                                    $fld->AdvancedSearch->SearchValue = ConvertSearchValue($fldVal, $fldOpr, $fld);
                                    $fld->AdvancedSearch->SearchValue2 = ConvertSearchValue($fldVal2, $fldOpr, $fld);
                                    $parts[] = GetSearchSql(
                                        $fld,
                                        $fld->AdvancedSearch->SearchValue, // SearchValue
                                        $fldOpr,
                                        "", // $fldCond not used
                                        $fld->AdvancedSearch->SearchValue2, // SearchValue2
                                        "", // $fldOpr2 not used
                                        $this->Dbid
                                    );
                                }
                            }
                        } finally {
                            $fld->UseFilter = $useFilter;
                        }
                    }
                }
            }
        }
        $where = "";
        foreach ($parts as $part) {
            AddFilter($where, $part, $group["condition"]);
        }
        if ($where && ($group["not"] ?? false)) {
            $where = "NOT (" . $where . ")";
        }
        return $where;
    }

    // Page Load event
    public function pageLoad(): void
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload(): void
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(string &$url): void
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(string &$message, string $type): void
    {
        if ($type == "success") {
            //$message = "your success message";
        } elseif ($type == "failure") {
            //$message = "your failure message";
        } elseif ($type == "warning") {
            //$message = "your warning message";
        } else {
            //$message = "your message";
        }
    }

    // Page Render event
    public function pageRender(): void
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(string &$header): void
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(string &$footer): void
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(bool &$break, string &$content): void
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Form Custom Validate event
    public function formCustomValidate(string &$customError): bool
    {
        // Return error message in $customError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad(): void
    {
        // Example:
        //$opt = &$this->ListOptions->add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->moveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering(): void
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered(): void
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction(string $action, array $row): bool
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $doc = export object
    public function pageExporting(object &$doc): bool
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport(object $doc, array $row): void
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $row["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported(object $doc): void
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }

    // Page Importing event
    public function pageImporting(object &$builder, array &$options): bool
    {
        //var_dump($options); // Show all options for importing
        //$builder = fn($workflow) => $workflow->addStep($myStep);
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(array &$row, int $count): bool
    {
        //Log($count); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported(object $object, array $results): void
    {
        //var_dump($object); // Workflow result object
        //var_dump($results); // Import results
    }
}
