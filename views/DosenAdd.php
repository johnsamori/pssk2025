<?php

namespace PHPMaker2025\pssk2025;

// Page object
$DosenAdd = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fdosenadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdosenadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["No", [fields.No.visible && fields.No.required ? ew.Validators.required(fields.No.caption) : null], fields.No.isInvalid],
            ["NIP", [fields.NIP.visible && fields.NIP.required ? ew.Validators.required(fields.NIP.caption) : null], fields.NIP.isInvalid],
            ["NIDN", [fields.NIDN.visible && fields.NIDN.required ? ew.Validators.required(fields.NIDN.caption) : null], fields.NIDN.isInvalid],
            ["Nama_Lengkap", [fields.Nama_Lengkap.visible && fields.Nama_Lengkap.required ? ew.Validators.required(fields.Nama_Lengkap.caption) : null], fields.Nama_Lengkap.isInvalid],
            ["Gelar_Depan", [fields.Gelar_Depan.visible && fields.Gelar_Depan.required ? ew.Validators.required(fields.Gelar_Depan.caption) : null], fields.Gelar_Depan.isInvalid],
            ["Gelar_Belakang", [fields.Gelar_Belakang.visible && fields.Gelar_Belakang.required ? ew.Validators.required(fields.Gelar_Belakang.caption) : null], fields.Gelar_Belakang.isInvalid],
            ["Program_studi", [fields.Program_studi.visible && fields.Program_studi.required ? ew.Validators.required(fields.Program_studi.caption) : null], fields.Program_studi.isInvalid],
            ["NIK", [fields.NIK.visible && fields.NIK.required ? ew.Validators.required(fields.NIK.caption) : null], fields.NIK.isInvalid],
            ["Tanggal_lahir", [fields.Tanggal_lahir.visible && fields.Tanggal_lahir.required ? ew.Validators.required(fields.Tanggal_lahir.caption) : null, ew.Validators.datetime(fields.Tanggal_lahir.clientFormatPattern)], fields.Tanggal_lahir.isInvalid],
            ["Tempat_lahir", [fields.Tempat_lahir.visible && fields.Tempat_lahir.required ? ew.Validators.required(fields.Tempat_lahir.caption) : null], fields.Tempat_lahir.isInvalid],
            ["Nomor_Karpeg", [fields.Nomor_Karpeg.visible && fields.Nomor_Karpeg.required ? ew.Validators.required(fields.Nomor_Karpeg.caption) : null], fields.Nomor_Karpeg.isInvalid],
            ["Nomor_Stambuk", [fields.Nomor_Stambuk.visible && fields.Nomor_Stambuk.required ? ew.Validators.required(fields.Nomor_Stambuk.caption) : null], fields.Nomor_Stambuk.isInvalid],
            ["Jenis_kelamin", [fields.Jenis_kelamin.visible && fields.Jenis_kelamin.required ? ew.Validators.required(fields.Jenis_kelamin.caption) : null], fields.Jenis_kelamin.isInvalid],
            ["Gol_Darah", [fields.Gol_Darah.visible && fields.Gol_Darah.required ? ew.Validators.required(fields.Gol_Darah.caption) : null], fields.Gol_Darah.isInvalid],
            ["Agama", [fields.Agama.visible && fields.Agama.required ? ew.Validators.required(fields.Agama.caption) : null], fields.Agama.isInvalid],
            ["Stattus_menikah", [fields.Stattus_menikah.visible && fields.Stattus_menikah.required ? ew.Validators.required(fields.Stattus_menikah.caption) : null], fields.Stattus_menikah.isInvalid],
            ["Alamat", [fields.Alamat.visible && fields.Alamat.required ? ew.Validators.required(fields.Alamat.caption) : null], fields.Alamat.isInvalid],
            ["Kota", [fields.Kota.visible && fields.Kota.required ? ew.Validators.required(fields.Kota.caption) : null], fields.Kota.isInvalid],
            ["Telepon_seluler", [fields.Telepon_seluler.visible && fields.Telepon_seluler.required ? ew.Validators.required(fields.Telepon_seluler.caption) : null], fields.Telepon_seluler.isInvalid],
            ["Jenis_pegawai", [fields.Jenis_pegawai.visible && fields.Jenis_pegawai.required ? ew.Validators.required(fields.Jenis_pegawai.caption) : null], fields.Jenis_pegawai.isInvalid],
            ["Status_pegawai", [fields.Status_pegawai.visible && fields.Status_pegawai.required ? ew.Validators.required(fields.Status_pegawai.caption) : null], fields.Status_pegawai.isInvalid],
            ["Golongan", [fields.Golongan.visible && fields.Golongan.required ? ew.Validators.required(fields.Golongan.caption) : null], fields.Golongan.isInvalid],
            ["Pangkat", [fields.Pangkat.visible && fields.Pangkat.required ? ew.Validators.required(fields.Pangkat.caption) : null], fields.Pangkat.isInvalid],
            ["Status_dosen", [fields.Status_dosen.visible && fields.Status_dosen.required ? ew.Validators.required(fields.Status_dosen.caption) : null], fields.Status_dosen.isInvalid],
            ["Status_Belajar", [fields.Status_Belajar.visible && fields.Status_Belajar.required ? ew.Validators.required(fields.Status_Belajar.caption) : null], fields.Status_Belajar.isInvalid],
            ["e_mail", [fields.e_mail.visible && fields.e_mail.required ? ew.Validators.required(fields.e_mail.caption) : null], fields.e_mail.isInvalid]
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
<form name="fdosenadd" id="fdosenadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="dosen">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->No->Visible) { // No ?>
    <div id="r_No"<?= $Page->No->rowAttributes() ?>>
        <label id="elh_dosen_No" for="x_No" class="<?= $Page->LeftColumnClass ?>"><?= $Page->No->caption() ?><?= $Page->No->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->No->cellAttributes() ?>>
