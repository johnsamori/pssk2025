<?php

namespace PHPMaker2025\pssk2025;

// Table
$mata_kuliah = Container("mata_kuliah");
$mata_kuliah->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($mata_kuliah->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_mata_kuliahmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($mata_kuliah->id_mk->Visible) { // id_mk ?>
        <tr id="r_id_mk"<?= $mata_kuliah->id_mk->rowAttributes() ?>>
            <td class="<?= $mata_kuliah->TableLeftColumnClass ?>"><?= $mata_kuliah->id_mk->caption() ?></td>
            <td<?= $mata_kuliah->id_mk->cellAttributes() ?>>
<span id="el_mata_kuliah_id_mk">
<span<?= $mata_kuliah->id_mk->viewAttributes() ?>>
<?= $mata_kuliah->id_mk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mata_kuliah->Kode_MK->Visible) { // Kode_MK ?>
        <tr id="r_Kode_MK"<?= $mata_kuliah->Kode_MK->rowAttributes() ?>>
            <td class="<?= $mata_kuliah->TableLeftColumnClass ?>"><?= $mata_kuliah->Kode_MK->caption() ?></td>
            <td<?= $mata_kuliah->Kode_MK->cellAttributes() ?>>
<span id="el_mata_kuliah_Kode_MK">
<span<?= $mata_kuliah->Kode_MK->viewAttributes() ?>>
<?= $mata_kuliah->Kode_MK->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mata_kuliah->Semester->Visible) { // Semester ?>
        <tr id="r_Semester"<?= $mata_kuliah->Semester->rowAttributes() ?>>
            <td class="<?= $mata_kuliah->TableLeftColumnClass ?>"><?= $mata_kuliah->Semester->caption() ?></td>
            <td<?= $mata_kuliah->Semester->cellAttributes() ?>>
<span id="el_mata_kuliah_Semester">
<span<?= $mata_kuliah->Semester->viewAttributes() ?>>
<?= $mata_kuliah->Semester->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mata_kuliah->Tahun_Akademik->Visible) { // Tahun_Akademik ?>
        <tr id="r_Tahun_Akademik"<?= $mata_kuliah->Tahun_Akademik->rowAttributes() ?>>
            <td class="<?= $mata_kuliah->TableLeftColumnClass ?>"><?= $mata_kuliah->Tahun_Akademik->caption() ?></td>
            <td<?= $mata_kuliah->Tahun_Akademik->cellAttributes() ?>>
<span id="el_mata_kuliah_Tahun_Akademik">
<span<?= $mata_kuliah->Tahun_Akademik->viewAttributes() ?>>
<?= $mata_kuliah->Tahun_Akademik->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($mata_kuliah->Dosen->Visible) { // Dosen ?>
        <tr id="r_Dosen"<?= $mata_kuliah->Dosen->rowAttributes() ?>>
            <td class="<?= $mata_kuliah->TableLeftColumnClass ?>"><?= $mata_kuliah->Dosen->caption() ?></td>
            <td<?= $mata_kuliah->Dosen->cellAttributes() ?>>
<span id="el_mata_kuliah_Dosen">
<span<?= $mata_kuliah->Dosen->viewAttributes() ?>>
<?= $mata_kuliah->Dosen->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
