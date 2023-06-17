<?php
require '../../../app/config.php';
include_once '../../layout/navhead.php';
include_once '../../layout/footer.php';

$verif = $_GET['v'];
$id = $_GET['id'];

if ($verif == 3) {
    $update = $con->query("UPDATE izin SET  
        verif = '$verif'
        WHERE id_izin = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data Izin di Tolak";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
} else if ($verif == 2) {

    $izin = $con->query("SELECT * FROM izin WHERE id_izin = '$id' ")->fetch_array();

    $cek_tgl = mysqli_num_rows(mysqli_query($con, "SELECT * FROM absensi WHERE tanggal BETWEEN '$izin[tgl_mulai]' AND '$izin[tgl_selesai]' AND id_personil = '$izin[id_personil]'"));
    if ($cek_tgl > 0) {
        $_SESSION['error'] = "Tanggal yang dipilih Sudah Terisi Absensi/Cuti/Izin !";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        $update = $con->query("UPDATE izin SET
            verif = '$verif'
            WHERE id_izin = '$id'
        ");

        $start = strtotime($izin['tgl_mulai']);
        $end = strtotime($izin['tgl_selesai']);
        $absen = $izin['id_personil'];

        // Loop between timestamps, 24 hours at a time
        for ($i = $start; $i <= $end; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);
            $con->query("INSERT INTO absensi VALUES (
                default,
                '$absen', 
                '$id',
                default,
                '$thisDate',
                '-',
                default,
                default,
                default,
                '-',
                default,
                default,
                default,
                'Izin'
            )");
        }

        if ($update) {
            $_SESSION['pesan'] = "Data Izin di Setujui";
            echo "<meta http-equiv='refresh' content='0; url=index'>";
        } else {
            echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
            echo "<meta http-equiv='refresh' content='0; url=index'>";
        }
    }
}
