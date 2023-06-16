<?php
require '../../../app/config.php';
if (!isset($_SESSION['login'])) {
    echo "<script> alert('Silahkan login terlebih dahulu'); </script>";
    echo "<meta http-equiv='refresh' content='0; url=" . base_url('index') . "'>";
}

$user = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]'")->fetch_array();
$absen = $user['id_personil'];
$tanggal = date('Y-m-d');
$jamSekarang = date('H:i');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/assets/images/logo.png">

    <!-- Libs CSS -->

    <link href="<?= base_url() ?>/assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/libs/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/libs/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/assets/libs/prismjs/themes/prism-okaidia.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/libs/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="<?= base_url() ?>/assets/libs/swal2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/theme.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <title>Absensi Personil SPN POLDA KALSEL</title>

    <style>
        #map {
            height: 200px;
            width: 100%;
        }
    </style>
</head>

<body class="bg-light">
    <!-- container -->
    <div class="container-fluid">
        <div class="card card-body border border-dark-danger mt-2">
            <div class="row">
                <form id="form-absen-masuk" action="" method="POST" enctype="multipart/form-data">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <input type="hidden" name="foto_masuk" class="img-masuk">
                        <video id="video" width="100%" height="100%" autoplay muted playsinline></video>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                        <div id="map"></div>
                    </div>
                    <div class="d-grid mt-2">
                        <button type="submit" name="masuk" class="btn bg-dark-primary text-white"><i class="fas fa-id-card-alt me-1"></i> Absensi Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/feather-icons/dist/feather.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/prismjs/prism.js"></script>
    <script src="<?= base_url() ?>/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>

    <script src="<?= base_url() ?>/assets/libs/swal2/dist/sweetalert2.min.js"></script>
    <!-- Theme JS -->
    <script src="<?= base_url() ?>/assets/js/theme.min.js"></script>

    <script>
        const video = document.getElementById('video');
        const constraints = {
            audio: false,
            video: true
        }

        if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
            navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                video.srcObject = stream;
                video.play();
            }).catch(function(err) {
                console.error("Device access checks failed: ", err, constraints);
            });
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(lokasi_sukses, lokasi_gagal);
        }

        var lat = document.getElementById("lat");
        var lng = document.getElementById("lng");

        function lokasi_sukses(lokasi) {
            lat.value = lokasi.coords.latitude;
            lng.value = lokasi.coords.longitude;

            var map = L.map('map').setView([lokasi.coords.latitude, lokasi.coords.longitude], 17);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);


            var marker = L.marker([lokasi.coords.latitude, lokasi.coords.longitude]).addTo(map);


            //RADIUS KANTOR
            var lat_kantor = <?= $set['latitude'] ?>;
            var lng_kantor = <?= $set['longitude'] ?>;
            var circle = L.circle([lat_kantor, lng_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: <?= $set['radius'] ?>
            }).addTo(map);
        }

        function lokasi_gagal() {
            alert("Browser doesn't support geolocation!");
        }

        $("#form-absen-masuk").submit(function() {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth * 1;
            canvas.height = video.videoHeight * 1;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');

            $(".img-masuk").val(dataURL);
        });
    </script>
</body>

</html>

<?php
if (isset($_POST['masuk'])) {

    $img = $_POST['foto_masuk'];
    $folderPath = "../../../storage/masuk/";

    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);
    $foto_masuk = uniqid() . '.png';

    $file = $folderPath . $foto_masuk;
    file_put_contents($file, $image_base64);

    $tambah = $con->query("INSERT INTO absensi VALUES (
        default, 
        '$absen',
        default,
        default,
        '$tanggal',
        '$jamSekarang',
        '$_POST[lat]',
        '$_POST[lng]',
        '$foto_masuk',
        default,
        default,
        default,
        default,
        'Hadir'
    )");

    if ($tambah) {
        echo "
            <script>
                Swal.fire('Absen Masuk Berhasil !', '', 'success').then(function(){
                    window.close();
                    window.opener.location.reload(false);
                });
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire('Absen Masuk Gagal !', '', 'error').then(function(){
                    <meta http-equiv='refresh' content='0; url=absen-masuk'>
                });
            </script>
        ";
    }
}
?>