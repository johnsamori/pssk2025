<?php

namespace PHPMaker2025\pssk2025;

// Page object
$CutiAkademikDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cuti_akademik: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcuti_akademikdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcuti_akademikdelete")
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
<form name="fcuti_akademikdelete" id="fcuti_akademikdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cuti_akademik">
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
<?php if ($Page->id_ca->Visible) { // id_ca ?>
        <th class="<?= $Page->id_ca->headerCellClass() ?>"><span id="elh_cuti_akademik_id_ca" class="cuti_akademik_id_ca"><?= $Page->id_ca->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_cuti_akademik_NIM" class="cuti_akademik_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pengajuan_Surat_Cuti_Akademik->Visible) { // Pengajuan_Surat_Cuti_Akademik ?>
        <th class="<?= $Page->Pengajuan_Surat_Cuti_Akademik->headerCellClass() ?>"><span id="elh_cuti_akademik_Pengajuan_Surat_Cuti_Akademik" class="cuti_akademik_Pengajuan_Surat_Cuti_Akademik"><?= $Page->Pengajuan_Surat_Cuti_Akademik->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Persetujuan_Cuti_Akademik->Visible) { // Persetujuan_Cuti_Akademik ?>
        <th class="<?= $Page->Persetujuan_Cuti_Akademik->headerCellClass() ?>"><span id="elh_cuti_akademik_Persetujuan_Cuti_Akademik" class="cuti_akademik_Persetujuan_Cuti_Akademik"><?= $Page->Persetujuan_Cuti_Akademik->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Surat_Keterangan_Aktif_Kembali->Visible) { // Surat_Keterangan_Aktif_Kembali ?>
        <th class="<?= $Page->Surat_Keterangan_Aktif_Kembali->headerCellClass() ?>"><span id="elh_cuti_akademik_Surat_Keterangan_Aktif_Kembali" class="cuti_akademik_Surat_Keterangan_Aktif_Kembali"><?= $Page->Surat_Keterangan_Aktif_Kembali->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th class="<?= $Page->Tanggal->headerCellClass() ?>"><span id="elh_cuti_akademik_Tanggal" class="cuti_akademik_Tanggal"><?= $Page->Tanggal->caption() ?></span></th>
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
<?php if ($Page->id_ca->Visible) { // id_ca ?>
        <td<?= $Page->id_ca->cellAttributes() ?>>
<span id="">
<span<?= $Page->id_ca->viewAttributes() ?>>
<?= $Page->id_ca->getViewValue() ?></span>
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
<?php if ($Page->Pengajuan_Surat_Cuti_Akademik->Visible) { // Pengajuan_Surat_Cuti_Akademik ?>
        <td<?= $Page->Pengajuan_Surat_Cuti_Akademik->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pengajuan_Surat_Cuti_Akademik->viewAttributes() ?>>
<?= $Page->Pengajuan_Surat_Cuti_Akademik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Persetujuan_Cuti_Akademik->Visible) { // Persetujuan_Cuti_Akademik ?>
        <td<?= $Page->Persetujuan_Cuti_Akademik->cellAttributes() ?>>
<span id="">
<span<?= $Page->Persetujuan_Cuti_Akademik->viewAttributes() ?>>
<?= $Page->Persetujuan_Cuti_Akademik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Surat_Keterangan_Aktif_Kembali->Visible) { // Surat_Keterangan_Aktif_Kembali ?>
        <td<?= $Page->Surat_Keterangan_Aktif_Kembali->cellAttributes() ?>>
<span id="">
<span<?= $Page->Surat_Keterangan_Aktif_Kembali->viewAttributes() ?>>
<?= $Page->Surat_Keterangan_Aktif_Kembali->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td<?= $Page->Tanggal->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fcuti_akademikdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fcuti_akademikdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
