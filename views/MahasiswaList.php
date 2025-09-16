<?php

namespace PHPMaker2025\pssk2025;

// Page object
$MahasiswaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->getFormKeyCountName() ?>")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script<?= Nonce() ?>>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=25.12.16", "preview");
</script>
<script<?= Nonce() ?>>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fmahasiswasrch" id="fmahasiswasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fmahasiswasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mahasiswa: currentTable } });
var currentForm;
var fmahasiswasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fmahasiswasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="card shadow-sm" style="width: 100%">
<div class="card-header"><h4 class="card-title"><?php echo Language()->phrase("SearchPanel"); ?></h4></div>
<div class="card-body" style="margin-left: 20px !important;">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fmahasiswasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fmahasiswasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fmahasiswasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fmahasiswasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div></div>
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? "" : "" ?>">
<?php } else { ?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<?php } ?>
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mahasiswa">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_mahasiswa" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_mahasiswalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_mahasiswa_NIM" class="mahasiswa_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
        <th data-name="Nama" class="<?= $Page->Nama->headerCellClass() ?>"><div id="elh_mahasiswa_Nama" class="mahasiswa_Nama"><?= $Page->renderFieldHeader($Page->Nama) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Kelamin" class="mahasiswa_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <th data-name="Provinsi_Tempat_Lahir" class="<?= $Page->Provinsi_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Provinsi_Tempat_Lahir" class="mahasiswa_Provinsi_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Provinsi_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <th data-name="Kota_Tempat_Lahir" class="<?= $Page->Kota_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Lahir" class="mahasiswa_Kota_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <th data-name="Tanggal_Lahir" class="<?= $Page->Tanggal_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Lahir" class="mahasiswa_Tanggal_Lahir"><?= $Page->renderFieldHeader($Page->Tanggal_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <th data-name="Golongan_Darah" class="<?= $Page->Golongan_Darah->headerCellClass() ?>"><div id="elh_mahasiswa_Golongan_Darah" class="mahasiswa_Golongan_Darah"><?= $Page->renderFieldHeader($Page->Golongan_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <th data-name="Tinggi_Badan" class="<?= $Page->Tinggi_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Tinggi_Badan" class="mahasiswa_Tinggi_Badan"><?= $Page->renderFieldHeader($Page->Tinggi_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <th data-name="Berat_Badan" class="<?= $Page->Berat_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Berat_Badan" class="mahasiswa_Berat_Badan"><?= $Page->renderFieldHeader($Page->Berat_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <th data-name="Asal_sekolah" class="<?= $Page->Asal_sekolah->headerCellClass() ?>"><div id="elh_mahasiswa_Asal_sekolah" class="mahasiswa_Asal_sekolah"><?= $Page->renderFieldHeader($Page->Asal_sekolah) ?></div></th>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <th data-name="Tahun_Ijazah" class="<?= $Page->Tahun_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Tahun_Ijazah" class="mahasiswa_Tahun_Ijazah"><?= $Page->renderFieldHeader($Page->Tahun_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <th data-name="Nomor_Ijazah" class="<?= $Page->Nomor_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Ijazah" class="mahasiswa_Nomor_Ijazah"><?= $Page->renderFieldHeader($Page->Nomor_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <th data-name="Nilai_Raport_Kelas_10" class="<?= $Page->Nilai_Raport_Kelas_10->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_10" class="mahasiswa_Nilai_Raport_Kelas_10"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_10) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <th data-name="Nilai_Raport_Kelas_11" class="<?= $Page->Nilai_Raport_Kelas_11->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_11" class="mahasiswa_Nilai_Raport_Kelas_11"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_11) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <th data-name="Nilai_Raport_Kelas_12" class="<?= $Page->Nilai_Raport_Kelas_12->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_12" class="mahasiswa_Nilai_Raport_Kelas_12"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_12) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <th data-name="Tanggal_Daftar" class="<?= $Page->Tanggal_Daftar->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Daftar" class="mahasiswa_Tanggal_Daftar"><?= $Page->renderFieldHeader($Page->Tanggal_Daftar) ?></div></th>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
        <th data-name="No_Test" class="<?= $Page->No_Test->headerCellClass() ?>"><div id="elh_mahasiswa_No_Test" class="mahasiswa_No_Test"><?= $Page->renderFieldHeader($Page->No_Test) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <th data-name="Status_Masuk" class="<?= $Page->Status_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Masuk" class="mahasiswa_Status_Masuk"><?= $Page->renderFieldHeader($Page->Status_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <th data-name="Jalur_Masuk" class="<?= $Page->Jalur_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Jalur_Masuk" class="mahasiswa_Jalur_Masuk"><?= $Page->renderFieldHeader($Page->Jalur_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <th data-name="Bukti_Lulus" class="<?= $Page->Bukti_Lulus->headerCellClass() ?>"><div id="elh_mahasiswa_Bukti_Lulus" class="mahasiswa_Bukti_Lulus"><?= $Page->renderFieldHeader($Page->Bukti_Lulus) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <th data-name="Tes_Potensi_Akademik" class="<?= $Page->Tes_Potensi_Akademik->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Potensi_Akademik" class="mahasiswa_Tes_Potensi_Akademik"><?= $Page->renderFieldHeader($Page->Tes_Potensi_Akademik) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <th data-name="Tes_Wawancara" class="<?= $Page->Tes_Wawancara->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Wawancara" class="mahasiswa_Tes_Wawancara"><?= $Page->renderFieldHeader($Page->Tes_Wawancara) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <th data-name="Tes_Kesehatan" class="<?= $Page->Tes_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Kesehatan" class="mahasiswa_Tes_Kesehatan"><?= $Page->renderFieldHeader($Page->Tes_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <th data-name="Hasil_Test_Kesehatan" class="<?= $Page->Hasil_Test_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_Kesehatan" class="mahasiswa_Hasil_Test_Kesehatan"><?= $Page->renderFieldHeader($Page->Hasil_Test_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <th data-name="Test_MMPI" class="<?= $Page->Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Test_MMPI" class="mahasiswa_Test_MMPI"><?= $Page->renderFieldHeader($Page->Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <th data-name="Hasil_Test_MMPI" class="<?= $Page->Hasil_Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_MMPI" class="mahasiswa_Hasil_Test_MMPI"><?= $Page->renderFieldHeader($Page->Hasil_Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <th data-name="Angkatan" class="<?= $Page->Angkatan->headerCellClass() ?>"><div id="elh_mahasiswa_Angkatan" class="mahasiswa_Angkatan"><?= $Page->renderFieldHeader($Page->Angkatan) ?></div></th>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <th data-name="Tarif_SPP" class="<?= $Page->Tarif_SPP->headerCellClass() ?>"><div id="elh_mahasiswa_Tarif_SPP" class="mahasiswa_Tarif_SPP"><?= $Page->renderFieldHeader($Page->Tarif_SPP) ?></div></th>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <th data-name="NIK_No_KTP" class="<?= $Page->NIK_No_KTP->headerCellClass() ?>"><div id="elh_mahasiswa_NIK_No_KTP" class="mahasiswa_NIK_No_KTP"><?= $Page->renderFieldHeader($Page->NIK_No_KTP) ?></div></th>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
        <th data-name="No_KK" class="<?= $Page->No_KK->headerCellClass() ?>"><div id="elh_mahasiswa_No_KK" class="mahasiswa_No_KK"><?= $Page->renderFieldHeader($Page->No_KK) ?></div></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th data-name="NPWP" class="<?= $Page->NPWP->headerCellClass() ?>"><div id="elh_mahasiswa_NPWP" class="mahasiswa_NPWP"><?= $Page->renderFieldHeader($Page->NPWP) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <th data-name="Status_Nikah" class="<?= $Page->Status_Nikah->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Nikah" class="mahasiswa_Status_Nikah"><?= $Page->renderFieldHeader($Page->Status_Nikah) ?></div></th>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <th data-name="Kewarganegaraan" class="<?= $Page->Kewarganegaraan->headerCellClass() ?>"><div id="elh_mahasiswa_Kewarganegaraan" class="mahasiswa_Kewarganegaraan"><?= $Page->renderFieldHeader($Page->Kewarganegaraan) ?></div></th>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <th data-name="Propinsi_Tempat_Tinggal" class="<?= $Page->Propinsi_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Propinsi_Tempat_Tinggal" class="mahasiswa_Propinsi_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Propinsi_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <th data-name="Kota_Tempat_Tinggal" class="<?= $Page->Kota_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Tinggal" class="mahasiswa_Kota_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <th data-name="Kecamatan_Tempat_Tinggal" class="<?= $Page->Kecamatan_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kecamatan_Tempat_Tinggal" class="mahasiswa_Kecamatan_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kecamatan_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <th data-name="Alamat_Tempat_Tinggal" class="<?= $Page->Alamat_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Tempat_Tinggal" class="mahasiswa_Alamat_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Alamat_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
        <th data-name="RT" class="<?= $Page->RT->headerCellClass() ?>"><div id="elh_mahasiswa_RT" class="mahasiswa_RT"><?= $Page->renderFieldHeader($Page->RT) ?></div></th>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
        <th data-name="RW" class="<?= $Page->RW->headerCellClass() ?>"><div id="elh_mahasiswa_RW" class="mahasiswa_RW"><?= $Page->renderFieldHeader($Page->RW) ?></div></th>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <th data-name="Kelurahan" class="<?= $Page->Kelurahan->headerCellClass() ?>"><div id="elh_mahasiswa_Kelurahan" class="mahasiswa_Kelurahan"><?= $Page->renderFieldHeader($Page->Kelurahan) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <th data-name="Kode_Pos" class="<?= $Page->Kode_Pos->headerCellClass() ?>"><div id="elh_mahasiswa_Kode_Pos" class="mahasiswa_Kode_Pos"><?= $Page->renderFieldHeader($Page->Kode_Pos) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <th data-name="Nomor_Telpon_HP" class="<?= $Page->Nomor_Telpon_HP->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Telpon_HP" class="mahasiswa_Nomor_Telpon_HP"><?= $Page->renderFieldHeader($Page->Nomor_Telpon_HP) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_mahasiswa__Email" class="mahasiswa__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <th data-name="Jenis_Tinggal" class="<?= $Page->Jenis_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Tinggal" class="mahasiswa_Jenis_Tinggal"><?= $Page->renderFieldHeader($Page->Jenis_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <th data-name="Alat_Transportasi" class="<?= $Page->Alat_Transportasi->headerCellClass() ?>"><div id="elh_mahasiswa_Alat_Transportasi" class="mahasiswa_Alat_Transportasi"><?= $Page->renderFieldHeader($Page->Alat_Transportasi) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <th data-name="Sumber_Dana" class="<?= $Page->Sumber_Dana->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana" class="mahasiswa_Sumber_Dana"><?= $Page->renderFieldHeader($Page->Sumber_Dana) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <th data-name="Sumber_Dana_Beasiswa" class="<?= $Page->Sumber_Dana_Beasiswa->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana_Beasiswa" class="mahasiswa_Sumber_Dana_Beasiswa"><?= $Page->renderFieldHeader($Page->Sumber_Dana_Beasiswa) ?></div></th>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <th data-name="Jumlah_Sudara" class="<?= $Page->Jumlah_Sudara->headerCellClass() ?>"><div id="elh_mahasiswa_Jumlah_Sudara" class="mahasiswa_Jumlah_Sudara"><?= $Page->renderFieldHeader($Page->Jumlah_Sudara) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <th data-name="Status_Bekerja" class="<?= $Page->Status_Bekerja->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Bekerja" class="mahasiswa_Status_Bekerja"><?= $Page->renderFieldHeader($Page->Status_Bekerja) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <th data-name="Nomor_Asuransi" class="<?= $Page->Nomor_Asuransi->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Asuransi" class="mahasiswa_Nomor_Asuransi"><?= $Page->renderFieldHeader($Page->Nomor_Asuransi) ?></div></th>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
        <th data-name="Hobi" class="<?= $Page->Hobi->headerCellClass() ?>"><div id="elh_mahasiswa_Hobi" class="mahasiswa_Hobi"><?= $Page->renderFieldHeader($Page->Hobi) ?></div></th>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
        <th data-name="Foto" class="<?= $Page->Foto->headerCellClass() ?>"><div id="elh_mahasiswa_Foto" class="mahasiswa_Foto"><?= $Page->renderFieldHeader($Page->Foto) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <th data-name="Nama_Ayah" class="<?= $Page->Nama_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ayah" class="mahasiswa_Nama_Ayah"><?= $Page->renderFieldHeader($Page->Nama_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <th data-name="Pekerjaan_Ayah" class="<?= $Page->Pekerjaan_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ayah" class="mahasiswa_Pekerjaan_Ayah"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <th data-name="Nama_Ibu" class="<?= $Page->Nama_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ibu" class="mahasiswa_Nama_Ibu"><?= $Page->renderFieldHeader($Page->Nama_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <th data-name="Pekerjaan_Ibu" class="<?= $Page->Pekerjaan_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ibu" class="mahasiswa_Pekerjaan_Ibu"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <th data-name="Alamat_Orang_Tua" class="<?= $Page->Alamat_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Orang_Tua" class="mahasiswa_Alamat_Orang_Tua"><?= $Page->renderFieldHeader($Page->Alamat_Orang_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <th data-name="e_mail_Oranng_Tua" class="<?= $Page->e_mail_Oranng_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_e_mail_Oranng_Tua" class="mahasiswa_e_mail_Oranng_Tua"><?= $Page->renderFieldHeader($Page->e_mail_Oranng_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <th data-name="No_Kontak_Orang_Tua" class="<?= $Page->No_Kontak_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_No_Kontak_Orang_Tua" class="mahasiswa_No_Kontak_Orang_Tua"><?= $Page->renderFieldHeader($Page->No_Kontak_Orang_Tua) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
$isInlineAddOrCopy = ($Page->isCopy() || $Page->isAdd());
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Page->RowIndex == 0) {
    if (
        $Page->CurrentRow !== false
        && $Page->RowIndex !== '$rowindex$'
        && (!$Page->isGridAdd() || $Page->CurrentMode == "copy")
        && (!($isInlineAddOrCopy && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIM" class="el_mahasiswa_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama->Visible) { // Nama ?>
        <td data-name="Nama"<?= $Page->Nama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama" class="el_mahasiswa_Nama">
<span<?= $Page->Nama->viewAttributes() ?>>
<?= $Page->Nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Kelamin" class="el_mahasiswa_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <td data-name="Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Provinsi_Tempat_Lahir" class="el_mahasiswa_Provinsi_Tempat_Lahir">
<span<?= $Page->Provinsi_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Provinsi_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <td data-name="Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Lahir" class="el_mahasiswa_Kota_Tempat_Lahir">
<span<?= $Page->Kota_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <td data-name="Tanggal_Lahir"<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Lahir" class="el_mahasiswa_Tanggal_Lahir">
<span<?= $Page->Tanggal_Lahir->viewAttributes() ?>>
<?= $Page->Tanggal_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <td data-name="Golongan_Darah"<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Golongan_Darah" class="el_mahasiswa_Golongan_Darah">
<span<?= $Page->Golongan_Darah->viewAttributes() ?>>
<?= $Page->Golongan_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <td data-name="Tinggi_Badan"<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tinggi_Badan" class="el_mahasiswa_Tinggi_Badan">
<span<?= $Page->Tinggi_Badan->viewAttributes() ?>>
<?= $Page->Tinggi_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <td data-name="Berat_Badan"<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Berat_Badan" class="el_mahasiswa_Berat_Badan">
<span<?= $Page->Berat_Badan->viewAttributes() ?>>
<?= $Page->Berat_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <td data-name="Asal_sekolah"<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Asal_sekolah" class="el_mahasiswa_Asal_sekolah">
<span<?= $Page->Asal_sekolah->viewAttributes() ?>>
<?= $Page->Asal_sekolah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <td data-name="Tahun_Ijazah"<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tahun_Ijazah" class="el_mahasiswa_Tahun_Ijazah">
<span<?= $Page->Tahun_Ijazah->viewAttributes() ?>>
<?= $Page->Tahun_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <td data-name="Nomor_Ijazah"<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Ijazah" class="el_mahasiswa_Nomor_Ijazah">
<span<?= $Page->Nomor_Ijazah->viewAttributes() ?>>
<?= $Page->Nomor_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <td data-name="Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_10" class="el_mahasiswa_Nilai_Raport_Kelas_10">
<span<?= $Page->Nilai_Raport_Kelas_10->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_10->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <td data-name="Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_11" class="el_mahasiswa_Nilai_Raport_Kelas_11">
<span<?= $Page->Nilai_Raport_Kelas_11->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_11->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <td data-name="Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_12" class="el_mahasiswa_Nilai_Raport_Kelas_12">
<span<?= $Page->Nilai_Raport_Kelas_12->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_12->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <td data-name="Tanggal_Daftar"<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Daftar" class="el_mahasiswa_Tanggal_Daftar">
<span<?= $Page->Tanggal_Daftar->viewAttributes() ?>>
<?= $Page->Tanggal_Daftar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Test->Visible) { // No_Test ?>
        <td data-name="No_Test"<?= $Page->No_Test->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Test" class="el_mahasiswa_No_Test">
<span<?= $Page->No_Test->viewAttributes() ?>>
<?= $Page->No_Test->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <td data-name="Status_Masuk"<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Masuk" class="el_mahasiswa_Status_Masuk">
<span<?= $Page->Status_Masuk->viewAttributes() ?>>
<?= $Page->Status_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <td data-name="Jalur_Masuk"<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jalur_Masuk" class="el_mahasiswa_Jalur_Masuk">
<span<?= $Page->Jalur_Masuk->viewAttributes() ?>>
<?= $Page->Jalur_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <td data-name="Bukti_Lulus"<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Bukti_Lulus" class="el_mahasiswa_Bukti_Lulus">
<span<?= $Page->Bukti_Lulus->viewAttributes() ?>>
<?= $Page->Bukti_Lulus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <td data-name="Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Potensi_Akademik" class="el_mahasiswa_Tes_Potensi_Akademik">
<span<?= $Page->Tes_Potensi_Akademik->viewAttributes() ?>>
<?= $Page->Tes_Potensi_Akademik->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <td data-name="Tes_Wawancara"<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Wawancara" class="el_mahasiswa_Tes_Wawancara">
<span<?= $Page->Tes_Wawancara->viewAttributes() ?>>
<?= $Page->Tes_Wawancara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <td data-name="Tes_Kesehatan"<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Kesehatan" class="el_mahasiswa_Tes_Kesehatan">
<span<?= $Page->Tes_Kesehatan->viewAttributes() ?>>
<?= $Page->Tes_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <td data-name="Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_Kesehatan" class="el_mahasiswa_Hasil_Test_Kesehatan">
<span<?= $Page->Hasil_Test_Kesehatan->viewAttributes() ?>>
<?= $Page->Hasil_Test_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <td data-name="Test_MMPI"<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Test_MMPI" class="el_mahasiswa_Test_MMPI">
<span<?= $Page->Test_MMPI->viewAttributes() ?>>
<?= $Page->Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <td data-name="Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_MMPI" class="el_mahasiswa_Hasil_Test_MMPI">
<span<?= $Page->Hasil_Test_MMPI->viewAttributes() ?>>
<?= $Page->Hasil_Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <td data-name="Angkatan"<?= $Page->Angkatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Angkatan" class="el_mahasiswa_Angkatan">
<span<?= $Page->Angkatan->viewAttributes() ?>>
<?= $Page->Angkatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <td data-name="Tarif_SPP"<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tarif_SPP" class="el_mahasiswa_Tarif_SPP">
<span<?= $Page->Tarif_SPP->viewAttributes() ?>>
<?= $Page->Tarif_SPP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <td data-name="NIK_No_KTP"<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIK_No_KTP" class="el_mahasiswa_NIK_No_KTP">
<span<?= $Page->NIK_No_KTP->viewAttributes() ?>>
<?= $Page->NIK_No_KTP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_KK->Visible) { // No_KK ?>
        <td data-name="No_KK"<?= $Page->No_KK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_KK" class="el_mahasiswa_No_KK">
<span<?= $Page->No_KK->viewAttributes() ?>>
<?= $Page->No_KK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td data-name="NPWP"<?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NPWP" class="el_mahasiswa_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <td data-name="Status_Nikah"<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Nikah" class="el_mahasiswa_Status_Nikah">
<span<?= $Page->Status_Nikah->viewAttributes() ?>>
<?= $Page->Status_Nikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <td data-name="Kewarganegaraan"<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kewarganegaraan" class="el_mahasiswa_Kewarganegaraan">
<span<?= $Page->Kewarganegaraan->viewAttributes() ?>>
<?= $Page->Kewarganegaraan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <td data-name="Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Propinsi_Tempat_Tinggal" class="el_mahasiswa_Propinsi_Tempat_Tinggal">
<span<?= $Page->Propinsi_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Propinsi_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <td data-name="Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Tinggal" class="el_mahasiswa_Kota_Tempat_Tinggal">
<span<?= $Page->Kota_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <td data-name="Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kecamatan_Tempat_Tinggal" class="el_mahasiswa_Kecamatan_Tempat_Tinggal">
<span<?= $Page->Kecamatan_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kecamatan_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <td data-name="Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Tempat_Tinggal" class="el_mahasiswa_Alamat_Tempat_Tinggal">
<span<?= $Page->Alamat_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Alamat_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RT->Visible) { // RT ?>
        <td data-name="RT"<?= $Page->RT->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RT" class="el_mahasiswa_RT">
<span<?= $Page->RT->viewAttributes() ?>>
<?= $Page->RT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RW->Visible) { // RW ?>
        <td data-name="RW"<?= $Page->RW->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RW" class="el_mahasiswa_RW">
<span<?= $Page->RW->viewAttributes() ?>>
<?= $Page->RW->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <td data-name="Kelurahan"<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kelurahan" class="el_mahasiswa_Kelurahan">
<span<?= $Page->Kelurahan->viewAttributes() ?>>
<?= $Page->Kelurahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <td data-name="Kode_Pos"<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kode_Pos" class="el_mahasiswa_Kode_Pos">
<span<?= $Page->Kode_Pos->viewAttributes() ?>>
<?= $Page->Kode_Pos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <td data-name="Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Telpon_HP" class="el_mahasiswa_Nomor_Telpon_HP">
<span<?= $Page->Nomor_Telpon_HP->viewAttributes() ?>>
<?= $Page->Nomor_Telpon_HP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa__Email" class="el_mahasiswa__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <td data-name="Jenis_Tinggal"<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Tinggal" class="el_mahasiswa_Jenis_Tinggal">
<span<?= $Page->Jenis_Tinggal->viewAttributes() ?>>
<?= $Page->Jenis_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <td data-name="Alat_Transportasi"<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alat_Transportasi" class="el_mahasiswa_Alat_Transportasi">
<span<?= $Page->Alat_Transportasi->viewAttributes() ?>>
<?= $Page->Alat_Transportasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <td data-name="Sumber_Dana"<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana" class="el_mahasiswa_Sumber_Dana">
<span<?= $Page->Sumber_Dana->viewAttributes() ?>>
<?= $Page->Sumber_Dana->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <td data-name="Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana_Beasiswa" class="el_mahasiswa_Sumber_Dana_Beasiswa">
<span<?= $Page->Sumber_Dana_Beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_Dana_Beasiswa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <td data-name="Jumlah_Sudara"<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jumlah_Sudara" class="el_mahasiswa_Jumlah_Sudara">
<span<?= $Page->Jumlah_Sudara->viewAttributes() ?>>
<?= $Page->Jumlah_Sudara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <td data-name="Status_Bekerja"<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Bekerja" class="el_mahasiswa_Status_Bekerja">
<span<?= $Page->Status_Bekerja->viewAttributes() ?>>
<?= $Page->Status_Bekerja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <td data-name="Nomor_Asuransi"<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Asuransi" class="el_mahasiswa_Nomor_Asuransi">
<span<?= $Page->Nomor_Asuransi->viewAttributes() ?>>
<?= $Page->Nomor_Asuransi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hobi->Visible) { // Hobi ?>
        <td data-name="Hobi"<?= $Page->Hobi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hobi" class="el_mahasiswa_Hobi">
<span<?= $Page->Hobi->viewAttributes() ?>>
<?= $Page->Hobi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Foto->Visible) { // Foto ?>
        <td data-name="Foto"<?= $Page->Foto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Foto" class="el_mahasiswa_Foto">
<span<?= $Page->Foto->viewAttributes() ?>>
<?= $Page->Foto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <td data-name="Nama_Ayah"<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ayah" class="el_mahasiswa_Nama_Ayah">
<span<?= $Page->Nama_Ayah->viewAttributes() ?>>
<?= $Page->Nama_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <td data-name="Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ayah" class="el_mahasiswa_Pekerjaan_Ayah">
<span<?= $Page->Pekerjaan_Ayah->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <td data-name="Nama_Ibu"<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ibu" class="el_mahasiswa_Nama_Ibu">
<span<?= $Page->Nama_Ibu->viewAttributes() ?>>
<?= $Page->Nama_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <td data-name="Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ibu" class="el_mahasiswa_Pekerjaan_Ibu">
<span<?= $Page->Pekerjaan_Ibu->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <td data-name="Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Orang_Tua" class="el_mahasiswa_Alamat_Orang_Tua">
<span<?= $Page->Alamat_Orang_Tua->viewAttributes() ?>>
<?= $Page->Alamat_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <td data-name="e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_e_mail_Oranng_Tua" class="el_mahasiswa_e_mail_Oranng_Tua">
<span<?= $Page->e_mail_Oranng_Tua->viewAttributes() ?>>
<?= $Page->e_mail_Oranng_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <td data-name="No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Kontak_Orang_Tua" class="el_mahasiswa_No_Kontak_Orang_Tua">
<span<?= $Page->No_Kontak_Orang_Tua->viewAttributes() ?>>
<?= $Page->No_Kontak_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php // Begin of Empty Table by Masino Sinaga, September 10, 2023 ?>
<?php } else { ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { // --- Begin of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<table id="tbl_mahasiswalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
// $Page->renderListOptions(); // do not display for empty table, by Masino Sinaga, September 10, 2023

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_mahasiswa_NIM" class="mahasiswa_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
        <th data-name="Nama" class="<?= $Page->Nama->headerCellClass() ?>"><div id="elh_mahasiswa_Nama" class="mahasiswa_Nama"><?= $Page->renderFieldHeader($Page->Nama) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Kelamin" class="mahasiswa_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <th data-name="Provinsi_Tempat_Lahir" class="<?= $Page->Provinsi_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Provinsi_Tempat_Lahir" class="mahasiswa_Provinsi_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Provinsi_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <th data-name="Kota_Tempat_Lahir" class="<?= $Page->Kota_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Lahir" class="mahasiswa_Kota_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <th data-name="Tanggal_Lahir" class="<?= $Page->Tanggal_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Lahir" class="mahasiswa_Tanggal_Lahir"><?= $Page->renderFieldHeader($Page->Tanggal_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <th data-name="Golongan_Darah" class="<?= $Page->Golongan_Darah->headerCellClass() ?>"><div id="elh_mahasiswa_Golongan_Darah" class="mahasiswa_Golongan_Darah"><?= $Page->renderFieldHeader($Page->Golongan_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <th data-name="Tinggi_Badan" class="<?= $Page->Tinggi_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Tinggi_Badan" class="mahasiswa_Tinggi_Badan"><?= $Page->renderFieldHeader($Page->Tinggi_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <th data-name="Berat_Badan" class="<?= $Page->Berat_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Berat_Badan" class="mahasiswa_Berat_Badan"><?= $Page->renderFieldHeader($Page->Berat_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <th data-name="Asal_sekolah" class="<?= $Page->Asal_sekolah->headerCellClass() ?>"><div id="elh_mahasiswa_Asal_sekolah" class="mahasiswa_Asal_sekolah"><?= $Page->renderFieldHeader($Page->Asal_sekolah) ?></div></th>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <th data-name="Tahun_Ijazah" class="<?= $Page->Tahun_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Tahun_Ijazah" class="mahasiswa_Tahun_Ijazah"><?= $Page->renderFieldHeader($Page->Tahun_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <th data-name="Nomor_Ijazah" class="<?= $Page->Nomor_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Ijazah" class="mahasiswa_Nomor_Ijazah"><?= $Page->renderFieldHeader($Page->Nomor_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <th data-name="Nilai_Raport_Kelas_10" class="<?= $Page->Nilai_Raport_Kelas_10->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_10" class="mahasiswa_Nilai_Raport_Kelas_10"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_10) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <th data-name="Nilai_Raport_Kelas_11" class="<?= $Page->Nilai_Raport_Kelas_11->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_11" class="mahasiswa_Nilai_Raport_Kelas_11"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_11) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <th data-name="Nilai_Raport_Kelas_12" class="<?= $Page->Nilai_Raport_Kelas_12->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_12" class="mahasiswa_Nilai_Raport_Kelas_12"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_12) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <th data-name="Tanggal_Daftar" class="<?= $Page->Tanggal_Daftar->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Daftar" class="mahasiswa_Tanggal_Daftar"><?= $Page->renderFieldHeader($Page->Tanggal_Daftar) ?></div></th>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
        <th data-name="No_Test" class="<?= $Page->No_Test->headerCellClass() ?>"><div id="elh_mahasiswa_No_Test" class="mahasiswa_No_Test"><?= $Page->renderFieldHeader($Page->No_Test) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <th data-name="Status_Masuk" class="<?= $Page->Status_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Masuk" class="mahasiswa_Status_Masuk"><?= $Page->renderFieldHeader($Page->Status_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <th data-name="Jalur_Masuk" class="<?= $Page->Jalur_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Jalur_Masuk" class="mahasiswa_Jalur_Masuk"><?= $Page->renderFieldHeader($Page->Jalur_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <th data-name="Bukti_Lulus" class="<?= $Page->Bukti_Lulus->headerCellClass() ?>"><div id="elh_mahasiswa_Bukti_Lulus" class="mahasiswa_Bukti_Lulus"><?= $Page->renderFieldHeader($Page->Bukti_Lulus) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <th data-name="Tes_Potensi_Akademik" class="<?= $Page->Tes_Potensi_Akademik->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Potensi_Akademik" class="mahasiswa_Tes_Potensi_Akademik"><?= $Page->renderFieldHeader($Page->Tes_Potensi_Akademik) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <th data-name="Tes_Wawancara" class="<?= $Page->Tes_Wawancara->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Wawancara" class="mahasiswa_Tes_Wawancara"><?= $Page->renderFieldHeader($Page->Tes_Wawancara) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <th data-name="Tes_Kesehatan" class="<?= $Page->Tes_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Kesehatan" class="mahasiswa_Tes_Kesehatan"><?= $Page->renderFieldHeader($Page->Tes_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <th data-name="Hasil_Test_Kesehatan" class="<?= $Page->Hasil_Test_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_Kesehatan" class="mahasiswa_Hasil_Test_Kesehatan"><?= $Page->renderFieldHeader($Page->Hasil_Test_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <th data-name="Test_MMPI" class="<?= $Page->Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Test_MMPI" class="mahasiswa_Test_MMPI"><?= $Page->renderFieldHeader($Page->Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <th data-name="Hasil_Test_MMPI" class="<?= $Page->Hasil_Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_MMPI" class="mahasiswa_Hasil_Test_MMPI"><?= $Page->renderFieldHeader($Page->Hasil_Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <th data-name="Angkatan" class="<?= $Page->Angkatan->headerCellClass() ?>"><div id="elh_mahasiswa_Angkatan" class="mahasiswa_Angkatan"><?= $Page->renderFieldHeader($Page->Angkatan) ?></div></th>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <th data-name="Tarif_SPP" class="<?= $Page->Tarif_SPP->headerCellClass() ?>"><div id="elh_mahasiswa_Tarif_SPP" class="mahasiswa_Tarif_SPP"><?= $Page->renderFieldHeader($Page->Tarif_SPP) ?></div></th>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <th data-name="NIK_No_KTP" class="<?= $Page->NIK_No_KTP->headerCellClass() ?>"><div id="elh_mahasiswa_NIK_No_KTP" class="mahasiswa_NIK_No_KTP"><?= $Page->renderFieldHeader($Page->NIK_No_KTP) ?></div></th>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
        <th data-name="No_KK" class="<?= $Page->No_KK->headerCellClass() ?>"><div id="elh_mahasiswa_No_KK" class="mahasiswa_No_KK"><?= $Page->renderFieldHeader($Page->No_KK) ?></div></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th data-name="NPWP" class="<?= $Page->NPWP->headerCellClass() ?>"><div id="elh_mahasiswa_NPWP" class="mahasiswa_NPWP"><?= $Page->renderFieldHeader($Page->NPWP) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <th data-name="Status_Nikah" class="<?= $Page->Status_Nikah->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Nikah" class="mahasiswa_Status_Nikah"><?= $Page->renderFieldHeader($Page->Status_Nikah) ?></div></th>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <th data-name="Kewarganegaraan" class="<?= $Page->Kewarganegaraan->headerCellClass() ?>"><div id="elh_mahasiswa_Kewarganegaraan" class="mahasiswa_Kewarganegaraan"><?= $Page->renderFieldHeader($Page->Kewarganegaraan) ?></div></th>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <th data-name="Propinsi_Tempat_Tinggal" class="<?= $Page->Propinsi_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Propinsi_Tempat_Tinggal" class="mahasiswa_Propinsi_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Propinsi_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <th data-name="Kota_Tempat_Tinggal" class="<?= $Page->Kota_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Tinggal" class="mahasiswa_Kota_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <th data-name="Kecamatan_Tempat_Tinggal" class="<?= $Page->Kecamatan_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kecamatan_Tempat_Tinggal" class="mahasiswa_Kecamatan_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kecamatan_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <th data-name="Alamat_Tempat_Tinggal" class="<?= $Page->Alamat_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Tempat_Tinggal" class="mahasiswa_Alamat_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Alamat_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
        <th data-name="RT" class="<?= $Page->RT->headerCellClass() ?>"><div id="elh_mahasiswa_RT" class="mahasiswa_RT"><?= $Page->renderFieldHeader($Page->RT) ?></div></th>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
        <th data-name="RW" class="<?= $Page->RW->headerCellClass() ?>"><div id="elh_mahasiswa_RW" class="mahasiswa_RW"><?= $Page->renderFieldHeader($Page->RW) ?></div></th>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <th data-name="Kelurahan" class="<?= $Page->Kelurahan->headerCellClass() ?>"><div id="elh_mahasiswa_Kelurahan" class="mahasiswa_Kelurahan"><?= $Page->renderFieldHeader($Page->Kelurahan) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <th data-name="Kode_Pos" class="<?= $Page->Kode_Pos->headerCellClass() ?>"><div id="elh_mahasiswa_Kode_Pos" class="mahasiswa_Kode_Pos"><?= $Page->renderFieldHeader($Page->Kode_Pos) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <th data-name="Nomor_Telpon_HP" class="<?= $Page->Nomor_Telpon_HP->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Telpon_HP" class="mahasiswa_Nomor_Telpon_HP"><?= $Page->renderFieldHeader($Page->Nomor_Telpon_HP) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_mahasiswa__Email" class="mahasiswa__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <th data-name="Jenis_Tinggal" class="<?= $Page->Jenis_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Tinggal" class="mahasiswa_Jenis_Tinggal"><?= $Page->renderFieldHeader($Page->Jenis_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <th data-name="Alat_Transportasi" class="<?= $Page->Alat_Transportasi->headerCellClass() ?>"><div id="elh_mahasiswa_Alat_Transportasi" class="mahasiswa_Alat_Transportasi"><?= $Page->renderFieldHeader($Page->Alat_Transportasi) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <th data-name="Sumber_Dana" class="<?= $Page->Sumber_Dana->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana" class="mahasiswa_Sumber_Dana"><?= $Page->renderFieldHeader($Page->Sumber_Dana) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <th data-name="Sumber_Dana_Beasiswa" class="<?= $Page->Sumber_Dana_Beasiswa->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana_Beasiswa" class="mahasiswa_Sumber_Dana_Beasiswa"><?= $Page->renderFieldHeader($Page->Sumber_Dana_Beasiswa) ?></div></th>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <th data-name="Jumlah_Sudara" class="<?= $Page->Jumlah_Sudara->headerCellClass() ?>"><div id="elh_mahasiswa_Jumlah_Sudara" class="mahasiswa_Jumlah_Sudara"><?= $Page->renderFieldHeader($Page->Jumlah_Sudara) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <th data-name="Status_Bekerja" class="<?= $Page->Status_Bekerja->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Bekerja" class="mahasiswa_Status_Bekerja"><?= $Page->renderFieldHeader($Page->Status_Bekerja) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <th data-name="Nomor_Asuransi" class="<?= $Page->Nomor_Asuransi->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Asuransi" class="mahasiswa_Nomor_Asuransi"><?= $Page->renderFieldHeader($Page->Nomor_Asuransi) ?></div></th>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
        <th data-name="Hobi" class="<?= $Page->Hobi->headerCellClass() ?>"><div id="elh_mahasiswa_Hobi" class="mahasiswa_Hobi"><?= $Page->renderFieldHeader($Page->Hobi) ?></div></th>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
        <th data-name="Foto" class="<?= $Page->Foto->headerCellClass() ?>"><div id="elh_mahasiswa_Foto" class="mahasiswa_Foto"><?= $Page->renderFieldHeader($Page->Foto) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <th data-name="Nama_Ayah" class="<?= $Page->Nama_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ayah" class="mahasiswa_Nama_Ayah"><?= $Page->renderFieldHeader($Page->Nama_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <th data-name="Pekerjaan_Ayah" class="<?= $Page->Pekerjaan_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ayah" class="mahasiswa_Pekerjaan_Ayah"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <th data-name="Nama_Ibu" class="<?= $Page->Nama_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ibu" class="mahasiswa_Nama_Ibu"><?= $Page->renderFieldHeader($Page->Nama_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <th data-name="Pekerjaan_Ibu" class="<?= $Page->Pekerjaan_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ibu" class="mahasiswa_Pekerjaan_Ibu"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <th data-name="Alamat_Orang_Tua" class="<?= $Page->Alamat_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Orang_Tua" class="mahasiswa_Alamat_Orang_Tua"><?= $Page->renderFieldHeader($Page->Alamat_Orang_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <th data-name="e_mail_Oranng_Tua" class="<?= $Page->e_mail_Oranng_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_e_mail_Oranng_Tua" class="mahasiswa_e_mail_Oranng_Tua"><?= $Page->renderFieldHeader($Page->e_mail_Oranng_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <th data-name="No_Kontak_Orang_Tua" class="<?= $Page->No_Kontak_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_No_Kontak_Orang_Tua" class="mahasiswa_No_Kontak_Orang_Tua"><?= $Page->renderFieldHeader($Page->No_Kontak_Orang_Tua) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
    <tr class="border-bottom-0" style="height:36px;">
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIM" class="el_mahasiswa_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama->Visible) { // Nama ?>
        <td data-name="Nama"<?= $Page->Nama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama" class="el_mahasiswa_Nama">
<span<?= $Page->Nama->viewAttributes() ?>>
<?= $Page->Nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Kelamin" class="el_mahasiswa_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <td data-name="Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Provinsi_Tempat_Lahir" class="el_mahasiswa_Provinsi_Tempat_Lahir">
<span<?= $Page->Provinsi_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Provinsi_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <td data-name="Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Lahir" class="el_mahasiswa_Kota_Tempat_Lahir">
<span<?= $Page->Kota_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <td data-name="Tanggal_Lahir"<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Lahir" class="el_mahasiswa_Tanggal_Lahir">
<span<?= $Page->Tanggal_Lahir->viewAttributes() ?>>
<?= $Page->Tanggal_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <td data-name="Golongan_Darah"<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Golongan_Darah" class="el_mahasiswa_Golongan_Darah">
<span<?= $Page->Golongan_Darah->viewAttributes() ?>>
<?= $Page->Golongan_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <td data-name="Tinggi_Badan"<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tinggi_Badan" class="el_mahasiswa_Tinggi_Badan">
<span<?= $Page->Tinggi_Badan->viewAttributes() ?>>
<?= $Page->Tinggi_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <td data-name="Berat_Badan"<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Berat_Badan" class="el_mahasiswa_Berat_Badan">
<span<?= $Page->Berat_Badan->viewAttributes() ?>>
<?= $Page->Berat_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <td data-name="Asal_sekolah"<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Asal_sekolah" class="el_mahasiswa_Asal_sekolah">
<span<?= $Page->Asal_sekolah->viewAttributes() ?>>
<?= $Page->Asal_sekolah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <td data-name="Tahun_Ijazah"<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tahun_Ijazah" class="el_mahasiswa_Tahun_Ijazah">
<span<?= $Page->Tahun_Ijazah->viewAttributes() ?>>
<?= $Page->Tahun_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <td data-name="Nomor_Ijazah"<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Ijazah" class="el_mahasiswa_Nomor_Ijazah">
<span<?= $Page->Nomor_Ijazah->viewAttributes() ?>>
<?= $Page->Nomor_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <td data-name="Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_10" class="el_mahasiswa_Nilai_Raport_Kelas_10">
<span<?= $Page->Nilai_Raport_Kelas_10->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_10->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <td data-name="Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_11" class="el_mahasiswa_Nilai_Raport_Kelas_11">
<span<?= $Page->Nilai_Raport_Kelas_11->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_11->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <td data-name="Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_12" class="el_mahasiswa_Nilai_Raport_Kelas_12">
<span<?= $Page->Nilai_Raport_Kelas_12->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_12->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <td data-name="Tanggal_Daftar"<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Daftar" class="el_mahasiswa_Tanggal_Daftar">
<span<?= $Page->Tanggal_Daftar->viewAttributes() ?>>
<?= $Page->Tanggal_Daftar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Test->Visible) { // No_Test ?>
        <td data-name="No_Test"<?= $Page->No_Test->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Test" class="el_mahasiswa_No_Test">
<span<?= $Page->No_Test->viewAttributes() ?>>
<?= $Page->No_Test->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <td data-name="Status_Masuk"<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Masuk" class="el_mahasiswa_Status_Masuk">
<span<?= $Page->Status_Masuk->viewAttributes() ?>>
<?= $Page->Status_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <td data-name="Jalur_Masuk"<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jalur_Masuk" class="el_mahasiswa_Jalur_Masuk">
<span<?= $Page->Jalur_Masuk->viewAttributes() ?>>
<?= $Page->Jalur_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <td data-name="Bukti_Lulus"<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Bukti_Lulus" class="el_mahasiswa_Bukti_Lulus">
<span<?= $Page->Bukti_Lulus->viewAttributes() ?>>
<?= $Page->Bukti_Lulus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <td data-name="Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Potensi_Akademik" class="el_mahasiswa_Tes_Potensi_Akademik">
<span<?= $Page->Tes_Potensi_Akademik->viewAttributes() ?>>
<?= $Page->Tes_Potensi_Akademik->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <td data-name="Tes_Wawancara"<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Wawancara" class="el_mahasiswa_Tes_Wawancara">
<span<?= $Page->Tes_Wawancara->viewAttributes() ?>>
<?= $Page->Tes_Wawancara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <td data-name="Tes_Kesehatan"<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Kesehatan" class="el_mahasiswa_Tes_Kesehatan">
<span<?= $Page->Tes_Kesehatan->viewAttributes() ?>>
<?= $Page->Tes_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <td data-name="Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_Kesehatan" class="el_mahasiswa_Hasil_Test_Kesehatan">
<span<?= $Page->Hasil_Test_Kesehatan->viewAttributes() ?>>
<?= $Page->Hasil_Test_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <td data-name="Test_MMPI"<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Test_MMPI" class="el_mahasiswa_Test_MMPI">
<span<?= $Page->Test_MMPI->viewAttributes() ?>>
<?= $Page->Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <td data-name="Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_MMPI" class="el_mahasiswa_Hasil_Test_MMPI">
<span<?= $Page->Hasil_Test_MMPI->viewAttributes() ?>>
<?= $Page->Hasil_Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <td data-name="Angkatan"<?= $Page->Angkatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Angkatan" class="el_mahasiswa_Angkatan">
<span<?= $Page->Angkatan->viewAttributes() ?>>
<?= $Page->Angkatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <td data-name="Tarif_SPP"<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tarif_SPP" class="el_mahasiswa_Tarif_SPP">
<span<?= $Page->Tarif_SPP->viewAttributes() ?>>
<?= $Page->Tarif_SPP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <td data-name="NIK_No_KTP"<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIK_No_KTP" class="el_mahasiswa_NIK_No_KTP">
<span<?= $Page->NIK_No_KTP->viewAttributes() ?>>
<?= $Page->NIK_No_KTP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_KK->Visible) { // No_KK ?>
        <td data-name="No_KK"<?= $Page->No_KK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_KK" class="el_mahasiswa_No_KK">
<span<?= $Page->No_KK->viewAttributes() ?>>
<?= $Page->No_KK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td data-name="NPWP"<?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NPWP" class="el_mahasiswa_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <td data-name="Status_Nikah"<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Nikah" class="el_mahasiswa_Status_Nikah">
<span<?= $Page->Status_Nikah->viewAttributes() ?>>
<?= $Page->Status_Nikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <td data-name="Kewarganegaraan"<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kewarganegaraan" class="el_mahasiswa_Kewarganegaraan">
<span<?= $Page->Kewarganegaraan->viewAttributes() ?>>
<?= $Page->Kewarganegaraan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <td data-name="Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Propinsi_Tempat_Tinggal" class="el_mahasiswa_Propinsi_Tempat_Tinggal">
<span<?= $Page->Propinsi_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Propinsi_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <td data-name="Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Tinggal" class="el_mahasiswa_Kota_Tempat_Tinggal">
<span<?= $Page->Kota_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <td data-name="Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kecamatan_Tempat_Tinggal" class="el_mahasiswa_Kecamatan_Tempat_Tinggal">
<span<?= $Page->Kecamatan_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kecamatan_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <td data-name="Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Tempat_Tinggal" class="el_mahasiswa_Alamat_Tempat_Tinggal">
<span<?= $Page->Alamat_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Alamat_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RT->Visible) { // RT ?>
        <td data-name="RT"<?= $Page->RT->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RT" class="el_mahasiswa_RT">
<span<?= $Page->RT->viewAttributes() ?>>
<?= $Page->RT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RW->Visible) { // RW ?>
        <td data-name="RW"<?= $Page->RW->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RW" class="el_mahasiswa_RW">
<span<?= $Page->RW->viewAttributes() ?>>
<?= $Page->RW->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <td data-name="Kelurahan"<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kelurahan" class="el_mahasiswa_Kelurahan">
<span<?= $Page->Kelurahan->viewAttributes() ?>>
<?= $Page->Kelurahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <td data-name="Kode_Pos"<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kode_Pos" class="el_mahasiswa_Kode_Pos">
<span<?= $Page->Kode_Pos->viewAttributes() ?>>
<?= $Page->Kode_Pos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <td data-name="Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Telpon_HP" class="el_mahasiswa_Nomor_Telpon_HP">
<span<?= $Page->Nomor_Telpon_HP->viewAttributes() ?>>
<?= $Page->Nomor_Telpon_HP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa__Email" class="el_mahasiswa__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <td data-name="Jenis_Tinggal"<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Tinggal" class="el_mahasiswa_Jenis_Tinggal">
<span<?= $Page->Jenis_Tinggal->viewAttributes() ?>>
<?= $Page->Jenis_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <td data-name="Alat_Transportasi"<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alat_Transportasi" class="el_mahasiswa_Alat_Transportasi">
<span<?= $Page->Alat_Transportasi->viewAttributes() ?>>
<?= $Page->Alat_Transportasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <td data-name="Sumber_Dana"<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana" class="el_mahasiswa_Sumber_Dana">
<span<?= $Page->Sumber_Dana->viewAttributes() ?>>
<?= $Page->Sumber_Dana->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <td data-name="Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana_Beasiswa" class="el_mahasiswa_Sumber_Dana_Beasiswa">
<span<?= $Page->Sumber_Dana_Beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_Dana_Beasiswa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <td data-name="Jumlah_Sudara"<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jumlah_Sudara" class="el_mahasiswa_Jumlah_Sudara">
<span<?= $Page->Jumlah_Sudara->viewAttributes() ?>>
<?= $Page->Jumlah_Sudara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <td data-name="Status_Bekerja"<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Bekerja" class="el_mahasiswa_Status_Bekerja">
<span<?= $Page->Status_Bekerja->viewAttributes() ?>>
<?= $Page->Status_Bekerja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <td data-name="Nomor_Asuransi"<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Asuransi" class="el_mahasiswa_Nomor_Asuransi">
<span<?= $Page->Nomor_Asuransi->viewAttributes() ?>>
<?= $Page->Nomor_Asuransi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hobi->Visible) { // Hobi ?>
        <td data-name="Hobi"<?= $Page->Hobi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hobi" class="el_mahasiswa_Hobi">
<span<?= $Page->Hobi->viewAttributes() ?>>
<?= $Page->Hobi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Foto->Visible) { // Foto ?>
        <td data-name="Foto"<?= $Page->Foto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Foto" class="el_mahasiswa_Foto">
<span<?= $Page->Foto->viewAttributes() ?>>
<?= $Page->Foto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <td data-name="Nama_Ayah"<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ayah" class="el_mahasiswa_Nama_Ayah">
<span<?= $Page->Nama_Ayah->viewAttributes() ?>>
<?= $Page->Nama_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <td data-name="Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ayah" class="el_mahasiswa_Pekerjaan_Ayah">
<span<?= $Page->Pekerjaan_Ayah->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <td data-name="Nama_Ibu"<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ibu" class="el_mahasiswa_Nama_Ibu">
<span<?= $Page->Nama_Ibu->viewAttributes() ?>>
<?= $Page->Nama_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <td data-name="Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ibu" class="el_mahasiswa_Pekerjaan_Ibu">
<span<?= $Page->Pekerjaan_Ibu->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <td data-name="Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Orang_Tua" class="el_mahasiswa_Alamat_Orang_Tua">
<span<?= $Page->Alamat_Orang_Tua->viewAttributes() ?>>
<?= $Page->Alamat_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <td data-name="e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_e_mail_Oranng_Tua" class="el_mahasiswa_e_mail_Oranng_Tua">
<span<?= $Page->e_mail_Oranng_Tua->viewAttributes() ?>>
<?= $Page->e_mail_Oranng_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <td data-name="No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Kontak_Orang_Tua" class="el_mahasiswa_No_Kontak_Orang_Tua">
<span<?= $Page->No_Kontak_Orang_Tua->viewAttributes() ?>>
<?= $Page->No_Kontak_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
</tbody>
</table><!-- /.ew-table -->
<?php } // --- End of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<?php // End of Empty Table by Masino Sinaga, September 10, 2023 ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Result?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<?php // Begin of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mahasiswa">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_mahasiswa" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_mahasiswalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_mahasiswa_NIM" class="mahasiswa_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
        <th data-name="Nama" class="<?= $Page->Nama->headerCellClass() ?>"><div id="elh_mahasiswa_Nama" class="mahasiswa_Nama"><?= $Page->renderFieldHeader($Page->Nama) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Kelamin" class="mahasiswa_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <th data-name="Provinsi_Tempat_Lahir" class="<?= $Page->Provinsi_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Provinsi_Tempat_Lahir" class="mahasiswa_Provinsi_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Provinsi_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <th data-name="Kota_Tempat_Lahir" class="<?= $Page->Kota_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Lahir" class="mahasiswa_Kota_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <th data-name="Tanggal_Lahir" class="<?= $Page->Tanggal_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Lahir" class="mahasiswa_Tanggal_Lahir"><?= $Page->renderFieldHeader($Page->Tanggal_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <th data-name="Golongan_Darah" class="<?= $Page->Golongan_Darah->headerCellClass() ?>"><div id="elh_mahasiswa_Golongan_Darah" class="mahasiswa_Golongan_Darah"><?= $Page->renderFieldHeader($Page->Golongan_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <th data-name="Tinggi_Badan" class="<?= $Page->Tinggi_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Tinggi_Badan" class="mahasiswa_Tinggi_Badan"><?= $Page->renderFieldHeader($Page->Tinggi_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <th data-name="Berat_Badan" class="<?= $Page->Berat_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Berat_Badan" class="mahasiswa_Berat_Badan"><?= $Page->renderFieldHeader($Page->Berat_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <th data-name="Asal_sekolah" class="<?= $Page->Asal_sekolah->headerCellClass() ?>"><div id="elh_mahasiswa_Asal_sekolah" class="mahasiswa_Asal_sekolah"><?= $Page->renderFieldHeader($Page->Asal_sekolah) ?></div></th>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <th data-name="Tahun_Ijazah" class="<?= $Page->Tahun_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Tahun_Ijazah" class="mahasiswa_Tahun_Ijazah"><?= $Page->renderFieldHeader($Page->Tahun_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <th data-name="Nomor_Ijazah" class="<?= $Page->Nomor_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Ijazah" class="mahasiswa_Nomor_Ijazah"><?= $Page->renderFieldHeader($Page->Nomor_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <th data-name="Nilai_Raport_Kelas_10" class="<?= $Page->Nilai_Raport_Kelas_10->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_10" class="mahasiswa_Nilai_Raport_Kelas_10"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_10) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <th data-name="Nilai_Raport_Kelas_11" class="<?= $Page->Nilai_Raport_Kelas_11->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_11" class="mahasiswa_Nilai_Raport_Kelas_11"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_11) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <th data-name="Nilai_Raport_Kelas_12" class="<?= $Page->Nilai_Raport_Kelas_12->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_12" class="mahasiswa_Nilai_Raport_Kelas_12"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_12) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <th data-name="Tanggal_Daftar" class="<?= $Page->Tanggal_Daftar->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Daftar" class="mahasiswa_Tanggal_Daftar"><?= $Page->renderFieldHeader($Page->Tanggal_Daftar) ?></div></th>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
        <th data-name="No_Test" class="<?= $Page->No_Test->headerCellClass() ?>"><div id="elh_mahasiswa_No_Test" class="mahasiswa_No_Test"><?= $Page->renderFieldHeader($Page->No_Test) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <th data-name="Status_Masuk" class="<?= $Page->Status_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Masuk" class="mahasiswa_Status_Masuk"><?= $Page->renderFieldHeader($Page->Status_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <th data-name="Jalur_Masuk" class="<?= $Page->Jalur_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Jalur_Masuk" class="mahasiswa_Jalur_Masuk"><?= $Page->renderFieldHeader($Page->Jalur_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <th data-name="Bukti_Lulus" class="<?= $Page->Bukti_Lulus->headerCellClass() ?>"><div id="elh_mahasiswa_Bukti_Lulus" class="mahasiswa_Bukti_Lulus"><?= $Page->renderFieldHeader($Page->Bukti_Lulus) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <th data-name="Tes_Potensi_Akademik" class="<?= $Page->Tes_Potensi_Akademik->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Potensi_Akademik" class="mahasiswa_Tes_Potensi_Akademik"><?= $Page->renderFieldHeader($Page->Tes_Potensi_Akademik) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <th data-name="Tes_Wawancara" class="<?= $Page->Tes_Wawancara->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Wawancara" class="mahasiswa_Tes_Wawancara"><?= $Page->renderFieldHeader($Page->Tes_Wawancara) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <th data-name="Tes_Kesehatan" class="<?= $Page->Tes_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Kesehatan" class="mahasiswa_Tes_Kesehatan"><?= $Page->renderFieldHeader($Page->Tes_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <th data-name="Hasil_Test_Kesehatan" class="<?= $Page->Hasil_Test_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_Kesehatan" class="mahasiswa_Hasil_Test_Kesehatan"><?= $Page->renderFieldHeader($Page->Hasil_Test_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <th data-name="Test_MMPI" class="<?= $Page->Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Test_MMPI" class="mahasiswa_Test_MMPI"><?= $Page->renderFieldHeader($Page->Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <th data-name="Hasil_Test_MMPI" class="<?= $Page->Hasil_Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_MMPI" class="mahasiswa_Hasil_Test_MMPI"><?= $Page->renderFieldHeader($Page->Hasil_Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <th data-name="Angkatan" class="<?= $Page->Angkatan->headerCellClass() ?>"><div id="elh_mahasiswa_Angkatan" class="mahasiswa_Angkatan"><?= $Page->renderFieldHeader($Page->Angkatan) ?></div></th>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <th data-name="Tarif_SPP" class="<?= $Page->Tarif_SPP->headerCellClass() ?>"><div id="elh_mahasiswa_Tarif_SPP" class="mahasiswa_Tarif_SPP"><?= $Page->renderFieldHeader($Page->Tarif_SPP) ?></div></th>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <th data-name="NIK_No_KTP" class="<?= $Page->NIK_No_KTP->headerCellClass() ?>"><div id="elh_mahasiswa_NIK_No_KTP" class="mahasiswa_NIK_No_KTP"><?= $Page->renderFieldHeader($Page->NIK_No_KTP) ?></div></th>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
        <th data-name="No_KK" class="<?= $Page->No_KK->headerCellClass() ?>"><div id="elh_mahasiswa_No_KK" class="mahasiswa_No_KK"><?= $Page->renderFieldHeader($Page->No_KK) ?></div></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th data-name="NPWP" class="<?= $Page->NPWP->headerCellClass() ?>"><div id="elh_mahasiswa_NPWP" class="mahasiswa_NPWP"><?= $Page->renderFieldHeader($Page->NPWP) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <th data-name="Status_Nikah" class="<?= $Page->Status_Nikah->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Nikah" class="mahasiswa_Status_Nikah"><?= $Page->renderFieldHeader($Page->Status_Nikah) ?></div></th>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <th data-name="Kewarganegaraan" class="<?= $Page->Kewarganegaraan->headerCellClass() ?>"><div id="elh_mahasiswa_Kewarganegaraan" class="mahasiswa_Kewarganegaraan"><?= $Page->renderFieldHeader($Page->Kewarganegaraan) ?></div></th>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <th data-name="Propinsi_Tempat_Tinggal" class="<?= $Page->Propinsi_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Propinsi_Tempat_Tinggal" class="mahasiswa_Propinsi_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Propinsi_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <th data-name="Kota_Tempat_Tinggal" class="<?= $Page->Kota_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Tinggal" class="mahasiswa_Kota_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <th data-name="Kecamatan_Tempat_Tinggal" class="<?= $Page->Kecamatan_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kecamatan_Tempat_Tinggal" class="mahasiswa_Kecamatan_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kecamatan_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <th data-name="Alamat_Tempat_Tinggal" class="<?= $Page->Alamat_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Tempat_Tinggal" class="mahasiswa_Alamat_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Alamat_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
        <th data-name="RT" class="<?= $Page->RT->headerCellClass() ?>"><div id="elh_mahasiswa_RT" class="mahasiswa_RT"><?= $Page->renderFieldHeader($Page->RT) ?></div></th>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
        <th data-name="RW" class="<?= $Page->RW->headerCellClass() ?>"><div id="elh_mahasiswa_RW" class="mahasiswa_RW"><?= $Page->renderFieldHeader($Page->RW) ?></div></th>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <th data-name="Kelurahan" class="<?= $Page->Kelurahan->headerCellClass() ?>"><div id="elh_mahasiswa_Kelurahan" class="mahasiswa_Kelurahan"><?= $Page->renderFieldHeader($Page->Kelurahan) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <th data-name="Kode_Pos" class="<?= $Page->Kode_Pos->headerCellClass() ?>"><div id="elh_mahasiswa_Kode_Pos" class="mahasiswa_Kode_Pos"><?= $Page->renderFieldHeader($Page->Kode_Pos) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <th data-name="Nomor_Telpon_HP" class="<?= $Page->Nomor_Telpon_HP->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Telpon_HP" class="mahasiswa_Nomor_Telpon_HP"><?= $Page->renderFieldHeader($Page->Nomor_Telpon_HP) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_mahasiswa__Email" class="mahasiswa__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <th data-name="Jenis_Tinggal" class="<?= $Page->Jenis_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Tinggal" class="mahasiswa_Jenis_Tinggal"><?= $Page->renderFieldHeader($Page->Jenis_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <th data-name="Alat_Transportasi" class="<?= $Page->Alat_Transportasi->headerCellClass() ?>"><div id="elh_mahasiswa_Alat_Transportasi" class="mahasiswa_Alat_Transportasi"><?= $Page->renderFieldHeader($Page->Alat_Transportasi) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <th data-name="Sumber_Dana" class="<?= $Page->Sumber_Dana->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana" class="mahasiswa_Sumber_Dana"><?= $Page->renderFieldHeader($Page->Sumber_Dana) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <th data-name="Sumber_Dana_Beasiswa" class="<?= $Page->Sumber_Dana_Beasiswa->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana_Beasiswa" class="mahasiswa_Sumber_Dana_Beasiswa"><?= $Page->renderFieldHeader($Page->Sumber_Dana_Beasiswa) ?></div></th>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <th data-name="Jumlah_Sudara" class="<?= $Page->Jumlah_Sudara->headerCellClass() ?>"><div id="elh_mahasiswa_Jumlah_Sudara" class="mahasiswa_Jumlah_Sudara"><?= $Page->renderFieldHeader($Page->Jumlah_Sudara) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <th data-name="Status_Bekerja" class="<?= $Page->Status_Bekerja->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Bekerja" class="mahasiswa_Status_Bekerja"><?= $Page->renderFieldHeader($Page->Status_Bekerja) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <th data-name="Nomor_Asuransi" class="<?= $Page->Nomor_Asuransi->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Asuransi" class="mahasiswa_Nomor_Asuransi"><?= $Page->renderFieldHeader($Page->Nomor_Asuransi) ?></div></th>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
        <th data-name="Hobi" class="<?= $Page->Hobi->headerCellClass() ?>"><div id="elh_mahasiswa_Hobi" class="mahasiswa_Hobi"><?= $Page->renderFieldHeader($Page->Hobi) ?></div></th>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
        <th data-name="Foto" class="<?= $Page->Foto->headerCellClass() ?>"><div id="elh_mahasiswa_Foto" class="mahasiswa_Foto"><?= $Page->renderFieldHeader($Page->Foto) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <th data-name="Nama_Ayah" class="<?= $Page->Nama_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ayah" class="mahasiswa_Nama_Ayah"><?= $Page->renderFieldHeader($Page->Nama_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <th data-name="Pekerjaan_Ayah" class="<?= $Page->Pekerjaan_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ayah" class="mahasiswa_Pekerjaan_Ayah"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <th data-name="Nama_Ibu" class="<?= $Page->Nama_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ibu" class="mahasiswa_Nama_Ibu"><?= $Page->renderFieldHeader($Page->Nama_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <th data-name="Pekerjaan_Ibu" class="<?= $Page->Pekerjaan_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ibu" class="mahasiswa_Pekerjaan_Ibu"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <th data-name="Alamat_Orang_Tua" class="<?= $Page->Alamat_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Orang_Tua" class="mahasiswa_Alamat_Orang_Tua"><?= $Page->renderFieldHeader($Page->Alamat_Orang_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <th data-name="e_mail_Oranng_Tua" class="<?= $Page->e_mail_Oranng_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_e_mail_Oranng_Tua" class="mahasiswa_e_mail_Oranng_Tua"><?= $Page->renderFieldHeader($Page->e_mail_Oranng_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <th data-name="No_Kontak_Orang_Tua" class="<?= $Page->No_Kontak_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_No_Kontak_Orang_Tua" class="mahasiswa_No_Kontak_Orang_Tua"><?= $Page->renderFieldHeader($Page->No_Kontak_Orang_Tua) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
$isInlineAddOrCopy = ($Page->isCopy() || $Page->isAdd());
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Page->RowIndex == 0) {
    if (
        $Page->CurrentRow !== false
        && $Page->RowIndex !== '$rowindex$'
        && (!$Page->isGridAdd() || $Page->CurrentMode == "copy")
        && (!($isInlineAddOrCopy && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIM" class="el_mahasiswa_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama->Visible) { // Nama ?>
        <td data-name="Nama"<?= $Page->Nama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama" class="el_mahasiswa_Nama">
<span<?= $Page->Nama->viewAttributes() ?>>
<?= $Page->Nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Kelamin" class="el_mahasiswa_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <td data-name="Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Provinsi_Tempat_Lahir" class="el_mahasiswa_Provinsi_Tempat_Lahir">
<span<?= $Page->Provinsi_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Provinsi_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <td data-name="Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Lahir" class="el_mahasiswa_Kota_Tempat_Lahir">
<span<?= $Page->Kota_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <td data-name="Tanggal_Lahir"<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Lahir" class="el_mahasiswa_Tanggal_Lahir">
<span<?= $Page->Tanggal_Lahir->viewAttributes() ?>>
<?= $Page->Tanggal_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <td data-name="Golongan_Darah"<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Golongan_Darah" class="el_mahasiswa_Golongan_Darah">
<span<?= $Page->Golongan_Darah->viewAttributes() ?>>
<?= $Page->Golongan_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <td data-name="Tinggi_Badan"<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tinggi_Badan" class="el_mahasiswa_Tinggi_Badan">
<span<?= $Page->Tinggi_Badan->viewAttributes() ?>>
<?= $Page->Tinggi_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <td data-name="Berat_Badan"<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Berat_Badan" class="el_mahasiswa_Berat_Badan">
<span<?= $Page->Berat_Badan->viewAttributes() ?>>
<?= $Page->Berat_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <td data-name="Asal_sekolah"<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Asal_sekolah" class="el_mahasiswa_Asal_sekolah">
<span<?= $Page->Asal_sekolah->viewAttributes() ?>>
<?= $Page->Asal_sekolah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <td data-name="Tahun_Ijazah"<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tahun_Ijazah" class="el_mahasiswa_Tahun_Ijazah">
<span<?= $Page->Tahun_Ijazah->viewAttributes() ?>>
<?= $Page->Tahun_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <td data-name="Nomor_Ijazah"<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Ijazah" class="el_mahasiswa_Nomor_Ijazah">
<span<?= $Page->Nomor_Ijazah->viewAttributes() ?>>
<?= $Page->Nomor_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <td data-name="Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_10" class="el_mahasiswa_Nilai_Raport_Kelas_10">
<span<?= $Page->Nilai_Raport_Kelas_10->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_10->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <td data-name="Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_11" class="el_mahasiswa_Nilai_Raport_Kelas_11">
<span<?= $Page->Nilai_Raport_Kelas_11->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_11->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <td data-name="Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_12" class="el_mahasiswa_Nilai_Raport_Kelas_12">
<span<?= $Page->Nilai_Raport_Kelas_12->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_12->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <td data-name="Tanggal_Daftar"<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Daftar" class="el_mahasiswa_Tanggal_Daftar">
<span<?= $Page->Tanggal_Daftar->viewAttributes() ?>>
<?= $Page->Tanggal_Daftar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Test->Visible) { // No_Test ?>
        <td data-name="No_Test"<?= $Page->No_Test->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Test" class="el_mahasiswa_No_Test">
<span<?= $Page->No_Test->viewAttributes() ?>>
<?= $Page->No_Test->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <td data-name="Status_Masuk"<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Masuk" class="el_mahasiswa_Status_Masuk">
<span<?= $Page->Status_Masuk->viewAttributes() ?>>
<?= $Page->Status_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <td data-name="Jalur_Masuk"<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jalur_Masuk" class="el_mahasiswa_Jalur_Masuk">
<span<?= $Page->Jalur_Masuk->viewAttributes() ?>>
<?= $Page->Jalur_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <td data-name="Bukti_Lulus"<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Bukti_Lulus" class="el_mahasiswa_Bukti_Lulus">
<span<?= $Page->Bukti_Lulus->viewAttributes() ?>>
<?= $Page->Bukti_Lulus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <td data-name="Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Potensi_Akademik" class="el_mahasiswa_Tes_Potensi_Akademik">
<span<?= $Page->Tes_Potensi_Akademik->viewAttributes() ?>>
<?= $Page->Tes_Potensi_Akademik->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <td data-name="Tes_Wawancara"<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Wawancara" class="el_mahasiswa_Tes_Wawancara">
<span<?= $Page->Tes_Wawancara->viewAttributes() ?>>
<?= $Page->Tes_Wawancara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <td data-name="Tes_Kesehatan"<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Kesehatan" class="el_mahasiswa_Tes_Kesehatan">
<span<?= $Page->Tes_Kesehatan->viewAttributes() ?>>
<?= $Page->Tes_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <td data-name="Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_Kesehatan" class="el_mahasiswa_Hasil_Test_Kesehatan">
<span<?= $Page->Hasil_Test_Kesehatan->viewAttributes() ?>>
<?= $Page->Hasil_Test_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <td data-name="Test_MMPI"<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Test_MMPI" class="el_mahasiswa_Test_MMPI">
<span<?= $Page->Test_MMPI->viewAttributes() ?>>
<?= $Page->Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <td data-name="Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_MMPI" class="el_mahasiswa_Hasil_Test_MMPI">
<span<?= $Page->Hasil_Test_MMPI->viewAttributes() ?>>
<?= $Page->Hasil_Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <td data-name="Angkatan"<?= $Page->Angkatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Angkatan" class="el_mahasiswa_Angkatan">
<span<?= $Page->Angkatan->viewAttributes() ?>>
<?= $Page->Angkatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <td data-name="Tarif_SPP"<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tarif_SPP" class="el_mahasiswa_Tarif_SPP">
<span<?= $Page->Tarif_SPP->viewAttributes() ?>>
<?= $Page->Tarif_SPP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <td data-name="NIK_No_KTP"<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIK_No_KTP" class="el_mahasiswa_NIK_No_KTP">
<span<?= $Page->NIK_No_KTP->viewAttributes() ?>>
<?= $Page->NIK_No_KTP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_KK->Visible) { // No_KK ?>
        <td data-name="No_KK"<?= $Page->No_KK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_KK" class="el_mahasiswa_No_KK">
<span<?= $Page->No_KK->viewAttributes() ?>>
<?= $Page->No_KK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td data-name="NPWP"<?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NPWP" class="el_mahasiswa_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <td data-name="Status_Nikah"<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Nikah" class="el_mahasiswa_Status_Nikah">
<span<?= $Page->Status_Nikah->viewAttributes() ?>>
<?= $Page->Status_Nikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <td data-name="Kewarganegaraan"<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kewarganegaraan" class="el_mahasiswa_Kewarganegaraan">
<span<?= $Page->Kewarganegaraan->viewAttributes() ?>>
<?= $Page->Kewarganegaraan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <td data-name="Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Propinsi_Tempat_Tinggal" class="el_mahasiswa_Propinsi_Tempat_Tinggal">
<span<?= $Page->Propinsi_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Propinsi_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <td data-name="Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Tinggal" class="el_mahasiswa_Kota_Tempat_Tinggal">
<span<?= $Page->Kota_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <td data-name="Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kecamatan_Tempat_Tinggal" class="el_mahasiswa_Kecamatan_Tempat_Tinggal">
<span<?= $Page->Kecamatan_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kecamatan_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <td data-name="Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Tempat_Tinggal" class="el_mahasiswa_Alamat_Tempat_Tinggal">
<span<?= $Page->Alamat_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Alamat_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RT->Visible) { // RT ?>
        <td data-name="RT"<?= $Page->RT->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RT" class="el_mahasiswa_RT">
<span<?= $Page->RT->viewAttributes() ?>>
<?= $Page->RT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RW->Visible) { // RW ?>
        <td data-name="RW"<?= $Page->RW->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RW" class="el_mahasiswa_RW">
<span<?= $Page->RW->viewAttributes() ?>>
<?= $Page->RW->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <td data-name="Kelurahan"<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kelurahan" class="el_mahasiswa_Kelurahan">
<span<?= $Page->Kelurahan->viewAttributes() ?>>
<?= $Page->Kelurahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <td data-name="Kode_Pos"<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kode_Pos" class="el_mahasiswa_Kode_Pos">
<span<?= $Page->Kode_Pos->viewAttributes() ?>>
<?= $Page->Kode_Pos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <td data-name="Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Telpon_HP" class="el_mahasiswa_Nomor_Telpon_HP">
<span<?= $Page->Nomor_Telpon_HP->viewAttributes() ?>>
<?= $Page->Nomor_Telpon_HP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa__Email" class="el_mahasiswa__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <td data-name="Jenis_Tinggal"<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Tinggal" class="el_mahasiswa_Jenis_Tinggal">
<span<?= $Page->Jenis_Tinggal->viewAttributes() ?>>
<?= $Page->Jenis_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <td data-name="Alat_Transportasi"<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alat_Transportasi" class="el_mahasiswa_Alat_Transportasi">
<span<?= $Page->Alat_Transportasi->viewAttributes() ?>>
<?= $Page->Alat_Transportasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <td data-name="Sumber_Dana"<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana" class="el_mahasiswa_Sumber_Dana">
<span<?= $Page->Sumber_Dana->viewAttributes() ?>>
<?= $Page->Sumber_Dana->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <td data-name="Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana_Beasiswa" class="el_mahasiswa_Sumber_Dana_Beasiswa">
<span<?= $Page->Sumber_Dana_Beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_Dana_Beasiswa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <td data-name="Jumlah_Sudara"<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jumlah_Sudara" class="el_mahasiswa_Jumlah_Sudara">
<span<?= $Page->Jumlah_Sudara->viewAttributes() ?>>
<?= $Page->Jumlah_Sudara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <td data-name="Status_Bekerja"<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Bekerja" class="el_mahasiswa_Status_Bekerja">
<span<?= $Page->Status_Bekerja->viewAttributes() ?>>
<?= $Page->Status_Bekerja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <td data-name="Nomor_Asuransi"<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Asuransi" class="el_mahasiswa_Nomor_Asuransi">
<span<?= $Page->Nomor_Asuransi->viewAttributes() ?>>
<?= $Page->Nomor_Asuransi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hobi->Visible) { // Hobi ?>
        <td data-name="Hobi"<?= $Page->Hobi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hobi" class="el_mahasiswa_Hobi">
<span<?= $Page->Hobi->viewAttributes() ?>>
<?= $Page->Hobi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Foto->Visible) { // Foto ?>
        <td data-name="Foto"<?= $Page->Foto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Foto" class="el_mahasiswa_Foto">
<span<?= $Page->Foto->viewAttributes() ?>>
<?= $Page->Foto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <td data-name="Nama_Ayah"<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ayah" class="el_mahasiswa_Nama_Ayah">
<span<?= $Page->Nama_Ayah->viewAttributes() ?>>
<?= $Page->Nama_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <td data-name="Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ayah" class="el_mahasiswa_Pekerjaan_Ayah">
<span<?= $Page->Pekerjaan_Ayah->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <td data-name="Nama_Ibu"<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ibu" class="el_mahasiswa_Nama_Ibu">
<span<?= $Page->Nama_Ibu->viewAttributes() ?>>
<?= $Page->Nama_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <td data-name="Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ibu" class="el_mahasiswa_Pekerjaan_Ibu">
<span<?= $Page->Pekerjaan_Ibu->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <td data-name="Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Orang_Tua" class="el_mahasiswa_Alamat_Orang_Tua">
<span<?= $Page->Alamat_Orang_Tua->viewAttributes() ?>>
<?= $Page->Alamat_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <td data-name="e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_e_mail_Oranng_Tua" class="el_mahasiswa_e_mail_Oranng_Tua">
<span<?= $Page->e_mail_Oranng_Tua->viewAttributes() ?>>
<?= $Page->e_mail_Oranng_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <td data-name="No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Kontak_Orang_Tua" class="el_mahasiswa_No_Kontak_Orang_Tua">
<span<?= $Page->No_Kontak_Orang_Tua->viewAttributes() ?>>
<?= $Page->No_Kontak_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php // Begin of Empty Table by Masino Sinaga, September 10, 2023 ?>
<?php } else { ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { // --- Begin of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<table id="tbl_mahasiswalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
// $Page->renderListOptions(); // do not display for empty table, by Masino Sinaga, September 10, 2023

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_mahasiswa_NIM" class="mahasiswa_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
        <th data-name="Nama" class="<?= $Page->Nama->headerCellClass() ?>"><div id="elh_mahasiswa_Nama" class="mahasiswa_Nama"><?= $Page->renderFieldHeader($Page->Nama) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Kelamin" class="mahasiswa_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <th data-name="Provinsi_Tempat_Lahir" class="<?= $Page->Provinsi_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Provinsi_Tempat_Lahir" class="mahasiswa_Provinsi_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Provinsi_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <th data-name="Kota_Tempat_Lahir" class="<?= $Page->Kota_Tempat_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Lahir" class="mahasiswa_Kota_Tempat_Lahir"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <th data-name="Tanggal_Lahir" class="<?= $Page->Tanggal_Lahir->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Lahir" class="mahasiswa_Tanggal_Lahir"><?= $Page->renderFieldHeader($Page->Tanggal_Lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <th data-name="Golongan_Darah" class="<?= $Page->Golongan_Darah->headerCellClass() ?>"><div id="elh_mahasiswa_Golongan_Darah" class="mahasiswa_Golongan_Darah"><?= $Page->renderFieldHeader($Page->Golongan_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <th data-name="Tinggi_Badan" class="<?= $Page->Tinggi_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Tinggi_Badan" class="mahasiswa_Tinggi_Badan"><?= $Page->renderFieldHeader($Page->Tinggi_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <th data-name="Berat_Badan" class="<?= $Page->Berat_Badan->headerCellClass() ?>"><div id="elh_mahasiswa_Berat_Badan" class="mahasiswa_Berat_Badan"><?= $Page->renderFieldHeader($Page->Berat_Badan) ?></div></th>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <th data-name="Asal_sekolah" class="<?= $Page->Asal_sekolah->headerCellClass() ?>"><div id="elh_mahasiswa_Asal_sekolah" class="mahasiswa_Asal_sekolah"><?= $Page->renderFieldHeader($Page->Asal_sekolah) ?></div></th>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <th data-name="Tahun_Ijazah" class="<?= $Page->Tahun_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Tahun_Ijazah" class="mahasiswa_Tahun_Ijazah"><?= $Page->renderFieldHeader($Page->Tahun_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <th data-name="Nomor_Ijazah" class="<?= $Page->Nomor_Ijazah->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Ijazah" class="mahasiswa_Nomor_Ijazah"><?= $Page->renderFieldHeader($Page->Nomor_Ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <th data-name="Nilai_Raport_Kelas_10" class="<?= $Page->Nilai_Raport_Kelas_10->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_10" class="mahasiswa_Nilai_Raport_Kelas_10"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_10) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <th data-name="Nilai_Raport_Kelas_11" class="<?= $Page->Nilai_Raport_Kelas_11->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_11" class="mahasiswa_Nilai_Raport_Kelas_11"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_11) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <th data-name="Nilai_Raport_Kelas_12" class="<?= $Page->Nilai_Raport_Kelas_12->headerCellClass() ?>"><div id="elh_mahasiswa_Nilai_Raport_Kelas_12" class="mahasiswa_Nilai_Raport_Kelas_12"><?= $Page->renderFieldHeader($Page->Nilai_Raport_Kelas_12) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <th data-name="Tanggal_Daftar" class="<?= $Page->Tanggal_Daftar->headerCellClass() ?>"><div id="elh_mahasiswa_Tanggal_Daftar" class="mahasiswa_Tanggal_Daftar"><?= $Page->renderFieldHeader($Page->Tanggal_Daftar) ?></div></th>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
        <th data-name="No_Test" class="<?= $Page->No_Test->headerCellClass() ?>"><div id="elh_mahasiswa_No_Test" class="mahasiswa_No_Test"><?= $Page->renderFieldHeader($Page->No_Test) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <th data-name="Status_Masuk" class="<?= $Page->Status_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Masuk" class="mahasiswa_Status_Masuk"><?= $Page->renderFieldHeader($Page->Status_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <th data-name="Jalur_Masuk" class="<?= $Page->Jalur_Masuk->headerCellClass() ?>"><div id="elh_mahasiswa_Jalur_Masuk" class="mahasiswa_Jalur_Masuk"><?= $Page->renderFieldHeader($Page->Jalur_Masuk) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <th data-name="Bukti_Lulus" class="<?= $Page->Bukti_Lulus->headerCellClass() ?>"><div id="elh_mahasiswa_Bukti_Lulus" class="mahasiswa_Bukti_Lulus"><?= $Page->renderFieldHeader($Page->Bukti_Lulus) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <th data-name="Tes_Potensi_Akademik" class="<?= $Page->Tes_Potensi_Akademik->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Potensi_Akademik" class="mahasiswa_Tes_Potensi_Akademik"><?= $Page->renderFieldHeader($Page->Tes_Potensi_Akademik) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <th data-name="Tes_Wawancara" class="<?= $Page->Tes_Wawancara->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Wawancara" class="mahasiswa_Tes_Wawancara"><?= $Page->renderFieldHeader($Page->Tes_Wawancara) ?></div></th>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <th data-name="Tes_Kesehatan" class="<?= $Page->Tes_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Tes_Kesehatan" class="mahasiswa_Tes_Kesehatan"><?= $Page->renderFieldHeader($Page->Tes_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <th data-name="Hasil_Test_Kesehatan" class="<?= $Page->Hasil_Test_Kesehatan->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_Kesehatan" class="mahasiswa_Hasil_Test_Kesehatan"><?= $Page->renderFieldHeader($Page->Hasil_Test_Kesehatan) ?></div></th>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <th data-name="Test_MMPI" class="<?= $Page->Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Test_MMPI" class="mahasiswa_Test_MMPI"><?= $Page->renderFieldHeader($Page->Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <th data-name="Hasil_Test_MMPI" class="<?= $Page->Hasil_Test_MMPI->headerCellClass() ?>"><div id="elh_mahasiswa_Hasil_Test_MMPI" class="mahasiswa_Hasil_Test_MMPI"><?= $Page->renderFieldHeader($Page->Hasil_Test_MMPI) ?></div></th>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <th data-name="Angkatan" class="<?= $Page->Angkatan->headerCellClass() ?>"><div id="elh_mahasiswa_Angkatan" class="mahasiswa_Angkatan"><?= $Page->renderFieldHeader($Page->Angkatan) ?></div></th>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <th data-name="Tarif_SPP" class="<?= $Page->Tarif_SPP->headerCellClass() ?>"><div id="elh_mahasiswa_Tarif_SPP" class="mahasiswa_Tarif_SPP"><?= $Page->renderFieldHeader($Page->Tarif_SPP) ?></div></th>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <th data-name="NIK_No_KTP" class="<?= $Page->NIK_No_KTP->headerCellClass() ?>"><div id="elh_mahasiswa_NIK_No_KTP" class="mahasiswa_NIK_No_KTP"><?= $Page->renderFieldHeader($Page->NIK_No_KTP) ?></div></th>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
        <th data-name="No_KK" class="<?= $Page->No_KK->headerCellClass() ?>"><div id="elh_mahasiswa_No_KK" class="mahasiswa_No_KK"><?= $Page->renderFieldHeader($Page->No_KK) ?></div></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th data-name="NPWP" class="<?= $Page->NPWP->headerCellClass() ?>"><div id="elh_mahasiswa_NPWP" class="mahasiswa_NPWP"><?= $Page->renderFieldHeader($Page->NPWP) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <th data-name="Status_Nikah" class="<?= $Page->Status_Nikah->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Nikah" class="mahasiswa_Status_Nikah"><?= $Page->renderFieldHeader($Page->Status_Nikah) ?></div></th>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <th data-name="Kewarganegaraan" class="<?= $Page->Kewarganegaraan->headerCellClass() ?>"><div id="elh_mahasiswa_Kewarganegaraan" class="mahasiswa_Kewarganegaraan"><?= $Page->renderFieldHeader($Page->Kewarganegaraan) ?></div></th>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <th data-name="Propinsi_Tempat_Tinggal" class="<?= $Page->Propinsi_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Propinsi_Tempat_Tinggal" class="mahasiswa_Propinsi_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Propinsi_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <th data-name="Kota_Tempat_Tinggal" class="<?= $Page->Kota_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kota_Tempat_Tinggal" class="mahasiswa_Kota_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kota_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <th data-name="Kecamatan_Tempat_Tinggal" class="<?= $Page->Kecamatan_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Kecamatan_Tempat_Tinggal" class="mahasiswa_Kecamatan_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Kecamatan_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <th data-name="Alamat_Tempat_Tinggal" class="<?= $Page->Alamat_Tempat_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Tempat_Tinggal" class="mahasiswa_Alamat_Tempat_Tinggal"><?= $Page->renderFieldHeader($Page->Alamat_Tempat_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
        <th data-name="RT" class="<?= $Page->RT->headerCellClass() ?>"><div id="elh_mahasiswa_RT" class="mahasiswa_RT"><?= $Page->renderFieldHeader($Page->RT) ?></div></th>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
        <th data-name="RW" class="<?= $Page->RW->headerCellClass() ?>"><div id="elh_mahasiswa_RW" class="mahasiswa_RW"><?= $Page->renderFieldHeader($Page->RW) ?></div></th>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <th data-name="Kelurahan" class="<?= $Page->Kelurahan->headerCellClass() ?>"><div id="elh_mahasiswa_Kelurahan" class="mahasiswa_Kelurahan"><?= $Page->renderFieldHeader($Page->Kelurahan) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <th data-name="Kode_Pos" class="<?= $Page->Kode_Pos->headerCellClass() ?>"><div id="elh_mahasiswa_Kode_Pos" class="mahasiswa_Kode_Pos"><?= $Page->renderFieldHeader($Page->Kode_Pos) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <th data-name="Nomor_Telpon_HP" class="<?= $Page->Nomor_Telpon_HP->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Telpon_HP" class="mahasiswa_Nomor_Telpon_HP"><?= $Page->renderFieldHeader($Page->Nomor_Telpon_HP) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_mahasiswa__Email" class="mahasiswa__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <th data-name="Jenis_Tinggal" class="<?= $Page->Jenis_Tinggal->headerCellClass() ?>"><div id="elh_mahasiswa_Jenis_Tinggal" class="mahasiswa_Jenis_Tinggal"><?= $Page->renderFieldHeader($Page->Jenis_Tinggal) ?></div></th>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <th data-name="Alat_Transportasi" class="<?= $Page->Alat_Transportasi->headerCellClass() ?>"><div id="elh_mahasiswa_Alat_Transportasi" class="mahasiswa_Alat_Transportasi"><?= $Page->renderFieldHeader($Page->Alat_Transportasi) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <th data-name="Sumber_Dana" class="<?= $Page->Sumber_Dana->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana" class="mahasiswa_Sumber_Dana"><?= $Page->renderFieldHeader($Page->Sumber_Dana) ?></div></th>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <th data-name="Sumber_Dana_Beasiswa" class="<?= $Page->Sumber_Dana_Beasiswa->headerCellClass() ?>"><div id="elh_mahasiswa_Sumber_Dana_Beasiswa" class="mahasiswa_Sumber_Dana_Beasiswa"><?= $Page->renderFieldHeader($Page->Sumber_Dana_Beasiswa) ?></div></th>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <th data-name="Jumlah_Sudara" class="<?= $Page->Jumlah_Sudara->headerCellClass() ?>"><div id="elh_mahasiswa_Jumlah_Sudara" class="mahasiswa_Jumlah_Sudara"><?= $Page->renderFieldHeader($Page->Jumlah_Sudara) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <th data-name="Status_Bekerja" class="<?= $Page->Status_Bekerja->headerCellClass() ?>"><div id="elh_mahasiswa_Status_Bekerja" class="mahasiswa_Status_Bekerja"><?= $Page->renderFieldHeader($Page->Status_Bekerja) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <th data-name="Nomor_Asuransi" class="<?= $Page->Nomor_Asuransi->headerCellClass() ?>"><div id="elh_mahasiswa_Nomor_Asuransi" class="mahasiswa_Nomor_Asuransi"><?= $Page->renderFieldHeader($Page->Nomor_Asuransi) ?></div></th>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
        <th data-name="Hobi" class="<?= $Page->Hobi->headerCellClass() ?>"><div id="elh_mahasiswa_Hobi" class="mahasiswa_Hobi"><?= $Page->renderFieldHeader($Page->Hobi) ?></div></th>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
        <th data-name="Foto" class="<?= $Page->Foto->headerCellClass() ?>"><div id="elh_mahasiswa_Foto" class="mahasiswa_Foto"><?= $Page->renderFieldHeader($Page->Foto) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <th data-name="Nama_Ayah" class="<?= $Page->Nama_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ayah" class="mahasiswa_Nama_Ayah"><?= $Page->renderFieldHeader($Page->Nama_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <th data-name="Pekerjaan_Ayah" class="<?= $Page->Pekerjaan_Ayah->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ayah" class="mahasiswa_Pekerjaan_Ayah"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ayah) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <th data-name="Nama_Ibu" class="<?= $Page->Nama_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Nama_Ibu" class="mahasiswa_Nama_Ibu"><?= $Page->renderFieldHeader($Page->Nama_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <th data-name="Pekerjaan_Ibu" class="<?= $Page->Pekerjaan_Ibu->headerCellClass() ?>"><div id="elh_mahasiswa_Pekerjaan_Ibu" class="mahasiswa_Pekerjaan_Ibu"><?= $Page->renderFieldHeader($Page->Pekerjaan_Ibu) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <th data-name="Alamat_Orang_Tua" class="<?= $Page->Alamat_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_Alamat_Orang_Tua" class="mahasiswa_Alamat_Orang_Tua"><?= $Page->renderFieldHeader($Page->Alamat_Orang_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <th data-name="e_mail_Oranng_Tua" class="<?= $Page->e_mail_Oranng_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_e_mail_Oranng_Tua" class="mahasiswa_e_mail_Oranng_Tua"><?= $Page->renderFieldHeader($Page->e_mail_Oranng_Tua) ?></div></th>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <th data-name="No_Kontak_Orang_Tua" class="<?= $Page->No_Kontak_Orang_Tua->headerCellClass() ?>"><div id="elh_mahasiswa_No_Kontak_Orang_Tua" class="mahasiswa_No_Kontak_Orang_Tua"><?= $Page->renderFieldHeader($Page->No_Kontak_Orang_Tua) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
    <tr class="border-bottom-0" style="height:36px;">
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIM" class="el_mahasiswa_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama->Visible) { // Nama ?>
        <td data-name="Nama"<?= $Page->Nama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama" class="el_mahasiswa_Nama">
<span<?= $Page->Nama->viewAttributes() ?>>
<?= $Page->Nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Kelamin" class="el_mahasiswa_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <td data-name="Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Provinsi_Tempat_Lahir" class="el_mahasiswa_Provinsi_Tempat_Lahir">
<span<?= $Page->Provinsi_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Provinsi_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <td data-name="Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Lahir" class="el_mahasiswa_Kota_Tempat_Lahir">
<span<?= $Page->Kota_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <td data-name="Tanggal_Lahir"<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Lahir" class="el_mahasiswa_Tanggal_Lahir">
<span<?= $Page->Tanggal_Lahir->viewAttributes() ?>>
<?= $Page->Tanggal_Lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <td data-name="Golongan_Darah"<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Golongan_Darah" class="el_mahasiswa_Golongan_Darah">
<span<?= $Page->Golongan_Darah->viewAttributes() ?>>
<?= $Page->Golongan_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <td data-name="Tinggi_Badan"<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tinggi_Badan" class="el_mahasiswa_Tinggi_Badan">
<span<?= $Page->Tinggi_Badan->viewAttributes() ?>>
<?= $Page->Tinggi_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <td data-name="Berat_Badan"<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Berat_Badan" class="el_mahasiswa_Berat_Badan">
<span<?= $Page->Berat_Badan->viewAttributes() ?>>
<?= $Page->Berat_Badan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <td data-name="Asal_sekolah"<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Asal_sekolah" class="el_mahasiswa_Asal_sekolah">
<span<?= $Page->Asal_sekolah->viewAttributes() ?>>
<?= $Page->Asal_sekolah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <td data-name="Tahun_Ijazah"<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tahun_Ijazah" class="el_mahasiswa_Tahun_Ijazah">
<span<?= $Page->Tahun_Ijazah->viewAttributes() ?>>
<?= $Page->Tahun_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <td data-name="Nomor_Ijazah"<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Ijazah" class="el_mahasiswa_Nomor_Ijazah">
<span<?= $Page->Nomor_Ijazah->viewAttributes() ?>>
<?= $Page->Nomor_Ijazah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <td data-name="Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_10" class="el_mahasiswa_Nilai_Raport_Kelas_10">
<span<?= $Page->Nilai_Raport_Kelas_10->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_10->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <td data-name="Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_11" class="el_mahasiswa_Nilai_Raport_Kelas_11">
<span<?= $Page->Nilai_Raport_Kelas_11->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_11->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <td data-name="Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nilai_Raport_Kelas_12" class="el_mahasiswa_Nilai_Raport_Kelas_12">
<span<?= $Page->Nilai_Raport_Kelas_12->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_12->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <td data-name="Tanggal_Daftar"<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tanggal_Daftar" class="el_mahasiswa_Tanggal_Daftar">
<span<?= $Page->Tanggal_Daftar->viewAttributes() ?>>
<?= $Page->Tanggal_Daftar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Test->Visible) { // No_Test ?>
        <td data-name="No_Test"<?= $Page->No_Test->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Test" class="el_mahasiswa_No_Test">
<span<?= $Page->No_Test->viewAttributes() ?>>
<?= $Page->No_Test->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <td data-name="Status_Masuk"<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Masuk" class="el_mahasiswa_Status_Masuk">
<span<?= $Page->Status_Masuk->viewAttributes() ?>>
<?= $Page->Status_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <td data-name="Jalur_Masuk"<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jalur_Masuk" class="el_mahasiswa_Jalur_Masuk">
<span<?= $Page->Jalur_Masuk->viewAttributes() ?>>
<?= $Page->Jalur_Masuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <td data-name="Bukti_Lulus"<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Bukti_Lulus" class="el_mahasiswa_Bukti_Lulus">
<span<?= $Page->Bukti_Lulus->viewAttributes() ?>>
<?= $Page->Bukti_Lulus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <td data-name="Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Potensi_Akademik" class="el_mahasiswa_Tes_Potensi_Akademik">
<span<?= $Page->Tes_Potensi_Akademik->viewAttributes() ?>>
<?= $Page->Tes_Potensi_Akademik->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <td data-name="Tes_Wawancara"<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Wawancara" class="el_mahasiswa_Tes_Wawancara">
<span<?= $Page->Tes_Wawancara->viewAttributes() ?>>
<?= $Page->Tes_Wawancara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <td data-name="Tes_Kesehatan"<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tes_Kesehatan" class="el_mahasiswa_Tes_Kesehatan">
<span<?= $Page->Tes_Kesehatan->viewAttributes() ?>>
<?= $Page->Tes_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <td data-name="Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_Kesehatan" class="el_mahasiswa_Hasil_Test_Kesehatan">
<span<?= $Page->Hasil_Test_Kesehatan->viewAttributes() ?>>
<?= $Page->Hasil_Test_Kesehatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <td data-name="Test_MMPI"<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Test_MMPI" class="el_mahasiswa_Test_MMPI">
<span<?= $Page->Test_MMPI->viewAttributes() ?>>
<?= $Page->Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <td data-name="Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hasil_Test_MMPI" class="el_mahasiswa_Hasil_Test_MMPI">
<span<?= $Page->Hasil_Test_MMPI->viewAttributes() ?>>
<?= $Page->Hasil_Test_MMPI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <td data-name="Angkatan"<?= $Page->Angkatan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Angkatan" class="el_mahasiswa_Angkatan">
<span<?= $Page->Angkatan->viewAttributes() ?>>
<?= $Page->Angkatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <td data-name="Tarif_SPP"<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Tarif_SPP" class="el_mahasiswa_Tarif_SPP">
<span<?= $Page->Tarif_SPP->viewAttributes() ?>>
<?= $Page->Tarif_SPP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <td data-name="NIK_No_KTP"<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NIK_No_KTP" class="el_mahasiswa_NIK_No_KTP">
<span<?= $Page->NIK_No_KTP->viewAttributes() ?>>
<?= $Page->NIK_No_KTP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_KK->Visible) { // No_KK ?>
        <td data-name="No_KK"<?= $Page->No_KK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_KK" class="el_mahasiswa_No_KK">
<span<?= $Page->No_KK->viewAttributes() ?>>
<?= $Page->No_KK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td data-name="NPWP"<?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_NPWP" class="el_mahasiswa_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <td data-name="Status_Nikah"<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Nikah" class="el_mahasiswa_Status_Nikah">
<span<?= $Page->Status_Nikah->viewAttributes() ?>>
<?= $Page->Status_Nikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <td data-name="Kewarganegaraan"<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kewarganegaraan" class="el_mahasiswa_Kewarganegaraan">
<span<?= $Page->Kewarganegaraan->viewAttributes() ?>>
<?= $Page->Kewarganegaraan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <td data-name="Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Propinsi_Tempat_Tinggal" class="el_mahasiswa_Propinsi_Tempat_Tinggal">
<span<?= $Page->Propinsi_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Propinsi_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <td data-name="Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kota_Tempat_Tinggal" class="el_mahasiswa_Kota_Tempat_Tinggal">
<span<?= $Page->Kota_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <td data-name="Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kecamatan_Tempat_Tinggal" class="el_mahasiswa_Kecamatan_Tempat_Tinggal">
<span<?= $Page->Kecamatan_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kecamatan_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <td data-name="Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Tempat_Tinggal" class="el_mahasiswa_Alamat_Tempat_Tinggal">
<span<?= $Page->Alamat_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Alamat_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RT->Visible) { // RT ?>
        <td data-name="RT"<?= $Page->RT->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RT" class="el_mahasiswa_RT">
<span<?= $Page->RT->viewAttributes() ?>>
<?= $Page->RT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RW->Visible) { // RW ?>
        <td data-name="RW"<?= $Page->RW->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_RW" class="el_mahasiswa_RW">
<span<?= $Page->RW->viewAttributes() ?>>
<?= $Page->RW->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <td data-name="Kelurahan"<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kelurahan" class="el_mahasiswa_Kelurahan">
<span<?= $Page->Kelurahan->viewAttributes() ?>>
<?= $Page->Kelurahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <td data-name="Kode_Pos"<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Kode_Pos" class="el_mahasiswa_Kode_Pos">
<span<?= $Page->Kode_Pos->viewAttributes() ?>>
<?= $Page->Kode_Pos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <td data-name="Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Telpon_HP" class="el_mahasiswa_Nomor_Telpon_HP">
<span<?= $Page->Nomor_Telpon_HP->viewAttributes() ?>>
<?= $Page->Nomor_Telpon_HP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa__Email" class="el_mahasiswa__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <td data-name="Jenis_Tinggal"<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jenis_Tinggal" class="el_mahasiswa_Jenis_Tinggal">
<span<?= $Page->Jenis_Tinggal->viewAttributes() ?>>
<?= $Page->Jenis_Tinggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <td data-name="Alat_Transportasi"<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alat_Transportasi" class="el_mahasiswa_Alat_Transportasi">
<span<?= $Page->Alat_Transportasi->viewAttributes() ?>>
<?= $Page->Alat_Transportasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <td data-name="Sumber_Dana"<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana" class="el_mahasiswa_Sumber_Dana">
<span<?= $Page->Sumber_Dana->viewAttributes() ?>>
<?= $Page->Sumber_Dana->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <td data-name="Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Sumber_Dana_Beasiswa" class="el_mahasiswa_Sumber_Dana_Beasiswa">
<span<?= $Page->Sumber_Dana_Beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_Dana_Beasiswa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <td data-name="Jumlah_Sudara"<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Jumlah_Sudara" class="el_mahasiswa_Jumlah_Sudara">
<span<?= $Page->Jumlah_Sudara->viewAttributes() ?>>
<?= $Page->Jumlah_Sudara->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <td data-name="Status_Bekerja"<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Status_Bekerja" class="el_mahasiswa_Status_Bekerja">
<span<?= $Page->Status_Bekerja->viewAttributes() ?>>
<?= $Page->Status_Bekerja->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <td data-name="Nomor_Asuransi"<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nomor_Asuransi" class="el_mahasiswa_Nomor_Asuransi">
<span<?= $Page->Nomor_Asuransi->viewAttributes() ?>>
<?= $Page->Nomor_Asuransi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Hobi->Visible) { // Hobi ?>
        <td data-name="Hobi"<?= $Page->Hobi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Hobi" class="el_mahasiswa_Hobi">
<span<?= $Page->Hobi->viewAttributes() ?>>
<?= $Page->Hobi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Foto->Visible) { // Foto ?>
        <td data-name="Foto"<?= $Page->Foto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Foto" class="el_mahasiswa_Foto">
<span<?= $Page->Foto->viewAttributes() ?>>
<?= $Page->Foto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <td data-name="Nama_Ayah"<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ayah" class="el_mahasiswa_Nama_Ayah">
<span<?= $Page->Nama_Ayah->viewAttributes() ?>>
<?= $Page->Nama_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <td data-name="Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ayah" class="el_mahasiswa_Pekerjaan_Ayah">
<span<?= $Page->Pekerjaan_Ayah->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ayah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <td data-name="Nama_Ibu"<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Nama_Ibu" class="el_mahasiswa_Nama_Ibu">
<span<?= $Page->Nama_Ibu->viewAttributes() ?>>
<?= $Page->Nama_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <td data-name="Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Pekerjaan_Ibu" class="el_mahasiswa_Pekerjaan_Ibu">
<span<?= $Page->Pekerjaan_Ibu->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ibu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <td data-name="Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_Alamat_Orang_Tua" class="el_mahasiswa_Alamat_Orang_Tua">
<span<?= $Page->Alamat_Orang_Tua->viewAttributes() ?>>
<?= $Page->Alamat_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <td data-name="e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_e_mail_Oranng_Tua" class="el_mahasiswa_e_mail_Oranng_Tua">
<span<?= $Page->e_mail_Oranng_Tua->viewAttributes() ?>>
<?= $Page->e_mail_Oranng_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <td data-name="No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_mahasiswa_No_Kontak_Orang_Tua" class="el_mahasiswa_No_Kontak_Orang_Tua">
<span<?= $Page->No_Kontak_Orang_Tua->viewAttributes() ?>>
<?= $Page->No_Kontak_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
</tbody>
</table><!-- /.ew-table -->
<?php } // --- End of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<?php // End of Empty Table by Masino Sinaga, September 10, 2023 ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Result?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } // end of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("head", function() {
	$(".ew-grid").css("width", "100%");
	$(".sidebar, .main-sidebar, .main-header, .header-navbar, .main-menu").on("mouseenter", function(event) {
		$(".ew-grid").css("width", "100%");
	});
	$(".sidebar, .main-sidebar, .main-header, .header-navbar, .main-menu").on("mouseover", function(event) {
		$(".ew-grid").css("width", "100%");
	});
	var cssTransitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
	$('.main-header').on(cssTransitionEnd, function(event) {
		$(".ew-grid").css("width", "100%");
	});
	$(document).on('resize', function() {
		if ($('.ew-grid').length > 0) {
			$(".ew-grid").css("width", "100%");
		}
	});
	$(".nav-item.d-block").on("click", function(event) {
		$(".ew-grid").css("width", "100%");
	});
});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmahasiswaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmahasiswaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswaupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmahasiswaupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswadelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmahasiswadelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmahasiswalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmahasiswalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmahasiswalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="mahasiswa"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'mahasiswalist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$mahasiswa->isExport()) { ?>
<script>
loadjs.ready("jscookie", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle');
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			ew.Cookies.set(ew.PROJECT_NAME + "_mahasiswa_searchpanel", "notactive", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} else { 
			ew.Cookies.set(ew.PROJECT_NAME + "_mahasiswa_searchpanel", "active", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} 
	});
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("mahasiswa");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
