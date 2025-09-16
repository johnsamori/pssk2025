<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilSemesterAntaraDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_semester_antara: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdetil_semester_antaradelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_semester_antaradelete")
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
<form name="fdetil_semester_antaradelete" id="fdetil_semester_antaradelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detil_semester_antara">
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
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <th class="<?= $Page->id_smtsr->headerCellClass() ?>"><span id="elh_detil_semester_antara_id_smtsr" class="detil_semester_antara_id_smtsr"><?= $Page->id_smtsr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <th class="<?= $Page->no->headerCellClass() ?>"><span id="elh_detil_semester_antara_no" class="detil_semester_antara_no"><?= $Page->no->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_detil_semester_antara_NIM" class="detil_semester_antara_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
        <th class="<?= $Page->KRS->headerCellClass() ?>"><span id="elh_detil_semester_antara_KRS" class="detil_semester_antara_KRS"><?= $Page->KRS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <th class="<?= $Page->Bukti_SPP->headerCellClass() ?>"><span id="elh_detil_semester_antara_Bukti_SPP" class="detil_semester_antara_Bukti_SPP"><?= $Page->Bukti_SPP->caption() ?></span></th>
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
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
        <td<?= $Page->id_smtsr->cellAttributes() ?>>
<span id="">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<?= $Page->id_smtsr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
        <td<?= $Page->no->cellAttributes() ?>>
<span id="">
<span<?= $Page->no->viewAttributes() ?>>
<?= $Page->no->getViewValue() ?></span>
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
<?php if ($Page->KRS->Visible) { // KRS ?>
        <td<?= $Page->KRS->cellAttributes() ?>>
<span id="">
<span<?= $Page->KRS->viewAttributes() ?>>
<?= $Page->KRS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
        <td<?= $Page->Bukti_SPP->cellAttributes() ?>>
<span id="">
<span<?= $Page->Bukti_SPP->viewAttributes() ?>>
<?= GetFileViewTag($Page->Bukti_SPP, $Page->Bukti_SPP->getViewValue(), false) ?>
</span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_semester_antaradelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdetil_semester_antaradelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
