<?php

namespace PHPMaker2025\pssk2025;

// Page object
$MahasiswaAdd = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fmahasiswaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmahasiswaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["NIM", [fields.NIM.visible && fields.NIM.required ? ew.Validators.required(fields.NIM.caption) : null], fields.NIM.isInvalid],
            ["Nama", [fields.Nama.visible && fields.Nama.required ? ew.Validators.required(fields.Nama.caption) : null], fields.Nama.isInvalid],
            ["Jenis_Kelamin", [fields.Jenis_Kelamin.visible && fields.Jenis_Kelamin.required ? ew.Validators.required(fields.Jenis_Kelamin.caption) : null], fields.Jenis_Kelamin.isInvalid],
            ["Provinsi_Tempat_Lahir", [fields.Provinsi_Tempat_Lahir.visible && fields.Provinsi_Tempat_Lahir.required ? ew.Validators.required(fields.Provinsi_Tempat_Lahir.caption) : null], fields.Provinsi_Tempat_Lahir.isInvalid],
            ["Kota_Tempat_Lahir", [fields.Kota_Tempat_Lahir.visible && fields.Kota_Tempat_Lahir.required ? ew.Validators.required(fields.Kota_Tempat_Lahir.caption) : null], fields.Kota_Tempat_Lahir.isInvalid],
            ["Tanggal_Lahir", [fields.Tanggal_Lahir.visible && fields.Tanggal_Lahir.required ? ew.Validators.required(fields.Tanggal_Lahir.caption) : null, ew.Validators.datetime(fields.Tanggal_Lahir.clientFormatPattern)], fields.Tanggal_Lahir.isInvalid],
            ["Golongan_Darah", [fields.Golongan_Darah.visible && fields.Golongan_Darah.required ? ew.Validators.required(fields.Golongan_Darah.caption) : null], fields.Golongan_Darah.isInvalid],
            ["Tinggi_Badan", [fields.Tinggi_Badan.visible && fields.Tinggi_Badan.required ? ew.Validators.required(fields.Tinggi_Badan.caption) : null], fields.Tinggi_Badan.isInvalid],
            ["Berat_Badan", [fields.Berat_Badan.visible && fields.Berat_Badan.required ? ew.Validators.required(fields.Berat_Badan.caption) : null], fields.Berat_Badan.isInvalid],
            ["Asal_sekolah", [fields.Asal_sekolah.visible && fields.Asal_sekolah.required ? ew.Validators.required(fields.Asal_sekolah.caption) : null], fields.Asal_sekolah.isInvalid],
            ["Tahun_Ijazah", [fields.Tahun_Ijazah.visible && fields.Tahun_Ijazah.required ? ew.Validators.required(fields.Tahun_Ijazah.caption) : null], fields.Tahun_Ijazah.isInvalid],
            ["Nomor_Ijazah", [fields.Nomor_Ijazah.visible && fields.Nomor_Ijazah.required ? ew.Validators.required(fields.Nomor_Ijazah.caption) : null], fields.Nomor_Ijazah.isInvalid],
            ["Nilai_Raport_Kelas_10", [fields.Nilai_Raport_Kelas_10.visible && fields.Nilai_Raport_Kelas_10.required ? ew.Validators.required(fields.Nilai_Raport_Kelas_10.caption) : null, ew.Validators.integer], fields.Nilai_Raport_Kelas_10.isInvalid],
            ["Nilai_Raport_Kelas_11", [fields.Nilai_Raport_Kelas_11.visible && fields.Nilai_Raport_Kelas_11.required ? ew.Validators.required(fields.Nilai_Raport_Kelas_11.caption) : null, ew.Validators.integer], fields.Nilai_Raport_Kelas_11.isInvalid],
            ["Nilai_Raport_Kelas_12", [fields.Nilai_Raport_Kelas_12.visible && fields.Nilai_Raport_Kelas_12.required ? ew.Validators.required(fields.Nilai_Raport_Kelas_12.caption) : null, ew.Validators.integer], fields.Nilai_Raport_Kelas_12.isInvalid],
            ["Tanggal_Daftar", [fields.Tanggal_Daftar.visible && fields.Tanggal_Daftar.required ? ew.Validators.required(fields.Tanggal_Daftar.caption) : null, ew.Validators.datetime(fields.Tanggal_Daftar.clientFormatPattern)], fields.Tanggal_Daftar.isInvalid],
            ["No_Test", [fields.No_Test.visible && fields.No_Test.required ? ew.Validators.required(fields.No_Test.caption) : null], fields.No_Test.isInvalid],
            ["Status_Masuk", [fields.Status_Masuk.visible && fields.Status_Masuk.required ? ew.Validators.required(fields.Status_Masuk.caption) : null], fields.Status_Masuk.isInvalid],
            ["Jalur_Masuk", [fields.Jalur_Masuk.visible && fields.Jalur_Masuk.required ? ew.Validators.required(fields.Jalur_Masuk.caption) : null], fields.Jalur_Masuk.isInvalid],
            ["Bukti_Lulus", [fields.Bukti_Lulus.visible && fields.Bukti_Lulus.required ? ew.Validators.required(fields.Bukti_Lulus.caption) : null], fields.Bukti_Lulus.isInvalid],
            ["Tes_Potensi_Akademik", [fields.Tes_Potensi_Akademik.visible && fields.Tes_Potensi_Akademik.required ? ew.Validators.required(fields.Tes_Potensi_Akademik.caption) : null, ew.Validators.integer], fields.Tes_Potensi_Akademik.isInvalid],
            ["Tes_Wawancara", [fields.Tes_Wawancara.visible && fields.Tes_Wawancara.required ? ew.Validators.required(fields.Tes_Wawancara.caption) : null, ew.Validators.integer], fields.Tes_Wawancara.isInvalid],
            ["Tes_Kesehatan", [fields.Tes_Kesehatan.visible && fields.Tes_Kesehatan.required ? ew.Validators.required(fields.Tes_Kesehatan.caption) : null, ew.Validators.integer], fields.Tes_Kesehatan.isInvalid],
            ["Hasil_Test_Kesehatan", [fields.Hasil_Test_Kesehatan.visible && fields.Hasil_Test_Kesehatan.required ? ew.Validators.required(fields.Hasil_Test_Kesehatan.caption) : null], fields.Hasil_Test_Kesehatan.isInvalid],
            ["Test_MMPI", [fields.Test_MMPI.visible && fields.Test_MMPI.required ? ew.Validators.required(fields.Test_MMPI.caption) : null, ew.Validators.integer], fields.Test_MMPI.isInvalid],
            ["Hasil_Test_MMPI", [fields.Hasil_Test_MMPI.visible && fields.Hasil_Test_MMPI.required ? ew.Validators.required(fields.Hasil_Test_MMPI.caption) : null], fields.Hasil_Test_MMPI.isInvalid],
            ["Angkatan", [fields.Angkatan.visible && fields.Angkatan.required ? ew.Validators.required(fields.Angkatan.caption) : null], fields.Angkatan.isInvalid],
            ["Tarif_SPP", [fields.Tarif_SPP.visible && fields.Tarif_SPP.required ? ew.Validators.required(fields.Tarif_SPP.caption) : null, ew.Validators.integer], fields.Tarif_SPP.isInvalid],
            ["NIK_No_KTP", [fields.NIK_No_KTP.visible && fields.NIK_No_KTP.required ? ew.Validators.required(fields.NIK_No_KTP.caption) : null], fields.NIK_No_KTP.isInvalid],
            ["No_KK", [fields.No_KK.visible && fields.No_KK.required ? ew.Validators.required(fields.No_KK.caption) : null], fields.No_KK.isInvalid],
            ["NPWP", [fields.NPWP.visible && fields.NPWP.required ? ew.Validators.required(fields.NPWP.caption) : null], fields.NPWP.isInvalid],
            ["Status_Nikah", [fields.Status_Nikah.visible && fields.Status_Nikah.required ? ew.Validators.required(fields.Status_Nikah.caption) : null], fields.Status_Nikah.isInvalid],
            ["Kewarganegaraan", [fields.Kewarganegaraan.visible && fields.Kewarganegaraan.required ? ew.Validators.required(fields.Kewarganegaraan.caption) : null], fields.Kewarganegaraan.isInvalid],
            ["Propinsi_Tempat_Tinggal", [fields.Propinsi_Tempat_Tinggal.visible && fields.Propinsi_Tempat_Tinggal.required ? ew.Validators.required(fields.Propinsi_Tempat_Tinggal.caption) : null], fields.Propinsi_Tempat_Tinggal.isInvalid],
            ["Kota_Tempat_Tinggal", [fields.Kota_Tempat_Tinggal.visible && fields.Kota_Tempat_Tinggal.required ? ew.Validators.required(fields.Kota_Tempat_Tinggal.caption) : null], fields.Kota_Tempat_Tinggal.isInvalid],
            ["Kecamatan_Tempat_Tinggal", [fields.Kecamatan_Tempat_Tinggal.visible && fields.Kecamatan_Tempat_Tinggal.required ? ew.Validators.required(fields.Kecamatan_Tempat_Tinggal.caption) : null], fields.Kecamatan_Tempat_Tinggal.isInvalid],
            ["Alamat_Tempat_Tinggal", [fields.Alamat_Tempat_Tinggal.visible && fields.Alamat_Tempat_Tinggal.required ? ew.Validators.required(fields.Alamat_Tempat_Tinggal.caption) : null], fields.Alamat_Tempat_Tinggal.isInvalid],
            ["RT", [fields.RT.visible && fields.RT.required ? ew.Validators.required(fields.RT.caption) : null], fields.RT.isInvalid],
            ["RW", [fields.RW.visible && fields.RW.required ? ew.Validators.required(fields.RW.caption) : null], fields.RW.isInvalid],
            ["Kelurahan", [fields.Kelurahan.visible && fields.Kelurahan.required ? ew.Validators.required(fields.Kelurahan.caption) : null], fields.Kelurahan.isInvalid],
            ["Kode_Pos", [fields.Kode_Pos.visible && fields.Kode_Pos.required ? ew.Validators.required(fields.Kode_Pos.caption) : null], fields.Kode_Pos.isInvalid],
            ["Nomor_Telpon_HP", [fields.Nomor_Telpon_HP.visible && fields.Nomor_Telpon_HP.required ? ew.Validators.required(fields.Nomor_Telpon_HP.caption) : null], fields.Nomor_Telpon_HP.isInvalid],
            ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null], fields._Email.isInvalid],
            ["Jenis_Tinggal", [fields.Jenis_Tinggal.visible && fields.Jenis_Tinggal.required ? ew.Validators.required(fields.Jenis_Tinggal.caption) : null], fields.Jenis_Tinggal.isInvalid],
            ["Alat_Transportasi", [fields.Alat_Transportasi.visible && fields.Alat_Transportasi.required ? ew.Validators.required(fields.Alat_Transportasi.caption) : null], fields.Alat_Transportasi.isInvalid],
            ["Sumber_Dana", [fields.Sumber_Dana.visible && fields.Sumber_Dana.required ? ew.Validators.required(fields.Sumber_Dana.caption) : null], fields.Sumber_Dana.isInvalid],
            ["Sumber_Dana_Beasiswa", [fields.Sumber_Dana_Beasiswa.visible && fields.Sumber_Dana_Beasiswa.required ? ew.Validators.required(fields.Sumber_Dana_Beasiswa.caption) : null], fields.Sumber_Dana_Beasiswa.isInvalid],
            ["Jumlah_Sudara", [fields.Jumlah_Sudara.visible && fields.Jumlah_Sudara.required ? ew.Validators.required(fields.Jumlah_Sudara.caption) : null], fields.Jumlah_Sudara.isInvalid],
            ["Status_Bekerja", [fields.Status_Bekerja.visible && fields.Status_Bekerja.required ? ew.Validators.required(fields.Status_Bekerja.caption) : null], fields.Status_Bekerja.isInvalid],
            ["Nomor_Asuransi", [fields.Nomor_Asuransi.visible && fields.Nomor_Asuransi.required ? ew.Validators.required(fields.Nomor_Asuransi.caption) : null], fields.Nomor_Asuransi.isInvalid],
            ["Hobi", [fields.Hobi.visible && fields.Hobi.required ? ew.Validators.required(fields.Hobi.caption) : null], fields.Hobi.isInvalid],
            ["Foto", [fields.Foto.visible && fields.Foto.required ? ew.Validators.required(fields.Foto.caption) : null], fields.Foto.isInvalid],
            ["Nama_Ayah", [fields.Nama_Ayah.visible && fields.Nama_Ayah.required ? ew.Validators.required(fields.Nama_Ayah.caption) : null], fields.Nama_Ayah.isInvalid],
            ["Pekerjaan_Ayah", [fields.Pekerjaan_Ayah.visible && fields.Pekerjaan_Ayah.required ? ew.Validators.required(fields.Pekerjaan_Ayah.caption) : null], fields.Pekerjaan_Ayah.isInvalid],
            ["Nama_Ibu", [fields.Nama_Ibu.visible && fields.Nama_Ibu.required ? ew.Validators.required(fields.Nama_Ibu.caption) : null], fields.Nama_Ibu.isInvalid],
            ["Pekerjaan_Ibu", [fields.Pekerjaan_Ibu.visible && fields.Pekerjaan_Ibu.required ? ew.Validators.required(fields.Pekerjaan_Ibu.caption) : null], fields.Pekerjaan_Ibu.isInvalid],
            ["Alamat_Orang_Tua", [fields.Alamat_Orang_Tua.visible && fields.Alamat_Orang_Tua.required ? ew.Validators.required(fields.Alamat_Orang_Tua.caption) : null], fields.Alamat_Orang_Tua.isInvalid],
            ["e_mail_Oranng_Tua", [fields.e_mail_Oranng_Tua.visible && fields.e_mail_Oranng_Tua.required ? ew.Validators.required(fields.e_mail_Oranng_Tua.caption) : null], fields.e_mail_Oranng_Tua.isInvalid],
            ["No_Kontak_Orang_Tua", [fields.No_Kontak_Orang_Tua.visible && fields.No_Kontak_Orang_Tua.required ? ew.Validators.required(fields.No_Kontak_Orang_Tua.caption) : null], fields.No_Kontak_Orang_Tua.isInvalid],
            ["userid", [fields.userid.visible && fields.userid.required ? ew.Validators.required(fields.userid.caption) : null], fields.userid.isInvalid],
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null], fields.user.isInvalid],
            ["ip", [fields.ip.visible && fields.ip.required ? ew.Validators.required(fields.ip.caption) : null], fields.ip.isInvalid],
            ["tanggal_input", [fields.tanggal_input.visible && fields.tanggal_input.required ? ew.Validators.required(fields.tanggal_input.caption) : null], fields.tanggal_input.isInvalid]
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
<form name="fmahasiswaadd" id="fmahasiswaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mahasiswa">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->getFormOldKeyName() ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->NIM->Visible) { // NIM ?>
    <div id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <label id="elh_mahasiswa_NIM" for="x_NIM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIM->caption() ?><?= $Page->NIM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIM->cellAttributes() ?>>
<span id="el_mahasiswa_NIM">
<input type="<?= $Page->NIM->getInputTextType() ?>" name="x_NIM" id="x_NIM" data-table="mahasiswa" data-field="x_NIM" value="<?= $Page->NIM->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->NIM->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIM->formatPattern()) ?>"<?= $Page->NIM->editAttributes() ?> aria-describedby="x_NIM_help">
<?= $Page->NIM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
    <div id="r_Nama"<?= $Page->Nama->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nama" for="x_Nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama->caption() ?><?= $Page->Nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama->cellAttributes() ?>>
<span id="el_mahasiswa_Nama">
<input type="<?= $Page->Nama->getInputTextType() ?>" name="x_Nama" id="x_Nama" data-table="mahasiswa" data-field="x_Nama" value="<?= $Page->Nama->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama->formatPattern()) ?>"<?= $Page->Nama->editAttributes() ?> aria-describedby="x_Nama_help">
<?= $Page->Nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
    <div id="r_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->rowAttributes() ?>>
        <label id="elh_mahasiswa_Jenis_Kelamin" for="x_Jenis_Kelamin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenis_Kelamin->caption() ?><?= $Page->Jenis_Kelamin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_mahasiswa_Jenis_Kelamin">
<input type="<?= $Page->Jenis_Kelamin->getInputTextType() ?>" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" data-table="mahasiswa" data-field="x_Jenis_Kelamin" value="<?= $Page->Jenis_Kelamin->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->Jenis_Kelamin->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jenis_Kelamin->formatPattern()) ?>"<?= $Page->Jenis_Kelamin->editAttributes() ?> aria-describedby="x_Jenis_Kelamin_help">
<?= $Page->Jenis_Kelamin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_Kelamin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
    <div id="r_Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->rowAttributes() ?>>
        <label id="elh_mahasiswa_Provinsi_Tempat_Lahir" for="x_Provinsi_Tempat_Lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Provinsi_Tempat_Lahir->caption() ?><?= $Page->Provinsi_Tempat_Lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="el_mahasiswa_Provinsi_Tempat_Lahir">
