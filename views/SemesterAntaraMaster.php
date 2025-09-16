<?php

namespace PHPMaker2025\pssk2025;

// Table
$semester_antara = Container("semester_antara");
$semester_antara->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($semester_antara->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_semester_antaramaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($semester_antara->id_smtr->Visible) { // id_smtr ?>
        <tr id="r_id_smtr"<?= $semester_antara->id_smtr->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->id_smtr->caption() ?></td>
            <td<?= $semester_antara->id_smtr->cellAttributes() ?>>
<span id="el_semester_antara_id_smtr">
<span<?= $semester_antara->id_smtr->viewAttributes() ?>>
<?= $semester_antara->id_smtr->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->Semester->Visible) { // Semester ?>
        <tr id="r_Semester"<?= $semester_antara->Semester->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->Semester->caption() ?></td>
            <td<?= $semester_antara->Semester->cellAttributes() ?>>
<span id="el_semester_antara_Semester">
<span<?= $semester_antara->Semester->viewAttributes() ?>>
<?= $semester_antara->Semester->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->Jadwal->Visible) { // Jadwal ?>
        <tr id="r_Jadwal"<?= $semester_antara->Jadwal->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->Jadwal->caption() ?></td>
            <td<?= $semester_antara->Jadwal->cellAttributes() ?>>
<span id="el_semester_antara_Jadwal">
<span<?= $semester_antara->Jadwal->viewAttributes() ?>>
<?= $semester_antara->Jadwal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->Tahun_Akademik->Visible) { // Tahun_Akademik ?>
        <tr id="r_Tahun_Akademik"<?= $semester_antara->Tahun_Akademik->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->Tahun_Akademik->caption() ?></td>
            <td<?= $semester_antara->Tahun_Akademik->cellAttributes() ?>>
<span id="el_semester_antara_Tahun_Akademik">
<span<?= $semester_antara->Tahun_Akademik->viewAttributes() ?>>
<?= $semester_antara->Tahun_Akademik->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->Tanggal->Visible) { // Tanggal ?>
        <tr id="r_Tanggal"<?= $semester_antara->Tanggal->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->Tanggal->caption() ?></td>
            <td<?= $semester_antara->Tanggal->cellAttributes() ?>>
<span id="el_semester_antara_Tanggal">
<span<?= $semester_antara->Tanggal->viewAttributes() ?>>
<?= $semester_antara->Tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->User_id->Visible) { // User_id ?>
        <tr id="r_User_id"<?= $semester_antara->User_id->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->User_id->caption() ?></td>
            <td<?= $semester_antara->User_id->cellAttributes() ?>>
<span id="el_semester_antara_User_id">
<span<?= $semester_antara->User_id->viewAttributes() ?>>
<?= $semester_antara->User_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->User->Visible) { // User ?>
        <tr id="r_User"<?= $semester_antara->User->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->User->caption() ?></td>
            <td<?= $semester_antara->User->cellAttributes() ?>>
<span id="el_semester_antara_User">
<span<?= $semester_antara->User->viewAttributes() ?>>
<?= $semester_antara->User->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($semester_antara->IP->Visible) { // IP ?>
        <tr id="r_IP"<?= $semester_antara->IP->rowAttributes() ?>>
            <td class="<?= $semester_antara->TableLeftColumnClass ?>"><?= $semester_antara->IP->caption() ?></td>
            <td<?= $semester_antara->IP->cellAttributes() ?>>
<span id="el_semester_antara_IP">
<span<?= $semester_antara->IP->viewAttributes() ?>>
<?= $semester_antara->IP->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
