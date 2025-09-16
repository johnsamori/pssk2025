<?php

namespace PHPMaker2025\pssk2025;

// Page object
$Dashboard2 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$conn = Conn();
// $db = Conn();
//$db =& DbHelper();

$dosen = ExecuteScalar("SELECT count(NIP) from dosen");
$mhs = ExecuteScalar("SELECT count(NIM) from mahasiswa");
$beasiswa= ExecuteScalar("SELECT count(id_kemahasiswaan) from kemahasiswaan");
?>
<div class="row text-white">
                <div class="card bg-success m-lg-5 p-5 pt-2" style="width: 18rem;">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa-solid fa-graduation-cap m-lg-2"></i>
                        </div>

                        <h5 class="card-title text-white-50">Mahasiswa</h5>
                      
                    <div class="display-4"> <?php echo $mhs ?>  </div>
                    </div>
                </div>
                <div class="card bg-success m-lg-5 p-5 pt-2" style="width: 18rem;">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa-solid fa-user-pen m-lg-2"></i>
                        </div>
                        <h5 class="card-title text-white-50">Dosen</h5>
                              <div class="display-4"> <?php echo $dosen ?>  </div>                     
                    </div>
                </div>  

                 <div class="card bg-success m-lg-5 p-5 pt-2" style="width: 18rem;">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="fa-solid fa-hand-holding-dollar m-lg-2"></i>
                        </div>
                        <h5 class="card-title text-white-50">Beasiswa</h5>
                        <div class="display-4"> <?php echo $beasiswa ?>  </div>
                    </div>
                </div>  

 </div>
