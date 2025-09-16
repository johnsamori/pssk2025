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
class MahasiswaEdit extends Mahasiswa
{
    use MessagesTrait;
    use FormTrait;

    // Page ID
    public string $PageID = "edit";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "MahasiswaEdit";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "mahasiswaedit";

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
        $this->userid->setVisibility();
        $this->user->setVisibility();
        $this->ip->setVisibility();
        $this->tanggal_input->setVisibility();
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'mahasiswa';
        $this->TableName = 'mahasiswa';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

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

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mahasiswa');
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
                        $result["view"] = SameString($pageName, "mahasiswaview"); // If View page, no primary button
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
            if (($keyValue = Get("NIM") ?? Key(0) ?? Route(2)) !== null) {
                $this->NIM->setQueryStringValue($keyValue);
                $this->NIM->setOldValue($this->NIM->QueryStringValue);
            } elseif (Post("NIM") !== null) {
                $this->NIM->setFormValue(Post("NIM"));
                $this->NIM->setOldValue($this->NIM->FormValue);
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
                if (($keyValue = Get("NIM") ?? Route("NIM")) !== null) {
                    $this->NIM->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->NIM->CurrentValue = null;
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
                        $this->terminate("mahasiswalist"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "mahasiswalist") {
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
                        if (GetPageName($returnUrl) != "mahasiswalist") {
                            FlashBag()->add("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "mahasiswalist"; // Return list page content
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

        // Check field name 'Nama' before field var 'x_Nama'
        $val = $this->getFormValue("Nama", null) ?? $this->getFormValue("x_Nama", null);
        if (!$this->Nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama->Visible = false; // Disable update for API request
            } else {
                $this->Nama->setFormValue($val);
            }
        }

        // Check field name 'Jenis_Kelamin' before field var 'x_Jenis_Kelamin'
        $val = $this->getFormValue("Jenis_Kelamin", null) ?? $this->getFormValue("x_Jenis_Kelamin", null);
        if (!$this->Jenis_Kelamin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jenis_Kelamin->Visible = false; // Disable update for API request
            } else {
                $this->Jenis_Kelamin->setFormValue($val);
            }
        }

        // Check field name 'Provinsi_Tempat_Lahir' before field var 'x_Provinsi_Tempat_Lahir'
        $val = $this->getFormValue("Provinsi_Tempat_Lahir", null) ?? $this->getFormValue("x_Provinsi_Tempat_Lahir", null);
        if (!$this->Provinsi_Tempat_Lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Provinsi_Tempat_Lahir->Visible = false; // Disable update for API request
            } else {
                $this->Provinsi_Tempat_Lahir->setFormValue($val);
            }
        }

        // Check field name 'Kota_Tempat_Lahir' before field var 'x_Kota_Tempat_Lahir'
        $val = $this->getFormValue("Kota_Tempat_Lahir", null) ?? $this->getFormValue("x_Kota_Tempat_Lahir", null);
        if (!$this->Kota_Tempat_Lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kota_Tempat_Lahir->Visible = false; // Disable update for API request
            } else {
                $this->Kota_Tempat_Lahir->setFormValue($val);
            }
        }

        // Check field name 'Tanggal_Lahir' before field var 'x_Tanggal_Lahir'
        $val = $this->getFormValue("Tanggal_Lahir", null) ?? $this->getFormValue("x_Tanggal_Lahir", null);
        if (!$this->Tanggal_Lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tanggal_Lahir->Visible = false; // Disable update for API request
            } else {
                $this->Tanggal_Lahir->setFormValue($val, true, $validate);
            }
            $this->Tanggal_Lahir->CurrentValue = UnformatDateTime($this->Tanggal_Lahir->CurrentValue, $this->Tanggal_Lahir->formatPattern());
        }

