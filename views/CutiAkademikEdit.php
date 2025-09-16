<?php

namespace PHPMaker2025\pssk2025;

// Page object
$CutiAkademikEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php // Begin of Card view by Masino Sinaga, September 10, 2023 ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("EditCaption"); ?></h4>
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
<form name="fcuti_akademikedit" id="fcuti_akademikedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cuti_akademik: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcuti_akademikedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcuti_akademikedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_ca", [fields.id_ca.visible && fields.id_ca.required ? ew.Validators.required(fields.id_ca.caption) : null], fields.id_ca.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Pengajuan_Surat_Cuti_Akademik", [fields.Pengajuan_Surat_Cuti_Akademik.visible && fields.Pengajuan_Surat_Cuti_Akademik.required ? ew.Validators.required(fields.Pengajuan_Surat_Cuti_Akademik.caption) : null], fields.Pengajuan_Surat_Cuti_Akademik.isInvalid],
            ["Persetujuan_Cuti_Akademik", [fields.Persetujuan_Cuti_Akademik.visible && fields.Persetujuan_Cuti_Akademik.required ? ew.Validators.required(fields.Persetujuan_Cuti_Akademik.caption) : null], fields.Persetujuan_Cuti_Akademik.isInvalid],
            ["Surat_Keterangan_Aktif_Kembali", [fields.Surat_Keterangan_Aktif_Kembali.visible && fields.Surat_Keterangan_Aktif_Kembali.required ? ew.Validators.required(fields.Surat_Keterangan_Aktif_Kembali.caption) : null], fields.Surat_Keterangan_Aktif_Kembali.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null], fields.Tanggal.isInvalid],
            ["id_user", [fields.id_user.visible && fields.id_user.required ? ew.Validators.required(fields.id_user.caption) : null], fields.id_user.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["ip", [fields.ip.visible && fields.ip.required ? ew.Validators.required(fields.ip.caption) : null], fields.ip.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })
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
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cuti_akademik">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_ca->Visible) { // id_ca ?>
    <div id="r_id_ca"<?= $Page->id_ca->rowAttributes() ?>>
        <label id="elh_cuti_akademik_id_ca" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_ca->caption() ?><?= $Page->id_ca->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_ca->cellAttributes() ?>>
<span id="el_cuti_akademik_id_ca">
<span<?= $Page->id_ca->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_ca->getDisplayValue($Page->id_ca->getEditValue()))) ?>"></span>
<input type="hidden" data-table="cuti_akademik" data-field="x_id_ca" data-hidden="1" name="x_id_ca" id="x_id_ca" value="<?= HtmlEncode($Page->id_ca->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_cuti_akademik_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_cuti_akademik_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="cuti_akademik" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pengajuan_Surat_Cuti_Akademik->Visible) { // Pengajuan_Surat_Cuti_Akademik ?>
    <div id="r_Pengajuan_Surat_Cuti_Akademik"<?= $Page->Pengajuan_Surat_Cuti_Akademik->rowAttributes() ?>>
        <label id="elh_cuti_akademik_Pengajuan_Surat_Cuti_Akademik" for="x_Pengajuan_Surat_Cuti_Akademik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pengajuan_Surat_Cuti_Akademik->caption() ?><?= $Page->Pengajuan_Surat_Cuti_Akademik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pengajuan_Surat_Cuti_Akademik->cellAttributes() ?>>
<span id="el_cuti_akademik_Pengajuan_Surat_Cuti_Akademik">
<input type="<?= $Page->Pengajuan_Surat_Cuti_Akademik->getInputTextType() ?>" name="x_Pengajuan_Surat_Cuti_Akademik" id="x_Pengajuan_Surat_Cuti_Akademik" data-table="cuti_akademik" data-field="x_Pengajuan_Surat_Cuti_Akademik" value="<?= $Page->Pengajuan_Surat_Cuti_Akademik->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Pengajuan_Surat_Cuti_Akademik->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pengajuan_Surat_Cuti_Akademik->formatPattern()) ?>"<?= $Page->Pengajuan_Surat_Cuti_Akademik->editAttributes() ?> aria-describedby="x_Pengajuan_Surat_Cuti_Akademik_help">
<?= $Page->Pengajuan_Surat_Cuti_Akademik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pengajuan_Surat_Cuti_Akademik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Persetujuan_Cuti_Akademik->Visible) { // Persetujuan_Cuti_Akademik ?>
    <div id="r_Persetujuan_Cuti_Akademik"<?= $Page->Persetujuan_Cuti_Akademik->rowAttributes() ?>>
        <label id="elh_cuti_akademik_Persetujuan_Cuti_Akademik" for="x_Persetujuan_Cuti_Akademik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Persetujuan_Cuti_Akademik->caption() ?><?= $Page->Persetujuan_Cuti_Akademik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Persetujuan_Cuti_Akademik->cellAttributes() ?>>
<span id="el_cuti_akademik_Persetujuan_Cuti_Akademik">
<input type="<?= $Page->Persetujuan_Cuti_Akademik->getInputTextType() ?>" name="x_Persetujuan_Cuti_Akademik" id="x_Persetujuan_Cuti_Akademik" data-table="cuti_akademik" data-field="x_Persetujuan_Cuti_Akademik" value="<?= $Page->Persetujuan_Cuti_Akademik->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Persetujuan_Cuti_Akademik->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Persetujuan_Cuti_Akademik->formatPattern()) ?>"<?= $Page->Persetujuan_Cuti_Akademik->editAttributes() ?> aria-describedby="x_Persetujuan_Cuti_Akademik_help">
<?= $Page->Persetujuan_Cuti_Akademik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Persetujuan_Cuti_Akademik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Surat_Keterangan_Aktif_Kembali->Visible) { // Surat_Keterangan_Aktif_Kembali ?>
    <div id="r_Surat_Keterangan_Aktif_Kembali"<?= $Page->Surat_Keterangan_Aktif_Kembali->rowAttributes() ?>>
        <label id="elh_cuti_akademik_Surat_Keterangan_Aktif_Kembali" for="x_Surat_Keterangan_Aktif_Kembali" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Surat_Keterangan_Aktif_Kembali->caption() ?><?= $Page->Surat_Keterangan_Aktif_Kembali->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Surat_Keterangan_Aktif_Kembali->cellAttributes() ?>>
<span id="el_cuti_akademik_Surat_Keterangan_Aktif_Kembali">
<input type="<?= $Page->Surat_Keterangan_Aktif_Kembali->getInputTextType() ?>" name="x_Surat_Keterangan_Aktif_Kembali" id="x_Surat_Keterangan_Aktif_Kembali" data-table="cuti_akademik" data-field="x_Surat_Keterangan_Aktif_Kembali" value="<?= $Page->Surat_Keterangan_Aktif_Kembali->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Surat_Keterangan_Aktif_Kembali->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Surat_Keterangan_Aktif_Kembali->formatPattern()) ?>"<?= $Page->Surat_Keterangan_Aktif_Kembali->editAttributes() ?> aria-describedby="x_Surat_Keterangan_Aktif_Kembali_help">
<?= $Page->Surat_Keterangan_Aktif_Kembali->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Keterangan_Aktif_Kembali->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcuti_akademikedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcuti_akademikedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
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
</main>
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fcuti_akademikedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fcuti_akademikedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("cuti_akademik");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fcuti_akademikedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
