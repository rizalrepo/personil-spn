<?php require 'app/config.php'; ?>

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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.min.css">
    <title>Login Sistem</title>
</head>

<body class="bg-light">
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
            <div class="col-12 col-md-4 col-lg-4 col-xxl-4">
                <!-- Card -->
                <div class="card smooth-shadow-md border border-bg-danger">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4 text-center">
                            <img src="<?= base_url() ?>/assets/images/logo.png" width="150px" class="mb-2" alt=""><br>
                            <h4 class="mb-2 text-black">Sekolah Polisi Negara POLDA <br> Kalimantan Selatan</h4>
                        </div>
                        <hr class="my-1">
                        <!-- Form -->
                        <form method="POST" action="" class="needs-validation" novalidate>
                            <!-- Username -->
                            <div class="mb-3 mt-4">
                                <label for="username" class="form-label mb-1">Username</label>
                                <input type="text" id="username" class="form-control text-black" name="username" required>
                                <div class="invalid-feedback">Input Username !</div>
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="pw" class="form-label mb-1">Password</label>
                                <div class="input-group has-validation">
                                    <input type="password" name="password" id="pw" class="form-control text-black" required>
                                    <div class="input-group-text" id="lihat-pw"><span class="fas fa-eye-slash" title="Lihat Password" onclick="change();"></span></div>
                                    <div class="invalid-feedback">Input Password !</div>
                                </div>
                            </div>
                            <div>
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" name="log" class="btn bg-dark-danger text-white">Login <i class="bi bi-box-arrow-in-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
    <!-- Custom JS -->
    <script src="<?= base_url() ?>/assets/js/custom.min.js"></script>
</body>

</html>

<?php
if (isset($_POST['log'])) {
    $user = $con->real_escape_string($_POST['username']);
    $pass = $con->real_escape_string($_POST['password']);

    $pass = md5($pass);
    $query = $con->query("SELECT * FROM user WHERE username = '$user' AND password='$pass'");
    $data = $query->fetch_array();
    $username = $data['username'];
    $password = $data['password'];
    $id = $data['id_user'];
    $level = $data['level'];
    $usr = $data['nm_user'];

    if ($user == $username && $pass == $password) {

        $_SESSION["login"] = true;
        $_SESSION['id_user'] = $id;
        $_SESSION['level'] = $level;
        $_SESSION['nm_user'] = $usr;

        if ($level == 1) {
            $url = 'view/admin/';
        } else if ($level == 2) {
            $url = 'view/pimpinan/';
        } else if ($level == 3) {
            $url = 'view/personil/';
        }

        echo "
        <script type='text/javascript'>
            setTimeout(function () {    
                Swal.fire({
                    title: 'Login Berhasil',
                    text:  'Anda Login Sebagai $usr',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });     
            },10);  
            window.setTimeout(function(){ 
                window.location.replace('$url');
            } ,2000);   
        </script>";
    } else {
        echo "
        <script type='text/javascript'>
            setTimeout(function () {    
                Swal.fire({
                    title: 'Login Gagal',
                    text:  'Username atau Password Tidak Ditemukan',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });     
            },10);  
            window.setTimeout(function(){ 
                window.location.replace('index');
            } ,2000);   
        </script>";
    }
}
?>