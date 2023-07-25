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

    <link href="<?= base_url() ?>/assets/libs/select2/select2.min.css" rel="stylesheet">

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
                                                                $page != 'user' || $page != 'pangkat' || $page != 'jabatan' || $page != 'jenis_kegiatan' || $page != 'set'
                                                            ) {
                                                                echo 'collapsed';
                                                            } ?>" href="#!" data-bs-toggle="collapse" data-bs-target="#navMaster" aria-expanded="false" aria-controls="navMaster">
                                <i data-feather="layers" class="nav-icon icon-xs me-2">
                                </i> Data Master
                            </a>
                            <div id="navMaster" class="collapse <?php if (
                                                                    $page == 'user' || $page == 'pangkat' || $page == 'jabatan' || $page == 'set' || $page == 'jenis_kegiatan'
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
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'jenis_kegiatan'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/jenis-kegiatan/">
                                            <small>
                                                <i class="fas fa-pie-chart me-1"></i>
                                                Data Jenis Kegiatan
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'set'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/setting/">
                                            <small>
                                                <i class="fas fa-cogs me-1"></i>
                                                Setting Aplikasi
                                            </small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if (
                                                                $page != 'personil' || $page != 'absensi' || $page != 'izin' || $page != 'cuti' || $page != 'tugas' || $page != 'mutasi'
                                                            ) {
                                                                echo 'collapsed';
                                                            } ?>" href="#!" data-bs-toggle="collapse" data-bs-target="#navPersonil" aria-expanded="false" aria-controls="navPersonil">
                                <i data-feather="users" class="nav-icon icon-xs me-2">
                                </i> Personil
                            </a>
                            <div id="navPersonil" class="collapse <?php if (
                                                                        $page == 'personil' || $page == 'absensi' || $page == 'izin' || $page == 'cuti' || $page == 'tugas' || $page == 'mutasi'
                                                                    ) {
                                                                        echo 'show';
                                                                    } ?>" data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'personil'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/personil/">
                                            <small>
                                                <i class="fas fa-id-badge me-1"></i>
                                                Data Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'absensi'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/absensi/">
                                            <small>
                                                <i class="fas fa-map-marked-alt me-1"></i>
                                                Data Absensi
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'izin'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/izin/">
                                            <small>
                                                <i class="bi bi-calendar-week-fill me-1"></i>
                                                Data Izin
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'cuti'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/cuti/">
                                            <small>
                                                <i class="bi bi-calendar-range-fill me-1"></i>
                                                Data Cuti
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'tugas'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/tugas/">
                                            <small>
                                                <i class="bi bi-journal-bookmark-fill me-1"></i>
                                                Data Perintah Tugas
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (
                                                                $page == 'mutasi'
                                                            ) {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/mutasi/">
                                            <small>
                                                <i class="fas fa-arrow-right-arrow-left me-1"></i>
                                                Data Mutasi Jabatan
                                            </small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'kegiatan') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/admin/kegiatan/">
                                <i class="nav-icon far fa-calendar-check me-2"></i> Data Kegiatan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link has-arrow" href="#!" data-bs-toggle="collapse" data-bs-target="#navLaporan" aria-expanded="false" aria-controls="navLaporan">
                                <i data-feather="file-text" class="nav-icon icon-xs me-2">
                                </i>Laporan Cetak
                            </a>
                            <div id="navLaporan" class="collapse" data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapPersonil">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapAbsensi">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Rekapitulasi Absensi
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapAbsensiPersonil">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Absensi Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapIzin">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Izin Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapCuti">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Cuti Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapTugas">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Perintah Tugas
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapMutasi">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Mutasi Jabatan
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapKegiatan">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Kegiatan
                                            </small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php } else if ($_SESSION['level'] == 2) { ?>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'dashboard') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/">
                                <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'personil') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/personil/">
                                <i class="fas fa-id-badge nav-icon icon-xs me-2"></i> Personil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'absensi') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/absensi/">
                                <i class="fas fa-map-marked-alt nav-icon icon-xs me-2"></i> Absensi Personil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'izin') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/izin/">
                                <i class="bi bi-calendar-week-fill nav-icon icon-xs me-2"></i> Izin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'cuti') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/cuti/">
                                <i class="bi bi-calendar-range-fill nav-icon icon-xs me-2"></i> Cuti
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'tugas') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/tugas/">
                                <i class="bi bi-journal-bookmark-fill nav-icon icon-xs me-2"></i> Perintah Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'mutasi') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/mutasi/">
                                <i class="fas fa-arrow-right-arrow-left nav-icon icon-xs me-2"></i> Mutasi Jabatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'kegiatan') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/pimpinan/kegiatan/">
                                <i class="far fa-calendar-check nav-icon icon-xs me-2"></i> Kegiatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow" href="#!" data-bs-toggle="collapse" data-bs-target="#navLaporan" aria-expanded="false" aria-controls="navLaporan">
                                <i data-feather="file-text" class="nav-icon icon-xs me-2">
                                </i>Laporan Cetak
                            </a>
                            <div id="navLaporan" class="collapse" data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapPersonil">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapAbsensi">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Rekapitulasi Absensi
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapAbsensiPersonil">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Absensi Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapIzin">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Izin Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapCuti">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Cuti Personil
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapTugas">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Perintah Tugas
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapMutasi">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Mutasi Jabatan
                                            </small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#lapKegiatan">
                                            <small>
                                                <i class="far fa-circle me-1"></i>
                                                Kegiatan
                                            </small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php } else if ($_SESSION['level'] == 3) { ?>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'dashboard') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/personil/">
                                <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'absensi') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/personil/absensi/">
                                <i class="fas fa-map-marked-alt nav-icon icon-xs me-2"></i> Absensi Personil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'izin') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/personil/izin/">
                                <i class="bi bi-calendar-week-fill nav-icon icon-xs me-2"></i> Izin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'cuti') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/personil/cuti/">
                                <i class="bi bi-calendar-range-fill nav-icon icon-xs me-2"></i> Cuti
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow <?php if ($page == 'tugas') {
                                                                echo 'active';
                                                            } ?>" href="<?= base_url() ?>/view/personil/tugas/">
                                <i class="bi bi-journal-bookmark-fill nav-icon icon-xs me-2"></i> Perintah Tugas
                            </a>
                        </li>
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