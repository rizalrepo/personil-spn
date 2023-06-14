<?php
require '../../../app/config.php';
$page = 'absensi';
include_once '../../layout/navhead.php';

$log = $con->query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")->fetch_array();
$user = $log['id_personil'];

// $a1 = $con->query("SELECT COUNT(*) AS total FROM izin WHERE id_personil = '$user' AND verif = 1")->fetch_array();
// $a2 = $con->query("SELECT COUNT(*) AS total FROM izin WHERE id_personil = '$user' AND verif != 1")->fetch_array();
// $b1 = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE id_personil = '$user' AND verif = 1 ")->fetch_array();
// $b2 = $con->query("SELECT COUNT(*) AS total FROM cuti WHERE id_personil = '$user' AND verif != 1 ")->fetch_array();
?>

<!-- Container fluid -->
<div class="bg-dark-danger pt-3 pb-22"></div>
<div class="container-fluid mt-n22">
    <div class="row">
        <div class="col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0 text-white"><i class="fas fa-map-marked-alt me-2"></i>Absensi Personil</h4>
                </div>
            </div>
            <div class="alert alert-success mt-3 d-grid" role="alert">
                <span class="btn bg-dark-success text-white" onclick="absen(event)"><i class="fas fa-id-card-alt me-1"></i> Absen Masuk</span>
            </div>

            <div class="alert bg-dark-success text-white" role="alert">
                <h4 class="alert-heading">Well done!</h4>
                <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
            </div>
        </div>
    </div>
    <!-- row  -->
</div>

<?php
include_once '../../layout/footer.php';
?>

<script>
    function popupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var systemZoom = width / window.screen.availWidth;
        var left = (width - w) / 2 / systemZoom + dualScreenLeft
        var top = (height - h) / 2 / systemZoom + dualScreenTop
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) newWindow.focus();
    }

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

    function absen(e) {
        if ("geolocation" in navigator) { //check geolocation available 
            //try to get user current location using getCurrentPosition() method
            navigator.geolocation.getCurrentPosition(function(position) {
                console.log(latlondist(position.coords.latitude, position.coords.longitude, -3.3418973, 114.6069257));

                if (latlondist(position.coords.latitude, position.coords.longitude, -3.3418973, 114.6069257) <= 50) {

                    popupCenter('absen', 'SPN POLDA KALSEL - Absensi Personil', '450', '600');
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