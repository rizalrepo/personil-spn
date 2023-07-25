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

    $cek = $con->query("SELECT no_surat FROM tugas ORDER BY no_surat DESC LIMIT 1")->fetch_array();
    $ex = explode('/', $cek['no_surat']);

    if (date('d') == '01') {
        $a = '01';
    } else {
        $a = sprintf("%02d", floatval($ex[0]) + 1);
    }

    $b = 'ST';
    $c = array('', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
    $d = date('Y');
    $no_surat = $a . '/' . $b . '/' . $c[date('n')] . '/' . $d;

    $tgl_surat = date('Y-m-d');

    $tugas = $con->query("SELECT * FROM tugas WHERE id_tugas = '$id' ")->fetch_array();

    $update = $con->query("UPDATE tugas SET
        no_surat = '$no_surat',
        tgl_surat = '$tgl_surat',
        verif = '$verif'
        WHERE id_tugas = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data Perintah Tugas di Setujui";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
}