<input type="<?= $Page->Provinsi_Tempat_Lahir->getInputTextType() ?>" name="x_Provinsi_Tempat_Lahir" id="x_Provinsi_Tempat_Lahir" data-table="mahasiswa" data-field="x_Provinsi_Tempat_Lahir" value="<?= $Page->Provinsi_Tempat_Lahir->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Provinsi_Tempat_Lahir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Provinsi_Tempat_Lahir->formatPattern()) ?>"<?= $Page->Provinsi_Tempat_Lahir->editAttributes() ?> aria-describedby="x_Provinsi_Tempat_Lahir_help">
<?= $Page->Provinsi_Tempat_Lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Provinsi_Tempat_Lahir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
    <div id="r_Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->rowAttributes() ?>>
        <label id="elh_mahasiswa_Kota_Tempat_Lahir" for="x_Kota_Tempat_Lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kota_Tempat_Lahir->caption() ?><?= $Page->Kota_Tempat_Lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="el_mahasiswa_Kota_Tempat_Lahir">
<input type="<?= $Page->Kota_Tempat_Lahir->getInputTextType() ?>" name="x_Kota_Tempat_Lahir" id="x_Kota_Tempat_Lahir" data-table="mahasiswa" data-field="x_Kota_Tempat_Lahir" value="<?= $Page->Kota_Tempat_Lahir->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Kota_Tempat_Lahir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kota_Tempat_Lahir->formatPattern()) ?>"<?= $Page->Kota_Tempat_Lahir->editAttributes() ?> aria-describedby="x_Kota_Tempat_Lahir_help">
<?= $Page->Kota_Tempat_Lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kota_Tempat_Lahir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
    <div id="r_Tanggal_Lahir"<?= $Page->Tanggal_Lahir->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tanggal_Lahir" for="x_Tanggal_Lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tanggal_Lahir->caption() ?><?= $Page->Tanggal_Lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="el_mahasiswa_Tanggal_Lahir">
