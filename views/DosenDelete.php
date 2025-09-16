<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DosenDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdosendelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdosendelete")
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
<form name="fdosendelete" id="fdosendelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="dosen">
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
        <th class="<?= $Page->No->headerCellClass() ?>"><span id="elh_dosen_No" class="dosen_No"><?= $Page->No->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
        <th class="<?= $Page->NIP->headerCellClass() ?>"><span id="elh_dosen_NIP" class="dosen_NIP"><?= $Page->NIP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th class="<?= $Page->NIDN->headerCellClass() ?>"><span id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->NIDN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><span id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->Nama_Lengkap->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <th class="<?= $Page->Gelar_Depan->headerCellClass() ?>"><span id="elh_dosen_Gelar_Depan" class="dosen_Gelar_Depan"><?= $Page->Gelar_Depan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <th class="<?= $Page->Gelar_Belakang->headerCellClass() ?>"><span id="elh_dosen_Gelar_Belakang" class="dosen_Gelar_Belakang"><?= $Page->Gelar_Belakang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <th class="<?= $Page->Program_studi->headerCellClass() ?>"><span id="elh_dosen_Program_studi" class="dosen_Program_studi"><?= $Page->Program_studi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
        <th class="<?= $Page->NIK->headerCellClass() ?>"><span id="elh_dosen_NIK" class="dosen_NIK"><?= $Page->NIK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <th class="<?= $Page->Tanggal_lahir->headerCellClass() ?>"><span id="elh_dosen_Tanggal_lahir" class="dosen_Tanggal_lahir"><?= $Page->Tanggal_lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <th class="<?= $Page->Tempat_lahir->headerCellClass() ?>"><span id="elh_dosen_Tempat_lahir" class="dosen_Tempat_lahir"><?= $Page->Tempat_lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <th class="<?= $Page->Nomor_Karpeg->headerCellClass() ?>"><span id="elh_dosen_Nomor_Karpeg" class="dosen_Nomor_Karpeg"><?= $Page->Nomor_Karpeg->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <th class="<?= $Page->Nomor_Stambuk->headerCellClass() ?>"><span id="elh_dosen_Nomor_Stambuk" class="dosen_Nomor_Stambuk"><?= $Page->Nomor_Stambuk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <th class="<?= $Page->Jenis_kelamin->headerCellClass() ?>"><span id="elh_dosen_Jenis_kelamin" class="dosen_Jenis_kelamin"><?= $Page->Jenis_kelamin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <th class="<?= $Page->Gol_Darah->headerCellClass() ?>"><span id="elh_dosen_Gol_Darah" class="dosen_Gol_Darah"><?= $Page->Gol_Darah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
        <th class="<?= $Page->Agama->headerCellClass() ?>"><span id="elh_dosen_Agama" class="dosen_Agama"><?= $Page->Agama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <th class="<?= $Page->Stattus_menikah->headerCellClass() ?>"><span id="elh_dosen_Stattus_menikah" class="dosen_Stattus_menikah"><?= $Page->Stattus_menikah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th class="<?= $Page->Alamat->headerCellClass() ?>"><span id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->Alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
        <th class="<?= $Page->Kota->headerCellClass() ?>"><span id="elh_dosen_Kota" class="dosen_Kota"><?= $Page->Kota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <th class="<?= $Page->Telepon_seluler->headerCellClass() ?>"><span id="elh_dosen_Telepon_seluler" class="dosen_Telepon_seluler"><?= $Page->Telepon_seluler->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <th class="<?= $Page->Jenis_pegawai->headerCellClass() ?>"><span id="elh_dosen_Jenis_pegawai" class="dosen_Jenis_pegawai"><?= $Page->Jenis_pegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <th class="<?= $Page->Status_pegawai->headerCellClass() ?>"><span id="elh_dosen_Status_pegawai" class="dosen_Status_pegawai"><?= $Page->Status_pegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
        <th class="<?= $Page->Golongan->headerCellClass() ?>"><span id="elh_dosen_Golongan" class="dosen_Golongan"><?= $Page->Golongan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <th class="<?= $Page->Pangkat->headerCellClass() ?>"><span id="elh_dosen_Pangkat" class="dosen_Pangkat"><?= $Page->Pangkat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <th class="<?= $Page->Status_dosen->headerCellClass() ?>"><span id="elh_dosen_Status_dosen" class="dosen_Status_dosen"><?= $Page->Status_dosen->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <th class="<?= $Page->Status_Belajar->headerCellClass() ?>"><span id="elh_dosen_Status_Belajar" class="dosen_Status_Belajar"><?= $Page->Status_Belajar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
        <th class="<?= $Page->e_mail->headerCellClass() ?>"><span id="elh_dosen_e_mail" class="dosen_e_mail"><?= $Page->e_mail->caption() ?></span></th>
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
<?php if ($Page->NIP->Visible) { // NIP ?>
        <td<?= $Page->NIP->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIP->viewAttributes() ?>>
<?= $Page->NIP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td<?= $Page->NIDN->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
        <td<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Gelar_Depan->viewAttributes() ?>>
<?= $Page->Gelar_Depan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
        <td<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="">
<span<?= $Page->Gelar_Belakang->viewAttributes() ?>>
<?= $Page->Gelar_Belakang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
        <td<?= $Page->Program_studi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Program_studi->viewAttributes() ?>>
<?= $Page->Program_studi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
        <td<?= $Page->NIK->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIK->viewAttributes() ?>>
<?= $Page->NIK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
        <td<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tanggal_lahir->viewAttributes() ?>>
<?= $Page->Tanggal_lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
        <td<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tempat_lahir->viewAttributes() ?>>
<?= $Page->Tempat_lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
        <td<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nomor_Karpeg->viewAttributes() ?>>
<?= $Page->Nomor_Karpeg->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
        <td<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nomor_Stambuk->viewAttributes() ?>>
<?= $Page->Nomor_Stambuk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
        <td<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jenis_kelamin->viewAttributes() ?>>
<?= $Page->Jenis_kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
        <td<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Gol_Darah->viewAttributes() ?>>
<?= $Page->Gol_Darah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
        <td<?= $Page->Agama->cellAttributes() ?>>
<span id="">
<span<?= $Page->Agama->viewAttributes() ?>>
<?= $Page->Agama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
        <td<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Stattus_menikah->viewAttributes() ?>>
<?= $Page->Stattus_menikah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td<?= $Page->Alamat->cellAttributes() ?>>
<span id="">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
        <td<?= $Page->Kota->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kota->viewAttributes() ?>>
<?= $Page->Kota->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
        <td<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="">
<span<?= $Page->Telepon_seluler->viewAttributes() ?>>
<?= $Page->Telepon_seluler->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
        <td<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jenis_pegawai->viewAttributes() ?>>
<?= $Page->Jenis_pegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
        <td<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status_pegawai->viewAttributes() ?>>
<?= $Page->Status_pegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
        <td<?= $Page->Golongan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Golongan->viewAttributes() ?>>
<?= $Page->Golongan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
        <td<?= $Page->Pangkat->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pangkat->viewAttributes() ?>>
<?= $Page->Pangkat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
        <td<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status_dosen->viewAttributes() ?>>
<?= $Page->Status_dosen->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
        <td<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status_Belajar->viewAttributes() ?>>
<?= $Page->Status_Belajar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
        <td<?= $Page->e_mail->cellAttributes() ?>>
<span id="">
<span<?= $Page->e_mail->viewAttributes() ?>>
<?= $Page->e_mail->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosendelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosendelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
