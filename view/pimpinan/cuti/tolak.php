<?php
require '../../../app/configtables.php';
$con = mysqli_connect($con['host'], $con['user'], $con['pass'], $con['db']);
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}
?>

<div id="tolak<?= $id = $row['id_cuti']; ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="custom-width-modalLabel"><i class="fas fa-times-circle me-2"></i>Tolak Cuti Personil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php $d = $con->query("SELECT * FROM cuti WHERE id_cuti = '$id' ")->fetch_array(); ?>
            <div class="modal-body text-start">
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal needs-validation" novalidate method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label class="col-form-label">Ditolak Karena</label>
                                <input type="text" class="form-control" name="tolak" value="<?= $d['tolak'] ?>" required>
                                <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                            </div>
                            <div class="text-end">
                                <button type="reset" class="btn btn-sm btn-danger me-1"><i class="fas fa-times-circle me-1"></i>Reset</button>
                                <button type="submit" name="submit_tolak" class="btn btn-sm bg-primary text-white"><i class="fas fa-save me-1"></i> Tolak Cuti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->