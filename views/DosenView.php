<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DosenView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<?php // Begin of Card view by Masino Sinaga, September 10, 2023 ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("ViewCaption"); ?></h4>
	  <div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
	  </button>
	  </div>
	  <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
<?php } ?>
<?php // End of Card view by Masino Sinaga, September 10, 2023 ?>
<form name="fdosenview" id="fdosenview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdosenview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdosenview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="dosen">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->No->Visible) { // No ?>
    <tr id="r_No"<?= $Page->No->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_No"><?= $Page->No->caption() ?></span></td>
        <td data-name="No"<?= $Page->No->cellAttributes() ?>>
<span id="el_dosen_No">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
    <tr id="r_NIP"<?= $Page->NIP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_NIP"><?= $Page->NIP->caption() ?></span></td>
        <td data-name="NIP"<?= $Page->NIP->cellAttributes() ?>>
<span id="el_dosen_NIP">
<span<?= $Page->NIP->viewAttributes() ?>>
<?= $Page->NIP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
    <tr id="r_NIDN"<?= $Page->NIDN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_NIDN"><?= $Page->NIDN->caption() ?></span></td>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
    <tr id="r_Nama_Lengkap"<?= $Page->Nama_Lengkap->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Nama_Lengkap"><?= $Page->Nama_Lengkap->caption() ?></span></td>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
    <tr id="r_Gelar_Depan"<?= $Page->Gelar_Depan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Gelar_Depan"><?= $Page->Gelar_Depan->caption() ?></span></td>
        <td data-name="Gelar_Depan"<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="el_dosen_Gelar_Depan">
<span<?= $Page->Gelar_Depan->viewAttributes() ?>>
<?= $Page->Gelar_Depan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
    <tr id="r_Gelar_Belakang"<?= $Page->Gelar_Belakang->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Gelar_Belakang"><?= $Page->Gelar_Belakang->caption() ?></span></td>
        <td data-name="Gelar_Belakang"<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="el_dosen_Gelar_Belakang">
<span<?= $Page->Gelar_Belakang->viewAttributes() ?>>
<?= $Page->Gelar_Belakang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
    <tr id="r_Program_studi"<?= $Page->Program_studi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Program_studi"><?= $Page->Program_studi->caption() ?></span></td>
        <td data-name="Program_studi"<?= $Page->Program_studi->cellAttributes() ?>>
<span id="el_dosen_Program_studi">
<span<?= $Page->Program_studi->viewAttributes() ?>>
<?= $Page->Program_studi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
    <tr id="r_NIK"<?= $Page->NIK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_NIK"><?= $Page->NIK->caption() ?></span></td>
        <td data-name="NIK"<?= $Page->NIK->cellAttributes() ?>>
<span id="el_dosen_NIK">
<span<?= $Page->NIK->viewAttributes() ?>>
<?= $Page->NIK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
    <tr id="r_Tanggal_lahir"<?= $Page->Tanggal_lahir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Tanggal_lahir"><?= $Page->Tanggal_lahir->caption() ?></span></td>
        <td data-name="Tanggal_lahir"<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="el_dosen_Tanggal_lahir">
<span<?= $Page->Tanggal_lahir->viewAttributes() ?>>
<?= $Page->Tanggal_lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
    <tr id="r_Tempat_lahir"<?= $Page->Tempat_lahir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Tempat_lahir"><?= $Page->Tempat_lahir->caption() ?></span></td>
        <td data-name="Tempat_lahir"<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="el_dosen_Tempat_lahir">
<span<?= $Page->Tempat_lahir->viewAttributes() ?>>
<?= $Page->Tempat_lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
    <tr id="r_Nomor_Karpeg"<?= $Page->Nomor_Karpeg->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Nomor_Karpeg"><?= $Page->Nomor_Karpeg->caption() ?></span></td>
        <td data-name="Nomor_Karpeg"<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="el_dosen_Nomor_Karpeg">
<span<?= $Page->Nomor_Karpeg->viewAttributes() ?>>
<?= $Page->Nomor_Karpeg->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
    <tr id="r_Nomor_Stambuk"<?= $Page->Nomor_Stambuk->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Nomor_Stambuk"><?= $Page->Nomor_Stambuk->caption() ?></span></td>
        <td data-name="Nomor_Stambuk"<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="el_dosen_Nomor_Stambuk">
<span<?= $Page->Nomor_Stambuk->viewAttributes() ?>>
<?= $Page->Nomor_Stambuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
    <tr id="r_Jenis_kelamin"<?= $Page->Jenis_kelamin->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jenis_kelamin"><?= $Page->Jenis_kelamin->caption() ?></span></td>
        <td data-name="Jenis_kelamin"<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="el_dosen_Jenis_kelamin">
