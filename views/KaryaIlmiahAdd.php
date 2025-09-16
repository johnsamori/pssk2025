<?php

namespace PHPMaker2025\pssk2025;

// Page object
$KaryaIlmiahAdd = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { karya_ilmiah: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fkarya_ilmiahadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkarya_ilmiahadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Judul_Penelitian", [fields.Judul_Penelitian.visible && fields.Judul_Penelitian.required ? ew.Validators.required(fields.Judul_Penelitian.caption) : null], fields.Judul_Penelitian.isInvalid],
            ["Pembimbing_1", [fields.Pembimbing_1.visible && fields.Pembimbing_1.required ? ew.Validators.required(fields.Pembimbing_1.caption) : null], fields.Pembimbing_1.isInvalid],
            ["Pembimbing_2", [fields.Pembimbing_2.visible && fields.Pembimbing_2.required ? ew.Validators.required(fields.Pembimbing_2.caption) : null], fields.Pembimbing_2.isInvalid],
            ["Pembimbing_3", [fields.Pembimbing_3.visible && fields.Pembimbing_3.required ? ew.Validators.required(fields.Pembimbing_3.caption) : null], fields.Pembimbing_3.isInvalid],
            ["Penguji_1", [fields.Penguji_1.visible && fields.Penguji_1.required ? ew.Validators.required(fields.Penguji_1.caption) : null], fields.Penguji_1.isInvalid],
            ["Penguji_2", [fields.Penguji_2.visible && fields.Penguji_2.required ? ew.Validators.required(fields.Penguji_2.caption) : null], fields.Penguji_2.isInvalid],
            ["Lembar_Pengesahan", [fields.Lembar_Pengesahan.visible && fields.Lembar_Pengesahan.required ? ew.Validators.fileRequired(fields.Lembar_Pengesahan.caption) : null], fields.Lembar_Pengesahan.isInvalid],
            ["Judul_Publikasi", [fields.Judul_Publikasi.visible && fields.Judul_Publikasi.required ? ew.Validators.required(fields.Judul_Publikasi.caption) : null], fields.Judul_Publikasi.isInvalid],
            ["Link_Publikasi", [fields.Link_Publikasi.visible && fields.Link_Publikasi.required ? ew.Validators.required(fields.Link_Publikasi.caption) : null], fields.Link_Publikasi.isInvalid],
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
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
<form name="fkarya_ilmiahadd" id="fkarya_ilmiahadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="karya_ilmiah">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_karya_ilmiah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="karya_ilmiah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
    <div id="r_Judul_Penelitian"<?= $Page->Judul_Penelitian->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Judul_Penelitian" for="x_Judul_Penelitian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Judul_Penelitian->caption() ?><?= $Page->Judul_Penelitian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el_karya_ilmiah_Judul_Penelitian">
<input type="<?= $Page->Judul_Penelitian->getInputTextType() ?>" name="x_Judul_Penelitian" id="x_Judul_Penelitian" data-table="karya_ilmiah" data-field="x_Judul_Penelitian" value="<?= $Page->Judul_Penelitian->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Judul_Penelitian->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Judul_Penelitian->formatPattern()) ?>"<?= $Page->Judul_Penelitian->editAttributes() ?> aria-describedby="x_Judul_Penelitian_help">
<?= $Page->Judul_Penelitian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Judul_Penelitian->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pembimbing_1->Visible) { // Pembimbing_1 ?>
    <div id="r_Pembimbing_1"<?= $Page->Pembimbing_1->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Pembimbing_1" for="x_Pembimbing_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pembimbing_1->caption() ?><?= $Page->Pembimbing_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pembimbing_1->cellAttributes() ?>>
<span id="el_karya_ilmiah_Pembimbing_1">
<input type="<?= $Page->Pembimbing_1->getInputTextType() ?>" name="x_Pembimbing_1" id="x_Pembimbing_1" data-table="karya_ilmiah" data-field="x_Pembimbing_1" value="<?= $Page->Pembimbing_1->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Pembimbing_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pembimbing_1->formatPattern()) ?>"<?= $Page->Pembimbing_1->editAttributes() ?> aria-describedby="x_Pembimbing_1_help">
<?= $Page->Pembimbing_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pembimbing_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pembimbing_2->Visible) { // Pembimbing_2 ?>
    <div id="r_Pembimbing_2"<?= $Page->Pembimbing_2->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Pembimbing_2" for="x_Pembimbing_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pembimbing_2->caption() ?><?= $Page->Pembimbing_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pembimbing_2->cellAttributes() ?>>
<span id="el_karya_ilmiah_Pembimbing_2">
<input type="<?= $Page->Pembimbing_2->getInputTextType() ?>" name="x_Pembimbing_2" id="x_Pembimbing_2" data-table="karya_ilmiah" data-field="x_Pembimbing_2" value="<?= $Page->Pembimbing_2->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Pembimbing_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pembimbing_2->formatPattern()) ?>"<?= $Page->Pembimbing_2->editAttributes() ?> aria-describedby="x_Pembimbing_2_help">
<?= $Page->Pembimbing_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pembimbing_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pembimbing_3->Visible) { // Pembimbing_3 ?>
    <div id="r_Pembimbing_3"<?= $Page->Pembimbing_3->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Pembimbing_3" for="x_Pembimbing_3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pembimbing_3->caption() ?><?= $Page->Pembimbing_3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pembimbing_3->cellAttributes() ?>>
<span id="el_karya_ilmiah_Pembimbing_3">
<input type="<?= $Page->Pembimbing_3->getInputTextType() ?>" name="x_Pembimbing_3" id="x_Pembimbing_3" data-table="karya_ilmiah" data-field="x_Pembimbing_3" value="<?= $Page->Pembimbing_3->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Pembimbing_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pembimbing_3->formatPattern()) ?>"<?= $Page->Pembimbing_3->editAttributes() ?> aria-describedby="x_Pembimbing_3_help">
<?= $Page->Pembimbing_3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pembimbing_3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Penguji_1->Visible) { // Penguji_1 ?>
    <div id="r_Penguji_1"<?= $Page->Penguji_1->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Penguji_1" for="x_Penguji_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Penguji_1->caption() ?><?= $Page->Penguji_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Penguji_1->cellAttributes() ?>>
<span id="el_karya_ilmiah_Penguji_1">
<input type="<?= $Page->Penguji_1->getInputTextType() ?>" name="x_Penguji_1" id="x_Penguji_1" data-table="karya_ilmiah" data-field="x_Penguji_1" value="<?= $Page->Penguji_1->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Penguji_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Penguji_1->formatPattern()) ?>"<?= $Page->Penguji_1->editAttributes() ?> aria-describedby="x_Penguji_1_help">
<?= $Page->Penguji_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Penguji_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Penguji_2->Visible) { // Penguji_2 ?>
    <div id="r_Penguji_2"<?= $Page->Penguji_2->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Penguji_2" for="x_Penguji_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Penguji_2->caption() ?><?= $Page->Penguji_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Penguji_2->cellAttributes() ?>>
<span id="el_karya_ilmiah_Penguji_2">
<input type="<?= $Page->Penguji_2->getInputTextType() ?>" name="x_Penguji_2" id="x_Penguji_2" data-table="karya_ilmiah" data-field="x_Penguji_2" value="<?= $Page->Penguji_2->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Penguji_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Penguji_2->formatPattern()) ?>"<?= $Page->Penguji_2->editAttributes() ?> aria-describedby="x_Penguji_2_help">
<?= $Page->Penguji_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Penguji_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Lembar_Pengesahan->Visible) { // Lembar_Pengesahan ?>
    <div id="r_Lembar_Pengesahan"<?= $Page->Lembar_Pengesahan->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Lembar_Pengesahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Lembar_Pengesahan->caption() ?><?= $Page->Lembar_Pengesahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Lembar_Pengesahan->cellAttributes() ?>>
<span id="el_karya_ilmiah_Lembar_Pengesahan">
<div id="fd_x_Lembar_Pengesahan" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_Lembar_Pengesahan"
        name="x_Lembar_Pengesahan"
        class="form-control ew-file-input"
        title="<?= $Page->Lembar_Pengesahan->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="karya_ilmiah"
        data-field="x_Lembar_Pengesahan"
        data-size="255"
        data-accept-file-types="<?= $Page->Lembar_Pengesahan->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->Lembar_Pengesahan->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->Lembar_Pengesahan->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_Lembar_Pengesahan_help"
        <?= ($Page->Lembar_Pengesahan->ReadOnly || $Page->Lembar_Pengesahan->Disabled) ? " disabled" : "" ?>
        <?= $Page->Lembar_Pengesahan->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->Lembar_Pengesahan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Lembar_Pengesahan->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_Lembar_Pengesahan" id= "fn_x_Lembar_Pengesahan" value="<?= $Page->Lembar_Pengesahan->Upload->FileName ?>">
<input type="hidden" name="fa_x_Lembar_Pengesahan" id= "fa_x_Lembar_Pengesahan" value="0">
<table id="ft_x_Lembar_Pengesahan" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Judul_Publikasi->Visible) { // Judul_Publikasi ?>
    <div id="r_Judul_Publikasi"<?= $Page->Judul_Publikasi->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Judul_Publikasi" for="x_Judul_Publikasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Judul_Publikasi->caption() ?><?= $Page->Judul_Publikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Judul_Publikasi->cellAttributes() ?>>
<span id="el_karya_ilmiah_Judul_Publikasi">
<input type="<?= $Page->Judul_Publikasi->getInputTextType() ?>" name="x_Judul_Publikasi" id="x_Judul_Publikasi" data-table="karya_ilmiah" data-field="x_Judul_Publikasi" value="<?= $Page->Judul_Publikasi->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Judul_Publikasi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Judul_Publikasi->formatPattern()) ?>"<?= $Page->Judul_Publikasi->editAttributes() ?> aria-describedby="x_Judul_Publikasi_help">
<?= $Page->Judul_Publikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Judul_Publikasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Link_Publikasi->Visible) { // Link_Publikasi ?>
    <div id="r_Link_Publikasi"<?= $Page->Link_Publikasi->rowAttributes() ?>>
        <label id="elh_karya_ilmiah_Link_Publikasi" for="x_Link_Publikasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Link_Publikasi->caption() ?><?= $Page->Link_Publikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Link_Publikasi->cellAttributes() ?>>
<span id="el_karya_ilmiah_Link_Publikasi">
<input type="<?= $Page->Link_Publikasi->getInputTextType() ?>" name="x_Link_Publikasi" id="x_Link_Publikasi" data-table="karya_ilmiah" data-field="x_Link_Publikasi" value="<?= $Page->Link_Publikasi->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Link_Publikasi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Link_Publikasi->formatPattern()) ?>"<?= $Page->Link_Publikasi->editAttributes() ?> aria-describedby="x_Link_Publikasi_help">
<?= $Page->Link_Publikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Link_Publikasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkarya_ilmiahadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkarya_ilmiahadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fkarya_ilmiahadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fkarya_ilmiahadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("karya_ilmiah");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fkarya_ilmiahadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
