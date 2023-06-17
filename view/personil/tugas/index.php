<?php
require '../../../app/config.php';
$page = 'tugas';
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
                    <h4 class="mb-0"><i class="bi bi-journal-bookmark-fill me-2"></i>Data Perintah Tugas</h4>
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
                                <th>Surat</th>
                                <th>Agenda</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM tugas a LEFT JOIN tugas_detail b ON a.id_tugas = b.id_tugas WHERE b.id_personil = '$absen' ORDER BY a.id_tugas DESC");
                            while ($row = $data->fetch_array()) {
                                $tgl1 = $row['tgl_mulai'];
                                $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1)));
                                $a = date_create($tgl2);
                                $b = date_create($row['tgl_selesai']);
                                $diff = date_diff($a, $b);
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td width="22%">
                                        <b>Nomor</b> : <?= $row['no_surat'] ?>
                                        <hr class="mt-1 mb-1">
                                        <b>Tanggal</b> : <?= tgl($row['tgl_surat']) ?>
                                    </td>
                                    <td align="center"><?= $row['agenda'] ?></td>
                                    <td align="center">
                                        <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) {
                                            echo tgl($row['tgl_mulai']);
                                            echo '<hr class="my-1">
                                                        Lama Tugas : ' . $diff->d . ' Hari';
                                        } else {
                                            echo tgl($row['tgl_mulai']) . ' s/d ' . tgl($row['tgl_selesai']);
                                            echo '<hr class="my-1"> Lama Tugas : ' . $diff->d . ' Hari';
                                        } ?>
                                    </td>
                                    <td align="center"><?= $row['tempat'] ?></td>
                                    <td align="center" width="7%">
                                        <a href="surat?id=<?= $row[0] ?>" class="btn bg-success text-white btn-xs" title="Surat Perintah Tugas" target="_blank"><i class="fas fa-file-pdf"></i> Surat</a>
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