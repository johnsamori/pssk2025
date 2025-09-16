<?php

namespace PHPMaker2025\pssk2025;

// Page object
$MahasiswaDelete = &$Page;
?>
<script<?= Nonce() ?>>
var currentTable = <?= json_encode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { mahasiswa: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fmahasiswadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fmahasiswadelete")
        .setPageId("delete")
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
<form name="fmahasiswadelete" id="fmahasiswadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CSRF_PROTECTION") && Csrf()->isEnabled()) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" id="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" id="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mahasiswa">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->NIM->Visible) { // NIM ?>
        <th class="<?= $Page->NIM->headerCellClass() ?>"><span id="elh_mahasiswa_NIM" class="mahasiswa_NIM"><?= $Page->NIM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
        <th class="<?= $Page->Nama->headerCellClass() ?>"><span id="elh_mahasiswa_Nama" class="mahasiswa_Nama"><?= $Page->Nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><span id="elh_mahasiswa_Jenis_Kelamin" class="mahasiswa_Jenis_Kelamin"><?= $Page->Jenis_Kelamin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <th class="<?= $Page->Provinsi_Tempat_Lahir->headerCellClass() ?>"><span id="elh_mahasiswa_Provinsi_Tempat_Lahir" class="mahasiswa_Provinsi_Tempat_Lahir"><?= $Page->Provinsi_Tempat_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <th class="<?= $Page->Kota_Tempat_Lahir->headerCellClass() ?>"><span id="elh_mahasiswa_Kota_Tempat_Lahir" class="mahasiswa_Kota_Tempat_Lahir"><?= $Page->Kota_Tempat_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <th class="<?= $Page->Tanggal_Lahir->headerCellClass() ?>"><span id="elh_mahasiswa_Tanggal_Lahir" class="mahasiswa_Tanggal_Lahir"><?= $Page->Tanggal_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <th class="<?= $Page->Golongan_Darah->headerCellClass() ?>"><span id="elh_mahasiswa_Golongan_Darah" class="mahasiswa_Golongan_Darah"><?= $Page->Golongan_Darah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <th class="<?= $Page->Tinggi_Badan->headerCellClass() ?>"><span id="elh_mahasiswa_Tinggi_Badan" class="mahasiswa_Tinggi_Badan"><?= $Page->Tinggi_Badan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <th class="<?= $Page->Berat_Badan->headerCellClass() ?>"><span id="elh_mahasiswa_Berat_Badan" class="mahasiswa_Berat_Badan"><?= $Page->Berat_Badan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <th class="<?= $Page->Asal_sekolah->headerCellClass() ?>"><span id="elh_mahasiswa_Asal_sekolah" class="mahasiswa_Asal_sekolah"><?= $Page->Asal_sekolah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <th class="<?= $Page->Tahun_Ijazah->headerCellClass() ?>"><span id="elh_mahasiswa_Tahun_Ijazah" class="mahasiswa_Tahun_Ijazah"><?= $Page->Tahun_Ijazah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <th class="<?= $Page->Nomor_Ijazah->headerCellClass() ?>"><span id="elh_mahasiswa_Nomor_Ijazah" class="mahasiswa_Nomor_Ijazah"><?= $Page->Nomor_Ijazah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <th class="<?= $Page->Nilai_Raport_Kelas_10->headerCellClass() ?>"><span id="elh_mahasiswa_Nilai_Raport_Kelas_10" class="mahasiswa_Nilai_Raport_Kelas_10"><?= $Page->Nilai_Raport_Kelas_10->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <th class="<?= $Page->Nilai_Raport_Kelas_11->headerCellClass() ?>"><span id="elh_mahasiswa_Nilai_Raport_Kelas_11" class="mahasiswa_Nilai_Raport_Kelas_11"><?= $Page->Nilai_Raport_Kelas_11->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <th class="<?= $Page->Nilai_Raport_Kelas_12->headerCellClass() ?>"><span id="elh_mahasiswa_Nilai_Raport_Kelas_12" class="mahasiswa_Nilai_Raport_Kelas_12"><?= $Page->Nilai_Raport_Kelas_12->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <th class="<?= $Page->Tanggal_Daftar->headerCellClass() ?>"><span id="elh_mahasiswa_Tanggal_Daftar" class="mahasiswa_Tanggal_Daftar"><?= $Page->Tanggal_Daftar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
        <th class="<?= $Page->No_Test->headerCellClass() ?>"><span id="elh_mahasiswa_No_Test" class="mahasiswa_No_Test"><?= $Page->No_Test->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <th class="<?= $Page->Status_Masuk->headerCellClass() ?>"><span id="elh_mahasiswa_Status_Masuk" class="mahasiswa_Status_Masuk"><?= $Page->Status_Masuk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <th class="<?= $Page->Jalur_Masuk->headerCellClass() ?>"><span id="elh_mahasiswa_Jalur_Masuk" class="mahasiswa_Jalur_Masuk"><?= $Page->Jalur_Masuk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <th class="<?= $Page->Bukti_Lulus->headerCellClass() ?>"><span id="elh_mahasiswa_Bukti_Lulus" class="mahasiswa_Bukti_Lulus"><?= $Page->Bukti_Lulus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <th class="<?= $Page->Tes_Potensi_Akademik->headerCellClass() ?>"><span id="elh_mahasiswa_Tes_Potensi_Akademik" class="mahasiswa_Tes_Potensi_Akademik"><?= $Page->Tes_Potensi_Akademik->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <th class="<?= $Page->Tes_Wawancara->headerCellClass() ?>"><span id="elh_mahasiswa_Tes_Wawancara" class="mahasiswa_Tes_Wawancara"><?= $Page->Tes_Wawancara->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <th class="<?= $Page->Tes_Kesehatan->headerCellClass() ?>"><span id="elh_mahasiswa_Tes_Kesehatan" class="mahasiswa_Tes_Kesehatan"><?= $Page->Tes_Kesehatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <th class="<?= $Page->Hasil_Test_Kesehatan->headerCellClass() ?>"><span id="elh_mahasiswa_Hasil_Test_Kesehatan" class="mahasiswa_Hasil_Test_Kesehatan"><?= $Page->Hasil_Test_Kesehatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <th class="<?= $Page->Test_MMPI->headerCellClass() ?>"><span id="elh_mahasiswa_Test_MMPI" class="mahasiswa_Test_MMPI"><?= $Page->Test_MMPI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <th class="<?= $Page->Hasil_Test_MMPI->headerCellClass() ?>"><span id="elh_mahasiswa_Hasil_Test_MMPI" class="mahasiswa_Hasil_Test_MMPI"><?= $Page->Hasil_Test_MMPI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <th class="<?= $Page->Angkatan->headerCellClass() ?>"><span id="elh_mahasiswa_Angkatan" class="mahasiswa_Angkatan"><?= $Page->Angkatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <th class="<?= $Page->Tarif_SPP->headerCellClass() ?>"><span id="elh_mahasiswa_Tarif_SPP" class="mahasiswa_Tarif_SPP"><?= $Page->Tarif_SPP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <th class="<?= $Page->NIK_No_KTP->headerCellClass() ?>"><span id="elh_mahasiswa_NIK_No_KTP" class="mahasiswa_NIK_No_KTP"><?= $Page->NIK_No_KTP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
        <th class="<?= $Page->No_KK->headerCellClass() ?>"><span id="elh_mahasiswa_No_KK" class="mahasiswa_No_KK"><?= $Page->No_KK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th class="<?= $Page->NPWP->headerCellClass() ?>"><span id="elh_mahasiswa_NPWP" class="mahasiswa_NPWP"><?= $Page->NPWP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <th class="<?= $Page->Status_Nikah->headerCellClass() ?>"><span id="elh_mahasiswa_Status_Nikah" class="mahasiswa_Status_Nikah"><?= $Page->Status_Nikah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <th class="<?= $Page->Kewarganegaraan->headerCellClass() ?>"><span id="elh_mahasiswa_Kewarganegaraan" class="mahasiswa_Kewarganegaraan"><?= $Page->Kewarganegaraan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <th class="<?= $Page->Propinsi_Tempat_Tinggal->headerCellClass() ?>"><span id="elh_mahasiswa_Propinsi_Tempat_Tinggal" class="mahasiswa_Propinsi_Tempat_Tinggal"><?= $Page->Propinsi_Tempat_Tinggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <th class="<?= $Page->Kota_Tempat_Tinggal->headerCellClass() ?>"><span id="elh_mahasiswa_Kota_Tempat_Tinggal" class="mahasiswa_Kota_Tempat_Tinggal"><?= $Page->Kota_Tempat_Tinggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <th class="<?= $Page->Kecamatan_Tempat_Tinggal->headerCellClass() ?>"><span id="elh_mahasiswa_Kecamatan_Tempat_Tinggal" class="mahasiswa_Kecamatan_Tempat_Tinggal"><?= $Page->Kecamatan_Tempat_Tinggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <th class="<?= $Page->Alamat_Tempat_Tinggal->headerCellClass() ?>"><span id="elh_mahasiswa_Alamat_Tempat_Tinggal" class="mahasiswa_Alamat_Tempat_Tinggal"><?= $Page->Alamat_Tempat_Tinggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
        <th class="<?= $Page->RT->headerCellClass() ?>"><span id="elh_mahasiswa_RT" class="mahasiswa_RT"><?= $Page->RT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
        <th class="<?= $Page->RW->headerCellClass() ?>"><span id="elh_mahasiswa_RW" class="mahasiswa_RW"><?= $Page->RW->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <th class="<?= $Page->Kelurahan->headerCellClass() ?>"><span id="elh_mahasiswa_Kelurahan" class="mahasiswa_Kelurahan"><?= $Page->Kelurahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <th class="<?= $Page->Kode_Pos->headerCellClass() ?>"><span id="elh_mahasiswa_Kode_Pos" class="mahasiswa_Kode_Pos"><?= $Page->Kode_Pos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <th class="<?= $Page->Nomor_Telpon_HP->headerCellClass() ?>"><span id="elh_mahasiswa_Nomor_Telpon_HP" class="mahasiswa_Nomor_Telpon_HP"><?= $Page->Nomor_Telpon_HP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th class="<?= $Page->_Email->headerCellClass() ?>"><span id="elh_mahasiswa__Email" class="mahasiswa__Email"><?= $Page->_Email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <th class="<?= $Page->Jenis_Tinggal->headerCellClass() ?>"><span id="elh_mahasiswa_Jenis_Tinggal" class="mahasiswa_Jenis_Tinggal"><?= $Page->Jenis_Tinggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <th class="<?= $Page->Alat_Transportasi->headerCellClass() ?>"><span id="elh_mahasiswa_Alat_Transportasi" class="mahasiswa_Alat_Transportasi"><?= $Page->Alat_Transportasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <th class="<?= $Page->Sumber_Dana->headerCellClass() ?>"><span id="elh_mahasiswa_Sumber_Dana" class="mahasiswa_Sumber_Dana"><?= $Page->Sumber_Dana->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <th class="<?= $Page->Sumber_Dana_Beasiswa->headerCellClass() ?>"><span id="elh_mahasiswa_Sumber_Dana_Beasiswa" class="mahasiswa_Sumber_Dana_Beasiswa"><?= $Page->Sumber_Dana_Beasiswa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <th class="<?= $Page->Jumlah_Sudara->headerCellClass() ?>"><span id="elh_mahasiswa_Jumlah_Sudara" class="mahasiswa_Jumlah_Sudara"><?= $Page->Jumlah_Sudara->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <th class="<?= $Page->Status_Bekerja->headerCellClass() ?>"><span id="elh_mahasiswa_Status_Bekerja" class="mahasiswa_Status_Bekerja"><?= $Page->Status_Bekerja->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <th class="<?= $Page->Nomor_Asuransi->headerCellClass() ?>"><span id="elh_mahasiswa_Nomor_Asuransi" class="mahasiswa_Nomor_Asuransi"><?= $Page->Nomor_Asuransi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
        <th class="<?= $Page->Hobi->headerCellClass() ?>"><span id="elh_mahasiswa_Hobi" class="mahasiswa_Hobi"><?= $Page->Hobi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
        <th class="<?= $Page->Foto->headerCellClass() ?>"><span id="elh_mahasiswa_Foto" class="mahasiswa_Foto"><?= $Page->Foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <th class="<?= $Page->Nama_Ayah->headerCellClass() ?>"><span id="elh_mahasiswa_Nama_Ayah" class="mahasiswa_Nama_Ayah"><?= $Page->Nama_Ayah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <th class="<?= $Page->Pekerjaan_Ayah->headerCellClass() ?>"><span id="elh_mahasiswa_Pekerjaan_Ayah" class="mahasiswa_Pekerjaan_Ayah"><?= $Page->Pekerjaan_Ayah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <th class="<?= $Page->Nama_Ibu->headerCellClass() ?>"><span id="elh_mahasiswa_Nama_Ibu" class="mahasiswa_Nama_Ibu"><?= $Page->Nama_Ibu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <th class="<?= $Page->Pekerjaan_Ibu->headerCellClass() ?>"><span id="elh_mahasiswa_Pekerjaan_Ibu" class="mahasiswa_Pekerjaan_Ibu"><?= $Page->Pekerjaan_Ibu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <th class="<?= $Page->Alamat_Orang_Tua->headerCellClass() ?>"><span id="elh_mahasiswa_Alamat_Orang_Tua" class="mahasiswa_Alamat_Orang_Tua"><?= $Page->Alamat_Orang_Tua->caption() ?></span></th>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <th class="<?= $Page->e_mail_Oranng_Tua->headerCellClass() ?>"><span id="elh_mahasiswa_e_mail_Oranng_Tua" class="mahasiswa_e_mail_Oranng_Tua"><?= $Page->e_mail_Oranng_Tua->caption() ?></span></th>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <th class="<?= $Page->No_Kontak_Orang_Tua->headerCellClass() ?>"><span id="elh_mahasiswa_No_Kontak_Orang_Tua" class="mahasiswa_No_Kontak_Orang_Tua"><?= $Page->No_Kontak_Orang_Tua->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->NIM->Visible) { // NIM ?>
        <td<?= $Page->NIM->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIM->viewAttributes() ?>>
<?= $Page->NIM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama->Visible) { // Nama ?>
        <td<?= $Page->Nama->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nama->viewAttributes() ?>>
<?= $Page->Nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Provinsi_Tempat_Lahir->Visible) { // Provinsi_Tempat_Lahir ?>
        <td<?= $Page->Provinsi_Tempat_Lahir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Provinsi_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Provinsi_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kota_Tempat_Lahir->Visible) { // Kota_Tempat_Lahir ?>
        <td<?= $Page->Kota_Tempat_Lahir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kota_Tempat_Lahir->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal_Lahir->Visible) { // Tanggal_Lahir ?>
        <td<?= $Page->Tanggal_Lahir->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tanggal_Lahir->viewAttributes() ?>>
<?= $Page->Tanggal_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Golongan_Darah->Visible) { // Golongan_Darah ?>
        <td<?= $Page->Golongan_Darah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Golongan_Darah->viewAttributes() ?>>
<?= $Page->Golongan_Darah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tinggi_Badan->Visible) { // Tinggi_Badan ?>
        <td<?= $Page->Tinggi_Badan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tinggi_Badan->viewAttributes() ?>>
<?= $Page->Tinggi_Badan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Berat_Badan->Visible) { // Berat_Badan ?>
        <td<?= $Page->Berat_Badan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Berat_Badan->viewAttributes() ?>>
<?= $Page->Berat_Badan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Asal_sekolah->Visible) { // Asal_sekolah ?>
        <td<?= $Page->Asal_sekolah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Asal_sekolah->viewAttributes() ?>>
<?= $Page->Asal_sekolah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tahun_Ijazah->Visible) { // Tahun_Ijazah ?>
        <td<?= $Page->Tahun_Ijazah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tahun_Ijazah->viewAttributes() ?>>
<?= $Page->Tahun_Ijazah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nomor_Ijazah->Visible) { // Nomor_Ijazah ?>
        <td<?= $Page->Nomor_Ijazah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nomor_Ijazah->viewAttributes() ?>>
<?= $Page->Nomor_Ijazah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_10->Visible) { // Nilai_Raport_Kelas_10 ?>
        <td<?= $Page->Nilai_Raport_Kelas_10->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_Raport_Kelas_10->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_10->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_11->Visible) { // Nilai_Raport_Kelas_11 ?>
        <td<?= $Page->Nilai_Raport_Kelas_11->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_Raport_Kelas_11->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_11->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nilai_Raport_Kelas_12->Visible) { // Nilai_Raport_Kelas_12 ?>
        <td<?= $Page->Nilai_Raport_Kelas_12->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nilai_Raport_Kelas_12->viewAttributes() ?>>
<?= $Page->Nilai_Raport_Kelas_12->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tanggal_Daftar->Visible) { // Tanggal_Daftar ?>
        <td<?= $Page->Tanggal_Daftar->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tanggal_Daftar->viewAttributes() ?>>
<?= $Page->Tanggal_Daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->No_Test->Visible) { // No_Test ?>
        <td<?= $Page->No_Test->cellAttributes() ?>>
<span id="">
<span<?= $Page->No_Test->viewAttributes() ?>>
<?= $Page->No_Test->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status_Masuk->Visible) { // Status_Masuk ?>
        <td<?= $Page->Status_Masuk->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status_Masuk->viewAttributes() ?>>
<?= $Page->Status_Masuk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jalur_Masuk->Visible) { // Jalur_Masuk ?>
        <td<?= $Page->Jalur_Masuk->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jalur_Masuk->viewAttributes() ?>>
<?= $Page->Jalur_Masuk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Bukti_Lulus->Visible) { // Bukti_Lulus ?>
        <td<?= $Page->Bukti_Lulus->cellAttributes() ?>>
<span id="">
<span<?= $Page->Bukti_Lulus->viewAttributes() ?>>
<?= $Page->Bukti_Lulus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tes_Potensi_Akademik->Visible) { // Tes_Potensi_Akademik ?>
        <td<?= $Page->Tes_Potensi_Akademik->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tes_Potensi_Akademik->viewAttributes() ?>>
<?= $Page->Tes_Potensi_Akademik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tes_Wawancara->Visible) { // Tes_Wawancara ?>
        <td<?= $Page->Tes_Wawancara->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tes_Wawancara->viewAttributes() ?>>
<?= $Page->Tes_Wawancara->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tes_Kesehatan->Visible) { // Tes_Kesehatan ?>
        <td<?= $Page->Tes_Kesehatan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tes_Kesehatan->viewAttributes() ?>>
<?= $Page->Tes_Kesehatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Hasil_Test_Kesehatan->Visible) { // Hasil_Test_Kesehatan ?>
        <td<?= $Page->Hasil_Test_Kesehatan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Hasil_Test_Kesehatan->viewAttributes() ?>>
<?= $Page->Hasil_Test_Kesehatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Test_MMPI->Visible) { // Test_MMPI ?>
        <td<?= $Page->Test_MMPI->cellAttributes() ?>>
<span id="">
<span<?= $Page->Test_MMPI->viewAttributes() ?>>
<?= $Page->Test_MMPI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Hasil_Test_MMPI->Visible) { // Hasil_Test_MMPI ?>
        <td<?= $Page->Hasil_Test_MMPI->cellAttributes() ?>>
<span id="">
<span<?= $Page->Hasil_Test_MMPI->viewAttributes() ?>>
<?= $Page->Hasil_Test_MMPI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Angkatan->Visible) { // Angkatan ?>
        <td<?= $Page->Angkatan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Angkatan->viewAttributes() ?>>
<?= $Page->Angkatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Tarif_SPP->Visible) { // Tarif_SPP ?>
        <td<?= $Page->Tarif_SPP->cellAttributes() ?>>
<span id="">
<span<?= $Page->Tarif_SPP->viewAttributes() ?>>
<?= $Page->Tarif_SPP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NIK_No_KTP->Visible) { // NIK_No_KTP ?>
        <td<?= $Page->NIK_No_KTP->cellAttributes() ?>>
<span id="">
<span<?= $Page->NIK_No_KTP->viewAttributes() ?>>
<?= $Page->NIK_No_KTP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->No_KK->Visible) { // No_KK ?>
        <td<?= $Page->No_KK->cellAttributes() ?>>
<span id="">
<span<?= $Page->No_KK->viewAttributes() ?>>
<?= $Page->No_KK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td<?= $Page->NPWP->cellAttributes() ?>>
<span id="">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status_Nikah->Visible) { // Status_Nikah ?>
        <td<?= $Page->Status_Nikah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status_Nikah->viewAttributes() ?>>
<?= $Page->Status_Nikah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kewarganegaraan->Visible) { // Kewarganegaraan ?>
        <td<?= $Page->Kewarganegaraan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kewarganegaraan->viewAttributes() ?>>
<?= $Page->Kewarganegaraan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Propinsi_Tempat_Tinggal->Visible) { // Propinsi_Tempat_Tinggal ?>
        <td<?= $Page->Propinsi_Tempat_Tinggal->cellAttributes() ?>>
<span id="">
<span<?= $Page->Propinsi_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Propinsi_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kota_Tempat_Tinggal->Visible) { // Kota_Tempat_Tinggal ?>
        <td<?= $Page->Kota_Tempat_Tinggal->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kota_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kota_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kecamatan_Tempat_Tinggal->Visible) { // Kecamatan_Tempat_Tinggal ?>
        <td<?= $Page->Kecamatan_Tempat_Tinggal->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kecamatan_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Kecamatan_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Alamat_Tempat_Tinggal->Visible) { // Alamat_Tempat_Tinggal ?>
        <td<?= $Page->Alamat_Tempat_Tinggal->cellAttributes() ?>>
<span id="">
<span<?= $Page->Alamat_Tempat_Tinggal->viewAttributes() ?>>
<?= $Page->Alamat_Tempat_Tinggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RT->Visible) { // RT ?>
        <td<?= $Page->RT->cellAttributes() ?>>
<span id="">
<span<?= $Page->RT->viewAttributes() ?>>
<?= $Page->RT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RW->Visible) { // RW ?>
        <td<?= $Page->RW->cellAttributes() ?>>
<span id="">
<span<?= $Page->RW->viewAttributes() ?>>
<?= $Page->RW->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kelurahan->Visible) { // Kelurahan ?>
        <td<?= $Page->Kelurahan->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kelurahan->viewAttributes() ?>>
<?= $Page->Kelurahan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Kode_Pos->Visible) { // Kode_Pos ?>
        <td<?= $Page->Kode_Pos->cellAttributes() ?>>
<span id="">
<span<?= $Page->Kode_Pos->viewAttributes() ?>>
<?= $Page->Kode_Pos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nomor_Telpon_HP->Visible) { // Nomor_Telpon_HP ?>
        <td<?= $Page->Nomor_Telpon_HP->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nomor_Telpon_HP->viewAttributes() ?>>
<?= $Page->Nomor_Telpon_HP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <td<?= $Page->_Email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jenis_Tinggal->Visible) { // Jenis_Tinggal ?>
        <td<?= $Page->Jenis_Tinggal->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jenis_Tinggal->viewAttributes() ?>>
<?= $Page->Jenis_Tinggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Alat_Transportasi->Visible) { // Alat_Transportasi ?>
        <td<?= $Page->Alat_Transportasi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Alat_Transportasi->viewAttributes() ?>>
<?= $Page->Alat_Transportasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sumber_Dana->Visible) { // Sumber_Dana ?>
        <td<?= $Page->Sumber_Dana->cellAttributes() ?>>
<span id="">
<span<?= $Page->Sumber_Dana->viewAttributes() ?>>
<?= $Page->Sumber_Dana->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sumber_Dana_Beasiswa->Visible) { // Sumber_Dana_Beasiswa ?>
        <td<?= $Page->Sumber_Dana_Beasiswa->cellAttributes() ?>>
<span id="">
<span<?= $Page->Sumber_Dana_Beasiswa->viewAttributes() ?>>
<?= $Page->Sumber_Dana_Beasiswa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Jumlah_Sudara->Visible) { // Jumlah_Sudara ?>
        <td<?= $Page->Jumlah_Sudara->cellAttributes() ?>>
<span id="">
<span<?= $Page->Jumlah_Sudara->viewAttributes() ?>>
<?= $Page->Jumlah_Sudara->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Status_Bekerja->Visible) { // Status_Bekerja ?>
        <td<?= $Page->Status_Bekerja->cellAttributes() ?>>
<span id="">
<span<?= $Page->Status_Bekerja->viewAttributes() ?>>
<?= $Page->Status_Bekerja->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nomor_Asuransi->Visible) { // Nomor_Asuransi ?>
        <td<?= $Page->Nomor_Asuransi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nomor_Asuransi->viewAttributes() ?>>
<?= $Page->Nomor_Asuransi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Hobi->Visible) { // Hobi ?>
        <td<?= $Page->Hobi->cellAttributes() ?>>
<span id="">
<span<?= $Page->Hobi->viewAttributes() ?>>
<?= $Page->Hobi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Foto->Visible) { // Foto ?>
        <td<?= $Page->Foto->cellAttributes() ?>>
<span id="">
<span<?= $Page->Foto->viewAttributes() ?>>
<?= $Page->Foto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Ayah->Visible) { // Nama_Ayah ?>
        <td<?= $Page->Nama_Ayah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nama_Ayah->viewAttributes() ?>>
<?= $Page->Nama_Ayah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pekerjaan_Ayah->Visible) { // Pekerjaan_Ayah ?>
        <td<?= $Page->Pekerjaan_Ayah->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pekerjaan_Ayah->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ayah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Nama_Ibu->Visible) { // Nama_Ibu ?>
        <td<?= $Page->Nama_Ibu->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nama_Ibu->viewAttributes() ?>>
<?= $Page->Nama_Ibu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Pekerjaan_Ibu->Visible) { // Pekerjaan_Ibu ?>
        <td<?= $Page->Pekerjaan_Ibu->cellAttributes() ?>>
<span id="">
<span<?= $Page->Pekerjaan_Ibu->viewAttributes() ?>>
<?= $Page->Pekerjaan_Ibu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Alamat_Orang_Tua->Visible) { // Alamat_Orang_Tua ?>
        <td<?= $Page->Alamat_Orang_Tua->cellAttributes() ?>>
<span id="">
<span<?= $Page->Alamat_Orang_Tua->viewAttributes() ?>>
<?= $Page->Alamat_Orang_Tua->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->e_mail_Oranng_Tua->Visible) { // e_mail_Oranng_Tua ?>
        <td<?= $Page->e_mail_Oranng_Tua->cellAttributes() ?>>
<span id="">
<span<?= $Page->e_mail_Oranng_Tua->viewAttributes() ?>>
<?= $Page->e_mail_Oranng_Tua->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->No_Kontak_Orang_Tua->Visible) { // No_Kontak_Orang_Tua ?>
        <td<?= $Page->No_Kontak_Orang_Tua->cellAttributes() ?>>
<span id="">
<span<?= $Page->No_Kontak_Orang_Tua->viewAttributes() ?>>
<?= $Page->No_Kontak_Orang_Tua->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Result?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmahasiswadelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmahasiswadelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<script<?= Nonce() ?>>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
