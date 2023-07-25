<?php
require '../../../app/configtables.php';
$con = mysqli_connect($con['host'], $con['user'], $con['pass'], $con['db']);
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}
?>

<div id="id<?= $id = $row[0]; ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="custom-width-modalLabel"><i class="far fa-calendar-check me-2"></i>Detail Data Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php
            $q = $con->query("SELECT * FROM kegiatan a LEFT JOIN jenis_kegiatan b ON a.id_jenis_kegiatan = b.id_jenis_kegiatan LEFT JOIN personil c ON a.id_personil = c.id_personil WHERE a.id_kegiatan = '$id'");
            $d = $q->fetch_array();
            ?>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="card-body text-start">
                            <dl class="row">
                                <dt class="col-sm-3">Kegiatan</dt>
                                <dd class="col-sm-9">: <?= $d['nm_kegiatan'] ?></dd>
                                <dt class="col-sm-3">Jenis Kegiatan</dt>
                                <dd class="col-sm-9">: <?= $d['nm_jenis_kegiatan'] ?></dd>
                                <dt class="col-sm-3">Tanggal</dt>
                                <dd class="col-sm-9">:
                                    <?php if ($d['tgl_mulai'] == $d['tgl_selesai']) { ?>
                                        <?= tgl($d['tgl_mulai']) ?>
                                    <?php } else { ?>
                                        <?= tgl($d['tgl_mulai']) . ' - ' . tgl($d['tgl_selesai']) ?>
                                    <?php } ?>
                                    <?php
                                    $tgl1 = $d['tgl_mulai'];
                                    $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1)));
                                    $a = date_create($tgl2);
                                    $b = date_create($d['tgl_selesai']);
                                    $diff = date_diff($a, $b);
                                    echo  '(' . $diff->d . ' Hari)';
                                    ?>
                                </dd>
                                <dt class="col-sm-3">Tempat Pelaksanaan</dt>
                                <dd class="col-sm-9">: <?= $d['tempat'] ?></dd>
                                <dt class="col-sm-3">Keterangan</dt>
                                <dd class="col-sm-9">: <?= $d['ket'] ?></dd>
                                <dt class="col-sm-3">Penanggung Jawab</dt>
                                <dd class="col-sm-9">: <?= $d['nm_personil'] ?></dd>
                                <dt class="col-sm-3">Status Kegiatan</dt>
                                <dd class="col-sm-9">:
                                    <?php if ($d['tgl_mulai'] <= date('Y-m-d') && $d['tgl_selesai'] >= date('Y-m-d')) { ?>
                                        <span class="badge bg-primary">Sedang Berjalan</span>
                                    <?php } else if ($d['tgl_mulai'] > date('Y-m-d')) { ?>
                                        <span class="badge bg-warning">Belum Berjalan</span>
                                    <?php } else if ($d['tgl_selesai'] < date('Y-m-d')) { ?>
                                        <span class="badge bg-success">Kegiatan Selesai</span>
                                    <?php } ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->