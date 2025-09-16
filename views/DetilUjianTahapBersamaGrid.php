<?php

namespace PHPMaker2025\pssk2025;

// Set up and run Grid object
$Grid = Container("DetilUjianTahapBersamaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script<?= Nonce() ?>>
var fdetil_ujian_tahap_bersamagrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= json_encode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { detil_ujian_tahap_bersama: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_ujian_tahap_bersamagrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->getFormKeyCountName() ?>")

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
<div id="fdetil_ujian_tahap_bersamagrid" class="ew-form ew-list-form">
<div id="gmp_detil_ujian_tahap_bersama" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detil_ujian_tahap_bersamagrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Grid->no->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_no" class="detil_ujian_tahap_bersama_no"><?= $Grid->renderFieldHeader($Grid->no) ?></div></th>
<?php } ?>
<?php if ($Grid->id_utb->Visible) { // id_utb ?>
        <th data-name="id_utb" class="<?= $Grid->id_utb->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_id_utb" class="detil_ujian_tahap_bersama_id_utb"><?= $Grid->renderFieldHeader($Grid->id_utb) ?></div></th>
<?php } ?>
<?php if ($Grid->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Grid->NIM->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_NIM" class="detil_ujian_tahap_bersama_NIM"><?= $Grid->renderFieldHeader($Grid->NIM) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai->Visible) { // Nilai ?>
        <th data-name="Nilai" class="<?= $Grid->Nilai->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_Nilai" class="detil_ujian_tahap_bersama_Nilai"><?= $Grid->renderFieldHeader($Grid->Nilai) ?></div></th>
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
    <?php if ($Grid->no->Visible) { // no ?>
        <td data-name="no"<?= $Grid->no->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_no" id="o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Grid->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->no->getDisplayValue($Grid->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Grid->no->viewAttributes() ?>>
<?= $Grid->no->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_no" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_no" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->id_utb->Visible) { // id_utb ?>
        <td data-name="id_utb"<?= $Grid->id_utb->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Grid->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_utb->getDisplayValue($Grid->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_utb" name="x<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Grid->id_utb->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_utb" id="x<?= $Grid->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Grid->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_utb->formatPattern()) ?>"<?= $Grid->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_utb" id="o<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Grid->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_utb->getDisplayValue($Grid->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_utb" name="x<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Grid->id_utb->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_utb" id="x<?= $Grid->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Grid->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_utb->formatPattern()) ?>"<?= $Grid->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Grid->id_utb->viewAttributes() ?>>
<?= $Grid->id_utb->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_id_utb" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_id_utb" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Grid->NIM->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_NIM" id="o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<span<?= $Grid->NIM->viewAttributes() ?>>
<?= $Grid->NIM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_NIM" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_NIM" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai->Visible) { // Nilai ?>
        <td data-name="Nilai"<?= $Grid->Nilai->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Grid->Nilai->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai" id="x<?= $Grid->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Grid->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai->formatPattern()) ?>"<?= $Grid->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai" id="o<?= $Grid->RowIndex ?>_Nilai" value="<?= HtmlEncode($Grid->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Grid->Nilai->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai" id="x<?= $Grid->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Grid->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai->formatPattern()) ?>"<?= $Grid->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<span<?= $Grid->Nilai->viewAttributes() ?>>
<?= $Grid->Nilai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_Nilai" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_Nilai" value="<?= HtmlEncode($Grid->Nilai->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_Nilai" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_Nilai" value="<?= HtmlEncode($Grid->Nilai->OldValue) ?>">
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
loadjs.ready(["fdetil_ujian_tahap_bersamagrid","load"], () => fdetil_ujian_tahap_bersamagrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdetil_ujian_tahap_bersamagrid">
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
<div id="fdetil_ujian_tahap_bersamagrid" class="ew-form ew-list-form">
<div id="gmp_detil_ujian_tahap_bersama" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detil_ujian_tahap_bersamagrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->no->Visible) { // no ?>
        <th data-name="no" class="<?= $Grid->no->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_no" class="detil_ujian_tahap_bersama_no"><?= $Grid->renderFieldHeader($Grid->no) ?></div></th>
<?php } ?>
<?php if ($Grid->id_utb->Visible) { // id_utb ?>
        <th data-name="id_utb" class="<?= $Grid->id_utb->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_id_utb" class="detil_ujian_tahap_bersama_id_utb"><?= $Grid->renderFieldHeader($Grid->id_utb) ?></div></th>
<?php } ?>
<?php if ($Grid->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Grid->NIM->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_NIM" class="detil_ujian_tahap_bersama_NIM"><?= $Grid->renderFieldHeader($Grid->NIM) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai->Visible) { // Nilai ?>
        <th data-name="Nilai" class="<?= $Grid->Nilai->headerCellClass() ?>"><div id="elh_detil_ujian_tahap_bersama_Nilai" class="detil_ujian_tahap_bersama_Nilai"><?= $Grid->renderFieldHeader($Grid->Nilai) ?></div></th>
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
    <?php if ($Grid->no->Visible) { // no ?>
        <td data-name="no"<?= $Grid->no->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_no" id="o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Grid->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->no->getDisplayValue($Grid->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_no" class="el_detil_ujian_tahap_bersama_no">
<span<?= $Grid->no->viewAttributes() ?>>
<?= $Grid->no->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_no" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_no" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no" id="x<?= $Grid->RowIndex ?>_no" value="<?= HtmlEncode($Grid->no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->id_utb->Visible) { // id_utb ?>
        <td data-name="id_utb"<?= $Grid->id_utb->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Grid->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_utb->getDisplayValue($Grid->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_utb" name="x<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Grid->id_utb->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_utb" id="x<?= $Grid->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Grid->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_utb->formatPattern()) ?>"<?= $Grid->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_utb" id="o<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->id_utb->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Grid->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_utb->getDisplayValue($Grid->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_utb" name="x<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Grid->id_utb->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_id_utb" id="x<?= $Grid->RowIndex ?>_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Grid->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->id_utb->formatPattern()) ?>"<?= $Grid->id_utb->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_id_utb" class="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Grid->id_utb->viewAttributes() ?>>
<?= $Grid->id_utb->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_id_utb" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_id_utb" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_id_utb" value="<?= HtmlEncode($Grid->id_utb->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Grid->NIM->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_NIM" id="o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_NIM" class="el_detil_ujian_tahap_bersama_NIM">
<span<?= $Grid->NIM->viewAttributes() ?>>
<?= $Grid->NIM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_NIM" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_NIM" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai->Visible) { // Nilai ?>
        <td data-name="Nilai"<?= $Grid->Nilai->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Grid->Nilai->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai" id="x<?= $Grid->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Grid->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai->formatPattern()) ?>"<?= $Grid->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai" id="o<?= $Grid->RowIndex ?>_Nilai" value="<?= HtmlEncode($Grid->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Grid->Nilai->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai" id="x<?= $Grid->RowIndex ?>_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Grid->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai->formatPattern()) ?>"<?= $Grid->Nilai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_ujian_tahap_bersama_Nilai" class="el_detil_ujian_tahap_bersama_Nilai">
<span<?= $Grid->Nilai->viewAttributes() ?>>
<?= $Grid->Nilai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" name="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_Nilai" id="fdetil_ujian_tahap_bersamagrid$x<?= $Grid->RowIndex ?>_Nilai" value="<?= HtmlEncode($Grid->Nilai->FormValue) ?>">
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" data-hidden="1" data-old name="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_Nilai" id="fdetil_ujian_tahap_bersamagrid$o<?= $Grid->RowIndex ?>_Nilai" value="<?= HtmlEncode($Grid->Nilai->OldValue) ?>">
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
loadjs.ready(["fdetil_ujian_tahap_bersamagrid","load"], () => fdetil_ujian_tahap_bersamagrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdetil_ujian_tahap_bersamagrid">
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
    ew.addEventHandlers("detil_ujian_tahap_bersama");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
