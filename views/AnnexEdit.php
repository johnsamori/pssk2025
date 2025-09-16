<?php

namespace PHPMaker2025\pssk2025;

// Page object
$AnnexEdit = &$Page;
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
<form name="fannexedit" id="fannexedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { annex: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fannexedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fannexedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["No", [fields.No.visible && fields.No.required ? ew.Validators.required(fields.No.caption) : null], fields.No.isInvalid],
            ["Peraturan_Akdemik_Universitas", [fields.Peraturan_Akdemik_Universitas.visible && fields.Peraturan_Akdemik_Universitas.required ? ew.Validators.required(fields.Peraturan_Akdemik_Universitas.caption) : null], fields.Peraturan_Akdemik_Universitas.isInvalid],
            ["Pedoman_Pelaksanaan_Peraturan_Akademik", [fields.Pedoman_Pelaksanaan_Peraturan_Akademik.visible && fields.Pedoman_Pelaksanaan_Peraturan_Akademik.required ? ew.Validators.required(fields.Pedoman_Pelaksanaan_Peraturan_Akademik.caption) : null], fields.Pedoman_Pelaksanaan_Peraturan_Akademik.isInvalid],
            ["Rubrik_Penilaian", [fields.Rubrik_Penilaian.visible && fields.Rubrik_Penilaian.required ? ew.Validators.required(fields.Rubrik_Penilaian.caption) : null], fields.Rubrik_Penilaian.isInvalid],
            ["Panduan_Penulisan_KTI", [fields.Panduan_Penulisan_KTI.visible && fields.Panduan_Penulisan_KTI.required ? ew.Validators.required(fields.Panduan_Penulisan_KTI.caption) : null], fields.Panduan_Penulisan_KTI.isInvalid]
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
<input type="hidden" name="t" value="annex">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->No->Visible) { // No ?>
    <div id="r_No"<?= $Page->No->rowAttributes() ?>>
        <label id="elh_annex_No" class="<?= $Page->LeftColumnClass ?>"><?= $Page->No->caption() ?><?= $Page->No->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->No->cellAttributes() ?>>
<span id="el_annex_No">
<span<?= $Page->No->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->No->getDisplayValue($Page->No->getEditValue()))) ?>"></span>
<input type="hidden" data-table="annex" data-field="x_No" data-hidden="1" name="x_No" id="x_No" value="<?= HtmlEncode($Page->No->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Peraturan_Akdemik_Universitas->Visible) { // Peraturan_Akdemik_Universitas ?>
    <div id="r_Peraturan_Akdemik_Universitas"<?= $Page->Peraturan_Akdemik_Universitas->rowAttributes() ?>>
        <label id="elh_annex_Peraturan_Akdemik_Universitas" for="x_Peraturan_Akdemik_Universitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Peraturan_Akdemik_Universitas->caption() ?><?= $Page->Peraturan_Akdemik_Universitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Peraturan_Akdemik_Universitas->cellAttributes() ?>>
<span id="el_annex_Peraturan_Akdemik_Universitas">
<input type="<?= $Page->Peraturan_Akdemik_Universitas->getInputTextType() ?>" name="x_Peraturan_Akdemik_Universitas" id="x_Peraturan_Akdemik_Universitas" data-table="annex" data-field="x_Peraturan_Akdemik_Universitas" value="<?= $Page->Peraturan_Akdemik_Universitas->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Peraturan_Akdemik_Universitas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Peraturan_Akdemik_Universitas->formatPattern()) ?>"<?= $Page->Peraturan_Akdemik_Universitas->editAttributes() ?> aria-describedby="x_Peraturan_Akdemik_Universitas_help">
<?= $Page->Peraturan_Akdemik_Universitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Peraturan_Akdemik_Universitas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pedoman_Pelaksanaan_Peraturan_Akademik->Visible) { // Pedoman_Pelaksanaan_Peraturan_Akademik ?>
    <div id="r_Pedoman_Pelaksanaan_Peraturan_Akademik"<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->rowAttributes() ?>>
        <label id="elh_annex_Pedoman_Pelaksanaan_Peraturan_Akademik" for="x_Pedoman_Pelaksanaan_Peraturan_Akademik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->caption() ?><?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->cellAttributes() ?>>
<span id="el_annex_Pedoman_Pelaksanaan_Peraturan_Akademik">
<input type="<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getInputTextType() ?>" name="x_Pedoman_Pelaksanaan_Peraturan_Akademik" id="x_Pedoman_Pelaksanaan_Peraturan_Akademik" data-table="annex" data-field="x_Pedoman_Pelaksanaan_Peraturan_Akademik" value="<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pedoman_Pelaksanaan_Peraturan_Akademik->formatPattern()) ?>"<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->editAttributes() ?> aria-describedby="x_Pedoman_Pelaksanaan_Peraturan_Akademik_help">
<?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pedoman_Pelaksanaan_Peraturan_Akademik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Rubrik_Penilaian->Visible) { // Rubrik_Penilaian ?>
    <div id="r_Rubrik_Penilaian"<?= $Page->Rubrik_Penilaian->rowAttributes() ?>>
        <label id="elh_annex_Rubrik_Penilaian" for="x_Rubrik_Penilaian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rubrik_Penilaian->caption() ?><?= $Page->Rubrik_Penilaian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rubrik_Penilaian->cellAttributes() ?>>
<span id="el_annex_Rubrik_Penilaian">
<input type="<?= $Page->Rubrik_Penilaian->getInputTextType() ?>" name="x_Rubrik_Penilaian" id="x_Rubrik_Penilaian" data-table="annex" data-field="x_Rubrik_Penilaian" value="<?= $Page->Rubrik_Penilaian->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Rubrik_Penilaian->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rubrik_Penilaian->formatPattern()) ?>"<?= $Page->Rubrik_Penilaian->editAttributes() ?> aria-describedby="x_Rubrik_Penilaian_help">
<?= $Page->Rubrik_Penilaian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rubrik_Penilaian->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Panduan_Penulisan_KTI->Visible) { // Panduan_Penulisan_KTI ?>
    <div id="r_Panduan_Penulisan_KTI"<?= $Page->Panduan_Penulisan_KTI->rowAttributes() ?>>
        <label id="elh_annex_Panduan_Penulisan_KTI" for="x_Panduan_Penulisan_KTI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Panduan_Penulisan_KTI->caption() ?><?= $Page->Panduan_Penulisan_KTI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Panduan_Penulisan_KTI->cellAttributes() ?>>
<span id="el_annex_Panduan_Penulisan_KTI">
<input type="<?= $Page->Panduan_Penulisan_KTI->getInputTextType() ?>" name="x_Panduan_Penulisan_KTI" id="x_Panduan_Penulisan_KTI" data-table="annex" data-field="x_Panduan_Penulisan_KTI" value="<?= $Page->Panduan_Penulisan_KTI->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Panduan_Penulisan_KTI->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Panduan_Penulisan_KTI->formatPattern()) ?>"<?= $Page->Panduan_Penulisan_KTI->editAttributes() ?> aria-describedby="x_Panduan_Penulisan_KTI_help">
<?= $Page->Panduan_Penulisan_KTI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Panduan_Penulisan_KTI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fannexedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fannexedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fannexedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fannexedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("annex");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fannexedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
