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
class DosenDelete extends Dosen
{
    use MessagesTrait;

    // Page ID
    public string $PageID = "delete";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "DosenDelete";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "dosendelete";

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
            Redirect(GetUrl($url));
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
    public ?string $DbMasterFilter = "";
    public string $DbDetailFilter = "";
    public int $StartRecord = 0;
    public int $TotalRecords = 0;
    public int $RecordCount = 0;
    public array $RecKeys = [];
    public int $StartRowCount = 1;

    /**
     * Page run
     *
     * @return void
     */
    public function run(): void
    {
        global $ExportType;

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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("dosenlist"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            if ($this->deleteRows()) { // Delete rows
                if (!$this->peekSuccessMessage()) {
                    $this->setSuccessMessage($this->language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson(["success" => false, "error" => $this->getFailureMessage()]);
                    $this->terminate();
                    return;
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            $this->Result = $this->loadResult();
            if ($this->TotalRecords <= 0) { // No record found, exit
                $this->Result?->free();
                $this->terminate("dosenlist"); // Return to list
                return;
            }
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

    // Render row values based on field settings
    public function renderRow(): void
    {
        global $CurrentLanguage;

        // Initialize URLs

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
        if ($this->UseTransaction) {
            $conn->beginTransaction();
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
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Set warning message if some records skipped
            if (count($skipRecords) > 0) {
                $this->setWarningMessage(sprintf($this->language->phrase("RecordsSkipped"), count($skipRecords)));
                Log("Records skipped", $skipRecords);
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(sprintf($this->language->phrase("DeleteRecordsFailed"), count($successKeys), count($failKeys)));
                Log("Delete records failed", ["success" => $successKeys, "failure" => $failKeys]);
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromResult($oldRows);
            $table = $this->TableVar;
            if (Param("key_m") === null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb(): void
    {
        $breadcrumb = Breadcrumb();
        $url = CurrentUrl();
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("dosenlist"), "", $this->TableVar, true);
        $pageId = "delete";
        $breadcrumb->add("delete", $pageId, $url);
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
}
