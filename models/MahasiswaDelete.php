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
class MahasiswaDelete extends Mahasiswa
{
    use MessagesTrait;

    // Page ID
    public string $PageID = "delete";

    // Project ID
    public string $ProjectID = PROJECT_ID;

    // Page object name
    public string $PageObjName = "MahasiswaDelete";

    // View file path
    public ?string $View = null;

    // Title
    public ?string $Title = null; // Title for <title> tag

    // CSS class/style
    public string $CurrentPageName = "mahasiswadelete";

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
        $this->userid->Visible = false;
        $this->user->Visible = false;
        $this->ip->Visible = false;
        $this->tanggal_input->Visible = false;
    }

    // Constructor
    public function __construct(Language $language, AdvancedSecurity $security)
    {
        parent::__construct($language, $security);
        global $DashboardReport;
        $this->TableVar = 'mahasiswa';
        $this->TableName = 'mahasiswa';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

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
            $this->terminate("mahasiswalist"); // Prevent SQL injection, return to list
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
                $this->terminate("mahasiswalist"); // Return to list
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

    // Render row values based on field settings
    public function renderRow(): void
    {
        global $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // NIM

        // Nama

        // Jenis_Kelamin

        // Provinsi_Tempat_Lahir

        // Kota_Tempat_Lahir

        // Tanggal_Lahir

        // Golongan_Darah

        // Tinggi_Badan

        // Berat_Badan

        // Asal_sekolah

        // Tahun_Ijazah

        // Nomor_Ijazah

        // Nilai_Raport_Kelas_10

        // Nilai_Raport_Kelas_11

        // Nilai_Raport_Kelas_12

        // Tanggal_Daftar

        // No_Test

        // Status_Masuk

        // Jalur_Masuk

        // Bukti_Lulus

        // Tes_Potensi_Akademik

        // Tes_Wawancara

        // Tes_Kesehatan

        // Hasil_Test_Kesehatan

        // Test_MMPI

        // Hasil_Test_MMPI

        // Angkatan

        // Tarif_SPP

        // NIK_No_KTP

        // No_KK

        // NPWP

        // Status_Nikah

        // Kewarganegaraan

        // Propinsi_Tempat_Tinggal

        // Kota_Tempat_Tinggal

        // Kecamatan_Tempat_Tinggal

        // Alamat_Tempat_Tinggal

        // RT

        // RW

        // Kelurahan

        // Kode_Pos

        // Nomor_Telpon_HP

        // Email

        // Jenis_Tinggal

        // Alat_Transportasi

        // Sumber_Dana

        // Sumber_Dana_Beasiswa

        // Jumlah_Sudara

        // Status_Bekerja

        // Nomor_Asuransi

        // Hobi

        // Foto

        // Nama_Ayah

        // Pekerjaan_Ayah

        // Nama_Ibu

        // Pekerjaan_Ibu

        // Alamat_Orang_Tua

        // e_mail_Oranng_Tua

        // No_Kontak_Orang_Tua

        // userid

        // user

        // ip

        // tanggal_input

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
            $this->NIM->TooltipValue = "";

            // Nama
            $this->Nama->HrefValue = "";
            $this->Nama->TooltipValue = "";

            // Jenis_Kelamin
            $this->Jenis_Kelamin->HrefValue = "";
            $this->Jenis_Kelamin->TooltipValue = "";

            // Provinsi_Tempat_Lahir
            $this->Provinsi_Tempat_Lahir->HrefValue = "";
            $this->Provinsi_Tempat_Lahir->TooltipValue = "";

            // Kota_Tempat_Lahir
            $this->Kota_Tempat_Lahir->HrefValue = "";
            $this->Kota_Tempat_Lahir->TooltipValue = "";

            // Tanggal_Lahir
            $this->Tanggal_Lahir->HrefValue = "";
            $this->Tanggal_Lahir->TooltipValue = "";

            // Golongan_Darah
            $this->Golongan_Darah->HrefValue = "";
            $this->Golongan_Darah->TooltipValue = "";

            // Tinggi_Badan
            $this->Tinggi_Badan->HrefValue = "";
            $this->Tinggi_Badan->TooltipValue = "";

            // Berat_Badan
            $this->Berat_Badan->HrefValue = "";
            $this->Berat_Badan->TooltipValue = "";

            // Asal_sekolah
            $this->Asal_sekolah->HrefValue = "";
            $this->Asal_sekolah->TooltipValue = "";

            // Tahun_Ijazah
            $this->Tahun_Ijazah->HrefValue = "";
            $this->Tahun_Ijazah->TooltipValue = "";

            // Nomor_Ijazah
            $this->Nomor_Ijazah->HrefValue = "";
            $this->Nomor_Ijazah->TooltipValue = "";

            // Nilai_Raport_Kelas_10
            $this->Nilai_Raport_Kelas_10->HrefValue = "";
            $this->Nilai_Raport_Kelas_10->TooltipValue = "";

            // Nilai_Raport_Kelas_11
            $this->Nilai_Raport_Kelas_11->HrefValue = "";
            $this->Nilai_Raport_Kelas_11->TooltipValue = "";

            // Nilai_Raport_Kelas_12
            $this->Nilai_Raport_Kelas_12->HrefValue = "";
            $this->Nilai_Raport_Kelas_12->TooltipValue = "";

            // Tanggal_Daftar
            $this->Tanggal_Daftar->HrefValue = "";
            $this->Tanggal_Daftar->TooltipValue = "";

            // No_Test
            $this->No_Test->HrefValue = "";
            $this->No_Test->TooltipValue = "";

            // Status_Masuk
            $this->Status_Masuk->HrefValue = "";
            $this->Status_Masuk->TooltipValue = "";

            // Jalur_Masuk
            $this->Jalur_Masuk->HrefValue = "";
            $this->Jalur_Masuk->TooltipValue = "";

            // Bukti_Lulus
            $this->Bukti_Lulus->HrefValue = "";
            $this->Bukti_Lulus->TooltipValue = "";

            // Tes_Potensi_Akademik
            $this->Tes_Potensi_Akademik->HrefValue = "";
            $this->Tes_Potensi_Akademik->TooltipValue = "";

            // Tes_Wawancara
            $this->Tes_Wawancara->HrefValue = "";
            $this->Tes_Wawancara->TooltipValue = "";

            // Tes_Kesehatan
            $this->Tes_Kesehatan->HrefValue = "";
            $this->Tes_Kesehatan->TooltipValue = "";

            // Hasil_Test_Kesehatan
            $this->Hasil_Test_Kesehatan->HrefValue = "";
            $this->Hasil_Test_Kesehatan->TooltipValue = "";

            // Test_MMPI
            $this->Test_MMPI->HrefValue = "";
            $this->Test_MMPI->TooltipValue = "";

            // Hasil_Test_MMPI
            $this->Hasil_Test_MMPI->HrefValue = "";
            $this->Hasil_Test_MMPI->TooltipValue = "";

            // Angkatan
            $this->Angkatan->HrefValue = "";
            $this->Angkatan->TooltipValue = "";

            // Tarif_SPP
            $this->Tarif_SPP->HrefValue = "";
            $this->Tarif_SPP->TooltipValue = "";

            // NIK_No_KTP
            $this->NIK_No_KTP->HrefValue = "";
            $this->NIK_No_KTP->TooltipValue = "";

            // No_KK
            $this->No_KK->HrefValue = "";
            $this->No_KK->TooltipValue = "";

            // NPWP
            $this->NPWP->HrefValue = "";
            $this->NPWP->TooltipValue = "";

            // Status_Nikah
            $this->Status_Nikah->HrefValue = "";
            $this->Status_Nikah->TooltipValue = "";

            // Kewarganegaraan
            $this->Kewarganegaraan->HrefValue = "";
            $this->Kewarganegaraan->TooltipValue = "";

            // Propinsi_Tempat_Tinggal
            $this->Propinsi_Tempat_Tinggal->HrefValue = "";
            $this->Propinsi_Tempat_Tinggal->TooltipValue = "";

            // Kota_Tempat_Tinggal
            $this->Kota_Tempat_Tinggal->HrefValue = "";
            $this->Kota_Tempat_Tinggal->TooltipValue = "";

            // Kecamatan_Tempat_Tinggal
            $this->Kecamatan_Tempat_Tinggal->HrefValue = "";
            $this->Kecamatan_Tempat_Tinggal->TooltipValue = "";

            // Alamat_Tempat_Tinggal
            $this->Alamat_Tempat_Tinggal->HrefValue = "";
            $this->Alamat_Tempat_Tinggal->TooltipValue = "";

            // RT
            $this->RT->HrefValue = "";
            $this->RT->TooltipValue = "";

            // RW
            $this->RW->HrefValue = "";
            $this->RW->TooltipValue = "";

            // Kelurahan
            $this->Kelurahan->HrefValue = "";
            $this->Kelurahan->TooltipValue = "";

            // Kode_Pos
            $this->Kode_Pos->HrefValue = "";
            $this->Kode_Pos->TooltipValue = "";

            // Nomor_Telpon_HP
            $this->Nomor_Telpon_HP->HrefValue = "";
            $this->Nomor_Telpon_HP->TooltipValue = "";

            // Email
            $this->_Email->HrefValue = "";
            $this->_Email->TooltipValue = "";

            // Jenis_Tinggal
            $this->Jenis_Tinggal->HrefValue = "";
            $this->Jenis_Tinggal->TooltipValue = "";

            // Alat_Transportasi
            $this->Alat_Transportasi->HrefValue = "";
            $this->Alat_Transportasi->TooltipValue = "";

            // Sumber_Dana
            $this->Sumber_Dana->HrefValue = "";
            $this->Sumber_Dana->TooltipValue = "";

            // Sumber_Dana_Beasiswa
            $this->Sumber_Dana_Beasiswa->HrefValue = "";
            $this->Sumber_Dana_Beasiswa->TooltipValue = "";

            // Jumlah_Sudara
            $this->Jumlah_Sudara->HrefValue = "";
            $this->Jumlah_Sudara->TooltipValue = "";

            // Status_Bekerja
            $this->Status_Bekerja->HrefValue = "";
            $this->Status_Bekerja->TooltipValue = "";

            // Nomor_Asuransi
            $this->Nomor_Asuransi->HrefValue = "";
            $this->Nomor_Asuransi->TooltipValue = "";

            // Hobi
            $this->Hobi->HrefValue = "";
            $this->Hobi->TooltipValue = "";

            // Foto
            $this->Foto->HrefValue = "";
            $this->Foto->TooltipValue = "";

            // Nama_Ayah
            $this->Nama_Ayah->HrefValue = "";
            $this->Nama_Ayah->TooltipValue = "";

            // Pekerjaan_Ayah
            $this->Pekerjaan_Ayah->HrefValue = "";
            $this->Pekerjaan_Ayah->TooltipValue = "";

            // Nama_Ibu
            $this->Nama_Ibu->HrefValue = "";
            $this->Nama_Ibu->TooltipValue = "";

            // Pekerjaan_Ibu
            $this->Pekerjaan_Ibu->HrefValue = "";
            $this->Pekerjaan_Ibu->TooltipValue = "";

            // Alamat_Orang_Tua
            $this->Alamat_Orang_Tua->HrefValue = "";
            $this->Alamat_Orang_Tua->TooltipValue = "";

            // e_mail_Oranng_Tua
            $this->e_mail_Oranng_Tua->HrefValue = "";
            $this->e_mail_Oranng_Tua->TooltipValue = "";

            // No_Kontak_Orang_Tua
            $this->No_Kontak_Orang_Tua->HrefValue = "";
            $this->No_Kontak_Orang_Tua->TooltipValue = "";
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
        $breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("mahasiswalist"), "", $this->TableVar, true);
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
