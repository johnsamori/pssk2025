<?php

namespace PHPMaker2025\pssk2025;

// Page object
$PembimbinganEdit = &$Page;
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
<form name="fpembimbinganedit" id="fpembimbinganedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pembimbingan: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fpembimbinganedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpembimbinganedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id_pem", [fields.id_pem.visible && fields.id_pem.required ? ew.Validators.required(fields.id_pem.caption) : null], fields.id_pem.isInvalid],
            ["NIP_Dosen_Pembimbing", [fields.NIP_Dosen_Pembimbing.visible && fields.NIP_Dosen_Pembimbing.required ? ew.Validators.required(fields.NIP_Dosen_Pembimbing.caption) : null], fields.NIP_Dosen_Pembimbing.isInvalid],
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Catatan_Mahasiswa", [fields.Catatan_Mahasiswa.visible && fields.Catatan_Mahasiswa.required ? ew.Validators.required(fields.Catatan_Mahasiswa.caption) : null], fields.Catatan_Mahasiswa.isInvalid],
            ["Catatan_Dosen_Wali", [fields.Catatan_Dosen_Wali.visible && fields.Catatan_Dosen_Wali.required ? ew.Validators.required(fields.Catatan_Dosen_Wali.caption) : null], fields.Catatan_Dosen_Wali.isInvalid],
            ["Rekomendasi_Unit_BK", [fields.Rekomendasi_Unit_BK.visible && fields.Rekomendasi_Unit_BK.required ? ew.Validators.required(fields.Rekomendasi_Unit_BK.caption) : null], fields.Rekomendasi_Unit_BK.isInvalid],
            ["Nilai_IP_Semester", [fields.Nilai_IP_Semester.visible && fields.Nilai_IP_Semester.required ? ew.Validators.required(fields.Nilai_IP_Semester.caption) : null], fields.Nilai_IP_Semester.isInvalid],
            ["Nilai_IPK", [fields.Nilai_IPK.visible && fields.Nilai_IPK.required ? ew.Validators.required(fields.Nilai_IPK.caption) : null], fields.Nilai_IPK.isInvalid],
            ["Surat_Peringatan", [fields.Surat_Peringatan.visible && fields.Surat_Peringatan.required ? ew.Validators.required(fields.Surat_Peringatan.caption) : null], fields.Surat_Peringatan.isInvalid],
            ["Surat_Pemberitahuan", [fields.Surat_Pemberitahuan.visible && fields.Surat_Pemberitahuan.required ? ew.Validators.required(fields.Surat_Pemberitahuan.caption) : null], fields.Surat_Pemberitahuan.isInvalid],
            ["Rekomendasi_Akhir", [fields.Rekomendasi_Akhir.visible && fields.Rekomendasi_Akhir.required ? ew.Validators.required(fields.Rekomendasi_Akhir.caption) : null], fields.Rekomendasi_Akhir.isInvalid],
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
<input type="hidden" name="t" value="pembimbingan">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_pem->Visible) { // id_pem ?>
    <div id="r_id_pem"<?= $Page->id_pem->rowAttributes() ?>>
        <label id="elh_pembimbingan_id_pem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_pem->caption() ?><?= $Page->id_pem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_pem->cellAttributes() ?>>
<span id="el_pembimbingan_id_pem">
<span<?= $Page->id_pem->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_pem->getDisplayValue($Page->id_pem->getEditValue()))) ?>"></span>
<input type="hidden" data-table="pembimbingan" data-field="x_id_pem" data-hidden="1" name="x_id_pem" id="x_id_pem" value="<?= HtmlEncode($Page->id_pem->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIP_Dosen_Pembimbing->Visible) { // NIP_Dosen_Pembimbing ?>
    <div id="r_NIP_Dosen_Pembimbing"<?= $Page->NIP_Dosen_Pembimbing->rowAttributes() ?>>
        <label id="elh_pembimbingan_NIP_Dosen_Pembimbing" for="x_NIP_Dosen_Pembimbing" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIP_Dosen_Pembimbing->caption() ?><?= $Page->NIP_Dosen_Pembimbing->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIP_Dosen_Pembimbing->cellAttributes() ?>>
