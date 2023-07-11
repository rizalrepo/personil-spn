<?php
require '../../../app/config.php';
$page = 'mutasi';
include_once '../../layout/navhead.php';

$id = $_GET['id'];
$query = $con->query("SELECT * FROM mutasi a LEFT JOIN personil b ON a.id_personil = b.id_personil LEFT JOIN pangkat c ON b.id_pangkat = c.id_pangkat LEFT JOIN jabatan d ON a.id_jabatan = d.id_jabatan WHERE id_mutasi ='$id'");
$row = $query->fetch_array();

$d = $con->query("SELECT * FROM jabatan WHERE id_jabatan = '$row[id_jabatan_lama]' ")->fetch_array();

$filelama = $row['file_sk'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 my-3">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h4 class="mb-0"><i class="fas fa-arrow-right-arrow-left me-2"></i>Edit Data Mutasi Jabatan</h4>
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
                        <label class="col-sm-2 col-form-label">Nama Personil</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" hidden name="id_personil" value="<?= $row['id_personil'] ?>" id="id_personil" required>
                                <input type="text" class="form-control bg-light" id="nm_personil" value="<?= $row['nm_personil'] ?>" required readonly>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modal_personil" class="btn text-white btn-info btn-flat"><i class="fa fa-search"></i></button>
                                <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">NRP / NIP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bg-light" id="nrp_nip" value="<?= $row['nrp_nip'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Pangkat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bg-light" id="nm_pangkat" value="<?= $row['nm_pangkat'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Jabatan Sekarang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bg-light" id="nm_jabatan" value="<?= $d['nm_jabatan'] ?>" readonly>
                            <input type="hidden" class="form-control" name="id_jabatan_lama" id="id_jabatan_lama" value="<?= $row['id_jabatan_lama'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mutasi ke Jabatan</label>
                        <div class="col-sm-10">
                            <select name="id_jabatan" class="form-select select2" style="width: 100%;" required>
                                <?php $data = $con->query("SELECT * FROM jabatan ORDER BY id_jabatan ASC"); ?>
                                <?php foreach ($data as $d) :
                                    if ($d['id_jabatan'] == $row['id_jabatan']) { ?>
                                        <option value="<?= $d['id_jabatan']; ?>" selected="<?= $d['id_jabatan']; ?>"><?= $d['nm_jabatan'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $d['id_jabatan'] ?>"><?= $d['nm_jabatan'] ?></option>
                                <?php }
                                endforeach ?>
                            </select>
                            <div class="invalid-feedback">Kolom harus di pilih !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tanggal" value="<?= $row['tanggal'] ?>" required>
                            <div class="invalid-feedback">Kolom tidak boleh kosong !</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">File SK</label>
                        <div class="col-sm-10">
                            <input type="file" accept=".pdf,.PDF" class="form-control" name="file_sk">
                            <label style='color: red; font-style: italic; font-size: 12px;'>* Biarkan Kosong jika File tidak di Ubah !</label>
                        </div>
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

<div class="modal fade" id="modal_personil" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-id-badge me-1"></i>Pilih Personil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped dataTable">
                        <thead class="bg-danger">
                            <tr align="center">
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NRP / NIP</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = $con->query("SELECT * FROM personil a JOIN pangkat b ON a.id_pangkat = b.id_pangkat JOIN jabatan c ON a.id_jabatan = c.id_jabatan ORDER BY a.id_personil ASC");
                            while ($row = $data->fetch_array()) {
                            ?>
                                <tr>
                                    <td align="center" width="5%"><?= $no++ ?></td>
                                    <td><?= $row['nm_personil'] ?></td>
                                    <td align="center"><?= $row['nrp_nip'] ?></td>
                                    <td align="center"><?= $row['nm_pangkat'] ?></td>
                                    <td align="center"><?= $row['nm_jabatan'] ?></td>
                                    <td align="center" width="14%">
                                        <button class="btn btn-xs btn-primary" id="select" data-nm_personil="<?= $row['nm_personil'] ?>" data-id_personil="<?= $row['id_personil'] ?>" data-nrp_nip="<?= $row['nrp_nip']  ?>" data-nm_pangkat="<?= $row['nm_pangkat']  ?>" data-nm_jabatan="<?= $row['nm_jabatan'] ?>" data-id_jabatan_lama="<?= $row['id_jabatan'] ?>">
                                            <i class="fas fa-check-circle me-1"></i>Pilih
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../layout/footer.php';
?>
<script>
    $(document).ready(function() {
        $(document).on('click', '#select', function() {
            var nm_personil = $(this).data('nm_personil');
            var id_personil = $(this).data('id_personil');
            var nrp_nip = $(this).data('nrp_nip');
            var nm_pangkat = $(this).data('nm_pangkat');
            var nm_jabatan = $(this).data('nm_jabatan');
            var id_jabatan_lama = $(this).data('id_jabatan_lama');
            $('#nm_personil').val(nm_personil);
            $('#id_personil').val(id_personil);
            $('#nrp_nip').val(nrp_nip);
            $('#nm_pangkat').val(nm_pangkat);
            $('#nm_jabatan').val(nm_jabatan);
            $('#id_jabatan_lama').val(id_jabatan_lama);
            $('#modal_personil').modal('hide');
        });
    })
</script>
<?php
if (isset($_POST['submit'])) {
    $id_personil = $_POST['id_personil'];
    $id_jabatan = $_POST['id_jabatan'];
    $id_jabatan_lama = $_POST['id_jabatan_lama'];
    $tanggal = $_POST['tanggal'];

    $f_file_sk = "";

    if (!empty($_FILES['file_sk']['name'])) {

        // $filelama = $row['file_sk'];

        // UPLOAD FILE 
        $file      = $_FILES['file_sk']['name'];
        $x_file    = explode('.', $file);
        $ext_file  = end($x_file);
        $file_sk = rand(1, 99999) . '.' . $ext_file;
        $size_file = $_FILES['file_sk']['size'];
        $tmp_file  = $_FILES['file_sk']['tmp_name'];
        $dir_file  = '../../../storage/mutasi/';
        $allow_ext        = array('pdf', 'PDF');
        $allow_size       = 2097152;
        // var_dump($file_sk); die();

        if (in_array($ext_file, $allow_ext) === true) {
            if ($size_file <= $allow_size) {
                move_uploaded_file($tmp_file, $dir_file . $file_sk);
                if (file_exists($dir_file . $filelama)) {
                    unlink($dir_file . $filelama);
                }

                $f_file_sk .= "Upload Success";
            } else {
                echo "
                <script type='text/javascript'>
                    setTimeout(function () {    
                        swal({
                            title: '',
                            text:  'Ukuran File Terlalu Besar, Maksimal 2 Mb',
                            type: 'warning',
                            timer: 3000,
                            showConfirmButton: true
                        });     
                    },10);   
                    window.setTimeout(function(){ 
                        window.location.replace('edit?id=$id');
                    } ,2000); 
                </script>";
            }
        } else {
            echo "
            <script type='text/javascript'>
                setTimeout(function () {    
                    swal({
                        title: 'Format File Tidak Didukung',
                        text:  'File Harus PDF',
                        type: 'warning',
                        timer: 3000,
                        showConfirmButton: true
                    });     
                },10);  
                window.setTimeout(function(){ 
                    window.location.replace('edit?id=$id');
                } ,2000);  
            </script>";
        }
    } else {
        $file_sk = $row['file_sk'];
        $f_file_sk .= "Upload Success!";
    }

    if (!empty($f_file_sk)) {

        $update = $con->query("UPDATE mutasi SET 
            id_personil = '$id_personil',
            id_jabatan = '$id_jabatan',
            id_jabatan_lama = '$id_jabatan_lama',
            tanggal = '$tanggal',
            file_sk = '$file_sk'
            WHERE id_mutasi = '$id'
        ");

        if ($update) {
            $_SESSION['pesan'] = "Data Berhasil di Update";
            echo "<meta http-equiv='refresh' content='0; url=index'>";
        } else {
            echo "Data anda gagal diubah. Ulangi sekali lagi";
            echo "<meta http-equiv='refresh' content='0; url=edit?id=$id'>";
        }
    }
}
?>