<?php

namespace PHPMaker2025\pssk2025;

// Page object
$AnnexDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { annex: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fannexdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fannexdelete")
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
<form name="fannexdelete" id="fannexdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="annex">
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
<?php if ($Page->No->Visible) { // No ?>
        <th class="<?= $Page->No->headerCellClass() ?>"><span id="elh_annex_No" class="annex_No"><?= $Page->No->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Peraturan_Akdemik_Universitas->Visible) { // Peraturan_Akdemik_Universitas ?>
        <th class="<?= $Page->Peraturan_Akdemik_Universitas->headerCellClass() ?>"><span id="elh_annex_Peraturan_Akdemik_Universitas" class="annex_Peraturan_Akdemik_Universitas"><?= $Page->Peraturan_Akdemik_Universitas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pedoman_Pelaksanaan_Peraturan_Akademik->Visible) { // Pedoman_Pelaksanaan_Peraturan_Akademik ?>
        <th class="<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->headerCellClass() ?>"><span id="elh_annex_Pedoman_Pelaksanaan_Peraturan_Akademik" class="annex_Pedoman_Pelaksanaan_Peraturan_Akademik"><?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Rubrik_Penilaian->Visible) { // Rubrik_Penilaian ?>
        <th class="<?= $Page->Rubrik_Penilaian->headerCellClass() ?>"><span id="elh_annex_Rubrik_Penilaian" class="annex_Rubrik_Penilaian"><?= $Page->Rubrik_Penilaian->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Panduan_Penulisan_KTI->Visible) { // Panduan_Penulisan_KTI ?>
        <th class="<?= $Page->Panduan_Penulisan_KTI->headerCellClass() ?>"><span id="elh_annex_Panduan_Penulisan_KTI" class="annex_Panduan_Penulisan_KTI"><?= $Page->Panduan_Penulisan_KTI->caption() ?></span></th>
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
<?php if ($Page->No->Visible) { // No ?>
        <td<?= $Page->No->cellAttributes() ?>>
<span id="">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Peraturan_Akdemik_Universitas->Visible) { // Peraturan_Akdemik_Universitas ?>
        <td<?= $Page->Peraturan_Akdemik_Universitas->cellAttributes() ?>>
<span id="">
<span<?= $Page->Peraturan_Akdemik_Universitas->viewAttributes() ?>>
<?= $Page->Peraturan_Akdemik_Universitas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pedoman_Pelaksanaan_Peraturan_Akademik->Visible) { // Pedoman_Pelaksanaan_Peraturan_Akademik ?>
        <td<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->viewAttributes() ?>>
<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Rubrik_Penilaian->Visible) { // Rubrik_Penilaian ?>
        <td<?= $Page->Rubrik_Penilaian->cellAttributes() ?>>
<span id="">
<span<?= $Page->Rubrik_Penilaian->viewAttributes() ?>>
<?= $Page->Rubrik_Penilaian->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Panduan_Penulisan_KTI->Visible) { // Panduan_Penulisan_KTI ?>
        <td<?= $Page->Panduan_Penulisan_KTI->cellAttributes() ?>>
<span id="">
<span<?= $Page->Panduan_Penulisan_KTI->viewAttributes() ?>>
<?= $Page->Panduan_Penulisan_KTI->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fannexdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fannexdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
