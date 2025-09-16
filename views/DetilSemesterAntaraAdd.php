<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilSemesterAntaraAdd = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_semester_antara: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fdetil_semester_antaraadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_semester_antaraadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["id_smtsr", [fields.id_smtsr.visible && fields.id_smtsr.required ? ew.Validators.required(fields.id_smtsr.caption) : null], fields.id_smtsr.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["KRS", [fields.KRS.visible && fields.KRS.required ? ew.Validators.required(fields.KRS.caption) : null], fields.KRS.isInvalid],
            ["Bukti_SPP", [fields.Bukti_SPP.visible && fields.Bukti_SPP.required ? ew.Validators.fileRequired(fields.Bukti_SPP.caption) : null], fields.Bukti_SPP.isInvalid]
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
<form name="fdetil_semester_antaraadd" id="fdetil_semester_antaraadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detil_semester_antara">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "semester_antara") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="semester_antara">
<input type="hidden" name="fk_id_smtr" value="<?= HtmlEncode($Page->id_smtsr->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_smtsr->Visible) { // id_smtsr ?>
    <div id="r_id_smtsr"<?= $Page->id_smtsr->rowAttributes() ?>>
        <label id="elh_detil_semester_antara_id_smtsr" for="x_id_smtsr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_smtsr->caption() ?><?= $Page->id_smtsr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_smtsr->cellAttributes() ?>>
<?php if ($Page->id_smtsr->getSessionValue() != "") { ?>
<span id="el_detil_semester_antara_id_smtsr">
<span<?= $Page->id_smtsr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_smtsr->getDisplayValue($Page->id_smtsr->ViewValue))) ?>"></span>
<input type="hidden" id="x_id_smtsr" name="x_id_smtsr" value="<?= HtmlEncode($Page->id_smtsr->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_detil_semester_antara_id_smtsr">
<input type="<?= $Page->id_smtsr->getInputTextType() ?>" name="x_id_smtsr" id="x_id_smtsr" data-table="detil_semester_antara" data-field="x_id_smtsr" value="<?= $Page->id_smtsr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtsr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtsr->formatPattern()) ?>"<?= $Page->id_smtsr->editAttributes() ?> aria-describedby="x_id_smtsr_help">
<?= $Page->id_smtsr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_smtsr->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_detil_semester_antara_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_detil_semester_antara_NIM">
    <select
        id="x_NIM"
        name="x_NIM"
        class="form-select ew-select<?= $Page->NIM->isInvalidClass() ?>"
        <?php if (!$Page->NIM->IsNativeSelect) { ?>
        data-select2-id="fdetil_semester_antaraadd_x_NIM"
        <?php } ?>
        data-table="detil_semester_antara"
        data-field="x_NIM"
        data-value-separator="<?= $Page->NIM->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>"
        <?= $Page->NIM->editAttributes() ?>>
        <?= $Page->NIM->selectOptionListHtml("x_NIM") ?>
    </select>
    <?= $Page->NIM->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
<?= $Page->NIM->Lookup->getParamTag($Page, "p_x_NIM") ?>
<?php if (!$Page->NIM->IsNativeSelect) { ?>
<script<?= Nonce() ?>>
loadjs.ready("fdetil_semester_antaraadd", function() {
    var options = { name: "x_NIM", selectId: "fdetil_semester_antaraadd_x_NIM" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdetil_semester_antaraadd.lists.NIM?.lookupOptions.length) {
        options.data = { id: "x_NIM", form: "fdetil_semester_antaraadd" };
    } else {
        options.ajax = { id: "x_NIM", form: "fdetil_semester_antaraadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.detil_semester_antara.fields.NIM.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KRS->Visible) { // KRS ?>
    <div id="r_KRS"<?= $Page->KRS->rowAttributes() ?>>
        <label id="elh_detil_semester_antara_KRS" for="x_KRS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KRS->caption() ?><?= $Page->KRS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->KRS->cellAttributes() ?>>
<span id="el_detil_semester_antara_KRS">
<input type="<?= $Page->KRS->getInputTextType() ?>" name="x_KRS" id="x_KRS" data-table="detil_semester_antara" data-field="x_KRS" value="<?= $Page->KRS->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KRS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->KRS->formatPattern()) ?>"<?= $Page->KRS->editAttributes() ?> aria-describedby="x_KRS_help">
<?= $Page->KRS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KRS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Bukti_SPP->Visible) { // Bukti_SPP ?>
    <div id="r_Bukti_SPP"<?= $Page->Bukti_SPP->rowAttributes() ?>>
        <label id="elh_detil_semester_antara_Bukti_SPP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Bukti_SPP->caption() ?><?= $Page->Bukti_SPP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Bukti_SPP->cellAttributes() ?>>
<span id="el_detil_semester_antara_Bukti_SPP">
<div id="fd_x_Bukti_SPP" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Bukti_SPP"
        name="x_Bukti_SPP"
        class="form-control ew-file-input"
        title="<?= $Page->Bukti_SPP->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="detil_semester_antara"
        data-field="x_Bukti_SPP"
        data-size="50"
        data-accept-file-types="<?= $Page->Bukti_SPP->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Bukti_SPP->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Bukti_SPP->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Bukti_SPP_help"
        <?= ($Page->Bukti_SPP->ReadOnly || $Page->Bukti_SPP->Disabled) ? " disabled" : "" ?>
        <?= $Page->Bukti_SPP->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->Bukti_SPP->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Bukti_SPP->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_Bukti_SPP" id= "fn_x_Bukti_SPP" value="<?= $Page->Bukti_SPP->Upload->FileName ?>">
<input type="hidden" name="fa_x_Bukti_SPP" id= "fa_x_Bukti_SPP" value="0">
<table id="ft_x_Bukti_SPP" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdetil_semester_antaraadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdetil_semester_antaraadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_semester_antaraadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_semester_antaraadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("detil_semester_antara");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fdetil_semester_antaraadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