        // Check field name 'Golongan_Darah' before field var 'x_Golongan_Darah'
        $val = $this->getFormValue("Golongan_Darah", null) ?? $this->getFormValue("x_Golongan_Darah", null);
        if (!$this->Golongan_Darah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Golongan_Darah->Visible = false; // Disable update for API request
            } else {
                $this->Golongan_Darah->setFormValue($val);
            }
        }

        // Check field name 'Tinggi_Badan' before field var 'x_Tinggi_Badan'
        $val = $this->getFormValue("Tinggi_Badan", null) ?? $this->getFormValue("x_Tinggi_Badan", null);
        if (!$this->Tinggi_Badan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tinggi_Badan->Visible = false; // Disable update for API request
            } else {
                $this->Tinggi_Badan->setFormValue($val);
            }
        }

        // Check field name 'Berat_Badan' before field var 'x_Berat_Badan'
        $val = $this->getFormValue("Berat_Badan", null) ?? $this->getFormValue("x_Berat_Badan", null);
        if (!$this->Berat_Badan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Berat_Badan->Visible = false; // Disable update for API request
            } else {
                $this->Berat_Badan->setFormValue($val);
            }
        }

        // Check field name 'Asal_sekolah' before field var 'x_Asal_sekolah'
        $val = $this->getFormValue("Asal_sekolah", null) ?? $this->getFormValue("x_Asal_sekolah", null);
        if (!$this->Asal_sekolah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Asal_sekolah->Visible = false; // Disable update for API request
            } else {
                $this->Asal_sekolah->setFormValue($val);
            }
        }

        // Check field name 'Tahun_Ijazah' before field var 'x_Tahun_Ijazah'
        $val = $this->getFormValue("Tahun_Ijazah", null) ?? $this->getFormValue("x_Tahun_Ijazah", null);
        if (!$this->Tahun_Ijazah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tahun_Ijazah->Visible = false; // Disable update for API request
            } else {
                $this->Tahun_Ijazah->setFormValue($val);
            }
        }

        // Check field name 'Nomor_Ijazah' before field var 'x_Nomor_Ijazah'
        $val = $this->getFormValue("Nomor_Ijazah", null) ?? $this->getFormValue("x_Nomor_Ijazah", null);
        if (!$this->Nomor_Ijazah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nomor_Ijazah->Visible = false; // Disable update for API request
            } else {
                $this->Nomor_Ijazah->setFormValue($val);
            }
        }

        // Check field name 'Nilai_Raport_Kelas_10' before field var 'x_Nilai_Raport_Kelas_10'
        $val = $this->getFormValue("Nilai_Raport_Kelas_10", null) ?? $this->getFormValue("x_Nilai_Raport_Kelas_10", null);
        if (!$this->Nilai_Raport_Kelas_10->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Raport_Kelas_10->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Raport_Kelas_10->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Nilai_Raport_Kelas_11' before field var 'x_Nilai_Raport_Kelas_11'
        $val = $this->getFormValue("Nilai_Raport_Kelas_11", null) ?? $this->getFormValue("x_Nilai_Raport_Kelas_11", null);
        if (!$this->Nilai_Raport_Kelas_11->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Raport_Kelas_11->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Raport_Kelas_11->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Nilai_Raport_Kelas_12' before field var 'x_Nilai_Raport_Kelas_12'
        $val = $this->getFormValue("Nilai_Raport_Kelas_12", null) ?? $this->getFormValue("x_Nilai_Raport_Kelas_12", null);
        if (!$this->Nilai_Raport_Kelas_12->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nilai_Raport_Kelas_12->Visible = false; // Disable update for API request
            } else {
                $this->Nilai_Raport_Kelas_12->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Tanggal_Daftar' before field var 'x_Tanggal_Daftar'
        $val = $this->getFormValue("Tanggal_Daftar", null) ?? $this->getFormValue("x_Tanggal_Daftar", null);
        if (!$this->Tanggal_Daftar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tanggal_Daftar->Visible = false; // Disable update for API request
            } else {
                $this->Tanggal_Daftar->setFormValue($val, true, $validate);
            }
            $this->Tanggal_Daftar->CurrentValue = UnformatDateTime($this->Tanggal_Daftar->CurrentValue, $this->Tanggal_Daftar->formatPattern());
        }

        // Check field name 'No_Test' before field var 'x_No_Test'
        $val = $this->getFormValue("No_Test", null) ?? $this->getFormValue("x_No_Test", null);
        if (!$this->No_Test->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->No_Test->Visible = false; // Disable update for API request
            } else {
                $this->No_Test->setFormValue($val);
            }
        }

        // Check field name 'Status_Masuk' before field var 'x_Status_Masuk'
        $val = $this->getFormValue("Status_Masuk", null) ?? $this->getFormValue("x_Status_Masuk", null);
        if (!$this->Status_Masuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status_Masuk->Visible = false; // Disable update for API request
            } else {
                $this->Status_Masuk->setFormValue($val);
            }
        }

        // Check field name 'Jalur_Masuk' before field var 'x_Jalur_Masuk'
        $val = $this->getFormValue("Jalur_Masuk", null) ?? $this->getFormValue("x_Jalur_Masuk", null);
        if (!$this->Jalur_Masuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jalur_Masuk->Visible = false; // Disable update for API request
            } else {
                $this->Jalur_Masuk->setFormValue($val);
            }
        }

        // Check field name 'Bukti_Lulus' before field var 'x_Bukti_Lulus'
        $val = $this->getFormValue("Bukti_Lulus", null) ?? $this->getFormValue("x_Bukti_Lulus", null);
        if (!$this->Bukti_Lulus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Bukti_Lulus->Visible = false; // Disable update for API request
            } else {
                $this->Bukti_Lulus->setFormValue($val);
            }
        }

        // Check field name 'Tes_Potensi_Akademik' before field var 'x_Tes_Potensi_Akademik'
        $val = $this->getFormValue("Tes_Potensi_Akademik", null) ?? $this->getFormValue("x_Tes_Potensi_Akademik", null);
        if (!$this->Tes_Potensi_Akademik->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tes_Potensi_Akademik->Visible = false; // Disable update for API request
            } else {
                $this->Tes_Potensi_Akademik->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Tes_Wawancara' before field var 'x_Tes_Wawancara'
        $val = $this->getFormValue("Tes_Wawancara", null) ?? $this->getFormValue("x_Tes_Wawancara", null);
        if (!$this->Tes_Wawancara->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tes_Wawancara->Visible = false; // Disable update for API request
            } else {
                $this->Tes_Wawancara->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Tes_Kesehatan' before field var 'x_Tes_Kesehatan'
        $val = $this->getFormValue("Tes_Kesehatan", null) ?? $this->getFormValue("x_Tes_Kesehatan", null);
        if (!$this->Tes_Kesehatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tes_Kesehatan->Visible = false; // Disable update for API request
            } else {
                $this->Tes_Kesehatan->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Hasil_Test_Kesehatan' before field var 'x_Hasil_Test_Kesehatan'
        $val = $this->getFormValue("Hasil_Test_Kesehatan", null) ?? $this->getFormValue("x_Hasil_Test_Kesehatan", null);
        if (!$this->Hasil_Test_Kesehatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Hasil_Test_Kesehatan->Visible = false; // Disable update for API request
            } else {
                $this->Hasil_Test_Kesehatan->setFormValue($val);
            }
        }

        // Check field name 'Test_MMPI' before field var 'x_Test_MMPI'
        $val = $this->getFormValue("Test_MMPI", null) ?? $this->getFormValue("x_Test_MMPI", null);
        if (!$this->Test_MMPI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Test_MMPI->Visible = false; // Disable update for API request
            } else {
                $this->Test_MMPI->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Hasil_Test_MMPI' before field var 'x_Hasil_Test_MMPI'
        $val = $this->getFormValue("Hasil_Test_MMPI", null) ?? $this->getFormValue("x_Hasil_Test_MMPI", null);
        if (!$this->Hasil_Test_MMPI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Hasil_Test_MMPI->Visible = false; // Disable update for API request
            } else {
                $this->Hasil_Test_MMPI->setFormValue($val);
            }
        }

        // Check field name 'Angkatan' before field var 'x_Angkatan'
        $val = $this->getFormValue("Angkatan", null) ?? $this->getFormValue("x_Angkatan", null);
        if (!$this->Angkatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Angkatan->Visible = false; // Disable update for API request
            } else {
                $this->Angkatan->setFormValue($val);
            }
        }

        // Check field name 'Tarif_SPP' before field var 'x_Tarif_SPP'
        $val = $this->getFormValue("Tarif_SPP", null) ?? $this->getFormValue("x_Tarif_SPP", null);
        if (!$this->Tarif_SPP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tarif_SPP->Visible = false; // Disable update for API request
            } else {
                $this->Tarif_SPP->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'NIK_No_KTP' before field var 'x_NIK_No_KTP'
        $val = $this->getFormValue("NIK_No_KTP", null) ?? $this->getFormValue("x_NIK_No_KTP", null);
        if (!$this->NIK_No_KTP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIK_No_KTP->Visible = false; // Disable update for API request
            } else {
                $this->NIK_No_KTP->setFormValue($val);
            }
        }

        // Check field name 'No_KK' before field var 'x_No_KK'
        $val = $this->getFormValue("No_KK", null) ?? $this->getFormValue("x_No_KK", null);
        if (!$this->No_KK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->No_KK->Visible = false; // Disable update for API request
            } else {
                $this->No_KK->setFormValue($val);
            }
        }

        // Check field name 'NPWP' before field var 'x_NPWP'
        $val = $this->getFormValue("NPWP", null) ?? $this->getFormValue("x_NPWP", null);
        if (!$this->NPWP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NPWP->Visible = false; // Disable update for API request
            } else {
                $this->NPWP->setFormValue($val);
            }
        }

        // Check field name 'Status_Nikah' before field var 'x_Status_Nikah'
        $val = $this->getFormValue("Status_Nikah", null) ?? $this->getFormValue("x_Status_Nikah", null);
        if (!$this->Status_Nikah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status_Nikah->Visible = false; // Disable update for API request
            } else {
                $this->Status_Nikah->setFormValue($val);
            }
        }

        // Check field name 'Kewarganegaraan' before field var 'x_Kewarganegaraan'
        $val = $this->getFormValue("Kewarganegaraan", null) ?? $this->getFormValue("x_Kewarganegaraan", null);
        if (!$this->Kewarganegaraan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kewarganegaraan->Visible = false; // Disable update for API request
            } else {
                $this->Kewarganegaraan->setFormValue($val);
            }
        }

        // Check field name 'Propinsi_Tempat_Tinggal' before field var 'x_Propinsi_Tempat_Tinggal'
        $val = $this->getFormValue("Propinsi_Tempat_Tinggal", null) ?? $this->getFormValue("x_Propinsi_Tempat_Tinggal", null);
        if (!$this->Propinsi_Tempat_Tinggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Propinsi_Tempat_Tinggal->Visible = false; // Disable update for API request
            } else {
                $this->Propinsi_Tempat_Tinggal->setFormValue($val);
            }
        }

        // Check field name 'Kota_Tempat_Tinggal' before field var 'x_Kota_Tempat_Tinggal'
        $val = $this->getFormValue("Kota_Tempat_Tinggal", null) ?? $this->getFormValue("x_Kota_Tempat_Tinggal", null);
        if (!$this->Kota_Tempat_Tinggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kota_Tempat_Tinggal->Visible = false; // Disable update for API request
            } else {
                $this->Kota_Tempat_Tinggal->setFormValue($val);
            }
        }

        // Check field name 'Kecamatan_Tempat_Tinggal' before field var 'x_Kecamatan_Tempat_Tinggal'
        $val = $this->getFormValue("Kecamatan_Tempat_Tinggal", null) ?? $this->getFormValue("x_Kecamatan_Tempat_Tinggal", null);
        if (!$this->Kecamatan_Tempat_Tinggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kecamatan_Tempat_Tinggal->Visible = false; // Disable update for API request
            } else {
                $this->Kecamatan_Tempat_Tinggal->setFormValue($val);
            }
        }

        // Check field name 'Alamat_Tempat_Tinggal' before field var 'x_Alamat_Tempat_Tinggal'
        $val = $this->getFormValue("Alamat_Tempat_Tinggal", null) ?? $this->getFormValue("x_Alamat_Tempat_Tinggal", null);
        if (!$this->Alamat_Tempat_Tinggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Alamat_Tempat_Tinggal->Visible = false; // Disable update for API request
            } else {
                $this->Alamat_Tempat_Tinggal->setFormValue($val);
            }
        }

        // Check field name 'RT' before field var 'x_RT'
        $val = $this->getFormValue("RT", null) ?? $this->getFormValue("x_RT", null);
        if (!$this->RT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RT->Visible = false; // Disable update for API request
            } else {
                $this->RT->setFormValue($val);
            }
        }

        // Check field name 'RW' before field var 'x_RW'
        $val = $this->getFormValue("RW", null) ?? $this->getFormValue("x_RW", null);
        if (!$this->RW->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RW->Visible = false; // Disable update for API request
            } else {
                $this->RW->setFormValue($val);
            }
        }

        // Check field name 'Kelurahan' before field var 'x_Kelurahan'
        $val = $this->getFormValue("Kelurahan", null) ?? $this->getFormValue("x_Kelurahan", null);
        if (!$this->Kelurahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kelurahan->Visible = false; // Disable update for API request
            } else {
                $this->Kelurahan->setFormValue($val);
            }
        }

        // Check field name 'Kode_Pos' before field var 'x_Kode_Pos'
        $val = $this->getFormValue("Kode_Pos", null) ?? $this->getFormValue("x_Kode_Pos", null);
        if (!$this->Kode_Pos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kode_Pos->Visible = false; // Disable update for API request
            } else {
                $this->Kode_Pos->setFormValue($val);
            }
        }

        // Check field name 'Nomor_Telpon_HP' before field var 'x_Nomor_Telpon_HP'
        $val = $this->getFormValue("Nomor_Telpon_HP", null) ?? $this->getFormValue("x_Nomor_Telpon_HP", null);
        if (!$this->Nomor_Telpon_HP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nomor_Telpon_HP->Visible = false; // Disable update for API request
            } else {
                $this->Nomor_Telpon_HP->setFormValue($val);
            }
        }

        // Check field name 'Email' before field var 'x__Email'
        $val = $this->getFormValue("Email", null) ?? $this->getFormValue("x__Email", null);
        if (!$this->_Email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Email->Visible = false; // Disable update for API request
            } else {
                $this->_Email->setFormValue($val);
            }
        }

        // Check field name 'Jenis_Tinggal' before field var 'x_Jenis_Tinggal'
        $val = $this->getFormValue("Jenis_Tinggal", null) ?? $this->getFormValue("x_Jenis_Tinggal", null);
        if (!$this->Jenis_Tinggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jenis_Tinggal->Visible = false; // Disable update for API request
            } else {
                $this->Jenis_Tinggal->setFormValue($val);
            }
        }

        // Check field name 'Alat_Transportasi' before field var 'x_Alat_Transportasi'
        $val = $this->getFormValue("Alat_Transportasi", null) ?? $this->getFormValue("x_Alat_Transportasi", null);
        if (!$this->Alat_Transportasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Alat_Transportasi->Visible = false; // Disable update for API request
            } else {
                $this->Alat_Transportasi->setFormValue($val);
            }
        }

        // Check field name 'Sumber_Dana' before field var 'x_Sumber_Dana'
        $val = $this->getFormValue("Sumber_Dana", null) ?? $this->getFormValue("x_Sumber_Dana", null);
        if (!$this->Sumber_Dana->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Sumber_Dana->Visible = false; // Disable update for API request
            } else {
                $this->Sumber_Dana->setFormValue($val);
            }
        }

        // Check field name 'Sumber_Dana_Beasiswa' before field var 'x_Sumber_Dana_Beasiswa'
        $val = $this->getFormValue("Sumber_Dana_Beasiswa", null) ?? $this->getFormValue("x_Sumber_Dana_Beasiswa", null);
        if (!$this->Sumber_Dana_Beasiswa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Sumber_Dana_Beasiswa->Visible = false; // Disable update for API request
            } else {
                $this->Sumber_Dana_Beasiswa->setFormValue($val);
            }
        }

        // Check field name 'Jumlah_Sudara' before field var 'x_Jumlah_Sudara'
        $val = $this->getFormValue("Jumlah_Sudara", null) ?? $this->getFormValue("x_Jumlah_Sudara", null);
        if (!$this->Jumlah_Sudara->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jumlah_Sudara->Visible = false; // Disable update for API request
            } else {
                $this->Jumlah_Sudara->setFormValue($val);
            }
        }

        // Check field name 'Status_Bekerja' before field var 'x_Status_Bekerja'
        $val = $this->getFormValue("Status_Bekerja", null) ?? $this->getFormValue("x_Status_Bekerja", null);
        if (!$this->Status_Bekerja->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Status_Bekerja->Visible = false; // Disable update for API request
            } else {
                $this->Status_Bekerja->setFormValue($val);
            }
        }

        // Check field name 'Nomor_Asuransi' before field var 'x_Nomor_Asuransi'
        $val = $this->getFormValue("Nomor_Asuransi", null) ?? $this->getFormValue("x_Nomor_Asuransi", null);
        if (!$this->Nomor_Asuransi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nomor_Asuransi->Visible = false; // Disable update for API request
            } else {
                $this->Nomor_Asuransi->setFormValue($val);
            }
        }

        // Check field name 'Hobi' before field var 'x_Hobi'
        $val = $this->getFormValue("Hobi", null) ?? $this->getFormValue("x_Hobi", null);
        if (!$this->Hobi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Hobi->Visible = false; // Disable update for API request
            } else {
                $this->Hobi->setFormValue($val);
            }
        }

        // Check field name 'Foto' before field var 'x_Foto'
        $val = $this->getFormValue("Foto", null) ?? $this->getFormValue("x_Foto", null);
        if (!$this->Foto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Foto->Visible = false; // Disable update for API request
            } else {
                $this->Foto->setFormValue($val);
            }
        }

        // Check field name 'Nama_Ayah' before field var 'x_Nama_Ayah'
        $val = $this->getFormValue("Nama_Ayah", null) ?? $this->getFormValue("x_Nama_Ayah", null);
        if (!$this->Nama_Ayah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Ayah->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Ayah->setFormValue($val);
            }
        }

        // Check field name 'Pekerjaan_Ayah' before field var 'x_Pekerjaan_Ayah'
        $val = $this->getFormValue("Pekerjaan_Ayah", null) ?? $this->getFormValue("x_Pekerjaan_Ayah", null);
        if (!$this->Pekerjaan_Ayah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pekerjaan_Ayah->Visible = false; // Disable update for API request
            } else {
                $this->Pekerjaan_Ayah->setFormValue($val);
            }
        }

        // Check field name 'Nama_Ibu' before field var 'x_Nama_Ibu'
        $val = $this->getFormValue("Nama_Ibu", null) ?? $this->getFormValue("x_Nama_Ibu", null);
        if (!$this->Nama_Ibu->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Ibu->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Ibu->setFormValue($val);
            }
        }

        // Check field name 'Pekerjaan_Ibu' before field var 'x_Pekerjaan_Ibu'
        $val = $this->getFormValue("Pekerjaan_Ibu", null) ?? $this->getFormValue("x_Pekerjaan_Ibu", null);
        if (!$this->Pekerjaan_Ibu->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Pekerjaan_Ibu->Visible = false; // Disable update for API request
            } else {
                $this->Pekerjaan_Ibu->setFormValue($val);
            }
        }

        // Check field name 'Alamat_Orang_Tua' before field var 'x_Alamat_Orang_Tua'
        $val = $this->getFormValue("Alamat_Orang_Tua", null) ?? $this->getFormValue("x_Alamat_Orang_Tua", null);
        if (!$this->Alamat_Orang_Tua->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Alamat_Orang_Tua->Visible = false; // Disable update for API request
            } else {
                $this->Alamat_Orang_Tua->setFormValue($val);
            }
        }

        // Check field name 'e_mail_Oranng_Tua' before field var 'x_e_mail_Oranng_Tua'
        $val = $this->getFormValue("e_mail_Oranng_Tua", null) ?? $this->getFormValue("x_e_mail_Oranng_Tua", null);
        if (!$this->e_mail_Oranng_Tua->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->e_mail_Oranng_Tua->Visible = false; // Disable update for API request
            } else {
                $this->e_mail_Oranng_Tua->setFormValue($val);
            }
        }

        // Check field name 'No_Kontak_Orang_Tua' before field var 'x_No_Kontak_Orang_Tua'
        $val = $this->getFormValue("No_Kontak_Orang_Tua", null) ?? $this->getFormValue("x_No_Kontak_Orang_Tua", null);
        if (!$this->No_Kontak_Orang_Tua->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->No_Kontak_Orang_Tua->Visible = false; // Disable update for API request
            } else {
                $this->No_Kontak_Orang_Tua->setFormValue($val);
            }
        }

        // Check field name 'userid' before field var 'x_userid'
        $val = $this->getFormValue("userid", null) ?? $this->getFormValue("x_userid", null);
        if (!$this->userid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->userid->Visible = false; // Disable update for API request
            } else {
                $this->userid->setFormValue($val);
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

        // Check field name 'tanggal_input' before field var 'x_tanggal_input'
        $val = $this->getFormValue("tanggal_input", null) ?? $this->getFormValue("x_tanggal_input", null);
        if (!$this->tanggal_input->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_input->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_input->setFormValue($val);
            }
            $this->tanggal_input->CurrentValue = UnformatDateTime($this->tanggal_input->CurrentValue, $this->tanggal_input->formatPattern());
        }
    }

    // Restore form values
    public function restoreFormValues(): void
    {
        $this->NIM->CurrentValue = $this->NIM->FormValue;
        $this->Nama->CurrentValue = $this->Nama->FormValue;
        $this->Jenis_Kelamin->CurrentValue = $this->Jenis_Kelamin->FormValue;
        $this->Provinsi_Tempat_Lahir->CurrentValue = $this->Provinsi_Tempat_Lahir->FormValue;
        $this->Kota_Tempat_Lahir->CurrentValue = $this->Kota_Tempat_Lahir->FormValue;
        $this->Tanggal_Lahir->CurrentValue = $this->Tanggal_Lahir->FormValue;
        $this->Tanggal_Lahir->CurrentValue = UnformatDateTime($this->Tanggal_Lahir->CurrentValue, $this->Tanggal_Lahir->formatPattern());
        $this->Golongan_Darah->CurrentValue = $this->Golongan_Darah->FormValue;
        $this->Tinggi_Badan->CurrentValue = $this->Tinggi_Badan->FormValue;
        $this->Berat_Badan->CurrentValue = $this->Berat_Badan->FormValue;
        $this->Asal_sekolah->CurrentValue = $this->Asal_sekolah->FormValue;
        $this->Tahun_Ijazah->CurrentValue = $this->Tahun_Ijazah->FormValue;
        $this->Nomor_Ijazah->CurrentValue = $this->Nomor_Ijazah->FormValue;
        $this->Nilai_Raport_Kelas_10->CurrentValue = $this->Nilai_Raport_Kelas_10->FormValue;
        $this->Nilai_Raport_Kelas_11->CurrentValue = $this->Nilai_Raport_Kelas_11->FormValue;
        $this->Nilai_Raport_Kelas_12->CurrentValue = $this->Nilai_Raport_Kelas_12->FormValue;
        $this->Tanggal_Daftar->CurrentValue = $this->Tanggal_Daftar->FormValue;
        $this->Tanggal_Daftar->CurrentValue = UnformatDateTime($this->Tanggal_Daftar->CurrentValue, $this->Tanggal_Daftar->formatPattern());
        $this->No_Test->CurrentValue = $this->No_Test->FormValue;
        $this->Status_Masuk->CurrentValue = $this->Status_Masuk->FormValue;
        $this->Jalur_Masuk->CurrentValue = $this->Jalur_Masuk->FormValue;
        $this->Bukti_Lulus->CurrentValue = $this->Bukti_Lulus->FormValue;
        $this->Tes_Potensi_Akademik->CurrentValue = $this->Tes_Potensi_Akademik->FormValue;
        $this->Tes_Wawancara->CurrentValue = $this->Tes_Wawancara->FormValue;
        $this->Tes_Kesehatan->CurrentValue = $this->Tes_Kesehatan->FormValue;
        $this->Hasil_Test_Kesehatan->CurrentValue = $this->Hasil_Test_Kesehatan->FormValue;
        $this->Test_MMPI->CurrentValue = $this->Test_MMPI->FormValue;
        $this->Hasil_Test_MMPI->CurrentValue = $this->Hasil_Test_MMPI->FormValue;
        $this->Angkatan->CurrentValue = $this->Angkatan->FormValue;
        $this->Tarif_SPP->CurrentValue = $this->Tarif_SPP->FormValue;
        $this->NIK_No_KTP->CurrentValue = $this->NIK_No_KTP->FormValue;
        $this->No_KK->CurrentValue = $this->No_KK->FormValue;
        $this->NPWP->CurrentValue = $this->NPWP->FormValue;
        $this->Status_Nikah->CurrentValue = $this->Status_Nikah->FormValue;
        $this->Kewarganegaraan->CurrentValue = $this->Kewarganegaraan->FormValue;
        $this->Propinsi_Tempat_Tinggal->CurrentValue = $this->Propinsi_Tempat_Tinggal->FormValue;
        $this->Kota_Tempat_Tinggal->CurrentValue = $this->Kota_Tempat_Tinggal->FormValue;
        $this->Kecamatan_Tempat_Tinggal->CurrentValue = $this->Kecamatan_Tempat_Tinggal->FormValue;
        $this->Alamat_Tempat_Tinggal->CurrentValue = $this->Alamat_Tempat_Tinggal->FormValue;
        $this->RT->CurrentValue = $this->RT->FormValue;
        $this->RW->CurrentValue = $this->RW->FormValue;
        $this->Kelurahan->CurrentValue = $this->Kelurahan->FormValue;
        $this->Kode_Pos->CurrentValue = $this->Kode_Pos->FormValue;
        $this->Nomor_Telpon_HP->CurrentValue = $this->Nomor_Telpon_HP->FormValue;
        $this->_Email->CurrentValue = $this->_Email->FormValue;
        $this->Jenis_Tinggal->CurrentValue = $this->Jenis_Tinggal->FormValue;
        $this->Alat_Transportasi->CurrentValue = $this->Alat_Transportasi->FormValue;
        $this->Sumber_Dana->CurrentValue = $this->Sumber_Dana->FormValue;
        $this->Sumber_Dana_Beasiswa->CurrentValue = $this->Sumber_Dana_Beasiswa->FormValue;
        $this->Jumlah_Sudara->CurrentValue = $this->Jumlah_Sudara->FormValue;
        $this->Status_Bekerja->CurrentValue = $this->Status_Bekerja->FormValue;
        $this->Nomor_Asuransi->CurrentValue = $this->Nomor_Asuransi->FormValue;
        $this->Hobi->CurrentValue = $this->Hobi->FormValue;
        $this->Foto->CurrentValue = $this->Foto->FormValue;
        $this->Nama_Ayah->CurrentValue = $this->Nama_Ayah->FormValue;
        $this->Pekerjaan_Ayah->CurrentValue = $this->Pekerjaan_Ayah->FormValue;
        $this->Nama_Ibu->CurrentValue = $this->Nama_Ibu->FormValue;
        $this->Pekerjaan_Ibu->CurrentValue = $this->Pekerjaan_Ibu->FormValue;
        $this->Alamat_Orang_Tua->CurrentValue = $this->Alamat_Orang_Tua->FormValue;
        $this->e_mail_Oranng_Tua->CurrentValue = $this->e_mail_Oranng_Tua->FormValue;
        $this->No_Kontak_Orang_Tua->CurrentValue = $this->No_Kontak_Orang_Tua->FormValue;
        $this->userid->CurrentValue = $this->userid->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->ip->CurrentValue = $this->ip->FormValue;
        $this->tanggal_input->CurrentValue = $this->tanggal_input->FormValue;
        $this->tanggal_input->CurrentValue = UnformatDateTime($this->tanggal_input->CurrentValue, $this->tanggal_input->formatPattern());
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // NIM
        $this->NIM->RowCssClass = "row";

        // Nama
        $this->Nama->RowCssClass = "row";

        // Jenis_Kelamin
        $this->Jenis_Kelamin->RowCssClass = "row";

        // Provinsi_Tempat_Lahir
        $this->Provinsi_Tempat_Lahir->RowCssClass = "row";

        // Kota_Tempat_Lahir
        $this->Kota_Tempat_Lahir->RowCssClass = "row";

        // Tanggal_Lahir
        $this->Tanggal_Lahir->RowCssClass = "row";

        // Golongan_Darah
        $this->Golongan_Darah->RowCssClass = "row";

        // Tinggi_Badan
        $this->Tinggi_Badan->RowCssClass = "row";

        // Berat_Badan
        $this->Berat_Badan->RowCssClass = "row";

        // Asal_sekolah
        $this->Asal_sekolah->RowCssClass = "row";

        // Tahun_Ijazah
        $this->Tahun_Ijazah->RowCssClass = "row";

        // Nomor_Ijazah
        $this->Nomor_Ijazah->RowCssClass = "row";

        // Nilai_Raport_Kelas_10
        $this->Nilai_Raport_Kelas_10->RowCssClass = "row";

        // Nilai_Raport_Kelas_11
        $this->Nilai_Raport_Kelas_11->RowCssClass = "row";

        // Nilai_Raport_Kelas_12
        $this->Nilai_Raport_Kelas_12->RowCssClass = "row";

        // Tanggal_Daftar
        $this->Tanggal_Daftar->RowCssClass = "row";

        // No_Test
        $this->No_Test->RowCssClass = "row";

        // Status_Masuk
        $this->Status_Masuk->RowCssClass = "row";

        // Jalur_Masuk
        $this->Jalur_Masuk->RowCssClass = "row";

        // Bukti_Lulus
        $this->Bukti_Lulus->RowCssClass = "row";

        // Tes_Potensi_Akademik
        $this->Tes_Potensi_Akademik->RowCssClass = "row";

        // Tes_Wawancara
        $this->Tes_Wawancara->RowCssClass = "row";

        // Tes_Kesehatan
        $this->Tes_Kesehatan->RowCssClass = "row";

        // Hasil_Test_Kesehatan
        $this->Hasil_Test_Kesehatan->RowCssClass = "row";

        // Test_MMPI
        $this->Test_MMPI->RowCssClass = "row";

        // Hasil_Test_MMPI
        $this->Hasil_Test_MMPI->RowCssClass = "row";

        // Angkatan
        $this->Angkatan->RowCssClass = "row";

        // Tarif_SPP
        $this->Tarif_SPP->RowCssClass = "row";

        // NIK_No_KTP
        $this->NIK_No_KTP->RowCssClass = "row";

        // No_KK
        $this->No_KK->RowCssClass = "row";

        // NPWP
        $this->NPWP->RowCssClass = "row";

        // Status_Nikah
        $this->Status_Nikah->RowCssClass = "row";

        // Kewarganegaraan
        $this->Kewarganegaraan->RowCssClass = "row";

        // Propinsi_Tempat_Tinggal
        $this->Propinsi_Tempat_Tinggal->RowCssClass = "row";

        // Kota_Tempat_Tinggal
        $this->Kota_Tempat_Tinggal->RowCssClass = "row";

        // Kecamatan_Tempat_Tinggal
        $this->Kecamatan_Tempat_Tinggal->RowCssClass = "row";

        // Alamat_Tempat_Tinggal
        $this->Alamat_Tempat_Tinggal->RowCssClass = "row";

        // RT
        $this->RT->RowCssClass = "row";

        // RW
        $this->RW->RowCssClass = "row";

        // Kelurahan
        $this->Kelurahan->RowCssClass = "row";

        // Kode_Pos
        $this->Kode_Pos->RowCssClass = "row";

        // Nomor_Telpon_HP
        $this->Nomor_Telpon_HP->RowCssClass = "row";

        // Email
        $this->_Email->RowCssClass = "row";

        // Jenis_Tinggal
        $this->Jenis_Tinggal->RowCssClass = "row";

        // Alat_Transportasi
        $this->Alat_Transportasi->RowCssClass = "row";

        // Sumber_Dana
        $this->Sumber_Dana->RowCssClass = "row";

        // Sumber_Dana_Beasiswa
        $this->Sumber_Dana_Beasiswa->RowCssClass = "row";

        // Jumlah_Sudara
        $this->Jumlah_Sudara->RowCssClass = "row";

        // Status_Bekerja
        $this->Status_Bekerja->RowCssClass = "row";

        // Nomor_Asuransi
        $this->Nomor_Asuransi->RowCssClass = "row";

        // Hobi
        $this->Hobi->RowCssClass = "row";

        // Foto
        $this->Foto->RowCssClass = "row";

        // Nama_Ayah
        $this->Nama_Ayah->RowCssClass = "row";

        // Pekerjaan_Ayah
        $this->Pekerjaan_Ayah->RowCssClass = "row";

        // Nama_Ibu
        $this->Nama_Ibu->RowCssClass = "row";

        // Pekerjaan_Ibu
        $this->Pekerjaan_Ibu->RowCssClass = "row";

        // Alamat_Orang_Tua
        $this->Alamat_Orang_Tua->RowCssClass = "row";

        // e_mail_Oranng_Tua
        $this->e_mail_Oranng_Tua->RowCssClass = "row";

        // No_Kontak_Orang_Tua
        $this->No_Kontak_Orang_Tua->RowCssClass = "row";

        // userid
        $this->userid->RowCssClass = "row";

        // user
        $this->user->RowCssClass = "row";

        // ip
        $this->ip->RowCssClass = "row";

        // tanggal_input
        $this->tanggal_input->RowCssClass = "row";

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

            // Nama
            $this->Nama->HrefValue = "";

            // Jenis_Kelamin
            $this->Jenis_Kelamin->HrefValue = "";

            // Provinsi_Tempat_Lahir
            $this->Provinsi_Tempat_Lahir->HrefValue = "";

            // Kota_Tempat_Lahir
            $this->Kota_Tempat_Lahir->HrefValue = "";

            // Tanggal_Lahir
            $this->Tanggal_Lahir->HrefValue = "";

            // Golongan_Darah
            $this->Golongan_Darah->HrefValue = "";

            // Tinggi_Badan
            $this->Tinggi_Badan->HrefValue = "";

            // Berat_Badan
            $this->Berat_Badan->HrefValue = "";

            // Asal_sekolah
            $this->Asal_sekolah->HrefValue = "";

            // Tahun_Ijazah
            $this->Tahun_Ijazah->HrefValue = "";

            // Nomor_Ijazah
            $this->Nomor_Ijazah->HrefValue = "";

            // Nilai_Raport_Kelas_10
            $this->Nilai_Raport_Kelas_10->HrefValue = "";

            // Nilai_Raport_Kelas_11
            $this->Nilai_Raport_Kelas_11->HrefValue = "";

            // Nilai_Raport_Kelas_12
            $this->Nilai_Raport_Kelas_12->HrefValue = "";

            // Tanggal_Daftar
            $this->Tanggal_Daftar->HrefValue = "";

            // No_Test
            $this->No_Test->HrefValue = "";

            // Status_Masuk
            $this->Status_Masuk->HrefValue = "";

            // Jalur_Masuk
            $this->Jalur_Masuk->HrefValue = "";

            // Bukti_Lulus
            $this->Bukti_Lulus->HrefValue = "";

            // Tes_Potensi_Akademik
            $this->Tes_Potensi_Akademik->HrefValue = "";

            // Tes_Wawancara
            $this->Tes_Wawancara->HrefValue = "";

            // Tes_Kesehatan
            $this->Tes_Kesehatan->HrefValue = "";

            // Hasil_Test_Kesehatan
            $this->Hasil_Test_Kesehatan->HrefValue = "";

            // Test_MMPI
            $this->Test_MMPI->HrefValue = "";

            // Hasil_Test_MMPI
            $this->Hasil_Test_MMPI->HrefValue = "";

            // Angkatan
            $this->Angkatan->HrefValue = "";

            // Tarif_SPP
            $this->Tarif_SPP->HrefValue = "";

            // NIK_No_KTP
            $this->NIK_No_KTP->HrefValue = "";

            // No_KK
            $this->No_KK->HrefValue = "";

            // NPWP
            $this->NPWP->HrefValue = "";

            // Status_Nikah
            $this->Status_Nikah->HrefValue = "";

            // Kewarganegaraan
            $this->Kewarganegaraan->HrefValue = "";

            // Propinsi_Tempat_Tinggal
            $this->Propinsi_Tempat_Tinggal->HrefValue = "";

            // Kota_Tempat_Tinggal
            $this->Kota_Tempat_Tinggal->HrefValue = "";

            // Kecamatan_Tempat_Tinggal
            $this->Kecamatan_Tempat_Tinggal->HrefValue = "";

            // Alamat_Tempat_Tinggal
            $this->Alamat_Tempat_Tinggal->HrefValue = "";

            // RT
            $this->RT->HrefValue = "";

            // RW
            $this->RW->HrefValue = "";

            // Kelurahan
            $this->Kelurahan->HrefValue = "";

            // Kode_Pos
            $this->Kode_Pos->HrefValue = "";

            // Nomor_Telpon_HP
            $this->Nomor_Telpon_HP->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // Jenis_Tinggal
            $this->Jenis_Tinggal->HrefValue = "";

            // Alat_Transportasi
            $this->Alat_Transportasi->HrefValue = "";

            // Sumber_Dana
            $this->Sumber_Dana->HrefValue = "";

            // Sumber_Dana_Beasiswa
            $this->Sumber_Dana_Beasiswa->HrefValue = "";

            // Jumlah_Sudara
            $this->Jumlah_Sudara->HrefValue = "";

            // Status_Bekerja
            $this->Status_Bekerja->HrefValue = "";

            // Nomor_Asuransi
            $this->Nomor_Asuransi->HrefValue = "";

            // Hobi
            $this->Hobi->HrefValue = "";

            // Foto
            $this->Foto->HrefValue = "";

            // Nama_Ayah
            $this->Nama_Ayah->HrefValue = "";

            // Pekerjaan_Ayah
            $this->Pekerjaan_Ayah->HrefValue = "";

            // Nama_Ibu
            $this->Nama_Ibu->HrefValue = "";

            // Pekerjaan_Ibu
            $this->Pekerjaan_Ibu->HrefValue = "";

            // Alamat_Orang_Tua
            $this->Alamat_Orang_Tua->HrefValue = "";

            // e_mail_Oranng_Tua
            $this->e_mail_Oranng_Tua->HrefValue = "";

            // No_Kontak_Orang_Tua
            $this->No_Kontak_Orang_Tua->HrefValue = "";

            // userid
            $this->userid->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";

            // tanggal_input
            $this->tanggal_input->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // NIM
            $this->NIM->setupEditAttributes();
            $this->NIM->EditValue = !$this->NIM->Raw ? HtmlDecode($this->NIM->CurrentValue) : $this->NIM->CurrentValue;
            $this->NIM->PlaceHolder = RemoveHtml($this->NIM->caption());

            // Nama
            $this->Nama->setupEditAttributes();
            $this->Nama->EditValue = !$this->Nama->Raw ? HtmlDecode($this->Nama->CurrentValue) : $this->Nama->CurrentValue;
            $this->Nama->PlaceHolder = RemoveHtml($this->Nama->caption());

            // Jenis_Kelamin
            $this->Jenis_Kelamin->setupEditAttributes();
            $this->Jenis_Kelamin->EditValue = !$this->Jenis_Kelamin->Raw ? HtmlDecode($this->Jenis_Kelamin->CurrentValue) : $this->Jenis_Kelamin->CurrentValue;
            $this->Jenis_Kelamin->PlaceHolder = RemoveHtml($this->Jenis_Kelamin->caption());

            // Provinsi_Tempat_Lahir
            $this->Provinsi_Tempat_Lahir->setupEditAttributes();
            $this->Provinsi_Tempat_Lahir->EditValue = !$this->Provinsi_Tempat_Lahir->Raw ? HtmlDecode($this->Provinsi_Tempat_Lahir->CurrentValue) : $this->Provinsi_Tempat_Lahir->CurrentValue;
            $this->Provinsi_Tempat_Lahir->PlaceHolder = RemoveHtml($this->Provinsi_Tempat_Lahir->caption());

            // Kota_Tempat_Lahir
            $this->Kota_Tempat_Lahir->setupEditAttributes();
            $this->Kota_Tempat_Lahir->EditValue = !$this->Kota_Tempat_Lahir->Raw ? HtmlDecode($this->Kota_Tempat_Lahir->CurrentValue) : $this->Kota_Tempat_Lahir->CurrentValue;
            $this->Kota_Tempat_Lahir->PlaceHolder = RemoveHtml($this->Kota_Tempat_Lahir->caption());

            // Tanggal_Lahir
            $this->Tanggal_Lahir->setupEditAttributes();
            $this->Tanggal_Lahir->EditValue = FormatDateTime($this->Tanggal_Lahir->CurrentValue, $this->Tanggal_Lahir->formatPattern());
            $this->Tanggal_Lahir->PlaceHolder = RemoveHtml($this->Tanggal_Lahir->caption());

            // Golongan_Darah
            $this->Golongan_Darah->setupEditAttributes();
            $this->Golongan_Darah->EditValue = !$this->Golongan_Darah->Raw ? HtmlDecode($this->Golongan_Darah->CurrentValue) : $this->Golongan_Darah->CurrentValue;
            $this->Golongan_Darah->PlaceHolder = RemoveHtml($this->Golongan_Darah->caption());

            // Tinggi_Badan
            $this->Tinggi_Badan->setupEditAttributes();
            $this->Tinggi_Badan->EditValue = !$this->Tinggi_Badan->Raw ? HtmlDecode($this->Tinggi_Badan->CurrentValue) : $this->Tinggi_Badan->CurrentValue;
            $this->Tinggi_Badan->PlaceHolder = RemoveHtml($this->Tinggi_Badan->caption());

            // Berat_Badan
            $this->Berat_Badan->setupEditAttributes();
            $this->Berat_Badan->EditValue = !$this->Berat_Badan->Raw ? HtmlDecode($this->Berat_Badan->CurrentValue) : $this->Berat_Badan->CurrentValue;
            $this->Berat_Badan->PlaceHolder = RemoveHtml($this->Berat_Badan->caption());

            // Asal_sekolah
            $this->Asal_sekolah->setupEditAttributes();
            $this->Asal_sekolah->EditValue = !$this->Asal_sekolah->Raw ? HtmlDecode($this->Asal_sekolah->CurrentValue) : $this->Asal_sekolah->CurrentValue;
            $this->Asal_sekolah->PlaceHolder = RemoveHtml($this->Asal_sekolah->caption());

            // Tahun_Ijazah
            $this->Tahun_Ijazah->setupEditAttributes();
            $this->Tahun_Ijazah->EditValue = !$this->Tahun_Ijazah->Raw ? HtmlDecode($this->Tahun_Ijazah->CurrentValue) : $this->Tahun_Ijazah->CurrentValue;
            $this->Tahun_Ijazah->PlaceHolder = RemoveHtml($this->Tahun_Ijazah->caption());

            // Nomor_Ijazah
            $this->Nomor_Ijazah->setupEditAttributes();
            $this->Nomor_Ijazah->EditValue = !$this->Nomor_Ijazah->Raw ? HtmlDecode($this->Nomor_Ijazah->CurrentValue) : $this->Nomor_Ijazah->CurrentValue;
            $this->Nomor_Ijazah->PlaceHolder = RemoveHtml($this->Nomor_Ijazah->caption());

            // Nilai_Raport_Kelas_10
            $this->Nilai_Raport_Kelas_10->setupEditAttributes();
            $this->Nilai_Raport_Kelas_10->EditValue = $this->Nilai_Raport_Kelas_10->CurrentValue;
            $this->Nilai_Raport_Kelas_10->PlaceHolder = RemoveHtml($this->Nilai_Raport_Kelas_10->caption());
            if (strval($this->Nilai_Raport_Kelas_10->EditValue) != "" && is_numeric($this->Nilai_Raport_Kelas_10->EditValue)) {
                $this->Nilai_Raport_Kelas_10->EditValue = FormatNumber($this->Nilai_Raport_Kelas_10->EditValue, null);
            }

            // Nilai_Raport_Kelas_11
            $this->Nilai_Raport_Kelas_11->setupEditAttributes();
            $this->Nilai_Raport_Kelas_11->EditValue = $this->Nilai_Raport_Kelas_11->CurrentValue;
            $this->Nilai_Raport_Kelas_11->PlaceHolder = RemoveHtml($this->Nilai_Raport_Kelas_11->caption());
            if (strval($this->Nilai_Raport_Kelas_11->EditValue) != "" && is_numeric($this->Nilai_Raport_Kelas_11->EditValue)) {
                $this->Nilai_Raport_Kelas_11->EditValue = FormatNumber($this->Nilai_Raport_Kelas_11->EditValue, null);
            }

            // Nilai_Raport_Kelas_12
            $this->Nilai_Raport_Kelas_12->setupEditAttributes();
            $this->Nilai_Raport_Kelas_12->EditValue = $this->Nilai_Raport_Kelas_12->CurrentValue;
            $this->Nilai_Raport_Kelas_12->PlaceHolder = RemoveHtml($this->Nilai_Raport_Kelas_12->caption());
            if (strval($this->Nilai_Raport_Kelas_12->EditValue) != "" && is_numeric($this->Nilai_Raport_Kelas_12->EditValue)) {
                $this->Nilai_Raport_Kelas_12->EditValue = FormatNumber($this->Nilai_Raport_Kelas_12->EditValue, null);
            }

            // Tanggal_Daftar
            $this->Tanggal_Daftar->setupEditAttributes();
            $this->Tanggal_Daftar->EditValue = FormatDateTime($this->Tanggal_Daftar->CurrentValue, $this->Tanggal_Daftar->formatPattern());
            $this->Tanggal_Daftar->PlaceHolder = RemoveHtml($this->Tanggal_Daftar->caption());

            // No_Test
            $this->No_Test->setupEditAttributes();
            $this->No_Test->EditValue = !$this->No_Test->Raw ? HtmlDecode($this->No_Test->CurrentValue) : $this->No_Test->CurrentValue;
            $this->No_Test->PlaceHolder = RemoveHtml($this->No_Test->caption());

            // Status_Masuk
            $this->Status_Masuk->setupEditAttributes();
            $this->Status_Masuk->EditValue = !$this->Status_Masuk->Raw ? HtmlDecode($this->Status_Masuk->CurrentValue) : $this->Status_Masuk->CurrentValue;
            $this->Status_Masuk->PlaceHolder = RemoveHtml($this->Status_Masuk->caption());

            // Jalur_Masuk
            $this->Jalur_Masuk->setupEditAttributes();
            $this->Jalur_Masuk->EditValue = !$this->Jalur_Masuk->Raw ? HtmlDecode($this->Jalur_Masuk->CurrentValue) : $this->Jalur_Masuk->CurrentValue;
            $this->Jalur_Masuk->PlaceHolder = RemoveHtml($this->Jalur_Masuk->caption());

            // Bukti_Lulus
            $this->Bukti_Lulus->setupEditAttributes();
            $this->Bukti_Lulus->EditValue = !$this->Bukti_Lulus->Raw ? HtmlDecode($this->Bukti_Lulus->CurrentValue) : $this->Bukti_Lulus->CurrentValue;
            $this->Bukti_Lulus->PlaceHolder = RemoveHtml($this->Bukti_Lulus->caption());

            // Tes_Potensi_Akademik
            $this->Tes_Potensi_Akademik->setupEditAttributes();
            $this->Tes_Potensi_Akademik->EditValue = $this->Tes_Potensi_Akademik->CurrentValue;
            $this->Tes_Potensi_Akademik->PlaceHolder = RemoveHtml($this->Tes_Potensi_Akademik->caption());
            if (strval($this->Tes_Potensi_Akademik->EditValue) != "" && is_numeric($this->Tes_Potensi_Akademik->EditValue)) {
                $this->Tes_Potensi_Akademik->EditValue = FormatNumber($this->Tes_Potensi_Akademik->EditValue, null);
            }

            // Tes_Wawancara
            $this->Tes_Wawancara->setupEditAttributes();
            $this->Tes_Wawancara->EditValue = $this->Tes_Wawancara->CurrentValue;
            $this->Tes_Wawancara->PlaceHolder = RemoveHtml($this->Tes_Wawancara->caption());
            if (strval($this->Tes_Wawancara->EditValue) != "" && is_numeric($this->Tes_Wawancara->EditValue)) {
                $this->Tes_Wawancara->EditValue = FormatNumber($this->Tes_Wawancara->EditValue, null);
            }

            // Tes_Kesehatan
            $this->Tes_Kesehatan->setupEditAttributes();
            $this->Tes_Kesehatan->EditValue = $this->Tes_Kesehatan->CurrentValue;
            $this->Tes_Kesehatan->PlaceHolder = RemoveHtml($this->Tes_Kesehatan->caption());
            if (strval($this->Tes_Kesehatan->EditValue) != "" && is_numeric($this->Tes_Kesehatan->EditValue)) {
                $this->Tes_Kesehatan->EditValue = FormatNumber($this->Tes_Kesehatan->EditValue, null);
            }

            // Hasil_Test_Kesehatan
            $this->Hasil_Test_Kesehatan->setupEditAttributes();
            $this->Hasil_Test_Kesehatan->EditValue = !$this->Hasil_Test_Kesehatan->Raw ? HtmlDecode($this->Hasil_Test_Kesehatan->CurrentValue) : $this->Hasil_Test_Kesehatan->CurrentValue;
            $this->Hasil_Test_Kesehatan->PlaceHolder = RemoveHtml($this->Hasil_Test_Kesehatan->caption());

            // Test_MMPI
            $this->Test_MMPI->setupEditAttributes();
            $this->Test_MMPI->EditValue = $this->Test_MMPI->CurrentValue;
            $this->Test_MMPI->PlaceHolder = RemoveHtml($this->Test_MMPI->caption());
            if (strval($this->Test_MMPI->EditValue) != "" && is_numeric($this->Test_MMPI->EditValue)) {
                $this->Test_MMPI->EditValue = FormatNumber($this->Test_MMPI->EditValue, null);
            }

            // Hasil_Test_MMPI
            $this->Hasil_Test_MMPI->setupEditAttributes();
            $this->Hasil_Test_MMPI->EditValue = !$this->Hasil_Test_MMPI->Raw ? HtmlDecode($this->Hasil_Test_MMPI->CurrentValue) : $this->Hasil_Test_MMPI->CurrentValue;
            $this->Hasil_Test_MMPI->PlaceHolder = RemoveHtml($this->Hasil_Test_MMPI->caption());

            // Angkatan
            $this->Angkatan->setupEditAttributes();
            $this->Angkatan->EditValue = !$this->Angkatan->Raw ? HtmlDecode($this->Angkatan->CurrentValue) : $this->Angkatan->CurrentValue;
            $this->Angkatan->PlaceHolder = RemoveHtml($this->Angkatan->caption());

            // Tarif_SPP
            $this->Tarif_SPP->setupEditAttributes();
            $this->Tarif_SPP->EditValue = $this->Tarif_SPP->CurrentValue;
            $this->Tarif_SPP->PlaceHolder = RemoveHtml($this->Tarif_SPP->caption());
            if (strval($this->Tarif_SPP->EditValue) != "" && is_numeric($this->Tarif_SPP->EditValue)) {
                $this->Tarif_SPP->EditValue = FormatNumber($this->Tarif_SPP->EditValue, null);
            }

            // NIK_No_KTP
            $this->NIK_No_KTP->setupEditAttributes();
            $this->NIK_No_KTP->EditValue = !$this->NIK_No_KTP->Raw ? HtmlDecode($this->NIK_No_KTP->CurrentValue) : $this->NIK_No_KTP->CurrentValue;
            $this->NIK_No_KTP->PlaceHolder = RemoveHtml($this->NIK_No_KTP->caption());

            // No_KK
            $this->No_KK->setupEditAttributes();
            $this->No_KK->EditValue = !$this->No_KK->Raw ? HtmlDecode($this->No_KK->CurrentValue) : $this->No_KK->CurrentValue;
            $this->No_KK->PlaceHolder = RemoveHtml($this->No_KK->caption());

            // NPWP
            $this->NPWP->setupEditAttributes();
            $this->NPWP->EditValue = !$this->NPWP->Raw ? HtmlDecode($this->NPWP->CurrentValue) : $this->NPWP->CurrentValue;
            $this->NPWP->PlaceHolder = RemoveHtml($this->NPWP->caption());

            // Status_Nikah
            $this->Status_Nikah->setupEditAttributes();
            $this->Status_Nikah->EditValue = !$this->Status_Nikah->Raw ? HtmlDecode($this->Status_Nikah->CurrentValue) : $this->Status_Nikah->CurrentValue;
            $this->Status_Nikah->PlaceHolder = RemoveHtml($this->Status_Nikah->caption());

            // Kewarganegaraan
            $this->Kewarganegaraan->setupEditAttributes();
            $this->Kewarganegaraan->EditValue = !$this->Kewarganegaraan->Raw ? HtmlDecode($this->Kewarganegaraan->CurrentValue) : $this->Kewarganegaraan->CurrentValue;
            $this->Kewarganegaraan->PlaceHolder = RemoveHtml($this->Kewarganegaraan->caption());

            // Propinsi_Tempat_Tinggal
            $this->Propinsi_Tempat_Tinggal->setupEditAttributes();
            $this->Propinsi_Tempat_Tinggal->EditValue = !$this->Propinsi_Tempat_Tinggal->Raw ? HtmlDecode($this->Propinsi_Tempat_Tinggal->CurrentValue) : $this->Propinsi_Tempat_Tinggal->CurrentValue;
            $this->Propinsi_Tempat_Tinggal->PlaceHolder = RemoveHtml($this->Propinsi_Tempat_Tinggal->caption());

            // Kota_Tempat_Tinggal
            $this->Kota_Tempat_Tinggal->setupEditAttributes();
            $this->Kota_Tempat_Tinggal->EditValue = !$this->Kota_Tempat_Tinggal->Raw ? HtmlDecode($this->Kota_Tempat_Tinggal->CurrentValue) : $this->Kota_Tempat_Tinggal->CurrentValue;
            $this->Kota_Tempat_Tinggal->PlaceHolder = RemoveHtml($this->Kota_Tempat_Tinggal->caption());

            // Kecamatan_Tempat_Tinggal
            $this->Kecamatan_Tempat_Tinggal->setupEditAttributes();
            $this->Kecamatan_Tempat_Tinggal->EditValue = !$this->Kecamatan_Tempat_Tinggal->Raw ? HtmlDecode($this->Kecamatan_Tempat_Tinggal->CurrentValue) : $this->Kecamatan_Tempat_Tinggal->CurrentValue;
            $this->Kecamatan_Tempat_Tinggal->PlaceHolder = RemoveHtml($this->Kecamatan_Tempat_Tinggal->caption());

            // Alamat_Tempat_Tinggal
            $this->Alamat_Tempat_Tinggal->setupEditAttributes();
            $this->Alamat_Tempat_Tinggal->EditValue = !$this->Alamat_Tempat_Tinggal->Raw ? HtmlDecode($this->Alamat_Tempat_Tinggal->CurrentValue) : $this->Alamat_Tempat_Tinggal->CurrentValue;
            $this->Alamat_Tempat_Tinggal->PlaceHolder = RemoveHtml($this->Alamat_Tempat_Tinggal->caption());

            // RT
            $this->RT->setupEditAttributes();
            $this->RT->EditValue = !$this->RT->Raw ? HtmlDecode($this->RT->CurrentValue) : $this->RT->CurrentValue;
            $this->RT->PlaceHolder = RemoveHtml($this->RT->caption());

            // RW
            $this->RW->setupEditAttributes();
            $this->RW->EditValue = !$this->RW->Raw ? HtmlDecode($this->RW->CurrentValue) : $this->RW->CurrentValue;
            $this->RW->PlaceHolder = RemoveHtml($this->RW->caption());

            // Kelurahan
            $this->Kelurahan->setupEditAttributes();
            $this->Kelurahan->EditValue = !$this->Kelurahan->Raw ? HtmlDecode($this->Kelurahan->CurrentValue) : $this->Kelurahan->CurrentValue;
            $this->Kelurahan->PlaceHolder = RemoveHtml($this->Kelurahan->caption());

            // Kode_Pos
            $this->Kode_Pos->setupEditAttributes();
            $this->Kode_Pos->EditValue = !$this->Kode_Pos->Raw ? HtmlDecode($this->Kode_Pos->CurrentValue) : $this->Kode_Pos->CurrentValue;
            $this->Kode_Pos->PlaceHolder = RemoveHtml($this->Kode_Pos->caption());

            // Nomor_Telpon_HP
            $this->Nomor_Telpon_HP->setupEditAttributes();
            $this->Nomor_Telpon_HP->EditValue = !$this->Nomor_Telpon_HP->Raw ? HtmlDecode($this->Nomor_Telpon_HP->CurrentValue) : $this->Nomor_Telpon_HP->CurrentValue;
            $this->Nomor_Telpon_HP->PlaceHolder = RemoveHtml($this->Nomor_Telpon_HP->caption());

            // Email
            $this->_Email->setupEditAttributes();
            $this->_Email->EditValue = !$this->_Email->Raw ? HtmlDecode($this->_Email->CurrentValue) : $this->_Email->CurrentValue;
            $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

            // Jenis_Tinggal
            $this->Jenis_Tinggal->setupEditAttributes();
            $this->Jenis_Tinggal->EditValue = !$this->Jenis_Tinggal->Raw ? HtmlDecode($this->Jenis_Tinggal->CurrentValue) : $this->Jenis_Tinggal->CurrentValue;
            $this->Jenis_Tinggal->PlaceHolder = RemoveHtml($this->Jenis_Tinggal->caption());

            // Alat_Transportasi
            $this->Alat_Transportasi->setupEditAttributes();
            $this->Alat_Transportasi->EditValue = !$this->Alat_Transportasi->Raw ? HtmlDecode($this->Alat_Transportasi->CurrentValue) : $this->Alat_Transportasi->CurrentValue;
            $this->Alat_Transportasi->PlaceHolder = RemoveHtml($this->Alat_Transportasi->caption());

            // Sumber_Dana
            $this->Sumber_Dana->setupEditAttributes();
            $this->Sumber_Dana->EditValue = !$this->Sumber_Dana->Raw ? HtmlDecode($this->Sumber_Dana->CurrentValue) : $this->Sumber_Dana->CurrentValue;
            $this->Sumber_Dana->PlaceHolder = RemoveHtml($this->Sumber_Dana->caption());

            // Sumber_Dana_Beasiswa
            $this->Sumber_Dana_Beasiswa->setupEditAttributes();
            $this->Sumber_Dana_Beasiswa->EditValue = !$this->Sumber_Dana_Beasiswa->Raw ? HtmlDecode($this->Sumber_Dana_Beasiswa->CurrentValue) : $this->Sumber_Dana_Beasiswa->CurrentValue;
            $this->Sumber_Dana_Beasiswa->PlaceHolder = RemoveHtml($this->Sumber_Dana_Beasiswa->caption());

            // Jumlah_Sudara
            $this->Jumlah_Sudara->setupEditAttributes();
            $this->Jumlah_Sudara->EditValue = !$this->Jumlah_Sudara->Raw ? HtmlDecode($this->Jumlah_Sudara->CurrentValue) : $this->Jumlah_Sudara->CurrentValue;
            $this->Jumlah_Sudara->PlaceHolder = RemoveHtml($this->Jumlah_Sudara->caption());

            // Status_Bekerja
            $this->Status_Bekerja->setupEditAttributes();
            $this->Status_Bekerja->EditValue = !$this->Status_Bekerja->Raw ? HtmlDecode($this->Status_Bekerja->CurrentValue) : $this->Status_Bekerja->CurrentValue;
            $this->Status_Bekerja->PlaceHolder = RemoveHtml($this->Status_Bekerja->caption());

            // Nomor_Asuransi
            $this->Nomor_Asuransi->setupEditAttributes();
            $this->Nomor_Asuransi->EditValue = !$this->Nomor_Asuransi->Raw ? HtmlDecode($this->Nomor_Asuransi->CurrentValue) : $this->Nomor_Asuransi->CurrentValue;
            $this->Nomor_Asuransi->PlaceHolder = RemoveHtml($this->Nomor_Asuransi->caption());

            // Hobi
            $this->Hobi->setupEditAttributes();
            $this->Hobi->EditValue = !$this->Hobi->Raw ? HtmlDecode($this->Hobi->CurrentValue) : $this->Hobi->CurrentValue;
            $this->Hobi->PlaceHolder = RemoveHtml($this->Hobi->caption());

            // Foto
            $this->Foto->setupEditAttributes();
            $this->Foto->EditValue = !$this->Foto->Raw ? HtmlDecode($this->Foto->CurrentValue) : $this->Foto->CurrentValue;
            $this->Foto->PlaceHolder = RemoveHtml($this->Foto->caption());

            // Nama_Ayah
            $this->Nama_Ayah->setupEditAttributes();
            $this->Nama_Ayah->EditValue = !$this->Nama_Ayah->Raw ? HtmlDecode($this->Nama_Ayah->CurrentValue) : $this->Nama_Ayah->CurrentValue;
            $this->Nama_Ayah->PlaceHolder = RemoveHtml($this->Nama_Ayah->caption());

            // Pekerjaan_Ayah
            $this->Pekerjaan_Ayah->setupEditAttributes();
            $this->Pekerjaan_Ayah->EditValue = !$this->Pekerjaan_Ayah->Raw ? HtmlDecode($this->Pekerjaan_Ayah->CurrentValue) : $this->Pekerjaan_Ayah->CurrentValue;
            $this->Pekerjaan_Ayah->PlaceHolder = RemoveHtml($this->Pekerjaan_Ayah->caption());

            // Nama_Ibu
            $this->Nama_Ibu->setupEditAttributes();
            $this->Nama_Ibu->EditValue = !$this->Nama_Ibu->Raw ? HtmlDecode($this->Nama_Ibu->CurrentValue) : $this->Nama_Ibu->CurrentValue;
            $this->Nama_Ibu->PlaceHolder = RemoveHtml($this->Nama_Ibu->caption());

            // Pekerjaan_Ibu
            $this->Pekerjaan_Ibu->setupEditAttributes();
            $this->Pekerjaan_Ibu->EditValue = !$this->Pekerjaan_Ibu->Raw ? HtmlDecode($this->Pekerjaan_Ibu->CurrentValue) : $this->Pekerjaan_Ibu->CurrentValue;
            $this->Pekerjaan_Ibu->PlaceHolder = RemoveHtml($this->Pekerjaan_Ibu->caption());

            // Alamat_Orang_Tua
            $this->Alamat_Orang_Tua->setupEditAttributes();
            $this->Alamat_Orang_Tua->EditValue = !$this->Alamat_Orang_Tua->Raw ? HtmlDecode($this->Alamat_Orang_Tua->CurrentValue) : $this->Alamat_Orang_Tua->CurrentValue;
            $this->Alamat_Orang_Tua->PlaceHolder = RemoveHtml($this->Alamat_Orang_Tua->caption());

            // e_mail_Oranng_Tua
            $this->e_mail_Oranng_Tua->setupEditAttributes();
            $this->e_mail_Oranng_Tua->EditValue = !$this->e_mail_Oranng_Tua->Raw ? HtmlDecode($this->e_mail_Oranng_Tua->CurrentValue) : $this->e_mail_Oranng_Tua->CurrentValue;
            $this->e_mail_Oranng_Tua->PlaceHolder = RemoveHtml($this->e_mail_Oranng_Tua->caption());

            // No_Kontak_Orang_Tua
            $this->No_Kontak_Orang_Tua->setupEditAttributes();
            $this->No_Kontak_Orang_Tua->EditValue = !$this->No_Kontak_Orang_Tua->Raw ? HtmlDecode($this->No_Kontak_Orang_Tua->CurrentValue) : $this->No_Kontak_Orang_Tua->CurrentValue;
            $this->No_Kontak_Orang_Tua->PlaceHolder = RemoveHtml($this->No_Kontak_Orang_Tua->caption());

            // userid

            // user

            // ip

            // tanggal_input

            // Edit refer script

            // NIM
            $this->NIM->HrefValue = "";

            // Nama
            $this->Nama->HrefValue = "";

            // Jenis_Kelamin
            $this->Jenis_Kelamin->HrefValue = "";

            // Provinsi_Tempat_Lahir
            $this->Provinsi_Tempat_Lahir->HrefValue = "";

            // Kota_Tempat_Lahir
            $this->Kota_Tempat_Lahir->HrefValue = "";

            // Tanggal_Lahir
            $this->Tanggal_Lahir->HrefValue = "";

            // Golongan_Darah
            $this->Golongan_Darah->HrefValue = "";

            // Tinggi_Badan
            $this->Tinggi_Badan->HrefValue = "";

            // Berat_Badan
            $this->Berat_Badan->HrefValue = "";

            // Asal_sekolah
            $this->Asal_sekolah->HrefValue = "";

            // Tahun_Ijazah
            $this->Tahun_Ijazah->HrefValue = "";

            // Nomor_Ijazah
            $this->Nomor_Ijazah->HrefValue = "";

            // Nilai_Raport_Kelas_10
            $this->Nilai_Raport_Kelas_10->HrefValue = "";

            // Nilai_Raport_Kelas_11
            $this->Nilai_Raport_Kelas_11->HrefValue = "";

            // Nilai_Raport_Kelas_12
            $this->Nilai_Raport_Kelas_12->HrefValue = "";

            // Tanggal_Daftar
            $this->Tanggal_Daftar->HrefValue = "";

            // No_Test
            $this->No_Test->HrefValue = "";

            // Status_Masuk
            $this->Status_Masuk->HrefValue = "";

            // Jalur_Masuk
            $this->Jalur_Masuk->HrefValue = "";

            // Bukti_Lulus
            $this->Bukti_Lulus->HrefValue = "";

            // Tes_Potensi_Akademik
            $this->Tes_Potensi_Akademik->HrefValue = "";

            // Tes_Wawancara
            $this->Tes_Wawancara->HrefValue = "";

            // Tes_Kesehatan
            $this->Tes_Kesehatan->HrefValue = "";

            // Hasil_Test_Kesehatan
            $this->Hasil_Test_Kesehatan->HrefValue = "";

            // Test_MMPI
            $this->Test_MMPI->HrefValue = "";

            // Hasil_Test_MMPI
            $this->Hasil_Test_MMPI->HrefValue = "";

            // Angkatan
            $this->Angkatan->HrefValue = "";

            // Tarif_SPP
            $this->Tarif_SPP->HrefValue = "";

            // NIK_No_KTP
            $this->NIK_No_KTP->HrefValue = "";

            // No_KK
            $this->No_KK->HrefValue = "";

            // NPWP
            $this->NPWP->HrefValue = "";

            // Status_Nikah
            $this->Status_Nikah->HrefValue = "";

            // Kewarganegaraan
            $this->Kewarganegaraan->HrefValue = "";

            // Propinsi_Tempat_Tinggal
            $this->Propinsi_Tempat_Tinggal->HrefValue = "";

            // Kota_Tempat_Tinggal
            $this->Kota_Tempat_Tinggal->HrefValue = "";

            // Kecamatan_Tempat_Tinggal
            $this->Kecamatan_Tempat_Tinggal->HrefValue = "";

            // Alamat_Tempat_Tinggal
            $this->Alamat_Tempat_Tinggal->HrefValue = "";

            // RT
            $this->RT->HrefValue = "";

            // RW
            $this->RW->HrefValue = "";

            // Kelurahan
            $this->Kelurahan->HrefValue = "";

            // Kode_Pos
            $this->Kode_Pos->HrefValue = "";

            // Nomor_Telpon_HP
            $this->Nomor_Telpon_HP->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // Jenis_Tinggal
            $this->Jenis_Tinggal->HrefValue = "";

            // Alat_Transportasi
            $this->Alat_Transportasi->HrefValue = "";

            // Sumber_Dana
            $this->Sumber_Dana->HrefValue = "";

            // Sumber_Dana_Beasiswa
            $this->Sumber_Dana_Beasiswa->HrefValue = "";

            // Jumlah_Sudara
            $this->Jumlah_Sudara->HrefValue = "";

            // Status_Bekerja
            $this->Status_Bekerja->HrefValue = "";

            // Nomor_Asuransi
            $this->Nomor_Asuransi->HrefValue = "";

            // Hobi
            $this->Hobi->HrefValue = "";

            // Foto
            $this->Foto->HrefValue = "";

            // Nama_Ayah
            $this->Nama_Ayah->HrefValue = "";

            // Pekerjaan_Ayah
            $this->Pekerjaan_Ayah->HrefValue = "";

            // Nama_Ibu
            $this->Nama_Ibu->HrefValue = "";

            // Pekerjaan_Ibu
            $this->Pekerjaan_Ibu->HrefValue = "";

            // Alamat_Orang_Tua
            $this->Alamat_Orang_Tua->HrefValue = "";

            // e_mail_Oranng_Tua
            $this->e_mail_Oranng_Tua->HrefValue = "";

            // No_Kontak_Orang_Tua
            $this->No_Kontak_Orang_Tua->HrefValue = "";

            // userid
            $this->userid->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // ip
            $this->ip->HrefValue = "";

            // tanggal_input
            $this->tanggal_input->HrefValue = "";
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
            if ($this->Nama->Visible && $this->Nama->Required) {
                if (!$this->Nama->IsDetailKey && IsEmpty($this->Nama->FormValue)) {
                    $this->Nama->addErrorMessage(str_replace("%s", $this->Nama->caption(), $this->Nama->RequiredErrorMessage));
                }
            }
            if ($this->Jenis_Kelamin->Visible && $this->Jenis_Kelamin->Required) {
                if (!$this->Jenis_Kelamin->IsDetailKey && IsEmpty($this->Jenis_Kelamin->FormValue)) {
                    $this->Jenis_Kelamin->addErrorMessage(str_replace("%s", $this->Jenis_Kelamin->caption(), $this->Jenis_Kelamin->RequiredErrorMessage));
                }
            }
            if ($this->Provinsi_Tempat_Lahir->Visible && $this->Provinsi_Tempat_Lahir->Required) {
                if (!$this->Provinsi_Tempat_Lahir->IsDetailKey && IsEmpty($this->Provinsi_Tempat_Lahir->FormValue)) {
                    $this->Provinsi_Tempat_Lahir->addErrorMessage(str_replace("%s", $this->Provinsi_Tempat_Lahir->caption(), $this->Provinsi_Tempat_Lahir->RequiredErrorMessage));
                }
            }
            if ($this->Kota_Tempat_Lahir->Visible && $this->Kota_Tempat_Lahir->Required) {
                if (!$this->Kota_Tempat_Lahir->IsDetailKey && IsEmpty($this->Kota_Tempat_Lahir->FormValue)) {
                    $this->Kota_Tempat_Lahir->addErrorMessage(str_replace("%s", $this->Kota_Tempat_Lahir->caption(), $this->Kota_Tempat_Lahir->RequiredErrorMessage));
                }
            }
            if ($this->Tanggal_Lahir->Visible && $this->Tanggal_Lahir->Required) {
                if (!$this->Tanggal_Lahir->IsDetailKey && IsEmpty($this->Tanggal_Lahir->FormValue)) {
                    $this->Tanggal_Lahir->addErrorMessage(str_replace("%s", $this->Tanggal_Lahir->caption(), $this->Tanggal_Lahir->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->Tanggal_Lahir->FormValue, $this->Tanggal_Lahir->formatPattern())) {
                $this->Tanggal_Lahir->addErrorMessage($this->Tanggal_Lahir->getErrorMessage(false));
            }
            if ($this->Golongan_Darah->Visible && $this->Golongan_Darah->Required) {
                if (!$this->Golongan_Darah->IsDetailKey && IsEmpty($this->Golongan_Darah->FormValue)) {
                    $this->Golongan_Darah->addErrorMessage(str_replace("%s", $this->Golongan_Darah->caption(), $this->Golongan_Darah->RequiredErrorMessage));
                }
            }
            if ($this->Tinggi_Badan->Visible && $this->Tinggi_Badan->Required) {
                if (!$this->Tinggi_Badan->IsDetailKey && IsEmpty($this->Tinggi_Badan->FormValue)) {
                    $this->Tinggi_Badan->addErrorMessage(str_replace("%s", $this->Tinggi_Badan->caption(), $this->Tinggi_Badan->RequiredErrorMessage));
                }
            }
            if ($this->Berat_Badan->Visible && $this->Berat_Badan->Required) {
                if (!$this->Berat_Badan->IsDetailKey && IsEmpty($this->Berat_Badan->FormValue)) {
                    $this->Berat_Badan->addErrorMessage(str_replace("%s", $this->Berat_Badan->caption(), $this->Berat_Badan->RequiredErrorMessage));
                }
            }
            if ($this->Asal_sekolah->Visible && $this->Asal_sekolah->Required) {
                if (!$this->Asal_sekolah->IsDetailKey && IsEmpty($this->Asal_sekolah->FormValue)) {
                    $this->Asal_sekolah->addErrorMessage(str_replace("%s", $this->Asal_sekolah->caption(), $this->Asal_sekolah->RequiredErrorMessage));
                }
            }
            if ($this->Tahun_Ijazah->Visible && $this->Tahun_Ijazah->Required) {
                if (!$this->Tahun_Ijazah->IsDetailKey && IsEmpty($this->Tahun_Ijazah->FormValue)) {
                    $this->Tahun_Ijazah->addErrorMessage(str_replace("%s", $this->Tahun_Ijazah->caption(), $this->Tahun_Ijazah->RequiredErrorMessage));
                }
            }
            if ($this->Nomor_Ijazah->Visible && $this->Nomor_Ijazah->Required) {
                if (!$this->Nomor_Ijazah->IsDetailKey && IsEmpty($this->Nomor_Ijazah->FormValue)) {
                    $this->Nomor_Ijazah->addErrorMessage(str_replace("%s", $this->Nomor_Ijazah->caption(), $this->Nomor_Ijazah->RequiredErrorMessage));
                }
            }
            if ($this->Nilai_Raport_Kelas_10->Visible && $this->Nilai_Raport_Kelas_10->Required) {
                if (!$this->Nilai_Raport_Kelas_10->IsDetailKey && IsEmpty($this->Nilai_Raport_Kelas_10->FormValue)) {
                    $this->Nilai_Raport_Kelas_10->addErrorMessage(str_replace("%s", $this->Nilai_Raport_Kelas_10->caption(), $this->Nilai_Raport_Kelas_10->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Nilai_Raport_Kelas_10->FormValue)) {
                $this->Nilai_Raport_Kelas_10->addErrorMessage($this->Nilai_Raport_Kelas_10->getErrorMessage(false));
            }
            if ($this->Nilai_Raport_Kelas_11->Visible && $this->Nilai_Raport_Kelas_11->Required) {
                if (!$this->Nilai_Raport_Kelas_11->IsDetailKey && IsEmpty($this->Nilai_Raport_Kelas_11->FormValue)) {
                    $this->Nilai_Raport_Kelas_11->addErrorMessage(str_replace("%s", $this->Nilai_Raport_Kelas_11->caption(), $this->Nilai_Raport_Kelas_11->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Nilai_Raport_Kelas_11->FormValue)) {
                $this->Nilai_Raport_Kelas_11->addErrorMessage($this->Nilai_Raport_Kelas_11->getErrorMessage(false));
            }
            if ($this->Nilai_Raport_Kelas_12->Visible && $this->Nilai_Raport_Kelas_12->Required) {
                if (!$this->Nilai_Raport_Kelas_12->IsDetailKey && IsEmpty($this->Nilai_Raport_Kelas_12->FormValue)) {
                    $this->Nilai_Raport_Kelas_12->addErrorMessage(str_replace("%s", $this->Nilai_Raport_Kelas_12->caption(), $this->Nilai_Raport_Kelas_12->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Nilai_Raport_Kelas_12->FormValue)) {
                $this->Nilai_Raport_Kelas_12->addErrorMessage($this->Nilai_Raport_Kelas_12->getErrorMessage(false));
            }
            if ($this->Tanggal_Daftar->Visible && $this->Tanggal_Daftar->Required) {
                if (!$this->Tanggal_Daftar->IsDetailKey && IsEmpty($this->Tanggal_Daftar->FormValue)) {
                    $this->Tanggal_Daftar->addErrorMessage(str_replace("%s", $this->Tanggal_Daftar->caption(), $this->Tanggal_Daftar->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->Tanggal_Daftar->FormValue, $this->Tanggal_Daftar->formatPattern())) {
                $this->Tanggal_Daftar->addErrorMessage($this->Tanggal_Daftar->getErrorMessage(false));
            }
            if ($this->No_Test->Visible && $this->No_Test->Required) {
                if (!$this->No_Test->IsDetailKey && IsEmpty($this->No_Test->FormValue)) {
                    $this->No_Test->addErrorMessage(str_replace("%s", $this->No_Test->caption(), $this->No_Test->RequiredErrorMessage));
                }
            }
            if ($this->Status_Masuk->Visible && $this->Status_Masuk->Required) {
                if (!$this->Status_Masuk->IsDetailKey && IsEmpty($this->Status_Masuk->FormValue)) {
                    $this->Status_Masuk->addErrorMessage(str_replace("%s", $this->Status_Masuk->caption(), $this->Status_Masuk->RequiredErrorMessage));
                }
            }
            if ($this->Jalur_Masuk->Visible && $this->Jalur_Masuk->Required) {
                if (!$this->Jalur_Masuk->IsDetailKey && IsEmpty($this->Jalur_Masuk->FormValue)) {
                    $this->Jalur_Masuk->addErrorMessage(str_replace("%s", $this->Jalur_Masuk->caption(), $this->Jalur_Masuk->RequiredErrorMessage));
                }
            }
            if ($this->Bukti_Lulus->Visible && $this->Bukti_Lulus->Required) {
                if (!$this->Bukti_Lulus->IsDetailKey && IsEmpty($this->Bukti_Lulus->FormValue)) {
                    $this->Bukti_Lulus->addErrorMessage(str_replace("%s", $this->Bukti_Lulus->caption(), $this->Bukti_Lulus->RequiredErrorMessage));
                }
            }
            if ($this->Tes_Potensi_Akademik->Visible && $this->Tes_Potensi_Akademik->Required) {
                if (!$this->Tes_Potensi_Akademik->IsDetailKey && IsEmpty($this->Tes_Potensi_Akademik->FormValue)) {
                    $this->Tes_Potensi_Akademik->addErrorMessage(str_replace("%s", $this->Tes_Potensi_Akademik->caption(), $this->Tes_Potensi_Akademik->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Tes_Potensi_Akademik->FormValue)) {
                $this->Tes_Potensi_Akademik->addErrorMessage($this->Tes_Potensi_Akademik->getErrorMessage(false));
            }
            if ($this->Tes_Wawancara->Visible && $this->Tes_Wawancara->Required) {
                if (!$this->Tes_Wawancara->IsDetailKey && IsEmpty($this->Tes_Wawancara->FormValue)) {
                    $this->Tes_Wawancara->addErrorMessage(str_replace("%s", $this->Tes_Wawancara->caption(), $this->Tes_Wawancara->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Tes_Wawancara->FormValue)) {
                $this->Tes_Wawancara->addErrorMessage($this->Tes_Wawancara->getErrorMessage(false));
            }
            if ($this->Tes_Kesehatan->Visible && $this->Tes_Kesehatan->Required) {
                if (!$this->Tes_Kesehatan->IsDetailKey && IsEmpty($this->Tes_Kesehatan->FormValue)) {
                    $this->Tes_Kesehatan->addErrorMessage(str_replace("%s", $this->Tes_Kesehatan->caption(), $this->Tes_Kesehatan->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Tes_Kesehatan->FormValue)) {
                $this->Tes_Kesehatan->addErrorMessage($this->Tes_Kesehatan->getErrorMessage(false));
            }
            if ($this->Hasil_Test_Kesehatan->Visible && $this->Hasil_Test_Kesehatan->Required) {
                if (!$this->Hasil_Test_Kesehatan->IsDetailKey && IsEmpty($this->Hasil_Test_Kesehatan->FormValue)) {
                    $this->Hasil_Test_Kesehatan->addErrorMessage(str_replace("%s", $this->Hasil_Test_Kesehatan->caption(), $this->Hasil_Test_Kesehatan->RequiredErrorMessage));
                }
            }
            if ($this->Test_MMPI->Visible && $this->Test_MMPI->Required) {
                if (!$this->Test_MMPI->IsDetailKey && IsEmpty($this->Test_MMPI->FormValue)) {
                    $this->Test_MMPI->addErrorMessage(str_replace("%s", $this->Test_MMPI->caption(), $this->Test_MMPI->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Test_MMPI->FormValue)) {
                $this->Test_MMPI->addErrorMessage($this->Test_MMPI->getErrorMessage(false));
            }
            if ($this->Hasil_Test_MMPI->Visible && $this->Hasil_Test_MMPI->Required) {
                if (!$this->Hasil_Test_MMPI->IsDetailKey && IsEmpty($this->Hasil_Test_MMPI->FormValue)) {
                    $this->Hasil_Test_MMPI->addErrorMessage(str_replace("%s", $this->Hasil_Test_MMPI->caption(), $this->Hasil_Test_MMPI->RequiredErrorMessage));
                }
            }
            if ($this->Angkatan->Visible && $this->Angkatan->Required) {
                if (!$this->Angkatan->IsDetailKey && IsEmpty($this->Angkatan->FormValue)) {
                    $this->Angkatan->addErrorMessage(str_replace("%s", $this->Angkatan->caption(), $this->Angkatan->RequiredErrorMessage));
                }
            }
            if ($this->Tarif_SPP->Visible && $this->Tarif_SPP->Required) {
                if (!$this->Tarif_SPP->IsDetailKey && IsEmpty($this->Tarif_SPP->FormValue)) {
                    $this->Tarif_SPP->addErrorMessage(str_replace("%s", $this->Tarif_SPP->caption(), $this->Tarif_SPP->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Tarif_SPP->FormValue)) {
                $this->Tarif_SPP->addErrorMessage($this->Tarif_SPP->getErrorMessage(false));
            }
            if ($this->NIK_No_KTP->Visible && $this->NIK_No_KTP->Required) {
                if (!$this->NIK_No_KTP->IsDetailKey && IsEmpty($this->NIK_No_KTP->FormValue)) {
                    $this->NIK_No_KTP->addErrorMessage(str_replace("%s", $this->NIK_No_KTP->caption(), $this->NIK_No_KTP->RequiredErrorMessage));
                }
            }
            if ($this->No_KK->Visible && $this->No_KK->Required) {
                if (!$this->No_KK->IsDetailKey && IsEmpty($this->No_KK->FormValue)) {
                    $this->No_KK->addErrorMessage(str_replace("%s", $this->No_KK->caption(), $this->No_KK->RequiredErrorMessage));
                }
            }
            if ($this->NPWP->Visible && $this->NPWP->Required) {
                if (!$this->NPWP->IsDetailKey && IsEmpty($this->NPWP->FormValue)) {
                    $this->NPWP->addErrorMessage(str_replace("%s", $this->NPWP->caption(), $this->NPWP->RequiredErrorMessage));
                }
            }
            if ($this->Status_Nikah->Visible && $this->Status_Nikah->Required) {
                if (!$this->Status_Nikah->IsDetailKey && IsEmpty($this->Status_Nikah->FormValue)) {
                    $this->Status_Nikah->addErrorMessage(str_replace("%s", $this->Status_Nikah->caption(), $this->Status_Nikah->RequiredErrorMessage));
                }
            }
            if ($this->Kewarganegaraan->Visible && $this->Kewarganegaraan->Required) {
                if (!$this->Kewarganegaraan->IsDetailKey && IsEmpty($this->Kewarganegaraan->FormValue)) {
                    $this->Kewarganegaraan->addErrorMessage(str_replace("%s", $this->Kewarganegaraan->caption(), $this->Kewarganegaraan->RequiredErrorMessage));
                }
            }
            if ($this->Propinsi_Tempat_Tinggal->Visible && $this->Propinsi_Tempat_Tinggal->Required) {
                if (!$this->Propinsi_Tempat_Tinggal->IsDetailKey && IsEmpty($this->Propinsi_Tempat_Tinggal->FormValue)) {
                    $this->Propinsi_Tempat_Tinggal->addErrorMessage(str_replace("%s", $this->Propinsi_Tempat_Tinggal->caption(), $this->Propinsi_Tempat_Tinggal->RequiredErrorMessage));
                }
            }
            if ($this->Kota_Tempat_Tinggal->Visible && $this->Kota_Tempat_Tinggal->Required) {
                if (!$this->Kota_Tempat_Tinggal->IsDetailKey && IsEmpty($this->Kota_Tempat_Tinggal->FormValue)) {
                    $this->Kota_Tempat_Tinggal->addErrorMessage(str_replace("%s", $this->Kota_Tempat_Tinggal->caption(), $this->Kota_Tempat_Tinggal->RequiredErrorMessage));
                }
            }
            if ($this->Kecamatan_Tempat_Tinggal->Visible && $this->Kecamatan_Tempat_Tinggal->Required) {
                if (!$this->Kecamatan_Tempat_Tinggal->IsDetailKey && IsEmpty($this->Kecamatan_Tempat_Tinggal->FormValue)) {
                    $this->Kecamatan_Tempat_Tinggal->addErrorMessage(str_replace("%s", $this->Kecamatan_Tempat_Tinggal->caption(), $this->Kecamatan_Tempat_Tinggal->RequiredErrorMessage));
                }
            }
            if ($this->Alamat_Tempat_Tinggal->Visible && $this->Alamat_Tempat_Tinggal->Required) {
                if (!$this->Alamat_Tempat_Tinggal->IsDetailKey && IsEmpty($this->Alamat_Tempat_Tinggal->FormValue)) {
                    $this->Alamat_Tempat_Tinggal->addErrorMessage(str_replace("%s", $this->Alamat_Tempat_Tinggal->caption(), $this->Alamat_Tempat_Tinggal->RequiredErrorMessage));
                }
            }
            if ($this->RT->Visible && $this->RT->Required) {
                if (!$this->RT->IsDetailKey && IsEmpty($this->RT->FormValue)) {
                    $this->RT->addErrorMessage(str_replace("%s", $this->RT->caption(), $this->RT->RequiredErrorMessage));
                }
            }
            if ($this->RW->Visible && $this->RW->Required) {
                if (!$this->RW->IsDetailKey && IsEmpty($this->RW->FormValue)) {
                    $this->RW->addErrorMessage(str_replace("%s", $this->RW->caption(), $this->RW->RequiredErrorMessage));
                }
            }
            if ($this->Kelurahan->Visible && $this->Kelurahan->Required) {
                if (!$this->Kelurahan->IsDetailKey && IsEmpty($this->Kelurahan->FormValue)) {
                    $this->Kelurahan->addErrorMessage(str_replace("%s", $this->Kelurahan->caption(), $this->Kelurahan->RequiredErrorMessage));
                }
            }
            if ($this->Kode_Pos->Visible && $this->Kode_Pos->Required) {
                if (!$this->Kode_Pos->IsDetailKey && IsEmpty($this->Kode_Pos->FormValue)) {
                    $this->Kode_Pos->addErrorMessage(str_replace("%s", $this->Kode_Pos->caption(), $this->Kode_Pos->RequiredErrorMessage));
                }
            }
            if ($this->Nomor_Telpon_HP->Visible && $this->Nomor_Telpon_HP->Required) {
                if (!$this->Nomor_Telpon_HP->IsDetailKey && IsEmpty($this->Nomor_Telpon_HP->FormValue)) {
                    $this->Nomor_Telpon_HP->addErrorMessage(str_replace("%s", $this->Nomor_Telpon_HP->caption(), $this->Nomor_Telpon_HP->RequiredErrorMessage));
                }
            }
            if ($this->_Email->Visible && $this->_Email->Required) {
                if (!$this->_Email->IsDetailKey && IsEmpty($this->_Email->FormValue)) {
                    $this->_Email->addErrorMessage(str_replace("%s", $this->_Email->caption(), $this->_Email->RequiredErrorMessage));
                }
            }
            if ($this->Jenis_Tinggal->Visible && $this->Jenis_Tinggal->Required) {
                if (!$this->Jenis_Tinggal->IsDetailKey && IsEmpty($this->Jenis_Tinggal->FormValue)) {
                    $this->Jenis_Tinggal->addErrorMessage(str_replace("%s", $this->Jenis_Tinggal->caption(), $this->Jenis_Tinggal->RequiredErrorMessage));
                }
            }
            if ($this->Alat_Transportasi->Visible && $this->Alat_Transportasi->Required) {
                if (!$this->Alat_Transportasi->IsDetailKey && IsEmpty($this->Alat_Transportasi->FormValue)) {
                    $this->Alat_Transportasi->addErrorMessage(str_replace("%s", $this->Alat_Transportasi->caption(), $this->Alat_Transportasi->RequiredErrorMessage));
                }
            }
            if ($this->Sumber_Dana->Visible && $this->Sumber_Dana->Required) {
                if (!$this->Sumber_Dana->IsDetailKey && IsEmpty($this->Sumber_Dana->FormValue)) {
                    $this->Sumber_Dana->addErrorMessage(str_replace("%s", $this->Sumber_Dana->caption(), $this->Sumber_Dana->RequiredErrorMessage));
                }
            }
            if ($this->Sumber_Dana_Beasiswa->Visible && $this->Sumber_Dana_Beasiswa->Required) {
                if (!$this->Sumber_Dana_Beasiswa->IsDetailKey && IsEmpty($this->Sumber_Dana_Beasiswa->FormValue)) {
                    $this->Sumber_Dana_Beasiswa->addErrorMessage(str_replace("%s", $this->Sumber_Dana_Beasiswa->caption(), $this->Sumber_Dana_Beasiswa->RequiredErrorMessage));
                }
            }
            if ($this->Jumlah_Sudara->Visible && $this->Jumlah_Sudara->Required) {
                if (!$this->Jumlah_Sudara->IsDetailKey && IsEmpty($this->Jumlah_Sudara->FormValue)) {
                    $this->Jumlah_Sudara->addErrorMessage(str_replace("%s", $this->Jumlah_Sudara->caption(), $this->Jumlah_Sudara->RequiredErrorMessage));
                }
            }
            if ($this->Status_Bekerja->Visible && $this->Status_Bekerja->Required) {
                if (!$this->Status_Bekerja->IsDetailKey && IsEmpty($this->Status_Bekerja->FormValue)) {
                    $this->Status_Bekerja->addErrorMessage(str_replace("%s", $this->Status_Bekerja->caption(), $this->Status_Bekerja->RequiredErrorMessage));
                }
            }
            if ($this->Nomor_Asuransi->Visible && $this->Nomor_Asuransi->Required) {
                if (!$this->Nomor_Asuransi->IsDetailKey && IsEmpty($this->Nomor_Asuransi->FormValue)) {
                    $this->Nomor_Asuransi->addErrorMessage(str_replace("%s", $this->Nomor_Asuransi->caption(), $this->Nomor_Asuransi->RequiredErrorMessage));
                }
            }
            if ($this->Hobi->Visible && $this->Hobi->Required) {
                if (!$this->Hobi->IsDetailKey && IsEmpty($this->Hobi->FormValue)) {
                    $this->Hobi->addErrorMessage(str_replace("%s", $this->Hobi->caption(), $this->Hobi->RequiredErrorMessage));
                }
            }
            if ($this->Foto->Visible && $this->Foto->Required) {
                if (!$this->Foto->IsDetailKey && IsEmpty($this->Foto->FormValue)) {
                    $this->Foto->addErrorMessage(str_replace("%s", $this->Foto->caption(), $this->Foto->RequiredErrorMessage));
                }
            }
            if ($this->Nama_Ayah->Visible && $this->Nama_Ayah->Required) {
                if (!$this->Nama_Ayah->IsDetailKey && IsEmpty($this->Nama_Ayah->FormValue)) {
                    $this->Nama_Ayah->addErrorMessage(str_replace("%s", $this->Nama_Ayah->caption(), $this->Nama_Ayah->RequiredErrorMessage));
                }
            }
            if ($this->Pekerjaan_Ayah->Visible && $this->Pekerjaan_Ayah->Required) {
                if (!$this->Pekerjaan_Ayah->IsDetailKey && IsEmpty($this->Pekerjaan_Ayah->FormValue)) {
                    $this->Pekerjaan_Ayah->addErrorMessage(str_replace("%s", $this->Pekerjaan_Ayah->caption(), $this->Pekerjaan_Ayah->RequiredErrorMessage));
                }
            }
            if ($this->Nama_Ibu->Visible && $this->Nama_Ibu->Required) {
                if (!$this->Nama_Ibu->IsDetailKey && IsEmpty($this->Nama_Ibu->FormValue)) {
                    $this->Nama_Ibu->addErrorMessage(str_replace("%s", $this->Nama_Ibu->caption(), $this->Nama_Ibu->RequiredErrorMessage));
                }
            }
            if ($this->Pekerjaan_Ibu->Visible && $this->Pekerjaan_Ibu->Required) {
                if (!$this->Pekerjaan_Ibu->IsDetailKey && IsEmpty($this->Pekerjaan_Ibu->FormValue)) {
                    $this->Pekerjaan_Ibu->addErrorMessage(str_replace("%s", $this->Pekerjaan_Ibu->caption(), $this->Pekerjaan_Ibu->RequiredErrorMessage));
                }
            }
            if ($this->Alamat_Orang_Tua->Visible && $this->Alamat_Orang_Tua->Required) {
                if (!$this->Alamat_Orang_Tua->IsDetailKey && IsEmpty($this->Alamat_Orang_Tua->FormValue)) {
                    $this->Alamat_Orang_Tua->addErrorMessage(str_replace("%s", $this->Alamat_Orang_Tua->caption(), $this->Alamat_Orang_Tua->RequiredErrorMessage));
                }
            }
            if ($this->e_mail_Oranng_Tua->Visible && $this->e_mail_Oranng_Tua->Required) {
                if (!$this->e_mail_Oranng_Tua->IsDetailKey && IsEmpty($this->e_mail_Oranng_Tua->FormValue)) {
                    $this->e_mail_Oranng_Tua->addErrorMessage(str_replace("%s", $this->e_mail_Oranng_Tua->caption(), $this->e_mail_Oranng_Tua->RequiredErrorMessage));
                }
            }
            if ($this->No_Kontak_Orang_Tua->Visible && $this->No_Kontak_Orang_Tua->Required) {
                if (!$this->No_Kontak_Orang_Tua->IsDetailKey && IsEmpty($this->No_Kontak_Orang_Tua->FormValue)) {
                    $this->No_Kontak_Orang_Tua->addErrorMessage(str_replace("%s", $this->No_Kontak_Orang_Tua->caption(), $this->No_Kontak_Orang_Tua->RequiredErrorMessage));
                }
            }
            if ($this->userid->Visible && $this->userid->Required) {
                if (!$this->userid->IsDetailKey && IsEmpty($this->userid->FormValue)) {
                    $this->userid->addErrorMessage(str_replace("%s", $this->userid->caption(), $this->userid->RequiredErrorMessage));
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
            if ($this->tanggal_input->Visible && $this->tanggal_input->Required) {
                if (!$this->tanggal_input->IsDetailKey && IsEmpty($this->tanggal_input->FormValue)) {
                    $this->tanggal_input->addErrorMessage(str_replace("%s", $this->tanggal_input->caption(), $this->tanggal_input->RequiredErrorMessage));
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

        // Check field with unique index (NIM)
        if ($this->NIM->CurrentValue != "") {
            $filterChk = "(`NIM` = '" . AdjustSql($this->NIM->CurrentValue) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetchAssociative()) {
                $idxErrMsg = sprintf($this->language->phrase("DuplicateIndex"), $this->NIM->CurrentValue, $this->NIM->caption());
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
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

        // Nama
        $this->Nama->setDbValueDef($newRow, $this->Nama->CurrentValue, $this->Nama->ReadOnly);

        // Jenis_Kelamin
        $this->Jenis_Kelamin->setDbValueDef($newRow, $this->Jenis_Kelamin->CurrentValue, $this->Jenis_Kelamin->ReadOnly);

        // Provinsi_Tempat_Lahir
        $this->Provinsi_Tempat_Lahir->setDbValueDef($newRow, $this->Provinsi_Tempat_Lahir->CurrentValue, $this->Provinsi_Tempat_Lahir->ReadOnly);

        // Kota_Tempat_Lahir
        $this->Kota_Tempat_Lahir->setDbValueDef($newRow, $this->Kota_Tempat_Lahir->CurrentValue, $this->Kota_Tempat_Lahir->ReadOnly);

        // Tanggal_Lahir
        $this->Tanggal_Lahir->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal_Lahir->CurrentValue, $this->Tanggal_Lahir->formatPattern()), $this->Tanggal_Lahir->ReadOnly);

        // Golongan_Darah
        $this->Golongan_Darah->setDbValueDef($newRow, $this->Golongan_Darah->CurrentValue, $this->Golongan_Darah->ReadOnly);

        // Tinggi_Badan
        $this->Tinggi_Badan->setDbValueDef($newRow, $this->Tinggi_Badan->CurrentValue, $this->Tinggi_Badan->ReadOnly);

        // Berat_Badan
        $this->Berat_Badan->setDbValueDef($newRow, $this->Berat_Badan->CurrentValue, $this->Berat_Badan->ReadOnly);

        // Asal_sekolah
        $this->Asal_sekolah->setDbValueDef($newRow, $this->Asal_sekolah->CurrentValue, $this->Asal_sekolah->ReadOnly);

        // Tahun_Ijazah
        $this->Tahun_Ijazah->setDbValueDef($newRow, $this->Tahun_Ijazah->CurrentValue, $this->Tahun_Ijazah->ReadOnly);

        // Nomor_Ijazah
        $this->Nomor_Ijazah->setDbValueDef($newRow, $this->Nomor_Ijazah->CurrentValue, $this->Nomor_Ijazah->ReadOnly);

        // Nilai_Raport_Kelas_10
        $this->Nilai_Raport_Kelas_10->setDbValueDef($newRow, $this->Nilai_Raport_Kelas_10->CurrentValue, $this->Nilai_Raport_Kelas_10->ReadOnly);

        // Nilai_Raport_Kelas_11
        $this->Nilai_Raport_Kelas_11->setDbValueDef($newRow, $this->Nilai_Raport_Kelas_11->CurrentValue, $this->Nilai_Raport_Kelas_11->ReadOnly);

        // Nilai_Raport_Kelas_12
        $this->Nilai_Raport_Kelas_12->setDbValueDef($newRow, $this->Nilai_Raport_Kelas_12->CurrentValue, $this->Nilai_Raport_Kelas_12->ReadOnly);

        // Tanggal_Daftar
        $this->Tanggal_Daftar->setDbValueDef($newRow, UnFormatDateTime($this->Tanggal_Daftar->CurrentValue, $this->Tanggal_Daftar->formatPattern()), $this->Tanggal_Daftar->ReadOnly);

        // No_Test
        $this->No_Test->setDbValueDef($newRow, $this->No_Test->CurrentValue, $this->No_Test->ReadOnly);

        // Status_Masuk
        $this->Status_Masuk->setDbValueDef($newRow, $this->Status_Masuk->CurrentValue, $this->Status_Masuk->ReadOnly);

        // Jalur_Masuk
        $this->Jalur_Masuk->setDbValueDef($newRow, $this->Jalur_Masuk->CurrentValue, $this->Jalur_Masuk->ReadOnly);

        // Bukti_Lulus
        $this->Bukti_Lulus->setDbValueDef($newRow, $this->Bukti_Lulus->CurrentValue, $this->Bukti_Lulus->ReadOnly);

        // Tes_Potensi_Akademik
        $this->Tes_Potensi_Akademik->setDbValueDef($newRow, $this->Tes_Potensi_Akademik->CurrentValue, $this->Tes_Potensi_Akademik->ReadOnly);

        // Tes_Wawancara
        $this->Tes_Wawancara->setDbValueDef($newRow, $this->Tes_Wawancara->CurrentValue, $this->Tes_Wawancara->ReadOnly);

        // Tes_Kesehatan
        $this->Tes_Kesehatan->setDbValueDef($newRow, $this->Tes_Kesehatan->CurrentValue, $this->Tes_Kesehatan->ReadOnly);

        // Hasil_Test_Kesehatan
        $this->Hasil_Test_Kesehatan->setDbValueDef($newRow, $this->Hasil_Test_Kesehatan->CurrentValue, $this->Hasil_Test_Kesehatan->ReadOnly);

        // Test_MMPI
        $this->Test_MMPI->setDbValueDef($newRow, $this->Test_MMPI->CurrentValue, $this->Test_MMPI->ReadOnly);

        // Hasil_Test_MMPI
        $this->Hasil_Test_MMPI->setDbValueDef($newRow, $this->Hasil_Test_MMPI->CurrentValue, $this->Hasil_Test_MMPI->ReadOnly);

        // Angkatan
        $this->Angkatan->setDbValueDef($newRow, $this->Angkatan->CurrentValue, $this->Angkatan->ReadOnly);

        // Tarif_SPP
        $this->Tarif_SPP->setDbValueDef($newRow, $this->Tarif_SPP->CurrentValue, $this->Tarif_SPP->ReadOnly);

        // NIK_No_KTP
        $this->NIK_No_KTP->setDbValueDef($newRow, $this->NIK_No_KTP->CurrentValue, $this->NIK_No_KTP->ReadOnly);

        // No_KK
        $this->No_KK->setDbValueDef($newRow, $this->No_KK->CurrentValue, $this->No_KK->ReadOnly);

        // NPWP
        $this->NPWP->setDbValueDef($newRow, $this->NPWP->CurrentValue, $this->NPWP->ReadOnly);

        // Status_Nikah
        $this->Status_Nikah->setDbValueDef($newRow, $this->Status_Nikah->CurrentValue, $this->Status_Nikah->ReadOnly);

        // Kewarganegaraan
        $this->Kewarganegaraan->setDbValueDef($newRow, $this->Kewarganegaraan->CurrentValue, $this->Kewarganegaraan->ReadOnly);

        // Propinsi_Tempat_Tinggal
        $this->Propinsi_Tempat_Tinggal->setDbValueDef($newRow, $this->Propinsi_Tempat_Tinggal->CurrentValue, $this->Propinsi_Tempat_Tinggal->ReadOnly);

        // Kota_Tempat_Tinggal
        $this->Kota_Tempat_Tinggal->setDbValueDef($newRow, $this->Kota_Tempat_Tinggal->CurrentValue, $this->Kota_Tempat_Tinggal->ReadOnly);

        // Kecamatan_Tempat_Tinggal
        $this->Kecamatan_Tempat_Tinggal->setDbValueDef($newRow, $this->Kecamatan_Tempat_Tinggal->CurrentValue, $this->Kecamatan_Tempat_Tinggal->ReadOnly);

        // Alamat_Tempat_Tinggal
        $this->Alamat_Tempat_Tinggal->setDbValueDef($newRow, $this->Alamat_Tempat_Tinggal->CurrentValue, $this->Alamat_Tempat_Tinggal->ReadOnly);

        // RT
        $this->RT->setDbValueDef($newRow, $this->RT->CurrentValue, $this->RT->ReadOnly);

        // RW
        $this->RW->setDbValueDef($newRow, $this->RW->CurrentValue, $this->RW->ReadOnly);

        // Kelurahan
        $this->Kelurahan->setDbValueDef($newRow, $this->Kelurahan->CurrentValue, $this->Kelurahan->ReadOnly);

        // Kode_Pos
        $this->Kode_Pos->setDbValueDef($newRow, $this->Kode_Pos->CurrentValue, $this->Kode_Pos->ReadOnly);

        // Nomor_Telpon_HP
        $this->Nomor_Telpon_HP->setDbValueDef($newRow, $this->Nomor_Telpon_HP->CurrentValue, $this->Nomor_Telpon_HP->ReadOnly);

        // Email
        $this->_Email->setDbValueDef($newRow, $this->_Email->CurrentValue, $this->_Email->ReadOnly);

        // Jenis_Tinggal
        $this->Jenis_Tinggal->setDbValueDef($newRow, $this->Jenis_Tinggal->CurrentValue, $this->Jenis_Tinggal->ReadOnly);

        // Alat_Transportasi
        $this->Alat_Transportasi->setDbValueDef($newRow, $this->Alat_Transportasi->CurrentValue, $this->Alat_Transportasi->ReadOnly);

        // Sumber_Dana
        $this->Sumber_Dana->setDbValueDef($newRow, $this->Sumber_Dana->CurrentValue, $this->Sumber_Dana->ReadOnly);

        // Sumber_Dana_Beasiswa
        $this->Sumber_Dana_Beasiswa->setDbValueDef($newRow, $this->Sumber_Dana_Beasiswa->CurrentValue, $this->Sumber_Dana_Beasiswa->ReadOnly);

        // Jumlah_Sudara
        $this->Jumlah_Sudara->setDbValueDef($newRow, $this->Jumlah_Sudara->CurrentValue, $this->Jumlah_Sudara->ReadOnly);

        // Status_Bekerja
        $this->Status_Bekerja->setDbValueDef($newRow, $this->Status_Bekerja->CurrentValue, $this->Status_Bekerja->ReadOnly);

        // Nomor_Asuransi
        $this->Nomor_Asuransi->setDbValueDef($newRow, $this->Nomor_Asuransi->CurrentValue, $this->Nomor_Asuransi->ReadOnly);

        // Hobi
        $this->Hobi->setDbValueDef($newRow, $this->Hobi->CurrentValue, $this->Hobi->ReadOnly);

        // Foto
        $this->Foto->setDbValueDef($newRow, $this->Foto->CurrentValue, $this->Foto->ReadOnly);

        // Nama_Ayah
        $this->Nama_Ayah->setDbValueDef($newRow, $this->Nama_Ayah->CurrentValue, $this->Nama_Ayah->ReadOnly);

        // Pekerjaan_Ayah
        $this->Pekerjaan_Ayah->setDbValueDef($newRow, $this->Pekerjaan_Ayah->CurrentValue, $this->Pekerjaan_Ayah->ReadOnly);

        // Nama_Ibu
        $this->Nama_Ibu->setDbValueDef($newRow, $this->Nama_Ibu->CurrentValue, $this->Nama_Ibu->ReadOnly);

        // Pekerjaan_Ibu
        $this->Pekerjaan_Ibu->setDbValueDef($newRow, $this->Pekerjaan_Ibu->CurrentValue, $this->Pekerjaan_Ibu->ReadOnly);

        // Alamat_Orang_Tua
        $this->Alamat_Orang_Tua->setDbValueDef($newRow, $this->Alamat_Orang_Tua->CurrentValue, $this->Alamat_Orang_Tua->ReadOnly);

        // e_mail_Oranng_Tua
        $this->e_mail_Oranng_Tua->setDbValueDef($newRow, $this->e_mail_Oranng_Tua->CurrentValue, $this->e_mail_Oranng_Tua->ReadOnly);

        // No_Kontak_Orang_Tua
        $this->No_Kontak_Orang_Tua->setDbValueDef($newRow, $this->No_Kontak_Orang_Tua->CurrentValue, $this->No_Kontak_Orang_Tua->ReadOnly);

        // userid
        $this->userid->CurrentValue = $this->userid->getAutoUpdateValue(); // PHP
        $this->userid->setDbValueDef($newRow, $this->userid->CurrentValue, $this->userid->ReadOnly);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($newRow, $this->user->CurrentValue, $this->user->ReadOnly);

        // ip
        $this->ip->CurrentValue = $this->ip->getAutoUpdateValue(); // PHP
        $this->ip->setDbValueDef($newRow, $this->ip->CurrentValue, $this->ip->ReadOnly);

        // tanggal_input
        $this->tanggal_input->CurrentValue = $this->tanggal_input->getAutoUpdateValue(); // PHP
        $this->tanggal_input->setDbValueDef($newRow, UnFormatDateTime($this->tanggal_input->CurrentValue, $this->tanggal_input->formatPattern()), $this->tanggal_input->ReadOnly);
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
        if (isset($row['Nama'])) { // Nama
            $this->Nama->CurrentValue = $row['Nama'];
        }
        if (isset($row['Jenis_Kelamin'])) { // Jenis_Kelamin
            $this->Jenis_Kelamin->CurrentValue = $row['Jenis_Kelamin'];
        }
        if (isset($row['Provinsi_Tempat_Lahir'])) { // Provinsi_Tempat_Lahir
            $this->Provinsi_Tempat_Lahir->CurrentValue = $row['Provinsi_Tempat_Lahir'];
        }
        if (isset($row['Kota_Tempat_Lahir'])) { // Kota_Tempat_Lahir
            $this->Kota_Tempat_Lahir->CurrentValue = $row['Kota_Tempat_Lahir'];
        }
        if (isset($row['Tanggal_Lahir'])) { // Tanggal_Lahir
            $this->Tanggal_Lahir->CurrentValue = $row['Tanggal_Lahir'];
        }
        if (isset($row['Golongan_Darah'])) { // Golongan_Darah
            $this->Golongan_Darah->CurrentValue = $row['Golongan_Darah'];
        }
        if (isset($row['Tinggi_Badan'])) { // Tinggi_Badan
            $this->Tinggi_Badan->CurrentValue = $row['Tinggi_Badan'];
        }
        if (isset($row['Berat_Badan'])) { // Berat_Badan
            $this->Berat_Badan->CurrentValue = $row['Berat_Badan'];
        }
        if (isset($row['Asal_sekolah'])) { // Asal_sekolah
            $this->Asal_sekolah->CurrentValue = $row['Asal_sekolah'];
        }
        if (isset($row['Tahun_Ijazah'])) { // Tahun_Ijazah
            $this->Tahun_Ijazah->CurrentValue = $row['Tahun_Ijazah'];
        }
        if (isset($row['Nomor_Ijazah'])) { // Nomor_Ijazah
            $this->Nomor_Ijazah->CurrentValue = $row['Nomor_Ijazah'];
        }
        if (isset($row['Nilai_Raport_Kelas_10'])) { // Nilai_Raport_Kelas_10
            $this->Nilai_Raport_Kelas_10->CurrentValue = $row['Nilai_Raport_Kelas_10'];
        }
        if (isset($row['Nilai_Raport_Kelas_11'])) { // Nilai_Raport_Kelas_11
            $this->Nilai_Raport_Kelas_11->CurrentValue = $row['Nilai_Raport_Kelas_11'];
        }
        if (isset($row['Nilai_Raport_Kelas_12'])) { // Nilai_Raport_Kelas_12
            $this->Nilai_Raport_Kelas_12->CurrentValue = $row['Nilai_Raport_Kelas_12'];
        }
        if (isset($row['Tanggal_Daftar'])) { // Tanggal_Daftar
            $this->Tanggal_Daftar->CurrentValue = $row['Tanggal_Daftar'];
        }
        if (isset($row['No_Test'])) { // No_Test
            $this->No_Test->CurrentValue = $row['No_Test'];
        }
        if (isset($row['Status_Masuk'])) { // Status_Masuk
            $this->Status_Masuk->CurrentValue = $row['Status_Masuk'];
        }
        if (isset($row['Jalur_Masuk'])) { // Jalur_Masuk
            $this->Jalur_Masuk->CurrentValue = $row['Jalur_Masuk'];
        }
        if (isset($row['Bukti_Lulus'])) { // Bukti_Lulus
            $this->Bukti_Lulus->CurrentValue = $row['Bukti_Lulus'];
        }
        if (isset($row['Tes_Potensi_Akademik'])) { // Tes_Potensi_Akademik
            $this->Tes_Potensi_Akademik->CurrentValue = $row['Tes_Potensi_Akademik'];
        }
        if (isset($row['Tes_Wawancara'])) { // Tes_Wawancara
            $this->Tes_Wawancara->CurrentValue = $row['Tes_Wawancara'];
        }
        if (isset($row['Tes_Kesehatan'])) { // Tes_Kesehatan
            $this->Tes_Kesehatan->CurrentValue = $row['Tes_Kesehatan'];
        }
        if (isset($row['Hasil_Test_Kesehatan'])) { // Hasil_Test_Kesehatan
            $this->Hasil_Test_Kesehatan->CurrentValue = $row['Hasil_Test_Kesehatan'];
        }
        if (isset($row['Test_MMPI'])) { // Test_MMPI
            $this->Test_MMPI->CurrentValue = $row['Test_MMPI'];
        }
        if (isset($row['Hasil_Test_MMPI'])) { // Hasil_Test_MMPI
            $this->Hasil_Test_MMPI->CurrentValue = $row['Hasil_Test_MMPI'];
        }
        if (isset($row['Angkatan'])) { // Angkatan
            $this->Angkatan->CurrentValue = $row['Angkatan'];
        }
        if (isset($row['Tarif_SPP'])) { // Tarif_SPP
            $this->Tarif_SPP->CurrentValue = $row['Tarif_SPP'];
        }
        if (isset($row['NIK_No_KTP'])) { // NIK_No_KTP
            $this->NIK_No_KTP->CurrentValue = $row['NIK_No_KTP'];
        }
        if (isset($row['No_KK'])) { // No_KK
            $this->No_KK->CurrentValue = $row['No_KK'];
        }
        if (isset($row['NPWP'])) { // NPWP
            $this->NPWP->CurrentValue = $row['NPWP'];
        }
        if (isset($row['Status_Nikah'])) { // Status_Nikah
            $this->Status_Nikah->CurrentValue = $row['Status_Nikah'];
        }
        if (isset($row['Kewarganegaraan'])) { // Kewarganegaraan
            $this->Kewarganegaraan->CurrentValue = $row['Kewarganegaraan'];
        }
        if (isset($row['Propinsi_Tempat_Tinggal'])) { // Propinsi_Tempat_Tinggal
            $this->Propinsi_Tempat_Tinggal->CurrentValue = $row['Propinsi_Tempat_Tinggal'];
        }
        if (isset($row['Kota_Tempat_Tinggal'])) { // Kota_Tempat_Tinggal
            $this->Kota_Tempat_Tinggal->CurrentValue = $row['Kota_Tempat_Tinggal'];
        }
        if (isset($row['Kecamatan_Tempat_Tinggal'])) { // Kecamatan_Tempat_Tinggal
            $this->Kecamatan_Tempat_Tinggal->CurrentValue = $row['Kecamatan_Tempat_Tinggal'];
        }
        if (isset($row['Alamat_Tempat_Tinggal'])) { // Alamat_Tempat_Tinggal
            $this->Alamat_Tempat_Tinggal->CurrentValue = $row['Alamat_Tempat_Tinggal'];
        }
        if (isset($row['RT'])) { // RT
            $this->RT->CurrentValue = $row['RT'];
        }
        if (isset($row['RW'])) { // RW
            $this->RW->CurrentValue = $row['RW'];
        }
        if (isset($row['Kelurahan'])) { // Kelurahan
            $this->Kelurahan->CurrentValue = $row['Kelurahan'];
        }
        if (isset($row['Kode_Pos'])) { // Kode_Pos
            $this->Kode_Pos->CurrentValue = $row['Kode_Pos'];
        }
        if (isset($row['Nomor_Telpon_HP'])) { // Nomor_Telpon_HP
            $this->Nomor_Telpon_HP->CurrentValue = $row['Nomor_Telpon_HP'];
        }
        if (isset($row['Email'])) { // Email
            $this->_Email->CurrentValue = $row['Email'];
        }
        if (isset($row['Jenis_Tinggal'])) { // Jenis_Tinggal
            $this->Jenis_Tinggal->CurrentValue = $row['Jenis_Tinggal'];
        }
        if (isset($row['Alat_Transportasi'])) { // Alat_Transportasi
            $this->Alat_Transportasi->CurrentValue = $row['Alat_Transportasi'];
        }
        if (isset($row['Sumber_Dana'])) { // Sumber_Dana
            $this->Sumber_Dana->CurrentValue = $row['Sumber_Dana'];
        }
        if (isset($row['Sumber_Dana_Beasiswa'])) { // Sumber_Dana_Beasiswa
            $this->Sumber_Dana_Beasiswa->CurrentValue = $row['Sumber_Dana_Beasiswa'];
        }
        if (isset($row['Jumlah_Sudara'])) { // Jumlah_Sudara
            $this->Jumlah_Sudara->CurrentValue = $row['Jumlah_Sudara'];
        }
        if (isset($row['Status_Bekerja'])) { // Status_Bekerja
            $this->Status_Bekerja->CurrentValue = $row['Status_Bekerja'];
        }
        if (isset($row['Nomor_Asuransi'])) { // Nomor_Asuransi
            $this->Nomor_Asuransi->CurrentValue = $row['Nomor_Asuransi'];
        }
        if (isset($row['Hobi'])) { // Hobi
            $this->Hobi->CurrentValue = $row['Hobi'];
        }
        if (isset($row['Foto'])) { // Foto
            $this->Foto->CurrentValue = $row['Foto'];
        }
        if (isset($row['Nama_Ayah'])) { // Nama_Ayah
            $this->Nama_Ayah->CurrentValue = $row['Nama_Ayah'];
        }
        if (isset($row['Pekerjaan_Ayah'])) { // Pekerjaan_Ayah
            $this->Pekerjaan_Ayah->CurrentValue = $row['Pekerjaan_Ayah'];
        }
        if (isset($row['Nama_Ibu'])) { // Nama_Ibu
            $this->Nama_Ibu->CurrentValue = $row['Nama_Ibu'];
        }
        if (isset($row['Pekerjaan_Ibu'])) { // Pekerjaan_Ibu
            $this->Pekerjaan_Ibu->CurrentValue = $row['Pekerjaan_Ibu'];
        }
        if (isset($row['Alamat_Orang_Tua'])) { // Alamat_Orang_Tua
            $this->Alamat_Orang_Tua->CurrentValue = $row['Alamat_Orang_Tua'];
        }
        if (isset($row['e_mail_Oranng_Tua'])) { // e_mail_Oranng_Tua
            $this->e_mail_Oranng_Tua->CurrentValue = $row['e_mail_Oranng_Tua'];
        }
        if (isset($row['No_Kontak_Orang_Tua'])) { // No_Kontak_Orang_Tua
            $this->No_Kontak_Orang_Tua->CurrentValue = $row['No_Kontak_Orang_Tua'];
        }
        if (isset($row['userid'])) { // userid
            $this->userid->CurrentValue = $row['userid'];
        }
        if (isset($row['user'])) { // user
            $this->user->CurrentValue = $row['user'];
        }
        if (isset($row['ip'])) { // ip
            $this->ip->CurrentValue = $row['ip'];
        }
        if (isset($row['tanggal_input'])) { // tanggal_input
            $this->tanggal_input->CurrentValue = $row['tanggal_input'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("mahasiswalist"), "", $this->TableVar, true);
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
