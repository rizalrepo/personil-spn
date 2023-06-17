<?php
include_once '../../../app/config.php';

$id = $_GET['id'];
$data = $con->query("SELECT * FROM tugas WHERE id_tugas = '$id'");
$row = $data->fetch_array();

$a = $con->query("SELECT COUNT(*) as total FROM tugas_detail WHERE id_tugas = '$id'")->fetch_array();

if ($a['total'] == 1) {
    $nama = 'nama';
} else {
    $nama = 'nama-nama';
}

require_once '../../../assets/libs/mpdf/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
ob_start();
?>

<html>

<head>
    <title>Surat Perintah Tugas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">

</head>

<body bgcolor="#FFFFFF">
    <div class="table-responsive">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td align="center">
                    <img src="<?= base_url('assets/images/logo.png') ?>" align="left" height="75">
                </td>
                <td align="center">
                    <h4>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h4>
                    <h2>DAERAH KALIMANTAN SELATAN <br> SEKOLAH POLISI NEGARA</h2>
                    <h6>Jl. Ir. P. M. Noor, Guntung Paikat, Kec. Banjarbaru Selatan, Kota Banjar Baru, <br> Kalimantan Selatan Kodepos 70714</h6>
                </td>
                <td align="center">
                    <img src="<?= base_url('assets/images/pelengkap.png') ?>" align="right" height="75">
                </td>
            </tr>
        </table>
    </div>
    <hr size="2px" color="black">
    <table width="670" border="0" cellspacing="2" cellpadding="2" align="center">
        <tr>
            <td align="center">
                <h4><b>SURAT PERINTAH TUGAS</b><br>
                </h4>
            </td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <td style="text-align: right;">Banjarbaru, <?= tgl($row['tgl_surat']); ?></td>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <div align="left">
                <td>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
                        <tr>
                            <td width="10%">Nomor</td>
                            <td>: <?= $row['no_surat'] ?></td>
                        </tr>
                        <tr>
                            <td width="10%">Hal</td>
                            <td>: tugas</td>
                        </tr>
                    </table>
                </td>
            </div>
        </tr>
        <tr>
            <td>&nbsp;<br>
            </td>
        </tr>
        <tr>
            <td> Dengan ini KA SPN POLDA KALIMANTAN SELATAN menugaskan <?= $nama ?> dibawah ini :<br>

            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <?php
                    $qry = $con->query("SELECT * FROM tugas_detail td JOIN personil p ON p.id_personil = td.id_personil JOIN pangkat c ON p.id_pangkat = c.id_pangkat JOIN jabatan d ON p.id_jabatan = d.id_jabatan WHERE td.id_tugas = '$id' ORDER BY td.id_tugas_detail ASC");
                    while ($data2 = $qry->fetch_array()) {
                    ?>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="15%">N a m a</td>
                            <td>: <?= $data2['nm_personil'] ?> </td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="15%">NRP / NIP</td>
                            <td>: <?= $data2['nrp_nip'] ?> </td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="15%">Pangkat</td>
                            <td>: <?= $data2['nm_pangkat'] ?> </td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="15%">Jabatan</td>
                            <td>: <?= $data2['nm_jabatan'] ?> </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td align="justify">Untuk melaksanan Perintah Tugas pada :</td><br><br>
        </tr>
        <table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="20%">Tanggal</td>
                <td width="5%">:</td>
                <td width="75%">
                    <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) {
                        echo tgl($row['tgl_mulai']);
                    } else {
                        echo tgl($row['tgl_mulai']) . ' s/d ' . tgl($row['tgl_selesai']);
                    } ?>
                </td>
            <tr>
            <tr>
                <td width="20%">Tempat</td>
                <td width="5%">:</td>
                <td width="75%"><?= $row['tempat'] ?></td>
            </tr>
            <tr>
                <td width="20%">Agenda Kegiatan</td>
                <td width="5%">:</td>
                <td width="75%"><?= $row['agenda'] ?></td>
            </tr>
        </table>

        <tr>
            <td>&nbsp;<br>
        </tr>

        <tr>
            <td align="justify">Demikian Surat Perintah Tugas ini dibuat untuk dapat dilaksanakan dengan sebaik-baiknya.</td>
        </tr>

        <tr>
            <td>&nbsp;<br><br><br><br></td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="45%"></td>
                        <td width="10%"></td>
                        <td align="center">Disetujui oleh, <br> KA SPN POLDA KALIMANTAN SELATAN</td>
                    </tr>
                    <tr>
                        <td width="45%"><br>
                            <p class="signature"></p>
                        </td>

                        <td width="20%"><br><br><br><br><br>
                    </tr>
                    <tr>
                        <td width="45%"></td>
                        <td width="10%"></td>
                        <td width="20%"></td>
                    </tr>
                    <tr>
                        <td width="45%" align="left">

                        </td>
                        <td width="10%"></td>
                        <td align="center">
                            <p style="text-align: center;">RESTIKA P. NAINGGOLAN, S.I.K</p>
                            <hr style="margin: 0 3px;" width="100%" color="#000000">
                        </td>
                    </tr>
                    <tr>
                        <td width="45%"></td>
                        <td width="10%"></td>
                        <td align="center">KOMISARIS BESAR POLISI NRP 76030830</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>

        </tr>
    </table>

</body>

</html>

<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output();
?>