<?php
include '../../app/config.php';

$no = 1;

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

$personil = $_GET['personil'];
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

$cekpersonil = isset($personil);
$cekbulan = isset($bulan);
$cektahun = isset($tahun);

if ($personil == $cekpersonil && $bulan == $cekbulan && $tahun == $cektahun) {
    $sql = mysqli_query($con, "SELECT * FROM absensi a LEFT JOIN personil b ON a.id_personil = b.id_personil JOIN pangkat c ON b.id_pangkat = c.id_pangkat JOIN jabatan d ON b.id_jabatan = d.id_jabatan WHERE a.id_personil = '$personil' AND MONTH(a.tanggal) = '$bulan' AND YEAR(a.tanggal) = '$tahun' ORDER BY a.tanggal ASC");
    $dt = $con->query("SELECT * FROM personil WHERE id_personil = '$personil'")->fetch_array();
    $label = 'LAPORAN DATA ABSENSI PERSONIL <br> Nama Personil : ' . $dt['nm_personil'] . ' <br> Bulan : ' . $bln[date($bulan)] . ' ' . $tahun;
}

require_once '../../assets/libs/mpdf/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [380, 215]]);
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Absensi Personil</title>
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
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($data = mysqli_fetch_array($sql)) { ?>
                            <tr>
                                <td align="center" width="5%"><?= $no++; ?></td>
                                <td>
                                    <b>Nama</b> : <?= $data['nm_personil'] ?>
                                    <hr style="margin: 3px 0">
                                    <b>NRP / NIP</b> : <?= $data['nrp_nip'] ?>
                                </td>
                                <td align="center"><?= $data['nm_pangkat'] ?></td>
                                <td align="center"><?= $data['nm_jabatan'] ?></td>
                                <td align="center"><?= tgl($data['tanggal']) ?></td>
                                <td align="center">
                                    <?php if ($data['sts'] == 'Hadir') { ?>
                                        <?= $data['jam_masuk'] ?>
                                        -
                                        <?php if (!$data['jam_pulang']) { ?>
                                            belum pulang
                                        <?php } else { ?>
                                            <?= $data['jam_pulang'] ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                                <td align="center"><?= $data['sts'] ?></td>
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