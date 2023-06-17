<?php
include '../../../../app/config.php';

$id = $_POST['id'];

$query = $con->query("DELETE FROM tugas_detail WHERE id_tugas_detail = '$id' ");
if ($query) {
    echo "Data Berhasil Dihapus";
} else {
    echo "Data Gagal Dihapus";
}
