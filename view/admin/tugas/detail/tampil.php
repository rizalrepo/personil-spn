<table id="tbl" class="table table-striped table-bordered">
    <thead class="bg-dark-info">
        <tr align="center">
            <th>No</th>
            <th>Nama personil</th>
            <th>NRP/NIP</th>
            <th>Pangkat</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

        <?php
        include "../../../../app/config.php";
        $no1 = 1;
        $id1 = $_POST['id'];

        $data1 = mysqli_query($con, "SELECT * FROM tugas_detail td JOIN personil p ON p.id_personil = td.id_personil JOIN pangkat c ON p.id_pangkat = c.id_pangkat JOIN jabatan d ON p.id_jabatan = d.id_jabatan WHERE id_tugas = '$id1' ");
        while ($tampil1 = mysqli_fetch_array($data1)) {
        ?>
            <tr>
                <td align="center"><?= $no1++; ?></td>
                <td><?= $tampil1['nm_personil'] ?></td>
                <td align="center"><?= $tampil1['nrp_nip'] ?></td>
                <td align="center"><?= $tampil1['nm_pangkat'] ?></td>
                <td align="center"><?= $tampil1['nm_jabatan'] ?></td>
                <td align="center">
                    <a class="btn btn-sm btn-danger" href="#" id="hapus" data-id="<?= $tampil1[0]; ?>"> <i class="fas fa-trash me-1"></i>Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>

</table>


<hr>