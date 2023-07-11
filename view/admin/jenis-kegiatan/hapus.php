<?php
require '../../../app/config.php';
include_once '../../layout/navhead.php';
include_once '../../layout/footer.php';

$id = $_GET['id'];

$query = $con->query(" DELETE FROM jenis_kegiatan WHERE id_jenis_kegiatan = '$id' ");
if ($query) {
    $_SESSION['pesan'] = "Data Berhasil di Hapus";
    echo "<meta http-equiv='refresh' content='0; url=index'>";
} else {
    echo "Data anda gagal dihapus. Ulangi sekali lagi";
    echo "<meta http-equiv='refresh' content='0; url=index'>";
}
