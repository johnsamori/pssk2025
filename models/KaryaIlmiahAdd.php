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
class KaryaIlmiahAdd extends KaryaIlmiah
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "add";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "KaryaIlmiahAdd";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "karyailmiahadd";

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
        $this->Id_karya_ilmiah->Visible = false;
        $this->NIM->setVisibility();
        $this->Judul_Penelitian->setVisibility();
        $this->Pembimbing_1->setVisibility();
        $this->Pembimbing_2->setVisibility();
        $this->Pembimbing_3->setVisibility();
        $this->Penguji_1->setVisibility();
        $this->Penguji_2->setVisibility();
        $this->Lembar_Pengesahan->setVisibility();
        $this->Judul_Publikasi->setVisibility();
        $this->Link_Publikasi->setVisibility();
        $this->user_id->setVisibility();
        $this->user->setVisibility();
        $this->ip->setVisibility();
        $this->tanggal->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'karya_ilmiah';
        $this->TableName = 'karya_ilmiah';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Save if user language changed
        if (Param("language") !== null) {
            Profile()->setLanguageId(Param("language"))->saveToStorage();
        }

        // Table object (karya_ilmiah)
        if (!isset($GLOBALS["karya_ilmiah"]) || $GLOBALS["karya_ilmiah"]::class == PROJECT_NAMESPACE . "karya_ilmiah") {
            $GLOBALS["karya_ilmiah"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'karya_ilmiah');
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
                        $result["view"] = SameString($pageName, "karyailmiahview"); // If View page, no primary button
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
            $key .= @$ar['Id_karya_ilmiah'];
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
            $this->Id_karya_ilmiah->Visible = false;
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
            if (($keyValue = Get("Id_karya_ilmiah") ?? Route("Id_karya_ilmiah")) !== null) {
                $this->Id_karya_ilmiah->setQueryStringValue($keyValue);
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
                    $this->terminate("karyailmiahlist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                if ($this->addRow($oldRow)) { // Add successful
                    CleanUploadTempPaths(SessionId());
                    if (!$this->peekSuccessMessage() && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($this->language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "karyailmiahlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "karyailmiahview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "karyailmiahlist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "karyailmiahlist"; // Return list page content
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
        $this->Lembar_Pengesahan->Upload->Index = $this->FormIndex;
        $this->Lembar_Pengesahan->Upload->uploadFile();
    }

    // Load default values
    protected function loadDefaultValues(): void
    {
    }

    // Load form values
    protected function loadFormValues(): void
    {
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'NIM' before field var 'x_NIM'
        $val = $this->getFormValue("NIM", null) ?? $this->getFormValue("x_NIM", null);
        if (!$this->NIM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIM->Visible = false; // Disable update for API request
            } else {
                $this->NIM->setFormValue($val);
            }
        }

        // Check field name 'Judul_Penelitian' before field var 'x_Judul_Penelitian'
        $val = $this->getFormValue("Judul_Penelitian", null) ?? $this->getFormValue("x_Judul_Penelitian", null);
        if (!$this->Judul_Penelitian->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Judul_Penelitian->Visible = false; // Disable update for API request
            } else {
                $this->Judul_Penelitian->setFormValue($val);
            }
        }

        // Check field name 'Pembimbing_1' before field var 'x_Pembimbing_1'
        $val = $this->getFormValue("Pembimbing_1", null) ?? $this->getFormValue("x_Pembimbing_1", null);
        if (!$this->Pembimbing_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pembimbing_1->Visible = false; // Disable update for API request
            } else {
                $this->Pembimbing_1->setFormValue($val);
            }
        }

        // Check field name 'Pembimbing_2' before field var 'x_Pembimbing_2'
        $val = $this->getFormValue("Pembimbing_2", null) ?? $this->getFormValue("x_Pembimbing_2", null);
        if (!$this->Pembimbing_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pembimbing_2->Visible = false; // Disable update for API request
            } else {
                $this->Pembimbing_2->setFormValue($val);
            }
        }

        // Check field name 'Pembimbing_3' before field var 'x_Pembimbing_3'
        $val = $this->getFormValue("Pembimbing_3", null) ?? $this->getFormValue("x_Pembimbing_3", null);
        if (!$this->Pembimbing_3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pembimbing_3->Visible = false; // Disable update for API request
            } else {
                $this->Pembimbing_3->setFormValue($val);
            }
        }

        // Check field name 'Penguji_1' before field var 'x_Penguji_1'
        $val = $this->getFormValue("Penguji_1", null) ?? $this->getFormValue("x_Penguji_1", null);
        if (!$this->Penguji_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Penguji_1->Visible = false; // Disable update for API request
            } else {
                $this->Penguji_1->setFormValue($val);
            }
        }

        // Check field name 'Penguji_2' before field var 'x_Penguji_2'
        $val = $this->getFormValue("Penguji_2", null) ?? $this->getFormValue("x_Penguji_2", null);
        if (!$this->Penguji_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Penguji_2->Visible = false; // Disable update for API request
            } else {
                $this->Penguji_2->setFormValue($val);
            }
        }

        // Check field name 'Judul_Publikasi' before field var 'x_Judul_Publikasi'
        $val = $this->getFormValue("Judul_Publikasi", null) ?? $this->getFormValue("x_Judul_Publikasi", null);
        if (!$this->Judul_Publikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Judul_Publikasi->Visible = false; // Disable update for API request
            } else {
                $this->Judul_Publikasi->setFormValue($val);
            }
        }

        // Check field name 'Link_Publikasi' before field var 'x_Link_Publikasi'
        $val = $this->getFormValue("Link_Publikasi", null) ?? $this->getFormValue("x_Link_Publikasi", null);
        if (!$this->Link_Publikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Link_Publikasi->Visible = false; // Disable update for API request
            } else {
                $this->Link_Publikasi->setFormValue($val);
            }
        }

        // Check field name 'user_id' before field var 'x_user_id'
        $val = $this->getFormValue("user_id", null) ?? $this->getFormValue("x_user_id", null);
        if (!$this->user_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_id->Visible = false; // Disable update for API request
            } else {
                $this->user_id->setFormValue($val);
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

        // Check field name 'ip' before field var 'x_ip'
        $val = $this->getFormValue("ip", null) ?? $this->getFormValue("x_ip", null);
        if (!$this->ip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ip->Visible = false; // Disable update for API request
            } else {
                $this->ip->setFormValue($val);
            }
        }

        // Check field name 'tanggal' before field var 'x_tanggal'
        $val = $this->getFormValue("tanggal", null) ?? $this->getFormValue("x_tanggal", null);
        if (!$this->tanggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal->Visible = false; // Disable update for API request
            } else {
                $this->tanggal->setFormValue($val);
            }
            $this->tanggal->CurrentValue = UnformatDateTime($this->tanggal->CurrentValue, $this->tanggal->formatPattern());
        }

        // Check field name 'Id_karya_ilmiah' first before field var 'x_Id_karya_ilmiah'
        $val = $this->hasFormValue("Id_karya_ilmiah") ? $this->getFormValue("Id_karya_ilmiah") : $this->getFormValue("x_Id_karya_ilmiah");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->NIM->CurrentValue = $this->NIM->FormValue;
        $this->Judul_Penelitian->CurrentValue = $this->Judul_Penelitian->FormValue;
        $this->Pembimbing_1->CurrentValue = $this->Pembimbing_1->FormValue;
        $this->Pembimbing_2->CurrentValue = $this->Pembimbing_2->FormValue;
        $this->Pembimbing_3->CurrentValue = $this->Pembimbing_3->FormValue;
        $this->Penguji_1->CurrentValue = $this->Penguji_1->FormValue;
        $this->Penguji_2->CurrentValue = $this->Penguji_2->FormValue;
        $this->Judul_Publikasi->CurrentValue = $this->Judul_Publikasi->FormValue;
        $this->Link_Publikasi->CurrentValue = $this->Link_Publikasi->FormValue;
        $this->user_id->CurrentValue = $this->user_id->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->ip->CurrentValue = $this->ip->FormValue;
        $this->tanggal->CurrentValue = $this->tanggal->FormValue;
        $this->tanggal->CurrentValue = UnformatDateTime($this->tanggal->CurrentValue, $this->tanggal->formatPattern());
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
        $this->Id_karya_ilmiah->setDbValue($row['Id_karya_ilmiah']);
        $this->NIM->setDbValue($row['NIM']);
        $this->Judul_Penelitian->setDbValue($row['Judul_Penelitian']);
        $this->Pembimbing_1->setDbValue($row['Pembimbing_1']);
        $this->Pembimbing_2->setDbValue($row['Pembimbing_2']);
        $this->Pembimbing_3->setDbValue($row['Pembimbing_3']);
        $this->Penguji_1->setDbValue($row['Penguji_1']);
        $this->Penguji_2->setDbValue($row['Penguji_2']);
        $this->Lembar_Pengesahan->Upload->DbValue = $row['Lembar_Pengesahan'];
        $this->Lembar_Pengesahan->setDbValue($this->Lembar_Pengesahan->Upload->DbValue);
        $this->Judul_Publikasi->setDbValue($row['Judul_Publikasi']);
        $this->Link_Publikasi->setDbValue($row['Link_Publikasi']);
        $this->user_id->setDbValue($row['user_id']);
        $this->user->setDbValue($row['user']);
        $this->ip->setDbValue($row['ip']);
        $this->tanggal->setDbValue($row['tanggal']);
    }

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['Id_karya_ilmiah'] = $this->Id_karya_ilmiah->DefaultValue;
        $row['NIM'] = $this->NIM->DefaultValue;
        $row['Judul_Penelitian'] = $this->Judul_Penelitian->DefaultValue;
        $row['Pembimbing_1'] = $this->Pembimbing_1->DefaultValue;
        $row['Pembimbing_2'] = $this->Pembimbing_2->DefaultValue;
        $row['Pembimbing_3'] = $this->Pembimbing_3->DefaultValue;
        $row['Penguji_1'] = $this->Penguji_1->DefaultValue;
        $row['Penguji_2'] = $this->Penguji_2->DefaultValue;
        $row['Lembar_Pengesahan'] = $this->Lembar_Pengesahan->DefaultValue;
        $row['Judul_Publikasi'] = $this->Judul_Publikasi->DefaultValue;
        $row['Link_Publikasi'] = $this->Link_Publikasi->DefaultValue;
        $row['user_id'] = $this->user_id->DefaultValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Id_karya_ilmiah
        $this->Id_karya_ilmiah->RowCssClass = "row";

        // NIM
        $this->NIM->RowCssClass = "row";

        // Judul_Penelitian
        $this->Judul_Penelitian->RowCssClass = "row";

        // Pembimbing_1
        $this->Pembimbing_1->RowCssClass = "row";

        // Pembimbing_2
        $this->Pembimbing_2->RowCssClass = "row";

        // Pembimbing_3
        $this->Pembimbing_3->RowCssClass = "row";

        // Penguji_1
        $this->Penguji_1->RowCssClass = "row";

        // Penguji_2
        $this->Penguji_2->RowCssClass = "row";

        // Lembar_Pengesahan
        $this->Lembar_Pengesahan->RowCssClass = "row";

        // Judul_Publikasi
        $this->Judul_Publikasi->RowCssClass = "row";

        // Link_Publikasi
        $this->Link_Publikasi->RowCssClass = "row";

        // user_id
        $this->user_id->RowCssClass = "row";

        // user
        $this->user->RowCssClass = "row";

        // ip
        $this->ip->RowCssClass = "row";

        // tanggal
        $this->tanggal->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Id_karya_ilmiah
            $this->Id_karya_ilmiah->ViewValue = $this->Id_karya_ilmiah->CurrentValue;

            // NIM
            $this->NIM->ViewValue = $this->NIM->CurrentValue;

            // Judul_Penelitian
            $this->Judul_Penelitian->ViewValue = $this->Judul_Penelitian->CurrentValue;

            // Pembimbing_1
            $this->Pembimbing_1->ViewValue = $this->Pembimbing_1->CurrentValue;

            // Pembimbing_2
            $this->Pembimbing_2->ViewValue = $this->Pembimbing_2->CurrentValue;

            // Pembimbing_3
            $this->Pembimbing_3->ViewValue = $this->Pembimbing_3->CurrentValue;

            // Penguji_1
            $this->Penguji_1->ViewValue = $this->Penguji_1->CurrentValue;

            // Penguji_2
            $this->Penguji_2->ViewValue = $this->Penguji_2->CurrentValue;

            // Lembar_Pengesahan
            if (!IsEmpty($this->Lembar_Pengesahan->Upload->DbValue)) {
                $this->Lembar_Pengesahan->ViewValue = $this->Lembar_Pengesahan->Upload->DbValue;
            } else {
                $this->Lembar_Pengesahan->ViewValue = "";
            }

            // Judul_Publikasi
            $this->Judul_Publikasi->ViewValue = $this->Judul_Publikasi->CurrentValue;

            // Link_Publikasi
            $this->Link_Publikasi->ViewValue = $this->Link_Publikasi->CurrentValue;

            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;

            // user
            $this->user->ViewValue = $this->user->CurrentValue;

            // ip
            $this->ip->ViewValue = $this->ip->CurrentValue;

            // tanggal
            $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
            $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, $this->tanggal->formatPattern());

            // NIM
            $this->NIM->HrefValue = "";

            // Judul_Penelitian
            $this->Judul_Penelitian->HrefValue = "";

            // Pembimbing_1
            $this->Pembimbing_1->HrefValue = "";

            // Pembimbing_2
            $this->Pembimbing_2->HrefValue = "";

            // Pembimbing_3
            $this->Pembimbing_3->HrefValue = "";

            // Penguji_1
            $this->Penguji_1->HrefValue = "";

            // Penguji_2
            $this->Penguji_2->HrefValue = "";

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->HrefValue = "";
            $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;

            // Judul_Publikasi
            $this->Judul_Publikasi->HrefValue = "";

            // Link_Publikasi
            $this->Link_Publikasi->HrefValue = "";

            // user_id
            $this->user_id->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";

            // tanggal
            $this->tanggal->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // NIM
            $this->NIM->setupEditAttributes();
            $this->NIM->EditValue = !$this->NIM->Raw ? HtmlDecode($this->NIM->CurrentValue) : $this->NIM->CurrentValue;
            $this->NIM->PlaceHolder = RemoveHtml($this->NIM->caption());

            // Judul_Penelitian
            $this->Judul_Penelitian->setupEditAttributes();
            $this->Judul_Penelitian->EditValue = !$this->Judul_Penelitian->Raw ? HtmlDecode($this->Judul_Penelitian->CurrentValue) : $this->Judul_Penelitian->CurrentValue;
            $this->Judul_Penelitian->PlaceHolder = RemoveHtml($this->Judul_Penelitian->caption());

            // Pembimbing_1
            $this->Pembimbing_1->setupEditAttributes();
            $this->Pembimbing_1->EditValue = !$this->Pembimbing_1->Raw ? HtmlDecode($this->Pembimbing_1->CurrentValue) : $this->Pembimbing_1->CurrentValue;
            $this->Pembimbing_1->PlaceHolder = RemoveHtml($this->Pembimbing_1->caption());

            // Pembimbing_2
            $this->Pembimbing_2->setupEditAttributes();
            $this->Pembimbing_2->EditValue = !$this->Pembimbing_2->Raw ? HtmlDecode($this->Pembimbing_2->CurrentValue) : $this->Pembimbing_2->CurrentValue;
            $this->Pembimbing_2->PlaceHolder = RemoveHtml($this->Pembimbing_2->caption());

            // Pembimbing_3
            $this->Pembimbing_3->setupEditAttributes();
            $this->Pembimbing_3->EditValue = !$this->Pembimbing_3->Raw ? HtmlDecode($this->Pembimbing_3->CurrentValue) : $this->Pembimbing_3->CurrentValue;
            $this->Pembimbing_3->PlaceHolder = RemoveHtml($this->Pembimbing_3->caption());

            // Penguji_1
            $this->Penguji_1->setupEditAttributes();
            $this->Penguji_1->EditValue = !$this->Penguji_1->Raw ? HtmlDecode($this->Penguji_1->CurrentValue) : $this->Penguji_1->CurrentValue;
            $this->Penguji_1->PlaceHolder = RemoveHtml($this->Penguji_1->caption());

            // Penguji_2
            $this->Penguji_2->setupEditAttributes();
            $this->Penguji_2->EditValue = !$this->Penguji_2->Raw ? HtmlDecode($this->Penguji_2->CurrentValue) : $this->Penguji_2->CurrentValue;
            $this->Penguji_2->PlaceHolder = RemoveHtml($this->Penguji_2->caption());

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->setupEditAttributes();
            if (!IsEmpty($this->Lembar_Pengesahan->Upload->DbValue)) {
                $this->Lembar_Pengesahan->EditValue = $this->Lembar_Pengesahan->Upload->DbValue;
            } else {
                $this->Lembar_Pengesahan->EditValue = "";
            }
            if (!Config("CREATE_UPLOAD_FILE_ON_COPY")) {
                $this->Lembar_Pengesahan->Upload->DbValue = null;
            }
            if ($this->isShow() || $this->isCopy()) {
                $this->Lembar_Pengesahan->Upload->setupTempDirectory();
            }

            // Judul_Publikasi
            $this->Judul_Publikasi->setupEditAttributes();
            $this->Judul_Publikasi->EditValue = !$this->Judul_Publikasi->Raw ? HtmlDecode($this->Judul_Publikasi->CurrentValue) : $this->Judul_Publikasi->CurrentValue;
            $this->Judul_Publikasi->PlaceHolder = RemoveHtml($this->Judul_Publikasi->caption());

            // Link_Publikasi
            $this->Link_Publikasi->setupEditAttributes();
            $this->Link_Publikasi->EditValue = !$this->Link_Publikasi->Raw ? HtmlDecode($this->Link_Publikasi->CurrentValue) : $this->Link_Publikasi->CurrentValue;
            $this->Link_Publikasi->PlaceHolder = RemoveHtml($this->Link_Publikasi->caption());

            // user_id

            // user

            // ip

            // tanggal

            // Add refer script

            // NIM
            $this->NIM->HrefValue = "";

            // Judul_Penelitian
            $this->Judul_Penelitian->HrefValue = "";

            // Pembimbing_1
            $this->Pembimbing_1->HrefValue = "";

            // Pembimbing_2
            $this->Pembimbing_2->HrefValue = "";

            // Pembimbing_3
            $this->Pembimbing_3->HrefValue = "";

            // Penguji_1
            $this->Penguji_1->HrefValue = "";

            // Penguji_2
            $this->Penguji_2->HrefValue = "";

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->HrefValue = "";
            $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;

            // Judul_Publikasi
            $this->Judul_Publikasi->HrefValue = "";

            // Link_Publikasi
            $this->Link_Publikasi->HrefValue = "";

            // user_id
            $this->user_id->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";

            // tanggal
            $this->tanggal->HrefValue = "";
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
            if ($this->NIM->Visible && $this->NIM->Required) {
                if (!$this->NIM->IsDetailKey && IsEmpty($this->NIM->FormValue)) {
                    $this->NIM->addErrorMessage(str_replace("%s", $this->NIM->caption(), $this->NIM->RequiredErrorMessage));
                }
            }
            if ($this->Judul_Penelitian->Visible && $this->Judul_Penelitian->Required) {
                if (!$this->Judul_Penelitian->IsDetailKey && IsEmpty($this->Judul_Penelitian->FormValue)) {
                    $this->Judul_Penelitian->addErrorMessage(str_replace("%s", $this->Judul_Penelitian->caption(), $this->Judul_Penelitian->RequiredErrorMessage));
                }
            }
            if ($this->Pembimbing_1->Visible && $this->Pembimbing_1->Required) {
                if (!$this->Pembimbing_1->IsDetailKey && IsEmpty($this->Pembimbing_1->FormValue)) {
                    $this->Pembimbing_1->addErrorMessage(str_replace("%s", $this->Pembimbing_1->caption(), $this->Pembimbing_1->RequiredErrorMessage));
                }
            }
            if ($this->Pembimbing_2->Visible && $this->Pembimbing_2->Required) {
                if (!$this->Pembimbing_2->IsDetailKey && IsEmpty($this->Pembimbing_2->FormValue)) {
                    $this->Pembimbing_2->addErrorMessage(str_replace("%s", $this->Pembimbing_2->caption(), $this->Pembimbing_2->RequiredErrorMessage));
                }
            }
            if ($this->Pembimbing_3->Visible && $this->Pembimbing_3->Required) {
                if (!$this->Pembimbing_3->IsDetailKey && IsEmpty($this->Pembimbing_3->FormValue)) {
                    $this->Pembimbing_3->addErrorMessage(str_replace("%s", $this->Pembimbing_3->caption(), $this->Pembimbing_3->RequiredErrorMessage));
                }
            }
            if ($this->Penguji_1->Visible && $this->Penguji_1->Required) {
                if (!$this->Penguji_1->IsDetailKey && IsEmpty($this->Penguji_1->FormValue)) {
                    $this->Penguji_1->addErrorMessage(str_replace("%s", $this->Penguji_1->caption(), $this->Penguji_1->RequiredErrorMessage));
                }
            }
            if ($this->Penguji_2->Visible && $this->Penguji_2->Required) {
                if (!$this->Penguji_2->IsDetailKey && IsEmpty($this->Penguji_2->FormValue)) {
                    $this->Penguji_2->addErrorMessage(str_replace("%s", $this->Penguji_2->caption(), $this->Penguji_2->RequiredErrorMessage));
                }
            }
            if ($this->Lembar_Pengesahan->Visible && $this->Lembar_Pengesahan->Required) {
                if ($this->Lembar_Pengesahan->Upload->FileName == "" && !$this->Lembar_Pengesahan->Upload->KeepFile) {
                    $this->Lembar_Pengesahan->addErrorMessage(str_replace("%s", $this->Lembar_Pengesahan->caption(), $this->Lembar_Pengesahan->RequiredErrorMessage));
                }
            }
            if ($this->Judul_Publikasi->Visible && $this->Judul_Publikasi->Required) {
                if (!$this->Judul_Publikasi->IsDetailKey && IsEmpty($this->Judul_Publikasi->FormValue)) {
                    $this->Judul_Publikasi->addErrorMessage(str_replace("%s", $this->Judul_Publikasi->caption(), $this->Judul_Publikasi->RequiredErrorMessage));
                }
            }
            if ($this->Link_Publikasi->Visible && $this->Link_Publikasi->Required) {
                if (!$this->Link_Publikasi->IsDetailKey && IsEmpty($this->Link_Publikasi->FormValue)) {
                    $this->Link_Publikasi->addErrorMessage(str_replace("%s", $this->Link_Publikasi->caption(), $this->Link_Publikasi->RequiredErrorMessage));
                }
            }
            if ($this->user_id->Visible && $this->user_id->Required) {
                if (!$this->user_id->IsDetailKey && IsEmpty($this->user_id->FormValue)) {
                    $this->user_id->addErrorMessage(str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
                }
            }
            if ($this->user->Visible && $this->user->Required) {
                if (!$this->user->IsDetailKey && IsEmpty($this->user->FormValue)) {
                    $this->user->addErrorMessage(str_replace("%s", $this->user->caption(), $this->user->RequiredErrorMessage));
                }
            }
            if ($this->ip->Visible && $this->ip->Required) {
                if (!$this->ip->IsDetailKey && IsEmpty($this->ip->FormValue)) {
                    $this->ip->addErrorMessage(str_replace("%s", $this->ip->caption(), $this->ip->RequiredErrorMessage));
                }
            }
            if ($this->tanggal->Visible && $this->tanggal->Required) {
                if (!$this->tanggal->IsDetailKey && IsEmpty($this->tanggal->FormValue)) {
                    $this->tanggal->addErrorMessage(str_replace("%s", $this->tanggal->caption(), $this->tanggal->RequiredErrorMessage));
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

    // Add record
    protected function addRow(?array $oldRow = null): bool
    {
        // Get new row
        $newRow = $this->getAddRow();
        if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->Upload->KeepFile) {
            if (!IsEmpty($this->Lembar_Pengesahan->Upload->FileName)) {
                $this->Lembar_Pengesahan->Upload->DbValue = null;
                FixUploadFileNames($this->Lembar_Pengesahan);
                $this->Lembar_Pengesahan->setDbValueDef($newRow, $this->Lembar_Pengesahan->Upload->FileName, false);
            }
        }

        // Update current values
        $this->Fields->setCurrentValues($newRow);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($oldRow);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($oldRow, $newRow);
        if ($insertRow) {
            $addRow = $this->insert($newRow);
            if ($addRow) {
                if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->Upload->KeepFile) {
                    $this->Lembar_Pengesahan->Upload->DbValue = null;
                    if (!SaveUploadFiles($this->Lembar_Pengesahan, $newRow['Lembar_Pengesahan'], false)) {
                        $this->setFailureMessage($this->language->phrase("UploadError7"));
                        return false;
                    }
                }
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

        // NIM
        $this->NIM->setDbValueDef($newRow, $this->NIM->CurrentValue, false);

        // Judul_Penelitian
        $this->Judul_Penelitian->setDbValueDef($newRow, $this->Judul_Penelitian->CurrentValue, false);

        // Pembimbing_1
        $this->Pembimbing_1->setDbValueDef($newRow, $this->Pembimbing_1->CurrentValue, false);

        // Pembimbing_2
        $this->Pembimbing_2->setDbValueDef($newRow, $this->Pembimbing_2->CurrentValue, false);

        // Pembimbing_3
        $this->Pembimbing_3->setDbValueDef($newRow, $this->Pembimbing_3->CurrentValue, false);

        // Penguji_1
        $this->Penguji_1->setDbValueDef($newRow, $this->Penguji_1->CurrentValue, false);

        // Penguji_2
        $this->Penguji_2->setDbValueDef($newRow, $this->Penguji_2->CurrentValue, false);

        // Lembar_Pengesahan
        if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->Upload->KeepFile) {
            if ($this->Lembar_Pengesahan->Upload->FileName == "") {
                $newRow['Lembar_Pengesahan'] = null;
            } else {
                FixUploadTempFileNames($this->Lembar_Pengesahan);
                $newRow['Lembar_Pengesahan'] = $this->Lembar_Pengesahan->Upload->FileName;
            }
        }

        // Judul_Publikasi
        $this->Judul_Publikasi->setDbValueDef($newRow, $this->Judul_Publikasi->CurrentValue, false);

        // Link_Publikasi
        $this->Link_Publikasi->setDbValueDef($newRow, $this->Link_Publikasi->CurrentValue, false);

        // user_id
        $this->user_id->CurrentValue = $this->user_id->getAutoUpdateValue(); // PHP
        $this->user_id->setDbValueDef($newRow, $this->user_id->CurrentValue, false);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($newRow, $this->user->CurrentValue, false);

        // ip
        $this->ip->CurrentValue = $this->ip->getAutoUpdateValue(); // PHP
        $this->ip->setDbValueDef($newRow, $this->ip->CurrentValue, false);

        // tanggal
        $this->tanggal->CurrentValue = $this->tanggal->getAutoUpdateValue(); // PHP
        $this->tanggal->setDbValueDef($newRow, UnFormatDateTime($this->tanggal->CurrentValue, $this->tanggal->formatPattern()), false);
        return $newRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("karyailmiahlist"), "", $this->TableVar, true);
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
