<?php
include '../../app/config.php';

$no = 1;

$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$jenis = $_GET['jenis'];

$cekbulan = isset($bulan);
$cektahun = isset($tahun);
$cekjenis = isset($jenis);

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

if ($bulan == $cekbulan && $tahun == $cektahun && $jenis == null) {
    $sql = mysqli_query($con, "SELECT * FROM kegiatan a JOIN jenis_kegiatan b ON a.id_jenis_kegiatan = b.id_jenis_kegiatan LEFT JOIN personil c ON a.id_personil = c.id_personil WHERE MONTH(tgl_mulai) = '$bulan' AND YEAR(tgl_mulai) = '$tahun' ORDER BY tgl_mulai ASC");

    $label = 'LAPORAN DATA KEGIATAN <br> Bulan : ' . $bln[date($bulan)] . ' ' . $tahun;
} else if ($bulan == null && $tahun == null && $jenis == $cekjenis) {
    $sql = mysqli_query($con, "SELECT * FROM kegiatan a JOIN jenis_kegiatan b ON a.id_jenis_kegiatan = b.id_jenis_kegiatan LEFT JOIN personil c ON a.id_personil = c.id_personil WHERE a.id_jenis_kegiatan = '$jenis' ORDER BY tgl_mulai DESC");

    $dt = $con->query("SELECT * FROM jenis_kegiatan WHERE id_jenis_kegiatan = '$jenis'")->fetch_array();

    $label = 'LAPORAN DATA KEGIATAN <br> Jenis Kegiatan : ' . $dt['nm_jenis_kegiatan'];
} else if ($bulan == $cekbulan && $tahun == $cektahun && $jenis == $cekjenis) {
    $sql = mysqli_query($con, "SELECT * FROM kegiatan a JOIN jenis_kegiatan b ON a.id_jenis_kegiatan = b.id_jenis_kegiatan LEFT JOIN personil c ON a.id_personil = c.id_personil WHERE MONTH(tgl_mulai) = '$bulan' AND YEAR(tgl_mulai) = '$tahun' AND a.id_jenis_kegiatan = '$jenis' ORDER BY tgl_mulai ASC");

    $dt = $con->query("SELECT * FROM jenis_kegiatan WHERE id_jenis_kegiatan = '$jenis'")->fetch_array();

    $label = 'LAPORAN DATA KEGIATAN <br> Bulan : ' . $bln[date($bulan)] . ' ' . $tahun . '<br> Jenis Kegiatan : ' . $dt['nm_jenis_kegiatan'];
} else {
    $sql = mysqli_query($con, "SELECT * FROM kegiatan a JOIN jenis_kegiatan b ON a.id_jenis_kegiatan = b.id_jenis_kegiatan LEFT JOIN personil c ON a.id_personil = c.id_personil ORDER BY tgl_mulai DESC");
    $label = 'LAPORAN DATA KEGIATAN';
}

require_once '../../assets/libs/mpdf/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [380, 215]]);
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kegiatan</title>
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
                            <th>Nama Kegiatan</th>
                            <th>Jenis Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Lama Kegiatan</th>
                            <th>Tempat</th>
                            <th>Keterangan</th>
                            <th>PIC</th>
                            <th>Status</th>
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
                                <td><?= $data['nm_kegiatan'] ?></td>
                                <td align="center"><?= $data['nm_jenis_kegiatan'] ?></td>
                                <td align="center">
                                    <?php if ($data['tgl_mulai'] == $data['tgl_selesai']) { ?>
                                        <?= tgl($data['tgl_mulai']) ?>
                                    <?php } else { ?>
                                        <?= tgl($data['tgl_mulai']) . ' s/d ' . tgl($data['tgl_selesai']) ?>
                                    <?php } ?>
                                </td>
                                <td align="center"><?= $diff->d . ' Hari' ?></td>
                                <td align="center"><?= $data['tempat'] ?></td>
                                <td><?= $data['ket'] ?></td>
                                <td><?= $data['nm_personil'] ?></td>
                                <td align="center">
                                    <?php if ($data['tgl_mulai'] <= date('Y-m-d') && $data['tgl_selesai'] >= date('Y-m-d')) { ?>
                                        Sedang Berjalan
                                    <?php } else if ($data['tgl_mulai'] > date('Y-m-d')) { ?>
                                        Belum Berjalan
                                    <?php } else if ($data['tgl_selesai'] < date('Y-m-d')) { ?>
                                        Kegiatan Selesai
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