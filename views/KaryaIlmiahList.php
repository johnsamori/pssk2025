<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KaryaIlmiahList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { karya_ilmiah: currentTable } });
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
<form name="fkarya_ilmiahsrch" id="fkarya_ilmiahsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fkarya_ilmiahsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { karya_ilmiah: currentTable } });
var currentForm;
var fkarya_ilmiahsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fkarya_ilmiahsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fkarya_ilmiahsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fkarya_ilmiahsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fkarya_ilmiahsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fkarya_ilmiahsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="karya_ilmiah">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_karya_ilmiah" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_karya_ilmiahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <th data-name="Id_karya_ilmiah" class="<?= $Page->Id_karya_ilmiah->headerCellClass() ?>"><div id="elh_karya_ilmiah_Id_karya_ilmiah" class="karya_ilmiah_Id_karya_ilmiah"><?= $Page->renderFieldHeader($Page->Id_karya_ilmiah) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_karya_ilmiah_NIM" class="karya_ilmiah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Penelitian" class="karya_ilmiah_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <th data-name="Pembimbing_1" class="<?= $Page->Pembimbing_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_1" class="karya_ilmiah_Pembimbing_1"><?= $Page->renderFieldHeader($Page->Pembimbing_1) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <th data-name="Pembimbing_2" class="<?= $Page->Pembimbing_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_2" class="karya_ilmiah_Pembimbing_2"><?= $Page->renderFieldHeader($Page->Pembimbing_2) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <th data-name="Pembimbing_3" class="<?= $Page->Pembimbing_3->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_3" class="karya_ilmiah_Pembimbing_3"><?= $Page->renderFieldHeader($Page->Pembimbing_3) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <th data-name="Penguji_1" class="<?= $Page->Penguji_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_1" class="karya_ilmiah_Penguji_1"><?= $Page->renderFieldHeader($Page->Penguji_1) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <th data-name="Penguji_2" class="<?= $Page->Penguji_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_2" class="karya_ilmiah_Penguji_2"><?= $Page->renderFieldHeader($Page->Penguji_2) ?></div></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th data-name="Lembar_Pengesahan" class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><div id="elh_karya_ilmiah_Lembar_Pengesahan" class="karya_ilmiah_Lembar_Pengesahan"><?= $Page->renderFieldHeader($Page->Lembar_Pengesahan) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <th data-name="Judul_Publikasi" class="<?= $Page->Judul_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Publikasi" class="karya_ilmiah_Judul_Publikasi"><?= $Page->renderFieldHeader($Page->Judul_Publikasi) ?></div></th>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <th data-name="Link_Publikasi" class="<?= $Page->Link_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Link_Publikasi" class="karya_ilmiah_Link_Publikasi"><?= $Page->renderFieldHeader($Page->Link_Publikasi) ?></div></th>
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
    <?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <td data-name="Id_karya_ilmiah"<?= $Page->Id_karya_ilmiah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Id_karya_ilmiah" class="el_karya_ilmiah_Id_karya_ilmiah">
