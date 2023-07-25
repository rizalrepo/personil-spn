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
                                <select name="pangkat" class="form-control select2" style="width: 100%;">
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
                                <select name="jabatan" class="form-control select2" style="width: 100%;">
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
                                <button type="submit" class="btn btn-danger"><i class="fa fa-print"> </i> Cetak</button>
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

<script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>

<script>
    $(function() {
        $('.select2').select2({
            dropdownParent: $('#lapPersonil')
        });
    });
</script>