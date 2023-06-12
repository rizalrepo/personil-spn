<?php
require '../../app/config.php';
$page = 'dashboard';
include_once '../layout/navhead.php';

$a = $con->query("SELECT COUNT(*) AS total FROM personil")->fetch_array();
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
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-3">
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
    </div>
    <!-- row  -->
</div>

<?php
include_once '../layout/footer.php';
?>