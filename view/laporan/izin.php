<?php
include '../../app/config.php';

$no = 1;

$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$izin = $_GET['izin'];

$cekbulan = isset($bulan);
$cektahun = isset($tahun);
$cekizin = isset($izin);

$bln = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
);

if ($bulan == $cekbulan && $tahun == $cektahun && $izin == null) {
    $sql = mysqli_query($con, "SELECT * FROM izin a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON b.id_jabatan = d.id_jabatan WHERE MONTH(tgl_mulai) = '$bulan' AND YEAR(tgl_mulai) = '$tahun' ORDER BY tgl_mulai ASC");

    $label = 'LAPORAN DATA IZIN PERSONIL <br> Bulan : ' . $bln[date($bulan)] . ' ' . $tahun;
} else if ($bulan == null && $tahun == null && $izin == $cekizin) {
    $sql = mysqli_query($con, "SELECT * FROM izin a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON b.id_jabatan = d.id_jabatan WHERE sts_izin = '$izin' ORDER BY tgl_mulai DESC");

    $label = 'LAPORAN DATA IZIN PERSONIL <br> Jenis Izin : ' . $izin;
} else if ($bulan == $cekbulan && $tahun == $cektahun && $izin == $cekizin) {
    $sql = mysqli_query($con, "SELECT * FROM izin a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON b.id_jabatan = d.id_jabatan WHERE MONTH(tgl_mulai) = '$bulan' AND YEAR(tgl_mulai) = '$tahun' AND sts_izin = '$izin' ORDER BY tgl_mulai ASC");

    $label = 'LAPORAN DATA IZIN PERSONIL <br> Bulan : ' . $bln[date($bulan)] . ' ' . $tahun . '<br> Jenis Izin : ' . $izin;
} else {
    $sql = mysqli_query($con, "SELECT * FROM izin a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON b.id_jabatan = d.id_jabatan ORDER BY tgl_mulai DESC");
    $label = 'LAPORAN DATA IZIN PERSONIL';
}

require_once '../../assets/libs/mpdf/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [380, 215]]);
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Izin Personil</title>
</head>

<style>
    th {
        color: white;
    }
</style>

<body>
    <div class="table-responsive">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td align="center">
                    <img src="<?= base_url('assets/images/logo.png') ?>" align="left" height="100">
                </td>
                <td align="center">
                    <h4>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h4>
                    <h2>DAERAH KALIMANTAN SELATAN SEKOLAH POLISI NEGARA</h2>
                    <h6>Jl. Ir. P. M. Noor, Guntung Paikat, Kec. Banjarbaru Selatan, Kota Banjar Baru, Kalimantan Selatan Kodepos 70714</h6>
                </td>
                <td align="center">
                    <img src="<?= base_url('assets/images/pelengkap.png') ?>" align="right" height="100">
                </td>
            </tr>
        </table>
    </div>
    <hr size="2px" color="black">

    <h4 align="center">
        <?= $label ?><br>
    </h4>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <table border="1" cellspacing="0" cellpadding="6" width="100%">
                    <thead>
                        <tr bgcolor="#AE302E" align="center">
                            <th>No</th>
                            <th>Data Personil</th>
                            <th>Pangkat</th>
                            <th>Jabatan</th>
                            <th>Jenis Izin</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Lama Izin</th>
                            <th>Verifikasi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($data = mysqli_fetch_array($sql)) {
                            $tgl1 = $data['tgl_mulai'];
                            $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1)));
                            $a = date_create($tgl2);
                            $b = date_create($data['tgl_selesai']);
                            $diff = date_diff($a, $b);
                        ?>
                            <tr>
                                <td align="center" width="5%"><?= $no++; ?></td>
                                <td>
                                    <b>Nama</b> : <?= $data['nm_personil'] ?>
                                    <hr style="margin: 3px 0">
                                    <b>NRP / NIP</b> : <?= $data['nrp_nip'] ?>
                                </td>
                                <td align="center"><?= $data['nm_pangkat'] ?></td>
                                <td align="center"><?= $data['nm_jabatan'] ?></td>
                                <td align="center"><?= $data['sts_izin'] ?></td>
                                <td><?= $data['ket_izin'] ?></td>
                                <td align="center">
                                    <?php if ($data['tgl_mulai'] == $data['tgl_selesai']) {
                                        echo tgl($data['tgl_mulai']);
                                    } else {
                                        echo tgl($data['tgl_mulai']) . ' s/d ' . tgl($data['tgl_selesai']);
                                    } ?>
                                    <hr style="margin: 3px 0;">
                                    Lama Izin :
                                    <?php if ($diff->y != 0) {
                                        echo $diff->y  . ' Tahun ';
                                    }
                                    if ($diff->m != 0) {
                                        echo $diff->m . ' Bulan ';
                                    } ?>
                                    <?= $diff->d ?> Hari
                                </td>
                                <td align="center"><?= $diff->d . ' Hari' ?></td>
                                <td align="center">
                                    <?php if ($data['verif'] == 3) { ?>
                                        Izin Ditolak
                                        <hr style="margin: 3px 0">
                                        Karena <?= $data['tolak'] ?>
                                    <?php } else if ($data['verif'] == 2) { ?>
                                        Izin Disetujui
                                    <?php } else { ?>
                                        Belum Diverifikasi
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <br>
    <br>

    <br>
    <div class="table-responsive">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td align="center" width="80%">
                </td>
                <td align="center">
                    <h6>
                        Banjarbaru, <?= tgl(date('Y-m-d')) ?><br>
                        KA SPN POLDA KALIMANTAN SELATAN
                        <br><br><br><br><br><br><br>
                        RESTIKA P. NAINGGOLAN, S.I.K
                        <hr style="margin-top: 0; margin-bottom: 0;">
                        KOMISARIS BESAR POLISI NRP 76030830
                    </h6>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output();
?>