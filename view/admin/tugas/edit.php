<?php
require '../../../app/config.php';
$page = 'tugas';
include_once '../../layout/navhead.php';

$id = $_GET['id'];
$query = $con->query("SELECT * FROM tugas WHERE id_tugas ='$id'");
$row = $query->fetch_array();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="bi bi-journal-bookmark-fill me-2"></i>Edit Data Perintah Tugas</h4>
                </div>
                <div>
                    <a href="index" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-body border border-dark-danger">
                <form class="form-horizontal needs-validation" novalidate method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Nomor Surat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bg-light" value="<?= $row['no_surat'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Surat</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_surat" value="<?= $row['tgl_surat'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Agenda</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="agenda" value="<?= $row['agenda'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_mulai" value="<?= $row['tgl_mulai'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgl_selesai" value="<?= $row['tgl_selesai'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tempat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tempat" value="<?= $row['tempat'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <hr>
                    <span data-bs-toggle="modal" data-bs-target="#modal-tambah" class="btn btn-sm bg-dark-success text-white mb-2"><i class="fas fa-plus-circle me-1"></i>Tambah Personil</span>
                    <input type="hidden" id="dataid" value="<?= $id; ?>">
                    <div id="data-personil">

                    </div>
                    <div class="form-group row mt-4 text-end">
                        <div class="col-sm-12">
                            <button type="reset" class="btn btn-sm btn-danger float-right mr-2"><i class="fa fa-times-circle"></i> Batal</button>
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- row  -->
</div>

<div class="modal fade" id="modal-tambah" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="custom-width-modalLabel"><i class="fas fa-id-badge me-2"></i>Tambah Data Personil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal needs-validation" novalidate id="form-tambah" method="POST" enctype="multipart/form-data" action="detail/simpan.php">
                    <div class="card-body">
                        <input type="hidden" name="id_tugas" value="<?= $id ?>">
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Nama Personil</label>
                            <div class="col-sm-10">
                                <select name="id_personil" id="id_personil" class="form-select" style="width: 100%;" required>
                                    <option value="">-- Pilih --</option>
                                    <?php $data = $con->query("SELECT * FROM personil ORDER BY nm_personil ASC"); ?>
                                    <?php foreach ($data as $row) : ?>
                                        <option value="<?= $row['id_personil'] ?>"><?= $row['nm_personil'] ?> | NRP/NIP. <?= $row['nrp_nip'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">Kolom harus di pilih !</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="reset" class="btn btn-sm btn-danger float-right mr-2"><i class="fas fa-times-circle me-1"></i>Batal</button>
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<?php
include_once '../../layout/footer.php';
?>
<script>
    muncul();
    var data = "detail/tampil.php";

    function muncul() {
        $.post('detail/tampil.php', {
                id: $("#dataid").val()
            },
            function(data) {
                $("#data-personil").html(data);
            }
        );
    }

    $("#form-tambah").submit(function(e) {
        e.preventDefault();

        var dataform = $("#form-tambah").serialize();
        $.ajax({
            url: "detail/simpan.php",
            type: "POST",
            data: dataform,
            success: function(result) {
                var hasil = JSON.parse(result);
                if (hasil.hasil == "sukses") {
                    $('#modal-tambah').modal('hide');
                    $('#id_personil').val(null).trigger('change');
                    muncul();
                } else if (hasil.hasil == 'duplikat') {
                    Swal.fire({
                        title: 'Gagal !',
                        text: 'Data Personil sudah Ada !',
                        icon: 'error'
                    });
                }
            }
        });
    });

    $(document).on('click', '#hapus', function(e) {
        e.preventDefault();
        $.post('detail/hapus.php', {
                id: $(this).attr('data-id')
            },
            function(html) {
                muncul();
            }
        );
    });

    $(document).ready(function() {
        $('#id_personil').select2({
            dropdownParent: $('#modal-tambah')
        });
    });
</script>
<?php
if (isset($_POST['submit'])) {
    $tgl_surat = $_POST['tgl_surat'];
    $agenda = $_POST['agenda'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $tempat = $_POST['tempat'];

    $update = $con->query("UPDATE tugas SET 
        tgl_surat = '$tgl_surat',
        agenda = '$agenda',
        tgl_mulai = '$tgl_mulai',
        tgl_selesai = '$tgl_selesai',
        tempat = '$tempat'
        WHERE id_tugas = '$id'
    ");

    if ($update) {
        $_SESSION['pesan'] = "Data Berhasil di Update";
        echo "<meta http-equiv='refresh' content='0; url=index'>";
    } else {
        echo "Data anda gagal diubah. Ulangi sekali lagi";
        echo "<meta http-equiv='refresh' content='0; url=edit?id=$id'>";
    }
}


?>