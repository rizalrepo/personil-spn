<?php
require '../../../app/config.php';
$page = 'mutasi';
include_once '../../layout/navhead.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="fas fa-arrow-right-arrow-left me-2"></i>Data Mutasi Jabatan</h4>
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
                                <th>Data Personil</th>
                                <th>Mutasi Jabatan</th>
                                <th>Tanggal</th>
                                <th>Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM mutasi a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON a.id_jabatan = d.id_jabatan ORDER BY a.id_mutasi DESC");
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
                                    </td>
                                    <td align="center"><?= tgl($row['tanggal']) ?></td>
                                    <td align="center">
                                        <?php if ($row['verif'] == 1) { ?>
                                            <span class="badge bg-dark-warning">Menunggu</span>
                                        <?php } else if ($row['verif'] == 2) { ?>
                                            <span class="badge bg-dark-success">Disetujui</span>
                                        <?php } else { ?>
                                            <span class="badge bg-dark-danger">Ditolak</span><br>
                                            <?= $row['tolak'] ?>
                                        <?php }  ?>
                                    </td>
                                    <td align="center" width="12%">
                                        <a href="<?= base_url('storage/mutasi/' . $row['file_sk']) ?>" target="_blank" class="btn bg-dark-success btn-xs text-white" title="File SK"><i class="fas fa-file-import"></i></a>
                                        <?php if ($row['verif'] == 1) { ?>
                                            <a href="edit?id=<?= $row[0] ?>" class="btn btn-info btn-xs text-white" title="Edit"><i class="fa fa-edit"></i></a>
                                        <?php } ?>
                                        <a href="hapus?id=<?= $row[0] ?>" class="btn btn-danger btn-xs alert-hapus" title="Hapus"><i class="fa fa-trash"></i></a>
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