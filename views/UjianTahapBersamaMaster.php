<?php

namespace PHPMaker2025\pssk2025;

// Table
$ujian_tahap_bersama = Container("ujian_tahap_bersama");
$ujian_tahap_bersama->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($ujian_tahap_bersama->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ujian_tahap_bersamamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($ujian_tahap_bersama->id_utb->Visible) { // id_utb ?>
        <tr id="r_id_utb"<?= $ujian_tahap_bersama->id_utb->rowAttributes() ?>>
            <td class="<?= $ujian_tahap_bersama->TableLeftColumnClass ?>"><?= $ujian_tahap_bersama->id_utb->caption() ?></td>
            <td<?= $ujian_tahap_bersama->id_utb->cellAttributes() ?>>
<span id="el_ujian_tahap_bersama_id_utb">
<span<?= $ujian_tahap_bersama->id_utb->viewAttributes() ?>>
<?= $ujian_tahap_bersama->id_utb->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ujian_tahap_bersama->Ujian->Visible) { // Ujian ?>
        <tr id="r_Ujian"<?= $ujian_tahap_bersama->Ujian->rowAttributes() ?>>
            <td class="<?= $ujian_tahap_bersama->TableLeftColumnClass ?>"><?= $ujian_tahap_bersama->Ujian->caption() ?></td>
            <td<?= $ujian_tahap_bersama->Ujian->cellAttributes() ?>>
<span id="el_ujian_tahap_bersama_Ujian">
<span<?= $ujian_tahap_bersama->Ujian->viewAttributes() ?>>
<?= $ujian_tahap_bersama->Ujian->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ujian_tahap_bersama->Tanggal->Visible) { // Tanggal ?>
        <tr id="r_Tanggal"<?= $ujian_tahap_bersama->Tanggal->rowAttributes() ?>>
            <td class="<?= $ujian_tahap_bersama->TableLeftColumnClass ?>"><?= $ujian_tahap_bersama->Tanggal->caption() ?></td>
            <td<?= $ujian_tahap_bersama->Tanggal->cellAttributes() ?>>
<span id="el_ujian_tahap_bersama_Tanggal">
<span<?= $ujian_tahap_bersama->Tanggal->viewAttributes() ?>>
<?= $ujian_tahap_bersama->Tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
