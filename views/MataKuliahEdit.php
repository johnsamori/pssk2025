<?php

namespace PHPMaker2025\pssk2025;

// Page object
$MataKuliahEdit = &$Page;
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
<form name="fmata_kuliahedit" id="fmata_kuliahedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mata_kuliah: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fmata_kuliahedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmata_kuliahedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_mk", [fields.id_mk.visible && fields.id_mk.required ? ew.Validators.required(fields.id_mk.caption) : null], fields.id_mk.isInvalid],
            ["Kode_MK", [fields.Kode_MK.visible && fields.Kode_MK.required ? ew.Validators.required(fields.Kode_MK.caption) : null], fields.Kode_MK.isInvalid],
            ["Semester", [fields.Semester.visible && fields.Semester.required ? ew.Validators.required(fields.Semester.caption) : null], fields.Semester.isInvalid],
            ["Tahun_Akademik", [fields.Tahun_Akademik.visible && fields.Tahun_Akademik.required ? ew.Validators.required(fields.Tahun_Akademik.caption) : null], fields.Tahun_Akademik.isInvalid],
            ["Dosen", [fields.Dosen.visible && fields.Dosen.required ? ew.Validators.required(fields.Dosen.caption) : null], fields.Dosen.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null], fields.Tanggal.isInvalid],
            ["Ip", [fields.Ip.visible && fields.Ip.required ? ew.Validators.required(fields.Ip.caption) : null], fields.Ip.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["iduser", [fields.iduser.visible && fields.iduser.required ? ew.Validators.required(fields.iduser.caption) : null], fields.iduser.isInvalid]
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
<input type="hidden" name="t" value="mata_kuliah">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_mk->Visible) { // id_mk ?>
    <div id="r_id_mk"<?= $Page->id_mk->rowAttributes() ?>>
        <label id="elh_mata_kuliah_id_mk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_mk->caption() ?><?= $Page->id_mk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_mk->cellAttributes() ?>>
<span id="el_mata_kuliah_id_mk">
<span<?= $Page->id_mk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_mk->getDisplayValue($Page->id_mk->getEditValue()))) ?>"></span>
<input type="hidden" data-table="mata_kuliah" data-field="x_id_mk" data-hidden="1" name="x_id_mk" id="x_id_mk" value="<?= HtmlEncode($Page->id_mk->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
    <div id="r_Kode_MK"<?= $Page->Kode_MK->rowAttributes() ?>>
        <label id="elh_mata_kuliah_Kode_MK" for="x_Kode_MK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kode_MK->caption() ?><?= $Page->Kode_MK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kode_MK->cellAttributes() ?>>
<span id="el_mata_kuliah_Kode_MK">
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x_Kode_MK" id="x_Kode_MK" data-table="mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?> aria-describedby="x_Kode_MK_help">
<?= $Page->Kode_MK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
<input type="hidden" data-table="mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o_Kode_MK" id="o_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue ?? $Page->Kode_MK->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Semester->Visible) { // Semester ?>
    <div id="r_Semester"<?= $Page->Semester->rowAttributes() ?>>
        <label id="elh_mata_kuliah_Semester" for="x_Semester" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Semester->caption() ?><?= $Page->Semester->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Semester->cellAttributes() ?>>
<span id="el_mata_kuliah_Semester">
<input type="<?= $Page->Semester->getInputTextType() ?>" name="x_Semester" id="x_Semester" data-table="mata_kuliah" data-field="x_Semester" value="<?= $Page->Semester->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Semester->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Semester->formatPattern()) ?>"<?= $Page->Semester->editAttributes() ?> aria-describedby="x_Semester_help">
<?= $Page->Semester->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Semester->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tahun_Akademik->Visible) { // Tahun_Akademik ?>
    <div id="r_Tahun_Akademik"<?= $Page->Tahun_Akademik->rowAttributes() ?>>
        <label id="elh_mata_kuliah_Tahun_Akademik" for="x_Tahun_Akademik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tahun_Akademik->caption() ?><?= $Page->Tahun_Akademik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tahun_Akademik->cellAttributes() ?>>
<span id="el_mata_kuliah_Tahun_Akademik">
<input type="<?= $Page->Tahun_Akademik->getInputTextType() ?>" name="x_Tahun_Akademik" id="x_Tahun_Akademik" data-table="mata_kuliah" data-field="x_Tahun_Akademik" value="<?= $Page->Tahun_Akademik->getEditValue() ?>" size="30" maxlength="9" placeholder="<?= HtmlEncode($Page->Tahun_Akademik->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tahun_Akademik->formatPattern()) ?>"<?= $Page->Tahun_Akademik->editAttributes() ?> aria-describedby="x_Tahun_Akademik_help">
<?= $Page->Tahun_Akademik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tahun_Akademik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Dosen->Visible) { // Dosen ?>
    <div id="r_Dosen"<?= $Page->Dosen->rowAttributes() ?>>
        <label id="elh_mata_kuliah_Dosen" for="x_Dosen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Dosen->caption() ?><?= $Page->Dosen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Dosen->cellAttributes() ?>>
<span id="el_mata_kuliah_Dosen">
<input type="<?= $Page->Dosen->getInputTextType() ?>" name="x_Dosen" id="x_Dosen" data-table="mata_kuliah" data-field="x_Dosen" value="<?= $Page->Dosen->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Dosen->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Dosen->formatPattern()) ?>"<?= $Page->Dosen->editAttributes() ?> aria-describedby="x_Dosen_help">
<?= $Page->Dosen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Dosen->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("detil_mata_kuliah", explode(",", $Page->getCurrentDetailTable())) && $detil_mata_kuliah->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php if (Container("detil_mata_kuliah")->Count > 0) { // Begin of added by Masino Sinaga, September 16, 2023 ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_mata_kuliah", "TblCaption") ?></h4>
<?php } else { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_mata_kuliah", "TblCaption") ?></h4>
<?php } // End of added by Masino Sinaga, September 16, 2023 ?>
<?php } ?>
<?php include_once "DetilMataKuliahGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fmata_kuliahedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fmata_kuliahedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmata_kuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmata_kuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("mata_kuliah");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fmata_kuliahedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
