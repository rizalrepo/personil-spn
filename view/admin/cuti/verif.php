<?php
require '../../../app/config.php';
include_once '../../layout/navhead.php';
include_once '../../layout/footer.php';

$verif = $_GET['v'];
$id = $_GET['id'];

if ($verif == 3) {
    $update = $con->query("UPDATE cuti SET  
        verif = '$verif'
        WHERE id_cuti = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data Cuti di Tolak";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
} else if ($verif == 2) {

    $cek = $con->query("SELECT max(no_surat) as kode FROM cuti")->fetch_array();

    $no = $cek['kode'];
    $noUrut = (int) substr($no, 1, 2);
    $noUrut++;

    $a =  sprintf("%02s", $noUrut);
    $b = 'CUTI';
    $c = array('', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
    $d = date('Y');
    $no_surat = $a . '/' . $b . '/' . $c[date('n')] . '/' . $d;

    $tgl_surat = date('Y-m-d');

    $cuti = $con->query("SELECT * FROM cuti WHERE id_cuti = '$id' ")->fetch_array();

    $cek_tgl = mysqli_num_rows(mysqli_query($con, "SELECT * FROM absensi WHERE tanggal BETWEEN '$cuti[tgl_mulai]' AND '$cuti[tgl_selesai]' AND id_personil = '$cuti[id_personil]'"));
    if ($cek_tgl > 0) {
        $_SESSION['error'] = "Tanggal yang dipilih Sudah Terisi Absensi/Cuti/Izin !";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        $update = $con->query("UPDATE cuti SET
            no_surat = '$no_surat',
            tgl_surat = '$tgl_surat',
            verif = '$verif'
            WHERE id_cuti = '$id'
        ");

        $start = strtotime($cuti['tgl_mulai']);
        $end = strtotime($cuti['tgl_selesai']);
        $absen = $cuti['id_personil'];

        // Loop between timestamps, 24 hours at a time
        for ($i = $start; $i <= $end; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $con->query("INSERT INTO absensi VALUES (
                default,
                '$absen', 
                default,
                '$id',
                '$thisDate',
                '-',
                default,
                default,
                default,
                '-',
                default,
                default,
                default,
                'Cuti'
            )");
        }

        if ($update) {
            $_SESSION['pesan'] = "Data Cuti di Setujui";
            echo "<meta http-equiv='refresh' content='0; url=index'>";
        } else {
            echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
            echo "<meta http-equiv='refresh' content='0; url=index'>";
        }
    }
}
