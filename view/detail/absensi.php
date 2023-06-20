<?php
require '../../../app/configtables.php';
$con = mysqli_connect($con['host'], $con['user'], $con['pass'], $con['db']);
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}
?>
<style>
    .dataTables_length,
    .dataTables_info {
        text-align: left;
    }
</style>

<div id="id<?= $id = $row[0]; ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <?php
                $q = $con->query("SELECT * FROM absensi a JOIN personil b ON a.id_personil = b.id_personil WHERE a.id_personil = '$id' ORDER BY tanggal DESC");
                $d = $con->query("SELECT * FROM personil WHERE id_personil = '$id'")->fetch_array();
                ?>
                <h5 class="modal-title" id="custom-width-modalLabel"><i class="fas fa-map-marked-alt me-2"></i>Absensi <span class="fw-bold"><?= $d['nm_personil'] ?></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example-<?= $id ?>" class="table table-bordered table-hover table-striped dataTable">
                        <thead class="bg-dark-danger">
                            <tr align="center">
                                <th>No</th>
                                <th>Hari</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no1 = 1;
                            while ($r = $q->fetch_array()) {
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no1++ ?></td>
                                    <td align="center"><?= hari($r['tanggal']) ?></td>
                                    <td align="center"><?= tgl($r['tanggal']) ?></td>
                                    <td align="center">
                                        <?php if ($r['sts'] == 'Hadir') { ?>
                                            <?= $r['jam_masuk'] ?>
                                            -
                                            <?php if (!$r['jam_pulang']) { ?>
                                                Belum Pulang
                                            <?php } else { ?>
                                                <?= $r['jam_pulang'] ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($r['sts'] == 'Hadir') { ?>
                                            <?= $r['sts'] ?>
                                            <a href="<?= base_url() ?>/view/detail/detail-absensi?id=<?= $r[0] ?>" class="btn btn-info btn-xs text-white" title="Lokasi"><i class="fas fa-map-marked-alt me-1"></i>Detail</a>
                                        <?php } else { ?>
                                            <?= $r['sts'] ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>

<script>
    $(function() {
        $("#example-<?= $id ?>").DataTable();
    });
</script>