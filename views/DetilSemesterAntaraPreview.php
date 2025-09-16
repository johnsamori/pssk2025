<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilSemesterAntaraPreview = &$Page;
?>
<script<?= Nonce() ?>>ew.deepAssign(ew.vars, { tables: { detil_semester_antara: <?= json_encode($Page->toClientVar()) ?> } });</script>
<script<?= Nonce() ?>>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<?php // Begin of modification by Masino Sinaga, October 14, 2024 ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>" style="width: 100%;"><!-- .card -->
<?php // End of modification by Masino Sinaga, October 14, 2024 ?>
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .card-body -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php // Begin of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php // End of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
    <?php if (!$Page->id_smtsr->Sortable || !$Page->sortUrl($Page->id_smtsr)) { ?>
        <th class="<?= $Page->id_smtsr->headerCellClass() ?>"><?= $Page->id_smtsr->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_smtsr->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->id_smtsr->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id_smtsr->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id_smtsr->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id_smtsr->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
    <?php if (!$Page->no->Sortable || !$Page->sortUrl($Page->no)) { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><?= $Page->no->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->no->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->no->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->no->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->no->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <?php if (!$Page->NIM->Sortable || !$Page->sortUrl($Page->NIM)) { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><?= $Page->NIM->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->NIM->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->NIM->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->NIM->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->NIM->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
    <?php if (!$Page->KRS->Sortable || !$Page->sortUrl($Page->KRS)) { ?>
        <th class="<?= $Page->KRS->headerCellClass() ?>"><?= $Page->KRS->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->KRS->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->KRS->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->KRS->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->KRS->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->KRS->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
    <?php if (!$Page->Bukti_SPP->Sortable || !$Page->sortUrl($Page->Bukti_SPP)) { ?>
        <th class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><?= $Page->Bukti_SPP->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->Bukti_SPP->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Bukti_SPP->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Bukti_SPP->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Bukti_SPP->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecordCount = 0;
$Page->RowCount = 0;
// Begin of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023

// End of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023
while ($Page->fetch()) {
    // Init row class and style
    $Page->RecordCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->CurrentRow);

    // Render row
    $Page->RowType = RowType::PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Set up row attributes
    $Page->RowAttrs->merge([
        "data-rowindex" => $Page->RowCount,
        "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",

        // Add row attributes for expandable row
        "data-widget" => "expandable-table",
        "aria-expanded" => "false",
    ]);

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php // Begin of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php // End of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <!-- id_smtsr -->
        <td<?= $Page->id_smtsr->cellAttributes() ?>>
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <!-- no -->
        <td<?= $Page->no->cellAttributes() ?>>
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <!-- NIM -->
        <td<?= $Page->NIM->cellAttributes() ?>>
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <!-- KRS -->
        <td<?= $Page->KRS->cellAttributes() ?>>
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <!-- Bukti_SPP -->
        <td<?= $Page->Bukti_SPP->cellAttributes() ?>>
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
// Begin of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023

// End of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.card-body -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-footer -->
</div><!-- /.card -->
<?php } else { // No record ?>
<?php /////////// Begin of Empty Table in Preview Page by Masino Sinaga, September 15, 2023 ////////// ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<?php // BEGIN OF EMPTY TABLE CODE ?>
<?php // Begin of modification by Masino Sinaga, October 14, 2024 ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>" style="width: 100%;"><!-- .card -->
<?php // End of modification by Masino Sinaga, October 14, 2024 ?>
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .card-body -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
// $Page->renderListOptions();

// Render list options (header, left)
// $Page->ListOptions->render("header", "left");
?>
<?php // Begin of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php // End of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
    <?php if (!$Page->id_smtsr->Sortable || !$Page->sortUrl($Page->id_smtsr)) { ?>
        <th class="<?= $Page->id_smtsr->headerCellClass() ?>"><?= $Page->id_smtsr->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_smtsr->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->id_smtsr->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id_smtsr->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id_smtsr->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id_smtsr->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
    <?php if (!$Page->no->Sortable || !$Page->sortUrl($Page->no)) { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><?= $Page->no->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->no->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->no->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->no->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->no->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <?php if (!$Page->NIM->Sortable || !$Page->sortUrl($Page->NIM)) { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><?= $Page->NIM->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->NIM->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->NIM->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->NIM->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->NIM->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
    <?php if (!$Page->KRS->Sortable || !$Page->sortUrl($Page->KRS)) { ?>
        <th class="<?= $Page->KRS->headerCellClass() ?>"><?= $Page->KRS->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->KRS->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->KRS->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->KRS->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->KRS->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->KRS->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
    <?php if (!$Page->Bukti_SPP->Sortable || !$Page->sortUrl($Page->Bukti_SPP)) { ?>
        <th class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><?= $Page->Bukti_SPP->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><div role="button" data-table="detil_semester_antara" data-sort="<?= HtmlEncode($Page->Bukti_SPP->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Bukti_SPP->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Bukti_SPP->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Bukti_SPP->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
	<tr class="border-bottom-0" style="height:36px;">
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php // Begin of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php // End of Sequence Number in Preview, Added by Masino Sinaga, September 16, 2023 ?>
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <!-- id_smtsr -->
        <td<?= $Page->id_smtsr->cellAttributes() ?>>
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <!-- no -->
        <td<?= $Page->no->cellAttributes() ?>>
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <!-- NIM -->
        <td<?= $Page->NIM->cellAttributes() ?>>
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <!-- KRS -->
        <td<?= $Page->KRS->cellAttributes() ?>>
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <!-- Bukti_SPP -->
        <td<?= $Page->Bukti_SPP->cellAttributes() ?>>
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
    </tbody>
</table><!-- /.table -->
</div><!-- /.card-body -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-footer -->
</div><!-- /.card -->
<?php // END OF EMPTY TABLE CODE ?>
<?php } else { // Else of MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<div class="card border-0"><!-- .card -->
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card -->
<?php } ///////// End of Empty Table in Preview Page by Masino Sinaga, September 15, 2023  ?>
<?php } ?>
<?php
foreach ($Page->DetailCounts as $detailTblVar => $detailCount) {
?>
<div class="ew-detail-count d-none" data-table="<?= $detailTblVar ?>" data-count="<?= $detailCount ?>"><?= FormatInteger($detailCount) ?></div>
<?php
}
?>
<?php
$Page->showPageFooter();
?>
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
<?php
$Page->Result?->free();
?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
