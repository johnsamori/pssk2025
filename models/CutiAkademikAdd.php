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
class CutiAkademikAdd extends CutiAkademik
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "add";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "CutiAkademikAdd";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "cutiakademikadd";

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
        $this->id_ca->Visible = false;
        $this->NIM->setVisibility();
        $this->Pengajuan_Surat_Cuti_Akademik->setVisibility();
        $this->Persetujuan_Cuti_Akademik->setVisibility();
        $this->Surat_Keterangan_Aktif_Kembali->setVisibility();
        $this->Tanggal->setVisibility();
        $this->id_user->setVisibility();
        $this->user->setVisibility();
        $this->ip->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'cuti_akademik';
        $this->TableName = 'cuti_akademik';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Save if user language changed
        if (Param("language") !== null) {
            Profile()->setLanguageId(Param("language"))->saveToStorage();
        }

        // Table object (cuti_akademik)
        if (!isset($GLOBALS["cuti_akademik"]) || $GLOBALS["cuti_akademik"]::class == PROJECT_NAMESPACE . "cuti_akademik") {
            $GLOBALS["cuti_akademik"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'cuti_akademik');
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
                        $result["view"] = SameString($pageName, "cutiakademikview"); // If View page, no primary button
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
            $key .= @$ar['id_ca'];
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
            $this->id_ca->Visible = false;
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
            if (($keyValue = Get("id_ca") ?? Route("id_ca")) !== null) {
                $this->id_ca->setQueryStringValue($keyValue);
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
                    $this->terminate("cutiakademiklist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "cutiakademiklist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "cutiakademikview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "cutiakademiklist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "cutiakademiklist"; // Return list page content
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

        // Check field name 'Pengajuan_Surat_Cuti_Akademik' before field var 'x_Pengajuan_Surat_Cuti_Akademik'
        $val = $this->getFormValue("Pengajuan_Surat_Cuti_Akademik", null) ?? $this->getFormValue("x_Pengajuan_Surat_Cuti_Akademik", null);
        if (!$this->Pengajuan_Surat_Cuti_Akademik->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pengajuan_Surat_Cuti_Akademik->Visible = false; // Disable update for API request
            } else {
                $this->Pengajuan_Surat_Cuti_Akademik->setFormValue($val);
            }
        }

        // Check field name 'Persetujuan_Cuti_Akademik' before field var 'x_Persetujuan_Cuti_Akademik'
        $val = $this->getFormValue("Persetujuan_Cuti_Akademik", null) ?? $this->getFormValue("x_Persetujuan_Cuti_Akademik", null);
        if (!$this->Persetujuan_Cuti_Akademik->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Persetujuan_Cuti_Akademik->Visible = false; // Disable update for API request
            } else {
                $this->Persetujuan_Cuti_Akademik->setFormValue($val);
            }
        }

        // Check field name 'Surat_Keterangan_Aktif_Kembali' before field var 'x_Surat_Keterangan_Aktif_Kembali'
        $val = $this->getFormValue("Surat_Keterangan_Aktif_Kembali", null) ?? $this->getFormValue("x_Surat_Keterangan_Aktif_Kembali", null);
        if (!$this->Surat_Keterangan_Aktif_Kembali->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Surat_Keterangan_Aktif_Kembali->Visible = false; // Disable update for API request
            } else {
                $this->Surat_Keterangan_Aktif_Kembali->setFormValue($val);
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

        // Check field name 'id_user' before field var 'x_id_user'
        $val = $this->getFormValue("id_user", null) ?? $this->getFormValue("x_id_user", null);
        if (!$this->id_user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_user->Visible = false; // Disable update for API request
            } else {
                $this->id_user->setFormValue($val);
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

        // Check field name 'id_ca' first before field var 'x_id_ca'
        $val = $this->hasFormValue("id_ca") ? $this->getFormValue("id_ca") : $this->getFormValue("x_id_ca");
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->NIM->CurrentValue = $this->NIM->FormValue;
        $this->Pengajuan_Surat_Cuti_Akademik->CurrentValue = $this->Pengajuan_Surat_Cuti_Akademik->FormValue;
        $this->Persetujuan_Cuti_Akademik->CurrentValue = $this->Persetujuan_Cuti_Akademik->FormValue;
        $this->Surat_Keterangan_Aktif_Kembali->CurrentValue = $this->Surat_Keterangan_Aktif_Kembali->FormValue;
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnformatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->id_user->CurrentValue = $this->id_user->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->ip->CurrentValue = $this->ip->FormValue;
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
        $this->id_ca->setDbValue($row['id_ca']);
        $this->NIM->setDbValue($row['NIM']);
        $this->Pengajuan_Surat_Cuti_Akademik->setDbValue($row['Pengajuan_Surat_Cuti_Akademik']);
        $this->Persetujuan_Cuti_Akademik->setDbValue($row['Persetujuan_Cuti_Akademik']);
        $this->Surat_Keterangan_Aktif_Kembali->setDbValue($row['Surat_Keterangan_Aktif_Kembali']);
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->id_user->setDbValue($row['id_user']);
        $this->user->setDbValue($row['user']);
        $this->ip->setDbValue($row['ip']);
    }

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['id_ca'] = $this->id_ca->DefaultValue;
        $row['NIM'] = $this->NIM->DefaultValue;
        $row['Pengajuan_Surat_Cuti_Akademik'] = $this->Pengajuan_Surat_Cuti_Akademik->DefaultValue;
        $row['Persetujuan_Cuti_Akademik'] = $this->Persetujuan_Cuti_Akademik->DefaultValue;
        $row['Surat_Keterangan_Aktif_Kembali'] = $this->Surat_Keterangan_Aktif_Kembali->DefaultValue;
        $row['Tanggal'] = $this->Tanggal->DefaultValue;
        $row['id_user'] = $this->id_user->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['ip'] = $this->ip->DefaultValue;
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

        // id_ca
        $this->id_ca->RowCssClass = "row";

        // NIM
        $this->NIM->RowCssClass = "row";

        // Pengajuan_Surat_Cuti_Akademik
        $this->Pengajuan_Surat_Cuti_Akademik->RowCssClass = "row";

        // Persetujuan_Cuti_Akademik
        $this->Persetujuan_Cuti_Akademik->RowCssClass = "row";

        // Surat_Keterangan_Aktif_Kembali
        $this->Surat_Keterangan_Aktif_Kembali->RowCssClass = "row";

        // Tanggal
        $this->Tanggal->RowCssClass = "row";

        // id_user
        $this->id_user->RowCssClass = "row";

        // user
        $this->user->RowCssClass = "row";

        // ip
        $this->ip->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // id_ca
            $this->id_ca->ViewValue = $this->id_ca->CurrentValue;

            // NIM
            $this->NIM->ViewValue = $this->NIM->CurrentValue;

            // Pengajuan_Surat_Cuti_Akademik
            $this->Pengajuan_Surat_Cuti_Akademik->ViewValue = $this->Pengajuan_Surat_Cuti_Akademik->CurrentValue;

            // Persetujuan_Cuti_Akademik
            $this->Persetujuan_Cuti_Akademik->ViewValue = $this->Persetujuan_Cuti_Akademik->CurrentValue;

            // Surat_Keterangan_Aktif_Kembali
            $this->Surat_Keterangan_Aktif_Kembali->ViewValue = $this->Surat_Keterangan_Aktif_Kembali->CurrentValue;

            // Tanggal
            $this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
            $this->Tanggal->ViewValue = FormatDateTime($this->Tanggal->ViewValue, $this->Tanggal->formatPattern());

            // id_user
            $this->id_user->ViewValue = $this->id_user->CurrentValue;

            // user
            $this->user->ViewValue = $this->user->CurrentValue;

            // ip
            $this->ip->ViewValue = $this->ip->CurrentValue;

            // NIM
            $this->NIM->HrefValue = "";

            // Pengajuan_Surat_Cuti_Akademik
            $this->Pengajuan_Surat_Cuti_Akademik->HrefValue = "";

            // Persetujuan_Cuti_Akademik
            $this->Persetujuan_Cuti_Akademik->HrefValue = "";

            // Surat_Keterangan_Aktif_Kembali
            $this->Surat_Keterangan_Aktif_Kembali->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // id_user
            $this->id_user->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // NIM
            $this->NIM->setupEditAttributes();
            $this->NIM->EditValue = !$this->NIM->Raw ? HtmlDecode($this->NIM->CurrentValue) : $this->NIM->CurrentValue;
            $this->NIM->PlaceHolder = RemoveHtml($this->NIM->caption());

            // Pengajuan_Surat_Cuti_Akademik
            $this->Pengajuan_Surat_Cuti_Akademik->setupEditAttributes();
            $this->Pengajuan_Surat_Cuti_Akademik->EditValue = !$this->Pengajuan_Surat_Cuti_Akademik->Raw ? HtmlDecode($this->Pengajuan_Surat_Cuti_Akademik->CurrentValue) : $this->Pengajuan_Surat_Cuti_Akademik->CurrentValue;
            $this->Pengajuan_Surat_Cuti_Akademik->PlaceHolder = RemoveHtml($this->Pengajuan_Surat_Cuti_Akademik->caption());

            // Persetujuan_Cuti_Akademik
            $this->Persetujuan_Cuti_Akademik->setupEditAttributes();
            $this->Persetujuan_Cuti_Akademik->EditValue = !$this->Persetujuan_Cuti_Akademik->Raw ? HtmlDecode($this->Persetujuan_Cuti_Akademik->CurrentValue) : $this->Persetujuan_Cuti_Akademik->CurrentValue;
            $this->Persetujuan_Cuti_Akademik->PlaceHolder = RemoveHtml($this->Persetujuan_Cuti_Akademik->caption());

            // Surat_Keterangan_Aktif_Kembali
            $this->Surat_Keterangan_Aktif_Kembali->setupEditAttributes();
            $this->Surat_Keterangan_Aktif_Kembali->EditValue = !$this->Surat_Keterangan_Aktif_Kembali->Raw ? HtmlDecode($this->Surat_Keterangan_Aktif_Kembali->CurrentValue) : $this->Surat_Keterangan_Aktif_Kembali->CurrentValue;
            $this->Surat_Keterangan_Aktif_Kembali->PlaceHolder = RemoveHtml($this->Surat_Keterangan_Aktif_Kembali->caption());

            // Tanggal

            // id_user

            // user

            // ip

            // Add refer script

            // NIM
            $this->NIM->HrefValue = "";

            // Pengajuan_Surat_Cuti_Akademik
            $this->Pengajuan_Surat_Cuti_Akademik->HrefValue = "";

            // Persetujuan_Cuti_Akademik
            $this->Persetujuan_Cuti_Akademik->HrefValue = "";

            // Surat_Keterangan_Aktif_Kembali
            $this->Surat_Keterangan_Aktif_Kembali->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // id_user
            $this->id_user->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";
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
            if ($this->Pengajuan_Surat_Cuti_Akademik->Visible && $this->Pengajuan_Surat_Cuti_Akademik->Required) {
                if (!$this->Pengajuan_Surat_Cuti_Akademik->IsDetailKey && IsEmpty($this->Pengajuan_Surat_Cuti_Akademik->FormValue)) {
                    $this->Pengajuan_Surat_Cuti_Akademik->addErrorMessage(str_replace("%s", $this->Pengajuan_Surat_Cuti_Akademik->caption(), $this->Pengajuan_Surat_Cuti_Akademik->RequiredErrorMessage));
                }
            }
            if ($this->Persetujuan_Cuti_Akademik->Visible && $this->Persetujuan_Cuti_Akademik->Required) {
                if (!$this->Persetujuan_Cuti_Akademik->IsDetailKey && IsEmpty($this->Persetujuan_Cuti_Akademik->FormValue)) {
                    $this->Persetujuan_Cuti_Akademik->addErrorMessage(str_replace("%s", $this->Persetujuan_Cuti_Akademik->caption(), $this->Persetujuan_Cuti_Akademik->RequiredErrorMessage));
                }
            }
            if ($this->Surat_Keterangan_Aktif_Kembali->Visible && $this->Surat_Keterangan_Aktif_Kembali->Required) {
                if (!$this->Surat_Keterangan_Aktif_Kembali->IsDetailKey && IsEmpty($this->Surat_Keterangan_Aktif_Kembali->FormValue)) {
                    $this->Surat_Keterangan_Aktif_Kembali->addErrorMessage(str_replace("%s", $this->Surat_Keterangan_Aktif_Kembali->caption(), $this->Surat_Keterangan_Aktif_Kembali->RequiredErrorMessage));
                }
            }
            if ($this->Tanggal->Visible && $this->Tanggal->Required) {
                if (!$this->Tanggal->IsDetailKey && IsEmpty($this->Tanggal->FormValue)) {
                    $this->Tanggal->addErrorMessage(str_replace("%s", $this->Tanggal->caption(), $this->Tanggal->RequiredErrorMessage));
                }
            }
            if ($this->id_user->Visible && $this->id_user->Required) {
                if (!$this->id_user->IsDetailKey && IsEmpty($this->id_user->FormValue)) {
                    $this->id_user->addErrorMessage(str_replace("%s", $this->id_user->caption(), $this->id_user->RequiredErrorMessage));
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

        // Load db values from old row
        $this->loadDbValues($oldRow);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($oldRow, $newRow);
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

        // Pengajuan_Surat_Cuti_Akademik
        $this->Pengajuan_Surat_Cuti_Akademik->setDbValueDef($newRow, $this->Pengajuan_Surat_Cuti_Akademik->CurrentValue, false);

        // Persetujuan_Cuti_Akademik
        $this->Persetujuan_Cuti_Akademik->setDbValueDef($newRow, $this->Persetujuan_Cuti_Akademik->CurrentValue, false);

        // Surat_Keterangan_Aktif_Kembali
        $this->Surat_Keterangan_Aktif_Kembali->setDbValueDef($newRow, $this->Surat_Keterangan_Aktif_Kembali->CurrentValue, false);

        // Tanggal
        $this->Tanggal->CurrentValue = $this->Tanggal->getAutoUpdateValue(); // PHP
        $this->Tanggal->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern()), false);

        // id_user
        $this->id_user->CurrentValue = $this->id_user->getAutoUpdateValue(); // PHP
        $this->id_user->setDbValueDef($newRow, $this->id_user->CurrentValue, false);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($newRow, $this->user->CurrentValue, false);

        // ip
        $this->ip->CurrentValue = $this->ip->getAutoUpdateValue(); // PHP
        $this->ip->setDbValueDef($newRow, $this->ip->CurrentValue, false);
        return $newRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("cutiakademiklist"), "", $this->TableVar, true);
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
