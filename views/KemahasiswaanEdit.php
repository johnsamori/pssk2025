<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KemahasiswaanEdit = &$Page;
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
<form name="fkemahasiswaanedit" id="fkemahasiswaanedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kemahasiswaan: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fkemahasiswaanedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkemahasiswaanedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_kemahasiswaan", [fields.id_kemahasiswaan.visible && fields.id_kemahasiswaan.required ? ew.Validators.required(fields.id_kemahasiswaan.caption) : null, ew.Validators.integer], fields.id_kemahasiswaan.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Jenis_Beasiswa", [fields.Jenis_Beasiswa.visible && fields.Jenis_Beasiswa.required ? ew.Validators.required(fields.Jenis_Beasiswa.caption) : null], fields.Jenis_Beasiswa.isInvalid],
            ["Sumber_beasiswa", [fields.Sumber_beasiswa.visible && fields.Sumber_beasiswa.required ? ew.Validators.required(fields.Sumber_beasiswa.caption) : null], fields.Sumber_beasiswa.isInvalid],
            ["Nama_Kegiatan", [fields.Nama_Kegiatan.visible && fields.Nama_Kegiatan.required ? ew.Validators.required(fields.Nama_Kegiatan.caption) : null], fields.Nama_Kegiatan.isInvalid],
            ["Nama_Penghargaan_YangDiterima", [fields.Nama_Penghargaan_YangDiterima.visible && fields.Nama_Penghargaan_YangDiterima.required ? ew.Validators.required(fields.Nama_Penghargaan_YangDiterima.caption) : null], fields.Nama_Penghargaan_YangDiterima.isInvalid],
            ["Sertifikat", [fields.Sertifikat.visible && fields.Sertifikat.required ? ew.Validators.required(fields.Sertifikat.caption) : null], fields.Sertifikat.isInvalid],
            ["userid", [fields.userid.visible && fields.userid.required ? ew.Validators.required(fields.userid.caption) : null], fields.userid.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["ip", [fields.ip.visible && fields.ip.required ? ew.Validators.required(fields.ip.caption) : null], fields.ip.isInvalid],
            ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null], fields.tanggal.isInvalid]
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
            "NIM": <?= $Page->NIM->toClientList($Page) ?>,
            "Jenis_Beasiswa": <?= $Page->Jenis_Beasiswa->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="kemahasiswaan">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_kemahasiswaan->Visible) { // id_kemahasiswaan ?>
    <div id="r_id_kemahasiswaan"<?= $Page->id_kemahasiswaan->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_id_kemahasiswaan" for="x_id_kemahasiswaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_kemahasiswaan->caption() ?><?= $Page->id_kemahasiswaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_kemahasiswaan->cellAttributes() ?>>
<span id="el_kemahasiswaan_id_kemahasiswaan">
<input type="<?= $Page->id_kemahasiswaan->getInputTextType() ?>" name="x_id_kemahasiswaan" id="x_id_kemahasiswaan" data-table="kemahasiswaan" data-field="x_id_kemahasiswaan" value="<?= $Page->id_kemahasiswaan->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->id_kemahasiswaan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_kemahasiswaan->formatPattern()) ?>"<?= $Page->id_kemahasiswaan->editAttributes() ?> aria-describedby="x_id_kemahasiswaan_help">
<?= $Page->id_kemahasiswaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_kemahasiswaan->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fkemahasiswaanedit', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fkemahasiswaanedit", "x_id_kemahasiswaan", jQuery.extend(true, "", options));
});
</script>
<input type="hidden" data-table="kemahasiswaan" data-field="x_id_kemahasiswaan" data-hidden="1" data-old name="o_id_kemahasiswaan" id="o_id_kemahasiswaan" value="<?= HtmlEncode($Page->id_kemahasiswaan->OldValue ?? $Page->id_kemahasiswaan->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_kemahasiswaan_NIM">
<?php
if (IsRTL()) {
    $Page->NIM->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_NIM" class="ew-auto-suggest">
    <input type="<?= $Page->NIM->getInputTextType() ?>" class="form-control" name="sv_x_NIM" id="sv_x_NIM" value="<?= $Page->NIM->getEditValue() ?>" autocomplete="off" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
</span>
<selection-list hidden class="form-control" data-table="kemahasiswaan" data-field="x_NIM" data-input="sv_x_NIM" data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>" name="x_NIM" id="x_NIM" value="<?= HtmlEncode($Page->NIM->CurrentValue) ?>"></selection-list>
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready("fkemahasiswaanedit", function() {
    fkemahasiswaanedit.createAutoSuggest(Object.assign({"id":"x_NIM","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->NIM->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.kemahasiswaan.fields.NIM.autoSuggestOptions));
});
</script>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x_NIM") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jenis_Beasiswa->Visible) { // Jenis_Beasiswa ?>
    <div id="r_Jenis_Beasiswa"<?= $Page->Jenis_Beasiswa->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_Jenis_Beasiswa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenis_Beasiswa->caption() ?><?= $Page->Jenis_Beasiswa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenis_Beasiswa->cellAttributes() ?>>
<span id="el_kemahasiswaan_Jenis_Beasiswa">
<?php
if (IsRTL()) {
    $Page->Jenis_Beasiswa->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_Jenis_Beasiswa" class="ew-auto-suggest">
    <input type="<?= $Page->Jenis_Beasiswa->getInputTextType() ?>" class="form-control" name="sv_x_Jenis_Beasiswa" id="sv_x_Jenis_Beasiswa" value="<?= $Page->Jenis_Beasiswa->getEditValue() ?>" autocomplete="off" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Jenis_Beasiswa->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->Jenis_Beasiswa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jenis_Beasiswa->formatPattern()) ?>"<?= $Page->Jenis_Beasiswa->editAttributes() ?> aria-describedby="x_Jenis_Beasiswa_help">
</span>
<selection-list hidden class="form-control" data-table="kemahasiswaan" data-field="x_Jenis_Beasiswa" data-input="sv_x_Jenis_Beasiswa" data-value-separator="<?= $Page->Jenis_Beasiswa->displayValueSeparatorAttribute() ?>" name="x_Jenis_Beasiswa" id="x_Jenis_Beasiswa" value="<?= HtmlEncode($Page->Jenis_Beasiswa->CurrentValue) ?>"></selection-list>
<?= $Page->Jenis_Beasiswa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_Beasiswa->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready("fkemahasiswaanedit", function() {
    fkemahasiswaanedit.createAutoSuggest(Object.assign({"id":"x_Jenis_Beasiswa","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->Jenis_Beasiswa->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.kemahasiswaan.fields.Jenis_Beasiswa.autoSuggestOptions));
});
</script>
<?= $Page->Jenis_Beasiswa->Lookup->getParamTag($Page, "p_x_Jenis_Beasiswa") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Sumber_beasiswa->Visible) { // Sumber_beasiswa ?>
    <div id="r_Sumber_beasiswa"<?= $Page->Sumber_beasiswa->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_Sumber_beasiswa" for="x_Sumber_beasiswa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sumber_beasiswa->caption() ?><?= $Page->Sumber_beasiswa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Sumber_beasiswa->cellAttributes() ?>>
<span id="el_kemahasiswaan_Sumber_beasiswa">
<input type="<?= $Page->Sumber_beasiswa->getInputTextType() ?>" name="x_Sumber_beasiswa" id="x_Sumber_beasiswa" data-table="kemahasiswaan" data-field="x_Sumber_beasiswa" value="<?= $Page->Sumber_beasiswa->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Sumber_beasiswa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Sumber_beasiswa->formatPattern()) ?>"<?= $Page->Sumber_beasiswa->editAttributes() ?> aria-describedby="x_Sumber_beasiswa_help">
<?= $Page->Sumber_beasiswa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sumber_beasiswa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama_Kegiatan->Visible) { // Nama_Kegiatan ?>
    <div id="r_Nama_Kegiatan"<?= $Page->Nama_Kegiatan->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_Nama_Kegiatan" for="x_Nama_Kegiatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Kegiatan->caption() ?><?= $Page->Nama_Kegiatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Kegiatan->cellAttributes() ?>>
<span id="el_kemahasiswaan_Nama_Kegiatan">
<input type="<?= $Page->Nama_Kegiatan->getInputTextType() ?>" name="x_Nama_Kegiatan" id="x_Nama_Kegiatan" data-table="kemahasiswaan" data-field="x_Nama_Kegiatan" value="<?= $Page->Nama_Kegiatan->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Kegiatan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Kegiatan->formatPattern()) ?>"<?= $Page->Nama_Kegiatan->editAttributes() ?> aria-describedby="x_Nama_Kegiatan_help">
<?= $Page->Nama_Kegiatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Kegiatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama_Penghargaan_YangDiterima->Visible) { // Nama_Penghargaan_Yang Diterima ?>
    <div id="r_Nama_Penghargaan_YangDiterima"<?= $Page->Nama_Penghargaan_YangDiterima->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_Nama_Penghargaan_YangDiterima" for="x_Nama_Penghargaan_YangDiterima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Penghargaan_YangDiterima->caption() ?><?= $Page->Nama_Penghargaan_YangDiterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Penghargaan_YangDiterima->cellAttributes() ?>>
<span id="el_kemahasiswaan_Nama_Penghargaan_YangDiterima">
<input type="<?= $Page->Nama_Penghargaan_YangDiterima->getInputTextType() ?>" name="x_Nama_Penghargaan_YangDiterima" id="x_Nama_Penghargaan_YangDiterima" data-table="kemahasiswaan" data-field="x_Nama_Penghargaan_YangDiterima" value="<?= $Page->Nama_Penghargaan_YangDiterima->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Penghargaan_YangDiterima->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Penghargaan_YangDiterima->formatPattern()) ?>"<?= $Page->Nama_Penghargaan_YangDiterima->editAttributes() ?> aria-describedby="x_Nama_Penghargaan_YangDiterima_help">
<?= $Page->Nama_Penghargaan_YangDiterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Penghargaan_YangDiterima->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Sertifikat->Visible) { // Sertifikat ?>
    <div id="r_Sertifikat"<?= $Page->Sertifikat->rowAttributes() ?>>
        <label id="elh_kemahasiswaan_Sertifikat" for="x_Sertifikat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sertifikat->caption() ?><?= $Page->Sertifikat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Sertifikat->cellAttributes() ?>>
<span id="el_kemahasiswaan_Sertifikat">
<input type="<?= $Page->Sertifikat->getInputTextType() ?>" name="x_Sertifikat" id="x_Sertifikat" data-table="kemahasiswaan" data-field="x_Sertifikat" value="<?= $Page->Sertifikat->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Sertifikat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Sertifikat->formatPattern()) ?>"<?= $Page->Sertifikat->editAttributes() ?> aria-describedby="x_Sertifikat_help">
<?= $Page->Sertifikat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sertifikat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkemahasiswaanedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkemahasiswaanedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkemahasiswaanedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkemahasiswaanedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("kemahasiswaan");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fkemahasiswaanedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
