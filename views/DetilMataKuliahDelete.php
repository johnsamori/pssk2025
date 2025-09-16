<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilMataKuliahDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdetil_mata_kuliahdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_mata_kuliahdelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script<?= Nonce() ?>>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdetil_mata_kuliahdelete" id="fdetil_mata_kuliahdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detil_mata_kuliah">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id_no->Visible) { // id_no ?>
        <th class="<?= $Page->id_no->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_id_no" class="detil_mata_kuliah_id_no"><?= $Page->id_no->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <th class="<?= $Page->Kode_MK->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Kode_MK" class="detil_mata_kuliah_Kode_MK"><?= $Page->Kode_MK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_NIM" class="detil_mata_kuliah_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <th class="<?= $Page->Nilai_Diskusi->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Nilai_Diskusi" class="detil_mata_kuliah_Nilai_Diskusi"><?= $Page->Nilai_Diskusi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <th class="<?= $Page->Assessment_Skor_As_1->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Assessment_Skor_As_1" class="detil_mata_kuliah_Assessment_Skor_As_1"><?= $Page->Assessment_Skor_As_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <th class="<?= $Page->Assessment_Skor_As_2->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Assessment_Skor_As_2" class="detil_mata_kuliah_Assessment_Skor_As_2"><?= $Page->Assessment_Skor_As_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <th class="<?= $Page->Assessment_Skor_As_3->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Assessment_Skor_As_3" class="detil_mata_kuliah_Assessment_Skor_As_3"><?= $Page->Assessment_Skor_As_3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <th class="<?= $Page->Nilai_Tugas->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Nilai_Tugas" class="detil_mata_kuliah_Nilai_Tugas"><?= $Page->Nilai_Tugas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <th class="<?= $Page->Nilai_UTS->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Nilai_UTS" class="detil_mata_kuliah_Nilai_UTS"><?= $Page->Nilai_UTS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <th class="<?= $Page->Nilai_Akhir->headerCellClass() ?>"><span id="elh_detil_mata_kuliah_Nilai_Akhir" class="detil_mata_kuliah_Nilai_Akhir"><?= $Page->Nilai_Akhir->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id_no->Visible) { // id_no ?>
        <td<?= $Page->id_no->cellAttributes() ?>>
<span id="">
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
        <td<?= $Page->Kode_MK->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <td<?= $Page->NIM->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
        <td<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
        <td<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<span id="">
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
        <td<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<span id="">
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
        <td<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<span id="">
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
        <td<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
        <td<?= $Page->Nilai_UTS->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
        <td<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Result?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_mata_kuliahdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
