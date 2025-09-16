<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilUjianTahapBersamaPreview = &$Page;
?>
<script<?= Nonce() ?>>ew.deepAssign(ew.vars, { tables: { detil_ujian_tahap_bersama: <?= json_encode($Page->toClientVar()) ?> } });</script>
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
<?php if ($Page->no->Visible) { // no ?>
    <?php if (!$Page->no->Sortable || !$Page->sortUrl($Page->no)) { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><?= $Page->no->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->no->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->no->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->no->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->no->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
    <?php if (!$Page->id_utb->Sortable || !$Page->sortUrl($Page->id_utb)) { ?>
        <th class="<?= $Page->id_utb->headerCellClass() ?>"><?= $Page->id_utb->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_utb->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->id_utb->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id_utb->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id_utb->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id_utb->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <?php if (!$Page->NIM->Sortable || !$Page->sortUrl($Page->NIM)) { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><?= $Page->NIM->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->NIM->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->NIM->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->NIM->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->NIM->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
    <?php if (!$Page->Nilai->Sortable || !$Page->sortUrl($Page->Nilai)) { ?>
        <th class="<?= $Page->Nilai->headerCellClass() ?>"><?= $Page->Nilai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->Nilai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai->getSortIcon() ?></span>
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
<?php if ($Page->no->Visible) { // no ?>
        <!-- no -->
        <td<?= $Page->no->cellAttributes() ?>>
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
        <!-- id_utb -->
        <td<?= $Page->id_utb->cellAttributes() ?>>
<span<?= $Page->id_utb->viewAttributes() ?>>
<?= $Page->id_utb->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <!-- NIM -->
        <td<?= $Page->NIM->cellAttributes() ?>>
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
        <!-- Nilai -->
        <td<?= $Page->Nilai->cellAttributes() ?>>
<span<?= $Page->Nilai->viewAttributes() ?>>
<?= $Page->Nilai->getViewValue() ?></span>
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
<?php if ($Page->no->Visible) { // no ?>
    <?php if (!$Page->no->Sortable || !$Page->sortUrl($Page->no)) { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><?= $Page->no->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->no->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->no->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->no->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->no->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
    <?php if (!$Page->id_utb->Sortable || !$Page->sortUrl($Page->id_utb)) { ?>
        <th class="<?= $Page->id_utb->headerCellClass() ?>"><?= $Page->id_utb->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_utb->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->id_utb->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id_utb->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id_utb->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id_utb->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <?php if (!$Page->NIM->Sortable || !$Page->sortUrl($Page->NIM)) { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><?= $Page->NIM->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->NIM->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->NIM->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->NIM->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->NIM->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
    <?php if (!$Page->Nilai->Sortable || !$Page->sortUrl($Page->Nilai)) { ?>
        <th class="<?= $Page->Nilai->headerCellClass() ?>"><?= $Page->Nilai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai->headerCellClass() ?>"><div role="button" data-table="detil_ujian_tahap_bersama" data-sort="<?= HtmlEncode($Page->Nilai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai->getSortIcon() ?></span>
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
<?php if ($Page->no->Visible) { // no ?>
        <!-- no -->
        <td<?= $Page->no->cellAttributes() ?>>
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
        <!-- id_utb -->
        <td<?= $Page->id_utb->cellAttributes() ?>>
<span<?= $Page->id_utb->viewAttributes() ?>>
<?= $Page->id_utb->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <!-- NIM -->
        <td<?= $Page->NIM->cellAttributes() ?>>
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
        <!-- Nilai -->
        <td<?= $Page->Nilai->cellAttributes() ?>>
<span<?= $Page->Nilai->viewAttributes() ?>>
<?= $Page->Nilai->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_ujian_tahap_bersamaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_ujian_tahap_bersamaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
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
