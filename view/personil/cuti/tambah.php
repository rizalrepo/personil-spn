<?php
require '../../../app/config.php';
$page = 'cuti';
include_once '../../layout/navhead.php';

$log = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")->fetch_array();
$absen = $log['id_personil'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="bi bi-calendar-range-fill me-2"></i>Pengajuan Data Cuti</h4>
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
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ket" required>
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
    $ket = $_POST['ket'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];

    $thn = date('Y');

    $cek = mysqli_query($con, "SELECT COUNT(*) AS total FROM absensi WHERE id_personil = '$absen' AND YEAR(tanggal) = '$thn' AND sts = 'Cuti'")->fetch_array();

    $sisa = 12 - $cek['total'];

    $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl_mulai)));
    $a = date_create($tgl2);
    $b = date_create($tgl_selesai);
    $diff = date_diff($a, $b);

    $cek_tgl = mysqli_num_rows(mysqli_query($con, "SELECT * FROM absensi WHERE tanggal BETWEEN '$_POST[tgl_mulai]' AND '$_POST[tgl_selesai]' AND id_personil = '$absen'"));
    if ($cek_tgl > 0) {
        echo "
        <script type='text/javascript'>
            Swal.fire({
                title: 'Pengajuan Cuti Gagal !',
                text:  'Tanggal yang dipilih Sudah Terisi Absensi/Cuti/Izin !',
                icon: 'error'
            });     
        </script>";
    } else if ($sisa < $diff->d) {
        echo "
        <script type='text/javascript'>
            Swal.fire({
                title: 'Pengajuan Cuti Gagal !',
                text:  'Pengajuan Cuti Anda tersisa $sisa Hari dalam tahun ini !',
                icon: 'error'
            });     
        </script>";
    } else {
        $tambah = $con->query("INSERT INTO cuti VALUES (
            default, 
            default, 
            default, 
            '$absen',
            '$ket',
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

?>