<?php

namespace PHPMaker2025\pssk2025;

// Page object
$CutiAkademikView = &$Page;
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
<form name="fcuti_akademikview" id="fcuti_akademikview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cuti_akademik: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcuti_akademikview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcuti_akademikview")
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
<input type="hidden" name="t" value="cuti_akademik">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id_ca->Visible) { // id_ca ?>
    <tr id="r_id_ca"<?= $Page->id_ca->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_id_ca"><?= $Page->id_ca->caption() ?></span></td>
        <td data-name="id_ca"<?= $Page->id_ca->cellAttributes() ?>>
<span id="el_cuti_akademik_id_ca">
<span<?= $Page->id_ca->viewAttributes() ?>>
<?= $Page->id_ca->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_cuti_akademik_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pengajuan_Surat_Cuti_Akademik->Visible) { // Pengajuan_Surat_Cuti_Akademik ?>
    <tr id="r_Pengajuan_Surat_Cuti_Akademik"<?= $Page->Pengajuan_Surat_Cuti_Akademik->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_Pengajuan_Surat_Cuti_Akademik"><?= $Page->Pengajuan_Surat_Cuti_Akademik->caption() ?></span></td>
        <td data-name="Pengajuan_Surat_Cuti_Akademik"<?= $Page->Pengajuan_Surat_Cuti_Akademik->cellAttributes() ?>>
<span id="el_cuti_akademik_Pengajuan_Surat_Cuti_Akademik">
<span<?= $Page->Pengajuan_Surat_Cuti_Akademik->viewAttributes() ?>>
<?= $Page->Pengajuan_Surat_Cuti_Akademik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Persetujuan_Cuti_Akademik->Visible) { // Persetujuan_Cuti_Akademik ?>
    <tr id="r_Persetujuan_Cuti_Akademik"<?= $Page->Persetujuan_Cuti_Akademik->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_Persetujuan_Cuti_Akademik"><?= $Page->Persetujuan_Cuti_Akademik->caption() ?></span></td>
        <td data-name="Persetujuan_Cuti_Akademik"<?= $Page->Persetujuan_Cuti_Akademik->cellAttributes() ?>>
<span id="el_cuti_akademik_Persetujuan_Cuti_Akademik">
<span<?= $Page->Persetujuan_Cuti_Akademik->viewAttributes() ?>>
<?= $Page->Persetujuan_Cuti_Akademik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Surat_Keterangan_Aktif_Kembali->Visible) { // Surat_Keterangan_Aktif_Kembali ?>
    <tr id="r_Surat_Keterangan_Aktif_Kembali"<?= $Page->Surat_Keterangan_Aktif_Kembali->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_Surat_Keterangan_Aktif_Kembali"><?= $Page->Surat_Keterangan_Aktif_Kembali->caption() ?></span></td>
        <td data-name="Surat_Keterangan_Aktif_Kembali"<?= $Page->Surat_Keterangan_Aktif_Kembali->cellAttributes() ?>>
<span id="el_cuti_akademik_Surat_Keterangan_Aktif_Kembali">
<span<?= $Page->Surat_Keterangan_Aktif_Kembali->viewAttributes() ?>>
<?= $Page->Surat_Keterangan_Aktif_Kembali->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <tr id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_Tanggal"><?= $Page->Tanggal->caption() ?></span></td>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_cuti_akademik_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_user->Visible) { // id_user ?>
    <tr id="r_id_user"<?= $Page->id_user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_id_user"><?= $Page->id_user->caption() ?></span></td>
        <td data-name="id_user"<?= $Page->id_user->cellAttributes() ?>>
<span id="el_cuti_akademik_id_user">
<span<?= $Page->id_user->viewAttributes() ?>>
<?= $Page->id_user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_cuti_akademik_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
    <tr id="r_ip"<?= $Page->ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_cuti_akademik_ip"><?= $Page->ip->caption() ?></span></td>
        <td data-name="ip"<?= $Page->ip->cellAttributes() ?>>
<span id="el_cuti_akademik_ip">
<span<?= $Page->ip->viewAttributes() ?>>
<?= $Page->ip->getViewValue() ?></span>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fcuti_akademikadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fcuti_akademikadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fcuti_akademikedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fcuti_akademikedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
