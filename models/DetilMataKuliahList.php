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
class DetilMataKuliahList extends DetilMataKuliah
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "list";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "DetilMataKuliahList";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // Grid form hidden field names
    public string $FormName = "fdetil_mata_kuliahlist";

    // CSS class/style
    public string $CurrentPageName = "detilmatakuliahlist";

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
        $this->id_no->setVisibility();
        $this->Kode_MK->setVisibility();
        $this->NIM->setVisibility();
        $this->Nilai_Diskusi->setVisibility();
        $this->Assessment_Skor_As_1->setVisibility();
        $this->Assessment_Skor_As_2->setVisibility();
        $this->Assessment_Skor_As_3->setVisibility();
        $this->Nilai_Tugas->setVisibility();
        $this->Nilai_UTS->setVisibility();
        $this->Nilai_Akhir->setVisibility();
        $this->iduser->Visible = false;
        $this->user->Visible = false;
        $this->ip->Visible = false;
        $this->tanggal->Visible = false;
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'detil_mata_kuliah';
        $this->TableName = 'detil_mata_kuliah';

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

        // Table object (detil_mata_kuliah)
        if (!isset($GLOBALS["detil_mata_kuliah"]) || $GLOBALS["detil_mata_kuliah"]::class == PROJECT_NAMESPACE . "detil_mata_kuliah") {
            $GLOBALS["detil_mata_kuliah"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "detilmatakuliahadd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "detilmatakuliahdelete";
        $this->MultiUpdateUrl = "detilmatakuliahupdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'detil_mata_kuliah');
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
                    $result["view"] = SameString($pageName, "detilmatakuliahview"); // If View page, no primary button
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
            $key .= @$ar['id_no'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['Kode_MK'];
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id_no->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->iduser->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->user->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->ip->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->tanggal->Visible = false;
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fdetil_mata_kuliahgrid";
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

        // Check QueryString parameters
        if (Get("action") !== null) {
            $this->CurrentAction = Get("action");
        } else {
            if (Post("action") !== null && Post("action") !== $this->UserAction) {
                $this->CurrentAction = Post("action"); // Get action
            } elseif (Session(AddTabId(SESSION_INLINE_MODE)) == "gridedit") { // Previously in grid edit mode
                if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) { // Stay in grid edit mode if paging
                    $this->gridEditMode();
                } else { // Reset grid edit
                    $this->clearInlineMode();
                }
            }
        }

        // Clear inline mode
        if ($this->isCancel()) {
            $this->clearInlineMode();
        }

        // Switch to grid edit mode
        if ($this->isGridEdit()) {
            $this->gridEditMode();
        }

        // Grid Update
        if (IsPost() && ($this->isGridUpdate() || $this->isMultiUpdate() || $this->isGridOverwrite()) && (Session(AddTabId(SESSION_INLINE_MODE)) == "gridedit" || Session(AddTabId(SESSION_INLINE_MODE)) == "multiedit")) {
            if ($this->validateGridForm()) {
                $gridUpdate = $this->gridUpdate();
            } else {
                $gridUpdate = false;
            }
            if ($gridUpdate) {
				CleanUploadTempPaths(SessionId());
                // Handle modal grid edit and multi edit, redirect to list page directly
                if ($this->IsModal && !$this->UseAjaxActions) {
                    $this->terminate("detilmatakuliahlist");
                    return;
                }
            } else {
                $this->EventCancelled = true;
                if ($this->UseAjaxActions) {
                    WriteJson([
                        "success" => false,
                        "validation" => $this->ValidationErrors,
                        "error" => $this->getFailureMessage()
                    ]);
                    $this->terminate();
                    return;
                }
                if ($this->isMultiUpdate()) { // Stay in Multi-Edit mode
                    $this->FilterForModalActions = $this->getFilterFromRecords($this->getGridFormValues());
                    $this->multiEditMode();
                } else { // Stay in grid edit mode
                    $this->gridEditMode();
                }
            }
        }

        // Switch to grid add mode
        if ($this->isGridAdd()) {
            $this->gridAddMode();
            // Grid Insert
        } elseif (IsPost() && $this->isGridInsert() && Session(AddTabId(SESSION_INLINE_MODE)) == "gridadd") {
            if ($this->validateGridForm()) {
                $gridInsert = $this->gridInsert();
            } else {
                $gridInsert = false;
            }
            if ($gridInsert) {
				CleanUploadTempPaths(SessionId());
                // Handle modal grid add, redirect to list page directly
                if ($this->IsModal && !$this->UseAjaxActions) {
                    $this->terminate("detilmatakuliahlist");
                    return;
                }
            } else {
                $this->EventCancelled = true;
                if ($this->UseAjaxActions) {
                    WriteJson([
                        "success" => false,
                        "validation" => $this->ValidationErrors,
                        "error" => $this->getFailureMessage()
                    ]);
                    $this->terminate();
                    return;
                }
                $this->gridAddMode(); // Stay in grid add mode
            }
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

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = $this->security->allowDelete(CurrentProjectID() . $this->TableName);
                }
            }
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

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "mata_kuliah") {
            $masterTbl = Container("mata_kuliah");
            $masterRow = $masterTbl->loadRecords($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $masterRow !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($this->language->phrase("NoRecord")); // Set no record found
                $this->terminate("matakuliahlist"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($masterRow);
                $masterTbl->RowType = RowType::MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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
		if (ReadCookie('detil_mata_kuliah_searchpanel') == 'notactive' || ReadCookie('detil_mata_kuliah_searchpanel') == "") {
			RemoveClass($this->SearchPanelClass, "show");
			AppendClass($this->SearchPanelClass, "collapse");
		} elseif (ReadCookie('detil_mata_kuliah_searchpanel') == 'active') {
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

    // Exit inline mode
    protected function clearInlineMode(): void
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        Session()->remove(AddTabId(SESSION_INLINE_MODE)); // Clear inline mode
    }

    // Switch to grid add mode
    protected function gridAddMode(): void
    {
        $this->CurrentAction = "gridadd";
        Session(AddTabId(SESSION_INLINE_MODE), "gridadd");
        $this->hideFieldsForAddEdit();
    }

    // Switch to grid edit mode
    protected function gridEditMode(): void
    {
        $this->CurrentAction = "gridedit";
        Session(AddTabId(SESSION_INLINE_MODE), "gridedit");
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate(): bool
    {
        $gridUpdate = true;

        // Get old result set
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($result = $conn->executeQuery($sql)) {
            $oldRows = $result->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($oldRows)) {
            if (!$this->peekFailureMessage()) {
                $this->setFailureMessage($this->language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }
        $wrkfilter = "";
        $successKeys = [];
        $skipRecords = [];

        // Get row count
        $rowcnt = $this->getKeyCount();

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $this->FormIndex = $rowindex;
            $this->setKey($this->getOldKey());
            $rowaction = $this->getRowAction();

            // Load all values and keys
            if ($rowaction != "insertdelete" && $rowaction != "hide") { // Skip insert then deleted rows / hidden rows for grid edit
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                        if ($gridUpdate === null) { // Record skipped, get filter for this record as well
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                        if ($gridUpdate) { // Get inserted or updated filter
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    }
                }
                if ($gridUpdate === null) { // Record skipped
                    $key = $this->getKey();
                    $skipRecords[] = $rowindex . (!IsEmpty($key) ? ": " . $key : ""); // Record count and key if exists
                    $gridUpdate = true; // Skip this record and continue to next record
                } elseif ($gridUpdate === false) {
                    $this->EventCancelled = true;
                    break;
                } elseif ($gridUpdate) {
                    $successKeys[] = $this->getKey();
                }
            }
        }
        if ($gridUpdate) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $newRows = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($oldRows, $newRows);
            if (!$this->peekSuccessMessage()) {
                $this->setSuccessMessage($this->language->phrase("UpdateSuccess")); // Set up update success message
            }

            // Set warning message if some records skipped
            if (count($skipRecords) > 0) {
                $this->setWarningMessage(sprintf($this->language->phrase("RecordsSkipped"), count($skipRecords)));
                Log("Records skipped", $skipRecords);
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
            if (!$this->peekFailureMessage()) {
                $this->setFailureMessage($this->language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Perform grid add
    public function gridInsert(): bool
    {
        $rowindex = 1;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if (!$this->peekFailureMessage()) {
                $this->setFailureMessage($this->language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
		$gridInsert = false;
        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $successKeys = [];
        $skipRecords = [];

        // Get row count
        $rowcnt = $this->getKeyCount();

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $this->FormIndex = $rowindex;
            $rowaction = $this->getRowAction();
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            $oldRow = null;
            if ($rowaction == "insert") {
                $this->OldKey = $this->getOldKey();
                $oldRow = $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $this->SendEmail = false; // Do not send email on insert success
                $gridInsert = $this->addRow($oldRow); // Insert row (already validated by validateGridForm())
                if ($gridInsert === null) { // Record skipped
                    $key = $this->getKey(true);
                    $skipRecords[] = $rowindex . (!IsEmpty($key) ? ": " . $key : ""); // Record count and key if exists
                    $gridInsert = true; // Skip this record and continue to next record
                } elseif ($gridInsert === true) { // Record inserted
                    $addcnt++;
                    $successKeys[] = $this->getKey(true);

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } elseif ($gridInsert === false) { // Record not inserted
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->setFailureMessage($this->language->phrase("NoAddRecord"));
            $gridInsert = false;
		}
        if ($gridInsert) { // Some records inserted
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $this->FilterForModalActions = $wrkfilter;
            $sql = $this->getCurrentSql();
            $newRows = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($newRows);
            if (!$this->peekSuccessMessage()) {
                $this->setSuccessMessage($this->language->phrase("InsertSuccess")); // Set up insert success message
            }

            // Set warning message if some records skipped
            if (count($skipRecords) > 0) {
                $this->setWarningMessage(sprintf($this->language->phrase("RecordsSkipped"), count($skipRecords)));
                Log("Records skipped", $skipRecords);
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
            if (!$this->peekFailureMessage()) {
                $this->setFailureMessage($this->language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow(): bool
    {
        if (
            $this->hasFormValue("x_Kode_MK")
            && $this->hasFormValue("o_Kode_MK")
            && $this->Kode_MK->CurrentValue != $this->Kode_MK->DefaultValue
            && !($this->Kode_MK->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Kode_MK->CurrentValue == $this->Kode_MK->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_NIM")
            && $this->hasFormValue("o_NIM")
            && $this->NIM->CurrentValue != $this->NIM->DefaultValue
            && !($this->NIM->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->NIM->CurrentValue == $this->NIM->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Nilai_Diskusi")
            && $this->hasFormValue("o_Nilai_Diskusi")
            && $this->Nilai_Diskusi->CurrentValue != $this->Nilai_Diskusi->DefaultValue
            && !($this->Nilai_Diskusi->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Nilai_Diskusi->CurrentValue == $this->Nilai_Diskusi->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Assessment_Skor_As_1")
            && $this->hasFormValue("o_Assessment_Skor_As_1")
            && $this->Assessment_Skor_As_1->CurrentValue != $this->Assessment_Skor_As_1->DefaultValue
            && !($this->Assessment_Skor_As_1->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Assessment_Skor_As_1->CurrentValue == $this->Assessment_Skor_As_1->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Assessment_Skor_As_2")
            && $this->hasFormValue("o_Assessment_Skor_As_2")
            && $this->Assessment_Skor_As_2->CurrentValue != $this->Assessment_Skor_As_2->DefaultValue
            && !($this->Assessment_Skor_As_2->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Assessment_Skor_As_2->CurrentValue == $this->Assessment_Skor_As_2->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Assessment_Skor_As_3")
            && $this->hasFormValue("o_Assessment_Skor_As_3")
            && $this->Assessment_Skor_As_3->CurrentValue != $this->Assessment_Skor_As_3->DefaultValue
            && !($this->Assessment_Skor_As_3->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Assessment_Skor_As_3->CurrentValue == $this->Assessment_Skor_As_3->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Nilai_Tugas")
            && $this->hasFormValue("o_Nilai_Tugas")
            && $this->Nilai_Tugas->CurrentValue != $this->Nilai_Tugas->DefaultValue
            && !($this->Nilai_Tugas->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Nilai_Tugas->CurrentValue == $this->Nilai_Tugas->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Nilai_UTS")
            && $this->hasFormValue("o_Nilai_UTS")
            && $this->Nilai_UTS->CurrentValue != $this->Nilai_UTS->DefaultValue
            && !($this->Nilai_UTS->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Nilai_UTS->CurrentValue == $this->Nilai_UTS->getSessionValue())
        ) {
            return false;
        }
        if (
            $this->hasFormValue("x_Nilai_Akhir")
            && $this->hasFormValue("o_Nilai_Akhir")
            && $this->Nilai_Akhir->CurrentValue != $this->Nilai_Akhir->DefaultValue
            && !($this->Nilai_Akhir->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Nilai_Akhir->CurrentValue == $this->Nilai_Akhir->getSessionValue())
        ) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm(): bool
    {
        // Get row count
        $rowcnt = $this->getKeyCount();

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $this->FormIndex = $rowindex;
            $rowaction = $this->getRowAction();
            if ($rowaction != "delete" && $rowaction != "insertdelete" && $rowaction != "hide") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->ValidationErrors[$rowindex] = $this->getValidationErrors();
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues(): array
    {
        // Get row count
        $rowcnt = $this->getKeyCount();
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $this->FormIndex = $rowindex;
            $rowaction = $this->getRowAction();
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->Fields->getFormValues(); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues(int $rowindex): void
    {
        // Get row based on current index
        $this->FormIndex = $rowindex;
        $rowaction = $this->getRowAction();
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError(): void
    {
        foreach ($this->Fields as $field) {
            $field->clearErrorMessage();
        }
    }

    // Get list of filters
    public function getFilterList(): string
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server") {
            $savedFilterList = Profile()->getSearchFilters("fdetil_mata_kuliahsrch");
        }
        $filterList = Concat($filterList, $this->id_no->AdvancedSearch->toJson(), ","); // Field id_no
        $filterList = Concat($filterList, $this->Kode_MK->AdvancedSearch->toJson(), ","); // Field Kode_MK
        $filterList = Concat($filterList, $this->NIM->AdvancedSearch->toJson(), ","); // Field NIM
        $filterList = Concat($filterList, $this->Nilai_Diskusi->AdvancedSearch->toJson(), ","); // Field Nilai_Diskusi
        $filterList = Concat($filterList, $this->Assessment_Skor_As_1->AdvancedSearch->toJson(), ","); // Field Assessment_Skor_As_1
        $filterList = Concat($filterList, $this->Assessment_Skor_As_2->AdvancedSearch->toJson(), ","); // Field Assessment_Skor_As_2
        $filterList = Concat($filterList, $this->Assessment_Skor_As_3->AdvancedSearch->toJson(), ","); // Field Assessment_Skor_As_3
        $filterList = Concat($filterList, $this->Nilai_Tugas->AdvancedSearch->toJson(), ","); // Field Nilai_Tugas
        $filterList = Concat($filterList, $this->Nilai_UTS->AdvancedSearch->toJson(), ","); // Field Nilai_UTS
        $filterList = Concat($filterList, $this->Nilai_Akhir->AdvancedSearch->toJson(), ","); // Field Nilai_Akhir
        $filterList = Concat($filterList, $this->iduser->AdvancedSearch->toJson(), ","); // Field iduser
        $filterList = Concat($filterList, $this->user->AdvancedSearch->toJson(), ","); // Field user
        $filterList = Concat($filterList, $this->ip->AdvancedSearch->toJson(), ","); // Field ip
        $filterList = Concat($filterList, $this->tanggal->AdvancedSearch->toJson(), ","); // Field tanggal
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
            Profile()->setSearchFilters("fdetil_mata_kuliahsrch", $filters);
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

        // Field id_no
        $this->id_no->AdvancedSearch->SearchValue = $filter["x_id_no"] ?? "";
        $this->id_no->AdvancedSearch->SearchOperator = $filter["z_id_no"] ?? "";
        $this->id_no->AdvancedSearch->SearchCondition = $filter["v_id_no"] ?? "";
        $this->id_no->AdvancedSearch->SearchValue2 = $filter["y_id_no"] ?? "";
        $this->id_no->AdvancedSearch->SearchOperator2 = $filter["w_id_no"] ?? "";
        $this->id_no->AdvancedSearch->save();

        // Field Kode_MK
        $this->Kode_MK->AdvancedSearch->SearchValue = $filter["x_Kode_MK"] ?? "";
        $this->Kode_MK->AdvancedSearch->SearchOperator = $filter["z_Kode_MK"] ?? "";
        $this->Kode_MK->AdvancedSearch->SearchCondition = $filter["v_Kode_MK"] ?? "";
        $this->Kode_MK->AdvancedSearch->SearchValue2 = $filter["y_Kode_MK"] ?? "";
        $this->Kode_MK->AdvancedSearch->SearchOperator2 = $filter["w_Kode_MK"] ?? "";
        $this->Kode_MK->AdvancedSearch->save();

        // Field NIM
        $this->NIM->AdvancedSearch->SearchValue = $filter["x_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchOperator = $filter["z_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchCondition = $filter["v_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchValue2 = $filter["y_NIM"] ?? "";
        $this->NIM->AdvancedSearch->SearchOperator2 = $filter["w_NIM"] ?? "";
        $this->NIM->AdvancedSearch->save();

        // Field Nilai_Diskusi
        $this->Nilai_Diskusi->AdvancedSearch->SearchValue = $filter["x_Nilai_Diskusi"] ?? "";
        $this->Nilai_Diskusi->AdvancedSearch->SearchOperator = $filter["z_Nilai_Diskusi"] ?? "";
        $this->Nilai_Diskusi->AdvancedSearch->SearchCondition = $filter["v_Nilai_Diskusi"] ?? "";
        $this->Nilai_Diskusi->AdvancedSearch->SearchValue2 = $filter["y_Nilai_Diskusi"] ?? "";
        $this->Nilai_Diskusi->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_Diskusi"] ?? "";
        $this->Nilai_Diskusi->AdvancedSearch->save();

        // Field Assessment_Skor_As_1
        $this->Assessment_Skor_As_1->AdvancedSearch->SearchValue = $filter["x_Assessment_Skor_As_1"] ?? "";
        $this->Assessment_Skor_As_1->AdvancedSearch->SearchOperator = $filter["z_Assessment_Skor_As_1"] ?? "";
        $this->Assessment_Skor_As_1->AdvancedSearch->SearchCondition = $filter["v_Assessment_Skor_As_1"] ?? "";
        $this->Assessment_Skor_As_1->AdvancedSearch->SearchValue2 = $filter["y_Assessment_Skor_As_1"] ?? "";
        $this->Assessment_Skor_As_1->AdvancedSearch->SearchOperator2 = $filter["w_Assessment_Skor_As_1"] ?? "";
        $this->Assessment_Skor_As_1->AdvancedSearch->save();

        // Field Assessment_Skor_As_2
        $this->Assessment_Skor_As_2->AdvancedSearch->SearchValue = $filter["x_Assessment_Skor_As_2"] ?? "";
        $this->Assessment_Skor_As_2->AdvancedSearch->SearchOperator = $filter["z_Assessment_Skor_As_2"] ?? "";
        $this->Assessment_Skor_As_2->AdvancedSearch->SearchCondition = $filter["v_Assessment_Skor_As_2"] ?? "";
        $this->Assessment_Skor_As_2->AdvancedSearch->SearchValue2 = $filter["y_Assessment_Skor_As_2"] ?? "";
        $this->Assessment_Skor_As_2->AdvancedSearch->SearchOperator2 = $filter["w_Assessment_Skor_As_2"] ?? "";
        $this->Assessment_Skor_As_2->AdvancedSearch->save();

        // Field Assessment_Skor_As_3
        $this->Assessment_Skor_As_3->AdvancedSearch->SearchValue = $filter["x_Assessment_Skor_As_3"] ?? "";
        $this->Assessment_Skor_As_3->AdvancedSearch->SearchOperator = $filter["z_Assessment_Skor_As_3"] ?? "";
        $this->Assessment_Skor_As_3->AdvancedSearch->SearchCondition = $filter["v_Assessment_Skor_As_3"] ?? "";
        $this->Assessment_Skor_As_3->AdvancedSearch->SearchValue2 = $filter["y_Assessment_Skor_As_3"] ?? "";
        $this->Assessment_Skor_As_3->AdvancedSearch->SearchOperator2 = $filter["w_Assessment_Skor_As_3"] ?? "";
        $this->Assessment_Skor_As_3->AdvancedSearch->save();

        // Field Nilai_Tugas
        $this->Nilai_Tugas->AdvancedSearch->SearchValue = $filter["x_Nilai_Tugas"] ?? "";
        $this->Nilai_Tugas->AdvancedSearch->SearchOperator = $filter["z_Nilai_Tugas"] ?? "";
        $this->Nilai_Tugas->AdvancedSearch->SearchCondition = $filter["v_Nilai_Tugas"] ?? "";
        $this->Nilai_Tugas->AdvancedSearch->SearchValue2 = $filter["y_Nilai_Tugas"] ?? "";
        $this->Nilai_Tugas->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_Tugas"] ?? "";
        $this->Nilai_Tugas->AdvancedSearch->save();

        // Field Nilai_UTS
        $this->Nilai_UTS->AdvancedSearch->SearchValue = $filter["x_Nilai_UTS"] ?? "";
        $this->Nilai_UTS->AdvancedSearch->SearchOperator = $filter["z_Nilai_UTS"] ?? "";
        $this->Nilai_UTS->AdvancedSearch->SearchCondition = $filter["v_Nilai_UTS"] ?? "";
        $this->Nilai_UTS->AdvancedSearch->SearchValue2 = $filter["y_Nilai_UTS"] ?? "";
        $this->Nilai_UTS->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_UTS"] ?? "";
        $this->Nilai_UTS->AdvancedSearch->save();

        // Field Nilai_Akhir
        $this->Nilai_Akhir->AdvancedSearch->SearchValue = $filter["x_Nilai_Akhir"] ?? "";
        $this->Nilai_Akhir->AdvancedSearch->SearchOperator = $filter["z_Nilai_Akhir"] ?? "";
        $this->Nilai_Akhir->AdvancedSearch->SearchCondition = $filter["v_Nilai_Akhir"] ?? "";
        $this->Nilai_Akhir->AdvancedSearch->SearchValue2 = $filter["y_Nilai_Akhir"] ?? "";
        $this->Nilai_Akhir->AdvancedSearch->SearchOperator2 = $filter["w_Nilai_Akhir"] ?? "";
        $this->Nilai_Akhir->AdvancedSearch->save();

        // Field iduser
        $this->iduser->AdvancedSearch->SearchValue = $filter["x_iduser"] ?? "";
        $this->iduser->AdvancedSearch->SearchOperator = $filter["z_iduser"] ?? "";
        $this->iduser->AdvancedSearch->SearchCondition = $filter["v_iduser"] ?? "";
        $this->iduser->AdvancedSearch->SearchValue2 = $filter["y_iduser"] ?? "";
        $this->iduser->AdvancedSearch->SearchOperator2 = $filter["w_iduser"] ?? "";
        $this->iduser->AdvancedSearch->save();

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

        // Field tanggal
        $this->tanggal->AdvancedSearch->SearchValue = $filter["x_tanggal"] ?? "";
        $this->tanggal->AdvancedSearch->SearchOperator = $filter["z_tanggal"] ?? "";
        $this->tanggal->AdvancedSearch->SearchCondition = $filter["v_tanggal"] ?? "";
        $this->tanggal->AdvancedSearch->SearchValue2 = $filter["y_tanggal"] ?? "";
        $this->tanggal->AdvancedSearch->SearchOperator2 = $filter["w_tanggal"] ?? "";
        $this->tanggal->AdvancedSearch->save();
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
        $searchFlds[] = &$this->Kode_MK;
        $searchFlds[] = &$this->NIM;
        $searchFlds[] = &$this->Nilai_Diskusi;
        $searchFlds[] = &$this->Assessment_Skor_As_1;
        $searchFlds[] = &$this->Assessment_Skor_As_2;
        $searchFlds[] = &$this->Assessment_Skor_As_3;
        $searchFlds[] = &$this->Nilai_Tugas;
        $searchFlds[] = &$this->Nilai_UTS;
        $searchFlds[] = &$this->Nilai_Akhir;
        $searchFlds[] = &$this->iduser;
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
            $this->updateSort($this->id_no); // id_no
            $this->updateSort($this->Kode_MK); // Kode_MK
            $this->updateSort($this->NIM); // NIM
            $this->updateSort($this->Nilai_Diskusi); // Nilai_Diskusi
            $this->updateSort($this->Assessment_Skor_As_1); // Assessment_Skor_As_1
            $this->updateSort($this->Assessment_Skor_As_2); // Assessment_Skor_As_2
            $this->updateSort($this->Assessment_Skor_As_3); // Assessment_Skor_As_3
            $this->updateSort($this->Nilai_Tugas); // Nilai_Tugas
            $this->updateSort($this->Nilai_UTS); // Nilai_UTS
            $this->updateSort($this->Nilai_Akhir); // Nilai_Akhir
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

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->Kode_MK->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id_no->setSort("");
                $this->Kode_MK->setSort("");
                $this->NIM->setSort("");
                $this->Nilai_Diskusi->setSort("");
                $this->Assessment_Skor_As_1->setSort("");
                $this->Assessment_Skor_As_2->setSort("");
                $this->Assessment_Skor_As_3->setSort("");
                $this->Nilai_Tugas->setSort("");
                $this->Nilai_UTS->setSort("");
                $this->Nilai_Akhir->setSort("");
                $this->iduser->setSort("");
                $this->user->setSort("");
                $this->ip->setSort("");
                $this->tanggal->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions(): void
    {
        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

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

        // Set up row action and key
        if (is_numeric($this->RowIndex) && $this->RowType != "view") {
            $this->FormIndex = $this->RowIndex;
            $actionName = $this->getFormRowActionName(true);
            $oldKeyName = $this->getFormOldKeyName(true);
            $blankRowName = $this->getFormBlankRowName(true);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$this->security->allowDelete(CurrentProjectID() . $this->TableName) && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($this->language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $this->language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($this->language->phrase("ViewLink"));
            if ($this->security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"detil_mata_kuliah\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $this->language->phrase("ViewLink") . "</a>";
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
					$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"detil_mata_kuliah\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-ask=\"1\" data-btn=\"SaveBtn\">" . $this->language->phrase("EditLink") . "</a>";
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
					$opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"detil_mata_kuliah\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-ask=\"1\" data-btn=\"AddBtn\">" . $this->language->phrase("CopyLink") . "</a>";
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
                        "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fdetil_mata_kuliahlist\" data-key=\"" . $this->keyToJson(true) .
                        "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                    $links[] = $link;
                    if ($body == "") { // Setup first button
                        $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action" . ($listAction->getEnabled() ? "" : " disabled") .
                            "\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fdetil_mata_kuliahlist\" data-key=\"" . $this->keyToJson(true) .
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->id_no->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->Kode_MK->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";

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
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"detil_mata_kuliah\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-ask=\"1\" data-btn=\"AddBtn\">" . $this->language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $this->language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $this->security->canAdd();
        $item = &$option->add("gridadd");
        if ($this->ModalGridAdd && !IsMobile()) {
            $item->Body = "<button class=\"ew-add-edit ew-grid-add\" title=\"" . $this->language->phrase("GridAddLink", true) . "\" data-caption=\"" . $this->language->phrase("GridAddLink", true) . "\" data-ew-action=\"modal\" data-btn=\"AddBtn\" data-url=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $this->language->phrase("GridAddLink") . "</button>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . $this->language->phrase("GridAddLink", true) . "\" data-caption=\"" . $this->language->phrase("GridAddLink", true) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $this->language->phrase("GridAddLink") . "</a>";
        }
        $item->Visible = $this->GridAddUrl != "" && $this->security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        if ($this->ModalGridEdit && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . $this->language->phrase("GridEditLink", true) . "\" data-caption=\"" . $this->language->phrase("GridEditLink", true) . "\" data-ew-action=\"modal\" data-btn=\"GridSaveLink\" data-url=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $this->language->phrase("GridEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . $this->language->phrase("GridEditLink", true) . "\" data-caption=\"" . $this->language->phrase("GridEditLink", true) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $this->language->phrase("GridEditLink") . "</a>";
        }
        $item->Visible = $this->GridEditUrl != "" && $this->security->canEdit();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "id_no");
            $this->createColumnOption($option, "Kode_MK");
            $this->createColumnOption($option, "NIM");
            $this->createColumnOption($option, "Nilai_Diskusi");
            $this->createColumnOption($option, "Assessment_Skor_As_1");
            $this->createColumnOption($option, "Assessment_Skor_As_2");
            $this->createColumnOption($option, "Assessment_Skor_As_3");
            $this->createColumnOption($option, "Nilai_Tugas");
            $this->createColumnOption($option, "Nilai_UTS");
            $this->createColumnOption($option, "Nilai_Akhir");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fdetil_mata_kuliahsrch\" data-ew-action=\"none\">" . $this->language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fdetil_mata_kuliahsrch\" data-ew-action=\"none\">" . $this->language->phrase("DeleteFilter") . "</a>";
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
        if (!$this->isGridAdd() && !$this->isGridEdit() && !$this->isMultiEdit()) { // Not grid add/grid edit/multi edit mode
            $option = $options["action"];
            // Render list action buttons
            foreach ($this->ListActions as $listAction) { // ActionType::MULTIPLE
                if ($listAction->Select == ActionType::MULTIPLE && $listAction->getVisible()) {
                    $item = &$option->add("custom_" . $listAction->Action);
                    $caption = $listAction->getCaption();
                    $icon = $listAction->Icon ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fdetil_mata_kuliahlist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
        } else { // Grid add/grid edit/multi edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl(false);

            // Grid-Add
            if ($this->isGridAdd()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<a type=\"button\" class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($this->language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $this->language->phrase("AddBlankRow") . "</a>";
                        $item->Visible = $this->security->canAdd();
                    }
                if (!($this->ModalGridAdd && !IsMobile())) {
                    $option = $options["action"];
                    $option->UseDropDownButton = false;
                    // Add grid insert
                    $item = &$option->add("gridinsert");
                    $item->Body = "<button class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($this->language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("GridInsertLink")) . "\" form=\"fdetil_mata_kuliahlist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $this->language->phrase("GridInsertLink") . "</button>";
                    // Add grid cancel
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a type=\"button\" class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($this->language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $this->language->phrase("GridCancelLink") . "</a>";
                }
            }

            // Grid-Edit
            if ($this->isGridEdit()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<button class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($this->language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $this->language->phrase("AddBlankRow") . "</button>";
                        $item->Visible = $this->security->canAdd();
                    }
                if (!($this->ModalGridEdit && !IsMobile())) {
                    $option = $options["action"];
                    $option->UseDropDownButton = false;
                        $item = &$option->add("gridsave");
                        $item->Body = "<button class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($this->language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("GridSaveLink")) . "\" form=\"fdetil_mata_kuliahlist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $this->language->phrase("GridSaveLink") . "</button>";
                        $item = &$option->add("gridcancel");
                        $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                        $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($this->language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($this->language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $this->language->phrase("GridCancelLink") . "</a>";
                }
            }
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

        // Restore number of post back records
        if ($this->isConfirm() || $this->EventCancelled) {
            if ($this->hasKeyCount() && ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm())) {
                $this->KeyCount = $this->getKeyCount();
                $this->StopRecord = $this->StartRecord + $this->KeyCount - 1;
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_detil_mata_kuliah", "data-rowtype" => RowType::ADD]);
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
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm() || $this->isMultiEdit()) {
            $this->RowIndex++;
            $this->FormIndex = $this->RowIndex;
            if ($this->hasRowAction() && ($this->isConfirm() || $this->EventCancelled)) {
                $this->RowAction = $this->getRowAction();
            } elseif ($this->isGridAdd()) {
                $this->RowAction = "insert";
            } else {
                $this->RowAction = "";
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
        if ($this->isGridAdd() && $this->EventCancelled && !$this->hasBlankRow()) { // Insert failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isGridEdit()) { // Grid edit
            if ($this->EventCancelled) {
                $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
            }
            if ($this->RowAction == "insert") {
                $this->RowType = RowType::ADD; // Render add
            } else {
                $this->RowType = RowType::EDIT; // Render edit
            }
        }
        if ($this->isGridEdit() && ($this->RowType == RowType::EDIT || $this->RowType == RowType::ADD) && $this->EventCancelled) { // Update failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
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
            "id" => "r" . $this->RowCount . "_detil_mata_kuliah",
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

// Load default values
    protected function loadDefaultValues(): void
    {
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

    // Load form values
    protected function loadFormValues(): void
    {
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id_no' before field var 'x_id_no'
        $val = $this->getFormValue("id_no", null) ?? $this->getFormValue("x_id_no", null);
        if (!$this->id_no->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id_no->setFormValue($val);
        }

        // Check field name 'Kode_MK' before field var 'x_Kode_MK'
        $val = $this->getFormValue("Kode_MK", null) ?? $this->getFormValue("x_Kode_MK", null);
        if (!$this->Kode_MK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kode_MK->Visible = false; // Disable update for API request
            } else {
                $this->Kode_MK->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Kode_MK")) {
            $this->Kode_MK->setOldValue($this->getFormValue("o_Kode_MK"));
        }

        // Check field name 'NIM' before field var 'x_NIM'
        $val = $this->getFormValue("NIM", null) ?? $this->getFormValue("x_NIM", null);
        if (!$this->NIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIM->Visible = false; // Disable update for API request
            } else {
                $this->NIM->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_NIM")) {
            $this->NIM->setOldValue($this->getFormValue("o_NIM"));
        }

        // Check field name 'Nilai_Diskusi' before field var 'x_Nilai_Diskusi'
        $val = $this->getFormValue("Nilai_Diskusi", null) ?? $this->getFormValue("x_Nilai_Diskusi", null);
        if (!$this->Nilai_Diskusi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Diskusi->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Diskusi->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Nilai_Diskusi")) {
            $this->Nilai_Diskusi->setOldValue($this->getFormValue("o_Nilai_Diskusi"));
        }

        // Check field name 'Assessment_Skor_As_1' before field var 'x_Assessment_Skor_As_1'
        $val = $this->getFormValue("Assessment_Skor_As_1", null) ?? $this->getFormValue("x_Assessment_Skor_As_1", null);
        if (!$this->Assessment_Skor_As_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Assessment_Skor_As_1->Visible = false; // Disable update for API request
            } else {
                $this->Assessment_Skor_As_1->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Assessment_Skor_As_1")) {
            $this->Assessment_Skor_As_1->setOldValue($this->getFormValue("o_Assessment_Skor_As_1"));
        }

        // Check field name 'Assessment_Skor_As_2' before field var 'x_Assessment_Skor_As_2'
        $val = $this->getFormValue("Assessment_Skor_As_2", null) ?? $this->getFormValue("x_Assessment_Skor_As_2", null);
        if (!$this->Assessment_Skor_As_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Assessment_Skor_As_2->Visible = false; // Disable update for API request
            } else {
                $this->Assessment_Skor_As_2->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Assessment_Skor_As_2")) {
            $this->Assessment_Skor_As_2->setOldValue($this->getFormValue("o_Assessment_Skor_As_2"));
        }

        // Check field name 'Assessment_Skor_As_3' before field var 'x_Assessment_Skor_As_3'
        $val = $this->getFormValue("Assessment_Skor_As_3", null) ?? $this->getFormValue("x_Assessment_Skor_As_3", null);
        if (!$this->Assessment_Skor_As_3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Assessment_Skor_As_3->Visible = false; // Disable update for API request
            } else {
                $this->Assessment_Skor_As_3->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Assessment_Skor_As_3")) {
            $this->Assessment_Skor_As_3->setOldValue($this->getFormValue("o_Assessment_Skor_As_3"));
        }

        // Check field name 'Nilai_Tugas' before field var 'x_Nilai_Tugas'
        $val = $this->getFormValue("Nilai_Tugas", null) ?? $this->getFormValue("x_Nilai_Tugas", null);
        if (!$this->Nilai_Tugas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Tugas->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Tugas->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Nilai_Tugas")) {
            $this->Nilai_Tugas->setOldValue($this->getFormValue("o_Nilai_Tugas"));
        }

        // Check field name 'Nilai_UTS' before field var 'x_Nilai_UTS'
        $val = $this->getFormValue("Nilai_UTS", null) ?? $this->getFormValue("x_Nilai_UTS", null);
        if (!$this->Nilai_UTS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_UTS->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_UTS->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Nilai_UTS")) {
            $this->Nilai_UTS->setOldValue($this->getFormValue("o_Nilai_UTS"));
        }

        // Check field name 'Nilai_Akhir' before field var 'x_Nilai_Akhir'
        $val = $this->getFormValue("Nilai_Akhir", null) ?? $this->getFormValue("x_Nilai_Akhir", null);
        if (!$this->Nilai_Akhir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Akhir->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Akhir->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_Nilai_Akhir")) {
            $this->Nilai_Akhir->setOldValue($this->getFormValue("o_Nilai_Akhir"));
        }
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id_no->CurrentValue = $this->id_no->FormValue;
        }
        $this->Kode_MK->CurrentValue = $this->Kode_MK->FormValue;
        $this->NIM->CurrentValue = $this->NIM->FormValue;
        $this->Nilai_Diskusi->CurrentValue = $this->Nilai_Diskusi->FormValue;
        $this->Assessment_Skor_As_1->CurrentValue = $this->Assessment_Skor_As_1->FormValue;
        $this->Assessment_Skor_As_2->CurrentValue = $this->Assessment_Skor_As_2->FormValue;
        $this->Assessment_Skor_As_3->CurrentValue = $this->Assessment_Skor_As_3->FormValue;
        $this->Nilai_Tugas->CurrentValue = $this->Nilai_Tugas->FormValue;
        $this->Nilai_UTS->CurrentValue = $this->Nilai_UTS->FormValue;
        $this->Nilai_Akhir->CurrentValue = $this->Nilai_Akhir->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
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

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['id_no'] = $this->id_no->DefaultValue;
        $row['Kode_MK'] = $this->Kode_MK->DefaultValue;
        $row['NIM'] = $this->NIM->DefaultValue;
        $row['Nilai_Diskusi'] = $this->Nilai_Diskusi->DefaultValue;
        $row['Assessment_Skor_As_1'] = $this->Assessment_Skor_As_1->DefaultValue;
        $row['Assessment_Skor_As_2'] = $this->Assessment_Skor_As_2->DefaultValue;
        $row['Assessment_Skor_As_3'] = $this->Assessment_Skor_As_3->DefaultValue;
        $row['Nilai_Tugas'] = $this->Nilai_Tugas->DefaultValue;
        $row['Nilai_UTS'] = $this->Nilai_UTS->DefaultValue;
        $row['Nilai_Akhir'] = $this->Nilai_Akhir->DefaultValue;
        $row['iduser'] = $this->iduser->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['ip'] = $this->ip->DefaultValue;
        $row['tanggal'] = $this->tanggal->DefaultValue;
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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        } elseif ($this->RowType == RowType::ADD) {
            // id_no
            $this->id_no->EditValue = $this->id_no->CurrentValue;

            // Kode_MK
            $this->Kode_MK->setupEditAttributes();
            if ($this->Kode_MK->getSessionValue() != "") {
                $this->Kode_MK->CurrentValue = GetForeignKeyValue($this->Kode_MK->getSessionValue());
                $this->Kode_MK->OldValue = $this->Kode_MK->CurrentValue;
                $this->Kode_MK->ViewValue = $this->Kode_MK->CurrentValue;
            } else {
                $this->Kode_MK->EditValue = !$this->Kode_MK->Raw ? HtmlDecode($this->Kode_MK->CurrentValue) : $this->Kode_MK->CurrentValue;
                $this->Kode_MK->PlaceHolder = RemoveHtml($this->Kode_MK->caption());
            }

            // NIM
            $this->NIM->setupEditAttributes();
            $this->NIM->EditValue = !$this->NIM->Raw ? HtmlDecode($this->NIM->CurrentValue) : $this->NIM->CurrentValue;
            $this->NIM->PlaceHolder = RemoveHtml($this->NIM->caption());

            // Nilai_Diskusi
            $this->Nilai_Diskusi->setupEditAttributes();
            $this->Nilai_Diskusi->EditValue = !$this->Nilai_Diskusi->Raw ? HtmlDecode($this->Nilai_Diskusi->CurrentValue) : $this->Nilai_Diskusi->CurrentValue;
            $this->Nilai_Diskusi->PlaceHolder = RemoveHtml($this->Nilai_Diskusi->caption());

            // Assessment_Skor_As_1
            $this->Assessment_Skor_As_1->setupEditAttributes();
            $this->Assessment_Skor_As_1->EditValue = !$this->Assessment_Skor_As_1->Raw ? HtmlDecode($this->Assessment_Skor_As_1->CurrentValue) : $this->Assessment_Skor_As_1->CurrentValue;
            $this->Assessment_Skor_As_1->PlaceHolder = RemoveHtml($this->Assessment_Skor_As_1->caption());

            // Assessment_Skor_As_2
            $this->Assessment_Skor_As_2->setupEditAttributes();
            $this->Assessment_Skor_As_2->EditValue = !$this->Assessment_Skor_As_2->Raw ? HtmlDecode($this->Assessment_Skor_As_2->CurrentValue) : $this->Assessment_Skor_As_2->CurrentValue;
            $this->Assessment_Skor_As_2->PlaceHolder = RemoveHtml($this->Assessment_Skor_As_2->caption());

            // Assessment_Skor_As_3
            $this->Assessment_Skor_As_3->setupEditAttributes();
            $this->Assessment_Skor_As_3->EditValue = !$this->Assessment_Skor_As_3->Raw ? HtmlDecode($this->Assessment_Skor_As_3->CurrentValue) : $this->Assessment_Skor_As_3->CurrentValue;
            $this->Assessment_Skor_As_3->PlaceHolder = RemoveHtml($this->Assessment_Skor_As_3->caption());

            // Nilai_Tugas
            $this->Nilai_Tugas->setupEditAttributes();
            $this->Nilai_Tugas->EditValue = !$this->Nilai_Tugas->Raw ? HtmlDecode($this->Nilai_Tugas->CurrentValue) : $this->Nilai_Tugas->CurrentValue;
            $this->Nilai_Tugas->PlaceHolder = RemoveHtml($this->Nilai_Tugas->caption());

            // Nilai_UTS
            $this->Nilai_UTS->setupEditAttributes();
            $this->Nilai_UTS->EditValue = !$this->Nilai_UTS->Raw ? HtmlDecode($this->Nilai_UTS->CurrentValue) : $this->Nilai_UTS->CurrentValue;
            $this->Nilai_UTS->PlaceHolder = RemoveHtml($this->Nilai_UTS->caption());

            // Nilai_Akhir
            $this->Nilai_Akhir->setupEditAttributes();
            $this->Nilai_Akhir->EditValue = !$this->Nilai_Akhir->Raw ? HtmlDecode($this->Nilai_Akhir->CurrentValue) : $this->Nilai_Akhir->CurrentValue;
            $this->Nilai_Akhir->PlaceHolder = RemoveHtml($this->Nilai_Akhir->caption());

            // Add refer script

            // id_no
            $this->id_no->HrefValue = "";

            // Kode_MK
            $this->Kode_MK->HrefValue = "";

            // NIM
            $this->NIM->HrefValue = "";

            // Nilai_Diskusi
            $this->Nilai_Diskusi->HrefValue = "";

            // Assessment_Skor_As_1
            $this->Assessment_Skor_As_1->HrefValue = "";

            // Assessment_Skor_As_2
            $this->Assessment_Skor_As_2->HrefValue = "";

            // Assessment_Skor_As_3
            $this->Assessment_Skor_As_3->HrefValue = "";

            // Nilai_Tugas
            $this->Nilai_Tugas->HrefValue = "";

            // Nilai_UTS
            $this->Nilai_UTS->HrefValue = "";

            // Nilai_Akhir
            $this->Nilai_Akhir->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // id_no
            $this->id_no->setupEditAttributes();
            $this->id_no->EditValue = $this->id_no->CurrentValue;

            // Kode_MK
            $this->Kode_MK->setupEditAttributes();
            $this->Kode_MK->EditValue = !$this->Kode_MK->Raw ? HtmlDecode($this->Kode_MK->CurrentValue) : $this->Kode_MK->CurrentValue;
            $this->Kode_MK->PlaceHolder = RemoveHtml($this->Kode_MK->caption());

            // NIM
            $this->NIM->setupEditAttributes();
            $this->NIM->EditValue = !$this->NIM->Raw ? HtmlDecode($this->NIM->CurrentValue) : $this->NIM->CurrentValue;
            $this->NIM->PlaceHolder = RemoveHtml($this->NIM->caption());

            // Nilai_Diskusi
            $this->Nilai_Diskusi->setupEditAttributes();
            $this->Nilai_Diskusi->EditValue = !$this->Nilai_Diskusi->Raw ? HtmlDecode($this->Nilai_Diskusi->CurrentValue) : $this->Nilai_Diskusi->CurrentValue;
            $this->Nilai_Diskusi->PlaceHolder = RemoveHtml($this->Nilai_Diskusi->caption());

            // Assessment_Skor_As_1
            $this->Assessment_Skor_As_1->setupEditAttributes();
            $this->Assessment_Skor_As_1->EditValue = !$this->Assessment_Skor_As_1->Raw ? HtmlDecode($this->Assessment_Skor_As_1->CurrentValue) : $this->Assessment_Skor_As_1->CurrentValue;
            $this->Assessment_Skor_As_1->PlaceHolder = RemoveHtml($this->Assessment_Skor_As_1->caption());

            // Assessment_Skor_As_2
            $this->Assessment_Skor_As_2->setupEditAttributes();
            $this->Assessment_Skor_As_2->EditValue = !$this->Assessment_Skor_As_2->Raw ? HtmlDecode($this->Assessment_Skor_As_2->CurrentValue) : $this->Assessment_Skor_As_2->CurrentValue;
            $this->Assessment_Skor_As_2->PlaceHolder = RemoveHtml($this->Assessment_Skor_As_2->caption());

            // Assessment_Skor_As_3
            $this->Assessment_Skor_As_3->setupEditAttributes();
            $this->Assessment_Skor_As_3->EditValue = !$this->Assessment_Skor_As_3->Raw ? HtmlDecode($this->Assessment_Skor_As_3->CurrentValue) : $this->Assessment_Skor_As_3->CurrentValue;
            $this->Assessment_Skor_As_3->PlaceHolder = RemoveHtml($this->Assessment_Skor_As_3->caption());

            // Nilai_Tugas
            $this->Nilai_Tugas->setupEditAttributes();
            $this->Nilai_Tugas->EditValue = !$this->Nilai_Tugas->Raw ? HtmlDecode($this->Nilai_Tugas->CurrentValue) : $this->Nilai_Tugas->CurrentValue;
            $this->Nilai_Tugas->PlaceHolder = RemoveHtml($this->Nilai_Tugas->caption());

            // Nilai_UTS
            $this->Nilai_UTS->setupEditAttributes();
            $this->Nilai_UTS->EditValue = !$this->Nilai_UTS->Raw ? HtmlDecode($this->Nilai_UTS->CurrentValue) : $this->Nilai_UTS->CurrentValue;
            $this->Nilai_UTS->PlaceHolder = RemoveHtml($this->Nilai_UTS->caption());

            // Nilai_Akhir
            $this->Nilai_Akhir->setupEditAttributes();
            $this->Nilai_Akhir->EditValue = !$this->Nilai_Akhir->Raw ? HtmlDecode($this->Nilai_Akhir->CurrentValue) : $this->Nilai_Akhir->CurrentValue;
            $this->Nilai_Akhir->PlaceHolder = RemoveHtml($this->Nilai_Akhir->caption());

            // Edit refer script

            // id_no
            $this->id_no->HrefValue = "";

            // Kode_MK
            $this->Kode_MK->HrefValue = "";

            // NIM
            $this->NIM->HrefValue = "";

            // Nilai_Diskusi
            $this->Nilai_Diskusi->HrefValue = "";

            // Assessment_Skor_As_1
            $this->Assessment_Skor_As_1->HrefValue = "";

            // Assessment_Skor_As_2
            $this->Assessment_Skor_As_2->HrefValue = "";

            // Assessment_Skor_As_3
            $this->Assessment_Skor_As_3->HrefValue = "";

            // Nilai_Tugas
            $this->Nilai_Tugas->HrefValue = "";

            // Nilai_UTS
            $this->Nilai_UTS->HrefValue = "";

            // Nilai_Akhir
            $this->Nilai_Akhir->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm(): bool
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->id_no->Visible && $this->id_no->Required) {
                if (!$this->id_no->IsDetailKey && IsEmpty($this->id_no->FormValue)) {
                    $this->id_no->addErrorMessage(str_replace("%s", $this->id_no->caption(), $this->id_no->RequiredErrorMessage));
                }
            }
            if ($this->Kode_MK->Visible && $this->Kode_MK->Required) {
                if (!$this->Kode_MK->IsDetailKey && IsEmpty($this->Kode_MK->FormValue)) {
                    $this->Kode_MK->addErrorMessage(str_replace("%s", $this->Kode_MK->caption(), $this->Kode_MK->RequiredErrorMessage));
                }
            }
            if ($this->NIM->Visible && $this->NIM->Required) {
                if (!$this->NIM->IsDetailKey && IsEmpty($this->NIM->FormValue)) {
                    $this->NIM->addErrorMessage(str_replace("%s", $this->NIM->caption(), $this->NIM->RequiredErrorMessage));
                }
            }
            if ($this->Nilai_Diskusi->Visible && $this->Nilai_Diskusi->Required) {
                if (!$this->Nilai_Diskusi->IsDetailKey && IsEmpty($this->Nilai_Diskusi->FormValue)) {
                    $this->Nilai_Diskusi->addErrorMessage(str_replace("%s", $this->Nilai_Diskusi->caption(), $this->Nilai_Diskusi->RequiredErrorMessage));
                }
            }
            if ($this->Assessment_Skor_As_1->Visible && $this->Assessment_Skor_As_1->Required) {
                if (!$this->Assessment_Skor_As_1->IsDetailKey && IsEmpty($this->Assessment_Skor_As_1->FormValue)) {
                    $this->Assessment_Skor_As_1->addErrorMessage(str_replace("%s", $this->Assessment_Skor_As_1->caption(), $this->Assessment_Skor_As_1->RequiredErrorMessage));
                }
            }
            if ($this->Assessment_Skor_As_2->Visible && $this->Assessment_Skor_As_2->Required) {
                if (!$this->Assessment_Skor_As_2->IsDetailKey && IsEmpty($this->Assessment_Skor_As_2->FormValue)) {
                    $this->Assessment_Skor_As_2->addErrorMessage(str_replace("%s", $this->Assessment_Skor_As_2->caption(), $this->Assessment_Skor_As_2->RequiredErrorMessage));
                }
            }
            if ($this->Assessment_Skor_As_3->Visible && $this->Assessment_Skor_As_3->Required) {
                if (!$this->Assessment_Skor_As_3->IsDetailKey && IsEmpty($this->Assessment_Skor_As_3->FormValue)) {
                    $this->Assessment_Skor_As_3->addErrorMessage(str_replace("%s", $this->Assessment_Skor_As_3->caption(), $this->Assessment_Skor_As_3->RequiredErrorMessage));
                }
            }
            if ($this->Nilai_Tugas->Visible && $this->Nilai_Tugas->Required) {
                if (!$this->Nilai_Tugas->IsDetailKey && IsEmpty($this->Nilai_Tugas->FormValue)) {
                    $this->Nilai_Tugas->addErrorMessage(str_replace("%s", $this->Nilai_Tugas->caption(), $this->Nilai_Tugas->RequiredErrorMessage));
                }
            }
            if ($this->Nilai_UTS->Visible && $this->Nilai_UTS->Required) {
                if (!$this->Nilai_UTS->IsDetailKey && IsEmpty($this->Nilai_UTS->FormValue)) {
                    $this->Nilai_UTS->addErrorMessage(str_replace("%s", $this->Nilai_UTS->caption(), $this->Nilai_UTS->RequiredErrorMessage));
                }
            }
            if ($this->Nilai_Akhir->Visible && $this->Nilai_Akhir->Required) {
                if (!$this->Nilai_Akhir->IsDetailKey && IsEmpty($this->Nilai_Akhir->FormValue)) {
                    $this->Nilai_Akhir->addErrorMessage(str_replace("%s", $this->Nilai_Akhir->caption(), $this->Nilai_Akhir->RequiredErrorMessage));
                }
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows(): ?bool
    {
        if (!$this->security->canDelete()) {
            $this->setFailureMessage($this->language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql(true);
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($this->language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $oldRows = $rows;
        $successKeys = [];
        $failKeys = [];
        $skipRecords = [];
        $rowindex = 0;
        foreach ($oldRows as $row) {
            $rowindex++;
            $thisKey = $this->getKeyFromRecord($row);

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if ($deleteRow === false && !IsEmpty($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === null) { // Row skipped
                $skipRecords[] = $rowindex . (!IsEmpty($thisKey) ? ": " . $thisKey : ""); // Record count and key if exists
            } elseif ($deleteRow === false) { // Row not deleted
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } elseif ($deleteRow) { // Row deleted
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows && count($skipRecords) > 0) { // Record skipped
            return null;
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->peekSuccessMessage() || $this->peekFailureMessage()) {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($this->language->phrase("DeleteCancelled"));
            }
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow(): bool
    {
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $oldRow = $conn->fetchAssociative($sql);
        if (!$oldRow) {
            $this->setFailureMessage($this->language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($oldRow);
        }

        // Get new row
        $newRow = $this->getEditRow($oldRow);

        // Update current values
        $this->Fields->setCurrentValues($newRow);

        // Check referential integrity for master table 'mata_kuliah'
        $detailKeys = [];
        $keyValue = $newRow['Kode_MK'] ?? $oldRow['Kode_MK'];
        $detailKeys['Kode_MK'] = $keyValue;
        $masterTable = Container("mata_kuliah");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!IsEmpty($masterFilter)) {
            $masterRow = $masterTable->loadRecords($masterFilter)->fetchAssociative();
            $validMasterRecord = $masterRow !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = sprintf($this->language->phrase("RelatedRecordRequired"), "mata_kuliah");
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($oldRow, $newRow);

        // Check for duplicate key when key changed
        if ($updateRow) {
            $newKeyFilter = $this->getRecordFilter($newRow);
            if ($newKeyFilter != $oldKeyFilter) {
                $rsChk = $this->loadRecords($newKeyFilter)->fetchAssociative();
                if ($rsChk !== false) {
                    $keyErrMsg = sprintf($this->language->phrase("DuplicateKey"), $newKeyFilter);
                    $this->setFailureMessage($keyErrMsg);
                    $updateRow = false;
                }
            }
        }
        if ($updateRow) {
            if (count($newRow) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($newRow, "", $oldRow);
                if (!$editRow && !IsEmpty($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->peekSuccessMessage() || $this->peekFailureMessage()) {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($this->language->phrase("UpdateCancelled"));
            }
            $editRow = $updateRow;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($oldRow, $newRow);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow(array $oldRow): array
    {
        $newRow = [];

        // Kode_MK
        if ($this->Kode_MK->getSessionValue() != "") {
            $this->Kode_MK->ReadOnly = true;
        }
        $this->Kode_MK->setDbValueDef($newRow, $this->Kode_MK->CurrentValue, $this->Kode_MK->ReadOnly);

        // NIM
        $this->NIM->setDbValueDef($newRow, $this->NIM->CurrentValue, $this->NIM->ReadOnly);

        // Nilai_Diskusi
        $this->Nilai_Diskusi->setDbValueDef($newRow, $this->Nilai_Diskusi->CurrentValue, $this->Nilai_Diskusi->ReadOnly);

        // Assessment_Skor_As_1
        $this->Assessment_Skor_As_1->setDbValueDef($newRow, $this->Assessment_Skor_As_1->CurrentValue, $this->Assessment_Skor_As_1->ReadOnly);

        // Assessment_Skor_As_2
        $this->Assessment_Skor_As_2->setDbValueDef($newRow, $this->Assessment_Skor_As_2->CurrentValue, $this->Assessment_Skor_As_2->ReadOnly);

        // Assessment_Skor_As_3
        $this->Assessment_Skor_As_3->setDbValueDef($newRow, $this->Assessment_Skor_As_3->CurrentValue, $this->Assessment_Skor_As_3->ReadOnly);

        // Nilai_Tugas
        $this->Nilai_Tugas->setDbValueDef($newRow, $this->Nilai_Tugas->CurrentValue, $this->Nilai_Tugas->ReadOnly);

        // Nilai_UTS
        $this->Nilai_UTS->setDbValueDef($newRow, $this->Nilai_UTS->CurrentValue, $this->Nilai_UTS->ReadOnly);

        // Nilai_Akhir
        $this->Nilai_Akhir->setDbValueDef($newRow, $this->Nilai_Akhir->CurrentValue, $this->Nilai_Akhir->ReadOnly);
        return $newRow;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow(array $row): void
    {
        if (isset($row['Kode_MK'])) { // Kode_MK
            $this->Kode_MK->CurrentValue = $row['Kode_MK'];
        }
        if (isset($row['NIM'])) { // NIM
            $this->NIM->CurrentValue = $row['NIM'];
        }
        if (isset($row['Nilai_Diskusi'])) { // Nilai_Diskusi
            $this->Nilai_Diskusi->CurrentValue = $row['Nilai_Diskusi'];
        }
        if (isset($row['Assessment_Skor_As_1'])) { // Assessment_Skor_As_1
            $this->Assessment_Skor_As_1->CurrentValue = $row['Assessment_Skor_As_1'];
        }
        if (isset($row['Assessment_Skor_As_2'])) { // Assessment_Skor_As_2
            $this->Assessment_Skor_As_2->CurrentValue = $row['Assessment_Skor_As_2'];
        }
        if (isset($row['Assessment_Skor_As_3'])) { // Assessment_Skor_As_3
            $this->Assessment_Skor_As_3->CurrentValue = $row['Assessment_Skor_As_3'];
        }
        if (isset($row['Nilai_Tugas'])) { // Nilai_Tugas
            $this->Nilai_Tugas->CurrentValue = $row['Nilai_Tugas'];
        }
        if (isset($row['Nilai_UTS'])) { // Nilai_UTS
            $this->Nilai_UTS->CurrentValue = $row['Nilai_UTS'];
        }
        if (isset($row['Nilai_Akhir'])) { // Nilai_Akhir
            $this->Nilai_Akhir->CurrentValue = $row['Nilai_Akhir'];
        }
    }

    // Load row hash
    protected function loadRowHash(): void
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : null; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(array $row): ?string
    {
        if (!$row) {
            return null;
        }
        $hash = "";
        $hash .= GetFieldHash($row['Kode_MK']); // Kode_MK
        $hash .= GetFieldHash($row['NIM']); // NIM
        $hash .= GetFieldHash($row['Nilai_Diskusi']); // Nilai_Diskusi
        $hash .= GetFieldHash($row['Assessment_Skor_As_1']); // Assessment_Skor_As_1
        $hash .= GetFieldHash($row['Assessment_Skor_As_2']); // Assessment_Skor_As_2
        $hash .= GetFieldHash($row['Assessment_Skor_As_3']); // Assessment_Skor_As_3
        $hash .= GetFieldHash($row['Nilai_Tugas']); // Nilai_Tugas
        $hash .= GetFieldHash($row['Nilai_UTS']); // Nilai_UTS
        $hash .= GetFieldHash($row['Nilai_Akhir']); // Nilai_Akhir
        return md5($hash);
    }

    // Add record
    protected function addRow(?array $oldRow = null): bool
    {
        // Get new row
        $newRow = $this->getAddRow();

        // Update current values
        $this->Fields->setCurrentValues($newRow);

        // Check referential integrity for master table 'detil_mata_kuliah'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["Kode_MK"] = $this->Kode_MK->CurrentValue;
        $masterTable = Container("mata_kuliah");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!IsEmpty($masterFilter)) {
            $masterRow = $masterTable->loadRecords($masterFilter)->fetchAssociative();
            $validMasterRecord = $masterRow !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = sprintf($this->language->phrase("RelatedRecordRequired"), "mata_kuliah");
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($oldRow);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($oldRow, $newRow);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($newRow['Kode_MK']) == "") {
            $this->setFailureMessage($this->language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }
        if ($insertRow) {
            $addRow = $this->insert($newRow);
            if ($addRow) {
            } elseif (!IsEmpty($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->peekSuccessMessage() || $this->peekFailureMessage()) {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($this->language->phrase("InsertCancelled"));
            }
            $addRow = $insertRow;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($oldRow, $newRow);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow(): array
    {
        $newRow = [];

        // Kode_MK
        $this->Kode_MK->setDbValueDef($newRow, $this->Kode_MK->CurrentValue, false);

        // NIM
        $this->NIM->setDbValueDef($newRow, $this->NIM->CurrentValue, false);

        // Nilai_Diskusi
        $this->Nilai_Diskusi->setDbValueDef($newRow, $this->Nilai_Diskusi->CurrentValue, false);

        // Assessment_Skor_As_1
        $this->Assessment_Skor_As_1->setDbValueDef($newRow, $this->Assessment_Skor_As_1->CurrentValue, false);

        // Assessment_Skor_As_2
        $this->Assessment_Skor_As_2->setDbValueDef($newRow, $this->Assessment_Skor_As_2->CurrentValue, false);

        // Assessment_Skor_As_3
        $this->Assessment_Skor_As_3->setDbValueDef($newRow, $this->Assessment_Skor_As_3->CurrentValue, false);

        // Nilai_Tugas
        $this->Nilai_Tugas->setDbValueDef($newRow, $this->Nilai_Tugas->CurrentValue, false);

        // Nilai_UTS
        $this->Nilai_UTS->setDbValueDef($newRow, $this->Nilai_UTS->CurrentValue, false);

        // Nilai_Akhir
        $this->Nilai_Akhir->setDbValueDef($newRow, $this->Nilai_Akhir->CurrentValue, false);
        return $newRow;
    }

    // Set up search options
    protected function setupSearchOptions(): void
    {	
		$pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

	// Begin of add Search Panel Status by Masino Sinaga, October 13, 2024

	    // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
		if (ReadCookie('detil_mata_kuliah_searchpanel') == 'notactive' || ReadCookie('detil_mata_kuliah_searchpanel') == "") {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fdetil_mata_kuliahsrch\" aria-pressed=\"false\">" . $this->language->phrase("SearchLink") . "</a>";
		} elseif (ReadCookie('detil_mata_kuliah_searchpanel') == 'active') {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle active\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fdetil_mata_kuliahsrch\" aria-pressed=\"true\">" . $this->language->phrase("SearchLink") . "</a>";
		} else {
			$item->Body = "<a class=\"btn btn-default ew-search-toggle\" role=\"button\" title=\"" . $this->language->phrase("SearchPanel") . "\" data-caption=\"" . $this->language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fdetil_mata_kuliahsrch\" aria-pressed=\"false\">" . $this->language->phrase("SearchLink") . "</a>";
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms(): void
    {
        $validMaster = false;
        $foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "mata_kuliah") {
                $validMaster = true;
                $masterTbl = Container("mata_kuliah");
                if (($parm = Get("fk_Kode_MK", Get("Kode_MK"))) !== null) {
                    $masterTbl->Kode_MK->setQueryStringValue($parm);
                    $this->Kode_MK->QueryStringValue = $masterTbl->Kode_MK->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->Kode_MK->setSessionValue($this->Kode_MK->QueryStringValue);
                    $foreignKeys["Kode_MK"] = $this->Kode_MK->QueryStringValue;
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "mata_kuliah") {
                $validMaster = true;
                $masterTbl = Container("mata_kuliah");
                if (($parm = Post("fk_Kode_MK", Post("Kode_MK"))) !== null) {
                    $masterTbl->Kode_MK->setFormValue($parm);
                    $this->Kode_MK->FormValue = $masterTbl->Kode_MK->FormValue;
                    $this->Kode_MK->setSessionValue($this->Kode_MK->FormValue);
                    $foreignKeys["Kode_MK"] = $this->Kode_MK->FormValue;
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);
            $this->MultiEditUrl = $this->addMasterUrl($this->MultiEditUrl);

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb(); // Set up breadcrumb again for the master table
            }

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "mata_kuliah") {
                if (!array_key_exists("Kode_MK", $foreignKeys)) { // Not current foreign key
                    $this->Kode_MK->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
