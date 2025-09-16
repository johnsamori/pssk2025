<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilUjianTahapBersamaEdit = &$Page;
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
<form name="fdetil_ujian_tahap_bersamaedit" id="fdetil_ujian_tahap_bersamaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_ujian_tahap_bersama: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdetil_ujian_tahap_bersamaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_ujian_tahap_bersamaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["no", [fields.no.visible && fields.no.required ? ew.Validators.required(fields.no.caption) : null], fields.no.isInvalid],
            ["id_utb", [fields.id_utb.visible && fields.id_utb.required ? ew.Validators.required(fields.id_utb.caption) : null], fields.id_utb.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Nilai", [fields.Nilai.visible && fields.Nilai.required ? ew.Validators.required(fields.Nilai.caption) : null], fields.Nilai.isInvalid]
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
<input type="hidden" name="t" value="detil_ujian_tahap_bersama">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "ujian_tahap_bersama") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="ujian_tahap_bersama">
<input type="hidden" name="fk_id_utb" value="<?= HtmlEncode($Page->id_utb->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->no->Visible) { // no ?>
    <div id="r_no"<?= $Page->no->rowAttributes() ?>>
        <label id="elh_detil_ujian_tahap_bersama_no" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no->caption() ?><?= $Page->no->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->no->cellAttributes() ?>>
<span id="el_detil_ujian_tahap_bersama_no">
<span<?= $Page->no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->no->getDisplayValue($Page->no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_ujian_tahap_bersama" data-field="x_no" data-hidden="1" name="x_no" id="x_no" value="<?= HtmlEncode($Page->no->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_utb->Visible) { // id_utb ?>
    <div id="r_id_utb"<?= $Page->id_utb->rowAttributes() ?>>
        <label id="elh_detil_ujian_tahap_bersama_id_utb" for="x_id_utb" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_utb->caption() ?><?= $Page->id_utb->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_utb->cellAttributes() ?>>
<?php if ($Page->id_utb->getSessionValue() != "") { ?>
<span id="el_detil_ujian_tahap_bersama_id_utb">
<span<?= $Page->id_utb->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_utb->getDisplayValue($Page->id_utb->ViewValue))) ?>"></span>
<input type="hidden" id="x_id_utb" name="x_id_utb" value="<?= HtmlEncode($Page->id_utb->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_detil_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x_id_utb" id="x_id_utb" data-table="detil_ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?> aria-describedby="x_id_utb_help">
<?= $Page->id_utb->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_detil_ujian_tahap_bersama_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_detil_ujian_tahap_bersama_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="detil_ujian_tahap_bersama" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai->Visible) { // Nilai ?>
    <div id="r_Nilai"<?= $Page->Nilai->rowAttributes() ?>>
        <label id="elh_detil_ujian_tahap_bersama_Nilai" for="x_Nilai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai->caption() ?><?= $Page->Nilai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai->cellAttributes() ?>>
<span id="el_detil_ujian_tahap_bersama_Nilai">
<input type="<?= $Page->Nilai->getInputTextType() ?>" name="x_Nilai" id="x_Nilai" data-table="detil_ujian_tahap_bersama" data-field="x_Nilai" value="<?= $Page->Nilai->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai->formatPattern()) ?>"<?= $Page->Nilai->editAttributes() ?> aria-describedby="x_Nilai_help">
<?= $Page->Nilai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdetil_ujian_tahap_bersamaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdetil_ujian_tahap_bersamaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_ujian_tahap_bersamaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_ujian_tahap_bersamaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("detil_ujian_tahap_bersama");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fdetil_ujian_tahap_bersamaedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
