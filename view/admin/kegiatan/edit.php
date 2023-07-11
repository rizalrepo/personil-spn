<?php
require '../../../app/config.php';
$page = 'kegiatan';
include_once '../../layout/navhead.php';

$id = $_GET['id'];
$query = $con->query("SELECT * FROM kegiatan WHERE id_kegiatan ='$id'");
$row = $query->fetch_array();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="far fa-calendar-check me-2"></i>Edit Data kegiatan</h4>
                </div>
                <div>
                    <a href="index" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-body border border-dark-danger">
                <form class="form-horizontal needs-validation" novalidate method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Nama Kegiatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nm_kegiatan" value="<?= $row['nm_kegiatan'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Jenis Kegiatan</label>
                        <div class="col-sm-10">
                            <select name="id_jenis_kegiatan" class="form-control select2" style="width: 100%;" required>
                                <option value="">-- Pilih --</option>
                                <?php $data = $con->query("SELECT * FROM jenis_kegiatan ORDER BY id_jenis_kegiatan ASC"); ?>
                                <?php foreach ($data as $d) :
                                    if ($d['id_jenis_kegiatan'] == $row['id_jenis_kegiatan']) { ?>
                                        <option value="<?= $d['id_jenis_kegiatan']; ?>" selected="<?= $d['id_jenis_kegiatan']; ?>"><?= $d['nm_jenis_kegiatan'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $d['id_jenis_kegiatan'] ?>"><?= $d['nm_jenis_kegiatan'] ?></option>
                                <?php }
                                endforeach ?>
                            </select>
                            <div class="invalid-feedback">Kolom harus di pilih !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_mulai" value="<?= $row['tgl_mulai'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_selesai" value="<?= $row['tgl_selesai'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tempat Pelaksanaan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tempat" value="<?= $row['tempat'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea name="ket" class="form-control" required><?= $row['ket'] ?></textarea>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Penanggung Jawab</label>
                        <div class="col-sm-10">
                            <select name="id_personil" class="form-control select2" style="width: 100%;" required>
                                <option value="">-- Pilih --</option>
                                <?php $data = $con->query("SELECT * FROM personil ORDER BY id_personil ASC"); ?>
                                <?php foreach ($data as $d) :
                                    if ($d['id_personil'] == $row['id_personil']) { ?>
                                        <option value="<?= $d['id_personil']; ?>" selected="<?= $d['id_personil']; ?>"><?= $d['nm_personil'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $d['id_personil'] ?>"><?= $d['nm_personil'] ?></option>
                                <?php }
                                endforeach ?>
                            </select>
                            <div class="invalid-feedback">Kolom harus di pilih !</div>
                        </div>
                    </div>

                    <div class="form-group row mt-4 text-end">
                        <div class="col-sm-12">
                            <button type="reset" class="btn btn-sm btn-danger float-right mr-2"><i class="fa fa-times-circle"></i> Batal</button>
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- row  -->
</div>

<?php
include_once '../../layout/footer.php';

if (isset($_POST['submit'])) {
    $nm_kegiatan = $_POST['nm_kegiatan'];
    $id_jenis_kegiatan = $_POST['id_jenis_kegiatan'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $tempat = $_POST['tempat'];
    $ket = $_POST['ket'];
    $id_personil = $_POST['id_personil'];

    $update = $con->query("UPDATE kegiatan SET 
        nm_kegiatan = '$nm_kegiatan',
        id_jenis_kegiatan = '$id_jenis_kegiatan',
        tgl_mulai = '$tgl_mulai',
        tgl_selesai = '$tgl_selesai',
        tempat = '$tempat',
        ket = '$ket',
        id_personil = '$id_personil'
        WHERE id_kegiatan = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data Berhasil di Update";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal diubah. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=edit?id=$id'>";
    }
}
?>