<?php
require '../../../app/config.php';
$page = 'user';
include_once '../../layout/navhead.php';

$id = $_GET['id'];
$query = $con->query(" SELECT * FROM user WHERE id_user ='$id'");
$row = $query->fetch_array();

$level = [
    '' => '-- Pilih --',
    '1' => 'Admin',
    '2' => 'Pimpinan',
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="fas fa-user me-2"></i>Edit Data Pengguna</h4>
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
                        <label class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nm_user" value="<?= $row['nm_user'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <div class="input-group has-validation">
                                <input type="password" id="pw" class="form-control text-black" name="password">
                                <div class="input-group-text" id="lihat-pw"><span class="fas fa-eye-slash" title="Lihat Password" onclick="change();"></span></div>
                            </div>
                            <small class="text-danger fst-italic">*Kosongkan Password Jika Tidak Diubah</small>
                        </div>
                    </div>
                    <?php if ($row['level'] == 1 || $row['level'] == 2) { ?>
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Level Pengguna</label>
                            <div class="col-sm-10">
                                <?= form_dropdown('level', $level, $row['level'], 'class="form-select" required') ?>
                                <div class="invalid-feedback">Kolom harus di pilih !</div>
                            </div>
                        </div>
                    <?php } ?>
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
    $nama = $_POST['nm_user'];
    $user = $_POST['username'];
    if (!empty($_POST['password'])) {
        $pw = md5($_POST['password']);
    } else {
        $pw = $row['password'];
    }

    if (!empty($_POST['level'])) {
        $level = $_POST['level'];
    } else {
        $level = $row['level'];
    }

    $update = $con->query("UPDATE user SET 
        nm_user = '$nama', 
        username = '$user', 
        password = '$pw', 
        level = '$level' 
        WHERE id_user = '$id'
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