<input type="<?= $Page->Tanggal_Lahir->getInputTextType() ?>" name="x_Tanggal_Lahir" id="x_Tanggal_Lahir" data-table="mahasiswa" data-field="x_Tanggal_Lahir" value="<?= $Page->Tanggal_Lahir->getEditValue() ?>" placeholder="<?= HtmlEncode($Page->Tanggal_Lahir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tanggal_Lahir->formatPattern()) ?>"<?= $Page->Tanggal_Lahir->editAttributes() ?> aria-describedby="x_Tanggal_Lahir_help">
<?= $Page->Tanggal_Lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tanggal_Lahir->getErrorMessage() ?></div>
<?php if (!$Page->Tanggal_Lahir->ReadOnly && !$Page->Tanggal_Lahir->Disabled && !isset($Page->Tanggal_Lahir->EditAttrs["readonly"]) && !isset($Page->Tanggal_Lahir->EditAttrs["disabled"])) { ?>
<script<?= Nonce() ?>>
loadjs.ready(["fmahasiswaadd", "datetimepicker"], function () {
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
        "fmahasiswaadd",
        "x_Tanggal_Lahir",
        ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options),
        {"inputGroup":true}
    );
});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'jitMasking': false,
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Tanggal_Lahir", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
    <div id="r_Golongan_Darah"<?= $Page->Golongan_Darah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Golongan_Darah" for="x_Golongan_Darah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Golongan_Darah->caption() ?><?= $Page->Golongan_Darah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="el_mahasiswa_Golongan_Darah">
<input type="<?= $Page->Golongan_Darah->getInputTextType() ?>" name="x_Golongan_Darah" id="x_Golongan_Darah" data-table="mahasiswa" data-field="x_Golongan_Darah" value="<?= $Page->Golongan_Darah->getEditValue() ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->Golongan_Darah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Golongan_Darah->formatPattern()) ?>"<?= $Page->Golongan_Darah->editAttributes() ?> aria-describedby="x_Golongan_Darah_help">
<?= $Page->Golongan_Darah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Golongan_Darah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
    <div id="r_Tinggi_Badan"<?= $Page->Tinggi_Badan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tinggi_Badan" for="x_Tinggi_Badan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tinggi_Badan->caption() ?><?= $Page->Tinggi_Badan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="el_mahasiswa_Tinggi_Badan">
<input type="<?= $Page->Tinggi_Badan->getInputTextType() ?>" name="x_Tinggi_Badan" id="x_Tinggi_Badan" data-table="mahasiswa" data-field="x_Tinggi_Badan" value="<?= $Page->Tinggi_Badan->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Tinggi_Badan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tinggi_Badan->formatPattern()) ?>"<?= $Page->Tinggi_Badan->editAttributes() ?> aria-describedby="x_Tinggi_Badan_help">
<?= $Page->Tinggi_Badan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tinggi_Badan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
    <div id="r_Berat_Badan"<?= $Page->Berat_Badan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Berat_Badan" for="x_Berat_Badan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Berat_Badan->caption() ?><?= $Page->Berat_Badan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="el_mahasiswa_Berat_Badan">
<input type="<?= $Page->Berat_Badan->getInputTextType() ?>" name="x_Berat_Badan" id="x_Berat_Badan" data-table="mahasiswa" data-field="x_Berat_Badan" value="<?= $Page->Berat_Badan->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Berat_Badan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Berat_Badan->formatPattern()) ?>"<?= $Page->Berat_Badan->editAttributes() ?> aria-describedby="x_Berat_Badan_help">
<?= $Page->Berat_Badan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Berat_Badan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
    <div id="r_Asal_sekolah"<?= $Page->Asal_sekolah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Asal_sekolah" for="x_Asal_sekolah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Asal_sekolah->caption() ?><?= $Page->Asal_sekolah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="el_mahasiswa_Asal_sekolah">
<input type="<?= $Page->Asal_sekolah->getInputTextType() ?>" name="x_Asal_sekolah" id="x_Asal_sekolah" data-table="mahasiswa" data-field="x_Asal_sekolah" value="<?= $Page->Asal_sekolah->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Asal_sekolah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Asal_sekolah->formatPattern()) ?>"<?= $Page->Asal_sekolah->editAttributes() ?> aria-describedby="x_Asal_sekolah_help">
<?= $Page->Asal_sekolah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Asal_sekolah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
    <div id="r_Tahun_Ijazah"<?= $Page->Tahun_Ijazah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tahun_Ijazah" for="x_Tahun_Ijazah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tahun_Ijazah->caption() ?><?= $Page->Tahun_Ijazah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="el_mahasiswa_Tahun_Ijazah">
<input type="<?= $Page->Tahun_Ijazah->getInputTextType() ?>" name="x_Tahun_Ijazah" id="x_Tahun_Ijazah" data-table="mahasiswa" data-field="x_Tahun_Ijazah" value="<?= $Page->Tahun_Ijazah->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->Tahun_Ijazah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tahun_Ijazah->formatPattern()) ?>"<?= $Page->Tahun_Ijazah->editAttributes() ?> aria-describedby="x_Tahun_Ijazah_help">
<?= $Page->Tahun_Ijazah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tahun_Ijazah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
    <div id="r_Nomor_Ijazah"<?= $Page->Nomor_Ijazah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nomor_Ijazah" for="x_Nomor_Ijazah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nomor_Ijazah->caption() ?><?= $Page->Nomor_Ijazah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="el_mahasiswa_Nomor_Ijazah">
