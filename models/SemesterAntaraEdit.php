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
class SemesterAntaraEdit extends SemesterAntara
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "edit";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "SemesterAntaraEdit";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "semesterantaraedit";

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
        $this->id_smtr->setVisibility();
        $this->Semester->setVisibility();
        $this->Jadwal->setVisibility();
        $this->Tahun_Akademik->setVisibility();
        $this->Tanggal->setVisibility();
        $this->User_id->setVisibility();
        $this->User->setVisibility();
        $this->IP->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'semester_antara';
        $this->TableName = 'semester_antara';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Save if user language changed
        if (Param("language") !== null) {
            Profile()->setLanguageId(Param("language"))->saveToStorage();
        }

        // Table object (semester_antara)
        if (!isset($GLOBALS["semester_antara"]) || $GLOBALS["semester_antara"]::class == PROJECT_NAMESPACE . "semester_antara") {
            $GLOBALS["semester_antara"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'semester_antara');
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
                        $result["view"] = SameString($pageName, "semesterantaraview"); // If View page, no primary button
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
            $key .= @$ar['id_smtr'];
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

    // Properties
    public string $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public bool $IsModal = false;
    public bool $IsMobileOrModal = false;
    public ?string $DbMasterFilter = "";
    public string $DbDetailFilter = "";
    public ?string $HashValue = null; // Hash Value
    public int $DisplayRecords = 1;
    public int $StartRecord = 0;
    public int $StopRecord = 0;
    public int $TotalRecords = 0;
    public int $RecordRange = 10;
    public int $RecordCount = 0;

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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id_smtr") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_smtr->setQueryStringValue($keyValue);
                $this->id_smtr->setOldValue($this->id_smtr->QueryStringValue);
            } elseif (Post("id_smtr") !== null) {
                $this->id_smtr->setFormValue(Post("id_smtr"));
                $this->id_smtr->setOldValue($this->id_smtr->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($this->language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey($this->getOldKey(), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id_smtr") ?? Route("id_smtr")) !== null) {
                    $this->id_smtr->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_smtr->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if (!$this->peekFailureMessage()) {
                            $this->setFailureMessage($this->language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("semesterantaralist"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "semesterantaralist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                if ($this->editRow()) { // Update record based on key
                    CleanUploadTempPaths(SessionId());
                    if (!$this->peekSuccessMessage()) {
                        $this->setSuccessMessage($this->language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "semesterantaralist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "semesterantaralist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->terminate();
                    return;
                } elseif (($this->peekFailureMessage()[0] ?? "") == $this->language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues(): void
    {
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id_smtr' before field var 'x_id_smtr'
        $val = $this->getFormValue("id_smtr", null) ?? $this->getFormValue("x_id_smtr", null);
        if (!$this->id_smtr->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_smtr->Visible = false; // Disable update for API request
            } else {
                $this->id_smtr->setFormValue($val);
            }
        }
        if ($this->hasFormValue("o_id_smtr")) {
            $this->id_smtr->setOldValue($this->getFormValue("o_id_smtr"));
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

        // Check field name 'Jadwal' before field var 'x_Jadwal'
        $val = $this->getFormValue("Jadwal", null) ?? $this->getFormValue("x_Jadwal", null);
        if (!$this->Jadwal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jadwal->Visible = false; // Disable update for API request
            } else {
                $this->Jadwal->setFormValue($val);
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

        // Check field name 'Tanggal' before field var 'x_Tanggal'
        $val = $this->getFormValue("Tanggal", null) ?? $this->getFormValue("x_Tanggal", null);
        if (!$this->Tanggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tanggal->Visible = false; // Disable update for API request
            } else {
                $this->Tanggal->setFormValue($val, true, $validate);
            }
            $this->Tanggal->CurrentValue = UnformatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        }

        // Check field name 'User_id' before field var 'x_User_id'
        $val = $this->getFormValue("User_id", null) ?? $this->getFormValue("x_User_id", null);
        if (!$this->User_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->User_id->Visible = false; // Disable update for API request
            } else {
                $this->User_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'User' before field var 'x_User'
        $val = $this->getFormValue("User", null) ?? $this->getFormValue("x_User", null);
        if (!$this->User->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->User->Visible = false; // Disable update for API request
            } else {
                $this->User->setFormValue($val);
            }
        }

        // Check field name 'IP' before field var 'x_IP'
        $val = $this->getFormValue("IP", null) ?? $this->getFormValue("x_IP", null);
        if (!$this->IP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IP->Visible = false; // Disable update for API request
            } else {
                $this->IP->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->id_smtr->CurrentValue = $this->id_smtr->FormValue;
        $this->Semester->CurrentValue = $this->Semester->FormValue;
        $this->Jadwal->CurrentValue = $this->Jadwal->FormValue;
        $this->Tahun_Akademik->CurrentValue = $this->Tahun_Akademik->FormValue;
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnformatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->User_id->CurrentValue = $this->User_id->FormValue;
        $this->User->CurrentValue = $this->User->FormValue;
        $this->IP->CurrentValue = $this->IP->FormValue;
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
        $this->id_smtr->setDbValue($row['id_smtr']);
        $this->Semester->setDbValue($row['Semester']);
        $this->Jadwal->setDbValue($row['Jadwal']);
        $this->Tahun_Akademik->setDbValue($row['Tahun_Akademik']);
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->User_id->setDbValue($row['User_id']);
        $this->User->setDbValue($row['User']);
        $this->IP->setDbValue($row['IP']);
    }

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['id_smtr'] = $this->id_smtr->DefaultValue;
        $row['Semester'] = $this->Semester->DefaultValue;
        $row['Jadwal'] = $this->Jadwal->DefaultValue;
        $row['Tahun_Akademik'] = $this->Tahun_Akademik->DefaultValue;
        $row['Tanggal'] = $this->Tanggal->DefaultValue;
        $row['User_id'] = $this->User_id->DefaultValue;
        $row['User'] = $this->User->DefaultValue;
        $row['IP'] = $this->IP->DefaultValue;
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

        // id_smtr
        $this->id_smtr->RowCssClass = "row";

        // Semester
        $this->Semester->RowCssClass = "row";

        // Jadwal
        $this->Jadwal->RowCssClass = "row";

        // Tahun_Akademik
        $this->Tahun_Akademik->RowCssClass = "row";

        // Tanggal
        $this->Tanggal->RowCssClass = "row";

        // User_id
        $this->User_id->RowCssClass = "row";

        // User
        $this->User->RowCssClass = "row";

        // IP
        $this->IP->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // id_smtr
            $this->id_smtr->ViewValue = $this->id_smtr->CurrentValue;

            // Semester
            $this->Semester->ViewValue = $this->Semester->CurrentValue;

            // Jadwal
            $this->Jadwal->ViewValue = $this->Jadwal->CurrentValue;

            // Tahun_Akademik
            $this->Tahun_Akademik->ViewValue = $this->Tahun_Akademik->CurrentValue;

            // Tanggal
            $this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
            $this->Tanggal->ViewValue = FormatDateTime($this->Tanggal->ViewValue, $this->Tanggal->formatPattern());

            // User_id
            $this->User_id->ViewValue = $this->User_id->CurrentValue;
            $this->User_id->ViewValue = FormatNumber($this->User_id->ViewValue, $this->User_id->formatPattern());

            // User
            $this->User->ViewValue = $this->User->CurrentValue;

            // IP
            $this->IP->ViewValue = $this->IP->CurrentValue;

            // id_smtr
            $this->id_smtr->HrefValue = "";

            // Semester
            $this->Semester->HrefValue = "";

            // Jadwal
            $this->Jadwal->HrefValue = "";

            // Tahun_Akademik
            $this->Tahun_Akademik->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // User_id
            $this->User_id->HrefValue = "";

            // User
            $this->User->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // id_smtr
            $this->id_smtr->setupEditAttributes();
            $this->id_smtr->EditValue = !$this->id_smtr->Raw ? HtmlDecode($this->id_smtr->CurrentValue) : $this->id_smtr->CurrentValue;
            $this->id_smtr->PlaceHolder = RemoveHtml($this->id_smtr->caption());

            // Semester
            $this->Semester->setupEditAttributes();
            $this->Semester->EditValue = !$this->Semester->Raw ? HtmlDecode($this->Semester->CurrentValue) : $this->Semester->CurrentValue;
            $this->Semester->PlaceHolder = RemoveHtml($this->Semester->caption());

            // Jadwal
            $this->Jadwal->setupEditAttributes();
            $this->Jadwal->EditValue = !$this->Jadwal->Raw ? HtmlDecode($this->Jadwal->CurrentValue) : $this->Jadwal->CurrentValue;
            $this->Jadwal->PlaceHolder = RemoveHtml($this->Jadwal->caption());

            // Tahun_Akademik
            $this->Tahun_Akademik->setupEditAttributes();
            $this->Tahun_Akademik->EditValue = !$this->Tahun_Akademik->Raw ? HtmlDecode($this->Tahun_Akademik->CurrentValue) : $this->Tahun_Akademik->CurrentValue;
            $this->Tahun_Akademik->PlaceHolder = RemoveHtml($this->Tahun_Akademik->caption());

            // Tanggal
            $this->Tanggal->setupEditAttributes();
            $this->Tanggal->EditValue = FormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
            $this->Tanggal->PlaceHolder = RemoveHtml($this->Tanggal->caption());

            // User_id
            $this->User_id->setupEditAttributes();
            $this->User_id->EditValue = $this->User_id->CurrentValue;
            $this->User_id->PlaceHolder = RemoveHtml($this->User_id->caption());
            if (strval($this->User_id->EditValue) != "" && is_numeric($this->User_id->EditValue)) {
                $this->User_id->EditValue = FormatNumber($this->User_id->EditValue, null);
            }

            // User
            $this->User->setupEditAttributes();
            $this->User->EditValue = !$this->User->Raw ? HtmlDecode($this->User->CurrentValue) : $this->User->CurrentValue;
            $this->User->PlaceHolder = RemoveHtml($this->User->caption());

            // IP
            $this->IP->setupEditAttributes();
            $this->IP->EditValue = !$this->IP->Raw ? HtmlDecode($this->IP->CurrentValue) : $this->IP->CurrentValue;
            $this->IP->PlaceHolder = RemoveHtml($this->IP->caption());

            // Edit refer script

            // id_smtr
            $this->id_smtr->HrefValue = "";

            // Semester
            $this->Semester->HrefValue = "";

            // Jadwal
            $this->Jadwal->HrefValue = "";

            // Tahun_Akademik
            $this->Tahun_Akademik->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // User_id
            $this->User_id->HrefValue = "";

            // User
            $this->User->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";
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
            if ($this->id_smtr->Visible && $this->id_smtr->Required) {
                if (!$this->id_smtr->IsDetailKey && IsEmpty($this->id_smtr->FormValue)) {
                    $this->id_smtr->addErrorMessage(str_replace("%s", $this->id_smtr->caption(), $this->id_smtr->RequiredErrorMessage));
                }
            }
            if ($this->Semester->Visible && $this->Semester->Required) {
                if (!$this->Semester->IsDetailKey && IsEmpty($this->Semester->FormValue)) {
                    $this->Semester->addErrorMessage(str_replace("%s", $this->Semester->caption(), $this->Semester->RequiredErrorMessage));
                }
            }
            if ($this->Jadwal->Visible && $this->Jadwal->Required) {
                if (!$this->Jadwal->IsDetailKey && IsEmpty($this->Jadwal->FormValue)) {
                    $this->Jadwal->addErrorMessage(str_replace("%s", $this->Jadwal->caption(), $this->Jadwal->RequiredErrorMessage));
                }
            }
            if ($this->Tahun_Akademik->Visible && $this->Tahun_Akademik->Required) {
                if (!$this->Tahun_Akademik->IsDetailKey && IsEmpty($this->Tahun_Akademik->FormValue)) {
                    $this->Tahun_Akademik->addErrorMessage(str_replace("%s", $this->Tahun_Akademik->caption(), $this->Tahun_Akademik->RequiredErrorMessage));
                }
            }
            if ($this->Tanggal->Visible && $this->Tanggal->Required) {
                if (!$this->Tanggal->IsDetailKey && IsEmpty($this->Tanggal->FormValue)) {
                    $this->Tanggal->addErrorMessage(str_replace("%s", $this->Tanggal->caption(), $this->Tanggal->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->Tanggal->FormValue, $this->Tanggal->formatPattern())) {
                $this->Tanggal->addErrorMessage($this->Tanggal->getErrorMessage(false));
            }
            if ($this->User_id->Visible && $this->User_id->Required) {
                if (!$this->User_id->IsDetailKey && IsEmpty($this->User_id->FormValue)) {
                    $this->User_id->addErrorMessage(str_replace("%s", $this->User_id->caption(), $this->User_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->User_id->FormValue)) {
                $this->User_id->addErrorMessage($this->User_id->getErrorMessage(false));
            }
            if ($this->User->Visible && $this->User->Required) {
                if (!$this->User->IsDetailKey && IsEmpty($this->User->FormValue)) {
                    $this->User->addErrorMessage(str_replace("%s", $this->User->caption(), $this->User->RequiredErrorMessage));
                }
            }
            if ($this->IP->Visible && $this->IP->Required) {
                if (!$this->IP->IsDetailKey && IsEmpty($this->IP->FormValue)) {
                    $this->IP->addErrorMessage(str_replace("%s", $this->IP->caption(), $this->IP->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("DetilSemesterAntaraGrid");
        if (in_array("detil_semester_antara", $detailTblVar) && $detailPage->DetailEdit) {
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

        // Check field with unique index (id_smtr)
        if ($this->id_smtr->CurrentValue != "") {
            $filterChk = "(`id_smtr` = '" . AdjustSql($this->id_smtr->CurrentValue) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetchAssociative()) {
                $idxErrMsg = sprintf($this->language->phrase("DuplicateIndex"), $this->id_smtr->CurrentValue, $this->id_smtr->caption());
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("DetilSemesterAntaraGrid");
            if (in_array("detil_semester_antara", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $this->security->loadCurrentUserLevel($this->ProjectID . "detil_semester_antara"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $this->security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
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

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromResult([$newRow], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
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

        // id_smtr
        $this->id_smtr->setDbValueDef($newRow, $this->id_smtr->CurrentValue, $this->id_smtr->ReadOnly);

        // Semester
        $this->Semester->setDbValueDef($newRow, $this->Semester->CurrentValue, $this->Semester->ReadOnly);

        // Jadwal
        $this->Jadwal->setDbValueDef($newRow, $this->Jadwal->CurrentValue, $this->Jadwal->ReadOnly);

        // Tahun_Akademik
        $this->Tahun_Akademik->setDbValueDef($newRow, $this->Tahun_Akademik->CurrentValue, $this->Tahun_Akademik->ReadOnly);

        // Tanggal
        $this->Tanggal->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern()), $this->Tanggal->ReadOnly);

        // User_id
        $this->User_id->setDbValueDef($newRow, $this->User_id->CurrentValue, $this->User_id->ReadOnly);

        // User
        $this->User->setDbValueDef($newRow, $this->User->CurrentValue, $this->User->ReadOnly);

        // IP
        $this->IP->setDbValueDef($newRow, $this->IP->CurrentValue, $this->IP->ReadOnly);
        return $newRow;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow(array $row): void
    {
        if (isset($row['id_smtr'])) { // id_smtr
            $this->id_smtr->CurrentValue = $row['id_smtr'];
        }
        if (isset($row['Semester'])) { // Semester
            $this->Semester->CurrentValue = $row['Semester'];
        }
        if (isset($row['Jadwal'])) { // Jadwal
            $this->Jadwal->CurrentValue = $row['Jadwal'];
        }
        if (isset($row['Tahun_Akademik'])) { // Tahun_Akademik
            $this->Tahun_Akademik->CurrentValue = $row['Tahun_Akademik'];
        }
        if (isset($row['Tanggal'])) { // Tanggal
            $this->Tanggal->CurrentValue = $row['Tanggal'];
        }
        if (isset($row['User_id'])) { // User_id
            $this->User_id->CurrentValue = $row['User_id'];
        }
        if (isset($row['User'])) { // User
            $this->User->CurrentValue = $row['User'];
        }
        if (isset($row['IP'])) { // IP
            $this->IP->CurrentValue = $row['IP'];
        }
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
            if (in_array("detil_semester_antara", $detailTblVar)) {
                $detailPageObj = Container("DetilSemesterAntaraGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_smtsr->IsDetailKey = true;
                    $detailPageObj->id_smtsr->CurrentValue = $this->id_smtr->CurrentValue;
                    $detailPageObj->id_smtsr->setSessionValue($detailPageObj->id_smtsr->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("semesterantaralist"), "", $this->TableVar, true);
        $pageId = "edit";
        $breadcrumb->add("edit", $pageId, $url);
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
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
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
