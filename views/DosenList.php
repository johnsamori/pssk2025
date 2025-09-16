<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DosenList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
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
<form name="fdosensrch" id="fdosensrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fdosensrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentForm;
var fdosensrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdosensrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="dosen">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_dosen" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->No->Visible) { // No ?>
        <th data-name="No" class="<?= $Page->No->headerCellClass() ?>"><div id="elh_dosen_No" class="dosen_No"><?= $Page->renderFieldHeader($Page->No) ?></div></th>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
        <th data-name="NIP" class="<?= $Page->NIP->headerCellClass() ?>"><div id="elh_dosen_NIP" class="dosen_NIP"><?= $Page->renderFieldHeader($Page->NIP) ?></div></th>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <th data-name="Gelar_Depan" class="<?= $Page->Gelar_Depan->headerCellClass() ?>"><div id="elh_dosen_Gelar_Depan" class="dosen_Gelar_Depan"><?= $Page->renderFieldHeader($Page->Gelar_Depan) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <th data-name="Gelar_Belakang" class="<?= $Page->Gelar_Belakang->headerCellClass() ?>"><div id="elh_dosen_Gelar_Belakang" class="dosen_Gelar_Belakang"><?= $Page->renderFieldHeader($Page->Gelar_Belakang) ?></div></th>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <th data-name="Program_studi" class="<?= $Page->Program_studi->headerCellClass() ?>"><div id="elh_dosen_Program_studi" class="dosen_Program_studi"><?= $Page->renderFieldHeader($Page->Program_studi) ?></div></th>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
        <th data-name="NIK" class="<?= $Page->NIK->headerCellClass() ?>"><div id="elh_dosen_NIK" class="dosen_NIK"><?= $Page->renderFieldHeader($Page->NIK) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <th data-name="Tanggal_lahir" class="<?= $Page->Tanggal_lahir->headerCellClass() ?>"><div id="elh_dosen_Tanggal_lahir" class="dosen_Tanggal_lahir"><?= $Page->renderFieldHeader($Page->Tanggal_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <th data-name="Tempat_lahir" class="<?= $Page->Tempat_lahir->headerCellClass() ?>"><div id="elh_dosen_Tempat_lahir" class="dosen_Tempat_lahir"><?= $Page->renderFieldHeader($Page->Tempat_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <th data-name="Nomor_Karpeg" class="<?= $Page->Nomor_Karpeg->headerCellClass() ?>"><div id="elh_dosen_Nomor_Karpeg" class="dosen_Nomor_Karpeg"><?= $Page->renderFieldHeader($Page->Nomor_Karpeg) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <th data-name="Nomor_Stambuk" class="<?= $Page->Nomor_Stambuk->headerCellClass() ?>"><div id="elh_dosen_Nomor_Stambuk" class="dosen_Nomor_Stambuk"><?= $Page->renderFieldHeader($Page->Nomor_Stambuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <th data-name="Jenis_kelamin" class="<?= $Page->Jenis_kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_kelamin" class="dosen_Jenis_kelamin"><?= $Page->renderFieldHeader($Page->Jenis_kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <th data-name="Gol_Darah" class="<?= $Page->Gol_Darah->headerCellClass() ?>"><div id="elh_dosen_Gol_Darah" class="dosen_Gol_Darah"><?= $Page->renderFieldHeader($Page->Gol_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
        <th data-name="Agama" class="<?= $Page->Agama->headerCellClass() ?>"><div id="elh_dosen_Agama" class="dosen_Agama"><?= $Page->renderFieldHeader($Page->Agama) ?></div></th>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <th data-name="Stattus_menikah" class="<?= $Page->Stattus_menikah->headerCellClass() ?>"><div id="elh_dosen_Stattus_menikah" class="dosen_Stattus_menikah"><?= $Page->renderFieldHeader($Page->Stattus_menikah) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
        <th data-name="Kota" class="<?= $Page->Kota->headerCellClass() ?>"><div id="elh_dosen_Kota" class="dosen_Kota"><?= $Page->renderFieldHeader($Page->Kota) ?></div></th>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <th data-name="Telepon_seluler" class="<?= $Page->Telepon_seluler->headerCellClass() ?>"><div id="elh_dosen_Telepon_seluler" class="dosen_Telepon_seluler"><?= $Page->renderFieldHeader($Page->Telepon_seluler) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <th data-name="Jenis_pegawai" class="<?= $Page->Jenis_pegawai->headerCellClass() ?>"><div id="elh_dosen_Jenis_pegawai" class="dosen_Jenis_pegawai"><?= $Page->renderFieldHeader($Page->Jenis_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <th data-name="Status_pegawai" class="<?= $Page->Status_pegawai->headerCellClass() ?>"><div id="elh_dosen_Status_pegawai" class="dosen_Status_pegawai"><?= $Page->renderFieldHeader($Page->Status_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
        <th data-name="Golongan" class="<?= $Page->Golongan->headerCellClass() ?>"><div id="elh_dosen_Golongan" class="dosen_Golongan"><?= $Page->renderFieldHeader($Page->Golongan) ?></div></th>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <th data-name="Pangkat" class="<?= $Page->Pangkat->headerCellClass() ?>"><div id="elh_dosen_Pangkat" class="dosen_Pangkat"><?= $Page->renderFieldHeader($Page->Pangkat) ?></div></th>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <th data-name="Status_dosen" class="<?= $Page->Status_dosen->headerCellClass() ?>"><div id="elh_dosen_Status_dosen" class="dosen_Status_dosen"><?= $Page->renderFieldHeader($Page->Status_dosen) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <th data-name="Status_Belajar" class="<?= $Page->Status_Belajar->headerCellClass() ?>"><div id="elh_dosen_Status_Belajar" class="dosen_Status_Belajar"><?= $Page->renderFieldHeader($Page->Status_Belajar) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
        <th data-name="e_mail" class="<?= $Page->e_mail->headerCellClass() ?>"><div id="elh_dosen_e_mail" class="dosen_e_mail"><?= $Page->renderFieldHeader($Page->e_mail) ?></div></th>
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
    <?php if ($Page->No->Visible) { // No ?>
        <td data-name="No"<?= $Page->No->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_No" class="el_dosen_No">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIP->Visible) { // NIP ?>
        <td data-name="NIP"<?= $Page->NIP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIP" class="el_dosen_NIP">
<span<?= $Page->NIP->viewAttributes() ?>>
<?= $Page->NIP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <td data-name="Gelar_Depan"<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Depan" class="el_dosen_Gelar_Depan">
<span<?= $Page->Gelar_Depan->viewAttributes() ?>>
<?= $Page->Gelar_Depan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <td data-name="Gelar_Belakang"<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Belakang" class="el_dosen_Gelar_Belakang">
<span<?= $Page->Gelar_Belakang->viewAttributes() ?>>
<?= $Page->Gelar_Belakang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <td data-name="Program_studi"<?= $Page->Program_studi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Program_studi" class="el_dosen_Program_studi">
<span<?= $Page->Program_studi->viewAttributes() ?>>
<?= $Page->Program_studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK->Visible) { // NIK ?>
        <td data-name="NIK"<?= $Page->NIK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIK" class="el_dosen_NIK">
<span<?= $Page->NIK->viewAttributes() ?>>
<?= $Page->NIK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <td data-name="Tanggal_lahir"<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tanggal_lahir" class="el_dosen_Tanggal_lahir">
<span<?= $Page->Tanggal_lahir->viewAttributes() ?>>
<?= $Page->Tanggal_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <td data-name="Tempat_lahir"<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tempat_lahir" class="el_dosen_Tempat_lahir">
<span<?= $Page->Tempat_lahir->viewAttributes() ?>>
<?= $Page->Tempat_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <td data-name="Nomor_Karpeg"<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Karpeg" class="el_dosen_Nomor_Karpeg">
<span<?= $Page->Nomor_Karpeg->viewAttributes() ?>>
<?= $Page->Nomor_Karpeg->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <td data-name="Nomor_Stambuk"<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Stambuk" class="el_dosen_Nomor_Stambuk">
<span<?= $Page->Nomor_Stambuk->viewAttributes() ?>>
<?= $Page->Nomor_Stambuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <td data-name="Jenis_kelamin"<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_kelamin" class="el_dosen_Jenis_kelamin">
<span<?= $Page->Jenis_kelamin->viewAttributes() ?>>
<?= $Page->Jenis_kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <td data-name="Gol_Darah"<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gol_Darah" class="el_dosen_Gol_Darah">
<span<?= $Page->Gol_Darah->viewAttributes() ?>>
<?= $Page->Gol_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Agama->Visible) { // Agama ?>
        <td data-name="Agama"<?= $Page->Agama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Agama" class="el_dosen_Agama">
<span<?= $Page->Agama->viewAttributes() ?>>
<?= $Page->Agama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <td data-name="Stattus_menikah"<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Stattus_menikah" class="el_dosen_Stattus_menikah">
<span<?= $Page->Stattus_menikah->viewAttributes() ?>>
<?= $Page->Stattus_menikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota->Visible) { // Kota ?>
        <td data-name="Kota"<?= $Page->Kota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Kota" class="el_dosen_Kota">
<span<?= $Page->Kota->viewAttributes() ?>>
<?= $Page->Kota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <td data-name="Telepon_seluler"<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Telepon_seluler" class="el_dosen_Telepon_seluler">
<span<?= $Page->Telepon_seluler->viewAttributes() ?>>
<?= $Page->Telepon_seluler->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <td data-name="Jenis_pegawai"<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_pegawai" class="el_dosen_Jenis_pegawai">
<span<?= $Page->Jenis_pegawai->viewAttributes() ?>>
<?= $Page->Jenis_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <td data-name="Status_pegawai"<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_pegawai" class="el_dosen_Status_pegawai">
<span<?= $Page->Status_pegawai->viewAttributes() ?>>
<?= $Page->Status_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan->Visible) { // Golongan ?>
        <td data-name="Golongan"<?= $Page->Golongan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Golongan" class="el_dosen_Golongan">
<span<?= $Page->Golongan->viewAttributes() ?>>
<?= $Page->Golongan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <td data-name="Pangkat"<?= $Page->Pangkat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Pangkat" class="el_dosen_Pangkat">
<span<?= $Page->Pangkat->viewAttributes() ?>>
<?= $Page->Pangkat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <td data-name="Status_dosen"<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_dosen" class="el_dosen_Status_dosen">
<span<?= $Page->Status_dosen->viewAttributes() ?>>
<?= $Page->Status_dosen->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <td data-name="Status_Belajar"<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_Belajar" class="el_dosen_Status_Belajar">
<span<?= $Page->Status_Belajar->viewAttributes() ?>>
<?= $Page->Status_Belajar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail->Visible) { // e_mail ?>
        <td data-name="e_mail"<?= $Page->e_mail->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_e_mail" class="el_dosen_e_mail">
<span<?= $Page->e_mail->viewAttributes() ?>>
<?= $Page->e_mail->getViewValue() ?></span>
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
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->No->Visible) { // No ?>
        <th data-name="No" class="<?= $Page->No->headerCellClass() ?>"><div id="elh_dosen_No" class="dosen_No"><?= $Page->renderFieldHeader($Page->No) ?></div></th>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
        <th data-name="NIP" class="<?= $Page->NIP->headerCellClass() ?>"><div id="elh_dosen_NIP" class="dosen_NIP"><?= $Page->renderFieldHeader($Page->NIP) ?></div></th>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <th data-name="Gelar_Depan" class="<?= $Page->Gelar_Depan->headerCellClass() ?>"><div id="elh_dosen_Gelar_Depan" class="dosen_Gelar_Depan"><?= $Page->renderFieldHeader($Page->Gelar_Depan) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <th data-name="Gelar_Belakang" class="<?= $Page->Gelar_Belakang->headerCellClass() ?>"><div id="elh_dosen_Gelar_Belakang" class="dosen_Gelar_Belakang"><?= $Page->renderFieldHeader($Page->Gelar_Belakang) ?></div></th>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <th data-name="Program_studi" class="<?= $Page->Program_studi->headerCellClass() ?>"><div id="elh_dosen_Program_studi" class="dosen_Program_studi"><?= $Page->renderFieldHeader($Page->Program_studi) ?></div></th>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
        <th data-name="NIK" class="<?= $Page->NIK->headerCellClass() ?>"><div id="elh_dosen_NIK" class="dosen_NIK"><?= $Page->renderFieldHeader($Page->NIK) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <th data-name="Tanggal_lahir" class="<?= $Page->Tanggal_lahir->headerCellClass() ?>"><div id="elh_dosen_Tanggal_lahir" class="dosen_Tanggal_lahir"><?= $Page->renderFieldHeader($Page->Tanggal_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <th data-name="Tempat_lahir" class="<?= $Page->Tempat_lahir->headerCellClass() ?>"><div id="elh_dosen_Tempat_lahir" class="dosen_Tempat_lahir"><?= $Page->renderFieldHeader($Page->Tempat_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <th data-name="Nomor_Karpeg" class="<?= $Page->Nomor_Karpeg->headerCellClass() ?>"><div id="elh_dosen_Nomor_Karpeg" class="dosen_Nomor_Karpeg"><?= $Page->renderFieldHeader($Page->Nomor_Karpeg) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <th data-name="Nomor_Stambuk" class="<?= $Page->Nomor_Stambuk->headerCellClass() ?>"><div id="elh_dosen_Nomor_Stambuk" class="dosen_Nomor_Stambuk"><?= $Page->renderFieldHeader($Page->Nomor_Stambuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <th data-name="Jenis_kelamin" class="<?= $Page->Jenis_kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_kelamin" class="dosen_Jenis_kelamin"><?= $Page->renderFieldHeader($Page->Jenis_kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <th data-name="Gol_Darah" class="<?= $Page->Gol_Darah->headerCellClass() ?>"><div id="elh_dosen_Gol_Darah" class="dosen_Gol_Darah"><?= $Page->renderFieldHeader($Page->Gol_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
        <th data-name="Agama" class="<?= $Page->Agama->headerCellClass() ?>"><div id="elh_dosen_Agama" class="dosen_Agama"><?= $Page->renderFieldHeader($Page->Agama) ?></div></th>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <th data-name="Stattus_menikah" class="<?= $Page->Stattus_menikah->headerCellClass() ?>"><div id="elh_dosen_Stattus_menikah" class="dosen_Stattus_menikah"><?= $Page->renderFieldHeader($Page->Stattus_menikah) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
        <th data-name="Kota" class="<?= $Page->Kota->headerCellClass() ?>"><div id="elh_dosen_Kota" class="dosen_Kota"><?= $Page->renderFieldHeader($Page->Kota) ?></div></th>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <th data-name="Telepon_seluler" class="<?= $Page->Telepon_seluler->headerCellClass() ?>"><div id="elh_dosen_Telepon_seluler" class="dosen_Telepon_seluler"><?= $Page->renderFieldHeader($Page->Telepon_seluler) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <th data-name="Jenis_pegawai" class="<?= $Page->Jenis_pegawai->headerCellClass() ?>"><div id="elh_dosen_Jenis_pegawai" class="dosen_Jenis_pegawai"><?= $Page->renderFieldHeader($Page->Jenis_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <th data-name="Status_pegawai" class="<?= $Page->Status_pegawai->headerCellClass() ?>"><div id="elh_dosen_Status_pegawai" class="dosen_Status_pegawai"><?= $Page->renderFieldHeader($Page->Status_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
        <th data-name="Golongan" class="<?= $Page->Golongan->headerCellClass() ?>"><div id="elh_dosen_Golongan" class="dosen_Golongan"><?= $Page->renderFieldHeader($Page->Golongan) ?></div></th>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <th data-name="Pangkat" class="<?= $Page->Pangkat->headerCellClass() ?>"><div id="elh_dosen_Pangkat" class="dosen_Pangkat"><?= $Page->renderFieldHeader($Page->Pangkat) ?></div></th>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <th data-name="Status_dosen" class="<?= $Page->Status_dosen->headerCellClass() ?>"><div id="elh_dosen_Status_dosen" class="dosen_Status_dosen"><?= $Page->renderFieldHeader($Page->Status_dosen) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <th data-name="Status_Belajar" class="<?= $Page->Status_Belajar->headerCellClass() ?>"><div id="elh_dosen_Status_Belajar" class="dosen_Status_Belajar"><?= $Page->renderFieldHeader($Page->Status_Belajar) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
        <th data-name="e_mail" class="<?= $Page->e_mail->headerCellClass() ?>"><div id="elh_dosen_e_mail" class="dosen_e_mail"><?= $Page->renderFieldHeader($Page->e_mail) ?></div></th>
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
    <?php if ($Page->No->Visible) { // No ?>
        <td data-name="No"<?= $Page->No->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_No" class="el_dosen_No">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIP->Visible) { // NIP ?>
        <td data-name="NIP"<?= $Page->NIP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIP" class="el_dosen_NIP">
<span<?= $Page->NIP->viewAttributes() ?>>
<?= $Page->NIP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <td data-name="Gelar_Depan"<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Depan" class="el_dosen_Gelar_Depan">
<span<?= $Page->Gelar_Depan->viewAttributes() ?>>
<?= $Page->Gelar_Depan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <td data-name="Gelar_Belakang"<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Belakang" class="el_dosen_Gelar_Belakang">
<span<?= $Page->Gelar_Belakang->viewAttributes() ?>>
<?= $Page->Gelar_Belakang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <td data-name="Program_studi"<?= $Page->Program_studi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Program_studi" class="el_dosen_Program_studi">
<span<?= $Page->Program_studi->viewAttributes() ?>>
<?= $Page->Program_studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK->Visible) { // NIK ?>
        <td data-name="NIK"<?= $Page->NIK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIK" class="el_dosen_NIK">
<span<?= $Page->NIK->viewAttributes() ?>>
<?= $Page->NIK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <td data-name="Tanggal_lahir"<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tanggal_lahir" class="el_dosen_Tanggal_lahir">
<span<?= $Page->Tanggal_lahir->viewAttributes() ?>>
<?= $Page->Tanggal_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <td data-name="Tempat_lahir"<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tempat_lahir" class="el_dosen_Tempat_lahir">
<span<?= $Page->Tempat_lahir->viewAttributes() ?>>
<?= $Page->Tempat_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <td data-name="Nomor_Karpeg"<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Karpeg" class="el_dosen_Nomor_Karpeg">
<span<?= $Page->Nomor_Karpeg->viewAttributes() ?>>
<?= $Page->Nomor_Karpeg->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <td data-name="Nomor_Stambuk"<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Stambuk" class="el_dosen_Nomor_Stambuk">
<span<?= $Page->Nomor_Stambuk->viewAttributes() ?>>
<?= $Page->Nomor_Stambuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <td data-name="Jenis_kelamin"<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_kelamin" class="el_dosen_Jenis_kelamin">
<span<?= $Page->Jenis_kelamin->viewAttributes() ?>>
<?= $Page->Jenis_kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <td data-name="Gol_Darah"<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gol_Darah" class="el_dosen_Gol_Darah">
<span<?= $Page->Gol_Darah->viewAttributes() ?>>
<?= $Page->Gol_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Agama->Visible) { // Agama ?>
        <td data-name="Agama"<?= $Page->Agama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Agama" class="el_dosen_Agama">
<span<?= $Page->Agama->viewAttributes() ?>>
<?= $Page->Agama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <td data-name="Stattus_menikah"<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Stattus_menikah" class="el_dosen_Stattus_menikah">
<span<?= $Page->Stattus_menikah->viewAttributes() ?>>
<?= $Page->Stattus_menikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota->Visible) { // Kota ?>
        <td data-name="Kota"<?= $Page->Kota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Kota" class="el_dosen_Kota">
<span<?= $Page->Kota->viewAttributes() ?>>
<?= $Page->Kota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <td data-name="Telepon_seluler"<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Telepon_seluler" class="el_dosen_Telepon_seluler">
<span<?= $Page->Telepon_seluler->viewAttributes() ?>>
<?= $Page->Telepon_seluler->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <td data-name="Jenis_pegawai"<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_pegawai" class="el_dosen_Jenis_pegawai">
<span<?= $Page->Jenis_pegawai->viewAttributes() ?>>
<?= $Page->Jenis_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <td data-name="Status_pegawai"<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_pegawai" class="el_dosen_Status_pegawai">
<span<?= $Page->Status_pegawai->viewAttributes() ?>>
<?= $Page->Status_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan->Visible) { // Golongan ?>
        <td data-name="Golongan"<?= $Page->Golongan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Golongan" class="el_dosen_Golongan">
<span<?= $Page->Golongan->viewAttributes() ?>>
<?= $Page->Golongan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <td data-name="Pangkat"<?= $Page->Pangkat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Pangkat" class="el_dosen_Pangkat">
<span<?= $Page->Pangkat->viewAttributes() ?>>
<?= $Page->Pangkat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <td data-name="Status_dosen"<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_dosen" class="el_dosen_Status_dosen">
<span<?= $Page->Status_dosen->viewAttributes() ?>>
<?= $Page->Status_dosen->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <td data-name="Status_Belajar"<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_Belajar" class="el_dosen_Status_Belajar">
<span<?= $Page->Status_Belajar->viewAttributes() ?>>
<?= $Page->Status_Belajar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail->Visible) { // e_mail ?>
        <td data-name="e_mail"<?= $Page->e_mail->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_e_mail" class="el_dosen_e_mail">
<span<?= $Page->e_mail->viewAttributes() ?>>
<?= $Page->e_mail->getViewValue() ?></span>
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
<input type="hidden" name="t" value="dosen">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_dosen" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->No->Visible) { // No ?>
        <th data-name="No" class="<?= $Page->No->headerCellClass() ?>"><div id="elh_dosen_No" class="dosen_No"><?= $Page->renderFieldHeader($Page->No) ?></div></th>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
        <th data-name="NIP" class="<?= $Page->NIP->headerCellClass() ?>"><div id="elh_dosen_NIP" class="dosen_NIP"><?= $Page->renderFieldHeader($Page->NIP) ?></div></th>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <th data-name="Gelar_Depan" class="<?= $Page->Gelar_Depan->headerCellClass() ?>"><div id="elh_dosen_Gelar_Depan" class="dosen_Gelar_Depan"><?= $Page->renderFieldHeader($Page->Gelar_Depan) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <th data-name="Gelar_Belakang" class="<?= $Page->Gelar_Belakang->headerCellClass() ?>"><div id="elh_dosen_Gelar_Belakang" class="dosen_Gelar_Belakang"><?= $Page->renderFieldHeader($Page->Gelar_Belakang) ?></div></th>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <th data-name="Program_studi" class="<?= $Page->Program_studi->headerCellClass() ?>"><div id="elh_dosen_Program_studi" class="dosen_Program_studi"><?= $Page->renderFieldHeader($Page->Program_studi) ?></div></th>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
        <th data-name="NIK" class="<?= $Page->NIK->headerCellClass() ?>"><div id="elh_dosen_NIK" class="dosen_NIK"><?= $Page->renderFieldHeader($Page->NIK) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <th data-name="Tanggal_lahir" class="<?= $Page->Tanggal_lahir->headerCellClass() ?>"><div id="elh_dosen_Tanggal_lahir" class="dosen_Tanggal_lahir"><?= $Page->renderFieldHeader($Page->Tanggal_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <th data-name="Tempat_lahir" class="<?= $Page->Tempat_lahir->headerCellClass() ?>"><div id="elh_dosen_Tempat_lahir" class="dosen_Tempat_lahir"><?= $Page->renderFieldHeader($Page->Tempat_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <th data-name="Nomor_Karpeg" class="<?= $Page->Nomor_Karpeg->headerCellClass() ?>"><div id="elh_dosen_Nomor_Karpeg" class="dosen_Nomor_Karpeg"><?= $Page->renderFieldHeader($Page->Nomor_Karpeg) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <th data-name="Nomor_Stambuk" class="<?= $Page->Nomor_Stambuk->headerCellClass() ?>"><div id="elh_dosen_Nomor_Stambuk" class="dosen_Nomor_Stambuk"><?= $Page->renderFieldHeader($Page->Nomor_Stambuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <th data-name="Jenis_kelamin" class="<?= $Page->Jenis_kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_kelamin" class="dosen_Jenis_kelamin"><?= $Page->renderFieldHeader($Page->Jenis_kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <th data-name="Gol_Darah" class="<?= $Page->Gol_Darah->headerCellClass() ?>"><div id="elh_dosen_Gol_Darah" class="dosen_Gol_Darah"><?= $Page->renderFieldHeader($Page->Gol_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
        <th data-name="Agama" class="<?= $Page->Agama->headerCellClass() ?>"><div id="elh_dosen_Agama" class="dosen_Agama"><?= $Page->renderFieldHeader($Page->Agama) ?></div></th>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <th data-name="Stattus_menikah" class="<?= $Page->Stattus_menikah->headerCellClass() ?>"><div id="elh_dosen_Stattus_menikah" class="dosen_Stattus_menikah"><?= $Page->renderFieldHeader($Page->Stattus_menikah) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
        <th data-name="Kota" class="<?= $Page->Kota->headerCellClass() ?>"><div id="elh_dosen_Kota" class="dosen_Kota"><?= $Page->renderFieldHeader($Page->Kota) ?></div></th>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <th data-name="Telepon_seluler" class="<?= $Page->Telepon_seluler->headerCellClass() ?>"><div id="elh_dosen_Telepon_seluler" class="dosen_Telepon_seluler"><?= $Page->renderFieldHeader($Page->Telepon_seluler) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <th data-name="Jenis_pegawai" class="<?= $Page->Jenis_pegawai->headerCellClass() ?>"><div id="elh_dosen_Jenis_pegawai" class="dosen_Jenis_pegawai"><?= $Page->renderFieldHeader($Page->Jenis_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <th data-name="Status_pegawai" class="<?= $Page->Status_pegawai->headerCellClass() ?>"><div id="elh_dosen_Status_pegawai" class="dosen_Status_pegawai"><?= $Page->renderFieldHeader($Page->Status_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
        <th data-name="Golongan" class="<?= $Page->Golongan->headerCellClass() ?>"><div id="elh_dosen_Golongan" class="dosen_Golongan"><?= $Page->renderFieldHeader($Page->Golongan) ?></div></th>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <th data-name="Pangkat" class="<?= $Page->Pangkat->headerCellClass() ?>"><div id="elh_dosen_Pangkat" class="dosen_Pangkat"><?= $Page->renderFieldHeader($Page->Pangkat) ?></div></th>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <th data-name="Status_dosen" class="<?= $Page->Status_dosen->headerCellClass() ?>"><div id="elh_dosen_Status_dosen" class="dosen_Status_dosen"><?= $Page->renderFieldHeader($Page->Status_dosen) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <th data-name="Status_Belajar" class="<?= $Page->Status_Belajar->headerCellClass() ?>"><div id="elh_dosen_Status_Belajar" class="dosen_Status_Belajar"><?= $Page->renderFieldHeader($Page->Status_Belajar) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
        <th data-name="e_mail" class="<?= $Page->e_mail->headerCellClass() ?>"><div id="elh_dosen_e_mail" class="dosen_e_mail"><?= $Page->renderFieldHeader($Page->e_mail) ?></div></th>
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
    <?php if ($Page->No->Visible) { // No ?>
        <td data-name="No"<?= $Page->No->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_No" class="el_dosen_No">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIP->Visible) { // NIP ?>
        <td data-name="NIP"<?= $Page->NIP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIP" class="el_dosen_NIP">
<span<?= $Page->NIP->viewAttributes() ?>>
<?= $Page->NIP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <td data-name="Gelar_Depan"<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Depan" class="el_dosen_Gelar_Depan">
<span<?= $Page->Gelar_Depan->viewAttributes() ?>>
<?= $Page->Gelar_Depan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <td data-name="Gelar_Belakang"<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Belakang" class="el_dosen_Gelar_Belakang">
<span<?= $Page->Gelar_Belakang->viewAttributes() ?>>
<?= $Page->Gelar_Belakang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <td data-name="Program_studi"<?= $Page->Program_studi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Program_studi" class="el_dosen_Program_studi">
<span<?= $Page->Program_studi->viewAttributes() ?>>
<?= $Page->Program_studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK->Visible) { // NIK ?>
        <td data-name="NIK"<?= $Page->NIK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIK" class="el_dosen_NIK">
<span<?= $Page->NIK->viewAttributes() ?>>
<?= $Page->NIK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <td data-name="Tanggal_lahir"<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tanggal_lahir" class="el_dosen_Tanggal_lahir">
<span<?= $Page->Tanggal_lahir->viewAttributes() ?>>
<?= $Page->Tanggal_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <td data-name="Tempat_lahir"<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tempat_lahir" class="el_dosen_Tempat_lahir">
<span<?= $Page->Tempat_lahir->viewAttributes() ?>>
<?= $Page->Tempat_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <td data-name="Nomor_Karpeg"<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Karpeg" class="el_dosen_Nomor_Karpeg">
<span<?= $Page->Nomor_Karpeg->viewAttributes() ?>>
<?= $Page->Nomor_Karpeg->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <td data-name="Nomor_Stambuk"<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Stambuk" class="el_dosen_Nomor_Stambuk">
<span<?= $Page->Nomor_Stambuk->viewAttributes() ?>>
<?= $Page->Nomor_Stambuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <td data-name="Jenis_kelamin"<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_kelamin" class="el_dosen_Jenis_kelamin">
<span<?= $Page->Jenis_kelamin->viewAttributes() ?>>
<?= $Page->Jenis_kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <td data-name="Gol_Darah"<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gol_Darah" class="el_dosen_Gol_Darah">
<span<?= $Page->Gol_Darah->viewAttributes() ?>>
<?= $Page->Gol_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Agama->Visible) { // Agama ?>
        <td data-name="Agama"<?= $Page->Agama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Agama" class="el_dosen_Agama">
<span<?= $Page->Agama->viewAttributes() ?>>
<?= $Page->Agama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <td data-name="Stattus_menikah"<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Stattus_menikah" class="el_dosen_Stattus_menikah">
<span<?= $Page->Stattus_menikah->viewAttributes() ?>>
<?= $Page->Stattus_menikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota->Visible) { // Kota ?>
        <td data-name="Kota"<?= $Page->Kota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Kota" class="el_dosen_Kota">
<span<?= $Page->Kota->viewAttributes() ?>>
<?= $Page->Kota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <td data-name="Telepon_seluler"<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Telepon_seluler" class="el_dosen_Telepon_seluler">
<span<?= $Page->Telepon_seluler->viewAttributes() ?>>
<?= $Page->Telepon_seluler->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <td data-name="Jenis_pegawai"<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_pegawai" class="el_dosen_Jenis_pegawai">
<span<?= $Page->Jenis_pegawai->viewAttributes() ?>>
<?= $Page->Jenis_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <td data-name="Status_pegawai"<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_pegawai" class="el_dosen_Status_pegawai">
<span<?= $Page->Status_pegawai->viewAttributes() ?>>
<?= $Page->Status_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan->Visible) { // Golongan ?>
        <td data-name="Golongan"<?= $Page->Golongan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Golongan" class="el_dosen_Golongan">
<span<?= $Page->Golongan->viewAttributes() ?>>
<?= $Page->Golongan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <td data-name="Pangkat"<?= $Page->Pangkat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Pangkat" class="el_dosen_Pangkat">
<span<?= $Page->Pangkat->viewAttributes() ?>>
<?= $Page->Pangkat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <td data-name="Status_dosen"<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_dosen" class="el_dosen_Status_dosen">
<span<?= $Page->Status_dosen->viewAttributes() ?>>
<?= $Page->Status_dosen->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <td data-name="Status_Belajar"<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_Belajar" class="el_dosen_Status_Belajar">
<span<?= $Page->Status_Belajar->viewAttributes() ?>>
<?= $Page->Status_Belajar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail->Visible) { // e_mail ?>
        <td data-name="e_mail"<?= $Page->e_mail->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_e_mail" class="el_dosen_e_mail">
<span<?= $Page->e_mail->viewAttributes() ?>>
<?= $Page->e_mail->getViewValue() ?></span>
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
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->No->Visible) { // No ?>
        <th data-name="No" class="<?= $Page->No->headerCellClass() ?>"><div id="elh_dosen_No" class="dosen_No"><?= $Page->renderFieldHeader($Page->No) ?></div></th>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
        <th data-name="NIP" class="<?= $Page->NIP->headerCellClass() ?>"><div id="elh_dosen_NIP" class="dosen_NIP"><?= $Page->renderFieldHeader($Page->NIP) ?></div></th>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <th data-name="Gelar_Depan" class="<?= $Page->Gelar_Depan->headerCellClass() ?>"><div id="elh_dosen_Gelar_Depan" class="dosen_Gelar_Depan"><?= $Page->renderFieldHeader($Page->Gelar_Depan) ?></div></th>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <th data-name="Gelar_Belakang" class="<?= $Page->Gelar_Belakang->headerCellClass() ?>"><div id="elh_dosen_Gelar_Belakang" class="dosen_Gelar_Belakang"><?= $Page->renderFieldHeader($Page->Gelar_Belakang) ?></div></th>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <th data-name="Program_studi" class="<?= $Page->Program_studi->headerCellClass() ?>"><div id="elh_dosen_Program_studi" class="dosen_Program_studi"><?= $Page->renderFieldHeader($Page->Program_studi) ?></div></th>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
        <th data-name="NIK" class="<?= $Page->NIK->headerCellClass() ?>"><div id="elh_dosen_NIK" class="dosen_NIK"><?= $Page->renderFieldHeader($Page->NIK) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <th data-name="Tanggal_lahir" class="<?= $Page->Tanggal_lahir->headerCellClass() ?>"><div id="elh_dosen_Tanggal_lahir" class="dosen_Tanggal_lahir"><?= $Page->renderFieldHeader($Page->Tanggal_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <th data-name="Tempat_lahir" class="<?= $Page->Tempat_lahir->headerCellClass() ?>"><div id="elh_dosen_Tempat_lahir" class="dosen_Tempat_lahir"><?= $Page->renderFieldHeader($Page->Tempat_lahir) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <th data-name="Nomor_Karpeg" class="<?= $Page->Nomor_Karpeg->headerCellClass() ?>"><div id="elh_dosen_Nomor_Karpeg" class="dosen_Nomor_Karpeg"><?= $Page->renderFieldHeader($Page->Nomor_Karpeg) ?></div></th>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <th data-name="Nomor_Stambuk" class="<?= $Page->Nomor_Stambuk->headerCellClass() ?>"><div id="elh_dosen_Nomor_Stambuk" class="dosen_Nomor_Stambuk"><?= $Page->renderFieldHeader($Page->Nomor_Stambuk) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <th data-name="Jenis_kelamin" class="<?= $Page->Jenis_kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_kelamin" class="dosen_Jenis_kelamin"><?= $Page->renderFieldHeader($Page->Jenis_kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <th data-name="Gol_Darah" class="<?= $Page->Gol_Darah->headerCellClass() ?>"><div id="elh_dosen_Gol_Darah" class="dosen_Gol_Darah"><?= $Page->renderFieldHeader($Page->Gol_Darah) ?></div></th>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
        <th data-name="Agama" class="<?= $Page->Agama->headerCellClass() ?>"><div id="elh_dosen_Agama" class="dosen_Agama"><?= $Page->renderFieldHeader($Page->Agama) ?></div></th>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <th data-name="Stattus_menikah" class="<?= $Page->Stattus_menikah->headerCellClass() ?>"><div id="elh_dosen_Stattus_menikah" class="dosen_Stattus_menikah"><?= $Page->renderFieldHeader($Page->Stattus_menikah) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
        <th data-name="Kota" class="<?= $Page->Kota->headerCellClass() ?>"><div id="elh_dosen_Kota" class="dosen_Kota"><?= $Page->renderFieldHeader($Page->Kota) ?></div></th>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <th data-name="Telepon_seluler" class="<?= $Page->Telepon_seluler->headerCellClass() ?>"><div id="elh_dosen_Telepon_seluler" class="dosen_Telepon_seluler"><?= $Page->renderFieldHeader($Page->Telepon_seluler) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <th data-name="Jenis_pegawai" class="<?= $Page->Jenis_pegawai->headerCellClass() ?>"><div id="elh_dosen_Jenis_pegawai" class="dosen_Jenis_pegawai"><?= $Page->renderFieldHeader($Page->Jenis_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <th data-name="Status_pegawai" class="<?= $Page->Status_pegawai->headerCellClass() ?>"><div id="elh_dosen_Status_pegawai" class="dosen_Status_pegawai"><?= $Page->renderFieldHeader($Page->Status_pegawai) ?></div></th>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
        <th data-name="Golongan" class="<?= $Page->Golongan->headerCellClass() ?>"><div id="elh_dosen_Golongan" class="dosen_Golongan"><?= $Page->renderFieldHeader($Page->Golongan) ?></div></th>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <th data-name="Pangkat" class="<?= $Page->Pangkat->headerCellClass() ?>"><div id="elh_dosen_Pangkat" class="dosen_Pangkat"><?= $Page->renderFieldHeader($Page->Pangkat) ?></div></th>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <th data-name="Status_dosen" class="<?= $Page->Status_dosen->headerCellClass() ?>"><div id="elh_dosen_Status_dosen" class="dosen_Status_dosen"><?= $Page->renderFieldHeader($Page->Status_dosen) ?></div></th>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <th data-name="Status_Belajar" class="<?= $Page->Status_Belajar->headerCellClass() ?>"><div id="elh_dosen_Status_Belajar" class="dosen_Status_Belajar"><?= $Page->renderFieldHeader($Page->Status_Belajar) ?></div></th>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
        <th data-name="e_mail" class="<?= $Page->e_mail->headerCellClass() ?>"><div id="elh_dosen_e_mail" class="dosen_e_mail"><?= $Page->renderFieldHeader($Page->e_mail) ?></div></th>
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
    <?php if ($Page->No->Visible) { // No ?>
        <td data-name="No"<?= $Page->No->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_No" class="el_dosen_No">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIP->Visible) { // NIP ?>
        <td data-name="NIP"<?= $Page->NIP->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIP" class="el_dosen_NIP">
<span<?= $Page->NIP->viewAttributes() ?>>
<?= $Page->NIP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <td data-name="Gelar_Depan"<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Depan" class="el_dosen_Gelar_Depan">
<span<?= $Page->Gelar_Depan->viewAttributes() ?>>
<?= $Page->Gelar_Depan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <td data-name="Gelar_Belakang"<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gelar_Belakang" class="el_dosen_Gelar_Belakang">
<span<?= $Page->Gelar_Belakang->viewAttributes() ?>>
<?= $Page->Gelar_Belakang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <td data-name="Program_studi"<?= $Page->Program_studi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Program_studi" class="el_dosen_Program_studi">
<span<?= $Page->Program_studi->viewAttributes() ?>>
<?= $Page->Program_studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIK->Visible) { // NIK ?>
        <td data-name="NIK"<?= $Page->NIK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_NIK" class="el_dosen_NIK">
<span<?= $Page->NIK->viewAttributes() ?>>
<?= $Page->NIK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <td data-name="Tanggal_lahir"<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tanggal_lahir" class="el_dosen_Tanggal_lahir">
<span<?= $Page->Tanggal_lahir->viewAttributes() ?>>
<?= $Page->Tanggal_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <td data-name="Tempat_lahir"<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Tempat_lahir" class="el_dosen_Tempat_lahir">
<span<?= $Page->Tempat_lahir->viewAttributes() ?>>
<?= $Page->Tempat_lahir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <td data-name="Nomor_Karpeg"<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Karpeg" class="el_dosen_Nomor_Karpeg">
<span<?= $Page->Nomor_Karpeg->viewAttributes() ?>>
<?= $Page->Nomor_Karpeg->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <td data-name="Nomor_Stambuk"<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Nomor_Stambuk" class="el_dosen_Nomor_Stambuk">
<span<?= $Page->Nomor_Stambuk->viewAttributes() ?>>
<?= $Page->Nomor_Stambuk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <td data-name="Jenis_kelamin"<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_kelamin" class="el_dosen_Jenis_kelamin">
<span<?= $Page->Jenis_kelamin->viewAttributes() ?>>
<?= $Page->Jenis_kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <td data-name="Gol_Darah"<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Gol_Darah" class="el_dosen_Gol_Darah">
<span<?= $Page->Gol_Darah->viewAttributes() ?>>
<?= $Page->Gol_Darah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Agama->Visible) { // Agama ?>
        <td data-name="Agama"<?= $Page->Agama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Agama" class="el_dosen_Agama">
<span<?= $Page->Agama->viewAttributes() ?>>
<?= $Page->Agama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <td data-name="Stattus_menikah"<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Stattus_menikah" class="el_dosen_Stattus_menikah">
<span<?= $Page->Stattus_menikah->viewAttributes() ?>>
<?= $Page->Stattus_menikah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kota->Visible) { // Kota ?>
        <td data-name="Kota"<?= $Page->Kota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Kota" class="el_dosen_Kota">
<span<?= $Page->Kota->viewAttributes() ?>>
<?= $Page->Kota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <td data-name="Telepon_seluler"<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Telepon_seluler" class="el_dosen_Telepon_seluler">
<span<?= $Page->Telepon_seluler->viewAttributes() ?>>
<?= $Page->Telepon_seluler->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <td data-name="Jenis_pegawai"<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Jenis_pegawai" class="el_dosen_Jenis_pegawai">
<span<?= $Page->Jenis_pegawai->viewAttributes() ?>>
<?= $Page->Jenis_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <td data-name="Status_pegawai"<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_pegawai" class="el_dosen_Status_pegawai">
<span<?= $Page->Status_pegawai->viewAttributes() ?>>
<?= $Page->Status_pegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Golongan->Visible) { // Golongan ?>
        <td data-name="Golongan"<?= $Page->Golongan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Golongan" class="el_dosen_Golongan">
<span<?= $Page->Golongan->viewAttributes() ?>>
<?= $Page->Golongan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <td data-name="Pangkat"<?= $Page->Pangkat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Pangkat" class="el_dosen_Pangkat">
<span<?= $Page->Pangkat->viewAttributes() ?>>
<?= $Page->Pangkat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <td data-name="Status_dosen"<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_dosen" class="el_dosen_Status_dosen">
<span<?= $Page->Status_dosen->viewAttributes() ?>>
<?= $Page->Status_dosen->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <td data-name="Status_Belajar"<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_Status_Belajar" class="el_dosen_Status_Belajar">
<span<?= $Page->Status_Belajar->viewAttributes() ?>>
<?= $Page->Status_Belajar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->e_mail->Visible) { // e_mail ?>
        <td data-name="e_mail"<?= $Page->e_mail->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_dosen_e_mail" class="el_dosen_e_mail">
<span<?= $Page->e_mail->viewAttributes() ?>>
<?= $Page->e_mail->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosendelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosendelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="dosen"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'dosenlist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$dosen->isExport()) { ?>
<script>
loadjs.ready("jscookie", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle');
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			ew.Cookies.set(ew.PROJECT_NAME + "_dosen_searchpanel", "notactive", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} else { 
			ew.Cookies.set(ew.PROJECT_NAME + "_dosen_searchpanel", "active", {
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
    ew.addEventHandlers("dosen");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
