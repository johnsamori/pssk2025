<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilMataKuliahList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: currentTable } });
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

        // Add fields
        .setFields([
            ["id_no", [fields.id_no.visible && fields.id_no.required ? ew.Validators.required(fields.id_no.caption) : null], fields.id_no.isInvalid],
            ["Kode_MK", [fields.Kode_MK.visible && fields.Kode_MK.required ? ew.Validators.required(fields.Kode_MK.caption) : null], fields.Kode_MK.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Nilai_Diskusi", [fields.Nilai_Diskusi.visible && fields.Nilai_Diskusi.required ? ew.Validators.required(fields.Nilai_Diskusi.caption) : null], fields.Nilai_Diskusi.isInvalid],
            ["Assessment_Skor_As_1", [fields.Assessment_Skor_As_1.visible && fields.Assessment_Skor_As_1.required ? ew.Validators.required(fields.Assessment_Skor_As_1.caption) : null], fields.Assessment_Skor_As_1.isInvalid],
            ["Assessment_Skor_As_2", [fields.Assessment_Skor_As_2.visible && fields.Assessment_Skor_As_2.required ? ew.Validators.required(fields.Assessment_Skor_As_2.caption) : null], fields.Assessment_Skor_As_2.isInvalid],
            ["Assessment_Skor_As_3", [fields.Assessment_Skor_As_3.visible && fields.Assessment_Skor_As_3.required ? ew.Validators.required(fields.Assessment_Skor_As_3.caption) : null], fields.Assessment_Skor_As_3.isInvalid],
            ["Nilai_Tugas", [fields.Nilai_Tugas.visible && fields.Nilai_Tugas.required ? ew.Validators.required(fields.Nilai_Tugas.caption) : null], fields.Nilai_Tugas.isInvalid],
            ["Nilai_UTS", [fields.Nilai_UTS.visible && fields.Nilai_UTS.required ? ew.Validators.required(fields.Nilai_UTS.caption) : null], fields.Nilai_UTS.isInvalid],
            ["Nilai_Akhir", [fields.Nilai_Akhir.visible && fields.Nilai_Akhir.required ? ew.Validators.required(fields.Nilai_Akhir.caption) : null], fields.Nilai_Akhir.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["Kode_MK",false],["NIM",false],["Nilai_Diskusi",false],["Assessment_Skor_As_1",false],["Assessment_Skor_As_2",false],["Assessment_Skor_As_3",false],["Nilai_Tugas",false],["Nilai_UTS",false],["Nilai_Akhir",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "mata_kuliah") {
    if ($Page->MasterRecordExists) {
        include_once "views/MataKuliahMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fdetil_mata_kuliahsrch" id="fdetil_mata_kuliahsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fdetil_mata_kuliahsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: currentTable } });
var currentForm;
var fdetil_mata_kuliahsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdetil_mata_kuliahsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdetil_mata_kuliahsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdetil_mata_kuliahsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdetil_mata_kuliahsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdetil_mata_kuliahsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="detil_mata_kuliah">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "mata_kuliah" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="mata_kuliah">
<input type="hidden" name="fk_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detil_mata_kuliah" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detil_mata_kuliahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_no->Visible) { // id_no ?>
        <th data-name="id_no" class="<?= $Page->id_no->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Page->renderFieldHeader($Page->id_no) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <th data-name="Kode_MK" class="<?= $Page->Kode_MK->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Page->renderFieldHeader($Page->Kode_MK) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th data-name="Nilai_Diskusi" class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Page->renderFieldHeader($Page->Nilai_Diskusi) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th data-name="Assessment_Skor_As_1" class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_1) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th data-name="Assessment_Skor_As_2" class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_2) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th data-name="Assessment_Skor_As_3" class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_3) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th data-name="Nilai_Tugas" class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Page->renderFieldHeader($Page->Nilai_Tugas) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th data-name="Nilai_UTS" class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Page->renderFieldHeader($Page->Nilai_UTS) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th data-name="Nilai_Akhir" class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Page->renderFieldHeader($Page->Nilai_Akhir) ?></div></th>
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

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete"
            && $Page->RowAction != "insertdelete"
            && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
            && $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_no->Visible) { // id_no ?>
        <td data-name="id_no"<?= $Page->id_no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_no" id="o<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_no->getDisplayValue($Page->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <td data-name="Kode_MK"<?= $Page->Kode_MK->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue ?? $Page->Kode_MK->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td data-name="Nilai_Diskusi"<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Diskusi" id="o<?= $Page->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Page->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td data-name="Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Page->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td data-name="Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Page->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td data-name="Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Page->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td data-name="Nilai_Tugas"<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Tugas" id="o<?= $Page->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Page->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td data-name="Nilai_UTS"<?= $Page->Nilai_UTS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_UTS" id="o<?= $Page->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Page->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td data-name="Nilai_Akhir"<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Akhir" id="o<?= $Page->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Page->Nilai_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script<?= Nonce() ?> data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

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
<table id="tbl_detil_mata_kuliahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_no->Visible) { // id_no ?>
        <th data-name="id_no" class="<?= $Page->id_no->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Page->renderFieldHeader($Page->id_no) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <th data-name="Kode_MK" class="<?= $Page->Kode_MK->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Page->renderFieldHeader($Page->Kode_MK) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th data-name="Nilai_Diskusi" class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Page->renderFieldHeader($Page->Nilai_Diskusi) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th data-name="Assessment_Skor_As_1" class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_1) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th data-name="Assessment_Skor_As_2" class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_2) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th data-name="Assessment_Skor_As_3" class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_3) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th data-name="Nilai_Tugas" class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Page->renderFieldHeader($Page->Nilai_Tugas) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th data-name="Nilai_UTS" class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Page->renderFieldHeader($Page->Nilai_UTS) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th data-name="Nilai_Akhir" class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Page->renderFieldHeader($Page->Nilai_Akhir) ?></div></th>
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
    <?php if ($Page->id_no->Visible) { // id_no ?>
        <td data-name="id_no"<?= $Page->id_no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_no" id="o<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_no->getDisplayValue($Page->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <td data-name="Kode_MK"<?= $Page->Kode_MK->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue ?? $Page->Kode_MK->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td data-name="Nilai_Diskusi"<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Diskusi" id="o<?= $Page->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Page->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td data-name="Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Page->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td data-name="Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Page->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td data-name="Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Page->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td data-name="Nilai_Tugas"<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Tugas" id="o<?= $Page->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Page->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td data-name="Nilai_UTS"<?= $Page->Nilai_UTS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_UTS" id="o<?= $Page->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Page->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td data-name="Nilai_Akhir"<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Akhir" id="o<?= $Page->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Page->Nilai_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
</span>
<?php } ?>
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
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->getFormKeyCountName() ?>" id="<?= $Page->getFormKeyCountName() ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormKeyCountName() ?>" id="<?= $Page->getFormKeyCountName() ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
<input type="hidden" name="t" value="detil_mata_kuliah">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "mata_kuliah" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="mata_kuliah">
<input type="hidden" name="fk_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detil_mata_kuliah" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detil_mata_kuliahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_no->Visible) { // id_no ?>
        <th data-name="id_no" class="<?= $Page->id_no->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Page->renderFieldHeader($Page->id_no) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <th data-name="Kode_MK" class="<?= $Page->Kode_MK->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Page->renderFieldHeader($Page->Kode_MK) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th data-name="Nilai_Diskusi" class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Page->renderFieldHeader($Page->Nilai_Diskusi) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th data-name="Assessment_Skor_As_1" class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_1) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th data-name="Assessment_Skor_As_2" class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_2) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th data-name="Assessment_Skor_As_3" class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_3) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th data-name="Nilai_Tugas" class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Page->renderFieldHeader($Page->Nilai_Tugas) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th data-name="Nilai_UTS" class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Page->renderFieldHeader($Page->Nilai_UTS) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th data-name="Nilai_Akhir" class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Page->renderFieldHeader($Page->Nilai_Akhir) ?></div></th>
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

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete"
            && $Page->RowAction != "insertdelete"
            && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
            && $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_no->Visible) { // id_no ?>
        <td data-name="id_no"<?= $Page->id_no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_no" id="o<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_no->getDisplayValue($Page->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <td data-name="Kode_MK"<?= $Page->Kode_MK->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue ?? $Page->Kode_MK->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td data-name="Nilai_Diskusi"<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Diskusi" id="o<?= $Page->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Page->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td data-name="Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Page->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td data-name="Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Page->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td data-name="Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Page->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td data-name="Nilai_Tugas"<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Tugas" id="o<?= $Page->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Page->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td data-name="Nilai_UTS"<?= $Page->Nilai_UTS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_UTS" id="o<?= $Page->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Page->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td data-name="Nilai_Akhir"<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Akhir" id="o<?= $Page->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Page->Nilai_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script<?= Nonce() ?> data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

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
<table id="tbl_detil_mata_kuliahlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_no->Visible) { // id_no ?>
        <th data-name="id_no" class="<?= $Page->id_no->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Page->renderFieldHeader($Page->id_no) ?></div></th>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <th data-name="Kode_MK" class="<?= $Page->Kode_MK->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Page->renderFieldHeader($Page->Kode_MK) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th data-name="Nilai_Diskusi" class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Page->renderFieldHeader($Page->Nilai_Diskusi) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th data-name="Assessment_Skor_As_1" class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_1) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th data-name="Assessment_Skor_As_2" class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_2) ?></div></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th data-name="Assessment_Skor_As_3" class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Page->renderFieldHeader($Page->Assessment_Skor_As_3) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th data-name="Nilai_Tugas" class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Page->renderFieldHeader($Page->Nilai_Tugas) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th data-name="Nilai_UTS" class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Page->renderFieldHeader($Page->Nilai_UTS) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th data-name="Nilai_Akhir" class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Page->renderFieldHeader($Page->Nilai_Akhir) ?></div></th>
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
    <?php if ($Page->id_no->Visible) { // id_no ?>
        <td data-name="id_no"<?= $Page->id_no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_no" id="o<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_no->getDisplayValue($Page->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_no" id="x<?= $Page->RowIndex ?>_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <td data-name="Kode_MK"<?= $Page->Kode_MK->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_Kode_MK" name="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kode_MK" id="o<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue ?? $Page->Kode_MK->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="x<?= $Page->RowIndex ?>_Kode_MK" id="x<?= $Page->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td data-name="Nilai_Diskusi"<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Diskusi" id="o<?= $Page->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Page->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Diskusi" id="x<?= $Page->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td data-name="Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Page->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td data-name="Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Page->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td data-name="Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="o<?= $Page->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Page->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Page->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td data-name="Nilai_Tugas"<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Tugas" id="o<?= $Page->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Page->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Tugas" id="x<?= $Page->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td data-name="Nilai_UTS"<?= $Page->Nilai_UTS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_UTS" id="o<?= $Page->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Page->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_UTS" id="x<?= $Page->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td data-name="Nilai_Akhir"<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai_Akhir" id="o<?= $Page->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Page->Nilai_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai_Akhir" id="x<?= $Page->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
</span>
<?php } ?>
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
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->getFormKeyCountName() ?>" id="<?= $Page->getFormKeyCountName() ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormKeyCountName() ?>" id="<?= $Page->getFormKeyCountName() ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_mata_kuliahupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_mata_kuliahdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_mata_kuliahlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_mata_kuliahlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_mata_kuliahlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="detil_mata_kuliah"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'detil_mata_kuliahlist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$detil_mata_kuliah->isExport()) { ?>
<script>
loadjs.ready("jscookie", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle');
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			ew.Cookies.set(ew.PROJECT_NAME + "_detil_mata_kuliah_searchpanel", "notactive", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} else { 
			ew.Cookies.set(ew.PROJECT_NAME + "_detil_mata_kuliah_searchpanel", "active", {
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
    ew.addEventHandlers("detil_mata_kuliah");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
