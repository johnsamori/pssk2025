<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KesehatanMahasiswaDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kesehatan_mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fkesehatan_mahasiswadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkesehatan_mahasiswadelete")
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
<form name="fkesehatan_mahasiswadelete" id="fkesehatan_mahasiswadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kesehatan_mahasiswa">
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
<?php if ($Page->Id_kesehatan->Visible) { // Id_kesehatan ?>
        <th class="<?= $Page->Id_kesehatan->headerCellClass() ?>"><span id="elh_kesehatan_mahasiswa_Id_kesehatan" class="kesehatan_mahasiswa_Id_kesehatan"><?= $Page->Id_kesehatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_kesehatan_mahasiswa_NIM" class="kesehatan_mahasiswa_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Dokter_Penanggung_Jawab->Visible) { // Dokter_Penanggung_Jawab ?>
        <th class="<?= $Page->Dokter_Penanggung_Jawab->headerCellClass() ?>"><span id="elh_kesehatan_mahasiswa_Dokter_Penanggung_Jawab" class="kesehatan_mahasiswa_Dokter_Penanggung_Jawab"><?= $Page->Dokter_Penanggung_Jawab->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nomor_SIP->Visible) { // Nomor_SIP ?>
        <th class="<?= $Page->Nomor_SIP->headerCellClass() ?>"><span id="elh_kesehatan_mahasiswa_Nomor_SIP" class="kesehatan_mahasiswa_Nomor_SIP"><?= $Page->Nomor_SIP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Diagnosa->Visible) { // Diagnosa ?>
        <th class="<?= $Page->Diagnosa->headerCellClass() ?>"><span id="elh_kesehatan_mahasiswa_Diagnosa" class="kesehatan_mahasiswa_Diagnosa"><?= $Page->Diagnosa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Rekomendasi_Dokter->Visible) { // Rekomendasi_Dokter ?>
        <th class="<?= $Page->Rekomendasi_Dokter->headerCellClass() ?>"><span id="elh_kesehatan_mahasiswa_Rekomendasi_Dokter" class="kesehatan_mahasiswa_Rekomendasi_Dokter"><?= $Page->Rekomendasi_Dokter->caption() ?></span></th>
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
<?php if ($Page->Id_kesehatan->Visible) { // Id_kesehatan ?>
        <td<?= $Page->Id_kesehatan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Id_kesehatan->viewAttributes() ?>>
<?= $Page->Id_kesehatan->getViewValue() ?></span>
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
<?php if ($Page->Dokter_Penanggung_Jawab->Visible) { // Dokter_Penanggung_Jawab ?>
        <td<?= $Page->Dokter_Penanggung_Jawab->cellAttributes() ?>>
<span id="">
<span<?= $Page->Dokter_Penanggung_Jawab->viewAttributes() ?>>
<?= $Page->Dokter_Penanggung_Jawab->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nomor_SIP->Visible) { // Nomor_SIP ?>
        <td<?= $Page->Nomor_SIP->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nomor_SIP->viewAttributes() ?>>
<?= $Page->Nomor_SIP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Diagnosa->Visible) { // Diagnosa ?>
        <td<?= $Page->Diagnosa->cellAttributes() ?>>
<span id="">
<span<?= $Page->Diagnosa->viewAttributes() ?>>
<?= $Page->Diagnosa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Rekomendasi_Dokter->Visible) { // Rekomendasi_Dokter ?>
        <td<?= $Page->Rekomendasi_Dokter->cellAttributes() ?>>
<span id="">
<span<?= $Page->Rekomendasi_Dokter->viewAttributes() ?>>
<?= $Page->Rekomendasi_Dokter->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkesehatan_mahasiswadelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkesehatan_mahasiswadelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
