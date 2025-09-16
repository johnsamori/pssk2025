<?php

namespace PHPMaker2025\pssk2025;

// Page object
$PembimbinganDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pembimbingan: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fpembimbingandelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpembimbingandelete")
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
<form name="fpembimbingandelete" id="fpembimbingandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembimbingan">
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
<?php if ($Page->id_pem->Visible) { // id_pem ?>
        <th class="<?= $Page->id_pem->headerCellClass() ?>"><span id="elh_pembimbingan_id_pem" class="pembimbingan_id_pem"><?= $Page->id_pem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIP_Dosen_Pembimbing->Visible) { // NIP_Dosen_Pembimbing ?>
        <th class="<?= $Page->NIP_Dosen_Pembimbing->headerCellClass() ?>"><span id="elh_pembimbingan_NIP_Dosen_Pembimbing" class="pembimbingan_NIP_Dosen_Pembimbing"><?= $Page->NIP_Dosen_Pembimbing->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_pembimbingan_NIM" class="pembimbingan_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Catatan_Mahasiswa->Visible) { // Catatan_Mahasiswa ?>
        <th class="<?= $Page->Catatan_Mahasiswa->headerCellClass() ?>"><span id="elh_pembimbingan_Catatan_Mahasiswa" class="pembimbingan_Catatan_Mahasiswa"><?= $Page->Catatan_Mahasiswa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Catatan_Dosen_Wali->Visible) { // Catatan_Dosen_Wali ?>
        <th class="<?= $Page->Catatan_Dosen_Wali->headerCellClass() ?>"><span id="elh_pembimbingan_Catatan_Dosen_Wali" class="pembimbingan_Catatan_Dosen_Wali"><?= $Page->Catatan_Dosen_Wali->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Rekomendasi_Unit_BK->Visible) { // Rekomendasi_Unit_BK ?>
        <th class="<?= $Page->Rekomendasi_Unit_BK->headerCellClass() ?>"><span id="elh_pembimbingan_Rekomendasi_Unit_BK" class="pembimbingan_Rekomendasi_Unit_BK"><?= $Page->Rekomendasi_Unit_BK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_IP_Semester->Visible) { // Nilai_IP_Semester ?>
        <th class="<?= $Page->Nilai_IP_Semester->headerCellClass() ?>"><span id="elh_pembimbingan_Nilai_IP_Semester" class="pembimbingan_Nilai_IP_Semester"><?= $Page->Nilai_IP_Semester->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_IPK->Visible) { // Nilai_IPK ?>
        <th class="<?= $Page->Nilai_IPK->headerCellClass() ?>"><span id="elh_pembimbingan_Nilai_IPK" class="pembimbingan_Nilai_IPK"><?= $Page->Nilai_IPK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Surat_Peringatan->Visible) { // Surat_Peringatan ?>
        <th class="<?= $Page->Surat_Peringatan->headerCellClass() ?>"><span id="elh_pembimbingan_Surat_Peringatan" class="pembimbingan_Surat_Peringatan"><?= $Page->Surat_Peringatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Surat_Pemberitahuan->Visible) { // Surat_Pemberitahuan ?>
        <th class="<?= $Page->Surat_Pemberitahuan->headerCellClass() ?>"><span id="elh_pembimbingan_Surat_Pemberitahuan" class="pembimbingan_Surat_Pemberitahuan"><?= $Page->Surat_Pemberitahuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Rekomendasi_Akhir->Visible) { // Rekomendasi_Akhir ?>
        <th class="<?= $Page->Rekomendasi_Akhir->headerCellClass() ?>"><span id="elh_pembimbingan_Rekomendasi_Akhir" class="pembimbingan_Rekomendasi_Akhir"><?= $Page->Rekomendasi_Akhir->caption() ?></span></th>
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
<?php if ($Page->id_pem->Visible) { // id_pem ?>
        <td<?= $Page->id_pem->cellAttributes() ?>>
<span id="">
<span<?= $Page->id_pem->viewAttributes() ?>>
<?= $Page->id_pem->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NIP_Dosen_Pembimbing->Visible) { // NIP_Dosen_Pembimbing ?>
        <td<?= $Page->NIP_Dosen_Pembimbing->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIP_Dosen_Pembimbing->viewAttributes() ?>>
<?= $Page->NIP_Dosen_Pembimbing->getViewValue() ?></span>
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
<?php if ($Page->Catatan_Mahasiswa->Visible) { // Catatan_Mahasiswa ?>
        <td<?= $Page->Catatan_Mahasiswa->cellAttributes() ?>>
<span id="">
<span<?= $Page->Catatan_Mahasiswa->viewAttributes() ?>>
<?= $Page->Catatan_Mahasiswa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Catatan_Dosen_Wali->Visible) { // Catatan_Dosen_Wali ?>
        <td<?= $Page->Catatan_Dosen_Wali->cellAttributes() ?>>
<span id="">
<span<?= $Page->Catatan_Dosen_Wali->viewAttributes() ?>>
<?= $Page->Catatan_Dosen_Wali->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Rekomendasi_Unit_BK->Visible) { // Rekomendasi_Unit_BK ?>
        <td<?= $Page->Rekomendasi_Unit_BK->cellAttributes() ?>>
<span id="">
<span<?= $Page->Rekomendasi_Unit_BK->viewAttributes() ?>>
<?= $Page->Rekomendasi_Unit_BK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_IP_Semester->Visible) { // Nilai_IP_Semester ?>
        <td<?= $Page->Nilai_IP_Semester->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_IP_Semester->viewAttributes() ?>>
<?= $Page->Nilai_IP_Semester->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_IPK->Visible) { // Nilai_IPK ?>
        <td<?= $Page->Nilai_IPK->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_IPK->viewAttributes() ?>>
<?= $Page->Nilai_IPK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Surat_Peringatan->Visible) { // Surat_Peringatan ?>
        <td<?= $Page->Surat_Peringatan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Surat_Peringatan->viewAttributes() ?>>
<?= $Page->Surat_Peringatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Surat_Pemberitahuan->Visible) { // Surat_Pemberitahuan ?>
        <td<?= $Page->Surat_Pemberitahuan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Surat_Pemberitahuan->viewAttributes() ?>>
<?= $Page->Surat_Pemberitahuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Rekomendasi_Akhir->Visible) { // Rekomendasi_Akhir ?>
        <td<?= $Page->Rekomendasi_Akhir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Rekomendasi_Akhir->viewAttributes() ?>>
<?= $Page->Rekomendasi_Akhir->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fpembimbingandelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fpembimbingandelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
