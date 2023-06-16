<?php
require '../../../app/config.php';
$page = 'izin';
include_once '../../layout/navhead.php';

$jns = [
    '' => '-- Pilih --',
    'Izin' => 'Izin',
    'Sakit' => 'Sakit',
];

$log = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")->fetch_array();
$absen = $log['id_personil'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="bi bi-calendar-week-fill me-2"></i>Pengajuan Data Cuti</h4>
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
                            <?= form_dropdown('sts_izin', $jns, '', 'class="form-select" required') ?>
                            <div class="invalid-feedback">Kolom harus di pilih !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ket_izin" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">File Izin</label>
                        <div class="col-sm-10">
                            <input type="file" accept=".pdf,.PDF" class="form-control" name="file_izin" required>
                            <label style='color: red; font-style: italic; font-size: 12px;'>* File harus PDF dan Ukuran file maksimal 2MB</label>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_mulai" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_selesai" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mt-4 text-end">
                        <div class="col-sm-12">
                            <button type="reset" class="btn btn-sm btn-danger float-right mr-2"><i class="fa fa-times-circle"></i> Batal</button>
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
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

    $cek_tgl = mysqli_num_rows(mysqli_query($con, "SELECT * FROM absensi WHERE tanggal BETWEEN '$_POST[tgl_mulai]' AND '$_POST[tgl_selesai]' AND id_personil = '$absen'"));
    if ($cek_tgl > 0) {
        echo "
        <script type='text/javascript'>
            Swal.fire({
                title: 'Pengajuan Izin Gagal !',
                text:  'Tanggal yang dipilih Sudah Terisi Absensi/Cuti/Izin !',
                icon: 'error'
            });     
        </script>";
    } else {
        $sts_izin = $_POST['sts_izin'];
        $ket_izin = $_POST['ket_izin'];

        $f_file_izin = "";

        if (!empty($_FILES['file_izin']['name'])) {

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
                            window.location.replace('tambah');
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
                        window.location.replace('tambah');
                    } ,2000);  
                </script>";
            }
        } else {
            $file_izin = $_POST['file_izin'];
            $f_file_izin .= "Upload Success!";
        }

        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        if (!empty($f_file_izin)) {
            $tambah = $con->query("INSERT INTO izin VALUES (
                default, 
                '$absen',
                '$sts_izin',
                '$ket_izin',
                '$file_izin',
                '$tgl_mulai',
                '$tgl_selesai',
                1,
                default
            )");

            if ($tambah) {
                $_SESSION['pesan'] = "Data Berhasil di Simpan";
                echo "<meta http-equiv='refresh' content='0; url=index'>";
            } else {
                echo "Data anda gagal disimpan. Ulangi sekali lagi";
                echo "<meta http-equiv='refresh' content='0; url=tambah'>";
            }
        }
    }
}

?>