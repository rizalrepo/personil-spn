<?php
require '../../../app/config.php';
$page = 'izin';
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
                    <h4 class="mb-0"><i class="bi bi-calendar-week-fill me-2"></i>Data Izin</h4>
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
                                <th>Personil</th>
                                <th>Jenis Izin</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Status Izin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM izin a JOIN personil b ON a.id_personil = b.id_personil WHERE a.id_personil = '$absen' ORDER BY a.id_izin DESC");
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
                                    <td align="center"><?= $row['sts_izin'] ?></td>
                                    <td><?= $row['ket_izin'] ?></td>
                                    <td align="center">
                                        <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) {
                                            echo tgl($row['tgl_mulai']);
                                        } else {
                                            echo tgl($row['tgl_mulai']) . ' s/d ' . tgl($row['tgl_selesai']);
                                        } ?>
                                        <hr class="my-1">
                                        Lama Izin :
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
                                            <span class="btn btn-xs bg-dark-warning text-white"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                        <?php } else if ($row['verif'] == 2) { ?>
                                            <span class="btn btn-xs btn-success"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                        <?php } else { ?>
                                            <span class="btn btn-xs btn-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                            <hr class="my-1">
                                            Karena <?= $row['tolak'] ?>
                                        <?php }  ?>
                                    </td>
                                    <td align="center" width="11%">
                                        <a href="<?= base_url() ?>/storage/izin/<?= $row['file_izin'] ?>" target="_BLANK" class="btn btn-xs btn-primary"><i class="fas fa-file-alt"></i></a>
                                        <?php if ($row['verif'] == 1) { ?>
                                            <a href="edit?id=<?= $row[0] ?>" class="btn btn-info text-white btn-xs" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="hapus?id=<?= $row[0] ?>" class="btn btn-danger btn-xs alert-hapus" title="Hapus"><i class="fas fa-trash"></i></a>
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