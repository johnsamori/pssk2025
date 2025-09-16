<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KesehatanMahasiswaView = &$Page;
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
<form name="fkesehatan_mahasiswaview" id="fkesehatan_mahasiswaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kesehatan_mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fkesehatan_mahasiswaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkesehatan_mahasiswaview")
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
<input type="hidden" name="t" value="kesehatan_mahasiswa">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Id_kesehatan->Visible) { // Id_kesehatan ?>
    <tr id="r_Id_kesehatan"<?= $Page->Id_kesehatan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Id_kesehatan"><?= $Page->Id_kesehatan->caption() ?></span></td>
        <td data-name="Id_kesehatan"<?= $Page->Id_kesehatan->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Id_kesehatan">
<span<?= $Page->Id_kesehatan->viewAttributes() ?>>
<?= $Page->Id_kesehatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Dokter_Penanggung_Jawab->Visible) { // Dokter_Penanggung_Jawab ?>
    <tr id="r_Dokter_Penanggung_Jawab"<?= $Page->Dokter_Penanggung_Jawab->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Dokter_Penanggung_Jawab"><?= $Page->Dokter_Penanggung_Jawab->caption() ?></span></td>
        <td data-name="Dokter_Penanggung_Jawab"<?= $Page->Dokter_Penanggung_Jawab->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Dokter_Penanggung_Jawab">
<span<?= $Page->Dokter_Penanggung_Jawab->viewAttributes() ?>>
<?= $Page->Dokter_Penanggung_Jawab->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nomor_SIP->Visible) { // Nomor_SIP ?>
    <tr id="r_Nomor_SIP"<?= $Page->Nomor_SIP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Nomor_SIP"><?= $Page->Nomor_SIP->caption() ?></span></td>
        <td data-name="Nomor_SIP"<?= $Page->Nomor_SIP->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Nomor_SIP">
<span<?= $Page->Nomor_SIP->viewAttributes() ?>>
<?= $Page->Nomor_SIP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Diagnosa->Visible) { // Diagnosa ?>
    <tr id="r_Diagnosa"<?= $Page->Diagnosa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Diagnosa"><?= $Page->Diagnosa->caption() ?></span></td>
        <td data-name="Diagnosa"<?= $Page->Diagnosa->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Diagnosa">
<span<?= $Page->Diagnosa->viewAttributes() ?>>
<?= $Page->Diagnosa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rekomendasi_Dokter->Visible) { // Rekomendasi_Dokter ?>
    <tr id="r_Rekomendasi_Dokter"<?= $Page->Rekomendasi_Dokter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Rekomendasi_Dokter"><?= $Page->Rekomendasi_Dokter->caption() ?></span></td>
        <td data-name="Rekomendasi_Dokter"<?= $Page->Rekomendasi_Dokter->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Rekomendasi_Dokter">
<span<?= $Page->Rekomendasi_Dokter->viewAttributes() ?>>
<?= $Page->Rekomendasi_Dokter->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Ip->Visible) { // Ip ?>
    <tr id="r_Ip"<?= $Page->Ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_Ip"><?= $Page->Ip->caption() ?></span></td>
        <td data-name="Ip"<?= $Page->Ip->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Ip">
<span<?= $Page->Ip->viewAttributes() ?>>
<?= $Page->Ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id"<?= $Page->user_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kesehatan_mahasiswa_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id"<?= $Page->user_id->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkesehatan_mahasiswaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkesehatan_mahasiswaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkesehatan_mahasiswaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkesehatan_mahasiswaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
