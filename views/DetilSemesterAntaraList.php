<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilSemesterAntaraList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_semester_antara: currentTable } });
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
            ["id_smtsr", [fields.id_smtsr.visible && fields.id_smtsr.required ? ew.Validators.required(fields.id_smtsr.caption) : null], fields.id_smtsr.isInvalid],
            ["no", [fields.no.visible && fields.no.required ? ew.Validators.required(fields.no.caption) : null], fields.no.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["KRS", [fields.KRS.visible && fields.KRS.required ? ew.Validators.required(fields.KRS.caption) : null], fields.KRS.isInvalid],
            ["Bukti_SPP", [fields.Bukti_SPP.visible && fields.Bukti_SPP.required ? ew.Validators.fileRequired(fields.Bukti_SPP.caption) : null], fields.Bukti_SPP.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["id_smtsr",false],["NIM",false],["KRS",false],["Bukti_SPP",false]];
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
            "NIM": <?= $Page->NIM->toClientList($Page) ?>,
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "semester_antara") {
    if ($Page->MasterRecordExists) {
        include_once "views/SemesterAntaraMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fdetil_semester_antarasrch" id="fdetil_semester_antarasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fdetil_semester_antarasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_semester_antara: currentTable } });
var currentForm;
var fdetil_semester_antarasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdetil_semester_antarasrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdetil_semester_antarasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdetil_semester_antarasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdetil_semester_antarasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdetil_semester_antarasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="detil_semester_antara">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "semester_antara" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="semester_antara">
<input type="hidden" name="fk_id_smtr" value="<?= HtmlEncode($Page->id_smtsr->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detil_semester_antara" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detil_semester_antaralist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <th data-name="id_smtsr" class="<?= $Page->id_smtsr->headerCellClass() ?>"><div id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Page->renderFieldHeader($Page->id_smtsr) ?></div></th>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <th data-name="KRS" class="<?= $Page->KRS->headerCellClass() ?>"><div id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Page->renderFieldHeader($Page->KRS) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th data-name="Bukti_SPP" class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><div id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Page->renderFieldHeader($Page->Bukti_SPP) ?></div></th>
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
    <?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <td data-name="id_smtsr"<?= $Page->id_smtsr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue ?? $Page->id_smtsr->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->KRS->Visible) { // KRS ?>
        <td data-name="KRS"<?= $Page->KRS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_KRS" id="o<?= $Page->RowIndex ?>_KRS" value="<?= HtmlEncode($Page->KRS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td data-name="Bukti_SPP"<?= $Page->Bukti_SPP->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_Bukti_SPP" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Bukti_SPP" id="o<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= HtmlEncode($Page->Bukti_SPP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
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
<table id="tbl_detil_semester_antaralist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <th data-name="id_smtsr" class="<?= $Page->id_smtsr->headerCellClass() ?>"><div id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Page->renderFieldHeader($Page->id_smtsr) ?></div></th>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <th data-name="KRS" class="<?= $Page->KRS->headerCellClass() ?>"><div id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Page->renderFieldHeader($Page->KRS) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th data-name="Bukti_SPP" class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><div id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Page->renderFieldHeader($Page->Bukti_SPP) ?></div></th>
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
    <?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <td data-name="id_smtsr"<?= $Page->id_smtsr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue ?? $Page->id_smtsr->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->KRS->Visible) { // KRS ?>
        <td data-name="KRS"<?= $Page->KRS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_KRS" id="o<?= $Page->RowIndex ?>_KRS" value="<?= HtmlEncode($Page->KRS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td data-name="Bukti_SPP"<?= $Page->Bukti_SPP->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_Bukti_SPP" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Bukti_SPP" id="o<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= HtmlEncode($Page->Bukti_SPP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
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
<input type="hidden" name="t" value="detil_semester_antara">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "semester_antara" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="semester_antara">
<input type="hidden" name="fk_id_smtr" value="<?= HtmlEncode($Page->id_smtsr->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_detil_semester_antara" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_detil_semester_antaralist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <th data-name="id_smtsr" class="<?= $Page->id_smtsr->headerCellClass() ?>"><div id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Page->renderFieldHeader($Page->id_smtsr) ?></div></th>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <th data-name="KRS" class="<?= $Page->KRS->headerCellClass() ?>"><div id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Page->renderFieldHeader($Page->KRS) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th data-name="Bukti_SPP" class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><div id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Page->renderFieldHeader($Page->Bukti_SPP) ?></div></th>
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
    <?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <td data-name="id_smtsr"<?= $Page->id_smtsr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue ?? $Page->id_smtsr->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->KRS->Visible) { // KRS ?>
        <td data-name="KRS"<?= $Page->KRS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_KRS" id="o<?= $Page->RowIndex ?>_KRS" value="<?= HtmlEncode($Page->KRS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td data-name="Bukti_SPP"<?= $Page->Bukti_SPP->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_Bukti_SPP" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Bukti_SPP" id="o<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= HtmlEncode($Page->Bukti_SPP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
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
<table id="tbl_detil_semester_antaralist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <th data-name="id_smtsr" class="<?= $Page->id_smtsr->headerCellClass() ?>"><div id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Page->renderFieldHeader($Page->id_smtsr) ?></div></th>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Page->no->headerCellClass() ?>"><div id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Page->renderFieldHeader($Page->no) ?></div></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Page->NIM->headerCellClass() ?>"><div id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Page->renderFieldHeader($Page->NIM) ?></div></th>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <th data-name="KRS" class="<?= $Page->KRS->headerCellClass() ?>"><div id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Page->renderFieldHeader($Page->KRS) ?></div></th>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th data-name="Bukti_SPP" class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><div id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Page->renderFieldHeader($Page->Bukti_SPP) ?></div></th>
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
    <?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <td data-name="id_smtsr"<?= $Page->id_smtsr->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_id_smtsr" name="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_smtsr" id="o<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->OldValue ?? $Page->id_smtsr->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_smtsr" id="x<?= $Page->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->no->Visible) { // no ?>
        <td data-name="no"<?= $Page->no->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_no" id="o<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Page->RowIndex ?>_no" id="x<?= $Page->RowIndex ?>_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_NIM" id="o<?= $Page->RowIndex ?>_NIM" value="<?= HtmlEncode($Page->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Page->RowIndex ?>_NIM"
        name="x<?= $Page->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x{$Page->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_NIM", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_NIM", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->KRS->Visible) { // KRS ?>
        <td data-name="KRS"<?= $Page->KRS->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_KRS" id="o<?= $Page->RowIndex ?>_KRS" value="<?= HtmlEncode($Page->KRS->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_KRS" id="x<?= $Page->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td data-name="Bukti_SPP"<?= $Page->Bukti_SPP->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_Bukti_SPP" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Bukti_SPP" id="o<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= HtmlEncode($Page->Bukti_SPP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Page->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_Bukti_SPP"
        name="x<?= $Page->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Page->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_semester_antaraadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_semester_antaraadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_semester_antaraedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_semester_antaraedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_semester_antaraupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_semester_antaraupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_semester_antaradelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_semester_antaradelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_semester_antaralist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_semester_antaralist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_semester_antaralist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="detil_semester_antara"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'detil_semester_antaralist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$detil_semester_antara->isExport()) { ?>
<script>
loadjs.ready("jscookie", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle');
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			ew.Cookies.set(ew.PROJECT_NAME + "_detil_semester_antara_searchpanel", "notactive", {
			  sameSite: ew.COOKIE_SAMESITE,
			  secure: ew.COOKIE_SECURE
			}); 
		} else { 
			ew.Cookies.set(ew.PROJECT_NAME + "_detil_semester_antara_searchpanel", "active", {
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
    ew.addEventHandlers("detil_semester_antara");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
