<?php
require '../../../app/config.php';
$page = 'cuti';
include_once '../../layout/navhead.php';

$noverif = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE verif = 1 ")->fetch_array();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="bi bi-calendar-range-fill me-2"></i>Data Cuti</h4>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-body border border-dark-danger">
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Data Cuti Belum di Verifikasi <span class="fw-bold badge bg-danger"><?= $noverif['total'] ?> Data</span>
                </a>

                <div class="collapse" id="collapseExample">
                    <div class="table-responsive mt-2">
                        <table id="tbl" class="table table-bordered table-striped dataTable">
                            <thead class="bg-dark-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Data Personil</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                $data = $con->query("SELECT * FROM cuti a LEFT JOIN personil b ON a.id_personil = b.id_personil WHERE a.verif = 1 ORDER BY a.id_cuti ASC");
                                while ($row = $data->fetch_array()) {
                                    $tgl1 = $row['tgl_mulai'];
                                    $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1)));
                                    $a = date_create($tgl2);
                                    $b = date_create($row['tgl_selesai']);
                                    $diff = date_diff($a, $b);
                                ?>
                                    <tr>
                                        <td align="center" width="5%"><?= $no++ ?></td>
                                        <td>
                                            <b>Nama</b> : <?= $row['nm_personil'] ?>
                                            <hr class="my-1">
                                            <b>NRP / NIP</b> : <?= $row['nrp_nip'] ?>
                                        </td>
                                        <td align="center"><?= $row['ket'] ?></td>
                                        <td align="center">
                                            <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) {
                                                echo tgl($row['tgl_mulai']);
                                            } else {
                                                echo tgl($row['tgl_mulai']) . ' s/d ' . tgl($row['tgl_selesai']);
                                            } ?>
                                            <hr class="my-1">
                                            Lama cuti :
                                            <?php if ($diff->y != 0) {
                                                echo $diff->y  . ' Tahun ';
                                            }
                                            if ($diff->m != 0) {
                                                echo $diff->m . ' Bulan ';
                                            } ?>
                                            <?= $diff->d ?> Hari
                                        </td>
                                        <td align="center" width="13%">
                                            <div class="d-grid">
                                                <a href="verif?id=<?= $row['id_cuti'] ?>&v=2" class="btn bg-success text-white btn-xs alert-verif" title="Setujui"><i class="fas fa-check-circle me-1"></i>Setujui</a>
                                                <span data-bs-target="#tolak<?= $row['id_cuti']; ?>" data-bs-toggle="modal" class="btn bg-danger text-white btn-xs mt-1" title="Tolak"><i class="fa fa-times-circle me-1"></i> Tolak</>
                                            </div>
                                            <?php include('tolak.php'); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-body border border-dark-danger mt-3">

                <?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
                    <div id="notif" class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <b><?= $_SESSION['pesan'] ?></b>
                        </div>
                    </div>
                <?php $_SESSION['pesan'] = '';
                } ?>

                <?php if (isset($_SESSION['error']) && $_SESSION['error'] <> '') { ?>
                    <div id="notif" class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <b><?= $_SESSION['error'] ?></b>
                        </div>
                    </div>
                <?php $_SESSION['error'] = '';
                } ?>

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped dataTable">
                        <thead class="bg-dark-danger">
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Data Personil</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM cuti a LEFT JOIN personil b ON a.id_personil = b.id_personil WHERE a.verif != 1 ORDER BY a.id_cuti DESC");
                            while ($row = $data->fetch_array()) {
                                $tgl1 = $row['tgl_mulai'];
                                $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1)));
                                $a = date_create($tgl2);
                                $b = date_create($row['tgl_selesai']);
                                $diff = date_diff($a, $b);
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td align="center">
                                        <?php if ($row['verif'] == 2) { ?>
                                            <?= $row['no_surat'] ?>
                                            <hr class="my-1">
                                            <a href="surat?id=<?= $row[0] ?>" target="_BLANK" class="btn bg-success text-white btn-xs" title="Surat"><i class="fas fa-envelope-open-text me-1"></i>Surat Cuti</a>
                                        <?php } else if ($row['verif'] == 3) { ?>
                                            -
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <b>Nama</b> : <?= $row['nm_personil'] ?>
                                        <hr class="my-1">
                                        <b>NRP / NIP</b> : <?= $row['nrp_nip'] ?>
                                        <hr class="my-1">
                                    </td>
                                    <td align="center"><?= $row['ket'] ?></td>
                                    <td align="center">
                                        <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) {
                                            echo tgl($row['tgl_mulai']);
                                        } else {
                                            echo tgl($row['tgl_mulai']) . ' s/d ' . tgl($row['tgl_selesai']);
                                        } ?>
                                        <hr class="my-1">
                                        Lama cuti :
                                        <?php if ($diff->y != 0) {
                                            echo $diff->y  . ' Tahun ';
                                        }
                                        if ($diff->m != 0) {
                                            echo $diff->m . ' Bulan ';
                                        } ?>
                                        <?= $diff->d ?> Hari
                                    </td>
                                    <td align="center">
                                        <?php if ($row['verif'] == 2) { ?>
                                            <span class="btn btn-xs btn-success"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                        <?php } else if ($row['verif'] == 3) { ?>
                                            <span class="btn btn-xs btn-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                            <hr class="my-1">
                                            Karena <?= $row['tolak'] ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row  -->
</div>


<?php
include_once '../../layout/footer.php';

if (isset($_POST['submit_tolak'])) {
    $tolak = $_POST['tolak'];

    $update = $con->query("UPDATE cuti SET 
        verif = 3, 
        tolak = '$tolak'
        WHERE id_cuti = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data cuti di Tolak";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        $_SESSION['error'] = "Terjadi Kesalahan !";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
}
?>