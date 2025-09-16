<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilMataKuliahPreview = &$Page;
?>
<script<?= Nonce() ?>>ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: <?= json_encode($Page->toClientVar()) ?> } });</script>
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
<?php if ($Page->id_no->Visible) { // id_no ?>
    <?php if (!$Page->id_no->Sortable || !$Page->sortUrl($Page->id_no)) { ?>
        <th class="<?= $Page->id_no->headerCellClass() ?>"><?= $Page->id_no->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_no->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->id_no->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id_no->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id_no->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id_no->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
    <?php if (!$Page->Kode_MK->Sortable || !$Page->sortUrl($Page->Kode_MK)) { ?>
        <th class="<?= $Page->Kode_MK->headerCellClass() ?>"><?= $Page->Kode_MK->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Kode_MK->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Kode_MK->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Kode_MK->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Kode_MK->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Kode_MK->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <?php if (!$Page->NIM->Sortable || !$Page->sortUrl($Page->NIM)) { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><?= $Page->NIM->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->NIM->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->NIM->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->NIM->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->NIM->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
    <?php if (!$Page->Nilai_Diskusi->Sortable || !$Page->sortUrl($Page->Nilai_Diskusi)) { ?>
        <th class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><?= $Page->Nilai_Diskusi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_Diskusi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_Diskusi->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_Diskusi->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_Diskusi->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
    <?php if (!$Page->Assessment_Skor_As_1->Sortable || !$Page->sortUrl($Page->Assessment_Skor_As_1)) { ?>
        <th class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><?= $Page->Assessment_Skor_As_1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Assessment_Skor_As_1->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Assessment_Skor_As_1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Assessment_Skor_As_1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Assessment_Skor_As_1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
    <?php if (!$Page->Assessment_Skor_As_2->Sortable || !$Page->sortUrl($Page->Assessment_Skor_As_2)) { ?>
        <th class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><?= $Page->Assessment_Skor_As_2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Assessment_Skor_As_2->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Assessment_Skor_As_2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Assessment_Skor_As_2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Assessment_Skor_As_2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
    <?php if (!$Page->Assessment_Skor_As_3->Sortable || !$Page->sortUrl($Page->Assessment_Skor_As_3)) { ?>
        <th class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><?= $Page->Assessment_Skor_As_3->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Assessment_Skor_As_3->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Assessment_Skor_As_3->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Assessment_Skor_As_3->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Assessment_Skor_As_3->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
    <?php if (!$Page->Nilai_Tugas->Sortable || !$Page->sortUrl($Page->Nilai_Tugas)) { ?>
        <th class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><?= $Page->Nilai_Tugas->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_Tugas->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_Tugas->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_Tugas->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_Tugas->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
    <?php if (!$Page->Nilai_UTS->Sortable || !$Page->sortUrl($Page->Nilai_UTS)) { ?>
        <th class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><?= $Page->Nilai_UTS->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_UTS->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_UTS->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_UTS->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_UTS->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
    <?php if (!$Page->Nilai_Akhir->Sortable || !$Page->sortUrl($Page->Nilai_Akhir)) { ?>
        <th class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><?= $Page->Nilai_Akhir->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_Akhir->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_Akhir->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_Akhir->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_Akhir->getSortIcon() ?></span>
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
<?php if ($Page->id_no->Visible) { // id_no ?>
        <!-- id_no -->
        <td<?= $Page->id_no->cellAttributes() ?>>
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <!-- Kode_MK -->
        <td<?= $Page->Kode_MK->cellAttributes() ?>>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <!-- NIM -->
        <td<?= $Page->NIM->cellAttributes() ?>>
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <!-- Nilai_Diskusi -->
        <td<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <!-- Assessment_Skor_As_1 -->
        <td<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <!-- Assessment_Skor_As_2 -->
        <td<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <!-- Assessment_Skor_As_3 -->
        <td<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <!-- Nilai_Tugas -->
        <td<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <!-- Nilai_UTS -->
        <td<?= $Page->Nilai_UTS->cellAttributes() ?>>
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <!-- Nilai_Akhir -->
        <td<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
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
<?php if ($Page->id_no->Visible) { // id_no ?>
    <?php if (!$Page->id_no->Sortable || !$Page->sortUrl($Page->id_no)) { ?>
        <th class="<?= $Page->id_no->headerCellClass() ?>"><?= $Page->id_no->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_no->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->id_no->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id_no->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id_no->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id_no->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
    <?php if (!$Page->Kode_MK->Sortable || !$Page->sortUrl($Page->Kode_MK)) { ?>
        <th class="<?= $Page->Kode_MK->headerCellClass() ?>"><?= $Page->Kode_MK->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Kode_MK->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Kode_MK->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Kode_MK->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Kode_MK->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Kode_MK->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <?php if (!$Page->NIM->Sortable || !$Page->sortUrl($Page->NIM)) { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><?= $Page->NIM->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->NIM->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->NIM->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->NIM->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->NIM->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
    <?php if (!$Page->Nilai_Diskusi->Sortable || !$Page->sortUrl($Page->Nilai_Diskusi)) { ?>
        <th class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><?= $Page->Nilai_Diskusi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_Diskusi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_Diskusi->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_Diskusi->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_Diskusi->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
    <?php if (!$Page->Assessment_Skor_As_1->Sortable || !$Page->sortUrl($Page->Assessment_Skor_As_1)) { ?>
        <th class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><?= $Page->Assessment_Skor_As_1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Assessment_Skor_As_1->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Assessment_Skor_As_1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Assessment_Skor_As_1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Assessment_Skor_As_1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
    <?php if (!$Page->Assessment_Skor_As_2->Sortable || !$Page->sortUrl($Page->Assessment_Skor_As_2)) { ?>
        <th class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><?= $Page->Assessment_Skor_As_2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Assessment_Skor_As_2->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Assessment_Skor_As_2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Assessment_Skor_As_2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Assessment_Skor_As_2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
    <?php if (!$Page->Assessment_Skor_As_3->Sortable || !$Page->sortUrl($Page->Assessment_Skor_As_3)) { ?>
        <th class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><?= $Page->Assessment_Skor_As_3->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Assessment_Skor_As_3->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Assessment_Skor_As_3->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Assessment_Skor_As_3->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Assessment_Skor_As_3->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
    <?php if (!$Page->Nilai_Tugas->Sortable || !$Page->sortUrl($Page->Nilai_Tugas)) { ?>
        <th class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><?= $Page->Nilai_Tugas->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_Tugas->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_Tugas->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_Tugas->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_Tugas->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
    <?php if (!$Page->Nilai_UTS->Sortable || !$Page->sortUrl($Page->Nilai_UTS)) { ?>
        <th class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><?= $Page->Nilai_UTS->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_UTS->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_UTS->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_UTS->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_UTS->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
    <?php if (!$Page->Nilai_Akhir->Sortable || !$Page->sortUrl($Page->Nilai_Akhir)) { ?>
        <th class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><?= $Page->Nilai_Akhir->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><div role="button" data-table="detil_mata_kuliah" data-sort="<?= HtmlEncode($Page->Nilai_Akhir->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nilai_Akhir->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nilai_Akhir->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nilai_Akhir->getSortIcon() ?></span>
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
<?php if ($Page->id_no->Visible) { // id_no ?>
        <!-- id_no -->
        <td<?= $Page->id_no->cellAttributes() ?>>
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <!-- Kode_MK -->
        <td<?= $Page->Kode_MK->cellAttributes() ?>>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <!-- NIM -->
        <td<?= $Page->NIM->cellAttributes() ?>>
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <!-- Nilai_Diskusi -->
        <td<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <!-- Assessment_Skor_As_1 -->
        <td<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <!-- Assessment_Skor_As_2 -->
        <td<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <!-- Assessment_Skor_As_3 -->
        <td<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <!-- Nilai_Tugas -->
        <td<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <!-- Nilai_UTS -->
        <td<?= $Page->Nilai_UTS->cellAttributes() ?>>
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <!-- Nilai_Akhir -->
        <td<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
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
