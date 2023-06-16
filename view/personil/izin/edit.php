<?php
require '../../../app/config.php';
$page = 'izin';
include_once '../../layout/navhead.php';

$id = $_GET['id'];
$query = $con->query("SELECT * FROM izin WHERE id_izin ='$id'");
$row = $query->fetch_array();

$jns = [
    '' => '-- Pilih --',
    'Izin' => 'Izin',
    'Sakit' => 'Sakit',
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="bi bi-calendar-week-fill me-2"></i>Edit Pengajuan Izin</h4>
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
                        <label class="col-sm-2 col-form-label">Jenis Izin</label>
                        <div class="col-sm-10">
                            <?= form_dropdown('sts_izin', $jns, $row['sts_izin'], 'class="form-select" required') ?>
                            <div class="invalid-feedback">Kolom harus di pilih !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ket_izin" value="<?= $row['ket_izin'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">File Izin</label>
                        <div class="col-sm-10">
                            <input type="file" accept=".pdf,.PDF" class="form-control" name="file_izin">
                            <label style='color: red; font-style: italic; font-size: 12px;'>* Biarkan Kosong jika File tidak di ubah</label>
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
    $sts_izin = $_POST['sts_izin'];
    $ket_izin = $_POST['ket_izin'];

    $f_file_izin = "";

    if (!empty($_FILES['file_izin']['name'])) {
        $filelama = $row['file_izin'];

        // UPLOAD FILE 
        $file      = $_FILES['file_izin']['name'];
        $x_file    = explode('.', $file);
        $ext_file  = end($x_file);
        $file_izin = rand(1, 99999) . '.' . $ext_file;
        $size_file = $_FILES['file_izin']['size'];
        $tmp_file  = $_FILES['file_izin']['tmp_name'];
        $dir_file  = '../../../storage/izin/';
        $allow_ext        = array('pdf', 'PDF');
        $allow_size       = 2097152;
        // var_dump($file_izin); die();

        if (in_array($ext_file, $allow_ext) === true) {
            if ($size_file <= $allow_size) {
                move_uploaded_file($tmp_file, $dir_file . $file_izin);
                if (file_exists($dir_file . $filelama)) {
                    unlink($dir_file . $filelama);
                }
                $f_file_izin .= "Upload Success";
            } else {
                echo "
                <script type='text/javascript'>
                    setTimeout(function () {    
                        Swal.fire({
                            title: '',
                            text:  'Ukuran Foto Terlalu Besar, Maksimal 2 Mb',
                            icon: 'error',
                            timer: 3000,
                            showConfirmButton: true
                        });     
                    },10);   
                    window.setTimeout(function(){ 
                        window.location.replace('edit?id=$id');
                    } ,2000); 
                </script>";
            }
        } else {
            echo "
            <script type='text/javascript'>
                setTimeout(function () {    
                    Swal.fire({
                        title: 'Format File Tidak Didukung',
                        text:  'File Harus Berupa PDF',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: true
                    });     
                },10);  
                window.setTimeout(function(){ 
                    window.location.replace('edit?id=$id');
                } ,2000);  
            </script>";
        }
    } else {
        $file_izin = $row['file_izin'];
        $f_file_izin .= "Upload Success!";
    }

    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];

    if (!empty($f_file_izin)) {
        $update = $con->query("UPDATE izin SET 
            sts_izin = '$sts_izin', 
            ket_izin = '$ket_izin',
            file_izin = '$file_izin',
            tgl_mulai = '$tgl_mulai',
            tgl_selesai = '$tgl_selesai'
            WHERE id_izin = '$id'
        ");

        if ($update) {
            $_SESSION['pesan'] = "Data Berhasil di Update";
            echo "<meta http-equiv='refresh' content='0; url=index'>";
        } else {
            echo "Data anda gagal diubah. Ulangi sekali lagi";
            echo "<meta http-equiv='refresh' content='0; url=edit?id=$id'>";
        }
    }
}


?>