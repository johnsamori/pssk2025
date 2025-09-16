<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KemahasiswaanView = &$Page;
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
<form name="fkemahasiswaanview" id="fkemahasiswaanview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kemahasiswaan: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fkemahasiswaanview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkemahasiswaanview")
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
<input type="hidden" name="t" value="kemahasiswaan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id_kemahasiswaan->Visible) { // id_kemahasiswaan ?>
    <tr id="r_id_kemahasiswaan"<?= $Page->id_kemahasiswaan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_id_kemahasiswaan"><?= $Page->id_kemahasiswaan->caption() ?></span></td>
        <td data-name="id_kemahasiswaan"<?= $Page->id_kemahasiswaan->cellAttributes() ?>>
<span id="el_kemahasiswaan_id_kemahasiswaan">
<span<?= $Page->id_kemahasiswaan->viewAttributes() ?>>
<?= $Page->id_kemahasiswaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_kemahasiswaan_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenis_Beasiswa->Visible) { // Jenis_Beasiswa ?>
    <tr id="r_Jenis_Beasiswa"<?= $Page->Jenis_Beasiswa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_Jenis_Beasiswa"><?= $Page->Jenis_Beasiswa->caption() ?></span></td>
        <td data-name="Jenis_Beasiswa"<?= $Page->Jenis_Beasiswa->cellAttributes() ?>>
<span id="el_kemahasiswaan_Jenis_Beasiswa">
<span<?= $Page->Jenis_Beasiswa->viewAttributes() ?>>
<?= $Page->Jenis_Beasiswa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sumber_beasiswa->Visible) { // Sumber_beasiswa ?>
    <tr id="r_Sumber_beasiswa"<?= $Page->Sumber_beasiswa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_Sumber_beasiswa"><?= $Page->Sumber_beasiswa->caption() ?></span></td>
        <td data-name="Sumber_beasiswa"<?= $Page->Sumber_beasiswa->cellAttributes() ?>>
<span id="el_kemahasiswaan_Sumber_beasiswa">
<span<?= $Page->Sumber_beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_beasiswa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Kegiatan->Visible) { // Nama_Kegiatan ?>
    <tr id="r_Nama_Kegiatan"<?= $Page->Nama_Kegiatan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_Nama_Kegiatan"><?= $Page->Nama_Kegiatan->caption() ?></span></td>
        <td data-name="Nama_Kegiatan"<?= $Page->Nama_Kegiatan->cellAttributes() ?>>
<span id="el_kemahasiswaan_Nama_Kegiatan">
<span<?= $Page->Nama_Kegiatan->viewAttributes() ?>>
<?= $Page->Nama_Kegiatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Penghargaan_YangDiterima->Visible) { // Nama_Penghargaan_Yang Diterima ?>
    <tr id="r_Nama_Penghargaan_YangDiterima"<?= $Page->Nama_Penghargaan_YangDiterima->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_Nama_Penghargaan_YangDiterima"><?= $Page->Nama_Penghargaan_YangDiterima->caption() ?></span></td>
        <td data-name="Nama_Penghargaan_YangDiterima"<?= $Page->Nama_Penghargaan_YangDiterima->cellAttributes() ?>>
<span id="el_kemahasiswaan_Nama_Penghargaan_YangDiterima">
<span<?= $Page->Nama_Penghargaan_YangDiterima->viewAttributes() ?>>
<?= $Page->Nama_Penghargaan_YangDiterima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sertifikat->Visible) { // Sertifikat ?>
    <tr id="r_Sertifikat"<?= $Page->Sertifikat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_Sertifikat"><?= $Page->Sertifikat->caption() ?></span></td>
        <td data-name="Sertifikat"<?= $Page->Sertifikat->cellAttributes() ?>>
<span id="el_kemahasiswaan_Sertifikat">
<span<?= $Page->Sertifikat->viewAttributes() ?>>
<?= $Page->Sertifikat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->userid->Visible) { // userid ?>
    <tr id="r_userid"<?= $Page->userid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_userid"><?= $Page->userid->caption() ?></span></td>
        <td data-name="userid"<?= $Page->userid->cellAttributes() ?>>
<span id="el_kemahasiswaan_userid">
<span<?= $Page->userid->viewAttributes() ?>>
<?= $Page->userid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_kemahasiswaan_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
    <tr id="r_ip"<?= $Page->ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_ip"><?= $Page->ip->caption() ?></span></td>
        <td data-name="ip"<?= $Page->ip->cellAttributes() ?>>
<span id="el_kemahasiswaan_ip">
<span<?= $Page->ip->viewAttributes() ?>>
<?= $Page->ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal"<?= $Page->tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kemahasiswaan_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal"<?= $Page->tanggal->cellAttributes() ?>>
<span id="el_kemahasiswaan_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkemahasiswaanadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkemahasiswaanadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkemahasiswaanedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkemahasiswaanedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
