<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KaryaIlmiahDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { karya_ilmiah: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fkarya_ilmiahdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkarya_ilmiahdelete")
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
<form name="fkarya_ilmiahdelete" id="fkarya_ilmiahdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="karya_ilmiah">
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
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <th class="<?= $Page->Id_karya_ilmiah->headerCellClass() ?>"><span id="elh_karya_ilmiah_Id_karya_ilmiah" class="karya_ilmiah_Id_karya_ilmiah"><?= $Page->Id_karya_ilmiah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_karya_ilmiah_NIM" class="karya_ilmiah_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><span id="elh_karya_ilmiah_Judul_Penelitian" class="karya_ilmiah_Judul_Penelitian"><?= $Page->Judul_Penelitian->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <th class="<?= $Page->Pembimbing_1->headerCellClass() ?>"><span id="elh_karya_ilmiah_Pembimbing_1" class="karya_ilmiah_Pembimbing_1"><?= $Page->Pembimbing_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <th class="<?= $Page->Pembimbing_2->headerCellClass() ?>"><span id="elh_karya_ilmiah_Pembimbing_2" class="karya_ilmiah_Pembimbing_2"><?= $Page->Pembimbing_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <th class="<?= $Page->Pembimbing_3->headerCellClass() ?>"><span id="elh_karya_ilmiah_Pembimbing_3" class="karya_ilmiah_Pembimbing_3"><?= $Page->Pembimbing_3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <th class="<?= $Page->Penguji_1->headerCellClass() ?>"><span id="elh_karya_ilmiah_Penguji_1" class="karya_ilmiah_Penguji_1"><?= $Page->Penguji_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <th class="<?= $Page->Penguji_2->headerCellClass() ?>"><span id="elh_karya_ilmiah_Penguji_2" class="karya_ilmiah_Penguji_2"><?= $Page->Penguji_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <th class="<?= $Page->Lembar_Pengesahan->headerCellClass() ?>"><span id="elh_karya_ilmiah_Lembar_Pengesahan" class="karya_ilmiah_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <th class="<?= $Page->Judul_Publikasi->headerCellClass() ?>"><span id="elh_karya_ilmiah_Judul_Publikasi" class="karya_ilmiah_Judul_Publikasi"><?= $Page->Judul_Publikasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <th class="<?= $Page->Link_Publikasi->headerCellClass() ?>"><span id="elh_karya_ilmiah_Link_Publikasi" class="karya_ilmiah_Link_Publikasi"><?= $Page->Link_Publikasi->caption() ?></span></th>
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
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
        <td<?= $Page->Id_karya_ilmiah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Id_karya_ilmiah->viewAttributes() ?>>
<?= $Page->Id_karya_ilmiah->getViewValue() ?></span>
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
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
        <td<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pembimbing_1->viewAttributes() ?>>
<?= $Page->Pembimbing_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
        <td<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pembimbing_2->viewAttributes() ?>>
<?= $Page->Pembimbing_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
        <td<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pembimbing_3->viewAttributes() ?>>
<?= $Page->Pembimbing_3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
        <td<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="">
<span<?= $Page->Penguji_1->viewAttributes() ?>>
<?= $Page->Penguji_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
        <td<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="">
<span<?= $Page->Penguji_2->viewAttributes() ?>>
<?= $Page->Penguji_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
        <td<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
        <td<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Judul_Publikasi->viewAttributes() ?>>
<?= $Page->Judul_Publikasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
        <td<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Link_Publikasi->viewAttributes() ?>>
<?= $Page->Link_Publikasi->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkarya_ilmiahdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
