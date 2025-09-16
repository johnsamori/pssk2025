<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KesehatanMahasiswaAdd = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kesehatan_mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fkesehatan_mahasiswaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkesehatan_mahasiswaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Dokter_Penanggung_Jawab", [fields.Dokter_Penanggung_Jawab.visible && fields.Dokter_Penanggung_Jawab.required ? ew.Validators.required(fields.Dokter_Penanggung_Jawab.caption) : null], fields.Dokter_Penanggung_Jawab.isInvalid],
            ["Nomor_SIP", [fields.Nomor_SIP.visible && fields.Nomor_SIP.required ? ew.Validators.required(fields.Nomor_SIP.caption) : null], fields.Nomor_SIP.isInvalid],
            ["Diagnosa", [fields.Diagnosa.visible && fields.Diagnosa.required ? ew.Validators.required(fields.Diagnosa.caption) : null], fields.Diagnosa.isInvalid],
            ["Rekomendasi_Dokter", [fields.Rekomendasi_Dokter.visible && fields.Rekomendasi_Dokter.required ? ew.Validators.required(fields.Rekomendasi_Dokter.caption) : null], fields.Rekomendasi_Dokter.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null], fields.Tanggal.isInvalid],
            ["Ip", [fields.Ip.visible && fields.Ip.required ? ew.Validators.required(fields.Ip.caption) : null], fields.Ip.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php // Begin of Card view by Masino Sinaga, September 10, 2023 ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("AddCaption"); ?></h4>
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
<form name="fkesehatan_mahasiswaadd" id="fkesehatan_mahasiswaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kesehatan_mahasiswa">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_kesehatan_mahasiswa_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="kesehatan_mahasiswa" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Dokter_Penanggung_Jawab->Visible) { // Dokter_Penanggung_Jawab ?>
    <div id="r_Dokter_Penanggung_Jawab"<?= $Page->Dokter_Penanggung_Jawab->rowAttributes() ?>>
        <label id="elh_kesehatan_mahasiswa_Dokter_Penanggung_Jawab" for="x_Dokter_Penanggung_Jawab" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Dokter_Penanggung_Jawab->caption() ?><?= $Page->Dokter_Penanggung_Jawab->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Dokter_Penanggung_Jawab->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Dokter_Penanggung_Jawab">
<input type="<?= $Page->Dokter_Penanggung_Jawab->getInputTextType() ?>" name="x_Dokter_Penanggung_Jawab" id="x_Dokter_Penanggung_Jawab" data-table="kesehatan_mahasiswa" data-field="x_Dokter_Penanggung_Jawab" value="<?= $Page->Dokter_Penanggung_Jawab->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Dokter_Penanggung_Jawab->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Dokter_Penanggung_Jawab->formatPattern()) ?>"<?= $Page->Dokter_Penanggung_Jawab->editAttributes() ?> aria-describedby="x_Dokter_Penanggung_Jawab_help">
<?= $Page->Dokter_Penanggung_Jawab->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Dokter_Penanggung_Jawab->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nomor_SIP->Visible) { // Nomor_SIP ?>
    <div id="r_Nomor_SIP"<?= $Page->Nomor_SIP->rowAttributes() ?>>
        <label id="elh_kesehatan_mahasiswa_Nomor_SIP" for="x_Nomor_SIP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nomor_SIP->caption() ?><?= $Page->Nomor_SIP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nomor_SIP->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Nomor_SIP">
<input type="<?= $Page->Nomor_SIP->getInputTextType() ?>" name="x_Nomor_SIP" id="x_Nomor_SIP" data-table="kesehatan_mahasiswa" data-field="x_Nomor_SIP" value="<?= $Page->Nomor_SIP->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Nomor_SIP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nomor_SIP->formatPattern()) ?>"<?= $Page->Nomor_SIP->editAttributes() ?> aria-describedby="x_Nomor_SIP_help">
<?= $Page->Nomor_SIP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nomor_SIP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Diagnosa->Visible) { // Diagnosa ?>
    <div id="r_Diagnosa"<?= $Page->Diagnosa->rowAttributes() ?>>
        <label id="elh_kesehatan_mahasiswa_Diagnosa" for="x_Diagnosa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Diagnosa->caption() ?><?= $Page->Diagnosa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Diagnosa->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Diagnosa">
<input type="<?= $Page->Diagnosa->getInputTextType() ?>" name="x_Diagnosa" id="x_Diagnosa" data-table="kesehatan_mahasiswa" data-field="x_Diagnosa" value="<?= $Page->Diagnosa->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Diagnosa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Diagnosa->formatPattern()) ?>"<?= $Page->Diagnosa->editAttributes() ?> aria-describedby="x_Diagnosa_help">
<?= $Page->Diagnosa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Diagnosa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Rekomendasi_Dokter->Visible) { // Rekomendasi_Dokter ?>
    <div id="r_Rekomendasi_Dokter"<?= $Page->Rekomendasi_Dokter->rowAttributes() ?>>
        <label id="elh_kesehatan_mahasiswa_Rekomendasi_Dokter" for="x_Rekomendasi_Dokter" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rekomendasi_Dokter->caption() ?><?= $Page->Rekomendasi_Dokter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rekomendasi_Dokter->cellAttributes() ?>>
<span id="el_kesehatan_mahasiswa_Rekomendasi_Dokter">
<input type="<?= $Page->Rekomendasi_Dokter->getInputTextType() ?>" name="x_Rekomendasi_Dokter" id="x_Rekomendasi_Dokter" data-table="kesehatan_mahasiswa" data-field="x_Rekomendasi_Dokter" value="<?= $Page->Rekomendasi_Dokter->getEditValue() ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Rekomendasi_Dokter->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rekomendasi_Dokter->formatPattern()) ?>"<?= $Page->Rekomendasi_Dokter->editAttributes() ?> aria-describedby="x_Rekomendasi_Dokter_help">
<?= $Page->Rekomendasi_Dokter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rekomendasi_Dokter->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkesehatan_mahasiswaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkesehatan_mahasiswaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkesehatan_mahasiswaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkesehatan_mahasiswaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("kesehatan_mahasiswa");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fkesehatan_mahasiswaadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
