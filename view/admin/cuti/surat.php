<?php
include_once '../../../app/config.php';

$id = $_GET['id'];
$data = $con->query("SELECT * FROM cuti a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON b.id_jabatan = d.id_jabatan WHERE id_cuti = '$id'");
$row = $data->fetch_array();
$tgl1 = $row['tgl_mulai'];
$tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1)));
$a = date_create($tgl2);
$b = date_create($row['tgl_selesai']);
$diff = date_diff($a, $b);

require_once '../../../assets/libs/mpdf/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
ob_start();
?>

<html>

<head>
    <title>Surat Cuti Personil</title>
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
                <h4><b>SURAT CUTI PERSONIL</b><br>
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
                            <td width="13%">Nomor</td>
                            <td width="70%">: <?= $row['no_surat'] ?></td>
                        </tr>
                        <tr>
                            <td width="13%">Hal</td>
                            <td width="70%">: Cuti</td>
                        </tr>
                    </table>
                </td>
            </div>
        </tr>
        <tr>
            <td>&nbsp;<br></td>
        </tr>
        <tr>
            <div align="left">
                <td>
                    Kepada Yth,

                    <br>
                    KA SPN POLDA KALIMANTAN SELATAN

                    <br>
                    Di Tempat
                    <br>

                </td>
            </div>
        </tr>
        <tr>
            <td>&nbsp;<br>
            </td>
        </tr>
        <tr>
            <td>Yang bertanda tangan dibawah ini :<br>

            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="29%">N a m a</td>
                        <td width="70%">: <?= $row['nm_personil'] ?> </td>
                    </tr>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="29%">NRP / NIP</td>
                        <td width="70%">: <?= $row['nrp_nip'] ?> </td>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="29%">Pangkat</td>
                        <td width="70%">: <?= $row['nm_pangkat'] ?> </td>
                    </tr>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="29%">Jabatan</td>
                        <td width="70%">: <?= $row['nm_jabatan'] ?> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">Bermaksud untuk mengajukan Cuti dengan keterangan <b><?= $row['ket'] ?></b> selama <?= $diff->d; ?> Hari,
                <?php if ($row['tgl_mulai'] == $row['tgl_selesai']) { ?>
                    pada tanggal <?= tgl($row['tgl_mulai']) ?> <br>
                <?php } else { ?>
                    terhitung mulai tanggal <?= tgl($row['tgl_mulai']) ?> sampai dengan tanggal <?= tgl($row['tgl_selesai']) ?><br>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">Demikian surat pengajuan cuti ini, untuk digunakan sebagaimana mestinya, atas perhatian dan kebijaksanaannya saya ucapkan terima kasih</td>
        </tr>
        <tr>
            <td>&nbsp;<br><br><br></td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="45%" align="center">Pemohon,</td>
                        <td width="10%"></td>
                        <td width="45%" align="center">Disetujui oleh, <br> KA SPN POLDA KALIMANTAN SELATAN</td>
                    </tr>
                    <tr>
                        <td width="45%"><br>
                            <p class="signature"></p>
                        </td>

                        <td width="45%"><br><br><br><br><br><br></td>
                    </tr>
                    <tr>
                        <td width="45%"></td>
                        <td width="10%"></td>
                        <td width="45%"></td>
                    </tr>
                    <tr>
                        <td width="45%" align="center">
                            <p style="text-align: center;"><?= $row['nm_personil'] ?></p>
                            <hr style="margin: 0 3px;" width="100%" color="#000000">
                        </td>
                        <td width="10%"></td>
                        <td width="45%" align="center">
                            <p style="text-align: center;">RESTIKA P. NAINGGOLAN, S.I.K</p>
                            <hr style="margin: 0 3px;" width="100%" color="#000000">
                        </td>
                    </tr>
                    <tr>
                        <td width="45%" align="center">NRP/NIP : <?= $row['nrp_nip'] ?></td>
                        <td width="10%"></td>
                        <td width="45%" align="center">KOMISARIS BESAR POLISI NRP 76030830</td>

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