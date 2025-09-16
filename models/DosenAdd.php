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
class DosenAdd extends Dosen
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "add";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "DosenAdd";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "dosenadd";

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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

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

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'dosen');
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
                        $result["view"] = SameString($pageName, "dosenview"); // If View page, no primary button
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
            if (($keyValue = Get("No") ?? Route("No")) !== null) {
                $this->No->setQueryStringValue($keyValue);
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
                    $this->terminate("dosenlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "dosenlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "dosenview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "dosenlist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "dosenlist"; // Return list page content
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

        // Check field name 'No' before field var 'x_No'
        $val = $this->getFormValue("No", null) ?? $this->getFormValue("x_No", null);
        if (!$this->No->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->No->Visible = false; // Disable update for API request
            } else {
                $this->No->setFormValue($val);
            }
        }

        // Check field name 'NIP' before field var 'x_NIP'
        $val = $this->getFormValue("NIP", null) ?? $this->getFormValue("x_NIP", null);
        if (!$this->NIP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIP->Visible = false; // Disable update for API request
            } else {
                $this->NIP->setFormValue($val);
            }
        }

        // Check field name 'NIDN' before field var 'x_NIDN'
        $val = $this->getFormValue("NIDN", null) ?? $this->getFormValue("x_NIDN", null);
        if (!$this->NIDN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIDN->Visible = false; // Disable update for API request
            } else {
                $this->NIDN->setFormValue($val);
            }
        }

        // Check field name 'Nama_Lengkap' before field var 'x_Nama_Lengkap'
        $val = $this->getFormValue("Nama_Lengkap", null) ?? $this->getFormValue("x_Nama_Lengkap", null);
        if (!$this->Nama_Lengkap->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Lengkap->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Lengkap->setFormValue($val);
            }
        }

        // Check field name 'Gelar_Depan' before field var 'x_Gelar_Depan'
        $val = $this->getFormValue("Gelar_Depan", null) ?? $this->getFormValue("x_Gelar_Depan", null);
        if (!$this->Gelar_Depan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Gelar_Depan->Visible = false; // Disable update for API request
            } else {
                $this->Gelar_Depan->setFormValue($val);
            }
        }

        // Check field name 'Gelar_Belakang' before field var 'x_Gelar_Belakang'
        $val = $this->getFormValue("Gelar_Belakang", null) ?? $this->getFormValue("x_Gelar_Belakang", null);
        if (!$this->Gelar_Belakang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Gelar_Belakang->Visible = false; // Disable update for API request
            } else {
                $this->Gelar_Belakang->setFormValue($val);
            }
        }

        // Check field name 'Program_studi' before field var 'x_Program_studi'
        $val = $this->getFormValue("Program_studi", null) ?? $this->getFormValue("x_Program_studi", null);
        if (!$this->Program_studi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Program_studi->Visible = false; // Disable update for API request
            } else {
                $this->Program_studi->setFormValue($val);
            }
        }

        // Check field name 'NIK' before field var 'x_NIK'
        $val = $this->getFormValue("NIK", null) ?? $this->getFormValue("x_NIK", null);
        if (!$this->NIK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIK->Visible = false; // Disable update for API request
            } else {
                $this->NIK->setFormValue($val);
            }
        }

        // Check field name 'Tanggal_lahir' before field var 'x_Tanggal_lahir'
        $val = $this->getFormValue("Tanggal_lahir", null) ?? $this->getFormValue("x_Tanggal_lahir", null);
        if (!$this->Tanggal_lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tanggal_lahir->Visible = false; // Disable update for API request
            } else {
                $this->Tanggal_lahir->setFormValue($val, true, $validate);
            }
            $this->Tanggal_lahir->CurrentValue = UnformatDateTime($this->Tanggal_lahir->CurrentValue, $this->Tanggal_lahir->formatPattern());
        }

        // Check field name 'Tempat_lahir' before field var 'x_Tempat_lahir'
        $val = $this->getFormValue("Tempat_lahir", null) ?? $this->getFormValue("x_Tempat_lahir", null);
        if (!$this->Tempat_lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tempat_lahir->Visible = false; // Disable update for API request
            } else {
                $this->Tempat_lahir->setFormValue($val);
            }
        }

        // Check field name 'Nomor_Karpeg' before field var 'x_Nomor_Karpeg'
        $val = $this->getFormValue("Nomor_Karpeg", null) ?? $this->getFormValue("x_Nomor_Karpeg", null);
        if (!$this->Nomor_Karpeg->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nomor_Karpeg->Visible = false; // Disable update for API request
            } else {
                $this->Nomor_Karpeg->setFormValue($val);
            }
        }

        // Check field name 'Nomor_Stambuk' before field var 'x_Nomor_Stambuk'
        $val = $this->getFormValue("Nomor_Stambuk", null) ?? $this->getFormValue("x_Nomor_Stambuk", null);
        if (!$this->Nomor_Stambuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nomor_Stambuk->Visible = false; // Disable update for API request
            } else {
                $this->Nomor_Stambuk->setFormValue($val);
            }
        }

        // Check field name 'Jenis_kelamin' before field var 'x_Jenis_kelamin'
        $val = $this->getFormValue("Jenis_kelamin", null) ?? $this->getFormValue("x_Jenis_kelamin", null);
        if (!$this->Jenis_kelamin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jenis_kelamin->Visible = false; // Disable update for API request
            } else {
                $this->Jenis_kelamin->setFormValue($val);
            }
        }

        // Check field name 'Gol_Darah' before field var 'x_Gol_Darah'
        $val = $this->getFormValue("Gol_Darah", null) ?? $this->getFormValue("x_Gol_Darah", null);
        if (!$this->Gol_Darah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Gol_Darah->Visible = false; // Disable update for API request
            } else {
                $this->Gol_Darah->setFormValue($val);
            }
        }

        // Check field name 'Agama' before field var 'x_Agama'
        $val = $this->getFormValue("Agama", null) ?? $this->getFormValue("x_Agama", null);
        if (!$this->Agama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Agama->Visible = false; // Disable update for API request
            } else {
                $this->Agama->setFormValue($val);
            }
        }

        // Check field name 'Stattus_menikah' before field var 'x_Stattus_menikah'
        $val = $this->getFormValue("Stattus_menikah", null) ?? $this->getFormValue("x_Stattus_menikah", null);
        if (!$this->Stattus_menikah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Stattus_menikah->Visible = false; // Disable update for API request
            } else {
                $this->Stattus_menikah->setFormValue($val);
            }
        }

        // Check field name 'Alamat' before field var 'x_Alamat'
        $val = $this->getFormValue("Alamat", null) ?? $this->getFormValue("x_Alamat", null);
        if (!$this->Alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Alamat->Visible = false; // Disable update for API request
            } else {
                $this->Alamat->setFormValue($val);
            }
        }

        // Check field name 'Kota' before field var 'x_Kota'
        $val = $this->getFormValue("Kota", null) ?? $this->getFormValue("x_Kota", null);
        if (!$this->Kota->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kota->Visible = false; // Disable update for API request
            } else {
                $this->Kota->setFormValue($val);
            }
        }

        // Check field name 'Telepon_seluler' before field var 'x_Telepon_seluler'
        $val = $this->getFormValue("Telepon_seluler", null) ?? $this->getFormValue("x_Telepon_seluler", null);
        if (!$this->Telepon_seluler->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Telepon_seluler->Visible = false; // Disable update for API request
            } else {
                $this->Telepon_seluler->setFormValue($val);
            }
        }

        // Check field name 'Jenis_pegawai' before field var 'x_Jenis_pegawai'
        $val = $this->getFormValue("Jenis_pegawai", null) ?? $this->getFormValue("x_Jenis_pegawai", null);
        if (!$this->Jenis_pegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jenis_pegawai->Visible = false; // Disable update for API request
            } else {
                $this->Jenis_pegawai->setFormValue($val);
            }
        }

        // Check field name 'Status_pegawai' before field var 'x_Status_pegawai'
        $val = $this->getFormValue("Status_pegawai", null) ?? $this->getFormValue("x_Status_pegawai", null);
        if (!$this->Status_pegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status_pegawai->Visible = false; // Disable update for API request
            } else {
                $this->Status_pegawai->setFormValue($val);
            }
        }

        // Check field name 'Golongan' before field var 'x_Golongan'
        $val = $this->getFormValue("Golongan", null) ?? $this->getFormValue("x_Golongan", null);
        if (!$this->Golongan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Golongan->Visible = false; // Disable update for API request
            } else {
                $this->Golongan->setFormValue($val);
            }
        }

        // Check field name 'Pangkat' before field var 'x_Pangkat'
        $val = $this->getFormValue("Pangkat", null) ?? $this->getFormValue("x_Pangkat", null);
        if (!$this->Pangkat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pangkat->Visible = false; // Disable update for API request
            } else {
                $this->Pangkat->setFormValue($val);
            }
        }

        // Check field name 'Status_dosen' before field var 'x_Status_dosen'
        $val = $this->getFormValue("Status_dosen", null) ?? $this->getFormValue("x_Status_dosen", null);
        if (!$this->Status_dosen->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status_dosen->Visible = false; // Disable update for API request
            } else {
                $this->Status_dosen->setFormValue($val);
            }
        }

        // Check field name 'Status_Belajar' before field var 'x_Status_Belajar'
        $val = $this->getFormValue("Status_Belajar", null) ?? $this->getFormValue("x_Status_Belajar", null);
        if (!$this->Status_Belajar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status_Belajar->Visible = false; // Disable update for API request
            } else {
                $this->Status_Belajar->setFormValue($val);
            }
        }

        // Check field name 'e_mail' before field var 'x_e_mail'
        $val = $this->getFormValue("e_mail", null) ?? $this->getFormValue("x_e_mail", null);
        if (!$this->e_mail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->e_mail->Visible = false; // Disable update for API request
            } else {
                $this->e_mail->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->No->CurrentValue = $this->No->FormValue;
        $this->NIP->CurrentValue = $this->NIP->FormValue;
        $this->NIDN->CurrentValue = $this->NIDN->FormValue;
        $this->Nama_Lengkap->CurrentValue = $this->Nama_Lengkap->FormValue;
        $this->Gelar_Depan->CurrentValue = $this->Gelar_Depan->FormValue;
        $this->Gelar_Belakang->CurrentValue = $this->Gelar_Belakang->FormValue;
        $this->Program_studi->CurrentValue = $this->Program_studi->FormValue;
        $this->NIK->CurrentValue = $this->NIK->FormValue;
        $this->Tanggal_lahir->CurrentValue = $this->Tanggal_lahir->FormValue;
        $this->Tanggal_lahir->CurrentValue = UnformatDateTime($this->Tanggal_lahir->CurrentValue, $this->Tanggal_lahir->formatPattern());
        $this->Tempat_lahir->CurrentValue = $this->Tempat_lahir->FormValue;
        $this->Nomor_Karpeg->CurrentValue = $this->Nomor_Karpeg->FormValue;
        $this->Nomor_Stambuk->CurrentValue = $this->Nomor_Stambuk->FormValue;
        $this->Jenis_kelamin->CurrentValue = $this->Jenis_kelamin->FormValue;
        $this->Gol_Darah->CurrentValue = $this->Gol_Darah->FormValue;
        $this->Agama->CurrentValue = $this->Agama->FormValue;
        $this->Stattus_menikah->CurrentValue = $this->Stattus_menikah->FormValue;
        $this->Alamat->CurrentValue = $this->Alamat->FormValue;
        $this->Kota->CurrentValue = $this->Kota->FormValue;
        $this->Telepon_seluler->CurrentValue = $this->Telepon_seluler->FormValue;
        $this->Jenis_pegawai->CurrentValue = $this->Jenis_pegawai->FormValue;
        $this->Status_pegawai->CurrentValue = $this->Status_pegawai->FormValue;
        $this->Golongan->CurrentValue = $this->Golongan->FormValue;
        $this->Pangkat->CurrentValue = $this->Pangkat->FormValue;
        $this->Status_dosen->CurrentValue = $this->Status_dosen->FormValue;
        $this->Status_Belajar->CurrentValue = $this->Status_Belajar->FormValue;
        $this->e_mail->CurrentValue = $this->e_mail->FormValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // No
        $this->No->RowCssClass = "row";

        // NIP
        $this->NIP->RowCssClass = "row";

        // NIDN
        $this->NIDN->RowCssClass = "row";

        // Nama_Lengkap
        $this->Nama_Lengkap->RowCssClass = "row";

        // Gelar_Depan
        $this->Gelar_Depan->RowCssClass = "row";

        // Gelar_Belakang
        $this->Gelar_Belakang->RowCssClass = "row";

        // Program_studi
        $this->Program_studi->RowCssClass = "row";

        // NIK
        $this->NIK->RowCssClass = "row";

        // Tanggal_lahir
        $this->Tanggal_lahir->RowCssClass = "row";

        // Tempat_lahir
        $this->Tempat_lahir->RowCssClass = "row";

        // Nomor_Karpeg
        $this->Nomor_Karpeg->RowCssClass = "row";

        // Nomor_Stambuk
        $this->Nomor_Stambuk->RowCssClass = "row";

        // Jenis_kelamin
        $this->Jenis_kelamin->RowCssClass = "row";

        // Gol_Darah
        $this->Gol_Darah->RowCssClass = "row";

        // Agama
        $this->Agama->RowCssClass = "row";

        // Stattus_menikah
        $this->Stattus_menikah->RowCssClass = "row";

        // Alamat
        $this->Alamat->RowCssClass = "row";

        // Kota
        $this->Kota->RowCssClass = "row";

        // Telepon_seluler
        $this->Telepon_seluler->RowCssClass = "row";

        // Jenis_pegawai
        $this->Jenis_pegawai->RowCssClass = "row";

        // Status_pegawai
        $this->Status_pegawai->RowCssClass = "row";

        // Golongan
        $this->Golongan->RowCssClass = "row";

        // Pangkat
        $this->Pangkat->RowCssClass = "row";

        // Status_dosen
        $this->Status_dosen->RowCssClass = "row";

        // Status_Belajar
        $this->Status_Belajar->RowCssClass = "row";

        // e_mail
        $this->e_mail->RowCssClass = "row";

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

            // NIP
            $this->NIP->HrefValue = "";

            // NIDN
            $this->NIDN->HrefValue = "";

            // Nama_Lengkap
            $this->Nama_Lengkap->HrefValue = "";

            // Gelar_Depan
            $this->Gelar_Depan->HrefValue = "";

            // Gelar_Belakang
            $this->Gelar_Belakang->HrefValue = "";

            // Program_studi
            $this->Program_studi->HrefValue = "";

            // NIK
            $this->NIK->HrefValue = "";

            // Tanggal_lahir
            $this->Tanggal_lahir->HrefValue = "";

            // Tempat_lahir
            $this->Tempat_lahir->HrefValue = "";

            // Nomor_Karpeg
            $this->Nomor_Karpeg->HrefValue = "";

            // Nomor_Stambuk
            $this->Nomor_Stambuk->HrefValue = "";

            // Jenis_kelamin
            $this->Jenis_kelamin->HrefValue = "";

            // Gol_Darah
            $this->Gol_Darah->HrefValue = "";

            // Agama
            $this->Agama->HrefValue = "";

            // Stattus_menikah
            $this->Stattus_menikah->HrefValue = "";

            // Alamat
            $this->Alamat->HrefValue = "";

            // Kota
            $this->Kota->HrefValue = "";

            // Telepon_seluler
            $this->Telepon_seluler->HrefValue = "";

            // Jenis_pegawai
            $this->Jenis_pegawai->HrefValue = "";

            // Status_pegawai
            $this->Status_pegawai->HrefValue = "";

            // Golongan
            $this->Golongan->HrefValue = "";

            // Pangkat
            $this->Pangkat->HrefValue = "";

            // Status_dosen
            $this->Status_dosen->HrefValue = "";

            // Status_Belajar
            $this->Status_Belajar->HrefValue = "";

            // e_mail
            $this->e_mail->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // No
            $this->No->setupEditAttributes();
            $this->No->EditValue = !$this->No->Raw ? HtmlDecode($this->No->CurrentValue) : $this->No->CurrentValue;
            $this->No->PlaceHolder = RemoveHtml($this->No->caption());

            // NIP
            $this->NIP->setupEditAttributes();
            $this->NIP->EditValue = !$this->NIP->Raw ? HtmlDecode($this->NIP->CurrentValue) : $this->NIP->CurrentValue;
            $this->NIP->PlaceHolder = RemoveHtml($this->NIP->caption());

            // NIDN
            $this->NIDN->setupEditAttributes();
            $this->NIDN->EditValue = !$this->NIDN->Raw ? HtmlDecode($this->NIDN->CurrentValue) : $this->NIDN->CurrentValue;
            $this->NIDN->PlaceHolder = RemoveHtml($this->NIDN->caption());

            // Nama_Lengkap
            $this->Nama_Lengkap->setupEditAttributes();
            $this->Nama_Lengkap->EditValue = !$this->Nama_Lengkap->Raw ? HtmlDecode($this->Nama_Lengkap->CurrentValue) : $this->Nama_Lengkap->CurrentValue;
            $this->Nama_Lengkap->PlaceHolder = RemoveHtml($this->Nama_Lengkap->caption());

            // Gelar_Depan
            $this->Gelar_Depan->setupEditAttributes();
            $this->Gelar_Depan->EditValue = !$this->Gelar_Depan->Raw ? HtmlDecode($this->Gelar_Depan->CurrentValue) : $this->Gelar_Depan->CurrentValue;
            $this->Gelar_Depan->PlaceHolder = RemoveHtml($this->Gelar_Depan->caption());

            // Gelar_Belakang
            $this->Gelar_Belakang->setupEditAttributes();
            $this->Gelar_Belakang->EditValue = !$this->Gelar_Belakang->Raw ? HtmlDecode($this->Gelar_Belakang->CurrentValue) : $this->Gelar_Belakang->CurrentValue;
            $this->Gelar_Belakang->PlaceHolder = RemoveHtml($this->Gelar_Belakang->caption());

            // Program_studi
            $this->Program_studi->setupEditAttributes();
            $this->Program_studi->EditValue = !$this->Program_studi->Raw ? HtmlDecode($this->Program_studi->CurrentValue) : $this->Program_studi->CurrentValue;
            $this->Program_studi->PlaceHolder = RemoveHtml($this->Program_studi->caption());

            // NIK
            $this->NIK->setupEditAttributes();
            $this->NIK->EditValue = !$this->NIK->Raw ? HtmlDecode($this->NIK->CurrentValue) : $this->NIK->CurrentValue;
            $this->NIK->PlaceHolder = RemoveHtml($this->NIK->caption());

            // Tanggal_lahir
            $this->Tanggal_lahir->setupEditAttributes();
            $this->Tanggal_lahir->EditValue = FormatDateTime($this->Tanggal_lahir->CurrentValue, $this->Tanggal_lahir->formatPattern());
            $this->Tanggal_lahir->PlaceHolder = RemoveHtml($this->Tanggal_lahir->caption());

            // Tempat_lahir
            $this->Tempat_lahir->setupEditAttributes();
            $this->Tempat_lahir->EditValue = !$this->Tempat_lahir->Raw ? HtmlDecode($this->Tempat_lahir->CurrentValue) : $this->Tempat_lahir->CurrentValue;
            $this->Tempat_lahir->PlaceHolder = RemoveHtml($this->Tempat_lahir->caption());

            // Nomor_Karpeg
            $this->Nomor_Karpeg->setupEditAttributes();
            $this->Nomor_Karpeg->EditValue = !$this->Nomor_Karpeg->Raw ? HtmlDecode($this->Nomor_Karpeg->CurrentValue) : $this->Nomor_Karpeg->CurrentValue;
            $this->Nomor_Karpeg->PlaceHolder = RemoveHtml($this->Nomor_Karpeg->caption());

            // Nomor_Stambuk
            $this->Nomor_Stambuk->setupEditAttributes();
            $this->Nomor_Stambuk->EditValue = !$this->Nomor_Stambuk->Raw ? HtmlDecode($this->Nomor_Stambuk->CurrentValue) : $this->Nomor_Stambuk->CurrentValue;
            $this->Nomor_Stambuk->PlaceHolder = RemoveHtml($this->Nomor_Stambuk->caption());

            // Jenis_kelamin
            $this->Jenis_kelamin->setupEditAttributes();
            $this->Jenis_kelamin->EditValue = !$this->Jenis_kelamin->Raw ? HtmlDecode($this->Jenis_kelamin->CurrentValue) : $this->Jenis_kelamin->CurrentValue;
            $this->Jenis_kelamin->PlaceHolder = RemoveHtml($this->Jenis_kelamin->caption());

            // Gol_Darah
            $this->Gol_Darah->setupEditAttributes();
            $this->Gol_Darah->EditValue = !$this->Gol_Darah->Raw ? HtmlDecode($this->Gol_Darah->CurrentValue) : $this->Gol_Darah->CurrentValue;
            $this->Gol_Darah->PlaceHolder = RemoveHtml($this->Gol_Darah->caption());

            // Agama
            $this->Agama->setupEditAttributes();
            $this->Agama->EditValue = !$this->Agama->Raw ? HtmlDecode($this->Agama->CurrentValue) : $this->Agama->CurrentValue;
            $this->Agama->PlaceHolder = RemoveHtml($this->Agama->caption());

            // Stattus_menikah
            $this->Stattus_menikah->setupEditAttributes();
            $this->Stattus_menikah->EditValue = !$this->Stattus_menikah->Raw ? HtmlDecode($this->Stattus_menikah->CurrentValue) : $this->Stattus_menikah->CurrentValue;
            $this->Stattus_menikah->PlaceHolder = RemoveHtml($this->Stattus_menikah->caption());

            // Alamat
            $this->Alamat->setupEditAttributes();
            $this->Alamat->EditValue = !$this->Alamat->Raw ? HtmlDecode($this->Alamat->CurrentValue) : $this->Alamat->CurrentValue;
            $this->Alamat->PlaceHolder = RemoveHtml($this->Alamat->caption());

            // Kota
            $this->Kota->setupEditAttributes();
            $this->Kota->EditValue = !$this->Kota->Raw ? HtmlDecode($this->Kota->CurrentValue) : $this->Kota->CurrentValue;
            $this->Kota->PlaceHolder = RemoveHtml($this->Kota->caption());

            // Telepon_seluler
            $this->Telepon_seluler->setupEditAttributes();
            $this->Telepon_seluler->EditValue = !$this->Telepon_seluler->Raw ? HtmlDecode($this->Telepon_seluler->CurrentValue) : $this->Telepon_seluler->CurrentValue;
            $this->Telepon_seluler->PlaceHolder = RemoveHtml($this->Telepon_seluler->caption());

            // Jenis_pegawai
            $this->Jenis_pegawai->setupEditAttributes();
            $this->Jenis_pegawai->EditValue = !$this->Jenis_pegawai->Raw ? HtmlDecode($this->Jenis_pegawai->CurrentValue) : $this->Jenis_pegawai->CurrentValue;
            $this->Jenis_pegawai->PlaceHolder = RemoveHtml($this->Jenis_pegawai->caption());

            // Status_pegawai
            $this->Status_pegawai->setupEditAttributes();
            $this->Status_pegawai->EditValue = !$this->Status_pegawai->Raw ? HtmlDecode($this->Status_pegawai->CurrentValue) : $this->Status_pegawai->CurrentValue;
            $this->Status_pegawai->PlaceHolder = RemoveHtml($this->Status_pegawai->caption());

            // Golongan
            $this->Golongan->setupEditAttributes();
            $this->Golongan->EditValue = !$this->Golongan->Raw ? HtmlDecode($this->Golongan->CurrentValue) : $this->Golongan->CurrentValue;
            $this->Golongan->PlaceHolder = RemoveHtml($this->Golongan->caption());

            // Pangkat
            $this->Pangkat->setupEditAttributes();
            $this->Pangkat->EditValue = !$this->Pangkat->Raw ? HtmlDecode($this->Pangkat->CurrentValue) : $this->Pangkat->CurrentValue;
            $this->Pangkat->PlaceHolder = RemoveHtml($this->Pangkat->caption());

            // Status_dosen
            $this->Status_dosen->setupEditAttributes();
            $this->Status_dosen->EditValue = !$this->Status_dosen->Raw ? HtmlDecode($this->Status_dosen->CurrentValue) : $this->Status_dosen->CurrentValue;
            $this->Status_dosen->PlaceHolder = RemoveHtml($this->Status_dosen->caption());

            // Status_Belajar
            $this->Status_Belajar->setupEditAttributes();
            $this->Status_Belajar->EditValue = !$this->Status_Belajar->Raw ? HtmlDecode($this->Status_Belajar->CurrentValue) : $this->Status_Belajar->CurrentValue;
            $this->Status_Belajar->PlaceHolder = RemoveHtml($this->Status_Belajar->caption());

            // e_mail
            $this->e_mail->setupEditAttributes();
            $this->e_mail->EditValue = !$this->e_mail->Raw ? HtmlDecode($this->e_mail->CurrentValue) : $this->e_mail->CurrentValue;
            $this->e_mail->PlaceHolder = RemoveHtml($this->e_mail->caption());

            // Add refer script

            // No
            $this->No->HrefValue = "";

            // NIP
            $this->NIP->HrefValue = "";

            // NIDN
            $this->NIDN->HrefValue = "";

            // Nama_Lengkap
            $this->Nama_Lengkap->HrefValue = "";

            // Gelar_Depan
            $this->Gelar_Depan->HrefValue = "";

            // Gelar_Belakang
            $this->Gelar_Belakang->HrefValue = "";

            // Program_studi
            $this->Program_studi->HrefValue = "";

            // NIK
            $this->NIK->HrefValue = "";

            // Tanggal_lahir
            $this->Tanggal_lahir->HrefValue = "";

            // Tempat_lahir
            $this->Tempat_lahir->HrefValue = "";

            // Nomor_Karpeg
            $this->Nomor_Karpeg->HrefValue = "";

            // Nomor_Stambuk
            $this->Nomor_Stambuk->HrefValue = "";

            // Jenis_kelamin
            $this->Jenis_kelamin->HrefValue = "";

            // Gol_Darah
            $this->Gol_Darah->HrefValue = "";

            // Agama
            $this->Agama->HrefValue = "";

            // Stattus_menikah
            $this->Stattus_menikah->HrefValue = "";

            // Alamat
            $this->Alamat->HrefValue = "";

            // Kota
            $this->Kota->HrefValue = "";

            // Telepon_seluler
            $this->Telepon_seluler->HrefValue = "";

            // Jenis_pegawai
            $this->Jenis_pegawai->HrefValue = "";

            // Status_pegawai
            $this->Status_pegawai->HrefValue = "";

            // Golongan
            $this->Golongan->HrefValue = "";

            // Pangkat
            $this->Pangkat->HrefValue = "";

            // Status_dosen
            $this->Status_dosen->HrefValue = "";

            // Status_Belajar
            $this->Status_Belajar->HrefValue = "";

            // e_mail
            $this->e_mail->HrefValue = "";
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
            if ($this->No->Visible && $this->No->Required) {
                if (!$this->No->IsDetailKey && IsEmpty($this->No->FormValue)) {
                    $this->No->addErrorMessage(str_replace("%s", $this->No->caption(), $this->No->RequiredErrorMessage));
                }
            }
            if ($this->NIP->Visible && $this->NIP->Required) {
                if (!$this->NIP->IsDetailKey && IsEmpty($this->NIP->FormValue)) {
                    $this->NIP->addErrorMessage(str_replace("%s", $this->NIP->caption(), $this->NIP->RequiredErrorMessage));
                }
            }
            if ($this->NIDN->Visible && $this->NIDN->Required) {
                if (!$this->NIDN->IsDetailKey && IsEmpty($this->NIDN->FormValue)) {
                    $this->NIDN->addErrorMessage(str_replace("%s", $this->NIDN->caption(), $this->NIDN->RequiredErrorMessage));
                }
            }
            if ($this->Nama_Lengkap->Visible && $this->Nama_Lengkap->Required) {
                if (!$this->Nama_Lengkap->IsDetailKey && IsEmpty($this->Nama_Lengkap->FormValue)) {
                    $this->Nama_Lengkap->addErrorMessage(str_replace("%s", $this->Nama_Lengkap->caption(), $this->Nama_Lengkap->RequiredErrorMessage));
                }
            }
            if ($this->Gelar_Depan->Visible && $this->Gelar_Depan->Required) {
                if (!$this->Gelar_Depan->IsDetailKey && IsEmpty($this->Gelar_Depan->FormValue)) {
                    $this->Gelar_Depan->addErrorMessage(str_replace("%s", $this->Gelar_Depan->caption(), $this->Gelar_Depan->RequiredErrorMessage));
                }
            }
            if ($this->Gelar_Belakang->Visible && $this->Gelar_Belakang->Required) {
                if (!$this->Gelar_Belakang->IsDetailKey && IsEmpty($this->Gelar_Belakang->FormValue)) {
                    $this->Gelar_Belakang->addErrorMessage(str_replace("%s", $this->Gelar_Belakang->caption(), $this->Gelar_Belakang->RequiredErrorMessage));
                }
            }
            if ($this->Program_studi->Visible && $this->Program_studi->Required) {
                if (!$this->Program_studi->IsDetailKey && IsEmpty($this->Program_studi->FormValue)) {
                    $this->Program_studi->addErrorMessage(str_replace("%s", $this->Program_studi->caption(), $this->Program_studi->RequiredErrorMessage));
                }
            }
            if ($this->NIK->Visible && $this->NIK->Required) {
                if (!$this->NIK->IsDetailKey && IsEmpty($this->NIK->FormValue)) {
                    $this->NIK->addErrorMessage(str_replace("%s", $this->NIK->caption(), $this->NIK->RequiredErrorMessage));
                }
            }
            if ($this->Tanggal_lahir->Visible && $this->Tanggal_lahir->Required) {
                if (!$this->Tanggal_lahir->IsDetailKey && IsEmpty($this->Tanggal_lahir->FormValue)) {
                    $this->Tanggal_lahir->addErrorMessage(str_replace("%s", $this->Tanggal_lahir->caption(), $this->Tanggal_lahir->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->Tanggal_lahir->FormValue, $this->Tanggal_lahir->formatPattern())) {
                $this->Tanggal_lahir->addErrorMessage($this->Tanggal_lahir->getErrorMessage(false));
            }
            if ($this->Tempat_lahir->Visible && $this->Tempat_lahir->Required) {
                if (!$this->Tempat_lahir->IsDetailKey && IsEmpty($this->Tempat_lahir->FormValue)) {
                    $this->Tempat_lahir->addErrorMessage(str_replace("%s", $this->Tempat_lahir->caption(), $this->Tempat_lahir->RequiredErrorMessage));
                }
            }
            if ($this->Nomor_Karpeg->Visible && $this->Nomor_Karpeg->Required) {
                if (!$this->Nomor_Karpeg->IsDetailKey && IsEmpty($this->Nomor_Karpeg->FormValue)) {
                    $this->Nomor_Karpeg->addErrorMessage(str_replace("%s", $this->Nomor_Karpeg->caption(), $this->Nomor_Karpeg->RequiredErrorMessage));
                }
            }
            if ($this->Nomor_Stambuk->Visible && $this->Nomor_Stambuk->Required) {
                if (!$this->Nomor_Stambuk->IsDetailKey && IsEmpty($this->Nomor_Stambuk->FormValue)) {
                    $this->Nomor_Stambuk->addErrorMessage(str_replace("%s", $this->Nomor_Stambuk->caption(), $this->Nomor_Stambuk->RequiredErrorMessage));
                }
            }
            if ($this->Jenis_kelamin->Visible && $this->Jenis_kelamin->Required) {
                if (!$this->Jenis_kelamin->IsDetailKey && IsEmpty($this->Jenis_kelamin->FormValue)) {
                    $this->Jenis_kelamin->addErrorMessage(str_replace("%s", $this->Jenis_kelamin->caption(), $this->Jenis_kelamin->RequiredErrorMessage));
                }
            }
            if ($this->Gol_Darah->Visible && $this->Gol_Darah->Required) {
                if (!$this->Gol_Darah->IsDetailKey && IsEmpty($this->Gol_Darah->FormValue)) {
                    $this->Gol_Darah->addErrorMessage(str_replace("%s", $this->Gol_Darah->caption(), $this->Gol_Darah->RequiredErrorMessage));
                }
            }
            if ($this->Agama->Visible && $this->Agama->Required) {
                if (!$this->Agama->IsDetailKey && IsEmpty($this->Agama->FormValue)) {
                    $this->Agama->addErrorMessage(str_replace("%s", $this->Agama->caption(), $this->Agama->RequiredErrorMessage));
                }
            }
            if ($this->Stattus_menikah->Visible && $this->Stattus_menikah->Required) {
                if (!$this->Stattus_menikah->IsDetailKey && IsEmpty($this->Stattus_menikah->FormValue)) {
                    $this->Stattus_menikah->addErrorMessage(str_replace("%s", $this->Stattus_menikah->caption(), $this->Stattus_menikah->RequiredErrorMessage));
                }
            }
            if ($this->Alamat->Visible && $this->Alamat->Required) {
                if (!$this->Alamat->IsDetailKey && IsEmpty($this->Alamat->FormValue)) {
                    $this->Alamat->addErrorMessage(str_replace("%s", $this->Alamat->caption(), $this->Alamat->RequiredErrorMessage));
                }
            }
            if ($this->Kota->Visible && $this->Kota->Required) {
                if (!$this->Kota->IsDetailKey && IsEmpty($this->Kota->FormValue)) {
                    $this->Kota->addErrorMessage(str_replace("%s", $this->Kota->caption(), $this->Kota->RequiredErrorMessage));
                }
            }
            if ($this->Telepon_seluler->Visible && $this->Telepon_seluler->Required) {
                if (!$this->Telepon_seluler->IsDetailKey && IsEmpty($this->Telepon_seluler->FormValue)) {
                    $this->Telepon_seluler->addErrorMessage(str_replace("%s", $this->Telepon_seluler->caption(), $this->Telepon_seluler->RequiredErrorMessage));
                }
            }
            if ($this->Jenis_pegawai->Visible && $this->Jenis_pegawai->Required) {
                if (!$this->Jenis_pegawai->IsDetailKey && IsEmpty($this->Jenis_pegawai->FormValue)) {
                    $this->Jenis_pegawai->addErrorMessage(str_replace("%s", $this->Jenis_pegawai->caption(), $this->Jenis_pegawai->RequiredErrorMessage));
                }
            }
            if ($this->Status_pegawai->Visible && $this->Status_pegawai->Required) {
                if (!$this->Status_pegawai->IsDetailKey && IsEmpty($this->Status_pegawai->FormValue)) {
                    $this->Status_pegawai->addErrorMessage(str_replace("%s", $this->Status_pegawai->caption(), $this->Status_pegawai->RequiredErrorMessage));
                }
            }
            if ($this->Golongan->Visible && $this->Golongan->Required) {
                if (!$this->Golongan->IsDetailKey && IsEmpty($this->Golongan->FormValue)) {
                    $this->Golongan->addErrorMessage(str_replace("%s", $this->Golongan->caption(), $this->Golongan->RequiredErrorMessage));
                }
            }
            if ($this->Pangkat->Visible && $this->Pangkat->Required) {
                if (!$this->Pangkat->IsDetailKey && IsEmpty($this->Pangkat->FormValue)) {
                    $this->Pangkat->addErrorMessage(str_replace("%s", $this->Pangkat->caption(), $this->Pangkat->RequiredErrorMessage));
                }
            }
            if ($this->Status_dosen->Visible && $this->Status_dosen->Required) {
                if (!$this->Status_dosen->IsDetailKey && IsEmpty($this->Status_dosen->FormValue)) {
                    $this->Status_dosen->addErrorMessage(str_replace("%s", $this->Status_dosen->caption(), $this->Status_dosen->RequiredErrorMessage));
                }
            }
            if ($this->Status_Belajar->Visible && $this->Status_Belajar->Required) {
                if (!$this->Status_Belajar->IsDetailKey && IsEmpty($this->Status_Belajar->FormValue)) {
                    $this->Status_Belajar->addErrorMessage(str_replace("%s", $this->Status_Belajar->caption(), $this->Status_Belajar->RequiredErrorMessage));
                }
            }
            if ($this->e_mail->Visible && $this->e_mail->Required) {
                if (!$this->e_mail->IsDetailKey && IsEmpty($this->e_mail->FormValue)) {
                    $this->e_mail->addErrorMessage(str_replace("%s", $this->e_mail->caption(), $this->e_mail->RequiredErrorMessage));
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
        if ($this->No->CurrentValue != "") { // Check field with unique index
            $filter = "(`No` = '" . AdjustSql($this->No->CurrentValue) . "')";
            $rsChk = $this->loadRecords($filter)->fetchAssociative();
            if ($rsChk !== false) {
                $idxErrMsg = sprintf($this->language->phrase("DuplicateIndex"), $this->No->CurrentValue, $this->No->caption());
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($oldRow);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($oldRow, $newRow);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($newRow['No']) == "") {
            $this->setFailureMessage($this->language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($newRow);
            $rsChk = $this->loadRecords($filter)->fetchAssociative();
            if ($rsChk !== false) {
                $keyErrMsg = sprintf($this->language->phrase("DuplicateKey"), $filter);
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
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

        // No
        $this->No->setDbValueDef($newRow, $this->No->CurrentValue, false);

        // NIP
        $this->NIP->setDbValueDef($newRow, $this->NIP->CurrentValue, false);

        // NIDN
        $this->NIDN->setDbValueDef($newRow, $this->NIDN->CurrentValue, false);

        // Nama_Lengkap
        $this->Nama_Lengkap->setDbValueDef($newRow, $this->Nama_Lengkap->CurrentValue, false);

        // Gelar_Depan
        $this->Gelar_Depan->setDbValueDef($newRow, $this->Gelar_Depan->CurrentValue, false);

        // Gelar_Belakang
        $this->Gelar_Belakang->setDbValueDef($newRow, $this->Gelar_Belakang->CurrentValue, false);

        // Program_studi
        $this->Program_studi->setDbValueDef($newRow, $this->Program_studi->CurrentValue, false);

        // NIK
        $this->NIK->setDbValueDef($newRow, $this->NIK->CurrentValue, false);

        // Tanggal_lahir
        $this->Tanggal_lahir->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal_lahir->CurrentValue, $this->Tanggal_lahir->formatPattern()), false);

        // Tempat_lahir
        $this->Tempat_lahir->setDbValueDef($newRow, $this->Tempat_lahir->CurrentValue, false);

        // Nomor_Karpeg
        $this->Nomor_Karpeg->setDbValueDef($newRow, $this->Nomor_Karpeg->CurrentValue, false);

        // Nomor_Stambuk
        $this->Nomor_Stambuk->setDbValueDef($newRow, $this->Nomor_Stambuk->CurrentValue, false);

        // Jenis_kelamin
        $this->Jenis_kelamin->setDbValueDef($newRow, $this->Jenis_kelamin->CurrentValue, false);

        // Gol_Darah
        $this->Gol_Darah->setDbValueDef($newRow, $this->Gol_Darah->CurrentValue, false);

        // Agama
        $this->Agama->setDbValueDef($newRow, $this->Agama->CurrentValue, false);

        // Stattus_menikah
        $this->Stattus_menikah->setDbValueDef($newRow, $this->Stattus_menikah->CurrentValue, false);

        // Alamat
        $this->Alamat->setDbValueDef($newRow, $this->Alamat->CurrentValue, false);

        // Kota
        $this->Kota->setDbValueDef($newRow, $this->Kota->CurrentValue, false);

        // Telepon_seluler
        $this->Telepon_seluler->setDbValueDef($newRow, $this->Telepon_seluler->CurrentValue, false);

        // Jenis_pegawai
        $this->Jenis_pegawai->setDbValueDef($newRow, $this->Jenis_pegawai->CurrentValue, false);

        // Status_pegawai
        $this->Status_pegawai->setDbValueDef($newRow, $this->Status_pegawai->CurrentValue, false);

        // Golongan
        $this->Golongan->setDbValueDef($newRow, $this->Golongan->CurrentValue, false);

        // Pangkat
        $this->Pangkat->setDbValueDef($newRow, $this->Pangkat->CurrentValue, false);

        // Status_dosen
        $this->Status_dosen->setDbValueDef($newRow, $this->Status_dosen->CurrentValue, false);

        // Status_Belajar
        $this->Status_Belajar->setDbValueDef($newRow, $this->Status_Belajar->CurrentValue, false);

        // e_mail
        $this->e_mail->setDbValueDef($newRow, $this->e_mail->CurrentValue, false);
        return $newRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("dosenlist"), "", $this->TableVar, true);
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
