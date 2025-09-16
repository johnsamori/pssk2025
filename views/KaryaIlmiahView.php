<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KaryaIlmiahView = &$Page;
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
<form name="fkarya_ilmiahview" id="fkarya_ilmiahview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { karya_ilmiah: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fkarya_ilmiahview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkarya_ilmiahview")
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
<input type="hidden" name="t" value="karya_ilmiah">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Id_karya_ilmiah->Visible) { // Id_karya_ilmiah ?>
    <tr id="r_Id_karya_ilmiah"<?= $Page->Id_karya_ilmiah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Id_karya_ilmiah"><?= $Page->Id_karya_ilmiah->caption() ?></span></td>
        <td data-name="Id_karya_ilmiah"<?= $Page->Id_karya_ilmiah->cellAttributes() ?>>
<span id="el_karya_ilmiah_Id_karya_ilmiah">
<span<?= $Page->Id_karya_ilmiah->viewAttributes() ?>>
<?= $Page->Id_karya_ilmiah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_karya_ilmiah_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
    <tr id="r_Judul_Penelitian"<?= $Page->Judul_Penelitian->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Judul_Penelitian"><?= $Page->Judul_Penelitian->caption() ?></span></td>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el_karya_ilmiah_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
    <tr id="r_Pembimbing_1"<?= $Page->Pembimbing_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Pembimbing_1"><?= $Page->Pembimbing_1->caption() ?></span></td>
        <td data-name="Pembimbing_1"<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="el_karya_ilmiah_Pembimbing_1">
<span<?= $Page->Pembimbing_1->viewAttributes() ?>>
<?= $Page->Pembimbing_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
    <tr id="r_Pembimbing_2"<?= $Page->Pembimbing_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Pembimbing_2"><?= $Page->Pembimbing_2->caption() ?></span></td>
        <td data-name="Pembimbing_2"<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="el_karya_ilmiah_Pembimbing_2">
<span<?= $Page->Pembimbing_2->viewAttributes() ?>>
<?= $Page->Pembimbing_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
    <tr id="r_Pembimbing_3"<?= $Page->Pembimbing_3->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Pembimbing_3"><?= $Page->Pembimbing_3->caption() ?></span></td>
        <td data-name="Pembimbing_3"<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="el_karya_ilmiah_Pembimbing_3">
<span<?= $Page->Pembimbing_3->viewAttributes() ?>>
<?= $Page->Pembimbing_3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
    <tr id="r_Penguji_1"<?= $Page->Penguji_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Penguji_1"><?= $Page->Penguji_1->caption() ?></span></td>
        <td data-name="Penguji_1"<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="el_karya_ilmiah_Penguji_1">
<span<?= $Page->Penguji_1->viewAttributes() ?>>
<?= $Page->Penguji_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
    <tr id="r_Penguji_2"<?= $Page->Penguji_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Penguji_2"><?= $Page->Penguji_2->caption() ?></span></td>
        <td data-name="Penguji_2"<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="el_karya_ilmiah_Penguji_2">
<span<?= $Page->Penguji_2->viewAttributes() ?>>
<?= $Page->Penguji_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
    <tr id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Lembar_Pengesahan"><?= $Page->Lembar_Pengesahan->caption() ?></span></td>
        <td data-name="Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_karya_ilmiah_Lembar_Pengesahan">
<span<?= $Page->Lembar_Pengesahan->viewAttributes() ?>>
<?= GetFileViewTag($Page->Lembar_Pengesahan, $Page->Lembar_Pengesahan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
    <tr id="r_Judul_Publikasi"<?= $Page->Judul_Publikasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Judul_Publikasi"><?= $Page->Judul_Publikasi->caption() ?></span></td>
        <td data-name="Judul_Publikasi"<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="el_karya_ilmiah_Judul_Publikasi">
<span<?= $Page->Judul_Publikasi->viewAttributes() ?>>
<?= $Page->Judul_Publikasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
    <tr id="r_Link_Publikasi"<?= $Page->Link_Publikasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_Link_Publikasi"><?= $Page->Link_Publikasi->caption() ?></span></td>
        <td data-name="Link_Publikasi"<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="el_karya_ilmiah_Link_Publikasi">
<span<?= $Page->Link_Publikasi->viewAttributes() ?>>
<?= $Page->Link_Publikasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id"<?= $Page->user_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id"<?= $Page->user_id->cellAttributes() ?>>
<span id="el_karya_ilmiah_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_karya_ilmiah_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
    <tr id="r_ip"<?= $Page->ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_ip"><?= $Page->ip->caption() ?></span></td>
        <td data-name="ip"<?= $Page->ip->cellAttributes() ?>>
<span id="el_karya_ilmiah_ip">
<span<?= $Page->ip->viewAttributes() ?>>
<?= $Page->ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal"<?= $Page->tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_karya_ilmiah_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal"<?= $Page->tanggal->cellAttributes() ?>>
<span id="el_karya_ilmiah_tanggal">
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkarya_ilmiahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkarya_ilmiahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
