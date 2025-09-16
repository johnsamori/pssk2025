<?php

namespace PHPMaker2025\pssk2025;

// Page object
$PembimbinganView = &$Page;
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
<form name="fpembimbinganview" id="fpembimbinganview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pembimbingan: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fpembimbinganview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpembimbinganview")
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
<input type="hidden" name="t" value="pembimbingan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id_pem->Visible) { // id_pem ?>
    <tr id="r_id_pem"<?= $Page->id_pem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_id_pem"><?= $Page->id_pem->caption() ?></span></td>
        <td data-name="id_pem"<?= $Page->id_pem->cellAttributes() ?>>
<span id="el_pembimbingan_id_pem">
<span<?= $Page->id_pem->viewAttributes() ?>>
<?= $Page->id_pem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIP_Dosen_Pembimbing->Visible) { // NIP_Dosen_Pembimbing ?>
    <tr id="r_NIP_Dosen_Pembimbing"<?= $Page->NIP_Dosen_Pembimbing->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_NIP_Dosen_Pembimbing"><?= $Page->NIP_Dosen_Pembimbing->caption() ?></span></td>
        <td data-name="NIP_Dosen_Pembimbing"<?= $Page->NIP_Dosen_Pembimbing->cellAttributes() ?>>
<span id="el_pembimbingan_NIP_Dosen_Pembimbing">
<span<?= $Page->NIP_Dosen_Pembimbing->viewAttributes() ?>>
<?= $Page->NIP_Dosen_Pembimbing->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_pembimbingan_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Catatan_Mahasiswa->Visible) { // Catatan_Mahasiswa ?>
    <tr id="r_Catatan_Mahasiswa"<?= $Page->Catatan_Mahasiswa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Catatan_Mahasiswa"><?= $Page->Catatan_Mahasiswa->caption() ?></span></td>
        <td data-name="Catatan_Mahasiswa"<?= $Page->Catatan_Mahasiswa->cellAttributes() ?>>
<span id="el_pembimbingan_Catatan_Mahasiswa">
<span<?= $Page->Catatan_Mahasiswa->viewAttributes() ?>>
<?= $Page->Catatan_Mahasiswa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Catatan_Dosen_Wali->Visible) { // Catatan_Dosen_Wali ?>
    <tr id="r_Catatan_Dosen_Wali"<?= $Page->Catatan_Dosen_Wali->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Catatan_Dosen_Wali"><?= $Page->Catatan_Dosen_Wali->caption() ?></span></td>
        <td data-name="Catatan_Dosen_Wali"<?= $Page->Catatan_Dosen_Wali->cellAttributes() ?>>
<span id="el_pembimbingan_Catatan_Dosen_Wali">
<span<?= $Page->Catatan_Dosen_Wali->viewAttributes() ?>>
<?= $Page->Catatan_Dosen_Wali->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rekomendasi_Unit_BK->Visible) { // Rekomendasi_Unit_BK ?>
    <tr id="r_Rekomendasi_Unit_BK"<?= $Page->Rekomendasi_Unit_BK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Rekomendasi_Unit_BK"><?= $Page->Rekomendasi_Unit_BK->caption() ?></span></td>
        <td data-name="Rekomendasi_Unit_BK"<?= $Page->Rekomendasi_Unit_BK->cellAttributes() ?>>
<span id="el_pembimbingan_Rekomendasi_Unit_BK">
<span<?= $Page->Rekomendasi_Unit_BK->viewAttributes() ?>>
<?= $Page->Rekomendasi_Unit_BK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_IP_Semester->Visible) { // Nilai_IP_Semester ?>
    <tr id="r_Nilai_IP_Semester"<?= $Page->Nilai_IP_Semester->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Nilai_IP_Semester"><?= $Page->Nilai_IP_Semester->caption() ?></span></td>
        <td data-name="Nilai_IP_Semester"<?= $Page->Nilai_IP_Semester->cellAttributes() ?>>
<span id="el_pembimbingan_Nilai_IP_Semester">
<span<?= $Page->Nilai_IP_Semester->viewAttributes() ?>>
<?= $Page->Nilai_IP_Semester->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_IPK->Visible) { // Nilai_IPK ?>
    <tr id="r_Nilai_IPK"<?= $Page->Nilai_IPK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Nilai_IPK"><?= $Page->Nilai_IPK->caption() ?></span></td>
        <td data-name="Nilai_IPK"<?= $Page->Nilai_IPK->cellAttributes() ?>>
<span id="el_pembimbingan_Nilai_IPK">
<span<?= $Page->Nilai_IPK->viewAttributes() ?>>
<?= $Page->Nilai_IPK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Surat_Peringatan->Visible) { // Surat_Peringatan ?>
    <tr id="r_Surat_Peringatan"<?= $Page->Surat_Peringatan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Surat_Peringatan"><?= $Page->Surat_Peringatan->caption() ?></span></td>
        <td data-name="Surat_Peringatan"<?= $Page->Surat_Peringatan->cellAttributes() ?>>
<span id="el_pembimbingan_Surat_Peringatan">
<span<?= $Page->Surat_Peringatan->viewAttributes() ?>>
<?= $Page->Surat_Peringatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Surat_Pemberitahuan->Visible) { // Surat_Pemberitahuan ?>
    <tr id="r_Surat_Pemberitahuan"<?= $Page->Surat_Pemberitahuan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Surat_Pemberitahuan"><?= $Page->Surat_Pemberitahuan->caption() ?></span></td>
        <td data-name="Surat_Pemberitahuan"<?= $Page->Surat_Pemberitahuan->cellAttributes() ?>>
<span id="el_pembimbingan_Surat_Pemberitahuan">
<span<?= $Page->Surat_Pemberitahuan->viewAttributes() ?>>
<?= $Page->Surat_Pemberitahuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rekomendasi_Akhir->Visible) { // Rekomendasi_Akhir ?>
    <tr id="r_Rekomendasi_Akhir"<?= $Page->Rekomendasi_Akhir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Rekomendasi_Akhir"><?= $Page->Rekomendasi_Akhir->caption() ?></span></td>
        <td data-name="Rekomendasi_Akhir"<?= $Page->Rekomendasi_Akhir->cellAttributes() ?>>
<span id="el_pembimbingan_Rekomendasi_Akhir">
<span<?= $Page->Rekomendasi_Akhir->viewAttributes() ?>>
<?= $Page->Rekomendasi_Akhir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_pembimbingan_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Ip->Visible) { // Ip ?>
    <tr id="r_Ip"<?= $Page->Ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_Ip"><?= $Page->Ip->caption() ?></span></td>
        <td data-name="Ip"<?= $Page->Ip->cellAttributes() ?>>
<span id="el_pembimbingan_Ip">
<span<?= $Page->Ip->viewAttributes() ?>>
<?= $Page->Ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_pembimbingan_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->iduser->Visible) { // iduser ?>
    <tr id="r_iduser"<?= $Page->iduser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembimbingan_iduser"><?= $Page->iduser->caption() ?></span></td>
        <td data-name="iduser"<?= $Page->iduser->cellAttributes() ?>>
<span id="el_pembimbingan_iduser">
<span<?= $Page->iduser->viewAttributes() ?>>
<?= $Page->iduser->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fpembimbinganadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fpembimbinganadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fpembimbinganedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fpembimbinganedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