<span<?= $Page->Jenis_kelamin->viewAttributes() ?>>
<?= $Page->Jenis_kelamin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
    <tr id="r_Gol_Darah"<?= $Page->Gol_Darah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Gol_Darah"><?= $Page->Gol_Darah->caption() ?></span></td>
        <td data-name="Gol_Darah"<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="el_dosen_Gol_Darah">
<span<?= $Page->Gol_Darah->viewAttributes() ?>>
<?= $Page->Gol_Darah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
    <tr id="r_Agama"<?= $Page->Agama->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Agama"><?= $Page->Agama->caption() ?></span></td>
        <td data-name="Agama"<?= $Page->Agama->cellAttributes() ?>>
<span id="el_dosen_Agama">
<span<?= $Page->Agama->viewAttributes() ?>>
<?= $Page->Agama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
    <tr id="r_Stattus_menikah"<?= $Page->Stattus_menikah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Stattus_menikah"><?= $Page->Stattus_menikah->caption() ?></span></td>
        <td data-name="Stattus_menikah"<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="el_dosen_Stattus_menikah">
<span<?= $Page->Stattus_menikah->viewAttributes() ?>>
<?= $Page->Stattus_menikah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
    <tr id="r_Alamat"<?= $Page->Alamat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Alamat"><?= $Page->Alamat->caption() ?></span></td>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
    <tr id="r_Kota"<?= $Page->Kota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Kota"><?= $Page->Kota->caption() ?></span></td>
        <td data-name="Kota"<?= $Page->Kota->cellAttributes() ?>>
<span id="el_dosen_Kota">
<span<?= $Page->Kota->viewAttributes() ?>>
<?= $Page->Kota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
    <tr id="r_Telepon_seluler"<?= $Page->Telepon_seluler->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Telepon_seluler"><?= $Page->Telepon_seluler->caption() ?></span></td>
        <td data-name="Telepon_seluler"<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="el_dosen_Telepon_seluler">
<span<?= $Page->Telepon_seluler->viewAttributes() ?>>
<?= $Page->Telepon_seluler->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
    <tr id="r_Jenis_pegawai"<?= $Page->Jenis_pegawai->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Jenis_pegawai"><?= $Page->Jenis_pegawai->caption() ?></span></td>
        <td data-name="Jenis_pegawai"<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="el_dosen_Jenis_pegawai">
<span<?= $Page->Jenis_pegawai->viewAttributes() ?>>
<?= $Page->Jenis_pegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
    <tr id="r_Status_pegawai"<?= $Page->Status_pegawai->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Status_pegawai"><?= $Page->Status_pegawai->caption() ?></span></td>
        <td data-name="Status_pegawai"<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="el_dosen_Status_pegawai">
<span<?= $Page->Status_pegawai->viewAttributes() ?>>
<?= $Page->Status_pegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
    <tr id="r_Golongan"<?= $Page->Golongan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Golongan"><?= $Page->Golongan->caption() ?></span></td>
        <td data-name="Golongan"<?= $Page->Golongan->cellAttributes() ?>>
<span id="el_dosen_Golongan">
<span<?= $Page->Golongan->viewAttributes() ?>>
<?= $Page->Golongan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
    <tr id="r_Pangkat"<?= $Page->Pangkat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Pangkat"><?= $Page->Pangkat->caption() ?></span></td>
        <td data-name="Pangkat"<?= $Page->Pangkat->cellAttributes() ?>>
<span id="el_dosen_Pangkat">
<span<?= $Page->Pangkat->viewAttributes() ?>>
<?= $Page->Pangkat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
    <tr id="r_Status_dosen"<?= $Page->Status_dosen->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Status_dosen"><?= $Page->Status_dosen->caption() ?></span></td>
        <td data-name="Status_dosen"<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="el_dosen_Status_dosen">
<span<?= $Page->Status_dosen->viewAttributes() ?>>
<?= $Page->Status_dosen->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
    <tr id="r_Status_Belajar"<?= $Page->Status_Belajar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_Status_Belajar"><?= $Page->Status_Belajar->caption() ?></span></td>
        <td data-name="Status_Belajar"<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="el_dosen_Status_Belajar">
<span<?= $Page->Status_Belajar->viewAttributes() ?>>
<?= $Page->Status_Belajar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
    <tr id="r_e_mail"<?= $Page->e_mail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_dosen_e_mail"><?= $Page->e_mail->caption() ?></span></td>
        <td data-name="e_mail"<?= $Page->e_mail->cellAttributes() ?>>
<span id="el_dosen_e_mail">
<span<?= $Page->e_mail->viewAttributes() ?>>
<?= $Page->e_mail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php // Begin of Card view by Masino Sinaga, September 10, 2023 ?>
<?php if (!$Page->IsModal) { ?>
		</div>
     <!-- /.card-body -->
     </div>
  <!-- /.card -->
</div>
<?php } ?>
<?php // End of Card view by Masino Sinaga, September 10, 2023 ?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
