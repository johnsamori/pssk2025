<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DetilMataKuliahEdit = &$Page;
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
<form name="fdetil_mata_kuliahedit" id="fdetil_mata_kuliahedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { detil_mata_kuliah: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdetil_mata_kuliahedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdetil_mata_kuliahedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_no", [fields.id_no.visible && fields.id_no.required ? ew.Validators.required(fields.id_no.caption) : null], fields.id_no.isInvalid],
            ["Kode_MK", [fields.Kode_MK.visible && fields.Kode_MK.required ? ew.Validators.required(fields.Kode_MK.caption) : null], fields.Kode_MK.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Nilai_Diskusi", [fields.Nilai_Diskusi.visible && fields.Nilai_Diskusi.required ? ew.Validators.required(fields.Nilai_Diskusi.caption) : null], fields.Nilai_Diskusi.isInvalid],
            ["Assessment_Skor_As_1", [fields.Assessment_Skor_As_1.visible && fields.Assessment_Skor_As_1.required ? ew.Validators.required(fields.Assessment_Skor_As_1.caption) : null], fields.Assessment_Skor_As_1.isInvalid],
            ["Assessment_Skor_As_2", [fields.Assessment_Skor_As_2.visible && fields.Assessment_Skor_As_2.required ? ew.Validators.required(fields.Assessment_Skor_As_2.caption) : null], fields.Assessment_Skor_As_2.isInvalid],
            ["Assessment_Skor_As_3", [fields.Assessment_Skor_As_3.visible && fields.Assessment_Skor_As_3.required ? ew.Validators.required(fields.Assessment_Skor_As_3.caption) : null], fields.Assessment_Skor_As_3.isInvalid],
            ["Nilai_Tugas", [fields.Nilai_Tugas.visible && fields.Nilai_Tugas.required ? ew.Validators.required(fields.Nilai_Tugas.caption) : null], fields.Nilai_Tugas.isInvalid],
            ["Nilai_UTS", [fields.Nilai_UTS.visible && fields.Nilai_UTS.required ? ew.Validators.required(fields.Nilai_UTS.caption) : null], fields.Nilai_UTS.isInvalid],
            ["Nilai_Akhir", [fields.Nilai_Akhir.visible && fields.Nilai_Akhir.required ? ew.Validators.required(fields.Nilai_Akhir.caption) : null], fields.Nilai_Akhir.isInvalid],
            ["iduser", [fields.iduser.visible && fields.iduser.required ? ew.Validators.required(fields.iduser.caption) : null], fields.iduser.isInvalid],
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
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="detil_mata_kuliah">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "mata_kuliah") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="mata_kuliah">
<input type="hidden" name="fk_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_no->Visible) { // id_no ?>
    <div id="r_id_no"<?= $Page->id_no->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_id_no" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_no->caption() ?><?= $Page->id_no->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_no->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_id_no">
<span<?= $Page->id_no->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_no->getDisplayValue($Page->id_no->getEditValue()))) ?>"></span>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_id_no" data-hidden="1" name="x_id_no" id="x_id_no" value="<?= HtmlEncode($Page->id_no->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kode_MK->Visible) { // Kode_MK ?>
    <div id="r_Kode_MK"<?= $Page->Kode_MK->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Kode_MK" for="x_Kode_MK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kode_MK->caption() ?><?= $Page->Kode_MK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kode_MK->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Kode_MK">
<?php if ($Page->Kode_MK->getSessionValue() != "") { ?>
<span<?= $Page->Kode_MK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Kode_MK->getDisplayValue($Page->Kode_MK->getEditValue()))) ?>"></span>
<input type="hidden" id="x_Kode_MK" name="x_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<input type="<?= $Page->Kode_MK->getInputTextType() ?>" name="x_Kode_MK" id="x_Kode_MK" data-table="detil_mata_kuliah" data-field="x_Kode_MK" value="<?= $Page->Kode_MK->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode_MK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_MK->formatPattern()) ?>"<?= $Page->Kode_MK->editAttributes() ?> aria-describedby="x_Kode_MK_help">
<?= $Page->Kode_MK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kode_MK->getErrorMessage() ?></div>
<?php } ?>
<input type="hidden" data-table="detil_mata_kuliah" data-field="x_Kode_MK" data-hidden="1" data-old name="o_Kode_MK" id="o_Kode_MK" value="<?= HtmlEncode($Page->Kode_MK->OldValue ?? $Page->Kode_MK->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="detil_mata_kuliah" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_Diskusi->Visible) { // Nilai_Diskusi ?>
    <div id="r_Nilai_Diskusi"<?= $Page->Nilai_Diskusi->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Nilai_Diskusi" for="x_Nilai_Diskusi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_Diskusi->caption() ?><?= $Page->Nilai_Diskusi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_Diskusi->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_Diskusi">
