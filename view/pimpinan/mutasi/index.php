<?php
require '../../../app/config.php';
$page = 'mutasi';
include_once '../../layout/navhead.php';

$noverif = $con->query("SELECT COUNT(*) AS total FROM mutasi WHERE verif = 1 ")->fetch_array();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="fas fa-arrow-rigth-arrow-left me-2"></i>Data Mutasi Jabatan</h4>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-body border border-dark-danger">
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Data Mutasi Jabatan Belum di Verifikasi <span class="fw-bold badge bg-danger"><?= $noverif['total'] ?> Data</span>
                </a>

                <div class="collapse" id="collapseExample">
                    <div class="table-responsive mt-2">
                        <table id="tbl" class="table table-bordered table-striped dataTable">
                            <thead class="bg-dark-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Data Personil</th>
                                    <th>Mutasi Jabatan</th>
                                    <th>Tanggal</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                $data = $con->query("SELECT * FROM mutasi a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON a.id_jabatan = d.id_jabatan WHERE a.verif = 1 ORDER BY a.id_mutasi ASC");
                                while ($row = $data->fetch_array()) {
                                ?>
                                    <tr>
                                        <td align="center" width="5%"><?= $no++ ?></td>
                                        <td>
                                            <b>Nama </b> : <?= $row['nm_personil'] ?>
                                            <hr class="my-1">
                                            <b>NRP/NIP </b> : <?= $row['nrp_nip'] ?>
                                            <hr class="my-1">
                                            <b>Pangkat </b> : <?= $row['nm_pangkat'] ?>
                                        </td>
                                        <td align="center">
                                            <?php $d = $con->query("SELECT * FROM jabatan WHERE id_jabatan = '$row[id_jabatan_lama]' ")->fetch_array(); ?>
                                            <span class="badge bg-dark-warning"><?= $d['nm_jabatan'] ?></span>
                                            <i class="fas fa-arrow-right px-1 mt-2"></i>
                                            <span class="badge bg-dark-success"><?= $row['nm_jabatan'] ?></span>
                                            <hr class="my-2">
                                            <div class="text-center">
                                                <a href="<?= base_url() ?>/storage/mutasi/<?= $row['file_sk'] ?>" target="_BLANK" class="btn btn-xs btn-primary"><i class="fas fa-file-import me-1"></i> File SK</a>
                                            </div>
                                        </td>
                                        <td align="center"><?= tgl($row['tanggal']) ?></td>
                                        <td align="center" width="13%">
                                            <div class="d-grid">
                                                <a href="verif?id=<?= $row['id_mutasi'] ?>&v=2" class="btn bg-success text-white btn-xs alert-setuju" title="Setujui"><i class="fas fa-check-circle me-1"></i>Setujui</a>
                                                <span data-bs-target="#tolak<?= $row['id_mutasi']; ?>" data-bs-toggle="modal" class="btn bg-danger text-white btn-xs mt-1" title="Tolak"><i class="fa fa-times-circle me-1"></i> Tolak</>
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
                                <th>Data Personil</th>
                                <th>Mutasi Jabatan</th>
                                <th>Tanggal</th>
                                <th>Verifikasi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM mutasi a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON a.id_jabatan = d.id_jabatan WHERE a.verif != 1 ORDER BY a.id_mutasi ASC");
                            while ($row = $data->fetch_array()) {
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td>
                                        <b>Nama </b> : <?= $row['nm_personil'] ?>
                                        <hr class="my-1">
                                        <b>NRP/NIP </b> : <?= $row['nrp_nip'] ?>
                                        <hr class="my-1">
                                        <b>Pangkat </b> : <?= $row['nm_pangkat'] ?>
                                    </td>
                                    <td align="center">
                                        <?php $d = $con->query("SELECT * FROM jabatan WHERE id_jabatan = '$row[id_jabatan_lama]' ")->fetch_array(); ?>
                                        <span class="badge bg-dark-warning"><?= $d['nm_jabatan'] ?></span>
                                        <i class="fas fa-arrow-right px-1 mt-2"></i>
                                        <span class="badge bg-dark-success"><?= $row['nm_jabatan'] ?></span>
                                        <hr class="my-2">
                                        <div class="text-center">
                                            <a href="<?= base_url() ?>/storage/mutasi/<?= $row['file_sk'] ?>" target="_BLANK" class="btn btn-xs btn-primary"><i class="fas fa-file-import me-1"></i> File SK</a>
                                        </div>
                                    </td>
                                    <td align="center"><?= tgl($row['tanggal']) ?></td>
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

    $update = $con->query("UPDATE mutasi SET 
        verif = 3, 
        tolak = '$tolak'
        WHERE id_mutasi = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data mutasi di Tolak";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        $_SESSION['error'] = "Terjadi Kesalahan !";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
}
?>