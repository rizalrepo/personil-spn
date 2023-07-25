<?php
$izin = [
    '' => '-- Pilih --',
    'Izin' => 'Izin',
    'Sakit' => 'Sakit',
];
?>

<div class="modal fade" id="lapPersonil" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Data Personil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" target="_blank" action="<?= base_url('view/laporan/personil') ?>">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label fw-semibold">Berdasarkan Pangkat</label>
                                <select name="pangkat" class="form-select select-2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    <?php $data = $con->query("SELECT * FROM pangkat ORDER BY id_pangkat ASC"); ?>
                                    <?php foreach ($data as $row) : ?>
                                        <option value="<?= $row['id_pangkat'] ?>"><?= $row['nm_pangkat'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label fw-semibold">Berdasarkan Jabatan</label>
                                <select name="jabatan" class="form-select select-2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    <?php $data = $con->query("SELECT * FROM jabatan ORDER BY id_jabatan ASC"); ?>
                                    <?php foreach ($data as $row) : ?>
                                        <option value="<?= $row['id_jabatan'] ?>"><?= $row['nm_jabatan'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapAbsensi" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Rekapitulasi Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/rekap-absensi') ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control" required name="tahun" value="<?= date('Y') ?>">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapAbsensiPersonil" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Rekapitulasi Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/absensi') ?>">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="col-form-label fw-semibold">Personil</label>
                            <select name="personil" class="form-select select-2" style="width: 100%;" required>
                                <option value="">-- Pilih --</option>
                                <?php $data = $con->query("SELECT * FROM personil ORDER BY id_personil ASC"); ?>
                                <?php foreach ($data as $row) : ?>
                                    <option value="<?= $row['id_personil'] ?>">NRP/NIP. <?= $row['nrp_nip'] . ' | ' . $row['nm_personil'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control" required name="tahun" value="<?= date('Y') ?>">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapIzin" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Izin Personil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/izin') ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select bln-izin">
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control thn-izin" name="tahun">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="col-form-label fw-semibold">Jenis Izin</label>
                            <?= form_dropdown('izin', $izin, '', 'class="form-select"') ?>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapCuti" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Cuti Personil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/cuti') ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select bln-cuti">
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control thn-cuti" name="tahun">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapTugas" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Perintah Tugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/tugas') ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select bln-tugas">
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control thn-tugas" name="tahun">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapMutasi" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Mutasi Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/mutasi') ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select bln-mutasi">
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control thn-mutasi" name="tahun">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="lapKegiatan" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i data-feather="file-text" class="me-2"></i>Laporan Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate method="GET" target="_blank" action="<?= base_url('view/laporan/kegiatan') ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="col-form-label fw-semibold">Bulan</label>
                            <select name="bulan" class="form-select bln-kegiatan">
                                <option value="">-- Pilih --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control thn-kegiatan" name="tahun">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label class="col-form-label fw-semibold">Berdasarkan Jenis Kegiatan</label>
                            <select name="jenis" class="form-select select-2" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php $data = $con->query("SELECT * FROM jenis_kegiatan ORDER BY id_jenis_kegiatan ASC"); ?>
                                <?php foreach ($data as $row) : ?>
                                    <option value="<?= $row['id_jenis_kegiatan'] ?>"><?= $row['nm_jenis_kegiatan'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-print me-1"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>

<script>
    $(function() {
        $('.select-2').select2({
            dropdownParent: $('#lapPersonil')
        });

        $('.select-2').select2({
            dropdownParent: $('#lapAbsensiPersonil')
        });

        $('.select-2').select2({
            dropdownParent: $('#lapKegiatan')
        });

        $(".bln-izin").change(function() {
            if ($(".bln-izin option:selected").val() != '') {
                $('.thn-izin').prop('required', true);
            } else {
                $('.thn-izin').removeAttr('required');
            }
        });
        $(".bln-cuti").change(function() {
            if ($(".bln-cuti option:selected").val() != '') {
                $('.thn-cuti').prop('required', true);
            } else {
                $('.thn-cuti').removeAttr('required');
            }
        });
        $(".bln-tugas").change(function() {
            if ($(".bln-tugas option:selected").val() != '') {
                $('.thn-tugas').prop('required', true);
            } else {
                $('.thn-tugas').removeAttr('required');
            }
        });
        $(".bln-mutasi").change(function() {
            if ($(".bln-mutasi option:selected").val() != '') {
                $('.thn-mutasi').prop('required', true);
            } else {
                $('.thn-mutasi').removeAttr('required');
            }
        });
        $(".bln-kegiatan").change(function() {
            if ($(".bln-kegiatan option:selected").val() != '') {
                $('.thn-kegiatan').prop('required', true);
            } else {
                $('.thn-kegiatan').removeAttr('required');
            }
        });
    });
</script>