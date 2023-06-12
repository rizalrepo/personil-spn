<?php

if (!isset($_SESSION['login'])) {
    echo "<script> alert('Silahkan login terlebih dahulu'); </script>";
    echo "<meta http-equiv='refresh' content='0; url=" . base_url('index') . "'>";
}

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
    <link href="<?= base_url() ?>/assets/libs/datatable/datatables.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/theme.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.min.css">

    <title>Administrasi Personil SPN POLDA KALSEL</title>
</head>

<body class="bg-light">
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        <nav class="navbar-vertical navbar">
            <div class="nav-scroller">
                <!-- Brand logo -->
                <div class="text-center">
                    <a class="navbar-brand mb-0" href="#">
                        <img src="<?= base_url() ?>/assets/images/logo.png" class="me-1">
                        <small class="text-white fw-light">SPN POLDA KALSEL</small>
                    </a>
                </div>
                <!-- Navbar nav -->
                <ul class="navbar-nav flex-column" id="sideNavbar">
                    <?php if ($_SESSION['level'] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'dashboard') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/">
                                <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                            </a>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if (
                                                                $page != 'user' || $page != 'pangkat' || $page != 'jabatan'
                                                            ) {
                                                                echo 'collapsed';
                                                            } ?>" href="#!" data-bs-toggle="collapse" data-bs-target="#navPages" aria-expanded="false" aria-controls="navPages">
                                <i data-feather="layers" class="nav-icon icon-xs me-2">
                                </i> Data Master
                            </a>
                            <div id="navPages" class="collapse <?php if (
                                                                    $page == 'user' || $page == 'pangkat' || $page == 'jabatan'
                                                                ) {
                                                                    echo 'show';
                                                                } ?>" data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'user'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/user/">
                                            <small>
                                                <i class="fas fa-user me-1"></i>
                                                Data Pengguna
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'pangkat'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/pangkat/">
                                            <small>
                                                <i class="fas fa-award me-1"></i>
                                                Data Pangkat
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'jabatan'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/jabatan/">
                                            <small>
                                                <i class="fas fa-sitemap me-1"></i>
                                                Data Jabatan
                                            </small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'personil') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/personil">
                                <i class="nav-icon fas fa-id-badge me-2"></i> Data Personil
                            </a>
                        </li>
                    <?php } else if ($_SESSION['level'] == 2) { ?>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <!-- Page content -->
        <div id="page-content">
            <div class="header classList">
                <!-- navbar -->
                <nav class="navbar-classic navbar navbar-expand-lg">
                    <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
                    <!--Navbar nav -->
                    <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
                        <!-- List -->
                        <li class="dropdown ms-2">
                            <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted" href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-xs" data-feather="log-out"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                <div class="px-4 pb-0 pt-2">
                                    <div class="lh-1">
                                        <h5 class="mb-1"><?= $_SESSION['nm_user'] ?></h5>
                                    </div>
                                    <div class="dropdown-divider mt-3 mb-2"></div>
                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('edit-pw') ?>">
                                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="key"></i>Ubah Password
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item alert-logout" href="<?= base_url('logout') ?>">
                                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Log Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>