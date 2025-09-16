<?php

namespace PHPMaker2025\pssk2025;

// Page object
$MahasiswaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<?php // Begin of Card view by Masino Sinaga, September 10, 2023 ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("ViewCaption"); ?></h4>
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
<form name="fmahasiswaview" id="fmahasiswaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fmahasiswaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmahasiswaview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mahasiswa">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->NIM->Visible) { // NIM ?>
    <tr id="r_NIM"<?= $Page->NIM->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_NIM"><?= $Page->NIM->caption() ?></span></td>
        <td data-name="NIM"<?= $Page->NIM->cellAttributes() ?>>
<span id="el_mahasiswa_NIM">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
    <tr id="r_Nama"<?= $Page->Nama->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nama"><?= $Page->Nama->caption() ?></span></td>
        <td data-name="Nama"<?= $Page->Nama->cellAttributes() ?>>
<span id="el_mahasiswa_Nama">
<span<?= $Page->Nama->viewAttributes() ?>>
<?= $Page->Nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
    <tr id="r_Jenis_Kelamin"<?= $Page->Jenis_Kelamin->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Jenis_Kelamin"><?= $Page->Jenis_Kelamin->caption() ?></span></td>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_mahasiswa_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
    <tr id="r_Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Provinsi_Tempat_Lahir"><?= $Page->Provinsi_Tempat_Lahir->caption() ?></span></td>
        <td data-name="Provinsi_Tempat_Lahir"<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="el_mahasiswa_Provinsi_Tempat_Lahir">
<span<?= $Page->Provinsi_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Provinsi_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
    <tr id="r_Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Kota_Tempat_Lahir"><?= $Page->Kota_Tempat_Lahir->caption() ?></span></td>
        <td data-name="Kota_Tempat_Lahir"<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="el_mahasiswa_Kota_Tempat_Lahir">
<span<?= $Page->Kota_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
    <tr id="r_Tanggal_Lahir"<?= $Page->Tanggal_Lahir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tanggal_Lahir"><?= $Page->Tanggal_Lahir->caption() ?></span></td>
        <td data-name="Tanggal_Lahir"<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="el_mahasiswa_Tanggal_Lahir">
<span<?= $Page->Tanggal_Lahir->viewAttributes() ?>>
<?= $Page->Tanggal_Lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
    <tr id="r_Golongan_Darah"<?= $Page->Golongan_Darah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Golongan_Darah"><?= $Page->Golongan_Darah->caption() ?></span></td>
        <td data-name="Golongan_Darah"<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="el_mahasiswa_Golongan_Darah">
<span<?= $Page->Golongan_Darah->viewAttributes() ?>>
<?= $Page->Golongan_Darah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
    <tr id="r_Tinggi_Badan"<?= $Page->Tinggi_Badan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tinggi_Badan"><?= $Page->Tinggi_Badan->caption() ?></span></td>
        <td data-name="Tinggi_Badan"<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="el_mahasiswa_Tinggi_Badan">
<span<?= $Page->Tinggi_Badan->viewAttributes() ?>>
<?= $Page->Tinggi_Badan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
    <tr id="r_Berat_Badan"<?= $Page->Berat_Badan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Berat_Badan"><?= $Page->Berat_Badan->caption() ?></span></td>
        <td data-name="Berat_Badan"<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="el_mahasiswa_Berat_Badan">
<span<?= $Page->Berat_Badan->viewAttributes() ?>>
<?= $Page->Berat_Badan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
    <tr id="r_Asal_sekolah"<?= $Page->Asal_sekolah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Asal_sekolah"><?= $Page->Asal_sekolah->caption() ?></span></td>
        <td data-name="Asal_sekolah"<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="el_mahasiswa_Asal_sekolah">
<span<?= $Page->Asal_sekolah->viewAttributes() ?>>
<?= $Page->Asal_sekolah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
    <tr id="r_Tahun_Ijazah"<?= $Page->Tahun_Ijazah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tahun_Ijazah"><?= $Page->Tahun_Ijazah->caption() ?></span></td>
        <td data-name="Tahun_Ijazah"<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="el_mahasiswa_Tahun_Ijazah">
<span<?= $Page->Tahun_Ijazah->viewAttributes() ?>>
<?= $Page->Tahun_Ijazah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
    <tr id="r_Nomor_Ijazah"<?= $Page->Nomor_Ijazah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nomor_Ijazah"><?= $Page->Nomor_Ijazah->caption() ?></span></td>
        <td data-name="Nomor_Ijazah"<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="el_mahasiswa_Nomor_Ijazah">
<span<?= $Page->Nomor_Ijazah->viewAttributes() ?>>
<?= $Page->Nomor_Ijazah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
    <tr id="r_Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nilai_Raport_Kelas_10"><?= $Page->Nilai_Raport_Kelas_10->caption() ?></span></td>
        <td data-name="Nilai_Raport_Kelas_10"<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="el_mahasiswa_Nilai_Raport_Kelas_10">
<span<?= $Page->Nilai_Raport_Kelas_10->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_10->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
    <tr id="r_Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nilai_Raport_Kelas_11"><?= $Page->Nilai_Raport_Kelas_11->caption() ?></span></td>
        <td data-name="Nilai_Raport_Kelas_11"<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="el_mahasiswa_Nilai_Raport_Kelas_11">
<span<?= $Page->Nilai_Raport_Kelas_11->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_11->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
    <tr id="r_Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nilai_Raport_Kelas_12"><?= $Page->Nilai_Raport_Kelas_12->caption() ?></span></td>
        <td data-name="Nilai_Raport_Kelas_12"<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="el_mahasiswa_Nilai_Raport_Kelas_12">
<span<?= $Page->Nilai_Raport_Kelas_12->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_12->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
    <tr id="r_Tanggal_Daftar"<?= $Page->Tanggal_Daftar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tanggal_Daftar"><?= $Page->Tanggal_Daftar->caption() ?></span></td>
        <td data-name="Tanggal_Daftar"<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="el_mahasiswa_Tanggal_Daftar">
<span<?= $Page->Tanggal_Daftar->viewAttributes() ?>>
<?= $Page->Tanggal_Daftar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
    <tr id="r_No_Test"<?= $Page->No_Test->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_No_Test"><?= $Page->No_Test->caption() ?></span></td>
        <td data-name="No_Test"<?= $Page->No_Test->cellAttributes() ?>>
<span id="el_mahasiswa_No_Test">
<span<?= $Page->No_Test->viewAttributes() ?>>
<?= $Page->No_Test->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
    <tr id="r_Status_Masuk"<?= $Page->Status_Masuk->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Status_Masuk"><?= $Page->Status_Masuk->caption() ?></span></td>
        <td data-name="Status_Masuk"<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="el_mahasiswa_Status_Masuk">
<span<?= $Page->Status_Masuk->viewAttributes() ?>>
<?= $Page->Status_Masuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
    <tr id="r_Jalur_Masuk"<?= $Page->Jalur_Masuk->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Jalur_Masuk"><?= $Page->Jalur_Masuk->caption() ?></span></td>
        <td data-name="Jalur_Masuk"<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="el_mahasiswa_Jalur_Masuk">
<span<?= $Page->Jalur_Masuk->viewAttributes() ?>>
<?= $Page->Jalur_Masuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
    <tr id="r_Bukti_Lulus"<?= $Page->Bukti_Lulus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Bukti_Lulus"><?= $Page->Bukti_Lulus->caption() ?></span></td>
        <td data-name="Bukti_Lulus"<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="el_mahasiswa_Bukti_Lulus">
<span<?= $Page->Bukti_Lulus->viewAttributes() ?>>
<?= $Page->Bukti_Lulus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
    <tr id="r_Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tes_Potensi_Akademik"><?= $Page->Tes_Potensi_Akademik->caption() ?></span></td>
        <td data-name="Tes_Potensi_Akademik"<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="el_mahasiswa_Tes_Potensi_Akademik">
<span<?= $Page->Tes_Potensi_Akademik->viewAttributes() ?>>
<?= $Page->Tes_Potensi_Akademik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
    <tr id="r_Tes_Wawancara"<?= $Page->Tes_Wawancara->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tes_Wawancara"><?= $Page->Tes_Wawancara->caption() ?></span></td>
        <td data-name="Tes_Wawancara"<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="el_mahasiswa_Tes_Wawancara">
<span<?= $Page->Tes_Wawancara->viewAttributes() ?>>
<?= $Page->Tes_Wawancara->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
    <tr id="r_Tes_Kesehatan"<?= $Page->Tes_Kesehatan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tes_Kesehatan"><?= $Page->Tes_Kesehatan->caption() ?></span></td>
        <td data-name="Tes_Kesehatan"<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="el_mahasiswa_Tes_Kesehatan">
<span<?= $Page->Tes_Kesehatan->viewAttributes() ?>>
<?= $Page->Tes_Kesehatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
    <tr id="r_Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Hasil_Test_Kesehatan"><?= $Page->Hasil_Test_Kesehatan->caption() ?></span></td>
        <td data-name="Hasil_Test_Kesehatan"<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="el_mahasiswa_Hasil_Test_Kesehatan">
<span<?= $Page->Hasil_Test_Kesehatan->viewAttributes() ?>>
<?= $Page->Hasil_Test_Kesehatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
    <tr id="r_Test_MMPI"<?= $Page->Test_MMPI->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Test_MMPI"><?= $Page->Test_MMPI->caption() ?></span></td>
        <td data-name="Test_MMPI"<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="el_mahasiswa_Test_MMPI">
<span<?= $Page->Test_MMPI->viewAttributes() ?>>
<?= $Page->Test_MMPI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
    <tr id="r_Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Hasil_Test_MMPI"><?= $Page->Hasil_Test_MMPI->caption() ?></span></td>
        <td data-name="Hasil_Test_MMPI"<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="el_mahasiswa_Hasil_Test_MMPI">
<span<?= $Page->Hasil_Test_MMPI->viewAttributes() ?>>
<?= $Page->Hasil_Test_MMPI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
    <tr id="r_Angkatan"<?= $Page->Angkatan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Angkatan"><?= $Page->Angkatan->caption() ?></span></td>
        <td data-name="Angkatan"<?= $Page->Angkatan->cellAttributes() ?>>
<span id="el_mahasiswa_Angkatan">
<span<?= $Page->Angkatan->viewAttributes() ?>>
<?= $Page->Angkatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
    <tr id="r_Tarif_SPP"<?= $Page->Tarif_SPP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Tarif_SPP"><?= $Page->Tarif_SPP->caption() ?></span></td>
        <td data-name="Tarif_SPP"<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="el_mahasiswa_Tarif_SPP">
<span<?= $Page->Tarif_SPP->viewAttributes() ?>>
<?= $Page->Tarif_SPP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
    <tr id="r_NIK_No_KTP"<?= $Page->NIK_No_KTP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_NIK_No_KTP"><?= $Page->NIK_No_KTP->caption() ?></span></td>
        <td data-name="NIK_No_KTP"<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="el_mahasiswa_NIK_No_KTP">
<span<?= $Page->NIK_No_KTP->viewAttributes() ?>>
<?= $Page->NIK_No_KTP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
    <tr id="r_No_KK"<?= $Page->No_KK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_No_KK"><?= $Page->No_KK->caption() ?></span></td>
        <td data-name="No_KK"<?= $Page->No_KK->cellAttributes() ?>>
<span id="el_mahasiswa_No_KK">
<span<?= $Page->No_KK->viewAttributes() ?>>
<?= $Page->No_KK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
    <tr id="r_NPWP"<?= $Page->NPWP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_NPWP"><?= $Page->NPWP->caption() ?></span></td>
        <td data-name="NPWP"<?= $Page->NPWP->cellAttributes() ?>>
<span id="el_mahasiswa_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
    <tr id="r_Status_Nikah"<?= $Page->Status_Nikah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Status_Nikah"><?= $Page->Status_Nikah->caption() ?></span></td>
        <td data-name="Status_Nikah"<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="el_mahasiswa_Status_Nikah">
<span<?= $Page->Status_Nikah->viewAttributes() ?>>
<?= $Page->Status_Nikah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
    <tr id="r_Kewarganegaraan"<?= $Page->Kewarganegaraan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Kewarganegaraan"><?= $Page->Kewarganegaraan->caption() ?></span></td>
        <td data-name="Kewarganegaraan"<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="el_mahasiswa_Kewarganegaraan">
<span<?= $Page->Kewarganegaraan->viewAttributes() ?>>
<?= $Page->Kewarganegaraan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
    <tr id="r_Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Propinsi_Tempat_Tinggal"><?= $Page->Propinsi_Tempat_Tinggal->caption() ?></span></td>
        <td data-name="Propinsi_Tempat_Tinggal"<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Propinsi_Tempat_Tinggal">
<span<?= $Page->Propinsi_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Propinsi_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
    <tr id="r_Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Kota_Tempat_Tinggal"><?= $Page->Kota_Tempat_Tinggal->caption() ?></span></td>
        <td data-name="Kota_Tempat_Tinggal"<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Kota_Tempat_Tinggal">
<span<?= $Page->Kota_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
    <tr id="r_Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Kecamatan_Tempat_Tinggal"><?= $Page->Kecamatan_Tempat_Tinggal->caption() ?></span></td>
        <td data-name="Kecamatan_Tempat_Tinggal"<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Kecamatan_Tempat_Tinggal">
<span<?= $Page->Kecamatan_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kecamatan_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
    <tr id="r_Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Alamat_Tempat_Tinggal"><?= $Page->Alamat_Tempat_Tinggal->caption() ?></span></td>
        <td data-name="Alamat_Tempat_Tinggal"<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Alamat_Tempat_Tinggal">
<span<?= $Page->Alamat_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Alamat_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
    <tr id="r_RT"<?= $Page->RT->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_RT"><?= $Page->RT->caption() ?></span></td>
        <td data-name="RT"<?= $Page->RT->cellAttributes() ?>>
<span id="el_mahasiswa_RT">
<span<?= $Page->RT->viewAttributes() ?>>
<?= $Page->RT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
    <tr id="r_RW"<?= $Page->RW->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_RW"><?= $Page->RW->caption() ?></span></td>
        <td data-name="RW"<?= $Page->RW->cellAttributes() ?>>
<span id="el_mahasiswa_RW">
<span<?= $Page->RW->viewAttributes() ?>>
<?= $Page->RW->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
    <tr id="r_Kelurahan"<?= $Page->Kelurahan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Kelurahan"><?= $Page->Kelurahan->caption() ?></span></td>
        <td data-name="Kelurahan"<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="el_mahasiswa_Kelurahan">
<span<?= $Page->Kelurahan->viewAttributes() ?>>
<?= $Page->Kelurahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
    <tr id="r_Kode_Pos"<?= $Page->Kode_Pos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Kode_Pos"><?= $Page->Kode_Pos->caption() ?></span></td>
        <td data-name="Kode_Pos"<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="el_mahasiswa_Kode_Pos">
<span<?= $Page->Kode_Pos->viewAttributes() ?>>
<?= $Page->Kode_Pos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
    <tr id="r_Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nomor_Telpon_HP"><?= $Page->Nomor_Telpon_HP->caption() ?></span></td>
        <td data-name="Nomor_Telpon_HP"<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="el_mahasiswa_Nomor_Telpon_HP">
<span<?= $Page->Nomor_Telpon_HP->viewAttributes() ?>>
<?= $Page->Nomor_Telpon_HP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <tr id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa__Email"><?= $Page->_Email->caption() ?></span></td>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el_mahasiswa__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
    <tr id="r_Jenis_Tinggal"<?= $Page->Jenis_Tinggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Jenis_Tinggal"><?= $Page->Jenis_Tinggal->caption() ?></span></td>
        <td data-name="Jenis_Tinggal"<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="el_mahasiswa_Jenis_Tinggal">
<span<?= $Page->Jenis_Tinggal->viewAttributes() ?>>
<?= $Page->Jenis_Tinggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
    <tr id="r_Alat_Transportasi"<?= $Page->Alat_Transportasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Alat_Transportasi"><?= $Page->Alat_Transportasi->caption() ?></span></td>
        <td data-name="Alat_Transportasi"<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="el_mahasiswa_Alat_Transportasi">
<span<?= $Page->Alat_Transportasi->viewAttributes() ?>>
<?= $Page->Alat_Transportasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
    <tr id="r_Sumber_Dana"<?= $Page->Sumber_Dana->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Sumber_Dana"><?= $Page->Sumber_Dana->caption() ?></span></td>
        <td data-name="Sumber_Dana"<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="el_mahasiswa_Sumber_Dana">
<span<?= $Page->Sumber_Dana->viewAttributes() ?>>
<?= $Page->Sumber_Dana->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
    <tr id="r_Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Sumber_Dana_Beasiswa"><?= $Page->Sumber_Dana_Beasiswa->caption() ?></span></td>
        <td data-name="Sumber_Dana_Beasiswa"<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="el_mahasiswa_Sumber_Dana_Beasiswa">
<span<?= $Page->Sumber_Dana_Beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_Dana_Beasiswa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
    <tr id="r_Jumlah_Sudara"<?= $Page->Jumlah_Sudara->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Jumlah_Sudara"><?= $Page->Jumlah_Sudara->caption() ?></span></td>
        <td data-name="Jumlah_Sudara"<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="el_mahasiswa_Jumlah_Sudara">
<span<?= $Page->Jumlah_Sudara->viewAttributes() ?>>
<?= $Page->Jumlah_Sudara->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
    <tr id="r_Status_Bekerja"<?= $Page->Status_Bekerja->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Status_Bekerja"><?= $Page->Status_Bekerja->caption() ?></span></td>
        <td data-name="Status_Bekerja"<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="el_mahasiswa_Status_Bekerja">
<span<?= $Page->Status_Bekerja->viewAttributes() ?>>
<?= $Page->Status_Bekerja->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
    <tr id="r_Nomor_Asuransi"<?= $Page->Nomor_Asuransi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nomor_Asuransi"><?= $Page->Nomor_Asuransi->caption() ?></span></td>
        <td data-name="Nomor_Asuransi"<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="el_mahasiswa_Nomor_Asuransi">
<span<?= $Page->Nomor_Asuransi->viewAttributes() ?>>
<?= $Page->Nomor_Asuransi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
    <tr id="r_Hobi"<?= $Page->Hobi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Hobi"><?= $Page->Hobi->caption() ?></span></td>
        <td data-name="Hobi"<?= $Page->Hobi->cellAttributes() ?>>
<span id="el_mahasiswa_Hobi">
<span<?= $Page->Hobi->viewAttributes() ?>>
<?= $Page->Hobi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
    <tr id="r_Foto"<?= $Page->Foto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Foto"><?= $Page->Foto->caption() ?></span></td>
        <td data-name="Foto"<?= $Page->Foto->cellAttributes() ?>>
<span id="el_mahasiswa_Foto">
<span<?= $Page->Foto->viewAttributes() ?>>
<?= $Page->Foto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
    <tr id="r_Nama_Ayah"<?= $Page->Nama_Ayah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nama_Ayah"><?= $Page->Nama_Ayah->caption() ?></span></td>
        <td data-name="Nama_Ayah"<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="el_mahasiswa_Nama_Ayah">
<span<?= $Page->Nama_Ayah->viewAttributes() ?>>
<?= $Page->Nama_Ayah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
    <tr id="r_Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Pekerjaan_Ayah"><?= $Page->Pekerjaan_Ayah->caption() ?></span></td>
        <td data-name="Pekerjaan_Ayah"<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="el_mahasiswa_Pekerjaan_Ayah">
<span<?= $Page->Pekerjaan_Ayah->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ayah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
    <tr id="r_Nama_Ibu"<?= $Page->Nama_Ibu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Nama_Ibu"><?= $Page->Nama_Ibu->caption() ?></span></td>
        <td data-name="Nama_Ibu"<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="el_mahasiswa_Nama_Ibu">
<span<?= $Page->Nama_Ibu->viewAttributes() ?>>
<?= $Page->Nama_Ibu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
    <tr id="r_Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Pekerjaan_Ibu"><?= $Page->Pekerjaan_Ibu->caption() ?></span></td>
        <td data-name="Pekerjaan_Ibu"<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="el_mahasiswa_Pekerjaan_Ibu">
<span<?= $Page->Pekerjaan_Ibu->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ibu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
    <tr id="r_Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_Alamat_Orang_Tua"><?= $Page->Alamat_Orang_Tua->caption() ?></span></td>
        <td data-name="Alamat_Orang_Tua"<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="el_mahasiswa_Alamat_Orang_Tua">
<span<?= $Page->Alamat_Orang_Tua->viewAttributes() ?>>
<?= $Page->Alamat_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
    <tr id="r_e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_e_mail_Oranng_Tua"><?= $Page->e_mail_Oranng_Tua->caption() ?></span></td>
        <td data-name="e_mail_Oranng_Tua"<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="el_mahasiswa_e_mail_Oranng_Tua">
<span<?= $Page->e_mail_Oranng_Tua->viewAttributes() ?>>
<?= $Page->e_mail_Oranng_Tua->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
    <tr id="r_No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_No_Kontak_Orang_Tua"><?= $Page->No_Kontak_Orang_Tua->caption() ?></span></td>
        <td data-name="No_Kontak_Orang_Tua"<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="el_mahasiswa_No_Kontak_Orang_Tua">
<span<?= $Page->No_Kontak_Orang_Tua->viewAttributes() ?>>
<?= $Page->No_Kontak_Orang_Tua->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->userid->Visible) { // userid ?>
    <tr id="r_userid"<?= $Page->userid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_userid"><?= $Page->userid->caption() ?></span></td>
        <td data-name="userid"<?= $Page->userid->cellAttributes() ?>>
<span id="el_mahasiswa_userid">
<span<?= $Page->userid->viewAttributes() ?>>
<?= $Page->userid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_mahasiswa_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip->Visible) { // ip ?>
    <tr id="r_ip"<?= $Page->ip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_ip"><?= $Page->ip->caption() ?></span></td>
        <td data-name="ip"<?= $Page->ip->cellAttributes() ?>>
<span id="el_mahasiswa_ip">
<span<?= $Page->ip->viewAttributes() ?>>
<?= $Page->ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_input->Visible) { // tanggal_input ?>
    <tr id="r_tanggal_input"<?= $Page->tanggal_input->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mahasiswa_tanggal_input"><?= $Page->tanggal_input->caption() ?></span></td>
        <td data-name="tanggal_input"<?= $Page->tanggal_input->cellAttributes() ?>>
<span id="el_mahasiswa_tanggal_input">
<span<?= $Page->tanggal_input->viewAttributes() ?>>
<?= $Page->tanggal_input->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmahasiswaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmahasiswaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