<span<?= $Page->Id_karya_ilmiah->viewAttributes() ?>>
<?= $Page->Id_karya_ilmiah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_NIM" class="el_karya_ilmiah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Penelitian" class="el_karya_ilmiah_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <td data-name="Pembimbing_1"<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_1" class="el_karya_ilmiah_Pembimbing_1">
<span<?= $Page->Pembimbing_1->viewAttributes() ?>>
<?= $Page->Pembimbing_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <td data-name="Pembimbing_2"<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_2" class="el_karya_ilmiah_Pembimbing_2">
<span<?= $Page->Pembimbing_2->viewAttributes() ?>>
<?= $Page->Pembimbing_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <td data-name="Pembimbing_3"<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_3" class="el_karya_ilmiah_Pembimbing_3">
<span<?= $Page->Pembimbing_3->viewAttributes() ?>>
<?= $Page->Pembimbing_3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <td data-name="Penguji_1"<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_1" class="el_karya_ilmiah_Penguji_1">
<span<?= $Page->Penguji_1->viewAttributes() ?>>
<?= $Page->Penguji_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <td data-name="Penguji_2"<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_2" class="el_karya_ilmiah_Penguji_2">
<span<?= $Page->Penguji_2->viewAttributes() ?>>
<?= $Page->Penguji_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Lembar_Pengesahan" class="el_karya_ilmiah_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <td data-name="Judul_Publikasi"<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Publikasi" class="el_karya_ilmiah_Judul_Publikasi">
<span<?= $Page->Judul_Publikasi->viewAttributes() ?>>
<?= $Page->Judul_Publikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <td data-name="Link_Publikasi"<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Link_Publikasi" class="el_karya_ilmiah_Link_Publikasi">
<span<?= $Page->Link_Publikasi->viewAttributes() ?>>
<?= $Page->Link_Publikasi->getViewValue() ?></span>
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
<table id="tbl_karya_ilmiahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <th data-name="Id_karya_ilmiah" class="<?= $Page->Id_karya_ilmiah->headerCellClass() ?>"><div id="elh_karya_ilmiah_Id_karya_ilmiah" class="karya_ilmiah_Id_karya_ilmiah"><?= $Page->renderFieldHeader($Page->Id_karya_ilmiah) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_karya_ilmiah_NIM" class="karya_ilmiah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Penelitian" class="karya_ilmiah_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <th data-name="Pembimbing_1" class="<?= $Page->Pembimbing_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_1" class="karya_ilmiah_Pembimbing_1"><?= $Page->renderFieldHeader($Page->Pembimbing_1) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <th data-name="Pembimbing_2" class="<?= $Page->Pembimbing_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_2" class="karya_ilmiah_Pembimbing_2"><?= $Page->renderFieldHeader($Page->Pembimbing_2) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <th data-name="Pembimbing_3" class="<?= $Page->Pembimbing_3->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_3" class="karya_ilmiah_Pembimbing_3"><?= $Page->renderFieldHeader($Page->Pembimbing_3) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <th data-name="Penguji_1" class="<?= $Page->Penguji_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_1" class="karya_ilmiah_Penguji_1"><?= $Page->renderFieldHeader($Page->Penguji_1) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <th data-name="Penguji_2" class="<?= $Page->Penguji_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_2" class="karya_ilmiah_Penguji_2"><?= $Page->renderFieldHeader($Page->Penguji_2) ?></div></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th data-name="Lembar_Pengesahan" class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><div id="elh_karya_ilmiah_Lembar_Pengesahan" class="karya_ilmiah_Lembar_Pengesahan"><?= $Page->renderFieldHeader($Page->Lembar_Pengesahan) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <th data-name="Judul_Publikasi" class="<?= $Page->Judul_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Publikasi" class="karya_ilmiah_Judul_Publikasi"><?= $Page->renderFieldHeader($Page->Judul_Publikasi) ?></div></th>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <th data-name="Link_Publikasi" class="<?= $Page->Link_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Link_Publikasi" class="karya_ilmiah_Link_Publikasi"><?= $Page->renderFieldHeader($Page->Link_Publikasi) ?></div></th>
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
    <?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <td data-name="Id_karya_ilmiah"<?= $Page->Id_karya_ilmiah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Id_karya_ilmiah" class="el_karya_ilmiah_Id_karya_ilmiah">
