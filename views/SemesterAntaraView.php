<?php

namespace PHPMaker2025\pssk2025;

// Page object
$SemesterAntaraView = &$Page;
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
<form name="fsemester_antaraview" id="fsemester_antaraview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { semester_antara: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsemester_antaraview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsemester_antaraview")
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
<input type="hidden" name="t" value="semester_antara">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id_smtr->Visible) { // id_smtr ?>
    <tr id="r_id_smtr"<?= $Page->id_smtr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_id_smtr"><?= $Page->id_smtr->caption() ?></span></td>
        <td data-name="id_smtr"<?= $Page->id_smtr->cellAttributes() ?>>
<span id="el_semester_antara_id_smtr">
<span<?= $Page->id_smtr->viewAttributes() ?>>
<?= $Page->id_smtr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Semester->Visible) { // Semester ?>
    <tr id="r_Semester"<?= $Page->Semester->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_Semester"><?= $Page->Semester->caption() ?></span></td>
        <td data-name="Semester"<?= $Page->Semester->cellAttributes() ?>>
<span id="el_semester_antara_Semester">
<span<?= $Page->Semester->viewAttributes() ?>>
<?= $Page->Semester->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jadwal->Visible) { // Jadwal ?>
    <tr id="r_Jadwal"<?= $Page->Jadwal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_Jadwal"><?= $Page->Jadwal->caption() ?></span></td>
        <td data-name="Jadwal"<?= $Page->Jadwal->cellAttributes() ?>>
<span id="el_semester_antara_Jadwal">
<span<?= $Page->Jadwal->viewAttributes() ?>>
<?= $Page->Jadwal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tahun_Akademik->Visible) { // Tahun_Akademik ?>
    <tr id="r_Tahun_Akademik"<?= $Page->Tahun_Akademik->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_Tahun_Akademik"><?= $Page->Tahun_Akademik->caption() ?></span></td>
        <td data-name="Tahun_Akademik"<?= $Page->Tahun_Akademik->cellAttributes() ?>>
<span id="el_semester_antara_Tahun_Akademik">
<span<?= $Page->Tahun_Akademik->viewAttributes() ?>>
<?= $Page->Tahun_Akademik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_semester_antara_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->User_id->Visible) { // User_id ?>
    <tr id="r_User_id"<?= $Page->User_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_User_id"><?= $Page->User_id->caption() ?></span></td>
        <td data-name="User_id"<?= $Page->User_id->cellAttributes() ?>>
<span id="el_semester_antara_User_id">
<span<?= $Page->User_id->viewAttributes() ?>>
<?= $Page->User_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
    <tr id="r_User"<?= $Page->User->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_User"><?= $Page->User->caption() ?></span></td>
        <td data-name="User"<?= $Page->User->cellAttributes() ?>>
<span id="el_semester_antara_User">
<span<?= $Page->User->viewAttributes() ?>>
<?= $Page->User->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <tr id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_semester_antara_IP"><?= $Page->IP->caption() ?></span></td>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<span id="el_semester_antara_IP">
<span<?= $Page->IP->viewAttributes() ?>>
<?= $Page->IP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("detil_semester_antara", explode(",", $Page->getCurrentDetailTable())) && $detil_semester_antara->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php if (Container("detil_semester_antara")->Count > 0) { // Begin of added by Masino Sinaga, September 16, 2023 ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_semester_antara", "TblCaption") ?></h4>
<?php } else { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_semester_antara", "TblCaption") ?></h4>
<?php } // End of added by Masino Sinaga, September 16, 2023 ?>
<?php } ?>
<?php include_once "DetilSemesterAntaraGrid.php" ?>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fsemester_antaraadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fsemester_antaraadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fsemester_antaraedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fsemester_antaraedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
