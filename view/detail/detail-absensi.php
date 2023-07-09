<?php
require '../../app/config.php';
$page = 'absensi';
include_once '../layout/navhead.php';

$id = $_GET['id'];

$query = $con->query("SELECT * FROM absensi a JOIN personil b ON a.id_personil = b.id_personil JOIN pangkat c ON b.id_pangkat = c.id_pangkat JOIN jabatan d ON b.id_jabatan = d.id_jabatan WHERE a.id_absensi = '$id' ");
$dt = $query->fetch_array();
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<style>
    #lokasi_masuk,
    #lokasi_pulang {
        height: 300px;
        width: 100%;
    }
</style>

<!-- Container fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Detail Absensi</h4>
                </div>
                <div>
                    <?php
                    if ($_SESSION['level'] == 1) {
                        $url = '../admin/absensi/index';
                    } else if ($_SESSION['level'] == 2) {
                        $url = '../pimpinan/absensi/index';
                    } else if ($_SESSION['level'] == 3) {
                        $url = '../personil/absensi/index';
                    }
                    ?>
                    <a href="<?= $url ?>" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body border border-dark-danger">
        <div class="row text-start text-black">
            <div class="col-12">
                <dl class="row">
                    <dt class="col-sm-2">Nama Lengkap</dt>
                    <dd class="col-sm-10">: <?= $dt['nm_personil'] ?></dd>
                    <dt class="col-sm-2">NRP / NIP</dt>
                    <dd class="col-sm-10">: <?= $dt['nrp_nip'] ?></dd>
                    <dt class="col-sm-2">Pangkat</dt>
                    <dd class="col-sm-10">: <?= $dt['nm_pangkat'] ?></dd>
                    <dt class="col-sm-2">Jabatan</dt>
                    <dd class="col-sm-10">: <?= $dt['nm_jabatan'] ?></dd>
                    <dt class="col-sm-2">Tanggal Absensi</dt>
                    <dd class="col-sm-10">: <?= tgl_indo($dt['tanggal']) ?></dd>
                </dl>
            </div>
            <div class="col-6">
                <!-- Accordion Example -->
                <div class="accordion" id="accordionExample1">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingMasuk">
                            <button class="accordion-button fw-bold text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMasuk" aria-expanded="true" aria-controls="collapseMasuk">
                                Absen Masuk (<?= $dt['jam_masuk'] ?>)
                            </button>
                        </h2>

                        <div id="collapseMasuk" class="accordion-collapse collapse show" aria-labelledby="headingMasuk" data-bs-parent="#accordionExample1">
                            <div class="accordion-body">
                                <div id="lokasi_masuk"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <!-- Accordion Example -->
                <div class="accordion" id="accordionExample2">
                    <?php if ($dt['jam_pulang']) { ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPulang">
                                <button class="accordion-button fw-bold text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePulang" aria-expanded="true" aria-controls="collapsePulang">
                                    Absen Pulang (<?= $dt['jam_pulang'] ?>)
                                </button>
                            </h2>
                            <div id="collapsePulang" class="accordion-collapse collapse show" aria-labelledby="headingPulang" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <div id="lokasi_pulang"></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../layout/footer.php';
?>

<script>
    //RADIUS KANTOR
    var lat_kantor = <?= $set['latitude'] ?>;
    var lng_kantor = <?= $set['longitude'] ?>;

    var map_masuk = L.map('lokasi_masuk').setView([<?= $dt['lat_masuk'] ?>, <?= $dt['lng_masuk'] ?>], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map_masuk);

    var marker_masuk = L.marker([<?= $dt['lat_masuk'] ?>, <?= $dt['lng_masuk'] ?>]).addTo(map_masuk);

    var circle_masuk = L.circle([lat_kantor, lng_kantor], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: <?= $set['radius'] ?>
    }).addTo(map_masuk);

    var map_pulang = L.map('lokasi_pulang').setView([<?= $dt['lat_pulang'] ?>, <?= $dt['lng_pulang'] ?>], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map_pulang);

    var marker_pulang = L.marker([<?= $dt['lat_pulang'] ?>, <?= $dt['lng_pulang'] ?>]).addTo(map_pulang);

    var circle_pulang = L.circle([lat_kantor, lng_kantor], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: <?= $set['radius'] ?>
    }).addTo(map_pulang);
</script>