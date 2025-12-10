<div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Pilih Purchase Order</h5>
            <button class="btn-close" data-bs-dismiss="modal">x</button>
        </div>

        <div class="modal-body">
            <table class="table table-bordered" id="tableSearchPO">
                <thead>
                    <tr>
                        <th>No. PO</th>
                        <th>Tanggal</th>
                        <th>Pemohon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($po as $p): ?>
                    <tr>
                        <td><?= $p['no_po'] ?></td>
                        <td><?= date('d-m-Y', strtotime($p['tgl_po'])) ?></td>
                        <td><?= $p['nama_user'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="pilihPO(<?= $p['id_po'] ?>)">Pilih</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
    $("#tableSearchPO").DataTable();
</script>
