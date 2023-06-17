<?php
require '../../app/config.php';
$page = 'dashboard';
include_once '../layout/navhead.php';

$log = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")->fetch_array();
$user = $log['id_personil'];

$a1 = $con->query("SELECT COUNT(*) AS total FROM izin WHERE id_personil = '$user' AND verif = 1")->fetch_array();
$a2 = $con->query("SELECT COUNT(*) AS total FROM izin WHERE id_personil = '$user' AND verif != 1")->fetch_array();
$b1 = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE id_personil = '$user' AND verif = 1 ")->fetch_array();
$b2 = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE id_personil = '$user' AND verif != 1 ")->fetch_array();
?>

<!-- Container fluid -->
<div class="bg-dark-danger pt-5 pb-22"></div>
<div class="container-fluid mt-n22">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Administrasi Personil SPN POLDA KALSEL</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md bg-light-danger text-danger rounded-2">
                            <i class="bi bi-calendar-week-fill fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4>Data Izin</h4>
                            <span class="badge bg-dark-warning"><?= $a1['total'] ?> Data Belum Diverifikasi</span> <span class="badge bg-dark-success"><?= $a2['total'] ?> Data Diverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md bg-light-danger text-danger rounded-2">
                            <i class="bi bi-calendar-range-fill fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4>Data Cuti</h4>
                            <span class="badge bg-dark-warning"><?= $b1['total'] ?> Data Belum Diverifikasi</span> <span class="badge bg-dark-success"><?= $b2['total'] ?> Data Diverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row  -->
</div>

<?php
include_once '../layout/footer.php';
?>