<?php
require '../../../app/config.php';
$page = 'absensi';
include_once '../../layout/navhead.php';

$log = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")->fetch_array();
$absen = $log['id_personil'];
$tanggal = date('Y-m-d');
$jamSekarang = date('H:i');
$cek = $con->query("SELECT * FROM absensi WHERE id_personil = '$absen' AND tanggal = '$tanggal'")->fetch_array();
$cek_pulang = $con->query("SELECT * FROM absensi WHERE id_personil = '$absen' AND tanggal = '$tanggal' AND jam_masuk != 0 AND jam_pulang = NULL ")->fetch_array();
?>

<!-- Container fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-3">
            <div class="alert bg-dark-danger text-white" role="alert">
                <h4 class="alert-heading"><i class="fas fa-map-marked-alt me-1 mb-2"></i> Absensi Personil (<?= tgl_indo(date('Y-m-d')) ?>)</h4>
                <?php if (!isset($cek)) { ?>
                    <form action="" method="POST">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                        <button id="absen-masuk" hidden type="submit" name="masuk"></button>
                        <div class="alert alert-primary d-grid mb-0" role="alert">
                            <span class="btn bg-dark-success text-white" onclick="absenMasuk(event)"><i class="fas fa-id-card-alt me-1"></i> Absen Masuk</span>
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="alert alert-success fw-bold" role="alert">
                        <i class="fas fa-info-circle me-1"></i>
                        <?php if ($cek['sts'] == 'Hadir') { ?>
                            <?php if ($cek['jam_pulang'] != NULL) { ?>
                                Anda Sudah Melakukan Absensi Pulang !
                            <?php } else { ?>
                                Anda Sudah Melakukan Absensi Masuk !
                            <?php } ?>
                        <?php } else if ($cek['sts'] == 'Cuti') { ?>
                            Anda Sedang Cuti !
                        <?php } else if ($cek['sts'] == 'Izin') { ?>
                            Anda Sedang Izin !
                        <?php } else { ?>
                            Anda Sedang Sakit !
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($cek['sts'] == 'Hadir' && $cek['jam_pulang'] == NULL) { ?>
                    <form action="" method="POST">
                        <input type="hidden" id="lat2" name="lat2">
                        <input type="hidden" id="lng2" name="lng2">
                        <button id="absen-pulang" hidden type="submit" name="pulang"></button>
                        <div class="alert alert-primary d-grid mb-0" role="alert">
                            <span class="btn bg-dark-success text-white" onclick="absenPulang(event)"><i class="fas fa-id-card-alt me-1"></i> Absen Pulang</span>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-body border border-dark-danger">

                <?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
                    <div id="notif" class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <b><?= $_SESSION['pesan'] ?></b>
                        </div>
                    </div>
                <?php $_SESSION['pesan'] = '';
                } ?>


                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped dataTable">
                        <thead class="bg-dark-primary">
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM absensi WHERE id_personil = '$absen' ORDER BY tanggal DESC");
                            while ($row = $data->fetch_array()) {
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td align="center"><?= hari($row['tanggal']) ?></td>
                                    <td align="center"><?= tgl($row['tanggal']) ?></td>
                                    <td align="center">
                                        <?php if ($row['sts'] == 'Hadir') { ?>
                                            <?= $row['jam_masuk'] ?>
                                            -
                                            <?php if (!$row['jam_pulang']) { ?>
                                                Belum Pulang
                                            <?php } else { ?>
                                                <?= $row['jam_pulang'] ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($row['sts'] == 'Hadir') { ?>
                                            <?= $row['sts'] ?>
                                            <a href="../../detail/detail-absensi?id=<?= $row[0] ?>" class="btn bg-info text-white btn-xs" title="Lokasi"><i class="fas fa-map-marked-alt"></i> Detail</a>
                                        <?php } else { ?>
                                            <?= $row['sts'] ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row  -->
</div>

<?php
include_once '../../layout/footer.php';
?>

<script>
    function latlondist(lat1, lon1, lat2, lon2) {
        var dlat = deg2rad(lat2 - lat1); // Convierte de grados a radianes.
        var dlon = deg2rad(lon2 - lon1); // Convierte de grados a radianes.
        var a = Math.sin(dlat / 2) * Math.sin(dlat / 2) + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.sin(dlon / 2) * Math.sin(dlon / 2);
        var b = 2 * Math.asin(Math.sqrt(a));
        var c = (6371 * b * 1000).toFixed(2); // Distancia en km con dos decimales de precisión.
        return c;
    }

    function deg2rad(deg) {
        return deg * 0.017453292519943295; // deg * Math.PI / 180
    }

    if ("geolocation" in navigator) { //check geolocation available 
        //try to get user current location using getCurrentPosition() method
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log(position.coords.latitude, position.coords.longitude);

            var lat = document.getElementById("lat");
            var lng = document.getElementById("lng");

            var lat2 = document.getElementById("lat2");
            var lng2 = document.getElementById("lng2");

            if (lat && lng) {
                lat.value = position.coords.latitude;
                lng.value = position.coords.longitude;
            } else if (lat2 && lng2) {
                lat2.value = position.coords.latitude;
                lng2.value = position.coords.longitude;
            }

        });
    } else {
        console.log("Browser doesn't support geolocation!");
    }

    function absenMasuk(e) {
        if ("geolocation" in navigator) { //check geolocation available 
            //try to get user current location using getCurrentPosition() method
            navigator.geolocation.getCurrentPosition(function(position) {

                console.log(position.coords.latitude, position.coords.longitude);

                if (latlondist(position.coords.latitude, position.coords.longitude, <?= $set['latitude'] ?>, <?= $set['longitude'] ?>) <= <?= $set['radius'] ?>) {

                    e.preventDefault();
                    swal.fire({
                            title: 'Konfirmasi Absensi !',
                            html: 'Absensi untuk Masuk, Lanjutkan ?',
                            icon: "warning",
                            showCancelButton: true,
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $('#absen-masuk').click();
                            }
                        });
                    return false;
                } else {
                    Swal.fire({
                        title: 'Akses Absensi Gagal !',
                        text: 'Anda sedang berada diluar Radius Lokasi',
                        icon: 'error'
                    });
                }
            });
        } else {
            console.log("Browser doesn't support geolocation!");
        }
    }

    function absenPulang(e) {
        if ("geolocation" in navigator) { //check geolocation available 
            //try to get user current location using getCurrentPosition() method
            navigator.geolocation.getCurrentPosition(function(position) {

                console.log(position.coords.latitude, position.coords.longitude);

                if (latlondist(position.coords.latitude, position.coords.longitude, <?= $set['latitude'] ?>, <?= $set['longitude'] ?>) <= <?= $set['radius'] ?>) {

                    e.preventDefault();
                    swal.fire({
                            title: 'Konfirmasi Absensi !',
                            html: 'Absensi untuk Pulang, Lanjutkan ?',
                            icon: "warning",
                            showCancelButton: true,
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $('#absen-pulang').click();
                            }
                        });
                    return false;
                } else {
                    Swal.fire({
                        title: 'Akses Absensi Gagal !',
                        text: 'Anda sedang berada diluar Radius Lokasi',
                        icon: 'error'
                    });
                }
            });
        } else {
            console.log("Browser doesn't support geolocation!");
        }
    }
</script>

<?php
if (isset($_POST['masuk'])) {

    $tambah = $con->query("INSERT INTO absensi VALUES (
        default, 
        '$absen',
        default,
        default,
        '$tanggal',
        '$jamSekarang',
        '$_POST[lat]',
        '$_POST[lng]',
        default,
        default,
        default,
        'Hadir'
    )");

    if ($tambah) {
        echo "
        <script>
            Swal.fire('Absen Masuk Berhasil !', '', 'success')
            window.location.replace('index');
        </script>";
    } else {
        echo "
        <script>
            Swal.fire('Absen Masuk Gagal !', '', 'error')
            window.location.replace('index');
        </script>";
    }
}

if (isset($_POST['pulang'])) {

    $id = $cek['id_absensi'];

    $update = $con->query("UPDATE absensi SET  
        jam_pulang = '$jamSekarang',
        lat_pulang = '$_POST[lat2]',
        lng_pulang = '$_POST[lng2]'
        WHERE id_absensi = '$id'
    ");

    if ($update) {
        echo "
        <script>
            Swal.fire('Absen Pulang Berhasil !', '', 'success')
            window.location.replace('index');
        </script>";
    } else {
        echo "
        <script>
            Swal.fire('Absen Masuk Gagal !', '', 'error')
            window.location.replace('index');
        </script>";
    }
}
?>