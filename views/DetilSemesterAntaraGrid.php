<?php

namespace PHPMaker2025\pssk2025;

// Set up and run Grid object
$Grid = Container("DetilSemesterAntaraGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script<?= Nonce() ?>>
var fdetil_semester_antaragrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= json_encode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { detil_semester_antara: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_semester_antaragrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->getFormKeyCountName() ?>")

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
            "NIM": <?= $Grid->NIM->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<main class="list">
<?php } else { ?>
<main class="list">
<?php } ?>
<div id="ew-header-options">
<?php $Grid->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if (!$Grid->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if ($Grid->CurrentMode == "view" && $Grid->DetailViewPaging) { ?>
<?= $Grid->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<div id="fdetil_semester_antaragrid" class="ew-form ew-list-form">
<div id="gmp_detil_semester_antara" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detil_semester_antaragrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id_smtsr->Visible) { // id_smtsr ?>
        <th data-name="id_smtsr" class="<?= $Grid->id_smtsr->headerCellClass() ?>"><div id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Grid->renderFieldHeader($Grid->id_smtsr) ?></div></th>
<?php } ?>
<?php if ($Grid->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Grid->no->headerCellClass() ?>"><div id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Grid->renderFieldHeader($Grid->no) ?></div></th>
<?php } ?>
<?php if ($Grid->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Grid->NIM->headerCellClass() ?>"><div id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Grid->renderFieldHeader($Grid->NIM) ?></div></th>
<?php } ?>
<?php if ($Grid->KRS->Visible) { // KRS ?>
        <th data-name="KRS" class="<?= $Grid->KRS->headerCellClass() ?>"><div id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Grid->renderFieldHeader($Grid->KRS) ?></div></th>
<?php } ?>
<?php if ($Grid->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th data-name="Bukti_SPP" class="<?= $Grid->Bukti_SPP->headerCellClass() ?>"><div id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Grid->renderFieldHeader($Grid->Bukti_SPP) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
$isInlineAddOrCopy = ($Grid->isCopy() || $Grid->isAdd());
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Grid->RowIndex == 0) {
    if (
        $Grid->CurrentRow !== false
        && $Grid->RowIndex !== '$rowindex$'
        && (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        && (!($isInlineAddOrCopy && $Grid->RowIndex == 0))
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete"
            && $Grid->RowAction != "insertdelete"
            && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())
            && $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id_smtsr->Visible) { // id_smtsr ?>
        <td data-name="id_smtsr"<?= $Grid->id_smtsr->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->id_smtsr->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Grid->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_smtsr->getDisplayValue($Grid->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_smtsr" name="x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<input type="<?= $Grid->id_smtsr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_smtsr" id="x<?= $Grid->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Grid->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_smtsr->formatPattern()) ?>"<?= $Grid->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_smtsr" id="o<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<?php if ($Grid->id_smtsr->getSessionValue() != "") { ?>
<span<?= $Grid->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_smtsr->getDisplayValue($Grid->id_smtsr->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_smtsr" name="x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Grid->id_smtsr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_smtsr" id="x<?= $Grid->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Grid->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_smtsr->formatPattern()) ?>"<?= $Grid->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_smtsr->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_smtsr" id="o<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->OldValue ?? $Grid->id_smtsr->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Grid->id_smtsr->viewAttributes() ?>>
<?= $Grid->id_smtsr->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_id_smtsr" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_id_smtsr" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_smtsr" id="x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->no->Visible) { // no ?>
        <td data-name="no"<?= $Grid->no->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_no" id="o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Grid->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->no->getDisplayValue($Grid->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Grid->no->viewAttributes() ?>>
<?= $Grid->no->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_no" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_no" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Grid->NIM->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Grid->RowIndex ?>_NIM"
        name="x<?= $Grid->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Grid->NIM->isInvalidClass() ?>"
        <?php if (!$Grid->NIM->IsNativeSelect) { ?>
        data-select2-id="fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Grid->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>"
        <?= $Grid->NIM->editAttributes() ?>>
        <?= $Grid->NIM->selectOptionListHtml("x{$Grid->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
<?= $Grid->NIM->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NIM") ?>
<?php if (!$Grid->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("fdetil_semester_antaragrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_NIM", selectId: "fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdetil_semester_antaragrid.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_NIM" id="o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Grid->RowIndex ?>_NIM"
        name="x<?= $Grid->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Grid->NIM->isInvalidClass() ?>"
        <?php if (!$Grid->NIM->IsNativeSelect) { ?>
        data-select2-id="fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Grid->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>"
        <?= $Grid->NIM->editAttributes() ?>>
        <?= $Grid->NIM->selectOptionListHtml("x{$Grid->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
<?= $Grid->NIM->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NIM") ?>
<?php if (!$Grid->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("fdetil_semester_antaragrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_NIM", selectId: "fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdetil_semester_antaragrid.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
<span<?= $Grid->NIM->viewAttributes() ?>>
<?= $Grid->NIM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_NIM" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_NIM" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KRS->Visible) { // KRS ?>
        <td data-name="KRS"<?= $Grid->KRS->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Grid->KRS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_KRS" id="x<?= $Grid->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Grid->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->KRS->formatPattern()) ?>"<?= $Grid->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KRS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_KRS" id="o<?= $Grid->RowIndex ?>_KRS" value="<?= HtmlEncode($Grid->KRS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Grid->KRS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_KRS" id="x<?= $Grid->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Grid->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->KRS->formatPattern()) ?>"<?= $Grid->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KRS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<span<?= $Grid->KRS->viewAttributes() ?>>
<?= $Grid->KRS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_KRS" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_KRS" value="<?= HtmlEncode($Grid->KRS->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_KRS" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_KRS" value="<?= HtmlEncode($Grid->KRS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td data-name="Bukti_SPP"<?= $Grid->Bukti_SPP->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->Bukti_SPP->ReadOnly || $Grid->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_Bukti_SPP" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Bukti_SPP" id="o<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= HtmlEncode($Grid->Bukti_SPP->OldValue) ?>">
<?php } elseif ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<span<?= $Grid->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Grid->Bukti_SPP, $Grid->Bukti_SPP->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->Bukti_SPP->ReadOnly || $Grid->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script<?= Nonce() ?> data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fdetil_semester_antaragrid","load"], () => fdetil_semester_antaragrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->getFormKeyCountName() ?>" id="<?= $Grid->getFormKeyCountName() ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->getFormKeyCountName() ?>" id="<?= $Grid->getFormKeyCountName() ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetil_semester_antaragrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Result?->free();
?>
<?php if (!$Grid->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if ($Grid->CurrentMode == "view" && $Grid->DetailViewPaging) { ?>
<?= $Grid->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<?php // Begin of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if (!$Grid->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if ($Grid->CurrentMode == "view" && $Grid->DetailViewPaging) { ?>
<?= $Grid->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<div id="fdetil_semester_antaragrid" class="ew-form ew-list-form">
<div id="gmp_detil_semester_antara" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detil_semester_antaragrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id_smtsr->Visible) { // id_smtsr ?>
        <th data-name="id_smtsr" class="<?= $Grid->id_smtsr->headerCellClass() ?>"><div id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Grid->renderFieldHeader($Grid->id_smtsr) ?></div></th>
<?php } ?>
<?php if ($Grid->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Grid->no->headerCellClass() ?>"><div id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Grid->renderFieldHeader($Grid->no) ?></div></th>
<?php } ?>
<?php if ($Grid->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Grid->NIM->headerCellClass() ?>"><div id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Grid->renderFieldHeader($Grid->NIM) ?></div></th>
<?php } ?>
<?php if ($Grid->KRS->Visible) { // KRS ?>
        <th data-name="KRS" class="<?= $Grid->KRS->headerCellClass() ?>"><div id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Grid->renderFieldHeader($Grid->KRS) ?></div></th>
<?php } ?>
<?php if ($Grid->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th data-name="Bukti_SPP" class="<?= $Grid->Bukti_SPP->headerCellClass() ?>"><div id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Grid->renderFieldHeader($Grid->Bukti_SPP) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
$isInlineAddOrCopy = ($Grid->isCopy() || $Grid->isAdd());
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Grid->RowIndex == 0) {
    if (
        $Grid->CurrentRow !== false
        && $Grid->RowIndex !== '$rowindex$'
        && (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        && (!($isInlineAddOrCopy && $Grid->RowIndex == 0))
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete"
            && $Grid->RowAction != "insertdelete"
            && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())
            && $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id_smtsr->Visible) { // id_smtsr ?>
        <td data-name="id_smtsr"<?= $Grid->id_smtsr->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->id_smtsr->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Grid->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_smtsr->getDisplayValue($Grid->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_smtsr" name="x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<input type="<?= $Grid->id_smtsr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_smtsr" id="x<?= $Grid->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Grid->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_smtsr->formatPattern()) ?>"<?= $Grid->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_smtsr" id="o<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<?php if ($Grid->id_smtsr->getSessionValue() != "") { ?>
<span<?= $Grid->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_smtsr->getDisplayValue($Grid->id_smtsr->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_smtsr" name="x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Grid->id_smtsr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_smtsr" id="x<?= $Grid->RowIndex ?>_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Grid->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_smtsr->formatPattern()) ?>"<?= $Grid->id_smtsr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_smtsr->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_smtsr" id="o<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->OldValue ?? $Grid->id_smtsr->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_id_smtsr" class="el_detil_semester_antara_id_smtsr">
<span<?= $Grid->id_smtsr->viewAttributes() ?>>
<?= $Grid->id_smtsr->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_id_smtsr" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_id_smtsr" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_id_smtsr" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_smtsr" id="x<?= $Grid->RowIndex ?>_id_smtsr" value="<?= HtmlEncode($Grid->id_smtsr->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->no->Visible) { // no ?>
        <td data-name="no"<?= $Grid->no->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_no" id="o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Grid->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->no->getDisplayValue($Grid->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_no" class="el_detil_semester_antara_no">
<span<?= $Grid->no->viewAttributes() ?>>
<?= $Grid->no->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_no" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_no" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_semester_antara" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Grid->NIM->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Grid->RowIndex ?>_NIM"
        name="x<?= $Grid->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Grid->NIM->isInvalidClass() ?>"
        <?php if (!$Grid->NIM->IsNativeSelect) { ?>
        data-select2-id="fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Grid->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>"
        <?= $Grid->NIM->editAttributes() ?>>
        <?= $Grid->NIM->selectOptionListHtml("x{$Grid->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
<?= $Grid->NIM->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NIM") ?>
<?php if (!$Grid->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("fdetil_semester_antaragrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_NIM", selectId: "fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdetil_semester_antaragrid.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_NIM" id="o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
    <select
        id="x<?= $Grid->RowIndex ?>_NIM"
        name="x<?= $Grid->RowIndex ?>_NIM"
        class="form-select ew-select<?= $Grid->NIM->isInvalidClass() ?>"
        <?php if (!$Grid->NIM->IsNativeSelect) { ?>
        data-select2-id="fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Grid->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>"
        <?= $Grid->NIM->editAttributes() ?>>
        <?= $Grid->NIM->selectOptionListHtml("x{$Grid->RowIndex}_NIM") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
<?= $Grid->NIM->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NIM") ?>
<?php if (!$Grid->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("fdetil_semester_antaragrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_NIM", selectId: "fdetil_semester_antaragrid_x<?= $Grid->RowIndex ?>_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdetil_semester_antaragrid.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_NIM", form: "fdetil_semester_antaragrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_NIM" class="el_detil_semester_antara_NIM">
<span<?= $Grid->NIM->viewAttributes() ?>>
<?= $Grid->NIM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_NIM" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_NIM" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_NIM" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KRS->Visible) { // KRS ?>
        <td data-name="KRS"<?= $Grid->KRS->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Grid->KRS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_KRS" id="x<?= $Grid->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Grid->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->KRS->formatPattern()) ?>"<?= $Grid->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KRS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_KRS" id="o<?= $Grid->RowIndex ?>_KRS" value="<?= HtmlEncode($Grid->KRS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<input type="<?= $Grid->KRS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_KRS" id="x<?= $Grid->RowIndex ?>_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Grid->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->KRS->formatPattern()) ?>"<?= $Grid->KRS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KRS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_KRS" class="el_detil_semester_antara_KRS">
<span<?= $Grid->KRS->viewAttributes() ?>>
<?= $Grid->KRS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" name="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_KRS" id="fdetil_semester_antaragrid$x<?= $Grid->RowIndex ?>_KRS" value="<?= HtmlEncode($Grid->KRS->FormValue) ?>">
<input type="hidden" data-table="detil_semester_antara" data-field="x_KRS" data-hidden="1" data-old name="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_KRS" id="fdetil_semester_antaragrid$o<?= $Grid->RowIndex ?>_KRS" value="<?= HtmlEncode($Grid->KRS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td data-name="Bukti_SPP"<?= $Grid->Bukti_SPP->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->Bukti_SPP->ReadOnly || $Grid->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="detil_semester_antara" data-field="x_Bukti_SPP" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Bukti_SPP" id="o<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= HtmlEncode($Grid->Bukti_SPP->OldValue) ?>">
<?php } elseif ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<span<?= $Grid->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Grid->Bukti_SPP, $Grid->Bukti_SPP->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->Bukti_SPP->ReadOnly || $Grid->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_semester_antara_Bukti_SPP" class="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x<?= $Grid->RowIndex ?>_Bukti_SPP">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        name="x<?= $Grid->RowIndex ?>_Bukti_SPP"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Grid->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->Bukti_SPP->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fn_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= $Grid->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" id= "fa_x<?= $Grid->RowIndex ?>_Bukti_SPP" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_Bukti_SPP") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script<?= Nonce() ?> data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fdetil_semester_antaragrid","load"], () => fdetil_semester_antaragrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->getFormKeyCountName() ?>" id="<?= $Grid->getFormKeyCountName() ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->getFormKeyCountName() ?>" id="<?= $Grid->getFormKeyCountName() ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetil_semester_antaragrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Result?->free();
?>
<?php if (!$Grid->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if ($Grid->CurrentMode == "view" && $Grid->DetailViewPaging) { ?>
<?= $Grid->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } // end of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Grid->FooterOptions?->render("body") ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
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