<span id="el_pembimbingan_NIP_Dosen_Pembimbing">
<input type="<?= $Page->NIP_Dosen_Pembimbing->getInputTextType() ?>" name="x_NIP_Dosen_Pembimbing" id="x_NIP_Dosen_Pembimbing" data-table="pembimbingan" data-field="x_NIP_Dosen_Pembimbing" value="<?= $Page->NIP_Dosen_Pembimbing->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIP_Dosen_Pembimbing->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIP_Dosen_Pembimbing->formatPattern()) ?>"<?= $Page->NIP_Dosen_Pembimbing->editAttributes() ?> aria-describedby="x_NIP_Dosen_Pembimbing_help">
<?= $Page->NIP_Dosen_Pembimbing->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIP_Dosen_Pembimbing->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_pembimbingan_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_pembimbingan_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="pembimbingan" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Catatan_Mahasiswa->Visible) { // Catatan_Mahasiswa ?>
    <div id="r_Catatan_Mahasiswa"<?= $Page->Catatan_Mahasiswa->rowAttributes() ?>>
        <label id="elh_pembimbingan_Catatan_Mahasiswa" for="x_Catatan_Mahasiswa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Catatan_Mahasiswa->caption() ?><?= $Page->Catatan_Mahasiswa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Catatan_Mahasiswa->cellAttributes() ?>>
<span id="el_pembimbingan_Catatan_Mahasiswa">
<input type="<?= $Page->Catatan_Mahasiswa->getInputTextType() ?>" name="x_Catatan_Mahasiswa" id="x_Catatan_Mahasiswa" data-table="pembimbingan" data-field="x_Catatan_Mahasiswa" value="<?= $Page->Catatan_Mahasiswa->getEditValue() ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Catatan_Mahasiswa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Catatan_Mahasiswa->formatPattern()) ?>"<?= $Page->Catatan_Mahasiswa->editAttributes() ?> aria-describedby="x_Catatan_Mahasiswa_help">
<?= $Page->Catatan_Mahasiswa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Catatan_Mahasiswa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Catatan_Dosen_Wali->Visible) { // Catatan_Dosen_Wali ?>
    <div id="r_Catatan_Dosen_Wali"<?= $Page->Catatan_Dosen_Wali->rowAttributes() ?>>
        <label id="elh_pembimbingan_Catatan_Dosen_Wali" for="x_Catatan_Dosen_Wali" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Catatan_Dosen_Wali->caption() ?><?= $Page->Catatan_Dosen_Wali->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Catatan_Dosen_Wali->cellAttributes() ?>>
<span id="el_pembimbingan_Catatan_Dosen_Wali">
<input type="<?= $Page->Catatan_Dosen_Wali->getInputTextType() ?>" name="x_Catatan_Dosen_Wali" id="x_Catatan_Dosen_Wali" data-table="pembimbingan" data-field="x_Catatan_Dosen_Wali" value="<?= $Page->Catatan_Dosen_Wali->getEditValue() ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->Catatan_Dosen_Wali->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Catatan_Dosen_Wali->formatPattern()) ?>"<?= $Page->Catatan_Dosen_Wali->editAttributes() ?> aria-describedby="x_Catatan_Dosen_Wali_help">
<?= $Page->Catatan_Dosen_Wali->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Catatan_Dosen_Wali->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Rekomendasi_Unit_BK->Visible) { // Rekomendasi_Unit_BK ?>
    <div id="r_Rekomendasi_Unit_BK"<?= $Page->Rekomendasi_Unit_BK->rowAttributes() ?>>
        <label id="elh_pembimbingan_Rekomendasi_Unit_BK" for="x_Rekomendasi_Unit_BK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rekomendasi_Unit_BK->caption() ?><?= $Page->Rekomendasi_Unit_BK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rekomendasi_Unit_BK->cellAttributes() ?>>
<span id="el_pembimbingan_Rekomendasi_Unit_BK">
<input type="<?= $Page->Rekomendasi_Unit_BK->getInputTextType() ?>" name="x_Rekomendasi_Unit_BK" id="x_Rekomendasi_Unit_BK" data-table="pembimbingan" data-field="x_Rekomendasi_Unit_BK" value="<?= $Page->Rekomendasi_Unit_BK->getEditValue() ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Rekomendasi_Unit_BK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rekomendasi_Unit_BK->formatPattern()) ?>"<?= $Page->Rekomendasi_Unit_BK->editAttributes() ?> aria-describedby="x_Rekomendasi_Unit_BK_help">
<?= $Page->Rekomendasi_Unit_BK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rekomendasi_Unit_BK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_IP_Semester->Visible) { // Nilai_IP_Semester ?>
    <div id="r_Nilai_IP_Semester"<?= $Page->Nilai_IP_Semester->rowAttributes() ?>>
        <label id="elh_pembimbingan_Nilai_IP_Semester" for="x_Nilai_IP_Semester" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_IP_Semester->caption() ?><?= $Page->Nilai_IP_Semester->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_IP_Semester->cellAttributes() ?>>
<span id="el_pembimbingan_Nilai_IP_Semester">
<input type="<?= $Page->Nilai_IP_Semester->getInputTextType() ?>" name="x_Nilai_IP_Semester" id="x_Nilai_IP_Semester" data-table="pembimbingan" data-field="x_Nilai_IP_Semester" value="<?= $Page->Nilai_IP_Semester->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->Nilai_IP_Semester->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_IP_Semester->formatPattern()) ?>"<?= $Page->Nilai_IP_Semester->editAttributes() ?> aria-describedby="x_Nilai_IP_Semester_help">
<?= $Page->Nilai_IP_Semester->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_IP_Semester->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_IPK->Visible) { // Nilai_IPK ?>
    <div id="r_Nilai_IPK"<?= $Page->Nilai_IPK->rowAttributes() ?>>
        <label id="elh_pembimbingan_Nilai_IPK" for="x_Nilai_IPK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_IPK->caption() ?><?= $Page->Nilai_IPK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_IPK->cellAttributes() ?>>
<span id="el_pembimbingan_Nilai_IPK">
<input type="<?= $Page->Nilai_IPK->getInputTextType() ?>" name="x_Nilai_IPK" id="x_Nilai_IPK" data-table="pembimbingan" data-field="x_Nilai_IPK" value="<?= $Page->Nilai_IPK->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->Nilai_IPK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_IPK->formatPattern()) ?>"<?= $Page->Nilai_IPK->editAttributes() ?> aria-describedby="x_Nilai_IPK_help">
<?= $Page->Nilai_IPK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_IPK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Surat_Peringatan->Visible) { // Surat_Peringatan ?>
    <div id="r_Surat_Peringatan"<?= $Page->Surat_Peringatan->rowAttributes() ?>>
        <label id="elh_pembimbingan_Surat_Peringatan" for="x_Surat_Peringatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Surat_Peringatan->caption() ?><?= $Page->Surat_Peringatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Surat_Peringatan->cellAttributes() ?>>
<span id="el_pembimbingan_Surat_Peringatan">
<input type="<?= $Page->Surat_Peringatan->getInputTextType() ?>" name="x_Surat_Peringatan" id="x_Surat_Peringatan" data-table="pembimbingan" data-field="x_Surat_Peringatan" value="<?= $Page->Surat_Peringatan->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Surat_Peringatan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Surat_Peringatan->formatPattern()) ?>"<?= $Page->Surat_Peringatan->editAttributes() ?> aria-describedby="x_Surat_Peringatan_help">
<?= $Page->Surat_Peringatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Peringatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Surat_Pemberitahuan->Visible) { // Surat_Pemberitahuan ?>
    <div id="r_Surat_Pemberitahuan"<?= $Page->Surat_Pemberitahuan->rowAttributes() ?>>
        <label id="elh_pembimbingan_Surat_Pemberitahuan" for="x_Surat_Pemberitahuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Surat_Pemberitahuan->caption() ?><?= $Page->Surat_Pemberitahuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Surat_Pemberitahuan->cellAttributes() ?>>
<span id="el_pembimbingan_Surat_Pemberitahuan">
<input type="<?= $Page->Surat_Pemberitahuan->getInputTextType() ?>" name="x_Surat_Pemberitahuan" id="x_Surat_Pemberitahuan" data-table="pembimbingan" data-field="x_Surat_Pemberitahuan" value="<?= $Page->Surat_Pemberitahuan->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Surat_Pemberitahuan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Surat_Pemberitahuan->formatPattern()) ?>"<?= $Page->Surat_Pemberitahuan->editAttributes() ?> aria-describedby="x_Surat_Pemberitahuan_help">
<?= $Page->Surat_Pemberitahuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Surat_Pemberitahuan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Rekomendasi_Akhir->Visible) { // Rekomendasi_Akhir ?>
    <div id="r_Rekomendasi_Akhir"<?= $Page->Rekomendasi_Akhir->rowAttributes() ?>>
        <label id="elh_pembimbingan_Rekomendasi_Akhir" for="x_Rekomendasi_Akhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rekomendasi_Akhir->caption() ?><?= $Page->Rekomendasi_Akhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rekomendasi_Akhir->cellAttributes() ?>>
<span id="el_pembimbingan_Rekomendasi_Akhir">
<input type="<?= $Page->Rekomendasi_Akhir->getInputTextType() ?>" name="x_Rekomendasi_Akhir" id="x_Rekomendasi_Akhir" data-table="pembimbingan" data-field="x_Rekomendasi_Akhir" value="<?= $Page->Rekomendasi_Akhir->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->Rekomendasi_Akhir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rekomendasi_Akhir->formatPattern()) ?>"<?= $Page->Rekomendasi_Akhir->editAttributes() ?> aria-describedby="x_Rekomendasi_Akhir_help">
<?= $Page->Rekomendasi_Akhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rekomendasi_Akhir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fpembimbinganedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fpembimbinganedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fpembimbinganedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fpembimbinganedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("pembimbingan");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fpembimbinganedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
