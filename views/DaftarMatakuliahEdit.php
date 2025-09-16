<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DaftarMatakuliahEdit = &$Page;
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
<form name="fdaftar_matakuliahedit" id="fdaftar_matakuliahedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { daftar_matakuliah: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdaftar_matakuliahedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdaftar_matakuliahedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Kode", [fields.Kode.visible && fields.Kode.required ? ew.Validators.required(fields.Kode.caption) : null], fields.Kode.isInvalid],
            ["Nama", [fields.Nama.visible && fields.Nama.required ? ew.Validators.required(fields.Nama.caption) : null], fields.Nama.isInvalid],
            ["SKS", [fields.SKS.visible && fields.SKS.required ? ew.Validators.required(fields.SKS.caption) : null], fields.SKS.isInvalid]
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
<input type="hidden" name="t" value="daftar_matakuliah">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Kode->Visible) { // Kode ?>
    <div id="r_Kode"<?= $Page->Kode->rowAttributes() ?>>
        <label id="elh_daftar_matakuliah_Kode" for="x_Kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kode->caption() ?><?= $Page->Kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kode->cellAttributes() ?>>
<span id="el_daftar_matakuliah_Kode">
<input type="<?= $Page->Kode->getInputTextType() ?>" name="x_Kode" id="x_Kode" data-table="daftar_matakuliah" data-field="x_Kode" value="<?= $Page->Kode->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Kode->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode->formatPattern()) ?>"<?= $Page->Kode->editAttributes() ?> aria-describedby="x_Kode_help">
<?= $Page->Kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kode->getErrorMessage() ?></div>
<input type="hidden" data-table="daftar_matakuliah" data-field="x_Kode" data-hidden="1" data-old name="o_Kode" id="o_Kode" value="<?= HtmlEncode($Page->Kode->OldValue ?? $Page->Kode->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
    <div id="r_Nama"<?= $Page->Nama->rowAttributes() ?>>
        <label id="elh_daftar_matakuliah_Nama" for="x_Nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama->caption() ?><?= $Page->Nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama->cellAttributes() ?>>
<span id="el_daftar_matakuliah_Nama">
<input type="<?= $Page->Nama->getInputTextType() ?>" name="x_Nama" id="x_Nama" data-table="daftar_matakuliah" data-field="x_Nama" value="<?= $Page->Nama->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Nama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama->formatPattern()) ?>"<?= $Page->Nama->editAttributes() ?> aria-describedby="x_Nama_help">
<?= $Page->Nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SKS->Visible) { // SKS ?>
    <div id="r_SKS"<?= $Page->SKS->rowAttributes() ?>>
        <label id="elh_daftar_matakuliah_SKS" for="x_SKS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SKS->caption() ?><?= $Page->SKS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->SKS->cellAttributes() ?>>
<span id="el_daftar_matakuliah_SKS">
<input type="<?= $Page->SKS->getInputTextType() ?>" name="x_SKS" id="x_SKS" data-table="daftar_matakuliah" data-field="x_SKS" value="<?= $Page->SKS->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->SKS->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->SKS->formatPattern()) ?>"<?= $Page->SKS->editAttributes() ?> aria-describedby="x_SKS_help">
<?= $Page->SKS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SKS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdaftar_matakuliahedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdaftar_matakuliahedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdaftar_matakuliahedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdaftar_matakuliahedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("daftar_matakuliah");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fdaftar_matakuliahedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