<input type="<?= $Page->Nomor_Ijazah->getInputTextType() ?>" name="x_Nomor_Ijazah" id="x_Nomor_Ijazah" data-table="mahasiswa" data-field="x_Nomor_Ijazah" value="<?= $Page->Nomor_Ijazah->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Nomor_Ijazah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nomor_Ijazah->formatPattern()) ?>"<?= $Page->Nomor_Ijazah->editAttributes() ?> aria-describedby="x_Nomor_Ijazah_help">
<?= $Page->Nomor_Ijazah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nomor_Ijazah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
    <div id="r_Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nilai_Raport_Kelas_10" for="x_Nilai_Raport_Kelas_10" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_Raport_Kelas_10->caption() ?><?= $Page->Nilai_Raport_Kelas_10->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="el_mahasiswa_Nilai_Raport_Kelas_10">
<input type="<?= $Page->Nilai_Raport_Kelas_10->getInputTextType() ?>" name="x_Nilai_Raport_Kelas_10" id="x_Nilai_Raport_Kelas_10" data-table="mahasiswa" data-field="x_Nilai_Raport_Kelas_10" value="<?= $Page->Nilai_Raport_Kelas_10->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Nilai_Raport_Kelas_10->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Raport_Kelas_10->formatPattern()) ?>"<?= $Page->Nilai_Raport_Kelas_10->editAttributes() ?> aria-describedby="x_Nilai_Raport_Kelas_10_help">
<?= $Page->Nilai_Raport_Kelas_10->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_Raport_Kelas_10->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Nilai_Raport_Kelas_10", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
    <div id="r_Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nilai_Raport_Kelas_11" for="x_Nilai_Raport_Kelas_11" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_Raport_Kelas_11->caption() ?><?= $Page->Nilai_Raport_Kelas_11->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="el_mahasiswa_Nilai_Raport_Kelas_11">
<input type="<?= $Page->Nilai_Raport_Kelas_11->getInputTextType() ?>" name="x_Nilai_Raport_Kelas_11" id="x_Nilai_Raport_Kelas_11" data-table="mahasiswa" data-field="x_Nilai_Raport_Kelas_11" value="<?= $Page->Nilai_Raport_Kelas_11->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Nilai_Raport_Kelas_11->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Raport_Kelas_11->formatPattern()) ?>"<?= $Page->Nilai_Raport_Kelas_11->editAttributes() ?> aria-describedby="x_Nilai_Raport_Kelas_11_help">
<?= $Page->Nilai_Raport_Kelas_11->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_Raport_Kelas_11->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Nilai_Raport_Kelas_11", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
    <div id="r_Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nilai_Raport_Kelas_12" for="x_Nilai_Raport_Kelas_12" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nilai_Raport_Kelas_12->caption() ?><?= $Page->Nilai_Raport_Kelas_12->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="el_mahasiswa_Nilai_Raport_Kelas_12">
<input type="<?= $Page->Nilai_Raport_Kelas_12->getInputTextType() ?>" name="x_Nilai_Raport_Kelas_12" id="x_Nilai_Raport_Kelas_12" data-table="mahasiswa" data-field="x_Nilai_Raport_Kelas_12" value="<?= $Page->Nilai_Raport_Kelas_12->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Nilai_Raport_Kelas_12->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nilai_Raport_Kelas_12->formatPattern()) ?>"<?= $Page->Nilai_Raport_Kelas_12->editAttributes() ?> aria-describedby="x_Nilai_Raport_Kelas_12_help">
<?= $Page->Nilai_Raport_Kelas_12->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nilai_Raport_Kelas_12->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Nilai_Raport_Kelas_12", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
    <div id="r_Tanggal_Daftar"<?= $Page->Tanggal_Daftar->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tanggal_Daftar" for="x_Tanggal_Daftar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tanggal_Daftar->caption() ?><?= $Page->Tanggal_Daftar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="el_mahasiswa_Tanggal_Daftar">
<input type="<?= $Page->Tanggal_Daftar->getInputTextType() ?>" name="x_Tanggal_Daftar" id="x_Tanggal_Daftar" data-table="mahasiswa" data-field="x_Tanggal_Daftar" value="<?= $Page->Tanggal_Daftar->getEditValue() ?>" placeholder="<?= HtmlEncode($Page->Tanggal_Daftar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tanggal_Daftar->formatPattern()) ?>"<?= $Page->Tanggal_Daftar->editAttributes() ?> aria-describedby="x_Tanggal_Daftar_help">
<?= $Page->Tanggal_Daftar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tanggal_Daftar->getErrorMessage() ?></div>
<?php if (!$Page->Tanggal_Daftar->ReadOnly && !$Page->Tanggal_Daftar->Disabled && !isset($Page->Tanggal_Daftar->EditAttrs["readonly"]) && !isset($Page->Tanggal_Daftar->EditAttrs["disabled"])) { ?>
<script<?= Nonce() ?>>
loadjs.ready(["fmahasiswaadd", "datetimepicker"], function () {
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
        "fmahasiswaadd",
        "x_Tanggal_Daftar",
        ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options),
        {"inputGroup":true}
    );
});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'jitMasking': false,
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Tanggal_Daftar", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
    <div id="r_No_Test"<?= $Page->No_Test->rowAttributes() ?>>
        <label id="elh_mahasiswa_No_Test" for="x_No_Test" class="<?= $Page->LeftColumnClass ?>"><?= $Page->No_Test->caption() ?><?= $Page->No_Test->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->No_Test->cellAttributes() ?>>
<span id="el_mahasiswa_No_Test">
<input type="<?= $Page->No_Test->getInputTextType() ?>" name="x_No_Test" id="x_No_Test" data-table="mahasiswa" data-field="x_No_Test" value="<?= $Page->No_Test->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->No_Test->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->No_Test->formatPattern()) ?>"<?= $Page->No_Test->editAttributes() ?> aria-describedby="x_No_Test_help">
<?= $Page->No_Test->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->No_Test->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
    <div id="r_Status_Masuk"<?= $Page->Status_Masuk->rowAttributes() ?>>
        <label id="elh_mahasiswa_Status_Masuk" for="x_Status_Masuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status_Masuk->caption() ?><?= $Page->Status_Masuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="el_mahasiswa_Status_Masuk">
<input type="<?= $Page->Status_Masuk->getInputTextType() ?>" name="x_Status_Masuk" id="x_Status_Masuk" data-table="mahasiswa" data-field="x_Status_Masuk" value="<?= $Page->Status_Masuk->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Status_Masuk->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status_Masuk->formatPattern()) ?>"<?= $Page->Status_Masuk->editAttributes() ?> aria-describedby="x_Status_Masuk_help">
<?= $Page->Status_Masuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status_Masuk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
    <div id="r_Jalur_Masuk"<?= $Page->Jalur_Masuk->rowAttributes() ?>>
        <label id="elh_mahasiswa_Jalur_Masuk" for="x_Jalur_Masuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jalur_Masuk->caption() ?><?= $Page->Jalur_Masuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="el_mahasiswa_Jalur_Masuk">
<input type="<?= $Page->Jalur_Masuk->getInputTextType() ?>" name="x_Jalur_Masuk" id="x_Jalur_Masuk" data-table="mahasiswa" data-field="x_Jalur_Masuk" value="<?= $Page->Jalur_Masuk->getEditValue() ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Jalur_Masuk->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jalur_Masuk->formatPattern()) ?>"<?= $Page->Jalur_Masuk->editAttributes() ?> aria-describedby="x_Jalur_Masuk_help">
<?= $Page->Jalur_Masuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jalur_Masuk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
    <div id="r_Bukti_Lulus"<?= $Page->Bukti_Lulus->rowAttributes() ?>>
        <label id="elh_mahasiswa_Bukti_Lulus" for="x_Bukti_Lulus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Bukti_Lulus->caption() ?><?= $Page->Bukti_Lulus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="el_mahasiswa_Bukti_Lulus">
<input type="<?= $Page->Bukti_Lulus->getInputTextType() ?>" name="x_Bukti_Lulus" id="x_Bukti_Lulus" data-table="mahasiswa" data-field="x_Bukti_Lulus" value="<?= $Page->Bukti_Lulus->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Bukti_Lulus->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Bukti_Lulus->formatPattern()) ?>"<?= $Page->Bukti_Lulus->editAttributes() ?> aria-describedby="x_Bukti_Lulus_help">
<?= $Page->Bukti_Lulus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Bukti_Lulus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
    <div id="r_Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tes_Potensi_Akademik" for="x_Tes_Potensi_Akademik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tes_Potensi_Akademik->caption() ?><?= $Page->Tes_Potensi_Akademik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="el_mahasiswa_Tes_Potensi_Akademik">
