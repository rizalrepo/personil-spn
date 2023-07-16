<?php
require '../../app/config.php';
$page = 'dashboard';
include_once '../layout/navhead.php';

$a = $con->query("SELECT COUNT(*) AS total FROM personil")->fetch_array();
$e = $con->query("SELECT COUNT(*) AS total FROM kegiatan")->fetch_array();

$a1 = $con->query("SELECT COUNT(*) AS total FROM izin WHERE verif = 1")->fetch_array();
$a2 = $con->query("SELECT COUNT(*) AS total FROM izin WHERE verif != 1")->fetch_array();
$b1 = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE verif = 1 ")->fetch_array();
$b2 = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE verif != 1 ")->fetch_array();
$c1 = $con->query("SELECT COUNT(*) AS total FROM tugas WHERE verif = 1 ")->fetch_array();
$c2 = $con->query("SELECT COUNT(*) AS total FROM tugas WHERE verif != 1 ")->fetch_array();
$d1 = $con->query("SELECT COUNT(*) AS total FROM mutasi WHERE verif = 1 ")->fetch_array();
$d2 = $con->query("SELECT COUNT(*) AS total FROM mutasi WHERE verif != 1 ")->fetch_array();
?>

<!-- Container fluid -->
<div class="bg-dark-danger pt-5 pb-21"></div>
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
                            <i class="fas fa-id-badge fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4>Data Personil</h4>
                            <span class="text-success small pt-1 fw-bold"><?= $a['total'] ?></span>
                            <span class="text-muted small pt-2 ps-1">Total Data</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md bg-light-danger text-danger rounded-2">
                            <i class="far fa-calendar-check fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4>Data Kegiatan</h4>
                            <span class="text-success small pt-1 fw-bold"><?= $e['total'] ?></span>
                            <span class="text-muted small pt-2 ps-1">Total Data</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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
        <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md bg-light-danger text-danger rounded-2">
                            <i class="bi bi-journal-bookmark-fill fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4>Data Perintah Tugas</h4>
                            <span class="badge bg-dark-warning"><?= $c1['total'] ?> Data Belum Diverifikasi</span> <span class="badge bg-dark-success"><?= $c2['total'] ?> Data Diverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-md bg-light-danger text-danger rounded-2">
                            <i class="fas fa-arrow-right-arrow-left fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4>Data Mutasi Jabatan</h4>
                            <span class="badge bg-dark-warning"><?= $d1['total'] ?> Data Belum Diverifikasi</span> <span class="badge bg-dark-success"><?= $d2['total'] ?> Data Diverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <!-- row  -->
</div>

<?php
include_once '../layout/footer.php';
?>