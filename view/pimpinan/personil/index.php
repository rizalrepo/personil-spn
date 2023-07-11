<?php
require '../../../app/config.php';
$page = 'personil';
include_once '../../layout/navhead.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="fas fa-id-badge me-2"></i>Data Personil</h4>
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
                                <th>Nama Lengkap</th>
                                <th>NRP / NIP</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                                <th>TMT</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM personil a JOIN pangkat b ON a.id_pangkat = b.id_pangkat JOIN jabatan c ON a.id_jabatan = c.id_jabatan ORDER BY a.id_personil DESC");
                            while ($row = $data->fetch_array()) {
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td><?= $row['nm_personil'] ?></td>
                                    <td align="center"><?= $row['nrp_nip'] ?></td>
                                    <td align="center"><?= $row['nm_pangkat'] ?></td>
                                    <td align="center"><?= $row['nm_jabatan'] ?></td>
                                    <td align="center"><?= tgl($row['tmt']) ?></td>
                                    <td align="center" width="7%">
                                        <div class="d-grid">
                                            <span data-bs-target="#id<?= $row[0]; ?>" data-bs-toggle="modal" class="btn btn-success btn-xs text-white" title="Detail"><i class="fa fa-info-circle me-1"></i> Detail</span>
                                        </div>
                                        <?php include('../../detail/personil.php'); ?>
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