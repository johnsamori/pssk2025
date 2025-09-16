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
class KesehatanMahasiswaEdit extends KesehatanMahasiswa
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "edit";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "KesehatanMahasiswaEdit";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "kesehatanmahasiswaedit";

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
        $this->Id_kesehatan->setVisibility();
        $this->NIM->setVisibility();
        $this->Dokter_Penanggung_Jawab->setVisibility();
        $this->Nomor_SIP->setVisibility();
        $this->Diagnosa->setVisibility();
        $this->Rekomendasi_Dokter->setVisibility();
        $this->Tanggal->setVisibility();
        $this->Ip->setVisibility();
        $this->user->setVisibility();
        $this->user_id->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'kesehatan_mahasiswa';
        $this->TableName = 'kesehatan_mahasiswa';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Save if user language changed
        if (Param("language") !== null) {
            Profile()->setLanguageId(Param("language"))->saveToStorage();
        }

        // Table object (kesehatan_mahasiswa)
        if (!isset($GLOBALS["kesehatan_mahasiswa"]) || $GLOBALS["kesehatan_mahasiswa"]::class == PROJECT_NAMESPACE . "kesehatan_mahasiswa") {
            $GLOBALS["kesehatan_mahasiswa"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'kesehatan_mahasiswa');
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
                        $result["view"] = SameString($pageName, "kesehatanmahasiswaview"); // If View page, no primary button
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
            $key .= @$ar['Id_kesehatan'];
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
            $this->Id_kesehatan->Visible = false;
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
            if (($keyValue = Get("Id_kesehatan") ?? Key(0) ?? Route(2)) !== null) {
                $this->Id_kesehatan->setQueryStringValue($keyValue);
                $this->Id_kesehatan->setOldValue($this->Id_kesehatan->QueryStringValue);
            } elseif (Post("Id_kesehatan") !== null) {
                $this->Id_kesehatan->setFormValue(Post("Id_kesehatan"));
                $this->Id_kesehatan->setOldValue($this->Id_kesehatan->FormValue);
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
                if (($keyValue = Get("Id_kesehatan") ?? Route("Id_kesehatan")) !== null) {
                    $this->Id_kesehatan->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Id_kesehatan->CurrentValue = null;
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
                        $this->terminate("kesehatanmahasiswalist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "kesehatanmahasiswalist") {
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
                        if (GetPageName($returnUrl) != "kesehatanmahasiswalist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "kesehatanmahasiswalist"; // Return list page content
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

        // Check field name 'Id_kesehatan' before field var 'x_Id_kesehatan'
        $val = $this->getFormValue("Id_kesehatan", null) ?? $this->getFormValue("x_Id_kesehatan", null);
        if (!$this->Id_kesehatan->IsDetailKey) {
            $this->Id_kesehatan->setFormValue($val);
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

        // Check field name 'Dokter_Penanggung_Jawab' before field var 'x_Dokter_Penanggung_Jawab'
        $val = $this->getFormValue("Dokter_Penanggung_Jawab", null) ?? $this->getFormValue("x_Dokter_Penanggung_Jawab", null);
        if (!$this->Dokter_Penanggung_Jawab->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Dokter_Penanggung_Jawab->Visible = false; // Disable update for API request
            } else {
                $this->Dokter_Penanggung_Jawab->setFormValue($val);
            }
        }

        // Check field name 'Nomor_SIP' before field var 'x_Nomor_SIP'
        $val = $this->getFormValue("Nomor_SIP", null) ?? $this->getFormValue("x_Nomor_SIP", null);
        if (!$this->Nomor_SIP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nomor_SIP->Visible = false; // Disable update for API request
            } else {
                $this->Nomor_SIP->setFormValue($val);
            }
        }

        // Check field name 'Diagnosa' before field var 'x_Diagnosa'
        $val = $this->getFormValue("Diagnosa", null) ?? $this->getFormValue("x_Diagnosa", null);
        if (!$this->Diagnosa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Diagnosa->Visible = false; // Disable update for API request
            } else {
                $this->Diagnosa->setFormValue($val);
            }
        }

        // Check field name 'Rekomendasi_Dokter' before field var 'x_Rekomendasi_Dokter'
        $val = $this->getFormValue("Rekomendasi_Dokter", null) ?? $this->getFormValue("x_Rekomendasi_Dokter", null);
        if (!$this->Rekomendasi_Dokter->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Rekomendasi_Dokter->Visible = false; // Disable update for API request
            } else {
                $this->Rekomendasi_Dokter->setFormValue($val);
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

        // Check field name 'user_id' before field var 'x_user_id'
        $val = $this->getFormValue("user_id", null) ?? $this->getFormValue("x_user_id", null);
        if (!$this->user_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_id->Visible = false; // Disable update for API request
            } else {
                $this->user_id->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->Id_kesehatan->CurrentValue = $this->Id_kesehatan->FormValue;
        $this->NIM->CurrentValue = $this->NIM->FormValue;
        $this->Dokter_Penanggung_Jawab->CurrentValue = $this->Dokter_Penanggung_Jawab->FormValue;
        $this->Nomor_SIP->CurrentValue = $this->Nomor_SIP->FormValue;
        $this->Diagnosa->CurrentValue = $this->Diagnosa->FormValue;
        $this->Rekomendasi_Dokter->CurrentValue = $this->Rekomendasi_Dokter->FormValue;
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnformatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->Ip->CurrentValue = $this->Ip->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->user_id->CurrentValue = $this->user_id->FormValue;
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
        $this->Id_kesehatan->setDbValue($row['Id_kesehatan']);
        $this->NIM->setDbValue($row['NIM']);
        $this->Dokter_Penanggung_Jawab->setDbValue($row['Dokter_Penanggung_Jawab']);
        $this->Nomor_SIP->setDbValue($row['Nomor_SIP']);
        $this->Diagnosa->setDbValue($row['Diagnosa']);
        $this->Rekomendasi_Dokter->setDbValue($row['Rekomendasi_Dokter']);
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->Ip->setDbValue($row['Ip']);
        $this->user->setDbValue($row['user']);
        $this->user_id->setDbValue($row['user_id']);
    }

    // Return a row with default values
    protected function newRow(): array
    {
        $row = [];
        $row['Id_kesehatan'] = $this->Id_kesehatan->DefaultValue;
        $row['NIM'] = $this->NIM->DefaultValue;
        $row['Dokter_Penanggung_Jawab'] = $this->Dokter_Penanggung_Jawab->DefaultValue;
        $row['Nomor_SIP'] = $this->Nomor_SIP->DefaultValue;
        $row['Diagnosa'] = $this->Diagnosa->DefaultValue;
        $row['Rekomendasi_Dokter'] = $this->Rekomendasi_Dokter->DefaultValue;
        $row['Tanggal'] = $this->Tanggal->DefaultValue;
        $row['Ip'] = $this->Ip->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['user_id'] = $this->user_id->DefaultValue;
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

        // Id_kesehatan
        $this->Id_kesehatan->RowCssClass = "row";

        // NIM
        $this->NIM->RowCssClass = "row";

        // Dokter_Penanggung_Jawab
        $this->Dokter_Penanggung_Jawab->RowCssClass = "row";

        // Nomor_SIP
        $this->Nomor_SIP->RowCssClass = "row";

        // Diagnosa
        $this->Diagnosa->RowCssClass = "row";

        // Rekomendasi_Dokter
        $this->Rekomendasi_Dokter->RowCssClass = "row";

        // Tanggal
        $this->Tanggal->RowCssClass = "row";

        // Ip
        $this->Ip->RowCssClass = "row";

        // user
        $this->user->RowCssClass = "row";

        // user_id
        $this->user_id->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Id_kesehatan
            $this->Id_kesehatan->ViewValue = $this->Id_kesehatan->CurrentValue;

            // NIM
            $this->NIM->ViewValue = $this->NIM->CurrentValue;

            // Dokter_Penanggung_Jawab
            $this->Dokter_Penanggung_Jawab->ViewValue = $this->Dokter_Penanggung_Jawab->CurrentValue;

            // Nomor_SIP
            $this->Nomor_SIP->ViewValue = $this->Nomor_SIP->CurrentValue;

            // Diagnosa
            $this->Diagnosa->ViewValue = $this->Diagnosa->CurrentValue;

            // Rekomendasi_Dokter
            $this->Rekomendasi_Dokter->ViewValue = $this->Rekomendasi_Dokter->CurrentValue;

            // Tanggal
            $this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
            $this->Tanggal->ViewValue = FormatDateTime($this->Tanggal->ViewValue, $this->Tanggal->formatPattern());

            // Ip
            $this->Ip->ViewValue = $this->Ip->CurrentValue;

            // user
            $this->user->ViewValue = $this->user->CurrentValue;

            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewValue = FormatNumber($this->user_id->ViewValue, $this->user_id->formatPattern());

            // Id_kesehatan
            $this->Id_kesehatan->HrefValue = "";

            // NIM
            $this->NIM->HrefValue = "";

            // Dokter_Penanggung_Jawab
            $this->Dokter_Penanggung_Jawab->HrefValue = "";

            // Nomor_SIP
            $this->Nomor_SIP->HrefValue = "";

            // Diagnosa
            $this->Diagnosa->HrefValue = "";

            // Rekomendasi_Dokter
            $this->Rekomendasi_Dokter->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // Ip
            $this->Ip->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // user_id
            $this->user_id->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Id_kesehatan
            $this->Id_kesehatan->setupEditAttributes();
            $this->Id_kesehatan->EditValue = $this->Id_kesehatan->CurrentValue;

            // NIM
            $this->NIM->setupEditAttributes();
            $this->NIM->EditValue = !$this->NIM->Raw ? HtmlDecode($this->NIM->CurrentValue) : $this->NIM->CurrentValue;
            $this->NIM->PlaceHolder = RemoveHtml($this->NIM->caption());

            // Dokter_Penanggung_Jawab
            $this->Dokter_Penanggung_Jawab->setupEditAttributes();
            $this->Dokter_Penanggung_Jawab->EditValue = !$this->Dokter_Penanggung_Jawab->Raw ? HtmlDecode($this->Dokter_Penanggung_Jawab->CurrentValue) : $this->Dokter_Penanggung_Jawab->CurrentValue;
            $this->Dokter_Penanggung_Jawab->PlaceHolder = RemoveHtml($this->Dokter_Penanggung_Jawab->caption());

            // Nomor_SIP
            $this->Nomor_SIP->setupEditAttributes();
            $this->Nomor_SIP->EditValue = !$this->Nomor_SIP->Raw ? HtmlDecode($this->Nomor_SIP->CurrentValue) : $this->Nomor_SIP->CurrentValue;
            $this->Nomor_SIP->PlaceHolder = RemoveHtml($this->Nomor_SIP->caption());

            // Diagnosa
            $this->Diagnosa->setupEditAttributes();
            $this->Diagnosa->EditValue = !$this->Diagnosa->Raw ? HtmlDecode($this->Diagnosa->CurrentValue) : $this->Diagnosa->CurrentValue;
            $this->Diagnosa->PlaceHolder = RemoveHtml($this->Diagnosa->caption());

            // Rekomendasi_Dokter
            $this->Rekomendasi_Dokter->setupEditAttributes();
            $this->Rekomendasi_Dokter->EditValue = !$this->Rekomendasi_Dokter->Raw ? HtmlDecode($this->Rekomendasi_Dokter->CurrentValue) : $this->Rekomendasi_Dokter->CurrentValue;
            $this->Rekomendasi_Dokter->PlaceHolder = RemoveHtml($this->Rekomendasi_Dokter->caption());

            // Tanggal

            // Ip

            // user

            // user_id

            // Edit refer script

            // Id_kesehatan
            $this->Id_kesehatan->HrefValue = "";

            // NIM
            $this->NIM->HrefValue = "";

            // Dokter_Penanggung_Jawab
            $this->Dokter_Penanggung_Jawab->HrefValue = "";

            // Nomor_SIP
            $this->Nomor_SIP->HrefValue = "";

            // Diagnosa
            $this->Diagnosa->HrefValue = "";

            // Rekomendasi_Dokter
            $this->Rekomendasi_Dokter->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // Ip
            $this->Ip->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // user_id
            $this->user_id->HrefValue = "";
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
            if ($this->Id_kesehatan->Visible && $this->Id_kesehatan->Required) {
                if (!$this->Id_kesehatan->IsDetailKey && IsEmpty($this->Id_kesehatan->FormValue)) {
                    $this->Id_kesehatan->addErrorMessage(str_replace("%s", $this->Id_kesehatan->caption(), $this->Id_kesehatan->RequiredErrorMessage));
                }
            }
            if ($this->NIM->Visible && $this->NIM->Required) {
                if (!$this->NIM->IsDetailKey && IsEmpty($this->NIM->FormValue)) {
                    $this->NIM->addErrorMessage(str_replace("%s", $this->NIM->caption(), $this->NIM->RequiredErrorMessage));
                }
            }
            if ($this->Dokter_Penanggung_Jawab->Visible && $this->Dokter_Penanggung_Jawab->Required) {
                if (!$this->Dokter_Penanggung_Jawab->IsDetailKey && IsEmpty($this->Dokter_Penanggung_Jawab->FormValue)) {
                    $this->Dokter_Penanggung_Jawab->addErrorMessage(str_replace("%s", $this->Dokter_Penanggung_Jawab->caption(), $this->Dokter_Penanggung_Jawab->RequiredErrorMessage));
                }
            }
            if ($this->Nomor_SIP->Visible && $this->Nomor_SIP->Required) {
                if (!$this->Nomor_SIP->IsDetailKey && IsEmpty($this->Nomor_SIP->FormValue)) {
                    $this->Nomor_SIP->addErrorMessage(str_replace("%s", $this->Nomor_SIP->caption(), $this->Nomor_SIP->RequiredErrorMessage));
                }
            }
            if ($this->Diagnosa->Visible && $this->Diagnosa->Required) {
                if (!$this->Diagnosa->IsDetailKey && IsEmpty($this->Diagnosa->FormValue)) {
                    $this->Diagnosa->addErrorMessage(str_replace("%s", $this->Diagnosa->caption(), $this->Diagnosa->RequiredErrorMessage));
                }
            }
            if ($this->Rekomendasi_Dokter->Visible && $this->Rekomendasi_Dokter->Required) {
                if (!$this->Rekomendasi_Dokter->IsDetailKey && IsEmpty($this->Rekomendasi_Dokter->FormValue)) {
                    $this->Rekomendasi_Dokter->addErrorMessage(str_replace("%s", $this->Rekomendasi_Dokter->caption(), $this->Rekomendasi_Dokter->RequiredErrorMessage));
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
            if ($this->user_id->Visible && $this->user_id->Required) {
                if (!$this->user_id->IsDetailKey && IsEmpty($this->user_id->FormValue)) {
                    $this->user_id->addErrorMessage(str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
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

        // Call Row Updating event
        $updateRow = $this->rowUpdating($oldRow, $newRow);
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

        // NIM
        $this->NIM->setDbValueDef($newRow, $this->NIM->CurrentValue, $this->NIM->ReadOnly);

        // Dokter_Penanggung_Jawab
        $this->Dokter_Penanggung_Jawab->setDbValueDef($newRow, $this->Dokter_Penanggung_Jawab->CurrentValue, $this->Dokter_Penanggung_Jawab->ReadOnly);

        // Nomor_SIP
        $this->Nomor_SIP->setDbValueDef($newRow, $this->Nomor_SIP->CurrentValue, $this->Nomor_SIP->ReadOnly);

        // Diagnosa
        $this->Diagnosa->setDbValueDef($newRow, $this->Diagnosa->CurrentValue, $this->Diagnosa->ReadOnly);

        // Rekomendasi_Dokter
        $this->Rekomendasi_Dokter->setDbValueDef($newRow, $this->Rekomendasi_Dokter->CurrentValue, $this->Rekomendasi_Dokter->ReadOnly);

        // Tanggal
        $this->Tanggal->CurrentValue = $this->Tanggal->getAutoUpdateValue(); // PHP
        $this->Tanggal->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern()), $this->Tanggal->ReadOnly);

        // Ip
        $this->Ip->CurrentValue = $this->Ip->getAutoUpdateValue(); // PHP
        $this->Ip->setDbValueDef($newRow, $this->Ip->CurrentValue, $this->Ip->ReadOnly);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($newRow, $this->user->CurrentValue, $this->user->ReadOnly);

        // user_id
        $this->user_id->CurrentValue = $this->user_id->getAutoUpdateValue(); // PHP
        $this->user_id->setDbValueDef($newRow, $this->user_id->CurrentValue, $this->user_id->ReadOnly);
        return $newRow;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow(array $row): void
    {
        if (isset($row['NIM'])) { // NIM
            $this->NIM->CurrentValue = $row['NIM'];
        }
        if (isset($row['Dokter_Penanggung_Jawab'])) { // Dokter_Penanggung_Jawab
            $this->Dokter_Penanggung_Jawab->CurrentValue = $row['Dokter_Penanggung_Jawab'];
        }
        if (isset($row['Nomor_SIP'])) { // Nomor_SIP
            $this->Nomor_SIP->CurrentValue = $row['Nomor_SIP'];
        }
        if (isset($row['Diagnosa'])) { // Diagnosa
            $this->Diagnosa->CurrentValue = $row['Diagnosa'];
        }
        if (isset($row['Rekomendasi_Dokter'])) { // Rekomendasi_Dokter
            $this->Rekomendasi_Dokter->CurrentValue = $row['Rekomendasi_Dokter'];
        }
        if (isset($row['Tanggal'])) { // Tanggal
            $this->Tanggal->CurrentValue = $row['Tanggal'];
        }
        if (isset($row['Ip'])) { // Ip
            $this->Ip->CurrentValue = $row['Ip'];
        }
        if (isset($row['user'])) { // user
            $this->user->CurrentValue = $row['user'];
        }
        if (isset($row['user_id'])) { // user_id
            $this->user_id->CurrentValue = $row['user_id'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("kesehatanmahasiswalist"), "", $this->TableVar, true);
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
