<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilUjianTahapBersamaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_ujian_tahap_bersama: currentTable } });
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
            ["no", [fields.no.visible && fields.no.required ? ew.Validators.required(fields.no.caption) : null], fields.no.isInvalid],
            ["id_utb", [fields.id_utb.visible && fields.id_utb.required ? ew.Validators.required(fields.id_utb.caption) : null], fields.id_utb.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Nilai", [fields.Nilai.visible && fields.Nilai.required ? ew.Validators.required(fields.Nilai.caption) : null], fields.Nilai.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["id_utb",false],["NIM",false],["Nilai",false]];
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "ujian_tahap_bersama") {
    if ($Page->MasterRecordExists) {
        include_once "views/UjianTahapBersamaMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fdetil_ujian_tahap_bersamasrch" id="fdetil_ujian_tahap_bersamasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fdetil_ujian_tahap_bersamasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_ujian_tahap_bersama: currentTable } });
var currentForm;
var fdetil_ujian_tahap_bersamasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdetil_ujian_tahap_bersamasrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdetil_ujian_tahap_bersamasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdetil_ujian_tahap_bersamasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdetil_ujian_tahap_bersamasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdetil_ujian_tahap_bersamasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="detil_ujian_tahap_bersama">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "ujian_tahap_bersama" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="ujian_tahap_bersama">
<input type="hidden" name="fk_id_utb" value="<?= HtmlEncode($Page->id_utb->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detil_ujian_tahap_bersama" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detil_ujian_tahap_bersamalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_no" class="detil_ujian_tahap_bersama_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
        <th data-name="id_utb" class="<?= $Page->id_utb->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_id_utb" class="detil_ujian_tahap_bersama_id_utb"><?= $Page->renderFieldHeader($Page->id_utb) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_NIM" class="detil_ujian_tahap_bersama_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
        <th data-name="Nilai" class="<?= $Page->Nilai->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_Nilai" class="detil_ujian_tahap_bersama_Nilai"><?= $Page->renderFieldHeader($Page->Nilai) ?></div></th>
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
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->id_utb->Visible) { // id_utb ?>
        <td data-name="id_utb"<?= $Page->id_utb->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_utb" id="o<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<?= $Page->id_utb->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai->Visible) { // Nilai ?>
        <td data-name="Nilai"<?= $Page->Nilai->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai" id="o<?= $Page->RowIndex ?>_Nilai" value="<?= HtmlEncode($Page->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<span<?= $Page->Nilai->viewAttributes() ?>>
<?= $Page->Nilai->getViewValue() ?></span>
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
<table id="tbl_detil_ujian_tahap_bersamalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_no" class="detil_ujian_tahap_bersama_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
        <th data-name="id_utb" class="<?= $Page->id_utb->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_id_utb" class="detil_ujian_tahap_bersama_id_utb"><?= $Page->renderFieldHeader($Page->id_utb) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_NIM" class="detil_ujian_tahap_bersama_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
        <th data-name="Nilai" class="<?= $Page->Nilai->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_Nilai" class="detil_ujian_tahap_bersama_Nilai"><?= $Page->renderFieldHeader($Page->Nilai) ?></div></th>
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
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->id_utb->Visible) { // id_utb ?>
        <td data-name="id_utb"<?= $Page->id_utb->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_utb" id="o<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<?= $Page->id_utb->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai->Visible) { // Nilai ?>
        <td data-name="Nilai"<?= $Page->Nilai->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai" id="o<?= $Page->RowIndex ?>_Nilai" value="<?= HtmlEncode($Page->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<span<?= $Page->Nilai->viewAttributes() ?>>
<?= $Page->Nilai->getViewValue() ?></span>
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
<input type="hidden" name="t" value="detil_ujian_tahap_bersama">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "ujian_tahap_bersama" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="ujian_tahap_bersama">
<input type="hidden" name="fk_id_utb" value="<?= HtmlEncode($Page->id_utb->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detil_ujian_tahap_bersama" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detil_ujian_tahap_bersamalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_no" class="detil_ujian_tahap_bersama_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
        <th data-name="id_utb" class="<?= $Page->id_utb->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_id_utb" class="detil_ujian_tahap_bersama_id_utb"><?= $Page->renderFieldHeader($Page->id_utb) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_NIM" class="detil_ujian_tahap_bersama_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
        <th data-name="Nilai" class="<?= $Page->Nilai->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_Nilai" class="detil_ujian_tahap_bersama_Nilai"><?= $Page->renderFieldHeader($Page->Nilai) ?></div></th>
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
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->id_utb->Visible) { // id_utb ?>
        <td data-name="id_utb"<?= $Page->id_utb->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_utb" id="o<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<?= $Page->id_utb->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai->Visible) { // Nilai ?>
        <td data-name="Nilai"<?= $Page->Nilai->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai" id="o<?= $Page->RowIndex ?>_Nilai" value="<?= HtmlEncode($Page->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<span<?= $Page->Nilai->viewAttributes() ?>>
<?= $Page->Nilai->getViewValue() ?></span>
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
<table id="tbl_detil_ujian_tahap_bersamalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_no" class="detil_ujian_tahap_bersama_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
        <th data-name="id_utb" class="<?= $Page->id_utb->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_id_utb" class="detil_ujian_tahap_bersama_id_utb"><?= $Page->renderFieldHeader($Page->id_utb) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_NIM" class="detil_ujian_tahap_bersama_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
        <th data-name="Nilai" class="<?= $Page->Nilai->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_Nilai" class="detil_ujian_tahap_bersama_Nilai"><?= $Page->renderFieldHeader($Page->Nilai) ?></div></th>
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
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->id_utb->Visible) { // id_utb ?>
        <td data-name="id_utb"<?= $Page->id_utb->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_utb" id="o<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_utb" name="x<?= $Page->RowIndex ?>_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_utb" id="x<?= $Page->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<?= $Page->id_utb->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_NIM" id="x<?= $Page->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Nilai->Visible) { // Nilai ?>
        <td data-name="Nilai"<?= $Page->Nilai->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Nilai" id="o<?= $Page->RowIndex ?>_Nilai" value="<?= HtmlEncode($Page->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Nilai" id="x<?= $Page->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<span<?= $Page->Nilai->viewAttributes() ?>>
<?= $Page->Nilai->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_ujian_tahap_bersamaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_ujian_tahap_bersamaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamaupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_ujian_tahap_bersamaupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamadelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_ujian_tahap_bersamadelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_ujian_tahap_bersamalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_ujian_tahap_bersamalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_ujian_tahap_bersamalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="detil_ujian_tahap_bersama"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'detil_ujian_tahap_bersamalist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$detil_ujian_tahap_bersama->isExport()) { ?>
<script>
loadjs.ready("jscookie", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle');
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			ew.Cookies.set(ew.PROJECT_NAME + "_detil_ujian_tahap_bersama_searchpanel", "notactive", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} else { 
			ew.Cookies.set(ew.PROJECT_NAME + "_detil_ujian_tahap_bersama_searchpanel", "active", {
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
    ew.addEventHandlers("detil_ujian_tahap_bersama");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