<input type="<?= $Page->Tes_Potensi_Akademik->getInputTextType() ?>" name="x_Tes_Potensi_Akademik" id="x_Tes_Potensi_Akademik" data-table="mahasiswa" data-field="x_Tes_Potensi_Akademik" value="<?= $Page->Tes_Potensi_Akademik->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Tes_Potensi_Akademik->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tes_Potensi_Akademik->formatPattern()) ?>"<?= $Page->Tes_Potensi_Akademik->editAttributes() ?> aria-describedby="x_Tes_Potensi_Akademik_help">
<?= $Page->Tes_Potensi_Akademik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tes_Potensi_Akademik->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Tes_Potensi_Akademik", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
    <div id="r_Tes_Wawancara"<?= $Page->Tes_Wawancara->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tes_Wawancara" for="x_Tes_Wawancara" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tes_Wawancara->caption() ?><?= $Page->Tes_Wawancara->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="el_mahasiswa_Tes_Wawancara">
<input type="<?= $Page->Tes_Wawancara->getInputTextType() ?>" name="x_Tes_Wawancara" id="x_Tes_Wawancara" data-table="mahasiswa" data-field="x_Tes_Wawancara" value="<?= $Page->Tes_Wawancara->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Tes_Wawancara->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tes_Wawancara->formatPattern()) ?>"<?= $Page->Tes_Wawancara->editAttributes() ?> aria-describedby="x_Tes_Wawancara_help">
<?= $Page->Tes_Wawancara->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tes_Wawancara->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Tes_Wawancara", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
    <div id="r_Tes_Kesehatan"<?= $Page->Tes_Kesehatan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tes_Kesehatan" for="x_Tes_Kesehatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tes_Kesehatan->caption() ?><?= $Page->Tes_Kesehatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="el_mahasiswa_Tes_Kesehatan">
<input type="<?= $Page->Tes_Kesehatan->getInputTextType() ?>" name="x_Tes_Kesehatan" id="x_Tes_Kesehatan" data-table="mahasiswa" data-field="x_Tes_Kesehatan" value="<?= $Page->Tes_Kesehatan->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Tes_Kesehatan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tes_Kesehatan->formatPattern()) ?>"<?= $Page->Tes_Kesehatan->editAttributes() ?> aria-describedby="x_Tes_Kesehatan_help">
<?= $Page->Tes_Kesehatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tes_Kesehatan->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Tes_Kesehatan", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
    <div id="r_Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Hasil_Test_Kesehatan" for="x_Hasil_Test_Kesehatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Hasil_Test_Kesehatan->caption() ?><?= $Page->Hasil_Test_Kesehatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="el_mahasiswa_Hasil_Test_Kesehatan">
<input type="<?= $Page->Hasil_Test_Kesehatan->getInputTextType() ?>" name="x_Hasil_Test_Kesehatan" id="x_Hasil_Test_Kesehatan" data-table="mahasiswa" data-field="x_Hasil_Test_Kesehatan" value="<?= $Page->Hasil_Test_Kesehatan->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Hasil_Test_Kesehatan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hasil_Test_Kesehatan->formatPattern()) ?>"<?= $Page->Hasil_Test_Kesehatan->editAttributes() ?> aria-describedby="x_Hasil_Test_Kesehatan_help">
<?= $Page->Hasil_Test_Kesehatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hasil_Test_Kesehatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
    <div id="r_Test_MMPI"<?= $Page->Test_MMPI->rowAttributes() ?>>
        <label id="elh_mahasiswa_Test_MMPI" for="x_Test_MMPI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Test_MMPI->caption() ?><?= $Page->Test_MMPI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="el_mahasiswa_Test_MMPI">
<input type="<?= $Page->Test_MMPI->getInputTextType() ?>" name="x_Test_MMPI" id="x_Test_MMPI" data-table="mahasiswa" data-field="x_Test_MMPI" value="<?= $Page->Test_MMPI->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Test_MMPI->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Test_MMPI->formatPattern()) ?>"<?= $Page->Test_MMPI->editAttributes() ?> aria-describedby="x_Test_MMPI_help">
<?= $Page->Test_MMPI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Test_MMPI->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Test_MMPI", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
    <div id="r_Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->rowAttributes() ?>>
        <label id="elh_mahasiswa_Hasil_Test_MMPI" for="x_Hasil_Test_MMPI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Hasil_Test_MMPI->caption() ?><?= $Page->Hasil_Test_MMPI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="el_mahasiswa_Hasil_Test_MMPI">
<input type="<?= $Page->Hasil_Test_MMPI->getInputTextType() ?>" name="x_Hasil_Test_MMPI" id="x_Hasil_Test_MMPI" data-table="mahasiswa" data-field="x_Hasil_Test_MMPI" value="<?= $Page->Hasil_Test_MMPI->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Hasil_Test_MMPI->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hasil_Test_MMPI->formatPattern()) ?>"<?= $Page->Hasil_Test_MMPI->editAttributes() ?> aria-describedby="x_Hasil_Test_MMPI_help">
<?= $Page->Hasil_Test_MMPI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hasil_Test_MMPI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
    <div id="r_Angkatan"<?= $Page->Angkatan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Angkatan" for="x_Angkatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Angkatan->caption() ?><?= $Page->Angkatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Angkatan->cellAttributes() ?>>
<span id="el_mahasiswa_Angkatan">
<input type="<?= $Page->Angkatan->getInputTextType() ?>" name="x_Angkatan" id="x_Angkatan" data-table="mahasiswa" data-field="x_Angkatan" value="<?= $Page->Angkatan->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->Angkatan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Angkatan->formatPattern()) ?>"<?= $Page->Angkatan->editAttributes() ?> aria-describedby="x_Angkatan_help">
<?= $Page->Angkatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Angkatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
    <div id="r_Tarif_SPP"<?= $Page->Tarif_SPP->rowAttributes() ?>>
        <label id="elh_mahasiswa_Tarif_SPP" for="x_Tarif_SPP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Tarif_SPP->caption() ?><?= $Page->Tarif_SPP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="el_mahasiswa_Tarif_SPP">
