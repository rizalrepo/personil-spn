<?php
require '../../../app/config.php';
$page = 'cuti';
include_once '../../layout/navhead.php';

$log = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")->fetch_array();
$absen = $log['id_personil'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="bi bi-calendar-range-fill me-2"></i>Data Cuti</h4>
                </div>
                <div>
                    <a href="tambah" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-body border border-dark-danger">

                <?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
                    <div id="notif" class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <b><?= $_SESSION['pesan'] ?></b>
                        </div>
                    </div>
                <?php $_SESSION['pesan'] = '';
                } ?>

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped dataTable">
                        <thead class="bg-dark-danger">
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Status Cuti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM cuti WHERE id_personil = '$absen' ORDER BY id_cuti DESC");
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
                                        <?php if (!$row['no_surat']) {
                                            echo '-';
                                        } else {
                                            echo $row['no_surat'];
                                        } ?>
                                    </td>
                                    <td><?= $row['ket'] ?></td>
                                    <td align="center">
                                        <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) {
                                            echo tgl($row['tgl_mulai']);
                                        } else {
                                            echo tgl($row['tgl_mulai']) . ' s/d ' . tgl($row['tgl_selesai']);
                                        } ?>
                                        <hr class="my-1">
                                        Lama Cuti :
                                        <?php if ($diff->y != 0) {
                                            echo $diff->y  . ' Tahun ';
                                        }
                                        if ($diff->m != 0) {
                                            echo $diff->m . ' Bulan ';
                                        } ?>
                                        <?= $diff->d ?> Hari
                                    </td>
                                    <td align="center">
                                        <?php if ($row['verif'] == 1) { ?>
                                            <span class="btn btn-xs btn-warning">Belum Diverifikasi</span>
                                        <?php } else if ($row['verif'] == 2) { ?>
                                            <span class="btn btn-xs btn-success">Cuti Disetujui</span>
                                        <?php } else { ?>
                                            <span class="btn btn-xs btn-danger">Cuti Ditolak</span>
                                            <hr class="my-1">
                                            Karena <?= $row['tolak'] ?>
                                        <?php } ?>
                                    </td>
                                    <td align="center" width="16%">
                                        <?php if ($row['verif'] == 2) { ?>
                                            <a href="surat?id=<?= $row[0] ?>" target="_blank" class="btn bg-olive btn-xs" title="Surat"><i class="fas fa-envelope-open-text mr-1"></i> Surat Cuti</a>
                                        <?php } else if ($row['verif'] == 1) { ?>
                                            <a href="edit?id=<?= $row[0] ?>" class="btn btn-info text-white btn-xs" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="hapus?id=<?= $row[0] ?>" class="btn btn-danger btn-xs alert-hapus" title="Hapus"><i class="fas fa-trash"></i> Hapus</a>
                                        <?php } else { ?>
                                            -
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
?>