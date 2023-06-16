<?php
require '../../../app/config.php';
include_once '../../layout/navhead.php';
include_once '../../layout/footer.php';

$id = $_GET['id'];
$data  = $con->query("SELECT * FROM izin WHERE id_izin = '$id'")->fetch_array();
$query = $con->query(" DELETE FROM izin WHERE id_izin = '$id' ");
if ($query) {
    $file = $data['file_izin'];
    if ($file != null) {
        unlink('../../../storage/izin/' . $file);
    }
    $_SESSION['pesan'] = "Data Berhasil di Hapus";
    echo "<meta http-equiv='refresh' content='0; url=index'>";
} else {
    echo "Data anda gagal dihapus. Ulangi sekali lagi";
    echo "<meta http-equiv='refresh' content='0; url=index'>";
}
