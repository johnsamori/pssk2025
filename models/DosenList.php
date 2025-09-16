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
class DosenList extends Dosen
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "list";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "DosenList";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // Grid form hidden field names
    public string $FormName = "fdosenlist";

    // CSS class/style
    public string $CurrentPageName = "dosenlist";

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
        $this->No->setVisibility();
        $this->NIP->setVisibility();
        $this->NIDN->setVisibility();
        $this->Nama_Lengkap->setVisibility();
        $this->Gelar_Depan->setVisibility();
        $this->Gelar_Belakang->setVisibility();
        $this->Program_studi->setVisibility();
        $this->NIK->setVisibility();
        $this->Tanggal_lahir->setVisibility();
        $this->Tempat_lahir->setVisibility();
        $this->Nomor_Karpeg->setVisibility();
        $this->Nomor_Stambuk->setVisibility();
        $this->Jenis_kelamin->setVisibility();
        $this->Gol_Darah->setVisibility();
        $this->Agama->setVisibility();
        $this->Stattus_menikah->setVisibility();
        $this->Alamat->setVisibility();
        $this->Kota->setVisibility();
        $this->Telepon_seluler->setVisibility();
        $this->Jenis_pegawai->setVisibility();
        $this->Status_pegawai->setVisibility();
        $this->Golongan->setVisibility();
        $this->Pangkat->setVisibility();
        $this->Status_dosen->setVisibility();
        $this->Status_Belajar->setVisibility();
        $this->e_mail->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'dosen';
        $this->TableName = 'dosen';

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

        // Table object (dosen)
        if (!isset($GLOBALS["dosen"]) || $GLOBALS["dosen"]::class == PROJECT_NAMESPACE . "dosen") {
            $GLOBALS["dosen"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "dosenadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "dosendelete";
        $this->MultiUpdateUrl = "dosenupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'dosen');
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
                    $result["view"] = SameString($pageName, "dosenview"); // If View page, no primary button
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
            $key .= @$ar['No'];
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
            $this->FormName = "fdosengrid";
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
		if (ReadCookie('dosen_searchpanel') == 'notactive' || ReadCookie('dosen_searchpanel') == "") {
			RemoveClass($this->SearchPanelClass, "show");
			AppendClass($this->SearchPanelClass, "collapse");
		} elseif (ReadCookie('dosen_searchpanel') == 'active') {
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
            $savedFilterList = Profile()->getSearchFilters("fdosensrch");
        }
        $filterList = Concat($filterList, $this->No->AdvancedSearch->toJson(), ","); // Field No
        $filterList = Concat($filterList, $this->NIP->AdvancedSearch->toJson(), ","); // Field NIP
        $filterList = Concat($filterList, $this->NIDN->AdvancedSearch->toJson(), ","); // Field NIDN
        $filterList = Concat($filterList, $this->Nama_Lengkap->AdvancedSearch->toJson(), ","); // Field Nama_Lengkap
        $filterList = Concat($filterList, $this->Gelar_Depan->AdvancedSearch->toJson(), ","); // Field Gelar_Depan
        $filterList = Concat($filterList, $this->Gelar_Belakang->AdvancedSearch->toJson(), ","); // Field Gelar_Belakang
        $filterList = Concat($filterList, $this->Program_studi->AdvancedSearch->toJson(), ","); // Field Program_studi
        $filterList = Concat($filterList, $this->NIK->AdvancedSearch->toJson(), ","); // Field NIK
        $filterList = Concat($filterList, $this->Tanggal_lahir->AdvancedSearch->toJson(), ","); // Field Tanggal_lahir
        $filterList = Concat($filterList, $this->Tempat_lahir->AdvancedSearch->toJson(), ","); // Field Tempat_lahir
        $filterList = Concat($filterList, $this->Nomor_Karpeg->AdvancedSearch->toJson(), ","); // Field Nomor_Karpeg
        $filterList = Concat($filterList, $this->Nomor_Stambuk->AdvancedSearch->toJson(), ","); // Field Nomor_Stambuk
        $filterList = Concat($filterList, $this->Jenis_kelamin->AdvancedSearch->toJson(), ","); // Field Jenis_kelamin
        $filterList = Concat($filterList, $this->Gol_Darah->AdvancedSearch->toJson(), ","); // Field Gol_Darah
        $filterList = Concat($filterList, $this->Agama->AdvancedSearch->toJson(), ","); // Field Agama
        $filterList = Concat($filterList, $this->Stattus_menikah->AdvancedSearch->toJson(), ","); // Field Stattus_menikah
        $filterList = Concat($filterList, $this->Alamat->AdvancedSearch->toJson(), ","); // Field Alamat
        $filterList = Concat($filterList, $this->Kota->AdvancedSearch->toJson(), ","); // Field Kota
        $filterList = Concat($filterList, $this->Telepon_seluler->AdvancedSearch->toJson(), ","); // Field Telepon_seluler
        $filterList = Concat($filterList, $this->Jenis_pegawai->AdvancedSearch->toJson(), ","); // Field Jenis_pegawai
        $filterList = Concat($filterList, $this->Status_pegawai->AdvancedSearch->toJson(), ","); // Field Status_pegawai
        $filterList = Concat($filterList, $this->Golongan->AdvancedSearch->toJson(), ","); // Field Golongan
        $filterList = Concat($filterList, $this->Pangkat->AdvancedSearch->toJson(), ","); // Field Pangkat
        $filterList = Concat($filterList, $this->Status_dosen->AdvancedSearch->toJson(), ","); // Field Status_dosen
        $filterList = Concat($filterList, $this->Status_Belajar->AdvancedSearch->toJson(), ","); // Field Status_Belajar
        $filterList = Concat($filterList, $this->e_mail->AdvancedSearch->toJson(), ","); // Field e_mail
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
            Profile()->setSearchFilters("fdosensrch", $filters);
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

        // Field No
        $this->No->AdvancedSearch->SearchValue = $filter["x_No"] ?? "";
        $this->No->AdvancedSearch->SearchOperator = $filter["z_No"] ?? "";
        $this->No->AdvancedSearch->SearchCondition = $filter["v_No"] ?? "";
        $this->No->AdvancedSearch->SearchValue2 = $filter["y_No"] ?? "";
        $this->No->AdvancedSearch->SearchOperator2 = $filter["w_No"] ?? "";
        $this->No->AdvancedSearch->save();

        // Field NIP
        $this->NIP->AdvancedSearch->SearchValue = $filter["x_NIP"] ?? "";
        $this->NIP->AdvancedSearch->SearchOperator = $filter["z_NIP"] ?? "";
        $this->NIP->AdvancedSearch->SearchCondition = $filter["v_NIP"] ?? "";
        $this->NIP->AdvancedSearch->SearchValue2 = $filter["y_NIP"] ?? "";
        $this->NIP->AdvancedSearch->SearchOperator2 = $filter["w_NIP"] ?? "";
        $this->NIP->AdvancedSearch->save();

        // Field NIDN
        $this->NIDN->AdvancedSearch->SearchValue = $filter["x_NIDN"] ?? "";
        $this->NIDN->AdvancedSearch->SearchOperator = $filter["z_NIDN"] ?? "";
        $this->NIDN->AdvancedSearch->SearchCondition = $filter["v_NIDN"] ?? "";
        $this->NIDN->AdvancedSearch->SearchValue2 = $filter["y_NIDN"] ?? "";
        $this->NIDN->AdvancedSearch->SearchOperator2 = $filter["w_NIDN"] ?? "";
        $this->NIDN->AdvancedSearch->save();

        // Field Nama_Lengkap
        $this->Nama_Lengkap->AdvancedSearch->SearchValue = $filter["x_Nama_Lengkap"] ?? "";
        $this->Nama_Lengkap->AdvancedSearch->SearchOperator = $filter["z_Nama_Lengkap"] ?? "";
        $this->Nama_Lengkap->AdvancedSearch->SearchCondition = $filter["v_Nama_Lengkap"] ?? "";
        $this->Nama_Lengkap->AdvancedSearch->SearchValue2 = $filter["y_Nama_Lengkap"] ?? "";
        $this->Nama_Lengkap->AdvancedSearch->SearchOperator2 = $filter["w_Nama_Lengkap"] ?? "";
        $this->Nama_Lengkap->AdvancedSearch->save();

        // Field Gelar_Depan
        $this->Gelar_Depan->AdvancedSearch->SearchValue = $filter["x_Gelar_Depan"] ?? "";
        $this->Gelar_Depan->AdvancedSearch->SearchOperator = $filter["z_Gelar_Depan"] ?? "";
        $this->Gelar_Depan->AdvancedSearch->SearchCondition = $filter["v_Gelar_Depan"] ?? "";
        $this->Gelar_Depan->AdvancedSearch->SearchValue2 = $filter["y_Gelar_Depan"] ?? "";
        $this->Gelar_Depan->AdvancedSearch->SearchOperator2 = $filter["w_Gelar_Depan"] ?? "";
        $this->Gelar_Depan->AdvancedSearch->save();

        // Field Gelar_Belakang
        $this->Gelar_Belakang->AdvancedSearch->SearchValue = $filter["x_Gelar_Belakang"] ?? "";
        $this->Gelar_Belakang->AdvancedSearch->SearchOperator = $filter["z_Gelar_Belakang"] ?? "";
        $this->Gelar_Belakang->AdvancedSearch->SearchCondition = $filter["v_Gelar_Belakang"] ?? "";
        $this->Gelar_Belakang->AdvancedSearch->SearchValue2 = $filter["y_Gelar_Belakang"] ?? "";
        $this->Gelar_Belakang->AdvancedSearch->SearchOperator2 = $filter["w_Gelar_Belakang"] ?? "";
        $this->Gelar_Belakang->AdvancedSearch->save();

        // Field Program_studi
        $this->Program_studi->AdvancedSearch->SearchValue = $filter["x_Program_studi"] ?? "";
        $this->Program_studi->AdvancedSearch->SearchOperator = $filter["z_Program_studi"] ?? "";
        $this->Program_studi->AdvancedSearch->SearchCondition = $filter["v_Program_studi"] ?? "";
        $this->Program_studi->AdvancedSearch->SearchValue2 = $filter["y_Program_studi"] ?? "";
        $this->Program_studi->AdvancedSearch->SearchOperator2 = $filter["w_Program_studi"] ?? "";
        $this->Program_studi->AdvancedSearch->save();

        // Field NIK
        $this->NIK->AdvancedSearch->SearchValue = $filter["x_NIK"] ?? "";
        $this->NIK->AdvancedSearch->SearchOperator = $filter["z_NIK"] ?? "";
        $this->NIK->AdvancedSearch->SearchCondition = $filter["v_NIK"] ?? "";
        $this->NIK->AdvancedSearch->SearchValue2 = $filter["y_NIK"] ?? "";
        $this->NIK->AdvancedSearch->SearchOperator2 = $filter["w_NIK"] ?? "";
        $this->NIK->AdvancedSearch->save();

        // Field Tanggal_lahir
        $this->Tanggal_lahir->AdvancedSearch->SearchValue = $filter["x_Tanggal_lahir"] ?? "";
        $this->Tanggal_lahir->AdvancedSearch->SearchOperator = $filter["z_Tanggal_lahir"] ?? "";
        $this->Tanggal_lahir->AdvancedSearch->SearchCondition = $filter["v_Tanggal_lahir"] ?? "";
        $this->Tanggal_lahir->AdvancedSearch->SearchValue2 = $filter["y_Tanggal_lahir"] ?? "";
        $this->Tanggal_lahir->AdvancedSearch->SearchOperator2 = $filter["w_Tanggal_lahir"] ?? "";
        $this->Tanggal_lahir->AdvancedSearch->save();

        // Field Tempat_lahir
        $this->Tempat_lahir->AdvancedSearch->SearchValue = $filter["x_Tempat_lahir"] ?? "";
        $this->Tempat_lahir->AdvancedSearch->SearchOperator = $filter["z_Tempat_lahir"] ?? "";
        $this->Tempat_lahir->AdvancedSearch->SearchCondition = $filter["v_Tempat_lahir"] ?? "";
        $this->Tempat_lahir->AdvancedSearch->SearchValue2 = $filter["y_Tempat_lahir"] ?? "";
        $this->Tempat_lahir->AdvancedSearch->SearchOperator2 = $filter["w_Tempat_lahir"] ?? "";
        $this->Tempat_lahir->AdvancedSearch->save();

        // Field Nomor_Karpeg
        $this->Nomor_Karpeg->AdvancedSearch->SearchValue = $filter["x_Nomor_Karpeg"] ?? "";
        $this->Nomor_Karpeg->AdvancedSearch->SearchOperator = $filter["z_Nomor_Karpeg"] ?? "";
        $this->Nomor_Karpeg->AdvancedSearch->SearchCondition = $filter["v_Nomor_Karpeg"] ?? "";
        $this->Nomor_Karpeg->AdvancedSearch->SearchValue2 = $filter["y_Nomor_Karpeg"] ?? "";
        $this->Nomor_Karpeg->AdvancedSearch->SearchOperator2 = $filter["w_Nomor_Karpeg"] ?? "";
        $this->Nomor_Karpeg->AdvancedSearch->save();

        // Field Nomor_Stambuk
        $this->Nomor_Stambuk->AdvancedSearch->SearchValue = $filter["x_Nomor_Stambuk"] ?? "";
        $this->Nomor_Stambuk->AdvancedSearch->SearchOperator = $filter["z_Nomor_Stambuk"] ?? "";
        $this->Nomor_Stambuk->AdvancedSearch->SearchCondition = $filter["v_Nomor_Stambuk"] ?? "";
        $this->Nomor_Stambuk->AdvancedSearch->SearchValue2 = $filter["y_Nomor_Stambuk"] ?? "";
        $this->Nomor_Stambuk->AdvancedSearch->SearchOperator2 = $filter["w_Nomor_Stambuk"] ?? "";
        $this->Nomor_Stambuk->AdvancedSearch->save();

        // Field Jenis_kelamin
        $this->Jenis_kelamin->AdvancedSearch->SearchValue = $filter["x_Jenis_kelamin"] ?? "";
        $this->Jenis_kelamin->AdvancedSearch->SearchOperator = $filter["z_Jenis_kelamin"] ?? "";
        $this->Jenis_kelamin->AdvancedSearch->SearchCondition = $filter["v_Jenis_kelamin"] ?? "";
        $this->Jenis_kelamin->AdvancedSearch->SearchValue2 = $filter["y_Jenis_kelamin"] ?? "";
        $this->Jenis_kelamin->AdvancedSearch->SearchOperator2 = $filter["w_Jenis_kelamin"] ?? "";
        $this->Jenis_kelamin->AdvancedSearch->save();

        // Field Gol_Darah
        $this->Gol_Darah->AdvancedSearch->SearchValue = $filter["x_Gol_Darah"] ?? "";
        $this->Gol_Darah->AdvancedSearch->SearchOperator = $filter["z_Gol_Darah"] ?? "";
        $this->Gol_Darah->AdvancedSearch->SearchCondition = $filter["v_Gol_Darah"] ?? "";
        $this->Gol_Darah->AdvancedSearch->SearchValue2 = $filter["y_Gol_Darah"] ?? "";
        $this->Gol_Darah->AdvancedSearch->SearchOperator2 = $filter["w_Gol_Darah"] ?? "";
        $this->Gol_Darah->AdvancedSearch->save();

        // Field Agama
        $this->Agama->AdvancedSearch->SearchValue = $filter["x_Agama"] ?? "";
        $this->Agama->AdvancedSearch->SearchOperator = $filter["z_Agama"] ?? "";
        $this->Agama->AdvancedSearch->SearchCondition = $filter["v_Agama"] ?? "";
        $this->Agama->AdvancedSearch->SearchValue2 = $filter["y_Agama"] ?? "";
        $this->Agama->AdvancedSearch->SearchOperator2 = $filter["w_Agama"] ?? "";
        $this->Agama->AdvancedSearch->save();

        // Field Stattus_menikah
        $this->Stattus_menikah->AdvancedSearch->SearchValue = $filter["x_Stattus_menikah"] ?? "";
        $this->Stattus_menikah->AdvancedSearch->SearchOperator = $filter["z_Stattus_menikah"] ?? "";
        $this->Stattus_menikah->AdvancedSearch->SearchCondition = $filter["v_Stattus_menikah"] ?? "";
        $this->Stattus_menikah->AdvancedSearch->SearchValue2 = $filter["y_Stattus_menikah"] ?? "";
        $this->Stattus_menikah->AdvancedSearch->SearchOperator2 = $filter["w_Stattus_menikah"] ?? "";
        $this->Stattus_menikah->AdvancedSearch->save();

        // Field Alamat
        $this->Alamat->AdvancedSearch->SearchValue = $filter["x_Alamat"] ?? "";
        $this->Alamat->AdvancedSearch->SearchOperator = $filter["z_Alamat"] ?? "";
        $this->Alamat->AdvancedSearch->SearchCondition = $filter["v_Alamat"] ?? "";
        $this->Alamat->AdvancedSearch->SearchValue2 = $filter["y_Alamat"] ?? "";
        $this->Alamat->AdvancedSearch->SearchOperator2 = $filter["w_Alamat"] ?? "";
        $this->Alamat->AdvancedSearch->save();

        // Field Kota
        $this->Kota->AdvancedSearch->SearchValue = $filter["x_Kota"] ?? "";
        $this->Kota->AdvancedSearch->SearchOperator = $filter["z_Kota"] ?? "";
        $this->Kota->AdvancedSearch->SearchCondition = $filter["v_Kota"] ?? "";
        $this->Kota->AdvancedSearch->SearchValue2 = $filter["y_Kota"] ?? "";
        $this->Kota->AdvancedSearch->SearchOperator2 = $filter["w_Kota"] ?? "";
        $this->Kota->AdvancedSearch->save();

        // Field Telepon_seluler
        $this->Telepon_seluler->AdvancedSearch->SearchValue = $filter["x_Telepon_seluler"] ?? "";
        $this->Telepon_seluler->AdvancedSearch->SearchOperator = $filter["z_Telepon_seluler"] ?? "";
        $this->Telepon_seluler->AdvancedSearch->SearchCondition = $filter["v_Telepon_seluler"] ?? "";
        $this->Telepon_seluler->AdvancedSearch->SearchValue2 = $filter["y_Telepon_seluler"] ?? "";
        $this->Telepon_seluler->AdvancedSearch->SearchOperator2 = $filter["w_Telepon_seluler"] ?? "";
        $this->Telepon_seluler->AdvancedSearch->save();

        // Field Jenis_pegawai
        $this->Jenis_pegawai->AdvancedSearch->SearchValue = $filter["x_Jenis_pegawai"] ?? "";
        $this->Jenis_pegawai->AdvancedSearch->SearchOperator = $filter["z_Jenis_pegawai"] ?? "";
        $this->Jenis_pegawai->AdvancedSearch->SearchCondition = $filter["v_Jenis_pegawai"] ?? "";
        $this->Jenis_pegawai->AdvancedSearch->SearchValue2 = $filter["y_Jenis_pegawai"] ?? "";
        $this->Jenis_pegawai->AdvancedSearch->SearchOperator2 = $filter["w_Jenis_pegawai"] ?? "";
        $this->Jenis_pegawai->AdvancedSearch->save();

        // Field Status_pegawai
        $this->Status_pegawai->AdvancedSearch->SearchValue = $filter["x_Status_pegawai"] ?? "";
        $this->Status_pegawai->AdvancedSearch->SearchOperator = $filter["z_Status_pegawai"] ?? "";
        $this->Status_pegawai->AdvancedSearch->SearchCondition = $filter["v_Status_pegawai"] ?? "";
        $this->Status_pegawai->AdvancedSearch->SearchValue2 = $filter["y_Status_pegawai"] ?? "";
        $this->Status_pegawai->AdvancedSearch->SearchOperator2 = $filter["w_Status_pegawai"] ?? "";
        $this->Status_pegawai->AdvancedSearch->save();

        // Field Golongan
        $this->Golongan->AdvancedSearch->SearchValue = $filter["x_Golongan"] ?? "";
        $this->Golongan->AdvancedSearch->SearchOperator = $filter["z_Golongan"] ?? "";
        $this->Golongan->AdvancedSearch->SearchCondition = $filter["v_Golongan"] ?? "";
        $this->Golongan->AdvancedSearch->SearchValue2 = $filter["y_Golongan"] ?? "";
        $this->Golongan->AdvancedSearch->SearchOperator2 = $filter["w_Golongan"] ?? "";
        $this->Golongan->AdvancedSearch->save();

        // Field Pangkat
        $this->Pangkat->AdvancedSearch->SearchValue = $filter["x_Pangkat"] ?? "";
        $this->Pangkat->AdvancedSearch->SearchOperator = $filter["z_Pangkat"] ?? "";
        $this->Pangkat->AdvancedSearch->SearchCondition = $filter["v_Pangkat"] ?? "";
        $this->Pangkat->AdvancedSearch->SearchValue2 = $filter["y_Pangkat"] ?? "";
        $this->Pangkat->AdvancedSearch->SearchOperator2 = $filter["w_Pangkat"] ?? "";
        $this->Pangkat->AdvancedSearch->save();

        // Field Status_dosen
        $this->Status_dosen->AdvancedSearch->SearchValue = $filter["x_Status_dosen"] ?? "";
        $this->Status_dosen->AdvancedSearch->SearchOperator = $filter["z_Status_dosen"] ?? "";
        $this->Status_dosen->AdvancedSearch->SearchCondition = $filter["v_Status_dosen"] ?? "";
        $this->Status_dosen->AdvancedSearch->SearchValue2 = $filter["y_Status_dosen"] ?? "";
        $this->Status_dosen->AdvancedSearch->SearchOperator2 = $filter["w_Status_dosen"] ?? "";
        $this->Status_dosen->AdvancedSearch->save();

        // Field Status_Belajar
        $this->Status_Belajar->AdvancedSearch->SearchValue = $filter["x_Status_Belajar"] ?? "";
        $this->Status_Belajar->AdvancedSearch->SearchOperator = $filter["z_Status_Belajar"] ?? "";
        $this->Status_Belajar->AdvancedSearch->SearchCondition = $filter["v_Status_Belajar"] ?? "";
        $this->Status_Belajar->AdvancedSearch->SearchValue2 = $filter["y_Status_Belajar"] ?? "";
        $this->Status_Belajar->AdvancedSearch->SearchOperator2 = $filter["w_Status_Belajar"] ?? "";
        $this->Status_Belajar->AdvancedSearch->save();

        // Field e_mail
        $this->e_mail->AdvancedSearch->SearchValue = $filter["x_e_mail"] ?? "";
        $this->e_mail->AdvancedSearch->SearchOperator = $filter["z_e_mail"] ?? "";
        $this->e_mail->AdvancedSearch->SearchCondition = $filter["v_e_mail"] ?? "";
        $this->e_mail->AdvancedSearch->SearchValue2 = $filter["y_e_mail"] ?? "";
        $this->e_mail->AdvancedSearch->SearchOperator2 = $filter["w_e_mail"] ?? "";
        $this->e_mail->AdvancedSearch->save();
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
        $searchFlds[] = &$this->No;
        $searchFlds[] = &$this->NIP;
        $searchFlds[] = &$this->NIDN;
        $searchFlds[] = &$this->Nama_Lengkap;
        $searchFlds[] = &$this->Gelar_Depan;
        $searchFlds[] = &$this->Gelar_Belakang;
        $searchFlds[] = &$this->Program_studi;
        $searchFlds[] = &$this->NIK;
        $searchFlds[] = &$this->Tempat_lahir;
        $searchFlds[] = &$this->Nomor_Karpeg;
        $searchFlds[] = &$this->Nomor_Stambuk;
        $searchFlds[] = &$this->Jenis_kelamin;
        $searchFlds[] = &$this->Gol_Darah;
        $searchFlds[] = &$this->Agama;
        $searchFlds[] = &$this->Stattus_menikah;
        $searchFlds[] = &$this->Alamat;
        $searchFlds[] = &$this->Kota;
        $searchFlds[] = &$this->Telepon_seluler;
        $searchFlds[] = &$this->Jenis_pegawai;
        $searchFlds[] = &$this->Status_pegawai;
        $searchFlds[] = &$this->Golongan;
        $searchFlds[] = &$this->Pangkat;
        $searchFlds[] = &$this->Status_dosen;
        $searchFlds[] = &$this->Status_Belajar;
        $searchFlds[] = &$this->e_mail;
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
            $this->updateSort($this->No); // No
            $this->updateSort($this->NIP); // NIP
            $this->updateSort($this->NIDN); // NIDN
            $this->updateSort($this->Nama_Lengkap); // Nama_Lengkap
            $this->updateSort($this->Gelar_Depan); // Gelar_Depan
            $this->updateSort($this->Gelar_Belakang); // Gelar_Belakang
            $this->updateSort($this->Program_studi); // Program_studi
            $this->updateSort($this->NIK); // NIK
            $this->updateSort($this->Tanggal_lahir); // Tanggal_lahir
            $this->updateSort($this->Tempat_lahir); // Tempat_lahir
            $this->updateSort($this->Nomor_Karpeg); // Nomor_Karpeg
            $this->updateSort($this->Nomor_Stambuk); // Nomor_Stambuk
            $this->updateSort($this->Jenis_kelamin); // Jenis_kelamin
            $this->updateSort($this->Gol_Darah); // Gol_Darah
            $this->updateSort($this->Agama); // Agama
            $this->updateSort($this->Stattus_menikah); // Stattus_menikah
            $this->updateSort($this->Alamat); // Alamat
            $this->updateSort($this->Kota); // Kota
            $this->updateSort($this->Telepon_seluler); // Telepon_seluler
            $this->updateSort($this->Jenis_pegawai); // Jenis_pegawai
            $this->updateSort($this->Status_pegawai); // Status_pegawai
            $this->updateSort($this->Golongan); // Golongan
            $this->updateSort($this->Pangkat); // Pangkat
            $this->updateSort($this->Status_dosen); // Status_dosen
            $this->updateSort($this->Status_Belajar); // Status_Belajar
            $this->updateSort($this->e_mail); // e_mail
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
                $this->No->setSort("");
                $this->NIP->setSort("");
                $this->NIDN->setSort("");
                $this->Nama_Lengkap->setSort("");
                $this->Gelar_Depan->setSort("");
                $this->Gelar_Belakang->setSort("");
                $this->Program_studi->setSort("");
                $this->NIK->setSort("");
                $this->Tanggal_lahir->setSort("");
                $this->Tempat_lahir->setSort("");
                $this->Nomor_Karpeg->setSort("");
                $this->Nomor_Stambuk->setSort("");
                $this->Jenis_kelamin->setSort("");
                $this->Gol_Darah->setSort("");
                $this->Agama->setSort("");
                $this->Stattus_menikah->setSort("");
                $this->Alamat->setSort("");
                $this->Kota->setSort("");
                $this->Telepon_seluler->setSort("");
                $this->Jenis_pegawai->setSort("");
                $this->Status_pegawai->setSort("");
                $this->Golongan->setSort("");
                $this->Pangkat->setSort("");
                $this->Status_dosen->setSort("");
                $this->Status_Belajar->setSort("");
                $this->e_mail->setSort("");
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"dosen\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $this->language->phrase("ViewLink") . "</a>";
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
					$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"dosen\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-ask=\"1\" data-btn=\"SaveBtn\">" . $this->language->phrase("EditLink") . "</a>";
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
					$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"dosen\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-ask=\"1\" data-btn=\"AddBtn\">" . $this->language->phrase("CopyLink") . "</a>";
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
                        "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fdosenlist\" data-key=\"" . $this->keyToJson(true) .
                        "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                    $links[] = $link;
                    if ($body == "") { // Setup first button
                        $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action" . ($listAction->getEnabled() ? "" : " disabled") .
                            "\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fdosenlist\" data-key=\"" . $this->keyToJson(true) .
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->No->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";

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
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"dosen\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-ask=\"1\" data-btn=\"AddBtn\">" . $this->language->phrase("AddLink") . "</a>";
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
            $this->createColumnOption($option, "No");
            $this->createColumnOption($option, "NIP");
            $this->createColumnOption($option, "NIDN");
            $this->createColumnOption($option, "Nama_Lengkap");
            $this->createColumnOption($option, "Gelar_Depan");
            $this->createColumnOption($option, "Gelar_Belakang");
            $this->createColumnOption($option, "Program_studi");
            $this->createColumnOption($option, "NIK");
            $this->createColumnOption($option, "Tanggal_lahir");
            $this->createColumnOption($option, "Tempat_lahir");
            $this->createColumnOption($option, "Nomor_Karpeg");
            $this->createColumnOption($option, "Nomor_Stambuk");
            $this->createColumnOption($option, "Jenis_kelamin");
            $this->createColumnOption($option, "Gol_Darah");
            $this->createColumnOption($option, "Agama");
            $this->createColumnOption($option, "Stattus_menikah");
            $this->createColumnOption($option, "Alamat");
            $this->createColumnOption($option, "Kota");
            $this->createColumnOption($option, "Telepon_seluler");
            $this->createColumnOption($option, "Jenis_pegawai");
            $this->createColumnOption($option, "Status_pegawai");
            $this->createColumnOption($option, "Golongan");
            $this->createColumnOption($option, "Pangkat");
            $this->createColumnOption($option, "Status_dosen");
            $this->createColumnOption($option, "Status_Belajar");
            $this->createColumnOption($option, "e_mail");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fdosensrch\" data-ew-action=\"none\">" . $this->language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fdosensrch\" data-ew-action=\"none\">" . $this->language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fdosenlist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_dosen", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_dosen",
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

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['No'] = $this->No->DefaultValue;
        $row['NIP'] = $this->NIP->DefaultValue;
        $row['NIDN'] = $this->NIDN->DefaultValue;
        $row['Nama_Lengkap'] = $this->Nama_Lengkap->DefaultValue;
        $row['Gelar_Depan'] = $this->Gelar_Depan->DefaultValue;
        $row['Gelar_Belakang'] = $this->Gelar_Belakang->DefaultValue;
        $row['Program_studi'] = $this->Program_studi->DefaultValue;
        $row['NIK'] = $this->NIK->DefaultValue;
        $row['Tanggal_lahir'] = $this->Tanggal_lahir->DefaultValue;
        $row['Tempat_lahir'] = $this->Tempat_lahir->DefaultValue;
        $row['Nomor_Karpeg'] = $this->Nomor_Karpeg->DefaultValue;
        $row['Nomor_Stambuk'] = $this->Nomor_Stambuk->DefaultValue;
        $row['Jenis_kelamin'] = $this->Jenis_kelamin->DefaultValue;
        $row['Gol_Darah'] = $this->Gol_Darah->DefaultValue;
        $row['Agama'] = $this->Agama->DefaultValue;
        $row['Stattus_menikah'] = $this->Stattus_menikah->DefaultValue;
        $row['Alamat'] = $this->Alamat->DefaultValue;
        $row['Kota'] = $this->Kota->DefaultValue;
        $row['Telepon_seluler'] = $this->Telepon_seluler->DefaultValue;
        $row['Jenis_pegawai'] = $this->Jenis_pegawai->DefaultValue;
        $row['Status_pegawai'] = $this->Status_pegawai->DefaultValue;
        $row['Golongan'] = $this->Golongan->DefaultValue;
        $row['Pangkat'] = $this->Pangkat->DefaultValue;
        $row['Status_dosen'] = $this->Status_dosen->DefaultValue;
        $row['Status_Belajar'] = $this->Status_Belajar->DefaultValue;
        $row['e_mail'] = $this->e_mail->DefaultValue;
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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
		if (ReadCookie('dosen_searchpanel') == 'notactive' || ReadCookie('dosen_searchpanel') == "") {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fdosensrch\" aria-pressed=\"false\">" . $this->language->phrase("SearchLink") . "</a>";
		} elseif (ReadCookie('dosen_searchpanel') == 'active') {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle active\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fdosensrch\" aria-pressed=\"true\">" . $this->language->phrase("SearchLink") . "</a>";
		} else {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fdosensrch\" aria-pressed=\"false\">" . $this->language->phrase("SearchLink") . "</a>";
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
