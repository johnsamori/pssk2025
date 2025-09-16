<?php

namespace PHPMaker2025\pssk2025;

// Page object
$MataKuliahView = &$Page;
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
<form name="fmata_kuliahview" id="fmata_kuliahview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mata_kuliah: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fmata_kuliahview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmata_kuliahview")
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
<input type="hidden" name="t" value="mata_kuliah">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id_mk->Visible) { // id_mk ?>
    <tr id="r_id_mk"<?= $Page->id_mk->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_id_mk"><?= $Page->id_mk->caption() ?></span></td>
        <td data-name="id_mk"<?= $Page->id_mk->cellAttributes() ?>>
<span id="el_mata_kuliah_id_mk">
<span<?= $Page->id_mk->viewAttributes() ?>>
<?= $Page->id_mk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
    <tr id="r_Kode_MK"<?= $Page->Kode_MK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_Kode_MK"><?= $Page->Kode_MK->caption() ?></span></td>
        <td data-name="Kode_MK"<?= $Page->Kode_MK->cellAttributes() ?>>
<span id="el_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Semester->Visible) { // Semester ?>
    <tr id="r_Semester"<?= $Page->Semester->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_Semester"><?= $Page->Semester->caption() ?></span></td>
        <td data-name="Semester"<?= $Page->Semester->cellAttributes() ?>>
<span id="el_mata_kuliah_Semester">
<span<?= $Page->Semester->viewAttributes() ?>>
<?= $Page->Semester->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tahun_Akademik->Visible) { // Tahun_Akademik ?>
    <tr id="r_Tahun_Akademik"<?= $Page->Tahun_Akademik->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_Tahun_Akademik"><?= $Page->Tahun_Akademik->caption() ?></span></td>
        <td data-name="Tahun_Akademik"<?= $Page->Tahun_Akademik->cellAttributes() ?>>
<span id="el_mata_kuliah_Tahun_Akademik">
<span<?= $Page->Tahun_Akademik->viewAttributes() ?>>
<?= $Page->Tahun_Akademik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Dosen->Visible) { // Dosen ?>
    <tr id="r_Dosen"<?= $Page->Dosen->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_Dosen"><?= $Page->Dosen->caption() ?></span></td>
        <td data-name="Dosen"<?= $Page->Dosen->cellAttributes() ?>>
<span id="el_mata_kuliah_Dosen">
<span<?= $Page->Dosen->viewAttributes() ?>>
<?= $Page->Dosen->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_mata_kuliah_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Ip->Visible) { // Ip ?>
    <tr id="r_Ip"<?= $Page->Ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_Ip"><?= $Page->Ip->caption() ?></span></td>
        <td data-name="Ip"<?= $Page->Ip->cellAttributes() ?>>
<span id="el_mata_kuliah_Ip">
<span<?= $Page->Ip->viewAttributes() ?>>
<?= $Page->Ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_mata_kuliah_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->iduser->Visible) { // iduser ?>
    <tr id="r_iduser"<?= $Page->iduser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mata_kuliah_iduser"><?= $Page->iduser->caption() ?></span></td>
        <td data-name="iduser"<?= $Page->iduser->cellAttributes() ?>>
<span id="el_mata_kuliah_iduser">
<span<?= $Page->iduser->viewAttributes() ?>>
<?= $Page->iduser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("detil_mata_kuliah", explode(",", $Page->getCurrentDetailTable())) && $detil_mata_kuliah->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php if (Container("detil_mata_kuliah")->Count > 0) { // Begin of added by Masino Sinaga, September 16, 2023 ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_mata_kuliah", "TblCaption") ?></h4>
<?php } else { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_mata_kuliah", "TblCaption") ?></h4>
<?php } // End of added by Masino Sinaga, September 16, 2023 ?>
<?php } ?>
<?php include_once "DetilMataKuliahGrid.php" ?>
<?php } ?>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmata_kuliahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmata_kuliahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmata_kuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmata_kuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