<input type="<?= $Page->Tarif_SPP->getInputTextType() ?>" name="x_Tarif_SPP" id="x_Tarif_SPP" data-table="mahasiswa" data-field="x_Tarif_SPP" value="<?= $Page->Tarif_SPP->getEditValue() ?>" size="30" placeholder="<?= HtmlEncode($Page->Tarif_SPP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Tarif_SPP->formatPattern()) ?>"<?= $Page->Tarif_SPP->editAttributes() ?> aria-describedby="x_Tarif_SPP_help">
<?= $Page->Tarif_SPP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Tarif_SPP->getErrorMessage() ?></div>
<script<?= Nonce() ?>>
loadjs.ready(['fmahasiswaadd', 'jqueryinputmask'], function() {
	options = {
		'alias': 'numeric',
		'autoUnmask': true,
		'jitMasking': false,
		'groupSeparator': '<?php echo $GROUPING_SEPARATOR ?>',
		'digits': 0,
		'radixPoint': '<?php echo $DECIMAL_SEPARATOR ?>',
		'removeMaskOnSubmit': true
	};
	ew.createjQueryInputMask("fmahasiswaadd", "x_Tarif_SPP", jQuery.extend(true, "", options));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
    <div id="r_NIK_No_KTP"<?= $Page->NIK_No_KTP->rowAttributes() ?>>
        <label id="elh_mahasiswa_NIK_No_KTP" for="x_NIK_No_KTP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NIK_No_KTP->caption() ?><?= $Page->NIK_No_KTP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="el_mahasiswa_NIK_No_KTP">
<input type="<?= $Page->NIK_No_KTP->getInputTextType() ?>" name="x_NIK_No_KTP" id="x_NIK_No_KTP" data-table="mahasiswa" data-field="x_NIK_No_KTP" value="<?= $Page->NIK_No_KTP->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->NIK_No_KTP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NIK_No_KTP->formatPattern()) ?>"<?= $Page->NIK_No_KTP->editAttributes() ?> aria-describedby="x_NIK_No_KTP_help">
<?= $Page->NIK_No_KTP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NIK_No_KTP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
    <div id="r_No_KK"<?= $Page->No_KK->rowAttributes() ?>>
        <label id="elh_mahasiswa_No_KK" for="x_No_KK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->No_KK->caption() ?><?= $Page->No_KK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->No_KK->cellAttributes() ?>>
<span id="el_mahasiswa_No_KK">
<input type="<?= $Page->No_KK->getInputTextType() ?>" name="x_No_KK" id="x_No_KK" data-table="mahasiswa" data-field="x_No_KK" value="<?= $Page->No_KK->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->No_KK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->No_KK->formatPattern()) ?>"<?= $Page->No_KK->editAttributes() ?> aria-describedby="x_No_KK_help">
<?= $Page->No_KK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->No_KK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
    <div id="r_NPWP"<?= $Page->NPWP->rowAttributes() ?>>
        <label id="elh_mahasiswa_NPWP" for="x_NPWP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NPWP->caption() ?><?= $Page->NPWP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->NPWP->cellAttributes() ?>>
<span id="el_mahasiswa_NPWP">
<input type="<?= $Page->NPWP->getInputTextType() ?>" name="x_NPWP" id="x_NPWP" data-table="mahasiswa" data-field="x_NPWP" value="<?= $Page->NPWP->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->NPWP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->NPWP->formatPattern()) ?>"<?= $Page->NPWP->editAttributes() ?> aria-describedby="x_NPWP_help">
<?= $Page->NPWP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NPWP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
    <div id="r_Status_Nikah"<?= $Page->Status_Nikah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Status_Nikah" for="x_Status_Nikah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status_Nikah->caption() ?><?= $Page->Status_Nikah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="el_mahasiswa_Status_Nikah">
<input type="<?= $Page->Status_Nikah->getInputTextType() ?>" name="x_Status_Nikah" id="x_Status_Nikah" data-table="mahasiswa" data-field="x_Status_Nikah" value="<?= $Page->Status_Nikah->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Status_Nikah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status_Nikah->formatPattern()) ?>"<?= $Page->Status_Nikah->editAttributes() ?> aria-describedby="x_Status_Nikah_help">
<?= $Page->Status_Nikah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status_Nikah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
    <div id="r_Kewarganegaraan"<?= $Page->Kewarganegaraan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Kewarganegaraan" for="x_Kewarganegaraan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kewarganegaraan->caption() ?><?= $Page->Kewarganegaraan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="el_mahasiswa_Kewarganegaraan">
<input type="<?= $Page->Kewarganegaraan->getInputTextType() ?>" name="x_Kewarganegaraan" id="x_Kewarganegaraan" data-table="mahasiswa" data-field="x_Kewarganegaraan" value="<?= $Page->Kewarganegaraan->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->Kewarganegaraan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kewarganegaraan->formatPattern()) ?>"<?= $Page->Kewarganegaraan->editAttributes() ?> aria-describedby="x_Kewarganegaraan_help">
<?= $Page->Kewarganegaraan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kewarganegaraan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
    <div id="r_Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->rowAttributes() ?>>
        <label id="elh_mahasiswa_Propinsi_Tempat_Tinggal" for="x_Propinsi_Tempat_Tinggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Propinsi_Tempat_Tinggal->caption() ?><?= $Page->Propinsi_Tempat_Tinggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Propinsi_Tempat_Tinggal">
<input type="<?= $Page->Propinsi_Tempat_Tinggal->getInputTextType() ?>" name="x_Propinsi_Tempat_Tinggal" id="x_Propinsi_Tempat_Tinggal" data-table="mahasiswa" data-field="x_Propinsi_Tempat_Tinggal" value="<?= $Page->Propinsi_Tempat_Tinggal->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Propinsi_Tempat_Tinggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Propinsi_Tempat_Tinggal->formatPattern()) ?>"<?= $Page->Propinsi_Tempat_Tinggal->editAttributes() ?> aria-describedby="x_Propinsi_Tempat_Tinggal_help">
<?= $Page->Propinsi_Tempat_Tinggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Propinsi_Tempat_Tinggal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
    <div id="r_Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->rowAttributes() ?>>
        <label id="elh_mahasiswa_Kota_Tempat_Tinggal" for="x_Kota_Tempat_Tinggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kota_Tempat_Tinggal->caption() ?><?= $Page->Kota_Tempat_Tinggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Kota_Tempat_Tinggal">
<input type="<?= $Page->Kota_Tempat_Tinggal->getInputTextType() ?>" name="x_Kota_Tempat_Tinggal" id="x_Kota_Tempat_Tinggal" data-table="mahasiswa" data-field="x_Kota_Tempat_Tinggal" value="<?= $Page->Kota_Tempat_Tinggal->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Kota_Tempat_Tinggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kota_Tempat_Tinggal->formatPattern()) ?>"<?= $Page->Kota_Tempat_Tinggal->editAttributes() ?> aria-describedby="x_Kota_Tempat_Tinggal_help">
<?= $Page->Kota_Tempat_Tinggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kota_Tempat_Tinggal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
    <div id="r_Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->rowAttributes() ?>>
        <label id="elh_mahasiswa_Kecamatan_Tempat_Tinggal" for="x_Kecamatan_Tempat_Tinggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kecamatan_Tempat_Tinggal->caption() ?><?= $Page->Kecamatan_Tempat_Tinggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Kecamatan_Tempat_Tinggal">
<input type="<?= $Page->Kecamatan_Tempat_Tinggal->getInputTextType() ?>" name="x_Kecamatan_Tempat_Tinggal" id="x_Kecamatan_Tempat_Tinggal" data-table="mahasiswa" data-field="x_Kecamatan_Tempat_Tinggal" value="<?= $Page->Kecamatan_Tempat_Tinggal->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Kecamatan_Tempat_Tinggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kecamatan_Tempat_Tinggal->formatPattern()) ?>"<?= $Page->Kecamatan_Tempat_Tinggal->editAttributes() ?> aria-describedby="x_Kecamatan_Tempat_Tinggal_help">
<?= $Page->Kecamatan_Tempat_Tinggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kecamatan_Tempat_Tinggal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
    <div id="r_Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->rowAttributes() ?>>
        <label id="elh_mahasiswa_Alamat_Tempat_Tinggal" for="x_Alamat_Tempat_Tinggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Alamat_Tempat_Tinggal->caption() ?><?= $Page->Alamat_Tempat_Tinggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Alamat_Tempat_Tinggal">
<input type="<?= $Page->Alamat_Tempat_Tinggal->getInputTextType() ?>" name="x_Alamat_Tempat_Tinggal" id="x_Alamat_Tempat_Tinggal" data-table="mahasiswa" data-field="x_Alamat_Tempat_Tinggal" value="<?= $Page->Alamat_Tempat_Tinggal->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Alamat_Tempat_Tinggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Alamat_Tempat_Tinggal->formatPattern()) ?>"<?= $Page->Alamat_Tempat_Tinggal->editAttributes() ?> aria-describedby="x_Alamat_Tempat_Tinggal_help">
<?= $Page->Alamat_Tempat_Tinggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Alamat_Tempat_Tinggal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
    <div id="r_RT"<?= $Page->RT->rowAttributes() ?>>
        <label id="elh_mahasiswa_RT" for="x_RT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RT->caption() ?><?= $Page->RT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->RT->cellAttributes() ?>>
<span id="el_mahasiswa_RT">
<input type="<?= $Page->RT->getInputTextType() ?>" name="x_RT" id="x_RT" data-table="mahasiswa" data-field="x_RT" value="<?= $Page->RT->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->RT->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->RT->formatPattern()) ?>"<?= $Page->RT->editAttributes() ?> aria-describedby="x_RT_help">
<?= $Page->RT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
    <div id="r_RW"<?= $Page->RW->rowAttributes() ?>>
        <label id="elh_mahasiswa_RW" for="x_RW" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RW->caption() ?><?= $Page->RW->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->RW->cellAttributes() ?>>
<span id="el_mahasiswa_RW">
<input type="<?= $Page->RW->getInputTextType() ?>" name="x_RW" id="x_RW" data-table="mahasiswa" data-field="x_RW" value="<?= $Page->RW->getEditValue() ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->RW->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->RW->formatPattern()) ?>"<?= $Page->RW->editAttributes() ?> aria-describedby="x_RW_help">
<?= $Page->RW->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RW->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
    <div id="r_Kelurahan"<?= $Page->Kelurahan->rowAttributes() ?>>
        <label id="elh_mahasiswa_Kelurahan" for="x_Kelurahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kelurahan->caption() ?><?= $Page->Kelurahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="el_mahasiswa_Kelurahan">
<input type="<?= $Page->Kelurahan->getInputTextType() ?>" name="x_Kelurahan" id="x_Kelurahan" data-table="mahasiswa" data-field="x_Kelurahan" value="<?= $Page->Kelurahan->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Kelurahan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kelurahan->formatPattern()) ?>"<?= $Page->Kelurahan->editAttributes() ?> aria-describedby="x_Kelurahan_help">
<?= $Page->Kelurahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kelurahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
    <div id="r_Kode_Pos"<?= $Page->Kode_Pos->rowAttributes() ?>>
        <label id="elh_mahasiswa_Kode_Pos" for="x_Kode_Pos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Kode_Pos->caption() ?><?= $Page->Kode_Pos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="el_mahasiswa_Kode_Pos">
<input type="<?= $Page->Kode_Pos->getInputTextType() ?>" name="x_Kode_Pos" id="x_Kode_Pos" data-table="mahasiswa" data-field="x_Kode_Pos" value="<?= $Page->Kode_Pos->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->Kode_Pos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Kode_Pos->formatPattern()) ?>"<?= $Page->Kode_Pos->editAttributes() ?> aria-describedby="x_Kode_Pos_help">
<?= $Page->Kode_Pos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Kode_Pos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
    <div id="r_Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nomor_Telpon_HP" for="x_Nomor_Telpon_HP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nomor_Telpon_HP->caption() ?><?= $Page->Nomor_Telpon_HP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="el_mahasiswa_Nomor_Telpon_HP">
<input type="<?= $Page->Nomor_Telpon_HP->getInputTextType() ?>" name="x_Nomor_Telpon_HP" id="x_Nomor_Telpon_HP" data-table="mahasiswa" data-field="x_Nomor_Telpon_HP" value="<?= $Page->Nomor_Telpon_HP->getEditValue() ?>" size="30" maxlength="13" placeholder="<?= HtmlEncode($Page->Nomor_Telpon_HP->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nomor_Telpon_HP->formatPattern()) ?>"<?= $Page->Nomor_Telpon_HP->editAttributes() ?> aria-describedby="x_Nomor_Telpon_HP_help">
<?= $Page->Nomor_Telpon_HP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nomor_Telpon_HP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label id="elh_mahasiswa__Email" for="x__Email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Email->cellAttributes() ?>>
<span id="el_mahasiswa__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="mahasiswa" data-field="x__Email" value="<?= $Page->_Email->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
    <div id="r_Jenis_Tinggal"<?= $Page->Jenis_Tinggal->rowAttributes() ?>>
        <label id="elh_mahasiswa_Jenis_Tinggal" for="x_Jenis_Tinggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jenis_Tinggal->caption() ?><?= $Page->Jenis_Tinggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Jenis_Tinggal">
<input type="<?= $Page->Jenis_Tinggal->getInputTextType() ?>" name="x_Jenis_Tinggal" id="x_Jenis_Tinggal" data-table="mahasiswa" data-field="x_Jenis_Tinggal" value="<?= $Page->Jenis_Tinggal->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->Jenis_Tinggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jenis_Tinggal->formatPattern()) ?>"<?= $Page->Jenis_Tinggal->editAttributes() ?> aria-describedby="x_Jenis_Tinggal_help">
<?= $Page->Jenis_Tinggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jenis_Tinggal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
    <div id="r_Alat_Transportasi"<?= $Page->Alat_Transportasi->rowAttributes() ?>>
        <label id="elh_mahasiswa_Alat_Transportasi" for="x_Alat_Transportasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Alat_Transportasi->caption() ?><?= $Page->Alat_Transportasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="el_mahasiswa_Alat_Transportasi">
<input type="<?= $Page->Alat_Transportasi->getInputTextType() ?>" name="x_Alat_Transportasi" id="x_Alat_Transportasi" data-table="mahasiswa" data-field="x_Alat_Transportasi" value="<?= $Page->Alat_Transportasi->getEditValue() ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->Alat_Transportasi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Alat_Transportasi->formatPattern()) ?>"<?= $Page->Alat_Transportasi->editAttributes() ?> aria-describedby="x_Alat_Transportasi_help">
<?= $Page->Alat_Transportasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Alat_Transportasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
    <div id="r_Sumber_Dana"<?= $Page->Sumber_Dana->rowAttributes() ?>>
        <label id="elh_mahasiswa_Sumber_Dana" for="x_Sumber_Dana" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sumber_Dana->caption() ?><?= $Page->Sumber_Dana->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="el_mahasiswa_Sumber_Dana">
<input type="<?= $Page->Sumber_Dana->getInputTextType() ?>" name="x_Sumber_Dana" id="x_Sumber_Dana" data-table="mahasiswa" data-field="x_Sumber_Dana" value="<?= $Page->Sumber_Dana->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Sumber_Dana->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Sumber_Dana->formatPattern()) ?>"<?= $Page->Sumber_Dana->editAttributes() ?> aria-describedby="x_Sumber_Dana_help">
<?= $Page->Sumber_Dana->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sumber_Dana->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
    <div id="r_Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->rowAttributes() ?>>
        <label id="elh_mahasiswa_Sumber_Dana_Beasiswa" for="x_Sumber_Dana_Beasiswa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sumber_Dana_Beasiswa->caption() ?><?= $Page->Sumber_Dana_Beasiswa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="el_mahasiswa_Sumber_Dana_Beasiswa">
<input type="<?= $Page->Sumber_Dana_Beasiswa->getInputTextType() ?>" name="x_Sumber_Dana_Beasiswa" id="x_Sumber_Dana_Beasiswa" data-table="mahasiswa" data-field="x_Sumber_Dana_Beasiswa" value="<?= $Page->Sumber_Dana_Beasiswa->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Sumber_Dana_Beasiswa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Sumber_Dana_Beasiswa->formatPattern()) ?>"<?= $Page->Sumber_Dana_Beasiswa->editAttributes() ?> aria-describedby="x_Sumber_Dana_Beasiswa_help">
<?= $Page->Sumber_Dana_Beasiswa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sumber_Dana_Beasiswa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
    <div id="r_Jumlah_Sudara"<?= $Page->Jumlah_Sudara->rowAttributes() ?>>
        <label id="elh_mahasiswa_Jumlah_Sudara" for="x_Jumlah_Sudara" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Jumlah_Sudara->caption() ?><?= $Page->Jumlah_Sudara->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="el_mahasiswa_Jumlah_Sudara">
<input type="<?= $Page->Jumlah_Sudara->getInputTextType() ?>" name="x_Jumlah_Sudara" id="x_Jumlah_Sudara" data-table="mahasiswa" data-field="x_Jumlah_Sudara" value="<?= $Page->Jumlah_Sudara->getEditValue() ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->Jumlah_Sudara->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Jumlah_Sudara->formatPattern()) ?>"<?= $Page->Jumlah_Sudara->editAttributes() ?> aria-describedby="x_Jumlah_Sudara_help">
<?= $Page->Jumlah_Sudara->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Jumlah_Sudara->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
    <div id="r_Status_Bekerja"<?= $Page->Status_Bekerja->rowAttributes() ?>>
        <label id="elh_mahasiswa_Status_Bekerja" for="x_Status_Bekerja" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Status_Bekerja->caption() ?><?= $Page->Status_Bekerja->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="el_mahasiswa_Status_Bekerja">
<input type="<?= $Page->Status_Bekerja->getInputTextType() ?>" name="x_Status_Bekerja" id="x_Status_Bekerja" data-table="mahasiswa" data-field="x_Status_Bekerja" value="<?= $Page->Status_Bekerja->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Status_Bekerja->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Status_Bekerja->formatPattern()) ?>"<?= $Page->Status_Bekerja->editAttributes() ?> aria-describedby="x_Status_Bekerja_help">
<?= $Page->Status_Bekerja->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Status_Bekerja->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
    <div id="r_Nomor_Asuransi"<?= $Page->Nomor_Asuransi->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nomor_Asuransi" for="x_Nomor_Asuransi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nomor_Asuransi->caption() ?><?= $Page->Nomor_Asuransi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="el_mahasiswa_Nomor_Asuransi">
<input type="<?= $Page->Nomor_Asuransi->getInputTextType() ?>" name="x_Nomor_Asuransi" id="x_Nomor_Asuransi" data-table="mahasiswa" data-field="x_Nomor_Asuransi" value="<?= $Page->Nomor_Asuransi->getEditValue() ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Nomor_Asuransi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nomor_Asuransi->formatPattern()) ?>"<?= $Page->Nomor_Asuransi->editAttributes() ?> aria-describedby="x_Nomor_Asuransi_help">
<?= $Page->Nomor_Asuransi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nomor_Asuransi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
    <div id="r_Hobi"<?= $Page->Hobi->rowAttributes() ?>>
        <label id="elh_mahasiswa_Hobi" for="x_Hobi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Hobi->caption() ?><?= $Page->Hobi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Hobi->cellAttributes() ?>>
<span id="el_mahasiswa_Hobi">
<input type="<?= $Page->Hobi->getInputTextType() ?>" name="x_Hobi" id="x_Hobi" data-table="mahasiswa" data-field="x_Hobi" value="<?= $Page->Hobi->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->Hobi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hobi->formatPattern()) ?>"<?= $Page->Hobi->editAttributes() ?> aria-describedby="x_Hobi_help">
<?= $Page->Hobi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hobi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
    <div id="r_Foto"<?= $Page->Foto->rowAttributes() ?>>
        <label id="elh_mahasiswa_Foto" for="x_Foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Foto->caption() ?><?= $Page->Foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Foto->cellAttributes() ?>>
<span id="el_mahasiswa_Foto">
<input type="<?= $Page->Foto->getInputTextType() ?>" name="x_Foto" id="x_Foto" data-table="mahasiswa" data-field="x_Foto" value="<?= $Page->Foto->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Foto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Foto->formatPattern()) ?>"<?= $Page->Foto->editAttributes() ?> aria-describedby="x_Foto_help">
<?= $Page->Foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Foto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
    <div id="r_Nama_Ayah"<?= $Page->Nama_Ayah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nama_Ayah" for="x_Nama_Ayah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Ayah->caption() ?><?= $Page->Nama_Ayah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="el_mahasiswa_Nama_Ayah">
<input type="<?= $Page->Nama_Ayah->getInputTextType() ?>" name="x_Nama_Ayah" id="x_Nama_Ayah" data-table="mahasiswa" data-field="x_Nama_Ayah" value="<?= $Page->Nama_Ayah->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Ayah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Ayah->formatPattern()) ?>"<?= $Page->Nama_Ayah->editAttributes() ?> aria-describedby="x_Nama_Ayah_help">
<?= $Page->Nama_Ayah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Ayah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
    <div id="r_Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->rowAttributes() ?>>
        <label id="elh_mahasiswa_Pekerjaan_Ayah" for="x_Pekerjaan_Ayah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pekerjaan_Ayah->caption() ?><?= $Page->Pekerjaan_Ayah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="el_mahasiswa_Pekerjaan_Ayah">
<input type="<?= $Page->Pekerjaan_Ayah->getInputTextType() ?>" name="x_Pekerjaan_Ayah" id="x_Pekerjaan_Ayah" data-table="mahasiswa" data-field="x_Pekerjaan_Ayah" value="<?= $Page->Pekerjaan_Ayah->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->Pekerjaan_Ayah->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pekerjaan_Ayah->formatPattern()) ?>"<?= $Page->Pekerjaan_Ayah->editAttributes() ?> aria-describedby="x_Pekerjaan_Ayah_help">
<?= $Page->Pekerjaan_Ayah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pekerjaan_Ayah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
    <div id="r_Nama_Ibu"<?= $Page->Nama_Ibu->rowAttributes() ?>>
        <label id="elh_mahasiswa_Nama_Ibu" for="x_Nama_Ibu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nama_Ibu->caption() ?><?= $Page->Nama_Ibu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="el_mahasiswa_Nama_Ibu">
<input type="<?= $Page->Nama_Ibu->getInputTextType() ?>" name="x_Nama_Ibu" id="x_Nama_Ibu" data-table="mahasiswa" data-field="x_Nama_Ibu" value="<?= $Page->Nama_Ibu->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Nama_Ibu->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nama_Ibu->formatPattern()) ?>"<?= $Page->Nama_Ibu->editAttributes() ?> aria-describedby="x_Nama_Ibu_help">
<?= $Page->Nama_Ibu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nama_Ibu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
    <div id="r_Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->rowAttributes() ?>>
        <label id="elh_mahasiswa_Pekerjaan_Ibu" for="x_Pekerjaan_Ibu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Pekerjaan_Ibu->caption() ?><?= $Page->Pekerjaan_Ibu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="el_mahasiswa_Pekerjaan_Ibu">
<input type="<?= $Page->Pekerjaan_Ibu->getInputTextType() ?>" name="x_Pekerjaan_Ibu" id="x_Pekerjaan_Ibu" data-table="mahasiswa" data-field="x_Pekerjaan_Ibu" value="<?= $Page->Pekerjaan_Ibu->getEditValue() ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->Pekerjaan_Ibu->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Pekerjaan_Ibu->formatPattern()) ?>"<?= $Page->Pekerjaan_Ibu->editAttributes() ?> aria-describedby="x_Pekerjaan_Ibu_help">
<?= $Page->Pekerjaan_Ibu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Pekerjaan_Ibu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
    <div id="r_Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->rowAttributes() ?>>
        <label id="elh_mahasiswa_Alamat_Orang_Tua" for="x_Alamat_Orang_Tua" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Alamat_Orang_Tua->caption() ?><?= $Page->Alamat_Orang_Tua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="el_mahasiswa_Alamat_Orang_Tua">
<input type="<?= $Page->Alamat_Orang_Tua->getInputTextType() ?>" name="x_Alamat_Orang_Tua" id="x_Alamat_Orang_Tua" data-table="mahasiswa" data-field="x_Alamat_Orang_Tua" value="<?= $Page->Alamat_Orang_Tua->getEditValue() ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Alamat_Orang_Tua->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Alamat_Orang_Tua->formatPattern()) ?>"<?= $Page->Alamat_Orang_Tua->editAttributes() ?> aria-describedby="x_Alamat_Orang_Tua_help">
<?= $Page->Alamat_Orang_Tua->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Alamat_Orang_Tua->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
    <div id="r_e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->rowAttributes() ?>>
        <label id="elh_mahasiswa_e_mail_Oranng_Tua" for="x_e_mail_Oranng_Tua" class="<?= $Page->LeftColumnClass ?>"><?= $Page->e_mail_Oranng_Tua->caption() ?><?= $Page->e_mail_Oranng_Tua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="el_mahasiswa_e_mail_Oranng_Tua">
<input type="<?= $Page->e_mail_Oranng_Tua->getInputTextType() ?>" name="x_e_mail_Oranng_Tua" id="x_e_mail_Oranng_Tua" data-table="mahasiswa" data-field="x_e_mail_Oranng_Tua" value="<?= $Page->e_mail_Oranng_Tua->getEditValue() ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->e_mail_Oranng_Tua->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->e_mail_Oranng_Tua->formatPattern()) ?>"<?= $Page->e_mail_Oranng_Tua->editAttributes() ?> aria-describedby="x_e_mail_Oranng_Tua_help">
<?= $Page->e_mail_Oranng_Tua->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->e_mail_Oranng_Tua->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
    <div id="r_No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->rowAttributes() ?>>
        <label id="elh_mahasiswa_No_Kontak_Orang_Tua" for="x_No_Kontak_Orang_Tua" class="<?= $Page->LeftColumnClass ?>"><?= $Page->No_Kontak_Orang_Tua->caption() ?><?= $Page->No_Kontak_Orang_Tua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="el_mahasiswa_No_Kontak_Orang_Tua">
<input type="<?= $Page->No_Kontak_Orang_Tua->getInputTextType() ?>" name="x_No_Kontak_Orang_Tua" id="x_No_Kontak_Orang_Tua" data-table="mahasiswa" data-field="x_No_Kontak_Orang_Tua" value="<?= $Page->No_Kontak_Orang_Tua->getEditValue() ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->No_Kontak_Orang_Tua->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->No_Kontak_Orang_Tua->formatPattern()) ?>"<?= $Page->No_Kontak_Orang_Tua->editAttributes() ?> aria-describedby="x_No_Kontak_Orang_Tua_help">
<?= $Page->No_Kontak_Orang_Tua->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->No_Kontak_Orang_Tua->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fmahasiswaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fmahasiswaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmahasiswaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("mahasiswa");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fmahasiswaadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
