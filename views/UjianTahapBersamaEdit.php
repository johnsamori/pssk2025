<?php

namespace PHPMaker2025\pssk2025;

// Page object
$UjianTahapBersamaEdit = &$Page;
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
<form name="fujian_tahap_bersamaedit" id="fujian_tahap_bersamaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ujian_tahap_bersama: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fujian_tahap_bersamaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fujian_tahap_bersamaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_utb", [fields.id_utb.visible && fields.id_utb.required ? ew.Validators.required(fields.id_utb.caption) : null], fields.id_utb.isInvalid],
            ["Ujian", [fields.Ujian.visible && fields.Ujian.required ? ew.Validators.required(fields.Ujian.caption) : null], fields.Ujian.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null, ew.Validators.datetime(fields.Tanggal.clientFormatPattern)], fields.Tanggal.isInvalid],
            ["userid", [fields.userid.visible && fields.userid.required ? ew.Validators.required(fields.userid.caption) : null], fields.userid.isInvalid],
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
<input type="hidden" name="t" value="ujian_tahap_bersama">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_utb->Visible) { // id_utb ?>
    <div id="r_id_utb"<?= $Page->id_utb->rowAttributes() ?>>
        <label id="elh_ujian_tahap_bersama_id_utb" for="x_id_utb" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_utb->caption() ?><?= $Page->id_utb->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_utb->cellAttributes() ?>>
<span id="el_ujian_tahap_bersama_id_utb">
<input type="<?= $Page->id_utb->getInputTextType() ?>" name="x_id_utb" id="x_id_utb" data-table="ujian_tahap_bersama" data-field="x_id_utb" value="<?= $Page->id_utb->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id_utb->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_utb->formatPattern()) ?>"<?= $Page->id_utb->editAttributes() ?> aria-describedby="x_id_utb_help">
<?= $Page->id_utb->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_utb->getErrorMessage() ?></div>
<input type="hidden" data-table="ujian_tahap_bersama" data-field="x_id_utb" data-hidden="1" data-old name="o_id_utb" id="o_id_utb" value="<?= HtmlEncode($Page->id_utb->OldValue ?? $Page->id_utb->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Ujian->Visible) { // Ujian ?>
    <div id="r_Ujian"<?= $Page->Ujian->rowAttributes() ?>>
        <label id="elh_ujian_tahap_bersama_Ujian" for="x_Ujian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Ujian->caption() ?><?= $Page->Ujian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Ujian->cellAttributes() ?>>
<span id="el_ujian_tahap_bersama_Ujian">
<input type="<?= $Page->Ujian->getInputTextType() ?>" name="x_Ujian" id="x_Ujian" data-table="ujian_tahap_bersama" data-field="x_Ujian" value="<?= $Page->Ujian->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->Ujian->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Ujian->formatPattern()) ?>"<?= $Page->Ujian->editAttributes() ?> aria-describedby="x_Ujian_help">
<?= $Page->Ujian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Ujian->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <div id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <label id="elh_ujian_tahap_bersama_Tanggal" for="x_Tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tanggal->caption() ?><?= $Page->Tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_ujian_tahap_bersama_Tanggal">
<input type="<?= $Page->Tanggal->getInputTextType() ?>" name="x_Tanggal" id="x_Tanggal" data-table="ujian_tahap_bersama" data-field="x_Tanggal" value="<?= $Page->Tanggal->getEditValue() ?>" placeholder="<?= HtmlEncode($Page->Tanggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tanggal->formatPattern()) ?>"<?= $Page->Tanggal->editAttributes() ?> aria-describedby="x_Tanggal_help">
<?= $Page->Tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tanggal->getErrorMessage() ?></div>
<?php if (!$Page->Tanggal->ReadOnly && !$Page->Tanggal->Disabled && !isset($Page->Tanggal->EditAttrs["readonly"]) && !isset($Page->Tanggal->EditAttrs["disabled"])) { ?>
<script<?= Nonce() ?>>
loadjs.ready(["fujian_tahap_bersamaedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker(
        "fujian_tahap_bersamaedit",
        "x_Tanggal",
        ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options),
        {"inputGroup":true}
    );
});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready(['fujian_tahap_bersamaedit', 'jqueryinputmask'], function() {
	options = {
		'jitMasking': false,
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fujian_tahap_bersamaedit", "x_Tanggal", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("detil_ujian_tahap_bersama", explode(",", $Page->getCurrentDetailTable())) && $detil_ujian_tahap_bersama->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php if (Container("detil_ujian_tahap_bersama")->Count > 0) { // Begin of added by Masino Sinaga, September 16, 2023 ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_ujian_tahap_bersama", "TblCaption") ?></h4>
<?php } else { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_ujian_tahap_bersama", "TblCaption") ?></h4>
<?php } // End of added by Masino Sinaga, September 16, 2023 ?>
<?php } ?>
<?php include_once "DetilUjianTahapBersamaGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fujian_tahap_bersamaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fujian_tahap_bersamaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fujian_tahap_bersamaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fujian_tahap_bersamaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("ujian_tahap_bersama");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fujian_tahap_bersamaedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