<input type="<?= $Page->Nilai_Diskusi->getInputTextType() ?>" name="x_Nilai_Diskusi" id="x_Nilai_Diskusi" data-table="detil_mata_kuliah" data-field="x_Nilai_Diskusi" value="<?= $Page->Nilai_Diskusi->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Diskusi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Diskusi->formatPattern()) ?>"<?= $Page->Nilai_Diskusi->editAttributes() ?> aria-describedby="x_Nilai_Diskusi_help">
<?= $Page->Nilai_Diskusi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_Diskusi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_1->Visible) { // Assessment_Skor_As_1 ?>
    <div id="r_Assessment_Skor_As_1"<?= $Page->Assessment_Skor_As_1->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Assessment_Skor_As_1" for="x_Assessment_Skor_As_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Assessment_Skor_As_1->caption() ?><?= $Page->Assessment_Skor_As_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Assessment_Skor_As_1->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Assessment_Skor_As_1">
<input type="<?= $Page->Assessment_Skor_As_1->getInputTextType() ?>" name="x_Assessment_Skor_As_1" id="x_Assessment_Skor_As_1" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_1" value="<?= $Page->Assessment_Skor_As_1->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_1->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_1->editAttributes() ?> aria-describedby="x_Assessment_Skor_As_1_help">
<?= $Page->Assessment_Skor_As_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_2->Visible) { // Assessment_Skor_As_2 ?>
    <div id="r_Assessment_Skor_As_2"<?= $Page->Assessment_Skor_As_2->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Assessment_Skor_As_2" for="x_Assessment_Skor_As_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Assessment_Skor_As_2->caption() ?><?= $Page->Assessment_Skor_As_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Assessment_Skor_As_2->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Assessment_Skor_As_2">
<input type="<?= $Page->Assessment_Skor_As_2->getInputTextType() ?>" name="x_Assessment_Skor_As_2" id="x_Assessment_Skor_As_2" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_2" value="<?= $Page->Assessment_Skor_As_2->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_2->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_2->editAttributes() ?> aria-describedby="x_Assessment_Skor_As_2_help">
<?= $Page->Assessment_Skor_As_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Assessment_Skor_As_3->Visible) { // Assessment_Skor_As_3 ?>
    <div id="r_Assessment_Skor_As_3"<?= $Page->Assessment_Skor_As_3->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Assessment_Skor_As_3" for="x_Assessment_Skor_As_3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Assessment_Skor_As_3->caption() ?><?= $Page->Assessment_Skor_As_3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Assessment_Skor_As_3->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Assessment_Skor_As_3">
<input type="<?= $Page->Assessment_Skor_As_3->getInputTextType() ?>" name="x_Assessment_Skor_As_3" id="x_Assessment_Skor_As_3" data-table="detil_mata_kuliah" data-field="x_Assessment_Skor_As_3" value="<?= $Page->Assessment_Skor_As_3->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Assessment_Skor_As_3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Assessment_Skor_As_3->formatPattern()) ?>"<?= $Page->Assessment_Skor_As_3->editAttributes() ?> aria-describedby="x_Assessment_Skor_As_3_help">
<?= $Page->Assessment_Skor_As_3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Assessment_Skor_As_3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_Tugas->Visible) { // Nilai_Tugas ?>
    <div id="r_Nilai_Tugas"<?= $Page->Nilai_Tugas->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Nilai_Tugas" for="x_Nilai_Tugas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_Tugas->caption() ?><?= $Page->Nilai_Tugas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_Tugas->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_Tugas">
<input type="<?= $Page->Nilai_Tugas->getInputTextType() ?>" name="x_Nilai_Tugas" id="x_Nilai_Tugas" data-table="detil_mata_kuliah" data-field="x_Nilai_Tugas" value="<?= $Page->Nilai_Tugas->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Tugas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Tugas->formatPattern()) ?>"<?= $Page->Nilai_Tugas->editAttributes() ?> aria-describedby="x_Nilai_Tugas_help">
<?= $Page->Nilai_Tugas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_Tugas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_UTS->Visible) { // Nilai_UTS ?>
    <div id="r_Nilai_UTS"<?= $Page->Nilai_UTS->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Nilai_UTS" for="x_Nilai_UTS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_UTS->caption() ?><?= $Page->Nilai_UTS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_UTS->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_UTS">
<input type="<?= $Page->Nilai_UTS->getInputTextType() ?>" name="x_Nilai_UTS" id="x_Nilai_UTS" data-table="detil_mata_kuliah" data-field="x_Nilai_UTS" value="<?= $Page->Nilai_UTS->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_UTS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_UTS->formatPattern()) ?>"<?= $Page->Nilai_UTS->editAttributes() ?> aria-describedby="x_Nilai_UTS_help">
<?= $Page->Nilai_UTS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_UTS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_Akhir->Visible) { // Nilai_Akhir ?>
    <div id="r_Nilai_Akhir"<?= $Page->Nilai_Akhir->rowAttributes() ?>>
        <label id="elh_detil_mata_kuliah_Nilai_Akhir" for="x_Nilai_Akhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_Akhir->caption() ?><?= $Page->Nilai_Akhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_Akhir->cellAttributes() ?>>
<span id="el_detil_mata_kuliah_Nilai_Akhir">
<input type="<?= $Page->Nilai_Akhir->getInputTextType() ?>" name="x_Nilai_Akhir" id="x_Nilai_Akhir" data-table="detil_mata_kuliah" data-field="x_Nilai_Akhir" value="<?= $Page->Nilai_Akhir->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->Nilai_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Akhir->formatPattern()) ?>"<?= $Page->Nilai_Akhir->editAttributes() ?> aria-describedby="x_Nilai_Akhir_help">
<?= $Page->Nilai_Akhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_Akhir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdetil_mata_kuliahedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdetil_mata_kuliahedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdetil_mata_kuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdetil_mata_kuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("detil_mata_kuliah");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fdetil_mata_kuliahedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
