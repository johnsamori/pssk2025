<?php

namespace PHPMaker2025\pssk2025;

// Page object
$SemesterAntaraEdit = &$Page;
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
<form name="fsemester_antaraedit" id="fsemester_antaraedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { semester_antara: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsemester_antaraedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsemester_antaraedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_smtr", [fields.id_smtr.visible && fields.id_smtr.required ? ew.Validators.required(fields.id_smtr.caption) : null], fields.id_smtr.isInvalid],
            ["Semester", [fields.Semester.visible && fields.Semester.required ? ew.Validators.required(fields.Semester.caption) : null], fields.Semester.isInvalid],
            ["Jadwal", [fields.Jadwal.visible && fields.Jadwal.required ? ew.Validators.required(fields.Jadwal.caption) : null], fields.Jadwal.isInvalid],
            ["Tahun_Akademik", [fields.Tahun_Akademik.visible && fields.Tahun_Akademik.required ? ew.Validators.required(fields.Tahun_Akademik.caption) : null], fields.Tahun_Akademik.isInvalid],
            ["Tanggal", [fields.Tanggal.visible && fields.Tanggal.required ? ew.Validators.required(fields.Tanggal.caption) : null, ew.Validators.datetime(fields.Tanggal.clientFormatPattern)], fields.Tanggal.isInvalid],
            ["User_id", [fields.User_id.visible && fields.User_id.required ? ew.Validators.required(fields.User_id.caption) : null, ew.Validators.integer], fields.User_id.isInvalid],
            ["User", [fields.User.visible && fields.User.required ? ew.Validators.required(fields.User.caption) : null], fields.User.isInvalid],
            ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
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
<input type="hidden" name="t" value="semester_antara">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_smtr->Visible) { // id_smtr ?>
    <div id="r_id_smtr"<?= $Page->id_smtr->rowAttributes() ?>>
        <label id="elh_semester_antara_id_smtr" for="x_id_smtr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_smtr->caption() ?><?= $Page->id_smtr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_smtr->cellAttributes() ?>>
<span id="el_semester_antara_id_smtr">
<input type="<?= $Page->id_smtr->getInputTextType() ?>" name="x_id_smtr" id="x_id_smtr" data-table="semester_antara" data-field="x_id_smtr" value="<?= $Page->id_smtr->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->id_smtr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_smtr->formatPattern()) ?>"<?= $Page->id_smtr->editAttributes() ?> aria-describedby="x_id_smtr_help">
<?= $Page->id_smtr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_smtr->getErrorMessage() ?></div>
<input type="hidden" data-table="semester_antara" data-field="x_id_smtr" data-hidden="1" data-old name="o_id_smtr" id="o_id_smtr" value="<?= HtmlEncode($Page->id_smtr->OldValue ?? $Page->id_smtr->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Semester->Visible) { // Semester ?>
    <div id="r_Semester"<?= $Page->Semester->rowAttributes() ?>>
        <label id="elh_semester_antara_Semester" for="x_Semester" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Semester->caption() ?><?= $Page->Semester->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Semester->cellAttributes() ?>>
<span id="el_semester_antara_Semester">
<input type="<?= $Page->Semester->getInputTextType() ?>" name="x_Semester" id="x_Semester" data-table="semester_antara" data-field="x_Semester" value="<?= $Page->Semester->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Semester->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Semester->formatPattern()) ?>"<?= $Page->Semester->editAttributes() ?> aria-describedby="x_Semester_help">
<?= $Page->Semester->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Semester->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jadwal->Visible) { // Jadwal ?>
    <div id="r_Jadwal"<?= $Page->Jadwal->rowAttributes() ?>>
        <label id="elh_semester_antara_Jadwal" for="x_Jadwal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jadwal->caption() ?><?= $Page->Jadwal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jadwal->cellAttributes() ?>>
<span id="el_semester_antara_Jadwal">
<input type="<?= $Page->Jadwal->getInputTextType() ?>" name="x_Jadwal" id="x_Jadwal" data-table="semester_antara" data-field="x_Jadwal" value="<?= $Page->Jadwal->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Jadwal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jadwal->formatPattern()) ?>"<?= $Page->Jadwal->editAttributes() ?> aria-describedby="x_Jadwal_help">
<?= $Page->Jadwal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jadwal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tahun_Akademik->Visible) { // Tahun_Akademik ?>
    <div id="r_Tahun_Akademik"<?= $Page->Tahun_Akademik->rowAttributes() ?>>
        <label id="elh_semester_antara_Tahun_Akademik" for="x_Tahun_Akademik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tahun_Akademik->caption() ?><?= $Page->Tahun_Akademik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tahun_Akademik->cellAttributes() ?>>
<span id="el_semester_antara_Tahun_Akademik">
<input type="<?= $Page->Tahun_Akademik->getInputTextType() ?>" name="x_Tahun_Akademik" id="x_Tahun_Akademik" data-table="semester_antara" data-field="x_Tahun_Akademik" value="<?= $Page->Tahun_Akademik->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Tahun_Akademik->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tahun_Akademik->formatPattern()) ?>"<?= $Page->Tahun_Akademik->editAttributes() ?> aria-describedby="x_Tahun_Akademik_help">
<?= $Page->Tahun_Akademik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tahun_Akademik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
    <div id="r_Tanggal"<?= $Page->Tanggal->rowAttributes() ?>>
        <label id="elh_semester_antara_Tanggal" for="x_Tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tanggal->caption() ?><?= $Page->Tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el_semester_antara_Tanggal">
<input type="<?= $Page->Tanggal->getInputTextType() ?>" name="x_Tanggal" id="x_Tanggal" data-table="semester_antara" data-field="x_Tanggal" value="<?= $Page->Tanggal->getEditValue() ?>" placeholder="<?= HtmlEncode($Page->Tanggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tanggal->formatPattern()) ?>"<?= $Page->Tanggal->editAttributes() ?> aria-describedby="x_Tanggal_help">
<?= $Page->Tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tanggal->getErrorMessage() ?></div>
<?php if (!$Page->Tanggal->ReadOnly && !$Page->Tanggal->Disabled && !isset($Page->Tanggal->EditAttrs["readonly"]) && !isset($Page->Tanggal->EditAttrs["disabled"])) { ?>
<script<?= Nonce() ?>>
loadjs.ready(["fsemester_antaraedit", "datetimepicker"], function () {
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
        "fsemester_antaraedit",
        "x_Tanggal",
        ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options),
        {"inputGroup":true}
    );
});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready(['fsemester_antaraedit', 'jqueryinputmask'], function() {
	options = {
		'jitMasking': false,
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fsemester_antaraedit", "x_Tanggal", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->User_id->Visible) { // User_id ?>
    <div id="r_User_id"<?= $Page->User_id->rowAttributes() ?>>
        <label id="elh_semester_antara_User_id" for="x_User_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User_id->caption() ?><?= $Page->User_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->User_id->cellAttributes() ?>>
<span id="el_semester_antara_User_id">
<input type="<?= $Page->User_id->getInputTextType() ?>" name="x_User_id" id="x_User_id" data-table="semester_antara" data-field="x_User_id" value="<?= $Page->User_id->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->User_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_id->formatPattern()) ?>"<?= $Page->User_id->editAttributes() ?> aria-describedby="x_User_id_help">
<?= $Page->User_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_id->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fsemester_antaraedit', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fsemester_antaraedit", "x_User_id", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
    <div id="r_User"<?= $Page->User->rowAttributes() ?>>
        <label id="elh_semester_antara_User" for="x_User" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User->caption() ?><?= $Page->User->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->User->cellAttributes() ?>>
<span id="el_semester_antara_User">
<input type="<?= $Page->User->getInputTextType() ?>" name="x_User" id="x_User" data-table="semester_antara" data-field="x_User" value="<?= $Page->User->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->User->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User->formatPattern()) ?>"<?= $Page->User->editAttributes() ?> aria-describedby="x_User_help">
<?= $Page->User->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <div id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <label id="elh_semester_antara_IP" for="x_IP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IP->caption() ?><?= $Page->IP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->IP->cellAttributes() ?>>
<span id="el_semester_antara_IP">
<input type="<?= $Page->IP->getInputTextType() ?>" name="x_IP" id="x_IP" data-table="semester_antara" data-field="x_IP" value="<?= $Page->IP->getEditValue() ?>" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->IP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->IP->formatPattern()) ?>"<?= $Page->IP->editAttributes() ?> aria-describedby="x_IP_help">
<?= $Page->IP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("detil_semester_antara", explode(",", $Page->getCurrentDetailTable())) && $detil_semester_antara->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php if (Container("detil_semester_antara")->Count > 0) { // Begin of added by Masino Sinaga, September 16, 2023 ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_semester_antara", "TblCaption") ?></h4>
<?php } else { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("detil_semester_antara", "TblCaption") ?></h4>
<?php } // End of added by Masino Sinaga, September 16, 2023 ?>
<?php } ?>
<?php include_once "DetilSemesterAntaraGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsemester_antaraedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsemester_antaraedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fsemester_antaraedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fsemester_antaraedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("semester_antara");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fsemester_antaraedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
