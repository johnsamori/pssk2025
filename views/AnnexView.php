<?php

namespace PHPMaker2025\pssk2025;

// Page object
$AnnexView = &$Page;
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
<form name="fannexview" id="fannexview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { annex: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fannexview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fannexview")
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
<input type="hidden" name="t" value="annex">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->No->Visible) { // No ?>
    <tr id="r_No"<?= $Page->No->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_annex_No"><?= $Page->No->caption() ?></span></td>
        <td data-name="No"<?= $Page->No->cellAttributes() ?>>
<span id="el_annex_No">
<span<?= $Page->No->viewAttributes() ?>>
<?= $Page->No->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Peraturan_Akdemik_Universitas->Visible) { // Peraturan_Akdemik_Universitas ?>
    <tr id="r_Peraturan_Akdemik_Universitas"<?= $Page->Peraturan_Akdemik_Universitas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_annex_Peraturan_Akdemik_Universitas"><?= $Page->Peraturan_Akdemik_Universitas->caption() ?></span></td>
        <td data-name="Peraturan_Akdemik_Universitas"<?= $Page->Peraturan_Akdemik_Universitas->cellAttributes() ?>>
<span id="el_annex_Peraturan_Akdemik_Universitas">
<span<?= $Page->Peraturan_Akdemik_Universitas->viewAttributes() ?>>
<?= $Page->Peraturan_Akdemik_Universitas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pedoman_Pelaksanaan_Peraturan_Akademik->Visible) { // Pedoman_Pelaksanaan_Peraturan_Akademik ?>
    <tr id="r_Pedoman_Pelaksanaan_Peraturan_Akademik"<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_annex_Pedoman_Pelaksanaan_Peraturan_Akademik"><?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->caption() ?></span></td>
        <td data-name="Pedoman_Pelaksanaan_Peraturan_Akademik"<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->cellAttributes() ?>>
<span id="el_annex_Pedoman_Pelaksanaan_Peraturan_Akademik">
<span<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->viewAttributes() ?>>
<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Rubrik_Penilaian->Visible) { // Rubrik_Penilaian ?>
    <tr id="r_Rubrik_Penilaian"<?= $Page->Rubrik_Penilaian->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_annex_Rubrik_Penilaian"><?= $Page->Rubrik_Penilaian->caption() ?></span></td>
        <td data-name="Rubrik_Penilaian"<?= $Page->Rubrik_Penilaian->cellAttributes() ?>>
<span id="el_annex_Rubrik_Penilaian">
<span<?= $Page->Rubrik_Penilaian->viewAttributes() ?>>
<?= $Page->Rubrik_Penilaian->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Panduan_Penulisan_KTI->Visible) { // Panduan_Penulisan_KTI ?>
    <tr id="r_Panduan_Penulisan_KTI"<?= $Page->Panduan_Penulisan_KTI->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_annex_Panduan_Penulisan_KTI"><?= $Page->Panduan_Penulisan_KTI->caption() ?></span></td>
        <td data-name="Panduan_Penulisan_KTI"<?= $Page->Panduan_Penulisan_KTI->cellAttributes() ?>>
<span id="el_annex_Panduan_Penulisan_KTI">
<span<?= $Page->Panduan_Penulisan_KTI->viewAttributes() ?>>
<?= $Page->Panduan_Penulisan_KTI->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fannexadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fannexadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fannexedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fannexedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
