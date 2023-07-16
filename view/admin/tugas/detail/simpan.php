<?php

include '../../../../app/config.php';


$tugas    = $_POST['id_tugas'];
$personil   = $_POST['id_personil'];

$cek = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tugas_detail WHERE id_personil = '$personil' AND id_tugas = '$tugas' "));

if ($cek > 0) {
    $data['hasil'] = 'duplikat';
} else if ($personil == '') {
    $data['hasil'] = 'kosong';
} else {
    $tambah = $con->query("INSERT INTO tugas_detail VALUES (
            default,
            '$tugas', 
            '$personil'
        )");

    if ($tambah) {
        $data['hasil'] = 'sukses';
    } else {
        $data['hasil'] = 'gagal';
    }
}

echo json_encode($data);
