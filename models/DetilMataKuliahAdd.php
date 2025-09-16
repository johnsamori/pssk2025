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
class DetilMataKuliahAdd extends DetilMataKuliah
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "add";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "DetilMataKuliahAdd";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "detilmatakuliahadd";

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
        $this->id_no->Visible = false;
        $this->Kode_MK->setVisibility();
        $this->NIM->setVisibility();
        $this->Nilai_Diskusi->setVisibility();
        $this->Assessment_Skor_As_1->setVisibility();
        $this->Assessment_Skor_As_2->setVisibility();
        $this->Assessment_Skor_As_3->setVisibility();
        $this->Nilai_Tugas->setVisibility();
        $this->Nilai_UTS->setVisibility();
        $this->Nilai_Akhir->setVisibility();
        $this->iduser->setVisibility();
        $this->user->setVisibility();
        $this->ip->setVisibility();
        $this->tanggal->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'detil_mata_kuliah';
        $this->TableName = 'detil_mata_kuliah';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

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

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'detil_mata_kuliah');
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
                        $result["view"] = SameString($pageName, "detilmatakuliahview"); // If View page, no primary button
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
            if (($keyValue = Get("id_no") ?? Route("id_no")) !== null) {
                $this->id_no->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: Must be after loadOldRecord to prevent master key values being overwritten
        $this->setupMasterParms();

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
                    $this->terminate("detilmatakuliahlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "detilmatakuliahlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "detilmatakuliahview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "detilmatakuliahlist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "detilmatakuliahlist"; // Return list page content
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

        // Check field name 'Kode_MK' before field var 'x_Kode_MK'
        $val = $this->getFormValue("Kode_MK", null) ?? $this->getFormValue("x_Kode_MK", null);
        if (!$this->Kode_MK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kode_MK->Visible = false; // Disable update for API request
            } else {
                $this->Kode_MK->setFormValue($val);
            }
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

        // Check field name 'Nilai_Diskusi' before field var 'x_Nilai_Diskusi'
        $val = $this->getFormValue("Nilai_Diskusi", null) ?? $this->getFormValue("x_Nilai_Diskusi", null);
        if (!$this->Nilai_Diskusi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Diskusi->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Diskusi->setFormValue($val);
            }
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

        // Check field name 'Assessment_Skor_As_2' before field var 'x_Assessment_Skor_As_2'
        $val = $this->getFormValue("Assessment_Skor_As_2", null) ?? $this->getFormValue("x_Assessment_Skor_As_2", null);
        if (!$this->Assessment_Skor_As_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Assessment_Skor_As_2->Visible = false; // Disable update for API request
            } else {
                $this->Assessment_Skor_As_2->setFormValue($val);
            }
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

        // Check field name 'Nilai_Tugas' before field var 'x_Nilai_Tugas'
        $val = $this->getFormValue("Nilai_Tugas", null) ?? $this->getFormValue("x_Nilai_Tugas", null);
        if (!$this->Nilai_Tugas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Tugas->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Tugas->setFormValue($val);
            }
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

        // Check field name 'Nilai_Akhir' before field var 'x_Nilai_Akhir'
        $val = $this->getFormValue("Nilai_Akhir", null) ?? $this->getFormValue("x_Nilai_Akhir", null);
        if (!$this->Nilai_Akhir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Akhir->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Akhir->setFormValue($val);
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

        // Check field name 'id_no' first before field var 'x_id_no'
        $val = $this->hasFormValue("id_no") ? $this->getFormValue("id_no") : $this->getFormValue("x_id_no");
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->Kode_MK->CurrentValue = $this->Kode_MK->FormValue;
        $this->NIM->CurrentValue = $this->NIM->FormValue;
        $this->Nilai_Diskusi->CurrentValue = $this->Nilai_Diskusi->FormValue;
        $this->Assessment_Skor_As_1->CurrentValue = $this->Assessment_Skor_As_1->FormValue;
        $this->Assessment_Skor_As_2->CurrentValue = $this->Assessment_Skor_As_2->FormValue;
        $this->Assessment_Skor_As_3->CurrentValue = $this->Assessment_Skor_As_3->FormValue;
        $this->Nilai_Tugas->CurrentValue = $this->Nilai_Tugas->FormValue;
        $this->Nilai_UTS->CurrentValue = $this->Nilai_UTS->FormValue;
        $this->Nilai_Akhir->CurrentValue = $this->Nilai_Akhir->FormValue;
        $this->iduser->CurrentValue = $this->iduser->FormValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_no
        $this->id_no->RowCssClass = "row";

        // Kode_MK
        $this->Kode_MK->RowCssClass = "row";

        // NIM
        $this->NIM->RowCssClass = "row";

        // Nilai_Diskusi
        $this->Nilai_Diskusi->RowCssClass = "row";

        // Assessment_Skor_As_1
        $this->Assessment_Skor_As_1->RowCssClass = "row";

        // Assessment_Skor_As_2
        $this->Assessment_Skor_As_2->RowCssClass = "row";

        // Assessment_Skor_As_3
        $this->Assessment_Skor_As_3->RowCssClass = "row";

        // Nilai_Tugas
        $this->Nilai_Tugas->RowCssClass = "row";

        // Nilai_UTS
        $this->Nilai_UTS->RowCssClass = "row";

        // Nilai_Akhir
        $this->Nilai_Akhir->RowCssClass = "row";

        // iduser
        $this->iduser->RowCssClass = "row";

        // user
        $this->user->RowCssClass = "row";

        // ip
        $this->ip->RowCssClass = "row";

        // tanggal
        $this->tanggal->RowCssClass = "row";

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

            // iduser
            $this->iduser->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";

            // tanggal
            $this->tanggal->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // Kode_MK
            $this->Kode_MK->setupEditAttributes();
            if ($this->Kode_MK->getSessionValue() != "") {
                $this->Kode_MK->CurrentValue = GetForeignKeyValue($this->Kode_MK->getSessionValue());
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

            // iduser

            // user

            // ip

            // tanggal

            // Add refer script

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

            // iduser
            $this->iduser->HrefValue = "";

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
            if ($this->iduser->Visible && $this->iduser->Required) {
                if (!$this->iduser->IsDetailKey && IsEmpty($this->iduser->FormValue)) {
                    $this->iduser->addErrorMessage(str_replace("%s", $this->iduser->caption(), $this->iduser->RequiredErrorMessage));
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

        // iduser
        $this->iduser->CurrentValue = $this->iduser->getAutoUpdateValue(); // PHP
        $this->iduser->setDbValueDef($newRow, $this->iduser->CurrentValue, false);

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
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("detilmatakuliahlist"), "", $this->TableVar, true);
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
