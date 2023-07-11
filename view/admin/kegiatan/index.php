<?php
require '../../../app/config.php';
$page = 'kegiatan';
include_once '../../layout/navhead.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="far fa-calendar-check me-2"></i>Data Kegiatan</h4>
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
                                <th>Nama Kegiatan</th>
                                <th>Jenis Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM kegiatan a LEFT JOIN jenis_kegiatan b ON a.id_jenis_kegiatan = b.id_jenis_kegiatan ORDER BY a.id_kegiatan DESC");
                            while ($row = $data->fetch_array()) {
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td><?= $row['nm_kegiatan'] ?></td>
                                    <td align="center"><?= $row['nm_jenis_kegiatan'] ?></td>
                                    <td align="center">
                                        <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) { ?>
                                            <?= tgl($row['tgl_mulai']) ?>
                                        <?php } else { ?>
                                            <?= tgl($row['tgl_mulai']) . ' - ' . tgl($row['tgl_selesai']) ?>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($row['tgl_mulai'] <= date('Y-m-d') && $row['tgl_selesai'] >= date('Y-m-d')) { ?>
                                            <span class="badge bg-primary">Sedang Berjalan</span>
                                        <?php } else if ($row['tgl_mulai'] > date('Y-m-d')) { ?>
                                            <span class="badge bg-warning">Belum Berjalan</span>
                                        <?php } else if ($row['tgl_selesai'] < date('Y-m-d')) { ?>
                                            <span class="badge bg-success">Program Selesai</span>
                                        <?php } ?>
                                    </td>
                                    <td align="center" width="12%">
                                        <span data-bs-target="#id<?= $row[0]; ?>" data-bs-toggle="modal" class="btn btn-success btn-xs text-white" title="Detail"><i class="fa fa-info-circle"></i></span>
                                        <a href="edit?id=<?= $row[0] ?>" class="btn btn-info btn-xs text-white" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="hapus?id=<?= $row[0] ?>" class="btn btn-danger btn-xs alert-hapus" title="Hapus"><i class="fa fa-trash"></i></a>
                                        <?php include('../../detail/kegiatan.php'); ?>
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