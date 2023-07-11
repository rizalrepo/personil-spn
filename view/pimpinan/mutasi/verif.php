<?php
require '../../../app/config.php';
include_once '../../layout/navhead.php';
include_once '../../layout/footer.php';

$verif = $_GET['v'];
$id = $_GET['id'];

if ($verif == 3) {
    $update = $con->query("UPDATE mutasi SET  
        verif = '$verif'
        WHERE id_mutasi = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data mutasi di Tolak";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
} else if ($verif == 2) {

    $mutasi = $con->query("SELECT * FROM mutasi WHERE id_mutasi = '$id' ")->fetch_array();

    $update = $con->query("UPDATE mutasi SET
        verif = '$verif'
        WHERE id_mutasi = '$id'
    ");

    if ($update) {
        $con->query("UPDATE personil SET id_jabatan = '$mutasi[id_jabatan]' WHERE id_personil = '$mutasi[id_personil]' ");
        $_SESSION['pesan'] = "Data mutasi di Setujui";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal Diverifikasi. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    }
}