<span<?= $Page->Id_karya_ilmiah->viewAttributes() ?>>
<?= $Page->Id_karya_ilmiah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_NIM" class="el_karya_ilmiah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Penelitian" class="el_karya_ilmiah_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <td data-name="Pembimbing_1"<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_1" class="el_karya_ilmiah_Pembimbing_1">
<span<?= $Page->Pembimbing_1->viewAttributes() ?>>
<?= $Page->Pembimbing_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <td data-name="Pembimbing_2"<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_2" class="el_karya_ilmiah_Pembimbing_2">
<span<?= $Page->Pembimbing_2->viewAttributes() ?>>
<?= $Page->Pembimbing_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <td data-name="Pembimbing_3"<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_3" class="el_karya_ilmiah_Pembimbing_3">
<span<?= $Page->Pembimbing_3->viewAttributes() ?>>
<?= $Page->Pembimbing_3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <td data-name="Penguji_1"<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_1" class="el_karya_ilmiah_Penguji_1">
<span<?= $Page->Penguji_1->viewAttributes() ?>>
<?= $Page->Penguji_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <td data-name="Penguji_2"<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_2" class="el_karya_ilmiah_Penguji_2">
<span<?= $Page->Penguji_2->viewAttributes() ?>>
<?= $Page->Penguji_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Lembar_Pengesahan" class="el_karya_ilmiah_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <td data-name="Judul_Publikasi"<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Publikasi" class="el_karya_ilmiah_Judul_Publikasi">
<span<?= $Page->Judul_Publikasi->viewAttributes() ?>>
<?= $Page->Judul_Publikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <td data-name="Link_Publikasi"<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Link_Publikasi" class="el_karya_ilmiah_Link_Publikasi">
<span<?= $Page->Link_Publikasi->viewAttributes() ?>>
<?= $Page->Link_Publikasi->getViewValue() ?></span>
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
<input type="hidden" name="t" value="karya_ilmiah">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_karya_ilmiah" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_karya_ilmiahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <th data-name="Id_karya_ilmiah" class="<?= $Page->Id_karya_ilmiah->headerCellClass() ?>"><div id="elh_karya_ilmiah_Id_karya_ilmiah" class="karya_ilmiah_Id_karya_ilmiah"><?= $Page->renderFieldHeader($Page->Id_karya_ilmiah) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_karya_ilmiah_NIM" class="karya_ilmiah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Penelitian" class="karya_ilmiah_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <th data-name="Pembimbing_1" class="<?= $Page->Pembimbing_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_1" class="karya_ilmiah_Pembimbing_1"><?= $Page->renderFieldHeader($Page->Pembimbing_1) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <th data-name="Pembimbing_2" class="<?= $Page->Pembimbing_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_2" class="karya_ilmiah_Pembimbing_2"><?= $Page->renderFieldHeader($Page->Pembimbing_2) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <th data-name="Pembimbing_3" class="<?= $Page->Pembimbing_3->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_3" class="karya_ilmiah_Pembimbing_3"><?= $Page->renderFieldHeader($Page->Pembimbing_3) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <th data-name="Penguji_1" class="<?= $Page->Penguji_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_1" class="karya_ilmiah_Penguji_1"><?= $Page->renderFieldHeader($Page->Penguji_1) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <th data-name="Penguji_2" class="<?= $Page->Penguji_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_2" class="karya_ilmiah_Penguji_2"><?= $Page->renderFieldHeader($Page->Penguji_2) ?></div></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th data-name="Lembar_Pengesahan" class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><div id="elh_karya_ilmiah_Lembar_Pengesahan" class="karya_ilmiah_Lembar_Pengesahan"><?= $Page->renderFieldHeader($Page->Lembar_Pengesahan) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <th data-name="Judul_Publikasi" class="<?= $Page->Judul_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Publikasi" class="karya_ilmiah_Judul_Publikasi"><?= $Page->renderFieldHeader($Page->Judul_Publikasi) ?></div></th>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <th data-name="Link_Publikasi" class="<?= $Page->Link_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Link_Publikasi" class="karya_ilmiah_Link_Publikasi"><?= $Page->renderFieldHeader($Page->Link_Publikasi) ?></div></th>
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
    <?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <td data-name="Id_karya_ilmiah"<?= $Page->Id_karya_ilmiah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Id_karya_ilmiah" class="el_karya_ilmiah_Id_karya_ilmiah">
<span<?= $Page->Id_karya_ilmiah->viewAttributes() ?>>
<?= $Page->Id_karya_ilmiah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_NIM" class="el_karya_ilmiah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Penelitian" class="el_karya_ilmiah_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <td data-name="Pembimbing_1"<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_1" class="el_karya_ilmiah_Pembimbing_1">
<span<?= $Page->Pembimbing_1->viewAttributes() ?>>
<?= $Page->Pembimbing_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <td data-name="Pembimbing_2"<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_2" class="el_karya_ilmiah_Pembimbing_2">
<span<?= $Page->Pembimbing_2->viewAttributes() ?>>
<?= $Page->Pembimbing_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <td data-name="Pembimbing_3"<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_3" class="el_karya_ilmiah_Pembimbing_3">
<span<?= $Page->Pembimbing_3->viewAttributes() ?>>
<?= $Page->Pembimbing_3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <td data-name="Penguji_1"<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_1" class="el_karya_ilmiah_Penguji_1">
<span<?= $Page->Penguji_1->viewAttributes() ?>>
<?= $Page->Penguji_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <td data-name="Penguji_2"<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_2" class="el_karya_ilmiah_Penguji_2">
<span<?= $Page->Penguji_2->viewAttributes() ?>>
<?= $Page->Penguji_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Lembar_Pengesahan" class="el_karya_ilmiah_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <td data-name="Judul_Publikasi"<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Publikasi" class="el_karya_ilmiah_Judul_Publikasi">
<span<?= $Page->Judul_Publikasi->viewAttributes() ?>>
<?= $Page->Judul_Publikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <td data-name="Link_Publikasi"<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Link_Publikasi" class="el_karya_ilmiah_Link_Publikasi">
<span<?= $Page->Link_Publikasi->viewAttributes() ?>>
<?= $Page->Link_Publikasi->getViewValue() ?></span>
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
<table id="tbl_karya_ilmiahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <th data-name="Id_karya_ilmiah" class="<?= $Page->Id_karya_ilmiah->headerCellClass() ?>"><div id="elh_karya_ilmiah_Id_karya_ilmiah" class="karya_ilmiah_Id_karya_ilmiah"><?= $Page->renderFieldHeader($Page->Id_karya_ilmiah) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_karya_ilmiah_NIM" class="karya_ilmiah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Penelitian" class="karya_ilmiah_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <th data-name="Pembimbing_1" class="<?= $Page->Pembimbing_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_1" class="karya_ilmiah_Pembimbing_1"><?= $Page->renderFieldHeader($Page->Pembimbing_1) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <th data-name="Pembimbing_2" class="<?= $Page->Pembimbing_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_2" class="karya_ilmiah_Pembimbing_2"><?= $Page->renderFieldHeader($Page->Pembimbing_2) ?></div></th>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <th data-name="Pembimbing_3" class="<?= $Page->Pembimbing_3->headerCellClass() ?>"><div id="elh_karya_ilmiah_Pembimbing_3" class="karya_ilmiah_Pembimbing_3"><?= $Page->renderFieldHeader($Page->Pembimbing_3) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <th data-name="Penguji_1" class="<?= $Page->Penguji_1->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_1" class="karya_ilmiah_Penguji_1"><?= $Page->renderFieldHeader($Page->Penguji_1) ?></div></th>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <th data-name="Penguji_2" class="<?= $Page->Penguji_2->headerCellClass() ?>"><div id="elh_karya_ilmiah_Penguji_2" class="karya_ilmiah_Penguji_2"><?= $Page->renderFieldHeader($Page->Penguji_2) ?></div></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th data-name="Lembar_Pengesahan" class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><div id="elh_karya_ilmiah_Lembar_Pengesahan" class="karya_ilmiah_Lembar_Pengesahan"><?= $Page->renderFieldHeader($Page->Lembar_Pengesahan) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <th data-name="Judul_Publikasi" class="<?= $Page->Judul_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Judul_Publikasi" class="karya_ilmiah_Judul_Publikasi"><?= $Page->renderFieldHeader($Page->Judul_Publikasi) ?></div></th>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <th data-name="Link_Publikasi" class="<?= $Page->Link_Publikasi->headerCellClass() ?>"><div id="elh_karya_ilmiah_Link_Publikasi" class="karya_ilmiah_Link_Publikasi"><?= $Page->renderFieldHeader($Page->Link_Publikasi) ?></div></th>
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
    <?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <td data-name="Id_karya_ilmiah"<?= $Page->Id_karya_ilmiah->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Id_karya_ilmiah" class="el_karya_ilmiah_Id_karya_ilmiah">
