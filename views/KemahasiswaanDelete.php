<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KemahasiswaanDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kemahasiswaan: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fkemahasiswaandelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkemahasiswaandelete")
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
<form name="fkemahasiswaandelete" id="fkemahasiswaandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kemahasiswaan">
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
<?php if ($Page->id_kemahasiswaan->Visible) { // id_kemahasiswaan ?>
        <th class="<?= $Page->id_kemahasiswaan->headerCellClass() ?>"><span id="elh_kemahasiswaan_id_kemahasiswaan" class="kemahasiswaan_id_kemahasiswaan"><?= $Page->id_kemahasiswaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_kemahasiswaan_NIM" class="kemahasiswaan_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenis_Beasiswa->Visible) { // Jenis_Beasiswa ?>
        <th class="<?= $Page->Jenis_Beasiswa->headerCellClass() ?>"><span id="elh_kemahasiswaan_Jenis_Beasiswa" class="kemahasiswaan_Jenis_Beasiswa"><?= $Page->Jenis_Beasiswa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sumber_beasiswa->Visible) { // Sumber_beasiswa ?>
        <th class="<?= $Page->Sumber_beasiswa->headerCellClass() ?>"><span id="elh_kemahasiswaan_Sumber_beasiswa" class="kemahasiswaan_Sumber_beasiswa"><?= $Page->Sumber_beasiswa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Kegiatan->Visible) { // Nama_Kegiatan ?>
        <th class="<?= $Page->Nama_Kegiatan->headerCellClass() ?>"><span id="elh_kemahasiswaan_Nama_Kegiatan" class="kemahasiswaan_Nama_Kegiatan"><?= $Page->Nama_Kegiatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Penghargaan_YangDiterima->Visible) { // Nama_Penghargaan_Yang Diterima ?>
        <th class="<?= $Page->Nama_Penghargaan_YangDiterima->headerCellClass() ?>"><span id="elh_kemahasiswaan_Nama_Penghargaan_YangDiterima" class="kemahasiswaan_Nama_Penghargaan_YangDiterima"><?= $Page->Nama_Penghargaan_YangDiterima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sertifikat->Visible) { // Sertifikat ?>
        <th class="<?= $Page->Sertifikat->headerCellClass() ?>"><span id="elh_kemahasiswaan_Sertifikat" class="kemahasiswaan_Sertifikat"><?= $Page->Sertifikat->caption() ?></span></th>
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
<?php if ($Page->id_kemahasiswaan->Visible) { // id_kemahasiswaan ?>
        <td<?= $Page->id_kemahasiswaan->cellAttributes() ?>>
<span id="">
<span<?= $Page->id_kemahasiswaan->viewAttributes() ?>>
<?= $Page->id_kemahasiswaan->getViewValue() ?></span>
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
<?php if ($Page->Jenis_Beasiswa->Visible) { // Jenis_Beasiswa ?>
        <td<?= $Page->Jenis_Beasiswa->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jenis_Beasiswa->viewAttributes() ?>>
<?= $Page->Jenis_Beasiswa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sumber_beasiswa->Visible) { // Sumber_beasiswa ?>
        <td<?= $Page->Sumber_beasiswa->cellAttributes() ?>>
<span id="">
<span<?= $Page->Sumber_beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_beasiswa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Kegiatan->Visible) { // Nama_Kegiatan ?>
        <td<?= $Page->Nama_Kegiatan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nama_Kegiatan->viewAttributes() ?>>
<?= $Page->Nama_Kegiatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Penghargaan_YangDiterima->Visible) { // Nama_Penghargaan_Yang Diterima ?>
        <td<?= $Page->Nama_Penghargaan_YangDiterima->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nama_Penghargaan_YangDiterima->viewAttributes() ?>>
<?= $Page->Nama_Penghargaan_YangDiterima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sertifikat->Visible) { // Sertifikat ?>
        <td<?= $Page->Sertifikat->cellAttributes() ?>>
<span id="">
<span<?= $Page->Sertifikat->viewAttributes() ?>>
<?= $Page->Sertifikat->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkemahasiswaandelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fkemahasiswaandelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
