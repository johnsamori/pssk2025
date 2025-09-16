<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilMataKuliahView = &$Page;
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
<form name="fdetil_mata_kuliahview" id="fdetil_mata_kuliahview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdetil_mata_kuliahview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_mata_kuliahview")
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
<input type="hidden" name="t" value="detil_mata_kuliah">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id_no->Visible) { // id_no ?>
    <tr id="r_id_no"<?= $Page->id_no->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_id_no"><?= $Page->id_no->caption() ?></span></td>
        <td data-name="id_no"<?= $Page->id_no->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<?= $Page->id_no->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
    <tr id="r_Kode_MK"<?= $Page->Kode_MK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Kode_MK"><?= $Page->Kode_MK->caption() ?></span></td>
        <td data-name="Kode_MK"<?= $Page->Kode_MK->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Kode_MK">
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<?= $Page->Kode_MK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
    <tr id="r_Nilai_Diskusi"<?= $Page->Nilai_Diskusi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Nilai_Diskusi"><?= $Page->Nilai_Diskusi->caption() ?></span></td>
        <td data-name="Nilai_Diskusi"<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_Diskusi">
<span<?= $Page->Nilai_Diskusi->viewAttributes() ?>>
<?= $Page->Nilai_Diskusi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
    <tr id="r_Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Assessment_Skor_As_1"><?= $Page->Assessment_Skor_As_1->caption() ?></span></td>
        <td data-name="Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Assessment_Skor_As_1">
<span<?= $Page->Assessment_Skor_As_1->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
    <tr id="r_Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Assessment_Skor_As_2"><?= $Page->Assessment_Skor_As_2->caption() ?></span></td>
        <td data-name="Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Assessment_Skor_As_2">
<span<?= $Page->Assessment_Skor_As_2->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
    <tr id="r_Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Assessment_Skor_As_3"><?= $Page->Assessment_Skor_As_3->caption() ?></span></td>
        <td data-name="Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Assessment_Skor_As_3">
<span<?= $Page->Assessment_Skor_As_3->viewAttributes() ?>>
<?= $Page->Assessment_Skor_As_3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
    <tr id="r_Nilai_Tugas"<?= $Page->Nilai_Tugas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Nilai_Tugas"><?= $Page->Nilai_Tugas->caption() ?></span></td>
        <td data-name="Nilai_Tugas"<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_Tugas">
<span<?= $Page->Nilai_Tugas->viewAttributes() ?>>
<?= $Page->Nilai_Tugas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
    <tr id="r_Nilai_UTS"<?= $Page->Nilai_UTS->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Nilai_UTS"><?= $Page->Nilai_UTS->caption() ?></span></td>
        <td data-name="Nilai_UTS"<?= $Page->Nilai_UTS->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_UTS">
<span<?= $Page->Nilai_UTS->viewAttributes() ?>>
<?= $Page->Nilai_UTS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
    <tr id="r_Nilai_Akhir"<?= $Page->Nilai_Akhir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_Nilai_Akhir"><?= $Page->Nilai_Akhir->caption() ?></span></td>
        <td data-name="Nilai_Akhir"<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_Akhir">
<span<?= $Page->Nilai_Akhir->viewAttributes() ?>>
<?= $Page->Nilai_Akhir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->iduser->Visible) { // iduser ?>
    <tr id="r_iduser"<?= $Page->iduser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_iduser"><?= $Page->iduser->caption() ?></span></td>
        <td data-name="iduser"<?= $Page->iduser->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_iduser">
<span<?= $Page->iduser->viewAttributes() ?>>
<?= $Page->iduser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
    <tr id="r_ip"<?= $Page->ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_ip"><?= $Page->ip->caption() ?></span></td>
        <td data-name="ip"<?= $Page->ip->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_ip">
<span<?= $Page->ip->viewAttributes() ?>>
<?= $Page->ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal"<?= $Page->tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_detil_mata_kuliah_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal"<?= $Page->tanggal->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