<span<?= $Page->Id_karya_ilmiah->viewAttributes() ?>>
<?= $Page->Id_karya_ilmiah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_NIM" class="el_karya_ilmiah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Penelitian" class="el_karya_ilmiah_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <td data-name="Pembimbing_1"<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_1" class="el_karya_ilmiah_Pembimbing_1">
<span<?= $Page->Pembimbing_1->viewAttributes() ?>>
<?= $Page->Pembimbing_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <td data-name="Pembimbing_2"<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_2" class="el_karya_ilmiah_Pembimbing_2">
<span<?= $Page->Pembimbing_2->viewAttributes() ?>>
<?= $Page->Pembimbing_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <td data-name="Pembimbing_3"<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Pembimbing_3" class="el_karya_ilmiah_Pembimbing_3">
<span<?= $Page->Pembimbing_3->viewAttributes() ?>>
<?= $Page->Pembimbing_3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <td data-name="Penguji_1"<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_1" class="el_karya_ilmiah_Penguji_1">
<span<?= $Page->Penguji_1->viewAttributes() ?>>
<?= $Page->Penguji_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <td data-name="Penguji_2"<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Penguji_2" class="el_karya_ilmiah_Penguji_2">
<span<?= $Page->Penguji_2->viewAttributes() ?>>
<?= $Page->Penguji_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Lembar_Pengesahan" class="el_karya_ilmiah_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <td data-name="Judul_Publikasi"<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Judul_Publikasi" class="el_karya_ilmiah_Judul_Publikasi">
<span<?= $Page->Judul_Publikasi->viewAttributes() ?>>
<?= $Page->Judul_Publikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <td data-name="Link_Publikasi"<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_karya_ilmiah_Link_Publikasi" class="el_karya_ilmiah_Link_Publikasi">
<span<?= $Page->Link_Publikasi->viewAttributes() ?>>
<?= $Page->Link_Publikasi->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkarya_ilmiahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkarya_ilmiahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkarya_ilmiahupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkarya_ilmiahdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkarya_ilmiahlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkarya_ilmiahlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkarya_ilmiahlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="karya_ilmiah"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'karya_ilmiahlist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$karya_ilmiah->isExport()) { ?>
<script>
loadjs.ready("jscookie", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle');
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			ew.Cookies.set(ew.PROJECT_NAME + "_karya_ilmiah_searchpanel", "notactive", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} else { 
			ew.Cookies.set(ew.PROJECT_NAME + "_karya_ilmiah_searchpanel", "active", {
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
    ew.addEventHandlers("karya_ilmiah");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