<span id="el_dosen_No">
<input type="<?= $Page->No->getInputTextType() ?>" name="x_No" id="x_No" data-table="dosen" data-field="x_No" value="<?= $Page->No->getEditValue() ?>" size="30" maxlength="5" placeholder="<?= HtmlEncode($Page->No->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->No->formatPattern()) ?>"<?= $Page->No->editAttributes() ?> aria-describedby="x_No_help">
<?= $Page->No->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->No->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIP->Visible) { // NIP ?>
    <div id="r_NIP"<?= $Page->NIP->rowAttributes() ?>>
        <label id="elh_dosen_NIP" for="x_NIP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIP->caption() ?><?= $Page->NIP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIP->cellAttributes() ?>>
<span id="el_dosen_NIP">
<input type="<?= $Page->NIP->getInputTextType() ?>" name="x_NIP" id="x_NIP" data-table="dosen" data-field="x_NIP" value="<?= $Page->NIP->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NIP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIP->formatPattern()) ?>"<?= $Page->NIP->editAttributes() ?> aria-describedby="x_NIP_help">
<?= $Page->NIP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIDN->Visible) { // NIDN ?>
    <div id="r_NIDN"<?= $Page->NIDN->rowAttributes() ?>>
        <label id="elh_dosen_NIDN" for="x_NIDN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIDN->caption() ?><?= $Page->NIDN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIDN->cellAttributes() ?>>
<span id="el_dosen_NIDN">
<input type="<?= $Page->NIDN->getInputTextType() ?>" name="x_NIDN" id="x_NIDN" data-table="dosen" data-field="x_NIDN" value="<?= $Page->NIDN->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NIDN->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIDN->formatPattern()) ?>"<?= $Page->NIDN->editAttributes() ?> aria-describedby="x_NIDN_help">
<?= $Page->NIDN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIDN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
    <div id="r_Nama_Lengkap"<?= $Page->Nama_Lengkap->rowAttributes() ?>>
        <label id="elh_dosen_Nama_Lengkap" for="x_Nama_Lengkap" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Lengkap->caption() ?><?= $Page->Nama_Lengkap->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el_dosen_Nama_Lengkap">
<input type="<?= $Page->Nama_Lengkap->getInputTextType() ?>" name="x_Nama_Lengkap" id="x_Nama_Lengkap" data-table="dosen" data-field="x_Nama_Lengkap" value="<?= $Page->Nama_Lengkap->getEditValue() ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->Nama_Lengkap->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Lengkap->formatPattern()) ?>"<?= $Page->Nama_Lengkap->editAttributes() ?> aria-describedby="x_Nama_Lengkap_help">
<?= $Page->Nama_Lengkap->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Lengkap->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Gelar_Depan->Visible) { // Gelar_Depan ?>
    <div id="r_Gelar_Depan"<?= $Page->Gelar_Depan->rowAttributes() ?>>
        <label id="elh_dosen_Gelar_Depan" for="x_Gelar_Depan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Gelar_Depan->caption() ?><?= $Page->Gelar_Depan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Gelar_Depan->cellAttributes() ?>>
<span id="el_dosen_Gelar_Depan">
<input type="<?= $Page->Gelar_Depan->getInputTextType() ?>" name="x_Gelar_Depan" id="x_Gelar_Depan" data-table="dosen" data-field="x_Gelar_Depan" value="<?= $Page->Gelar_Depan->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Gelar_Depan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Gelar_Depan->formatPattern()) ?>"<?= $Page->Gelar_Depan->editAttributes() ?> aria-describedby="x_Gelar_Depan_help">
<?= $Page->Gelar_Depan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Gelar_Depan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Gelar_Belakang->Visible) { // Gelar_Belakang ?>
    <div id="r_Gelar_Belakang"<?= $Page->Gelar_Belakang->rowAttributes() ?>>
        <label id="elh_dosen_Gelar_Belakang" for="x_Gelar_Belakang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Gelar_Belakang->caption() ?><?= $Page->Gelar_Belakang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Gelar_Belakang->cellAttributes() ?>>
<span id="el_dosen_Gelar_Belakang">
<input type="<?= $Page->Gelar_Belakang->getInputTextType() ?>" name="x_Gelar_Belakang" id="x_Gelar_Belakang" data-table="dosen" data-field="x_Gelar_Belakang" value="<?= $Page->Gelar_Belakang->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Gelar_Belakang->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Gelar_Belakang->formatPattern()) ?>"<?= $Page->Gelar_Belakang->editAttributes() ?> aria-describedby="x_Gelar_Belakang_help">
<?= $Page->Gelar_Belakang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Gelar_Belakang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Program_studi->Visible) { // Program_studi ?>
    <div id="r_Program_studi"<?= $Page->Program_studi->rowAttributes() ?>>
        <label id="elh_dosen_Program_studi" for="x_Program_studi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Program_studi->caption() ?><?= $Page->Program_studi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Program_studi->cellAttributes() ?>>
<span id="el_dosen_Program_studi">
<input type="<?= $Page->Program_studi->getInputTextType() ?>" name="x_Program_studi" id="x_Program_studi" data-table="dosen" data-field="x_Program_studi" value="<?= $Page->Program_studi->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Program_studi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Program_studi->formatPattern()) ?>"<?= $Page->Program_studi->editAttributes() ?> aria-describedby="x_Program_studi_help">
<?= $Page->Program_studi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Program_studi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIK->Visible) { // NIK ?>
    <div id="r_NIK"<?= $Page->NIK->rowAttributes() ?>>
        <label id="elh_dosen_NIK" for="x_NIK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIK->caption() ?><?= $Page->NIK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIK->cellAttributes() ?>>
<span id="el_dosen_NIK">
<input type="<?= $Page->NIK->getInputTextType() ?>" name="x_NIK" id="x_NIK" data-table="dosen" data-field="x_NIK" value="<?= $Page->NIK->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->NIK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIK->formatPattern()) ?>"<?= $Page->NIK->editAttributes() ?> aria-describedby="x_NIK_help">
<?= $Page->NIK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tanggal_lahir->Visible) { // Tanggal_lahir ?>
    <div id="r_Tanggal_lahir"<?= $Page->Tanggal_lahir->rowAttributes() ?>>
        <label id="elh_dosen_Tanggal_lahir" for="x_Tanggal_lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tanggal_lahir->caption() ?><?= $Page->Tanggal_lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tanggal_lahir->cellAttributes() ?>>
<span id="el_dosen_Tanggal_lahir">
<input type="<?= $Page->Tanggal_lahir->getInputTextType() ?>" name="x_Tanggal_lahir" id="x_Tanggal_lahir" data-table="dosen" data-field="x_Tanggal_lahir" value="<?= $Page->Tanggal_lahir->getEditValue() ?>" placeholder="<?= HtmlEncode($Page->Tanggal_lahir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tanggal_lahir->formatPattern()) ?>"<?= $Page->Tanggal_lahir->editAttributes() ?> aria-describedby="x_Tanggal_lahir_help">
<?= $Page->Tanggal_lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tanggal_lahir->getErrorMessage() ?></div>
<?php if (!$Page->Tanggal_lahir->ReadOnly && !$Page->Tanggal_lahir->Disabled && !isset($Page->Tanggal_lahir->EditAttrs["readonly"]) && !isset($Page->Tanggal_lahir->EditAttrs["disabled"])) { ?>
<script<?= Nonce() ?>>
loadjs.ready(["fdosenadd", "datetimepicker"], function () {
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
        "fdosenadd",
        "x_Tanggal_lahir",
        ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options),
        {"inputGroup":true}
    );
});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready(['fdosenadd', 'jqueryinputmask'], function() {
	options = {
		'jitMasking': false,
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fdosenadd", "x_Tanggal_lahir", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tempat_lahir->Visible) { // Tempat_lahir ?>
    <div id="r_Tempat_lahir"<?= $Page->Tempat_lahir->rowAttributes() ?>>
        <label id="elh_dosen_Tempat_lahir" for="x_Tempat_lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tempat_lahir->caption() ?><?= $Page->Tempat_lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tempat_lahir->cellAttributes() ?>>
<span id="el_dosen_Tempat_lahir">
<input type="<?= $Page->Tempat_lahir->getInputTextType() ?>" name="x_Tempat_lahir" id="x_Tempat_lahir" data-table="dosen" data-field="x_Tempat_lahir" value="<?= $Page->Tempat_lahir->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Tempat_lahir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tempat_lahir->formatPattern()) ?>"<?= $Page->Tempat_lahir->editAttributes() ?> aria-describedby="x_Tempat_lahir_help">
<?= $Page->Tempat_lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tempat_lahir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nomor_Karpeg->Visible) { // Nomor_Karpeg ?>
    <div id="r_Nomor_Karpeg"<?= $Page->Nomor_Karpeg->rowAttributes() ?>>
        <label id="elh_dosen_Nomor_Karpeg" for="x_Nomor_Karpeg" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nomor_Karpeg->caption() ?><?= $Page->Nomor_Karpeg->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nomor_Karpeg->cellAttributes() ?>>
<span id="el_dosen_Nomor_Karpeg">
<input type="<?= $Page->Nomor_Karpeg->getInputTextType() ?>" name="x_Nomor_Karpeg" id="x_Nomor_Karpeg" data-table="dosen" data-field="x_Nomor_Karpeg" value="<?= $Page->Nomor_Karpeg->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Nomor_Karpeg->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nomor_Karpeg->formatPattern()) ?>"<?= $Page->Nomor_Karpeg->editAttributes() ?> aria-describedby="x_Nomor_Karpeg_help">
<?= $Page->Nomor_Karpeg->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nomor_Karpeg->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nomor_Stambuk->Visible) { // Nomor_Stambuk ?>
    <div id="r_Nomor_Stambuk"<?= $Page->Nomor_Stambuk->rowAttributes() ?>>
        <label id="elh_dosen_Nomor_Stambuk" for="x_Nomor_Stambuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nomor_Stambuk->caption() ?><?= $Page->Nomor_Stambuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nomor_Stambuk->cellAttributes() ?>>
<span id="el_dosen_Nomor_Stambuk">
<input type="<?= $Page->Nomor_Stambuk->getInputTextType() ?>" name="x_Nomor_Stambuk" id="x_Nomor_Stambuk" data-table="dosen" data-field="x_Nomor_Stambuk" value="<?= $Page->Nomor_Stambuk->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Nomor_Stambuk->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nomor_Stambuk->formatPattern()) ?>"<?= $Page->Nomor_Stambuk->editAttributes() ?> aria-describedby="x_Nomor_Stambuk_help">
<?= $Page->Nomor_Stambuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nomor_Stambuk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jenis_kelamin->Visible) { // Jenis_kelamin ?>
    <div id="r_Jenis_kelamin"<?= $Page->Jenis_kelamin->rowAttributes() ?>>
        <label id="elh_dosen_Jenis_kelamin" for="x_Jenis_kelamin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenis_kelamin->caption() ?><?= $Page->Jenis_kelamin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenis_kelamin->cellAttributes() ?>>
<span id="el_dosen_Jenis_kelamin">
<input type="<?= $Page->Jenis_kelamin->getInputTextType() ?>" name="x_Jenis_kelamin" id="x_Jenis_kelamin" data-table="dosen" data-field="x_Jenis_kelamin" value="<?= $Page->Jenis_kelamin->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Jenis_kelamin->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jenis_kelamin->formatPattern()) ?>"<?= $Page->Jenis_kelamin->editAttributes() ?> aria-describedby="x_Jenis_kelamin_help">
<?= $Page->Jenis_kelamin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_kelamin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Gol_Darah->Visible) { // Gol_Darah ?>
    <div id="r_Gol_Darah"<?= $Page->Gol_Darah->rowAttributes() ?>>
        <label id="elh_dosen_Gol_Darah" for="x_Gol_Darah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Gol_Darah->caption() ?><?= $Page->Gol_Darah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Gol_Darah->cellAttributes() ?>>
<span id="el_dosen_Gol_Darah">
<input type="<?= $Page->Gol_Darah->getInputTextType() ?>" name="x_Gol_Darah" id="x_Gol_Darah" data-table="dosen" data-field="x_Gol_Darah" value="<?= $Page->Gol_Darah->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Gol_Darah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Gol_Darah->formatPattern()) ?>"<?= $Page->Gol_Darah->editAttributes() ?> aria-describedby="x_Gol_Darah_help">
<?= $Page->Gol_Darah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Gol_Darah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Agama->Visible) { // Agama ?>
    <div id="r_Agama"<?= $Page->Agama->rowAttributes() ?>>
        <label id="elh_dosen_Agama" for="x_Agama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Agama->caption() ?><?= $Page->Agama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Agama->cellAttributes() ?>>
<span id="el_dosen_Agama">
<input type="<?= $Page->Agama->getInputTextType() ?>" name="x_Agama" id="x_Agama" data-table="dosen" data-field="x_Agama" value="<?= $Page->Agama->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Agama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Agama->formatPattern()) ?>"<?= $Page->Agama->editAttributes() ?> aria-describedby="x_Agama_help">
<?= $Page->Agama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Agama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Stattus_menikah->Visible) { // Stattus_menikah ?>
    <div id="r_Stattus_menikah"<?= $Page->Stattus_menikah->rowAttributes() ?>>
        <label id="elh_dosen_Stattus_menikah" for="x_Stattus_menikah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Stattus_menikah->caption() ?><?= $Page->Stattus_menikah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Stattus_menikah->cellAttributes() ?>>
<span id="el_dosen_Stattus_menikah">
<input type="<?= $Page->Stattus_menikah->getInputTextType() ?>" name="x_Stattus_menikah" id="x_Stattus_menikah" data-table="dosen" data-field="x_Stattus_menikah" value="<?= $Page->Stattus_menikah->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Stattus_menikah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Stattus_menikah->formatPattern()) ?>"<?= $Page->Stattus_menikah->editAttributes() ?> aria-describedby="x_Stattus_menikah_help">
<?= $Page->Stattus_menikah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Stattus_menikah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
    <div id="r_Alamat"<?= $Page->Alamat->rowAttributes() ?>>
        <label id="elh_dosen_Alamat" for="x_Alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Alamat->caption() ?><?= $Page->Alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Alamat->cellAttributes() ?>>
<span id="el_dosen_Alamat">
<input type="<?= $Page->Alamat->getInputTextType() ?>" name="x_Alamat" id="x_Alamat" data-table="dosen" data-field="x_Alamat" value="<?= $Page->Alamat->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Alamat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Alamat->formatPattern()) ?>"<?= $Page->Alamat->editAttributes() ?> aria-describedby="x_Alamat_help">
<?= $Page->Alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kota->Visible) { // Kota ?>
    <div id="r_Kota"<?= $Page->Kota->rowAttributes() ?>>
        <label id="elh_dosen_Kota" for="x_Kota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kota->caption() ?><?= $Page->Kota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kota->cellAttributes() ?>>
<span id="el_dosen_Kota">
<input type="<?= $Page->Kota->getInputTextType() ?>" name="x_Kota" id="x_Kota" data-table="dosen" data-field="x_Kota" value="<?= $Page->Kota->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Kota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kota->formatPattern()) ?>"<?= $Page->Kota->editAttributes() ?> aria-describedby="x_Kota_help">
<?= $Page->Kota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Telepon_seluler->Visible) { // Telepon_seluler ?>
    <div id="r_Telepon_seluler"<?= $Page->Telepon_seluler->rowAttributes() ?>>
        <label id="elh_dosen_Telepon_seluler" for="x_Telepon_seluler" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Telepon_seluler->caption() ?><?= $Page->Telepon_seluler->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Telepon_seluler->cellAttributes() ?>>
<span id="el_dosen_Telepon_seluler">
<input type="<?= $Page->Telepon_seluler->getInputTextType() ?>" name="x_Telepon_seluler" id="x_Telepon_seluler" data-table="dosen" data-field="x_Telepon_seluler" value="<?= $Page->Telepon_seluler->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Telepon_seluler->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Telepon_seluler->formatPattern()) ?>"<?= $Page->Telepon_seluler->editAttributes() ?> aria-describedby="x_Telepon_seluler_help">
<?= $Page->Telepon_seluler->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Telepon_seluler->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jenis_pegawai->Visible) { // Jenis_pegawai ?>
    <div id="r_Jenis_pegawai"<?= $Page->Jenis_pegawai->rowAttributes() ?>>
        <label id="elh_dosen_Jenis_pegawai" for="x_Jenis_pegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenis_pegawai->caption() ?><?= $Page->Jenis_pegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenis_pegawai->cellAttributes() ?>>
<span id="el_dosen_Jenis_pegawai">
<input type="<?= $Page->Jenis_pegawai->getInputTextType() ?>" name="x_Jenis_pegawai" id="x_Jenis_pegawai" data-table="dosen" data-field="x_Jenis_pegawai" value="<?= $Page->Jenis_pegawai->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Jenis_pegawai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jenis_pegawai->formatPattern()) ?>"<?= $Page->Jenis_pegawai->editAttributes() ?> aria-describedby="x_Jenis_pegawai_help">
<?= $Page->Jenis_pegawai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_pegawai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status_pegawai->Visible) { // Status_pegawai ?>
    <div id="r_Status_pegawai"<?= $Page->Status_pegawai->rowAttributes() ?>>
        <label id="elh_dosen_Status_pegawai" for="x_Status_pegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status_pegawai->caption() ?><?= $Page->Status_pegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status_pegawai->cellAttributes() ?>>
<span id="el_dosen_Status_pegawai">
<input type="<?= $Page->Status_pegawai->getInputTextType() ?>" name="x_Status_pegawai" id="x_Status_pegawai" data-table="dosen" data-field="x_Status_pegawai" value="<?= $Page->Status_pegawai->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Status_pegawai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status_pegawai->formatPattern()) ?>"<?= $Page->Status_pegawai->editAttributes() ?> aria-describedby="x_Status_pegawai_help">
<?= $Page->Status_pegawai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status_pegawai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Golongan->Visible) { // Golongan ?>
    <div id="r_Golongan"<?= $Page->Golongan->rowAttributes() ?>>
        <label id="elh_dosen_Golongan" for="x_Golongan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Golongan->caption() ?><?= $Page->Golongan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Golongan->cellAttributes() ?>>
<span id="el_dosen_Golongan">
<input type="<?= $Page->Golongan->getInputTextType() ?>" name="x_Golongan" id="x_Golongan" data-table="dosen" data-field="x_Golongan" value="<?= $Page->Golongan->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Golongan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Golongan->formatPattern()) ?>"<?= $Page->Golongan->editAttributes() ?> aria-describedby="x_Golongan_help">
<?= $Page->Golongan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Golongan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pangkat->Visible) { // Pangkat ?>
    <div id="r_Pangkat"<?= $Page->Pangkat->rowAttributes() ?>>
        <label id="elh_dosen_Pangkat" for="x_Pangkat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pangkat->caption() ?><?= $Page->Pangkat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pangkat->cellAttributes() ?>>
<span id="el_dosen_Pangkat">
<input type="<?= $Page->Pangkat->getInputTextType() ?>" name="x_Pangkat" id="x_Pangkat" data-table="dosen" data-field="x_Pangkat" value="<?= $Page->Pangkat->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->Pangkat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pangkat->formatPattern()) ?>"<?= $Page->Pangkat->editAttributes() ?> aria-describedby="x_Pangkat_help">
<?= $Page->Pangkat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pangkat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status_dosen->Visible) { // Status_dosen ?>
    <div id="r_Status_dosen"<?= $Page->Status_dosen->rowAttributes() ?>>
        <label id="elh_dosen_Status_dosen" for="x_Status_dosen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status_dosen->caption() ?><?= $Page->Status_dosen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status_dosen->cellAttributes() ?>>
<span id="el_dosen_Status_dosen">
<input type="<?= $Page->Status_dosen->getInputTextType() ?>" name="x_Status_dosen" id="x_Status_dosen" data-table="dosen" data-field="x_Status_dosen" value="<?= $Page->Status_dosen->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->Status_dosen->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status_dosen->formatPattern()) ?>"<?= $Page->Status_dosen->editAttributes() ?> aria-describedby="x_Status_dosen_help">
<?= $Page->Status_dosen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status_dosen->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status_Belajar->Visible) { // Status_Belajar ?>
    <div id="r_Status_Belajar"<?= $Page->Status_Belajar->rowAttributes() ?>>
        <label id="elh_dosen_Status_Belajar" for="x_Status_Belajar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status_Belajar->caption() ?><?= $Page->Status_Belajar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status_Belajar->cellAttributes() ?>>
<span id="el_dosen_Status_Belajar">
<input type="<?= $Page->Status_Belajar->getInputTextType() ?>" name="x_Status_Belajar" id="x_Status_Belajar" data-table="dosen" data-field="x_Status_Belajar" value="<?= $Page->Status_Belajar->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Status_Belajar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status_Belajar->formatPattern()) ?>"<?= $Page->Status_Belajar->editAttributes() ?> aria-describedby="x_Status_Belajar_help">
<?= $Page->Status_Belajar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status_Belajar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->e_mail->Visible) { // e_mail ?>
    <div id="r_e_mail"<?= $Page->e_mail->rowAttributes() ?>>
        <label id="elh_dosen_e_mail" for="x_e_mail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->e_mail->caption() ?><?= $Page->e_mail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->e_mail->cellAttributes() ?>>
<span id="el_dosen_e_mail">
<input type="<?= $Page->e_mail->getInputTextType() ?>" name="x_e_mail" id="x_e_mail" data-table="dosen" data-field="x_e_mail" value="<?= $Page->e_mail->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->e_mail->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->e_mail->formatPattern()) ?>"<?= $Page->e_mail->editAttributes() ?> aria-describedby="x_e_mail_help">
<?= $Page->e_mail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->e_mail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdosenadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdosenadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("dosen");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fdosenadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
