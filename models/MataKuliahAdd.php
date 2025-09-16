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
class MataKuliahAdd extends MataKuliah
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "add";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "MataKuliahAdd";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "matakuliahadd";

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
        $this->id_mk->Visible = false;
        $this->Kode_MK->setVisibility();
        $this->Semester->setVisibility();
        $this->Tahun_Akademik->setVisibility();
        $this->Dosen->setVisibility();
        $this->Tanggal->setVisibility();
        $this->Ip->setVisibility();
        $this->user->setVisibility();
        $this->iduser->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'mata_kuliah';
        $this->TableName = 'mata_kuliah';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Save if user language changed
        if (Param("language") !== null) {
            Profile()->setLanguageId(Param("language"))->saveToStorage();
        }

        // Table object (mata_kuliah)
        if (!isset($GLOBALS["mata_kuliah"]) || $GLOBALS["mata_kuliah"]::class == PROJECT_NAMESPACE . "mata_kuliah") {
            $GLOBALS["mata_kuliah"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mata_kuliah');
        }

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();
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
                if (
                    SameString($pageName, GetPageName($this->getListUrl()))
                    || SameString($pageName, GetPageName($this->getViewUrl()))
                    || SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "matakuliahview"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
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
            $key .= @$ar['id_mk'] . Config("COMPOSITE_KEY_SEPARATOR");
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
            $this->id_mk->Visible = false;
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
    public string $FormClassName = "ew-form ew-add-form";
    public bool $IsModal = false;
    public bool $IsMobileOrModal = false;
    public ?string $DbMasterFilter = "";
    public string $DbDetailFilter = "";
    public int $StartRecord = 0;
    public int $Priv = 0;
    public bool $CopyRecord = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run(): void
    {
        global $ExportType, $SkipHeaderFooter;

// Is modal
        $this->IsModal = IsModal();
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));
        $this->CurrentAction = Param("action"); // Set up current action
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

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey($this->getOldKey());
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id_mk") ?? Route("id_mk")) !== null) {
                $this->id_mk->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("Kode_MK") ?? Route("Kode_MK")) !== null) {
                $this->Kode_MK->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !IsEmpty($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $oldRow = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$oldRow) { // Record not loaded
                    if (!$this->peekFailureMessage()) {
                        $this->setFailureMessage($this->language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("matakuliahlist"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                if ($this->addRow($oldRow)) { // Add successful
                    CleanUploadTempPaths(SessionId());
                    if (!$this->peekSuccessMessage() && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($this->language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "matakuliahlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "matakuliahview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "matakuliahlist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "matakuliahlist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

// Get upload files
    protected function getUploadFiles(): void
    {
    }

    // Load default values
    protected function loadDefaultValues(): void
    {
    }

    // Load form values
    protected function loadFormValues(): void
    {
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Kode_MK' before field var 'x_Kode_MK'
        $val = $this->getFormValue("Kode_MK", null) ?? $this->getFormValue("x_Kode_MK", null);
        if (!$this->Kode_MK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kode_MK->Visible = false; // Disable update for API request
            } else {
                $this->Kode_MK->setFormValue($val);
            }
        }

        // Check field name 'Semester' before field var 'x_Semester'
        $val = $this->getFormValue("Semester", null) ?? $this->getFormValue("x_Semester", null);
        if (!$this->Semester->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Semester->Visible = false; // Disable update for API request
            } else {
                $this->Semester->setFormValue($val);
            }
        }

        // Check field name 'Tahun_Akademik' before field var 'x_Tahun_Akademik'
        $val = $this->getFormValue("Tahun_Akademik", null) ?? $this->getFormValue("x_Tahun_Akademik", null);
        if (!$this->Tahun_Akademik->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tahun_Akademik->Visible = false; // Disable update for API request
            } else {
                $this->Tahun_Akademik->setFormValue($val);
            }
        }

        // Check field name 'Dosen' before field var 'x_Dosen'
        $val = $this->getFormValue("Dosen", null) ?? $this->getFormValue("x_Dosen", null);
        if (!$this->Dosen->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Dosen->Visible = false; // Disable update for API request
            } else {
                $this->Dosen->setFormValue($val);
            }
        }

        // Check field name 'Tanggal' before field var 'x_Tanggal'
        $val = $this->getFormValue("Tanggal", null) ?? $this->getFormValue("x_Tanggal", null);
        if (!$this->Tanggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tanggal->Visible = false; // Disable update for API request
            } else {
                $this->Tanggal->setFormValue($val);
            }
            $this->Tanggal->CurrentValue = UnformatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        }

        // Check field name 'Ip' before field var 'x_Ip'
        $val = $this->getFormValue("Ip", null) ?? $this->getFormValue("x_Ip", null);
        if (!$this->Ip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Ip->Visible = false; // Disable update for API request
            } else {
                $this->Ip->setFormValue($val);
            }
        }

        // Check field name 'user' before field var 'x_user'
        $val = $this->getFormValue("user", null) ?? $this->getFormValue("x_user", null);
        if (!$this->user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user->Visible = false; // Disable update for API request
            } else {
                $this->user->setFormValue($val);
            }
        }

        // Check field name 'iduser' before field var 'x_iduser'
        $val = $this->getFormValue("iduser", null) ?? $this->getFormValue("x_iduser", null);
        if (!$this->iduser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->iduser->Visible = false; // Disable update for API request
            } else {
                $this->iduser->setFormValue($val);
            }
        }

        // Check field name 'id_mk' first before field var 'x_id_mk'
        $val = $this->hasFormValue("id_mk") ? $this->getFormValue("id_mk") : $this->getFormValue("x_id_mk");
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->Kode_MK->CurrentValue = $this->Kode_MK->FormValue;
        $this->Semester->CurrentValue = $this->Semester->FormValue;
        $this->Tahun_Akademik->CurrentValue = $this->Tahun_Akademik->FormValue;
        $this->Dosen->CurrentValue = $this->Dosen->FormValue;
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnformatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->Ip->CurrentValue = $this->Ip->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->iduser->CurrentValue = $this->iduser->FormValue;
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
        $this->id_mk->setDbValue($row['id_mk']);
        $this->Kode_MK->setDbValue($row['Kode_MK']);
        $this->Semester->setDbValue($row['Semester']);
        $this->Tahun_Akademik->setDbValue($row['Tahun_Akademik']);
        $this->Dosen->setDbValue($row['Dosen']);
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->Ip->setDbValue($row['Ip']);
        $this->user->setDbValue($row['user']);
        $this->iduser->setDbValue($row['iduser']);
    }

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['id_mk'] = $this->id_mk->DefaultValue;
        $row['Kode_MK'] = $this->Kode_MK->DefaultValue;
        $row['Semester'] = $this->Semester->DefaultValue;
        $row['Tahun_Akademik'] = $this->Tahun_Akademik->DefaultValue;
        $row['Dosen'] = $this->Dosen->DefaultValue;
        $row['Tanggal'] = $this->Tanggal->DefaultValue;
        $row['Ip'] = $this->Ip->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['iduser'] = $this->iduser->DefaultValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_mk
        $this->id_mk->RowCssClass = "row";

        // Kode_MK
        $this->Kode_MK->RowCssClass = "row";

        // Semester
        $this->Semester->RowCssClass = "row";

        // Tahun_Akademik
        $this->Tahun_Akademik->RowCssClass = "row";

        // Dosen
        $this->Dosen->RowCssClass = "row";

        // Tanggal
        $this->Tanggal->RowCssClass = "row";

        // Ip
        $this->Ip->RowCssClass = "row";

        // user
        $this->user->RowCssClass = "row";

        // iduser
        $this->iduser->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // id_mk
            $this->id_mk->ViewValue = $this->id_mk->CurrentValue;

            // Kode_MK
            $this->Kode_MK->ViewValue = $this->Kode_MK->CurrentValue;

            // Semester
            $this->Semester->ViewValue = $this->Semester->CurrentValue;

            // Tahun_Akademik
            $this->Tahun_Akademik->ViewValue = $this->Tahun_Akademik->CurrentValue;

            // Dosen
            $this->Dosen->ViewValue = $this->Dosen->CurrentValue;

            // Tanggal
            $this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
            $this->Tanggal->ViewValue = FormatDateTime($this->Tanggal->ViewValue, $this->Tanggal->formatPattern());

            // Ip
            $this->Ip->ViewValue = $this->Ip->CurrentValue;

            // user
            $this->user->ViewValue = $this->user->CurrentValue;

            // iduser
            $this->iduser->ViewValue = $this->iduser->CurrentValue;

            // Kode_MK
            $this->Kode_MK->HrefValue = "";

            // Semester
            $this->Semester->HrefValue = "";

            // Tahun_Akademik
            $this->Tahun_Akademik->HrefValue = "";

            // Dosen
            $this->Dosen->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // Ip
            $this->Ip->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // iduser
            $this->iduser->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // Kode_MK
            $this->Kode_MK->setupEditAttributes();
            $this->Kode_MK->EditValue = !$this->Kode_MK->Raw ? HtmlDecode($this->Kode_MK->CurrentValue) : $this->Kode_MK->CurrentValue;
            $this->Kode_MK->PlaceHolder = RemoveHtml($this->Kode_MK->caption());

            // Semester
            $this->Semester->setupEditAttributes();
            $this->Semester->EditValue = !$this->Semester->Raw ? HtmlDecode($this->Semester->CurrentValue) : $this->Semester->CurrentValue;
            $this->Semester->PlaceHolder = RemoveHtml($this->Semester->caption());

            // Tahun_Akademik
            $this->Tahun_Akademik->setupEditAttributes();
            $this->Tahun_Akademik->EditValue = !$this->Tahun_Akademik->Raw ? HtmlDecode($this->Tahun_Akademik->CurrentValue) : $this->Tahun_Akademik->CurrentValue;
            $this->Tahun_Akademik->PlaceHolder = RemoveHtml($this->Tahun_Akademik->caption());

            // Dosen
            $this->Dosen->setupEditAttributes();
            $this->Dosen->EditValue = !$this->Dosen->Raw ? HtmlDecode($this->Dosen->CurrentValue) : $this->Dosen->CurrentValue;
            $this->Dosen->PlaceHolder = RemoveHtml($this->Dosen->caption());

            // Tanggal

            // Ip

            // user

            // iduser

            // Add refer script

            // Kode_MK
            $this->Kode_MK->HrefValue = "";

            // Semester
            $this->Semester->HrefValue = "";

            // Tahun_Akademik
            $this->Tahun_Akademik->HrefValue = "";

            // Dosen
            $this->Dosen->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // Ip
            $this->Ip->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // iduser
            $this->iduser->HrefValue = "";
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
            if ($this->Kode_MK->Visible && $this->Kode_MK->Required) {
                if (!$this->Kode_MK->IsDetailKey && IsEmpty($this->Kode_MK->FormValue)) {
                    $this->Kode_MK->addErrorMessage(str_replace("%s", $this->Kode_MK->caption(), $this->Kode_MK->RequiredErrorMessage));
                }
            }
            if ($this->Semester->Visible && $this->Semester->Required) {
                if (!$this->Semester->IsDetailKey && IsEmpty($this->Semester->FormValue)) {
                    $this->Semester->addErrorMessage(str_replace("%s", $this->Semester->caption(), $this->Semester->RequiredErrorMessage));
                }
            }
            if ($this->Tahun_Akademik->Visible && $this->Tahun_Akademik->Required) {
                if (!$this->Tahun_Akademik->IsDetailKey && IsEmpty($this->Tahun_Akademik->FormValue)) {
                    $this->Tahun_Akademik->addErrorMessage(str_replace("%s", $this->Tahun_Akademik->caption(), $this->Tahun_Akademik->RequiredErrorMessage));
                }
            }
            if ($this->Dosen->Visible && $this->Dosen->Required) {
                if (!$this->Dosen->IsDetailKey && IsEmpty($this->Dosen->FormValue)) {
                    $this->Dosen->addErrorMessage(str_replace("%s", $this->Dosen->caption(), $this->Dosen->RequiredErrorMessage));
                }
            }
            if ($this->Tanggal->Visible && $this->Tanggal->Required) {
                if (!$this->Tanggal->IsDetailKey && IsEmpty($this->Tanggal->FormValue)) {
                    $this->Tanggal->addErrorMessage(str_replace("%s", $this->Tanggal->caption(), $this->Tanggal->RequiredErrorMessage));
                }
            }
            if ($this->Ip->Visible && $this->Ip->Required) {
                if (!$this->Ip->IsDetailKey && IsEmpty($this->Ip->FormValue)) {
                    $this->Ip->addErrorMessage(str_replace("%s", $this->Ip->caption(), $this->Ip->RequiredErrorMessage));
                }
            }
            if ($this->user->Visible && $this->user->Required) {
                if (!$this->user->IsDetailKey && IsEmpty($this->user->FormValue)) {
                    $this->user->addErrorMessage(str_replace("%s", $this->user->caption(), $this->user->RequiredErrorMessage));
                }
            }
            if ($this->iduser->Visible && $this->iduser->Required) {
                if (!$this->iduser->IsDetailKey && IsEmpty($this->iduser->FormValue)) {
                    $this->iduser->addErrorMessage(str_replace("%s", $this->iduser->caption(), $this->iduser->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("DetilMataKuliahGrid");
        if (in_array("detil_mata_kuliah", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

    // Add record
    protected function addRow(?array $oldRow = null): bool
    {
        // Get new row
        $newRow = $this->getAddRow();

        // Update current values
        $this->Fields->setCurrentValues($newRow);
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("DetilMataKuliahGrid");
            if (in_array("detil_mata_kuliah", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->Kode_MK->setSessionValue($this->Kode_MK->CurrentValue); // Set master key
                $this->security->loadCurrentUserLevel($this->ProjectID . "detil_mata_kuliah"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $this->security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->Kode_MK->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    if ($conn->isTransactionActive()) {
                        $conn->commit();
                    }
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    if ($conn->isTransactionActive()) {
                        $conn->rollback();
                    }
                }
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($oldRow, $newRow);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromResult([$newRow], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
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

        // Semester
        $this->Semester->setDbValueDef($newRow, $this->Semester->CurrentValue, false);

        // Tahun_Akademik
        $this->Tahun_Akademik->setDbValueDef($newRow, $this->Tahun_Akademik->CurrentValue, false);

        // Dosen
        $this->Dosen->setDbValueDef($newRow, $this->Dosen->CurrentValue, false);

        // Tanggal
        $this->Tanggal->CurrentValue = $this->Tanggal->getAutoUpdateValue(); // PHP
        $this->Tanggal->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern()), false);

        // Ip
        $this->Ip->CurrentValue = $this->Ip->getAutoUpdateValue(); // PHP
        $this->Ip->setDbValueDef($newRow, $this->Ip->CurrentValue, false);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($newRow, $this->user->CurrentValue, false);

        // iduser
        $this->iduser->CurrentValue = $this->iduser->getAutoUpdateValue(); // PHP
        $this->iduser->setDbValueDef($newRow, $this->iduser->CurrentValue, false);
        return $newRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms(): void
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("detil_mata_kuliah", $detailTblVar)) {
                $detailPageObj = Container("DetilMataKuliahGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->Kode_MK->IsDetailKey = true;
                    $detailPageObj->Kode_MK->CurrentValue = $this->Kode_MK->CurrentValue;
                    $detailPageObj->Kode_MK->setSessionValue($detailPageObj->Kode_MK->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("matakuliahlist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $breadcrumb->add("add", $pageId, $url);
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
}
