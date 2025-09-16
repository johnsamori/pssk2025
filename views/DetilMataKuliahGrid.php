<?php

namespace PHPMaker2025\pssk2025;

// Set up and run Grid object
$Grid = Container("DetilMataKuliahGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script<?= Nonce() ?>>
var fdetil_mata_kuliahgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= json_encode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_mata_kuliahgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->getFormKeyCountName() ?>")

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
<div id="fdetil_mata_kuliahgrid" class="ew-form ew-list-form">
<div id="gmp_detil_mata_kuliah" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detil_mata_kuliahgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->id_no->Visible) { // id_no ?>
        <th data-name="id_no" class="<?= $Grid->id_no->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Grid->renderFieldHeader($Grid->id_no) ?></div></th>
<?php } ?>
<?php if ($Grid->Kode_MK->Visible) { // Kode_MK ?>
        <th data-name="Kode_MK" class="<?= $Grid->Kode_MK->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Grid->renderFieldHeader($Grid->Kode_MK) ?></div></th>
<?php } ?>
<?php if ($Grid->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Grid->NIM->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Grid->renderFieldHeader($Grid->NIM) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th data-name="Nilai_Diskusi" class="<?= $Grid->Nilai_Diskusi->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Grid->renderFieldHeader($Grid->Nilai_Diskusi) ?></div></th>
<?php } ?>
<?php if ($Grid->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th data-name="Assessment_Skor_As_1" class="<?= $Grid->Assessment_Skor_As_1->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Grid->renderFieldHeader($Grid->Assessment_Skor_As_1) ?></div></th>
<?php } ?>
<?php if ($Grid->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th data-name="Assessment_Skor_As_2" class="<?= $Grid->Assessment_Skor_As_2->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Grid->renderFieldHeader($Grid->Assessment_Skor_As_2) ?></div></th>
<?php } ?>
<?php if ($Grid->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th data-name="Assessment_Skor_As_3" class="<?= $Grid->Assessment_Skor_As_3->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Grid->renderFieldHeader($Grid->Assessment_Skor_As_3) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th data-name="Nilai_Tugas" class="<?= $Grid->Nilai_Tugas->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Grid->renderFieldHeader($Grid->Nilai_Tugas) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th data-name="Nilai_UTS" class="<?= $Grid->Nilai_UTS->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Grid->renderFieldHeader($Grid->Nilai_UTS) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th data-name="Nilai_Akhir" class="<?= $Grid->Nilai_Akhir->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Grid->renderFieldHeader($Grid->Nilai_Akhir) ?></div></th>
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
    <?php if ($Grid->id_no->Visible) { // id_no ?>
        <td data-name="id_no"<?= $Grid->id_no->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_no" id="o<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Grid->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_no->getDisplayValue($Grid->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_no" id="x<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Grid->id_no->viewAttributes() ?>>
<?= $Grid->id_no->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_id_no" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_id_no" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_no" id="x<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->Kode_MK->Visible) { // Kode_MK ?>
        <td data-name="Kode_MK"<?= $Grid->Kode_MK->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->Kode_MK->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Grid->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Kode_MK->getDisplayValue($Grid->Kode_MK->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Kode_MK" name="x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<input type="<?= $Grid->Kode_MK->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Kode_MK" id="x<?= $Grid->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Grid->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Kode_MK->formatPattern()) ?>"<?= $Grid->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Kode_MK->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Kode_MK" id="o<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<?php if ($Grid->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Grid->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Kode_MK->getDisplayValue($Grid->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Kode_MK" name="x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Grid->Kode_MK->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Kode_MK" id="x<?= $Grid->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Grid->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Kode_MK->formatPattern()) ?>"<?= $Grid->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Kode_MK" id="o<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->OldValue ?? $Grid->Kode_MK->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Grid->Kode_MK->viewAttributes() ?>>
<?= $Grid->Kode_MK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Kode_MK" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Kode_MK" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Kode_MK" id="x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Grid->NIM->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_NIM" id="o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<span<?= $Grid->NIM->viewAttributes() ?>>
<?= $Grid->NIM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_NIM" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_NIM" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td data-name="Nilai_Diskusi"<?= $Grid->Nilai_Diskusi->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Grid->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Grid->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Diskusi->formatPattern()) ?>"<?= $Grid->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="o<?= $Grid->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Grid->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Grid->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Grid->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Diskusi->formatPattern()) ?>"<?= $Grid->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Grid->Nilai_Diskusi->viewAttributes() ?>>
<?= $Grid->Nilai_Diskusi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Grid->Nilai_Diskusi->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Grid->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td data-name="Assessment_Skor_As_1"<?= $Grid->Assessment_Skor_As_1->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Grid->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Grid->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Grid->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Grid->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Grid->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Grid->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Grid->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Grid->Assessment_Skor_As_1->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Grid->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td data-name="Assessment_Skor_As_2"<?= $Grid->Assessment_Skor_As_2->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Grid->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Grid->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Grid->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Grid->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Grid->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Grid->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Grid->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Grid->Assessment_Skor_As_2->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Grid->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td data-name="Assessment_Skor_As_3"<?= $Grid->Assessment_Skor_As_3->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Grid->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Grid->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Grid->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Grid->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Grid->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Grid->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Grid->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Grid->Assessment_Skor_As_3->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Grid->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td data-name="Nilai_Tugas"<?= $Grid->Nilai_Tugas->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Grid->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Tugas" id="x<?= $Grid->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Grid->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Tugas->formatPattern()) ?>"<?= $Grid->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_Tugas" id="o<?= $Grid->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Grid->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Grid->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Tugas" id="x<?= $Grid->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Grid->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Tugas->formatPattern()) ?>"<?= $Grid->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Grid->Nilai_Tugas->viewAttributes() ?>>
<?= $Grid->Nilai_Tugas->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Tugas" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Grid->Nilai_Tugas->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Tugas" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Grid->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td data-name="Nilai_UTS"<?= $Grid->Nilai_UTS->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Grid->Nilai_UTS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_UTS" id="x<?= $Grid->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Grid->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_UTS->formatPattern()) ?>"<?= $Grid->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_UTS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_UTS" id="o<?= $Grid->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Grid->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Grid->Nilai_UTS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_UTS" id="x<?= $Grid->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Grid->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_UTS->formatPattern()) ?>"<?= $Grid->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_UTS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Grid->Nilai_UTS->viewAttributes() ?>>
<?= $Grid->Nilai_UTS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_UTS" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Grid->Nilai_UTS->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_UTS" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Grid->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td data-name="Nilai_Akhir"<?= $Grid->Nilai_Akhir->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Grid->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Akhir" id="x<?= $Grid->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Grid->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Akhir->formatPattern()) ?>"<?= $Grid->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_Akhir" id="o<?= $Grid->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Grid->Nilai_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Grid->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Akhir" id="x<?= $Grid->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Grid->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Akhir->formatPattern()) ?>"<?= $Grid->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Grid->Nilai_Akhir->viewAttributes() ?>>
<?= $Grid->Nilai_Akhir->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Akhir" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Grid->Nilai_Akhir->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Akhir" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Grid->Nilai_Akhir->OldValue) ?>">
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
loadjs.ready(["fdetil_mata_kuliahgrid","load"], () => fdetil_mata_kuliahgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdetil_mata_kuliahgrid">
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
<div id="fdetil_mata_kuliahgrid" class="ew-form ew-list-form">
<div id="gmp_detil_mata_kuliah" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_detil_mata_kuliahgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->id_no->Visible) { // id_no ?>
        <th data-name="id_no" class="<?= $Grid->id_no->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Grid->renderFieldHeader($Grid->id_no) ?></div></th>
<?php } ?>
<?php if ($Grid->Kode_MK->Visible) { // Kode_MK ?>
        <th data-name="Kode_MK" class="<?= $Grid->Kode_MK->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Grid->renderFieldHeader($Grid->Kode_MK) ?></div></th>
<?php } ?>
<?php if ($Grid->NIM->Visible) { // NIM ?>
        <th data-name="NIM" class="<?= $Grid->NIM->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Grid->renderFieldHeader($Grid->NIM) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th data-name="Nilai_Diskusi" class="<?= $Grid->Nilai_Diskusi->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Grid->renderFieldHeader($Grid->Nilai_Diskusi) ?></div></th>
<?php } ?>
<?php if ($Grid->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th data-name="Assessment_Skor_As_1" class="<?= $Grid->Assessment_Skor_As_1->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Grid->renderFieldHeader($Grid->Assessment_Skor_As_1) ?></div></th>
<?php } ?>
<?php if ($Grid->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th data-name="Assessment_Skor_As_2" class="<?= $Grid->Assessment_Skor_As_2->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Grid->renderFieldHeader($Grid->Assessment_Skor_As_2) ?></div></th>
<?php } ?>
<?php if ($Grid->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th data-name="Assessment_Skor_As_3" class="<?= $Grid->Assessment_Skor_As_3->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Grid->renderFieldHeader($Grid->Assessment_Skor_As_3) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th data-name="Nilai_Tugas" class="<?= $Grid->Nilai_Tugas->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Grid->renderFieldHeader($Grid->Nilai_Tugas) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th data-name="Nilai_UTS" class="<?= $Grid->Nilai_UTS->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Grid->renderFieldHeader($Grid->Nilai_UTS) ?></div></th>
<?php } ?>
<?php if ($Grid->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th data-name="Nilai_Akhir" class="<?= $Grid->Nilai_Akhir->headerCellClass() ?>"><div id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Grid->renderFieldHeader($Grid->Nilai_Akhir) ?></div></th>
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
    <?php if ($Grid->id_no->Visible) { // id_no ?>
        <td data-name="id_no"<?= $Grid->id_no->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_id_no" id="o<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Grid->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_no->getDisplayValue($Grid->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_no" id="x<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_id_no" class="el_detil_mata_kuliah_id_no">
<span<?= $Grid->id_no->viewAttributes() ?>>
<?= $Grid->id_no->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_id_no" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_id_no" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_no" id="x<?= $Grid->RowIndex ?>_id_no" value="<?= HtmlEncode($Grid->id_no->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->Kode_MK->Visible) { // Kode_MK ?>
        <td data-name="Kode_MK"<?= $Grid->Kode_MK->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->Kode_MK->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Grid->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Kode_MK->getDisplayValue($Grid->Kode_MK->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Kode_MK" name="x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<input type="<?= $Grid->Kode_MK->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Kode_MK" id="x<?= $Grid->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Grid->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Kode_MK->formatPattern()) ?>"<?= $Grid->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Kode_MK->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Kode_MK" id="o<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<?php if ($Grid->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Grid->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Kode_MK->getDisplayValue($Grid->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Kode_MK" name="x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Grid->Kode_MK->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Kode_MK" id="x<?= $Grid->RowIndex ?>_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Grid->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Kode_MK->formatPattern()) ?>"<?= $Grid->Kode_MK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Kode_MK" id="o<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->OldValue ?? $Grid->Kode_MK->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Kode_MK" class="el_detil_mata_kuliah_Kode_MK">
<span<?= $Grid->Kode_MK->viewAttributes() ?>>
<?= $Grid->Kode_MK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Kode_MK" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Kode_MK" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Kode_MK" id="x<?= $Grid->RowIndex ?>_Kode_MK" value="<?= HtmlEncode($Grid->Kode_MK->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->NIM->Visible) { // NIM ?>
        <td data-name="NIM"<?= $Grid->NIM->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_NIM" id="o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<input type="<?= $Grid->NIM->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_NIM" id="x<?= $Grid->RowIndex ?>_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Grid->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->NIM->formatPattern()) ?>"<?= $Grid->NIM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NIM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_NIM" class="el_detil_mata_kuliah_NIM">
<span<?= $Grid->NIM->viewAttributes() ?>>
<?= $Grid->NIM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_NIM" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_NIM" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_NIM" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_NIM" value="<?= HtmlEncode($Grid->NIM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td data-name="Nilai_Diskusi"<?= $Grid->Nilai_Diskusi->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Grid->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Grid->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Diskusi->formatPattern()) ?>"<?= $Grid->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="o<?= $Grid->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Grid->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Grid->Nilai_Diskusi->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="x<?= $Grid->RowIndex ?>_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Grid->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Diskusi->formatPattern()) ?>"<?= $Grid->Nilai_Diskusi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Diskusi" class="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Grid->Nilai_Diskusi->viewAttributes() ?>>
<?= $Grid->Nilai_Diskusi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Grid->Nilai_Diskusi->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Diskusi" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Diskusi" value="<?= HtmlEncode($Grid->Nilai_Diskusi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td data-name="Assessment_Skor_As_1"<?= $Grid->Assessment_Skor_As_1->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Grid->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Grid->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Grid->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Grid->Assessment_Skor_As_1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Grid->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_1" class="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Grid->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Grid->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Grid->Assessment_Skor_As_1->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_1" value="<?= HtmlEncode($Grid->Assessment_Skor_As_1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td data-name="Assessment_Skor_As_2"<?= $Grid->Assessment_Skor_As_2->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Grid->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Grid->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Grid->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Grid->Assessment_Skor_As_2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Grid->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_2" class="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Grid->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Grid->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Grid->Assessment_Skor_As_2->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_2" value="<?= HtmlEncode($Grid->Assessment_Skor_As_2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td data-name="Assessment_Skor_As_3"<?= $Grid->Assessment_Skor_As_3->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Grid->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Grid->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Grid->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Grid->Assessment_Skor_As_3->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Grid->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Grid->Assessment_Skor_As_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Assessment_Skor_As_3" class="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Grid->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Grid->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Grid->Assessment_Skor_As_3->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Assessment_Skor_As_3" value="<?= HtmlEncode($Grid->Assessment_Skor_As_3->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td data-name="Nilai_Tugas"<?= $Grid->Nilai_Tugas->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Grid->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Tugas" id="x<?= $Grid->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Grid->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Tugas->formatPattern()) ?>"<?= $Grid->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_Tugas" id="o<?= $Grid->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Grid->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Grid->Nilai_Tugas->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Tugas" id="x<?= $Grid->RowIndex ?>_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Grid->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Tugas->formatPattern()) ?>"<?= $Grid->Nilai_Tugas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Tugas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Tugas" class="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Grid->Nilai_Tugas->viewAttributes() ?>>
<?= $Grid->Nilai_Tugas->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Tugas" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Grid->Nilai_Tugas->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Tugas" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Tugas" value="<?= HtmlEncode($Grid->Nilai_Tugas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td data-name="Nilai_UTS"<?= $Grid->Nilai_UTS->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Grid->Nilai_UTS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_UTS" id="x<?= $Grid->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Grid->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_UTS->formatPattern()) ?>"<?= $Grid->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_UTS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_UTS" id="o<?= $Grid->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Grid->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Grid->Nilai_UTS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_UTS" id="x<?= $Grid->RowIndex ?>_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Grid->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_UTS->formatPattern()) ?>"<?= $Grid->Nilai_UTS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_UTS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_UTS" class="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Grid->Nilai_UTS->viewAttributes() ?>>
<?= $Grid->Nilai_UTS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_UTS" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Grid->Nilai_UTS->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_UTS" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_UTS" value="<?= HtmlEncode($Grid->Nilai_UTS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td data-name="Nilai_Akhir"<?= $Grid->Nilai_Akhir->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Grid->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Akhir" id="x<?= $Grid->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Grid->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Akhir->formatPattern()) ?>"<?= $Grid->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nilai_Akhir" id="o<?= $Grid->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Grid->Nilai_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Grid->Nilai_Akhir->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nilai_Akhir" id="x<?= $Grid->RowIndex ?>_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Grid->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Grid->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nilai_Akhir->formatPattern()) ?>"<?= $Grid->Nilai_Akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nilai_Akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_detil_mata_kuliah_Nilai_Akhir" class="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Grid->Nilai_Akhir->viewAttributes() ?>>
<?= $Grid->Nilai_Akhir->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" name="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Akhir" id="fdetil_mata_kuliahgrid$x<?= $Grid->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Grid->Nilai_Akhir->FormValue) ?>">
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" data-hidden="1" data-old name="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Akhir" id="fdetil_mata_kuliahgrid$o<?= $Grid->RowIndex ?>_Nilai_Akhir" value="<?= HtmlEncode($Grid->Nilai_Akhir->OldValue) ?>">
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
loadjs.ready(["fdetil_mata_kuliahgrid","load"], () => fdetil_mata_kuliahgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fdetil_mata_kuliahgrid">
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
    ew.addEventHandlers("detil_mata_kuliah");
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
